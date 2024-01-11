<?php
$url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');

if (isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
} else {
    $idCliente = $_POST['idCliente'];
}

?>
<!-- Modal Añadir nuevo cobro --> 

     <?php
        # conectare la base de datos
        global $conn;

        // some action goes here under php              
                    echo '<div class="alert alert-success" id="crearCobroMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="crearCobroMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';
        global $conn2;

            echo '<div class="col-md-4">
                  <label>Cliente:</label>
                  <select class="form-select" name="cliente" id="cliente">';
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
                  if ($idCliente == $ID) {
                      echo "<option value='".$ID."' selected>".$last_name.", ".$first_name."</option>";
                  } else {
                      echo "<option value='".$ID."'>".$last_name.", ".$first_name."</option>";
                  }
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Producto:</label>
                  <select class="form-select" name="producto" id="producto">';
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
                  echo "<option value='".$ID."'>".$post_title."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Importe total (sólo número)</label>';
            echo '<input class="form-control" type="text" name="importe" id="importe">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';


            echo '<div class="col-md-4">
            <label>Tipo de pago:</label>
            <select class="form-select" name="tipoPago" id="tipoPago">';
            echo '<option selected value="">Selecciona una opción</option>';
            echo "<option value='1'>1) Transferencia bancaria</option>";
            echo "<option value='2'>2) Cash</option>";
            echo "<option value='3'>3) Tarjeta/Stripe</option>";
            echo "<option value='4'>4) PayPal</option>";
            echo "<option value='5'>5) Financiado Frakmenta</option>";
            echo "<option value='6'>6) Financiado Banc Sabadell</option>";
            echo "<option value='7'>7) Domiciliado SEPA</option>";
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Fecha del pago</label>';
            echo '<input class="form-control" type="date" name="fecha" id="fecha">';
            echo '<label style="color:#dc3545;display:none" id="AutCognom1Check">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Número del pago (sólo número entre 1-200)</label>';
            echo '<input class="form-control" type="text" name="numPago" id="numPago">';
            echo '<label style="color:#dc3545;display:none" id="AutCognom1Check">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
            <label>Estado:</label>
            <select class="form-select" name="estado" id="estado">';
            echo '<option selected value="">Selecciona una opción</option>';
            echo "<option value='1'>Pendiente de pago</option>";
            echo "<option value='2'>Pagado</option>";
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';
            
        echo "</form>";