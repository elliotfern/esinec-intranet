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
<!-- Modal Añadir nueva subscripcion --> 

<?php
        # conectare la base de datos
        global $conn;
        // some action goes here under php                
                    echo '<div class="alert alert-success" id="nuevaInscripcionMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="nuevaInscripcionMessageErr" style="display:none;role="alert">
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
                  <label>Código producto inscripción:</label>
                  <select class="form-select" name="codigo" id="codigo">';
            echo '<option selected value="">Selecciona una opción</option>';
             global $conn;
             $stmt = $conn->prepare("SELECT id, codigo
              FROM codigoCurso
              ORDER BY codigo ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['id'];
                  $codigo = $row['codigo'];
                  echo "<option value='".$ID."'>".$codigo."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
            <label>Edición curso</label>
            <select class="form-select" name="edicion" id="edicion">';
            echo '<option selected value="">Selecciona una opción</option>';
            global $conn;
            $stmt = $conn->prepare("SELECT id, edicion
              FROM edicionCurso
              ORDER BY edicion ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['id'];
                  $edicion = $row['edicion'];
                  echo "<option value='".$ID."'>".$edicion."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Asistencia (opcional)</label>';
            echo '<input class="form-control" type="text" name="asistencia" id="asistencia">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Importe total (sólo número)</label>';
            echo '<input class="form-control" type="text" name="importeTotal" id="importeTotal">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Comercial captación (opcional)</label>
                  <select class="form-select" name="captacionComercial" id="captacionComercial">';
            echo '<option selected value="">Selecciona una opción</option>';
             global $conn;
             $stmt = $conn->prepare("SELECT id, comercial
              FROM comercial
              ORDER BY comercial ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['id'];
                  $comercial = $row['comercial'];
                  echo "<option value='".$ID."'>".$comercial."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Comercial cierre (opcional)</label>
                  <select class="form-select" name="comercialCierre" id="comercialCierre">';
            echo '<option selected value="">Selecciona una opción</option>';
             global $conn;
             $stmt = $conn->prepare("SELECT id, comercial
              FROM comercial
              ORDER BY comercial ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID2 = $row['id'];
                  $comercial2 = $row['comercial'];
                  echo "<option value='".$ID2."'>".$comercial2."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Notas (opcional)</label>';
            echo '<input class="form-control" type="text" name="notas" id="notas">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';

        echo "</form>";
        ?>