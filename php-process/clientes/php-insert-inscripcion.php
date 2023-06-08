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


function data_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

    // insert data to db
    if (empty($_POST["cliente"])) {
      $hasError = true;
    } else {
      $cliente = data_input($_POST['cliente']);
    }

    if (empty($_POST["codigo"])) {
      $hasError = true;
    } else {
      $codigo = data_input($_POST['codigo']);
    }

    if (empty($_POST["edicion"])) {
      $hasError = true;
    } else {
      $edicion = data_input($_POST['edicion']);
    }

    if (empty($_POST["asistencia"])) {
      $asistencia = NULL;
    } else {
      $asistencia = data_input($_POST['asistencia']);
    }

    if (empty($_POST["importeTotal"])) {
      $hasError = true;
    } else {
        $importeTotal = data_input($_POST['importeTotal']);
        // Remove comma and dot from the input
        $importeTotal = str_replace(array(',', '.'), '', $importeTotal);
        if (!is_numeric($importeTotal) || round($importeTotal, 2) != $importeTotal) {
            $hasError = true;
        }
    }

    if (empty($_POST["captacionComercial"])) {
      $captacionComercial = NULL;
    } else {
      $captacionComercial = data_input($_POST['captacionComercial']);
    }

    if (empty($_POST["comercialCierre"])) {
      $comercialCierre = NULL;
    } else {
      $comercialCierre = data_input($_POST['comercialCierre']);
    }
    
    if (empty($_POST["notas"])) {
      $notas = null;
    } else {
      $notas = data_input($_POST['notas']);
    }
        
    if (!isset($hasError)) {
      $sql = "INSERT INTO txsxekgr_intranet.inscripcion_clientes SET cliente=:cliente, importeTotal=:importeTotal, codigo=:codigo, captacionComercial=:captacionComercial, comercialCierre=:comercialCierre, notas=:notas, asistencia=:asistencia, edicion=:edicion";
      
      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
      $stmt->bindParam(":importeTotal", $importeTotal, PDO::PARAM_STR);
      $stmt->bindParam(":codigo", $codigo, PDO::PARAM_INT);
      $stmt->bindParam(":edicion", $edicion, PDO::PARAM_INT);
      $stmt->bindParam(":asistencia", $asistencia, PDO::PARAM_STR);
      $stmt->bindParam(":captacionComercial", $captacionComercial, PDO::PARAM_INT);
      $stmt->bindParam(":comercialCierre", $comercialCierre, PDO::PARAM_INT);
      $stmt->bindParam(":notas", $notas, PDO::PARAM_STR);
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