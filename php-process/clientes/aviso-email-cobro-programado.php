<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: INSERT NUEVO COBRO PROGRAMADO
 * TABLA: pagos_programados
 */
    $url2 = $_SERVER['SERVER_NAME'];
    $rootDirectory = $_SERVER['DOCUMENT_ROOT'];
    $substring = "/public_html/gestion";
    $result = str_replace($substring, "", $rootDirectory);
    $path = $result . "/pass/connection.php";
    require_once($path);

    require_once( $rootDirectory . "/inc/php/functions.php");
    
    // Insertar datos en la base de datos
    if (empty($_POST["idCobro"])) {
        $hasError = true;
    } else {
        $id = data_input($_POST['idCobro']);
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
        $hasError = true;
        // Manejar el error, por ejemplo, mostrar un mensaje al usuario o realizar alguna otra acción
        }
    }

    // SACAR INFORMACION DEL PAGO
         //call api
        //read json file from url in php
        $url = "https://" . $url2 . "/controller/facturacion.php?type=pago-programado&id=" .$id;
        $input = file_get_contents($url);
        $arr = json_decode($input, true);
        $vault = $arr[0];

            $importe = $vault['importe'];
            // Formatear el importe en formato de moneda con separador de miles y símbolo de euro
            $formattedImporte = number_format($importe, 2, ',', '.') . ' €';

            $producto = $vault['producto'];
            $fecha = $vault['fecha'];
            // Formatear la fecha en formato "dd/mm/y"
            $formattedFecha = date("d/m/y", strtotime($fecha));

            $numPago = $vault['numPago'];
            $tipoPago = $vault['tipoPago'];
            $email = $vault['email'];

            if ($numPago == 1) {
                $pago = 'Transferencia bancaria';
            } else if ($numPago == 2) {
                $pago = 'Cash';
            } else if ($numPago == 4) {
                $pago = 'PayPal';
            } else if ($numPago == 3) {
                $pago = 'Tarjeta / Stripe';
            }


       
    if (!isset($hasError)) {
        $to = $email;
        $subject = 'Tienes un pago pendiente con ESINEC';
        $message = "
            Hola,\n
            Tienes un pago pendiente. Por favor, regulariza tu situación lo antes posible. Aquí tienes los detalles del pago pendiente:\n
            
            Producto: ".$producto."\n
            Importe: ".$formattedImporte."\n
            Fecha pago previsto: ".$formattedFecha."\n
            Número del pago: ".$numPago."\n
            Pago mediante: ".$pago."\n
            ";
        
        $headers = 'From: info@esinec.com' . "\r\n" .
            'Reply-To: info@esinec.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
     if (mail($to, $subject, $message, $headers)) {
      
        // response output
        $response = array(
            'status' => 'success', 
        );

        header( "Content-Type: application/json" );
        echo json_encode($response);
        } else {
            // response output - data error
            $response['status'] = 'Error, datos email incorrectos';
            header( "Content-Type: application/json" );
            echo json_encode($response);
        }

    } else {
      // response output - data error
      $response['status'] = 'error';
      header( "Content-Type: application/json" );
      echo json_encode($response);
    }