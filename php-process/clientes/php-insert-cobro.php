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

    // insert data to db
    if (empty($_POST["cliente"])) {
      $hasError = true;
    } else {
      $cliente = data_input($_POST['cliente']);
    }

    if (empty($_POST["producto"])) {
      $hasError = true;
    } else {
      $producto = data_input($_POST['producto']);
    }

    if (empty($_POST["importe"])) {
        $hasError = true;
    } else {
        $importe = data_input($_POST['importe']);
        // Check decimal separator and convert to dot if necessary
        if (strpos($importe, ',') !== false && strpos($importe, '.') === false) {
          $importe = str_replace(',', '.', $importe);
        }
        if (!is_numeric($importe) || round($importe, 2) != $importe) {
          $hasError = true;
        }
    }

    if (empty($_POST["tipoPago"])) {
      $hasError = true;
    } else {
      $tipoPago = data_input($_POST['tipoPago']);
    }

    if (empty($_POST["fecha"])) {
      $fecha = null;
    } else {
      $fecha = data_input($_POST['fecha']);
    }

    if (empty($_POST["numPago"])) {
      $hasError = true;
    } else {
      $numPago = data_input($_POST['numPago']);
      if (!filter_var($numPago, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>200)))) {
        $hasError = true;
      }
    }
    
    if (empty($_POST["estado"])) {
      $hasError = true;
    } else {
      $estado = data_input($_POST['estado']);
    }
        
    if (!isset($hasError)) {
      $sql = "INSERT INTO txsxekgr_intranet.pagos_programados SET cliente=:cliente, producto=:producto, importe=:importe, tipoPago=:tipoPago, fecha=:fecha, estado=:estado, numPago=:numPago";
      
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
      $stmt->bindParam(":producto", $producto, PDO::PARAM_INT);
      $stmt->bindParam(":importe", $importe, PDO::PARAM_STR);
      $stmt->bindParam(":tipoPago", $tipoPago, PDO::PARAM_INT);
      $stmt->bindParam(":numPago", $numPago, PDO::PARAM_INT);
      $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
      $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
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