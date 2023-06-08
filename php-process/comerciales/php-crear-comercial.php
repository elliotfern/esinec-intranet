<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: MODIFICAR COMERCIAL
 * TABLA: comercial
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
    if (empty($_POST["comercial2"])) {
      $hasError = true;
    } else {
      $comercial = data_input($_POST['comercial2']);
    }
    
    if (!isset($hasError)) {
      $sql = "INSERT INTO txsxekgr_intranet.comercial SET comercial=:comercial";
      
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":comercial", $comercial, PDO::PARAM_STR);
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