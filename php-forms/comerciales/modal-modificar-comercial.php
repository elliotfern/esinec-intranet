<?php

$url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');

if (isset($_POST['idComercial'])) {
    $idComercial = $_POST['idComercial'];
} else {
    $idComercial = $_POST['idComercial'];
}
        # conectare la base de datos
        global $conn;

        //call api
        //read json file from url in php
        $url = "https://" . $url2 . "/controller/comerciales.php?type=comercial-equipo&id=" .$idComercial;
        $input = file_get_contents($url);
        $arr = json_decode($input, true);
        $vault = $arr[0];

            $id_old = $vault['id']; 
            $comercial_old = $vault['equipo'];


        // some action goes here under php                
                    echo '<div class="alert alert-success" id="modificarComercialMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="modificarComercialMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormModificarInscripcion" class="row g-3">';

        echo '<input type="hidden" name="id" id="id" value="'.$id_old.'">';

            echo '<div class="col-md-4">';
            echo '<label>Comercial</label>';
            echo '<input class="form-control" type="text" name="equipo" id="equipo" value="'.$comercial_old.'">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';
      
        ?>