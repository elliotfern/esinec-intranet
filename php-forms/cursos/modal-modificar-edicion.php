<?php

$url2 = $_SERVER['SERVER_NAME'];

$url_root = $_SERVER['DOCUMENT_ROOT'];
define("APP_ROOT", $url_root); 

require_once(APP_ROOT . '/inc/connection.php');

if (isset($_POST['idEdicion'])) {
    $idEdicion = $_POST['idEdicion'];
} else {
    $idEdicion = $_POST['idEdicion'];
}
        # conectare la base de datos
        global $conn;

        //call api
        //read json file from url in php
        $url = "https://" . $url2 . "/controller/cursos.php?type=edicion-curso&id=" .$idEdicion;
        $input = file_get_contents($url);
        $arr = json_decode($input, true);
        $vault = $arr[0];

        $id_old = $vault['id']; 
        $edicion_old = $vault['edicion'];
        $curso_old = $vault['curso'];

        // some action goes here under php                
                    echo '<div class="alert alert-success" id="modificarEdicionMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="modificarEdicionMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormModificarInscripcion" class="row g-3">';

        echo '<input type="hidden" name="id" id="id" value="'.$id_old.'">';

          global $conn;
            echo '<div class="col-md-4">
                  <label>Curso vinculada a la edición:</label>
                  <select class="form-select" name="curso" id="curso">';
            echo '<option>Selecciona un cliente</option>';
              $stmt = $conn->prepare("SELECT id, codigo
              FROM codigoCurso
              ORDER BY codigo ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                $IDcodigo = $row['id'];
                $codigo = $row['codigo'];
                if ($curso_old == $IDcodigo) {
                  echo "<option value='".$curso_old."' selected>".$codigo."</option>";
                } else {
                    echo "<option value='".$IDcodigo."'>".$codigo."</option>";
                }
              }
              echo '</select>';
              echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
              echo '</div>';
          

            echo '<div class="col-md-4">
            <label>Nombre de la Edición</label>';
            echo '<input class="form-control" type="text" name="edicion" id="edicion" value="'.$edicion_old.'">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';
      
        ?>