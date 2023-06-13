<?php

// MODAL GENERAR FACTURA INTRANET

$url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');

if (isset($_POST['idFactura2'])) {
    $idFactura = $_POST['idFactura2'];
} else {
    $idFactura = $_POST['idFactura2'];
}
        # conectare la base de datos
        global $conn;

        //call api
        //read json file from url in php
        $url = "https://" . $url2 . "/controller/facturacion.php?type=factura-intranet-cliente&id=" .$idFactura;
        $input = file_get_contents($url);
        $arr = json_decode($input, true);
        $vault = $arr[0];

        $id_old = $vault['id']; 
            $status_old = $vault['status'];
            $date_old = $vault['fecha'];
            $clienteId_old = $vault['clienteId'];
            $invoiceNumber_old = $vault['invoice_number'];
            $orderTotal_old = $vault['total'];
            $orderTax_old = $vault['tax'];
            $items_old = $vault['producto'];
            $numPago_old = $vault['numPago'];
            $paymentType_old = $vault['payment_method'];
            $productoVariante_old = $vault['productoVariante'];
            $notas_old = $vault['notas'];
            $comision1_old = $vault['comision1'];
            $comisionista2_old = $vault['comisionista2'];
            $comision2_old = $vault['comision2'];
            $comisionista1_old = $vault['comisionista1'];

        # conectare la base de datos
        global $conn;
        global $conn2;
            // some action goes here under php              
                        echo '<div class="alert alert-success" id="modificarFacturaIntranetMessageOk" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ADD_OK_MESSAGE.'</h6>
                        </div>';
                
                        echo '<div class="alert alert-danger" id="modificarFacturaIntranetMessageErr" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                        </div>
                        ';
    
            echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';

            echo '<input type="hidden" name="id2" id="id2" value="'.$idFactura.'">';
            echo '<h6>Cliente asociado a la factura: </h6>';
            
            echo '<div class="col-md-4">
                <select class="form-select" name="clienteId" id="clienteId">';
                echo '<option value="">Selecciona un cliente</option>';
                  $stmt = $conn2->prepare("SELECT u.ID, m1.meta_value as first_name, m2.meta_value as last_name
                  FROM wp_users u
                  JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'first_name'
                  JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name'
                  WHERE u.ID IN (
                    SELECT user_id FROM wp_usermeta
                    WHERE meta_key = 'wp_capabilities'
                    AND meta_value LIKE '%customer%'
                  )
                  ORDER BY m2.meta_value ASC");
                  $stmt->execute(); 
                  $data = $stmt->fetchAll();
                  foreach($data as $row){
                      $ID = $row['ID'];
                      $first_name = $row['first_name'];
                      $last_name = $row['last_name'];
                      if ($clienteId_old == $ID) {
                          echo "<option value='".$clienteId_old."' selected>".$last_name.", ".$first_name."</option>";
                      } else {
                          echo "<option value='".$ID."'>".$last_name.", ".$first_name."</option>";
                      }
                  }
                echo '</select>';
                echo '</div>';
                
                echo '<div class="col-md-4">
                ¿Deseas añadir unos datos fiscales diferentes?
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="datosFiscales" name="datosFiscales">
                    <label class="form-check-label" for="flexCheckDefault">
                      Sí
                    </label>
                    </div> </div>';

                ?>
                <script>
                    $(document).ready(function() {
                    $('#datosFiscales').change(function() {
                        if ($(this).is(':checked')) {
                        $('#formularioSecundario').show();
                        $(this).val('2');
                        } else {
                        $('#formularioSecundario').hide();
                        $(this).val('');
                        }
                    });
                
                    obtenerDatosExistentes();
                    });

                        function obtenerDatosExistentes() {
                            var idCliente = $("#idCliente").val();
                        // Realiza la solicitud AJAX para verificar si los datos existen
                        var server = window.location.hostname;
                        var urlAjax =
                        "https://" +
                        server +
                        "/php-process/clientes/php-verificar-datos-fiscales.php";
                        $.ajax({
                            url: urlAjax,
                            type: 'GET',
                            data: {
                                idCliente: idCliente,
                            },
                            success: function(response) {
                                var parsedResponse = JSON.parse(response);
                                var datos = parsedResponse.datos;
                                console.log('Datos:', datos);
                                if (Object.keys(datos).length > 0) {
                                    // Si los datos existen, rellena los campos del formulario
                                    rellenarCampos(datos);
                                    //console.log('Exito');
                                    $('#datosfiscales_update').val('actualizar');
                                } else {
                                    // Si los datos no existen, realiza alguna otra acción
                                    $('#datosfiscales_update').val('insert');
                                    //console.log('NO hay JSON');
                                }
                               
                            },
                            error: function(xhr, status, error) {
                                alert('Error: ' + error);
                            }
                            });
                        }
                        function rellenarCampos(datos) {
                            $('#nombre').val(datos.nombre);
                            $('#apellidos').val(datos.apellidos);
                            $('#empresa').val(datos.empresa);
                            $('#dni').val(datos.dni);
                            $('#direccion').val(datos.direccion);
                            $('#ciudad').val(datos.ciudad);
                            $('#pais').val(datos.pais);
                            $('#provincia').val(datos.provincia);
                            }
                    </script>

                    <div id="formularioSecundario" class="container row g-3" style="display: none;">

                    <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $clienteId_old; ?>">

                    <input type="hidden" name="datosfiscales_update" id="datosfiscales_update">

                    <hr>
                    <h6>Datos fiscales: </h6>
                    <!-- Agrega los campos adicionales que deseas mostrar -->
                    <div class="col-md-4">
                    <label>Nombre:</label>
                    <input class="form-control" type="text" name="nombre" id="nombre">
                    </div>

                    <div class="col-md-4">
                    <label>Apellidos:</label>
                    <input class="form-control" type="text" name="apellidos" id="apellidos">
                    </div>

                    <div class="col-md-4">
                    <label>Empresa:</label>
                    <input class="form-control" type="text" name="empresa" id="empresa">
                    </div>

                    <div class="col-md-4">
                    <label>CIF/DNI/NIF:</label>
                    <input class="form-control" type="text" name="dni" id="dni">
                    </div>

                    <div class="col-md-4">
                    <label>Dirección:</label>
                    <input class="form-control" type="text" name="direccion" id="direccion">
                    </div>

                    <div class="col-md-4">
                    <label>Ciudad:</label>
                    <input class="form-control" type="text" name="ciudad" id="ciudad">
                    </div>

                    <div class="col-md-4">
                    <label>País:</label>
                    <input class="form-control" type="text" name="pais" id="pais">
                    </div>

                    <div class="col-md-4">
                    <label>Provincia:</label>
                    <input class="form-control" type="text" name="provincia" id="provincia" >
                    </div>

                </div>

               
                <?php
                
                echo '<hr>';
                echo '<h6>Producto: </h6>';

                echo '<div class="col-md-4">';
                echo '<label>Producto (vinculado a los productos de la web):</label>
                      <select class="form-select" name="items" id="items">';
                echo '<option selected value="">Selecciona un producto</option>';
                  $stmt = $conn2->prepare("SELECT ID, post_title
                  FROM wp_posts
                  WHERE post_type = 'product'
                  AND post_status = 'publish'
                  ORDER BY post_title ASC");
                  $stmt->execute(); 
                  $data = $stmt->fetchAll();
                  foreach($data as $row){
                      $ID = $row['ID'];
                      $post_title = $row['post_title'];
                        if ($items_old == $ID) {
                        echo "<option value='".$items_old."' selected>".$post_title."</option>";
                        } else {
                            echo "<option value='".$ID."'>".$post_title."</option>";
                        }
                  }
                echo '</select>';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Variante del producto (opcional)</label>';
                echo '<input class="form-control" type="text" name="productoVariante" id="productoVariante" value="'.$productoVariante_old.'">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Importe total (sin IVA)</label>';
                echo '<input class="form-control" type="text" name="orderTotal" id="orderTotal" value="'.$orderTotal_old.'">';
                echo '</div>';

                echo '<div class="col-md-4">
                <label>Tipo de IVA:</label>
                <select class="form-select" name="orderTax" id="orderTax">';
                if ($orderTax_old == 21) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='21' selected>21%</option>";
                    echo "<option value='0'>SIN IVA</option>";
                    echo '</select>';
                } elseif ($orderTax_old == 0) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='21'>21%</option>";
                    echo "<option value='0' selected>SIN IVA</option>";
                    echo '</select>';
                }   else {
                    echo '<option selected>Selecciona una opción</option>';
                    echo "<option value='21'>21%</option>";
                    echo "<option value='0'>SIN IVA</option>";
                    echo '</select>';
                }
                echo '</div>';

                echo '<hr>';
                echo '<h6>Datos factura:</h6>';

                echo '<div class="col-md-4">';
                echo '<label>Número de factura (sin escribir ESINEC Y AÑO)</label>';
                echo '<input class="form-control" type="text" name="invoiceNumber" id="invoiceNumber" value="'.$invoiceNumber_old.'">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Fecha factura</label>';
                echo '<input class="form-control" type="date" name="date" id="date" value="'.$date_old.'">';
                echo '</div>';
            
                echo '<div class="col-md-4">
                <label>Tipo de pago:</label>
                <select class="form-select" name="paymentType" id="paymentType">';
                if ($paymentType_old == 1) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1' selected>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($paymentType_old == 2) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2' selected>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($paymentType_old == 3) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3' selected>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($paymentType_old == 4) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4' selected>Paypal</option>";
                    echo '</select>';
                } else {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1' selected>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                }
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Número del pago (sólo número entre 1-12)</label>';
                echo '<input class="form-control" type="text" name="numPago2" id="numPago2" value="'.$numPago_old.'">';
                echo '</div>';
    
                echo '<div class="col-md-4">
                <label>Estado:</label>
                <select class="form-select" name="status" id="status">';
                if ($status_old == 1) {
                    echo '<option value="">Selecciona una opción</option>';
                    echo "<option value='1' selected>Pendiente de pago</option>";
                    echo "<option value='2'>Pagado</option>";
                    echo "<option value='3'>Factura cancelada</option>";
                    echo '</select>';
                } elseif ($status_old == 2) {
                    echo '<option value="">Selecciona una opción</option>';
                    echo "<option value='1'>Pendiente de pago</option>";
                    echo "<option value='2' selected>Pagado</option>";
                    echo "<option value='3'>Factura cancelada</option>";
                    echo '</select>';
                } elseif ($status_old == 3) {
                    echo '<option value="">Selecciona una opción</option>';
                    echo "<option value='1'>Pendiente de pago</option>";
                    echo "<option value='2'>Pagado</option>";
                    echo "<option value='3' selected>Factura cancelada</option>";
                    echo '</select>';
                }   
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Notas factura (opcional)</label>';
                echo '<input class="form-control" type="text" name="notas2" id="notas2" value="'.$notas_old.'">';
                echo '</div>';

                echo '<hr>';
                echo '<h5>Comisiones</h5>';

                echo '<div class="col-md-4">';
                echo '<label>Comisión 1 - Formato: 00,00 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comision1" id="comision1" value="'.$comision1_old.'">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Comisionista 1 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comisionista1" id="comisionista1" value="'.$comisionista1_old.'">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Comisión 2 - Formato: 00,00 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comision2" id="comision2" value="'.$comision2_old.'">';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Comisionista 2 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comisionista2" id="comisionista2" value="'.$comisionista2_old.'">';
                echo '</div>';
                
            echo "</form>";
      
        ?>