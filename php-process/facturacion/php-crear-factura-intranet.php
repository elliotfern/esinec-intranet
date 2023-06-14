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

      // DATOS FISCALES
      if ($_POST["datosfiscales"] == 2) {
        if ($_POST["datosfiscales_update"] == "actualizar") {

              $datosFiscalesActualizar = 1;

              if (empty($_POST["nombre"])) {
                $nombre = NULL;
              } else {
                $nombre = data_input($_POST['nombre']);
              }

              if (empty($_POST["apellidos"])) {
                $apellidos = NULL;
              } else {
                $apellidos = data_input($_POST['apellidos']);
              }
        
              if (empty($_POST["empresa"])) {
                $empresa = NULL;
              } else {
                $empresa = data_input($_POST['empresa']);
              }
        
              if (empty($_POST["dni"])) {
                $dni = NULL;
              } else {
                $dni = data_input($_POST['dni']);
              }
        
              if (empty($_POST["ciudad"])) {
                $ciudad = NULL;
              } else {
                $ciudad = data_input($_POST['ciudad']);
              }
        
              if (empty($_POST["direccion"])) {
                $direccion = NULL;
              } else {
                $direccion = data_input($_POST['direccion']);
              }
        
              if (empty($_POST["pais"])) {
                $pais = NULL;
              } else {
                $pais = data_input($_POST['pais']);
              }
        
              if (empty($_POST["provincia"])) {
                $provincia = NULL;
              } else {
                $provincia = data_input($_POST['provincia']);
              }
        } elseif ($_POST["datosfiscales_update"] == "insert") {
          $datosFiscalesActualizar = 2;

              if (empty($_POST["nombre"])) {
                $nombre = NULL;
              } else {
                $nombre = data_input($_POST['nombre']);
              }

              if (empty($_POST["apellidos"])) {
                $apellidos = NULL;
              } else {
                $apellidos = data_input($_POST['apellidos']);
              }
        
              if (empty($_POST["empresa"])) {
                $empresa = NULL;
              } else {
                $empresa = data_input($_POST['empresa']);
              }
        
              if (empty($_POST["dni"])) {
                $dni = NULL;
              } else {
                $dni = data_input($_POST['dni']);
              }
        
              if (empty($_POST["ciudad"])) {
                $ciudad = NULL;
              } else {
                $ciudad = data_input($_POST['ciudad']);
              }
        
              if (empty($_POST["direccion"])) {
                $direccion = NULL;
              } else {
                $direccion = data_input($_POST['direccion']);
              }
        
              if (empty($_POST["pais"])) {
                $pais = NULL;
              } else {
                $pais = data_input($_POST['pais']);
              }
        
              if (empty($_POST["provincia"])) {
                $provincia = NULL;
              } else {
                $provincia = data_input($_POST['provincia']);
              }
      }
   } 
    
    if (!isset($hasError)) {
      $sql = "INSERT INTO txsxekgr_intranet.facturas SET date=:date, status=:status, invoiceNumber=:invoiceNumber, clienteId=:clienteId, orderTotal=:orderTotal, orderTax=:orderTax, paymentType=:paymentType, items=:items, numPago=:numPago, productoVariante=:productoVariante, notas=:notas, comision1=:comision1, comisionista1=:comisionista1, comision2=:comision2, comisionista2=:comisionista2";
      
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
      $stmt->execute();

      // incrementar el numero de la factura invoice en tabla wordpress wp_wcpdf_invoice_number
      $order_id = 0;
      $fecha_actual = date("Y-m-d H:i:s");
      $date = $fecha_actual;
      $calculated_number = NULL;

      $sql = "INSERT INTO txsxekgr_esinec.wp_wcpdf_invoice_number SET order_id=:order_id, date=:date, calculated_number=:calculated_number";

      global $conn;
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);
      $stmt->bindParam(":date", $date, PDO::PARAM_STR);
      $stmt->bindParam(":calculated_number", $calculated_number, PDO::PARAM_STR);
      $stmt->execute();

      if ($datosFiscalesActualizar == "1") {
        $sql = "UPDATE txsxekgr_intranet.datosFiscalesCliente SET nombre=:nombre, apellidos=:apellidos, empresa=:empresa, dni=:dni, direccion=:direccion, ciudad=:ciudad, pais=:pais, provincia=:provincia WHERE idCliente=:idCliente";
      
        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(":empresa", $empresa, PDO::PARAM_STR);
        $stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
        $stmt->bindParam(":ciudad", $ciudad, PDO::PARAM_STR);
        $stmt->bindParam(":pais", $pais, PDO::PARAM_STR);
        $stmt->bindParam(":provincia", $provincia, PDO::PARAM_STR);
        $stmt->bindParam(":idCliente", $clienteId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
          // La ejecución fue exitosa
   
        } else {
          // Hubo un error en la ejecución

        }
      } elseif ($datosFiscalesActualizar == 2) {
        $sql = "INSERT INTO txsxekgr_intranet.datosFiscalesCliente SET nombre=:nombre, apellidos=:apellidos, empresa=:empresa, dni=:dni, direccion=:direccion, ciudad=:ciudad, pais=:pais, provincia=:provincia, idCliente=:idCliente";
      
        global $conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(":empresa", $empresa, PDO::PARAM_STR);
        $stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
        $stmt->bindParam(":ciudad", $ciudad, PDO::PARAM_STR);
        $stmt->bindParam(":pais", $pais, PDO::PARAM_STR);
        $stmt->bindParam(":provincia", $provincia, PDO::PARAM_STR);
        $stmt->bindParam(":idCliente", $clienteId, PDO::PARAM_INT);

        if ($stmt->execute()) {
         
        } else {
          
        }
      }


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