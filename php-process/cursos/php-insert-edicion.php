<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: INSERT NUEVO EDICION
 * TABLA: edicionCurso
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

        
    if (!isset($hasError)) {
      $sql = "INSERT INTO txsxekgr_intranet.edicionCurso SET curso=:curso, edicion=:edicion";
      
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":curso", $curso, PDO::PARAM_INT);
      $stmt->bindParam(":edicion", $edicion, PDO::PARAM_STR);
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