<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: INSERT NUEVO COBRO PROGRAMADO
 * TABLA: pagos_programados
 */

 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url_root = $_SERVER['DOCUMENT_ROOT'];
require_once($url_root. '/inc/connection.php');

function data_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

    // insert data to db
    if (empty($_POST["curso"])) {
        $hasError = true;
    } else {
      $curso = data_input($_POST['curso']);
    }

    if (empty($_POST["edicion"])) {
      $hasError = true;
    } else {
      $edicion = data_input($_POST['edicion']);
    }
        
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    if ($id === false) {
      $hasError = true;
  }
  
    
    if (!isset($hasError)) {
      $sql = "UPDATE txsxekgr_intranet.edicionCurso SET edicion=:edicion, curso=:curso WHERE id=:id";
      
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":edicion", $edicion, PDO::PARAM_STR);
      $stmt->bindParam(":curso", $curso, PDO::PARAM_INT);
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      
      // response output
      $response = array(
          'status' => 'success', 
      );

      header( "Content-Type: application/json" );
      echo json_encode($response);
    } else {
      // response output - data error
      $response['status'] = 'error';
      header( "Content-Type: application/json" );
      echo json_encode($response);
    }