<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: ENVÍO EMAIL A LOS CLIENTES CON PAGOS PROGRAMADOS, A 7 DÍAS VISTA
 * TABLA: pagos_programados
 */

 $rootDirectory = $_SERVER['DOCUMENT_ROOT'];
 $substring = "/public_html/gestion";
 $result = str_replace($substring, "", $rootDirectory);
 $path = $result . "/pass/connection.php";
 require_once($path);

// Paso 2: Obtener las filas que cumplen la condición

$fechaActual = date('Y-m-d');
$fechaLimite = date('Y-m-d', strtotime('+7 days'));

$query = "SELECT pp.cliente, pp.importe AS importe, u.user_email AS email, pro.post_title AS producto, pp.fecha, pp.numPago, pp.estado, pp.tipoPago
        FROM pagos_programados AS pp
        JOIN txsxekgr_esinec.wp_users AS u ON pp.cliente = u.ID
        JOIN txsxekgr_esinec.wp_posts AS pro ON pp.producto = pro.ID
        WHERE pp.fecha 
        BETWEEN :fechaActual AND :fechaLimite";

global $conn;
$stmt = $conn->prepare($query);
$stmt->bindParam(':fechaActual', $fechaActual);
$stmt->bindParam(':fechaLimite', $fechaLimite);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        

// Paso 3: Enviar correos electrónicos

foreach ($resultados as $fila) {
    
        $importe = $fila['importe'];
        // Formatear el importe en formato de moneda con separador de miles y símbolo de euro
        $formattedImporte = number_format($importe, 2, ',', '.') . ' €';

        $producto = $fila['producto'];
        $fecha = $fila['fecha'];
        // Formatear la fecha en formato "dd/mm/y"
        $formattedFecha = date("d/m/y", strtotime($fecha));

        $numPago = $fila['numPago'];
        $tipoPago = $fila['tipoPago'];
        $email = $fila['email'];

        if ($numPago == 1) {
            $pago = 'Transferencia bancaria';
        } else if ($numPago == 2) {
            $pago = 'Cash';
        } else if ($numPago == 4) {
            $pago = 'PayPal';
        } else if ($numPago == 3) {
            $pago = 'Tarjeta / Stripe';
        }

        $destinatario = $email;
        $asunto = 'Recordatorio próximo pago pendiente con ESINEC';
        $mensaje = "
            Hola,\n
            Te recordamos que en los próximos días tendrás un pago pendiente con nosotros. Por favor, regulariza tu situación lo antes posible. Aquí tienes los detalles del pago pendiente:\n
            
            Producto: ".$producto."\n
            Importe: ".$formattedImporte."\n
            Fecha pago previsto: ".$formattedFecha."\n
            Número del pago: ".$numPago."\n
            Pago mediante: ".$pago."\n
            ";

        $headers = "From: info@esinec.com\r\n";
        $headers .= "Reply-To: info@esinec.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        /* Aquí puedes mostrar los datos de cada fila como desees
        echo "ID: " . $fila['id'] . "<br>";
        echo "Fecha: " . $fila['fecha'] . "<br>";
        echo "Cliente ID: " . $fila['cliente'] . "<br>";
        echo "<br>";
        */

        // Envío de correo electrónico

        if (mail($destinatario, $asunto, $mensaje, $headers)) {
      
            // response output
            $response = array(
                'status' => 'Emails enviados con exito', 
            );
    
            header( "Content-Type: application/json" );
            echo json_encode($response);
            } else {
                // response output - data error
                $response['status'] = 'Error, datos email incorrectos';
                header( "Content-Type: application/json" );
                echo json_encode($response);
            }

}