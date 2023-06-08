<?php

$url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');

if (isset($_POST['idInscripcion2'])) {
    $idInscripcion2 = $_POST['idInscripcion2'];
} else {
    $idInscripcion2 = $_POST['idInscripcion2'];
}
        # conectare la base de datos
        global $conn;

        //call api
        //read json file from url in php
        $url = "https://" . $url2 . "/controller/clientes.php?type=inscripcion-cliente&id=" .$idInscripcion2;
        $input = file_get_contents($url);
        $arr = json_decode($input, true);
        $vault = $arr[0];

            $id_old = $vault['id']; 
            $importeTotal_old = $vault['importeTotal'];
            $asistencia_old = $vault['asistencia'];
            $cliente_old = $vault['cliente'];
            $codigo_old = $vault['codigo'];
            $edicion_old = $vault['edicion'];
            $captacionComercial_old = $vault['captacionComercial'];
            $comercialCierre_old = $vault['comercialCierre'];
            $notas_old = $vault['notas'];

        // some action goes here under php                
                    echo '<div class="alert alert-success" id="modificarInscripcionMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="modificarInscripcionMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormModificarInscripcion" class="row g-3">';

        echo '<input type="hidden" name="id2" id="id2" value="'.$id_old.'">';

          global $conn2;
            echo '<div class="col-md-4">
                  <label>Cliente:</label>
                  <select class="form-select" name="cliente2" id="cliente2">';
            echo '<option>Selecciona un cliente</option>';
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
                  <label>Código producto inscripción:</label>
                  <select class="form-select" name="codigo2" id="codigo2">';
            echo '<option selected value="">Selecciona una opción</option>';
             global $conn;
             $stmt = $conn->prepare("SELECT id, codigo
              FROM codigoCurso
              ORDER BY codigo ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $IDcodigo = $row['id'];
                  $codigo = $row['codigo'];
                  if ($codigo_old == $IDcodigo) {
                    echo "<option value='".$codigo_old."' selected>".$codigo."</option>";
                  } else {
                      echo "<option value='".$IDcodigo."'>".$codigo."</option>";
                  }
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
            <label>Edición curso</label>
            <select class="form-select" name="edicion2" id="edicion2">';
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
                  if ($edicion_old == $ID) {
                    echo "<option value='".$edicion_old."' selected>".$edicion."</option>";
                  } else {
                      echo "<option value='".$ID."'>".$edicion."</option>";
                  }
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Asistencia (opcional)</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$asistencia_old.'">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Importe total (sólo número)</label>';
            echo '<input type="text" class="form-control" name="importeTotal2" id="importeTotal2" value="'.$importeTotal_old.'" required>';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Comercial captación (opcional)</label>
                  <select class="form-select" name="captacionComercial2" id="captacionComercial2">';
            echo '<option selected value="">Selecciona una opción</option>';
             global $conn;
             $stmt = $conn->prepare("SELECT id, comercial
              FROM comercial
              ORDER BY comercial ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $IDcomercial = $row['id'];
                  $comercial = $row['comercial'];
                  if ($captacionComercial_old == $IDcomercial) {
                    echo "<option value='".$captacionComercial_old."' selected>".$comercial."</option>";
                  } else {
                      echo "<option value='".$IDcomercial."'>".$comercial."</option>";
                  }
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Comercial cierre (opcional)</label>
                  <select class="form-select" name="comercialCierre2" id="comercialCierre2">';
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
                  if ($comercialCierre_old == $ID2) {
                    echo "<option value='".$comercialCierre_old."' selected>".$comercial2."</option>";
                  } else {
                      echo "<option value='".$ID2."'>".$comercial2."</option>";
                  }
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Notas (opcional)</label>';
            echo '<input class="form-control" type="text" name="notas2" id="notas2" value="'.$notas_old.'">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';
      
        ?>