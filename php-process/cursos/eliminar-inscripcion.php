<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: ELIMINAR INSCRIPCION A CURSO
 * TABLA: inscripcion_clientes
 */

 $rootDirectory = $_SERVER['DOCUMENT_ROOT'];
 $substring = "/public_html/gestion";
 $result = str_replace($substring, "", $rootDirectory);
 $path = $result . "/pass/connection.php";
 require_once($path);


function data_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

    // Insertar datos en la base de datos
    if (empty($_POST["idInscripcion"])) {
        $hasError = true;
    } else {
        $id = data_input($_POST['idInscripcion']);
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
        $hasError = true;
        // Manejar el error, por ejemplo, mostrar un mensaje al usuario o realizar alguna otra acción
        }
    }

       
    if (!isset($hasError)) {
      $sql = "DELETE FROM txsxekgr_intranet.inscripcion_clientes WHERE id = :id";
      
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