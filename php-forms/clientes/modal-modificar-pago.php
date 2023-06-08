<?php

$url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');

if (isset($_POST['idPago2'])) {
    $idPago2 = $_POST['idPago2'];
} else {
    $idPago2 = $_POST['idPago2'];
}
        # conectare la base de datos
        global $conn;

        //call api
        //read json file from url in php
        $url = "https://" . $url2 . "/controller/clientes.php?type=pago-cliente-json&id=" .$idPago2;
        $input = file_get_contents($url);
        $arr = json_decode($input, true);
        $vault = $arr[0];

            $id_old = $vault['id']; 
            $importe_old = $vault['importe'];
            $producto_old = $vault['producto'];
            $cliente_old = $vault['cliente'];
            $tipoPago_old = $vault['tipoPago'];
            $fecha_old = $vault['fecha'];
            $numPago_old = $vault['numPago'];
            $estado_old = $vault['estado'];

           # conectare la base de datos
            global $conn;
    
            // some action goes here under php              
                        echo '<div class="alert alert-success" id="modificarCobroMessageOk" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ADD_OK_MESSAGE.'</h6>
                        </div>';
                
                        echo '<div class="alert alert-danger" id="modificarCobroMessageErr" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                        </div>
                        ';
    
            echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';

            echo '<input type="hidden" name="id2" id="id2" value="'.$id_old.'">';

            global $conn2;
    
                echo '<div class="col-md-4">
                      <label>Cliente:</label>
                      <select class="form-select" name="cliente2" id="cliente2">';
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
                      if ($cliente_old == $ID) {
                          echo "<option value='".$cliente_old."' selected>".$last_name.", ".$first_name."</option>";
                      } else {
                          echo "<option value='".$ID."'>".$last_name.", ".$first_name."</option>";
                      }
                  }
                echo '</select>';
                echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
                echo '</div>';
    
                echo '<div class="col-md-4">
                      <label>Producto:</label>
                      <select class="form-select" name="producto2" id="producto2">';
                echo '<option selected value="">Selecciona una opción</option>';
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
                        if ($producto_old == $ID) {
                        echo "<option value='".$producto_old."' selected>".$post_title."</option>";
                        } else {
                            echo "<option value='".$ID."'>".$post_title."</option>";
                        }
                  }
                echo '</select>';
                echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
                echo '</div>';
    
                echo '<div class="col-md-4">';
                echo '<label>Importe total (sólo número)</label>';
                echo '<input class="form-control" type="text" name="importe2" id="importe2"  value="'.$importe_old.'">';
                echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
                echo '</div>';
    
                echo '<div class="col-md-4">
                <label>Tipo de pago:</label>
                <select class="form-select" name="tipoPago2" id="tipoPago2">';
                if ($tipoPago_old == 1) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1' selected>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo '</select>';
                } elseif ($tipoPago_old == 2) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2' selected>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo '</select>';
                } elseif ($tipoPago_old == 3) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3' selected>Stripe - tarjeta</option>";
                    echo '</select>';
                }
                echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
                echo '</div>';
    
                echo '<div class="col-md-4">';
                echo '<label>Fecha del pago</label>';
                echo '<input class="form-control" type="date" name="fecha2" id="fecha2"  value="'.$fecha_old.'">';
                echo '<label style="color:#dc3545;display:none" id="AutCognom1Check">* Missing data</label>';
                echo '</div>';
    
                echo '<div class="col-md-4">';
                echo '<label>Número del pago (sólo número entre 1-12)</label>';
                echo '<input class="form-control" type="text" name="numPago2" id="numPago2"  value="'.$numPago_old.'">';
                echo '<label style="color:#dc3545;display:none" id="AutCognom1Check">* Missing data</label>';
                echo '</div>';
    
                echo '<div class="col-md-4">
                <label>Estado:</label>
                <select class="form-select" name="estado2" id="estado2">';
                if ($estado_old == 1) {
                    echo '<option value="">Selecciona una opción</option>';
                    echo "<option value='1' selected>Pendiente de pago</option>";
                    echo "<option value='2'>Pagado</option>";
                    echo '</select>';
                    } else {
                        echo '<option value="">Selecciona una opción</option>';
                        echo "<option value='1'>Pendiente de pago</option>";
                        echo "<option value='2' selected>Pagado</option>";
                        echo '</select>';
                    }
                echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
                echo '</div>';
                
            echo "</form>";
      
        ?>