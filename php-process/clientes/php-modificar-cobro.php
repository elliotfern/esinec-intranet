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

    // Recibir datos del formulario y validarlos
    $cliente = validateFormField($_POST["cliente2"]);
    $producto = validateFormField($_POST["producto2"]);
    $tipoPago = validateFormField($_POST["tipoPago2"]);
    $fecha = validateFormField($_POST["fecha2"]);
    $estado = validateFormField($_POST["estado2"]);

    $numPago = validateFormField($_POST["numPago2"], false, true);
    $importe = validateFormField($_POST["importe2"], true);


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