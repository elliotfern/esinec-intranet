<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: INSERT NUEVO CODIGO
 * TABLA: pagos_programados
 */

 $url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');


function data_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

    // insert data to db
    if (empty($_POST["codigo"])) {
      $hasError = true;
    } else {
      $codigo = data_input($_POST['codigo']);
    }

        
    if (!isset($hasError)) {
      $sql = "INSERT INTO txsxekgr_intranet.codigoCurso SET codigo=:codigo";
      
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":codigo", $codigo, PDO::PARAM_STR);
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