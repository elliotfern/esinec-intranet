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
    if (empty($_POST["cliente2"])) {
      $hasError = true;
    } else {
      $cliente = data_input($_POST['cliente2']);
    }

    if (empty($_POST["producto2"])) {
      $hasError = true;
    } else {
      $producto = data_input($_POST['producto2']);
    }

    if (empty($_POST["importe2"])) {
        $hasError = true;
    } else {
        $importe = data_input($_POST['importe2']);
        // Check decimal separator and convert to dot if necessary
        if (strpos($importe, ',') !== false && strpos($importe, '.') === false) {
          $importe = str_replace(',', '.', $importe);
        }
        if (!is_numeric($importe) || round($importe, 2) != $importe) {
          $hasError = true;
        }
    }

    if (empty($_POST["tipoPago2"])) {
      $hasError = true;
    } else {
      $tipoPago = data_input($_POST['tipoPago2']);
    }

    if (empty($_POST["fecha2"])) {
      $fecha = null;
    } else {
      $fecha = data_input($_POST['fecha2']);
    }

    if (empty($_POST["numPago2"])) {
      $hasError = true;
    } else {
      $numPago = data_input($_POST['numPago2']);
      if (!filter_var($numPago, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>12)))) {
        $hasError = true;
      }
    }
    
    if (empty($_POST["estado2"])) {
      $hasError = true;
    } else {
      $estado = data_input($_POST['estado2']);
    }
        
    $id = filter_input(INPUT_POST, 'id2', FILTER_SANITIZE_NUMBER_INT);
    
    if ($id === false) {
      $hasError = true;
    }
  
    if (!isset($hasError)) {
      $sql = "UPDATE txsxekgr_intranet.pagos_programados SET cliente=:cliente, producto=:producto, importe=:importe, tipoPago=:tipoPago, fecha=:fecha, estado=:estado, numPago=:numPago  WHERE id=:id";
       
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
      $stmt->bindParam(":producto", $producto, PDO::PARAM_INT);
      $stmt->bindParam(":importe", $importe, PDO::PARAM_STR);
      $stmt->bindParam(":tipoPago", $tipoPago, PDO::PARAM_INT);
      $stmt->bindParam(":numPago", $numPago, PDO::PARAM_INT);
      $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
      $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
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