<?php
/*
 * BACKEND INTRANET ESINEC
 * FUNCION: INSERT NUEVA FACTURA INTRANET
 * TABLA: facturas
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

    // insert data to db
    if (empty($_POST["date"])) {
      $hasError = true;
    } else {
      $date = data_input($_POST['date']);
    }

    if (empty($_POST["status"])) {
      $hasError = true;
    } else {
      $status = data_input($_POST['status']);
    }

    if (empty($_POST["orderTotal"])) {
        $hasError = true;
    } else {
        $orderTotal = data_input($_POST['orderTotal']);
        // Check decimal separator and convert to dot if necessary
        if (strpos($orderTotal, ',') !== false && strpos($orderTotal, '.') === false) {
          $orderTotal = str_replace(',', '.', $orderTotal);
        }
        if (!is_numeric($orderTotal) || round($orderTotal, 2) != $orderTotal) {
          $hasError = true;
        }
    }

    if (empty($_POST["orderTax"])) {
        $hasError = true;
    } else {
        $orderTax = data_input($_POST['orderTax']);
    }

    if (empty($_POST["invoiceNumber"])) {
      $hasError = true;
    } else {
      $invoiceNumber = data_input($_POST['invoiceNumber']);
    }

    if (empty($_POST["clienteId"])) {
        $hasError = true;
    } else {
      $clienteId = data_input($_POST['clienteId']);
    }

    if (empty($_POST["numPago2"])) {
      $hasError = true;
    } else {
      $numPago = data_input($_POST['numPago2']);
      if (!filter_var($numPago, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>12)))) {
        $hasError = true;
      }
    }
    
    if (empty($_POST["paymentType"])) {
      $hasError = true;
    } else {
      $paymentType = data_input($_POST['paymentType']);
    }

    if (empty($_POST["items"])) {
        $hasError = true;
      } else {
        $items = data_input($_POST['items']);
      }

    if (empty($_POST["productoVariante"])) {
        $productoVariante = NULL;
      } else {
        $productoVariante = data_input($_POST['productoVariante']);
      }

      if (empty($_POST["notas"])) {
        $notas = NULL;
      } else {
        $notas = data_input($_POST['notas']);
      }

      if (empty($_POST["comision1"])) {
        $comision1 = NULL;
      } else {
        $comision1 = data_input($_POST['comision1']);
      }

      if (empty($_POST["comisionista1"])) {
        $comisionista1 = NULL;
      } else {
        $comisionista1 = data_input($_POST['comisionista1']);
      }

      if (empty($_POST["comision2"])) {
        $comision2 = NULL;
      } else {
        $comision2 = data_input($_POST['comision2']);
      }

      if (empty($_POST["comisionista2"])) {
        $comisionista2 = NULL;
      } else {
        $comisionista2 = data_input($_POST['comisionista2']);
      }

      $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
      if ($id === false) {
        $hasError = true;
      }
    
    if (!isset($hasError)) {
      $sql = "UPDATE txsxekgr_intranet.facturas SET date=:date, status=:status, invoiceNumber=:invoiceNumber, clienteId=:clienteId, orderTotal=:orderTotal, orderTax=:orderTax, paymentType=:paymentType, items=:items, numPago=:numPago, productoVariante=:productoVariante, notas=:notas, comision1=:comision1, comisionista1=:comisionista1, comision2=:comision2, comisionista2=:comisionista2 WHERE id=:id";
      
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":date", $date, PDO::PARAM_STR);
      $stmt->bindParam(":status", $status, PDO::PARAM_INT);
      $stmt->bindParam(":invoiceNumber", $invoiceNumber, PDO::PARAM_INT);
      $stmt->bindParam(":clienteId", $clienteId, PDO::PARAM_INT);
      $stmt->bindParam(":orderTotal", $orderTotal, PDO::PARAM_STR);
      $stmt->bindParam(":orderTax", $orderTax, PDO::PARAM_INT);
      $stmt->bindParam(":paymentType", $paymentType, PDO::PARAM_INT);
      $stmt->bindParam(":items", $items, PDO::PARAM_INT);
      $stmt->bindParam(":numPago", $numPago, PDO::PARAM_INT);
      $stmt->bindParam(":productoVariante", $productoVariante, PDO::PARAM_STR);
      $stmt->bindParam(":notas", $notas, PDO::PARAM_STR);
      $stmt->bindParam(":comision1", $comision1, PDO::PARAM_STR);
      $stmt->bindParam(":comisionista1", $comisionista1, PDO::PARAM_STR);
      $stmt->bindParam(":comision2", $comision2, PDO::PARAM_STR);
      $stmt->bindParam(":comisionista2", $comisionista2, PDO::PARAM_STR);
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