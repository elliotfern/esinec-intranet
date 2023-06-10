<?php

// MODAL GENERAR FACTURA INTRANET

$url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');

if (isset($_POST['idFactura2'])) {
    $idFactura2 = $_POST['idFactura2'];
} else {
    $idFactura2 = $_POST['idFactura2'];
}

if (isset($_POST['status2'])) {
    $status2 = $_POST['status2'];
} else {
    $status2 = $_POST['status2'];
}

if (isset($_POST['producto2'])) {
    $producto2 = $_POST['producto2'];
} else {
    $producto2 = $_POST['producto2'];
}

if (isset($_POST['importe2'])) {
    $importe2 = $_POST['importe2'];
} else {
    $importe2 = $_POST['importe2'];
}

if (isset($_POST['fecha2'])) {
    $fecha2 = $_POST['fecha2'];
} else {
    $fecha2 = $_POST['fecha2'];
}

if (isset($_POST['cliente2'])) {
    $cliente2 = $_POST['cliente2'];
} else {
    $cliente2 = $_POST['cliente2'];
}

if (isset($_POST['tipoPago2'])) {
    $tipoPago2 = $_POST['tipoPago2'];
} else {
    $tipoPago2 = $_POST['tipoPago2'];
}

if (isset($_POST['numPago2'])) {
    $numPago2 = $_POST['numPago2'];
} else {
    $numPago2 = $_POST['numPago2'];
}


/*
id
date
status
invoiceNumber
clienteId
orderTotal
orderTax
paymentType
items
numPago
*/
        # conectare la base de datos
        global $conn;
    
            // some action goes here under php              
                        echo '<div class="alert alert-success" id="modificarFacturaIntranetMessageOk" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ADD_OK_MESSAGE.'</h6>
                        </div>';
                
                        echo '<div class="alert alert-danger" id="modificarFacturaIntranetMessageErr" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                        </div>
                        ';
    
            echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';

            echo '<input type="hidden" name="id2" id="id2" value="'.$id_old.'">';

            global $conn2;
    
                echo '<div class="col-md-4">
                      <label>Cliente:</label>
                      <select class="form-select" name="clienteId" id="clienteId">';
                echo '<option value="">Selecciona un cliente</option>';
                  $stmt = $conn2->prepare("SELECT u.ID, m1.meta_value as first_name, m2.meta_value as last_name
                  FROM wp_users u
                  JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'first_name'
                  JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name'
                  WHERE u.ID IN (
                    SELECT user_id FROM wp_usermeta
                    WHERE meta_key = 'wp_capabilities'
                    AND meta_value LIKE '%customer%'
                  )
                  ORDER BY m2.meta_value ASC");
                  $stmt->execute(); 
                  $data = $stmt->fetchAll();
                  foreach($data as $row){
                      $ID = $row['ID'];
                      $first_name = $row['first_name'];
                      $last_name = $row['last_name'];
                      if ($cliente2 == $ID) {
                          echo "<option value='".$cliente2."' selected>".$last_name.", ".$first_name."</option>";
                      } else {
                          echo "<option value='".$ID."'>".$last_name.", ".$first_name."</option>";
                      }
                  }
                echo '</select>';
                echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
                echo '</div>';
    
                echo '<div class="col-md-4">
                      <label>Producto:</label>
                      <select class="form-select" name="items" id="items">';
                echo '<option selected value="">Selecciona un producto</option>';
                  $stmt = $conn2->prepare("SELECT ID, post_title
                  FROM wp_posts
                  WHERE post_type = 'product'
                  AND post_status = 'publish'
                  ORDER BY post_title ASC");
                  $stmt->execute(); 
                  $data = $stmt->fetchAll();
                  foreach($data as $row){
                      $ID = $row['ID'];
                      $post_title = $row['post_title'];
                        if ($producto2 == $ID) {
                        echo "<option value='".$producto2."' selected>".$post_title."</option>";
                        } else {
                            echo "<option value='".$ID."'>".$post_title."</option>";
                        }
                  }
                echo '</select>';
                echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Variante del producto (opcional)</label>';
                echo '<input class="form-control" type="text" name="productoVariante" id="productoVariante" value="'.$idInvoice.'">';
                echo '</div>';

                $stmt = $conn2->prepare("SELECT MAX(id) AS last_id
                FROM txsxekgr_esinec.wp_wcpdf_invoice_number");
                $stmt->execute(); 
                $data = $stmt->fetchAll();
                foreach($data as $row){
                    $last_id = $row['last_id'];
                    $idInvoice = $last_id + 1;
                }

                echo '<div class="col-md-4">';
                echo '<label>Número de factura (sin escribir ESINEC Y AÑO)</label>';
                echo '<input class="form-control" type="text" name="invoiceNumber" id="invoiceNumber" value="'.$idInvoice.'">';
                echo '</div>';

                $vatRate = 21;
                $vatAmount = ($importe2 / (100+$vatRate)) * $vatRate;

                $vat_redondeado = ceil($vatAmount * 100) / 100;

                $precio_neto = $importe2 - $vat_redondeado;

                echo '<div class="col-md-4">';
                echo '<label>Importe total (sin IVA)</label>';
                echo '<input class="form-control" type="text" name="orderTotal" id="orderTotal" value="'.$precio_neto.'">';
                echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
                echo '</div>';
                
                echo '<div class="col-md-4">
                <label>Tipo de IVA:</label>
                <select class="form-select" name="orderTax" id="orderTax">';
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='21' selected>21%</option>";
                    echo "<option value='0'>SIN IVA</option>";
                    echo '</select>';
                echo '</div>';

                echo '<div class="col-md-4">
                <label>Tipo de pago:</label>
                <select class="form-select" name="paymentType" id="paymentType">';
                if ($tipoPago2 == 1) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1' selected>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($tipoPago2 == 2) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2' selected>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($tipoPago2 == 3) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3' selected>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($tipoPago2 == 4) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4' selected>Paypal</option>";
                    echo '</select>';
                } else {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1' selected>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                }
                echo '</div>';
    
                echo '<div class="col-md-4">';
                echo '<label>Fecha del pago</label>';
                echo '<input class="form-control" type="date" name="date" id="date" value="'.$fecha2.'">';
                echo '</div>';
    
                echo '<div class="col-md-4">';
                echo '<label>Número del pago (sólo número entre 1-12)</label>';
                echo '<input class="form-control" type="text" name="numPago2" id="numPago2" value="'.$numPago2.'">';
                echo '</div>';
    
                echo '<div class="col-md-4">
                <label>Estado:</label>
                <select class="form-select" name="status" id="status">';
                    echo '<option value="">Selecciona una opción</option>';
                    echo "<option value='1'>Pendiente de pago</option>";
                    echo "<option value='2'>Pagado</option>";
                    echo "<option value='3'>Factura cancelada</option>";
                    echo '</select>';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Notas factura (opcional)</label>';
                echo '<input class="form-control" type="text" name="notas" id="notas">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Comisión 1 - Formato: 00,00 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comision1" id="comisio1">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Comisionista 1 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comisionista1" id="comisionista1">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Comisión 2 - Formato: 00,00 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comision2" id="comisio2">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Comisionista 2 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comisionista2" id="comisionista2">';
                echo '</div>';
                
            echo "</form>";
      
        ?>