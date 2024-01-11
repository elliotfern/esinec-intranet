<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: INSERT NUEVO COBRO PROGRAMADO
 * TABLA: pagos_programados
 */

 $rootDirectory = $_SERVER['DOCUMENT_ROOT'];
 $substring = "/public_html/gestion";
 $result = str_replace($substring, "", $rootDirectory);
 $path = $result . "/pass/connection.php";
 require_once($path);

 require_once( $rootDirectory . "/inc/php/functions.php");

    // Insertar datos en la base de datos
    if (empty($_POST["id"])) {
        $hasError = true;
    } else {
        $id = data_input($_POST['id']);
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
        $hasError = true;
        // Manejar el error, por ejemplo, mostrar un mensaje al usuario o realizar alguna otra acción
        }
    }

       
    if (!isset($hasError)) {
      $sql = "DELETE FROM txsxekgr_intranet.pagos_programados WHERE id = :id";
      
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      $stmt = null;
      
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