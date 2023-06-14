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
    $idFactura2 = $_POST['idFactura2'];
} else {
    $idFactura2 = $_POST['idFactura2'];
}

if (isset($_POST['status2'])) {
    $status2 = $_POST['status2'];
} else {
    $status2 = $_POST['status2'];
}

if (isset($_POST['producto2'])) {
    $producto2 = $_POST['producto2'];
} else {
    $producto2 = $_POST['producto2'];
}

if (isset($_POST['importe2'])) {
    $importe2 = $_POST['importe2'];
} else {
    $importe2 = $_POST['importe2'];
}

if (isset($_POST['fecha2'])) {
    $fecha2 = $_POST['fecha2'];
} else {
    $fecha2 = $_POST['fecha2'];
}

if (isset($_POST['cliente2'])) {
    $cliente2 = $_POST['cliente2'];
} else {
    $cliente2 = $_POST['cliente2'];
}

if (isset($_POST['tipoPago2'])) {
    $tipoPago2 = $_POST['tipoPago2'];
} else {
    $tipoPago2 = $_POST['tipoPago2'];
}

if (isset($_POST['numPago2'])) {
    $numPago2 = $_POST['numPago2'];
} else {
    $numPago2 = $_POST['numPago2'];
}


/*
id
date
status
invoiceNumber
clienteId
orderTotal
orderTax
paymentType
items
numPago
*/
        # conectare la base de datos
        global $conn;
    
            // some action goes here under php              
                        echo '<div class="alert alert-success" id="crearFacturaIntranetMessageOk" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ADD_OK_MESSAGE.'</h6>
                        </div>';
                
                        echo '<div class="alert alert-danger" id="crearFacturaIntranetMessageErr" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                        </div>
                        ';
    
            echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';

            echo '<input type="hidden" name="id2" id="id2" value="'.$id_old.'">';
            echo '<input type="hidden" name="cliente" id="cliente" value="'.$cliente2.'">';

            global $conn2;

            echo '<h6>Cliente asociado a la factura: </h6>';

                echo '<div class="col-md-4">
                      <label>Cliente:</label>
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
                      if ($cliente2 == $ID) {
                          echo "<option value='".$cliente2."' selected>".$last_name.", ".$first_name."</option>";
                      } else {
                          echo "<option value='".$ID."'>".$last_name.", ".$first_name."</option>";
                      }
                  }
                echo '</select>';
                echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
                echo '</div>';

                echo '<div class="col-md-4">
                ¿Deseas añadir unos datos fiscales diferentes?
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="datosFiscales2" name="datosFiscales">
                    <label class="form-check-label" for="flexCheckDefault">
                      Sí
                    </label>
                    </div> </div>';

                    ?>
                    <script>
                        // Variable global para almacenar el valor de provinciaCliente
                        var provinciaCliente;
                        var paisCliente;
                        $(document).ready(function() {
                        $('#datosFiscales2').change(function() {
                            if ($(this).is(':checked')) {
                            $('#formularioSecundario2').show();
                            $(this).val('2');
                            } else {
                            $('#formularioSecundario2').hide();
                            $(this).val('');
                            }
                        });
                    
                        obtenerDatosExistentes();
                        });
    
                            function obtenerDatosExistentes() {
                                var idCliente = $("#cliente").val();
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
    
                                provinciaCliente = datos.provincia;
                                paisCliente = datos.pais;
                                }
                        </script>
    
                        <div id="formularioSecundario2" class="container row g-3" style="display: none;">
    
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
                        
                        <div class="col-md-4" id="container-pais">
                        <label for="pais">País:</label>
                        </div>
    
                        <script>
                            // Obtener el valor de la variable JavaScript
                            var paisCliente =  window.paisCliente;
    
                            // Definir las opciones del select
                            var opciones = [
                                { value: 'AF', text: 'Afganistán' },
      { value: 'AL', text: 'Albania' },
      { value: 'DE', text: 'Alemania' },
      { value: 'AD', text: 'Andorra' },
      { value: 'AO', text: 'Angola' },
      { value: 'AI', text: 'Anguila' },
      { value: 'AQ', text: 'Antártida' },
      { value: 'AG', text: 'Antigua y Barbuda' },
      { value: 'AN', text: 'Antillas Neerlandesas' },
      { value: 'SA', text: 'Arabia Saudita' },
      { value: 'DZ', text: 'Argelia' },
      { value: 'AR', text: 'Argentina' },
      { value: 'AM', text: 'Armenia' },
      { value: 'AW', text: 'Aruba' },
      { value: 'AU', text: 'Australia' },
      { value: 'AT', text: 'Austria' },
      { value: 'AZ', text: 'Azerbaiyán' },
      { value: 'BS', text: 'Bahamas' },
      { value: 'BH', text: 'Bahréin' },
      { value: 'BD', text: 'Bangladés' },
      { value: 'BB', text: 'Barbados' },
      { value: 'BE', text: 'Bélgica' },
      { value: 'BZ', text: 'Belice' },
      { value: 'BJ', text: 'Benín' },
      { value: 'BM', text: 'Bermudas' },
      { value: 'BY', text: 'Bielorrusia' },
      { value: 'MM', text: 'Birmania' },
      { value: 'BO', text: 'Bolivia' },
      { value: 'BA', text: 'Bosnia y Herzegovina' },
      { value: 'BW', text: 'Botsuana' },
      { value: 'BR', text: 'Brasil' },
      { value: 'BN', text: 'Brunéi' },
      { value: 'BG', text: 'Bulgaria' },
      { value: 'BF', text: 'Burkina Faso' },
      { value: 'BI', text: 'Burundi' },
      { value: 'BT', text: 'Bután' },
      { value: 'CV', text: 'Cabo Verde' },
      { value: 'KH', text: 'Camboya' },
      { value: 'CM', text: 'Camerún' },
      { value: 'CA', text: 'Canadá' },
      { value: 'TD', text: 'Chad' },
      { value: 'CL', text: 'Chile' },
      { value: 'CN', text: 'China' },
      { value: 'CY', text: 'Chipre' },
      { value: 'VA', text: 'Ciudad del Vaticano' },
      { value: 'CO', text: 'Colombia' },
      { value: 'KM', text: 'Comoras' },
      { value: 'CG', text: 'Congo' },
      { value: 'KP', text: 'Corea del Norte' },
      { value: 'KR', text: 'Corea del Sur' },
      { value: 'CI', text: 'Costa de Marfil' },
      { value: 'CR', text: 'Costa Rica' },
      { value: 'HR', text: 'Croacia' },
      { value: 'CU', text: 'Cuba' },
      { value: 'DK', text: 'Dinamarca' },
      { value: 'DM', text: 'Dominica' },
      { value: 'EC', text: 'Ecuador' },
      { value: 'EG', text: 'Egipto' },
      { value: 'SV', text: 'El Salvador' },
      { value: 'AE', text: 'Emiratos Árabes Unidos' },
      { value: 'ER', text: 'Eritrea' },
      { value: 'SK', text: 'Eslovaquia' },
      { value: 'SI', text: 'Eslovenia' },
      { value: 'ES', text: 'España' },
      { value: 'US', text: 'Estados Unidos' },
      { value: 'EE', text: 'Estonia' },
      { value: 'ET', text: 'Etiopía' },
      { value: 'PH', text: 'Filipinas' },
      { value: 'FI', text: 'Finlandia' },
      { value: 'FJ', text: 'Fiyi' },
      { value: 'FR', text: 'Francia' },
      { value: 'GA', text: 'Gabón' },
      { value: 'GM', text: 'Gambia' },
      { value: 'GE', text: 'Georgia' },
      { value: 'GH', text: 'Ghana' },
      { value: 'GI', text: 'Gibraltar' },
      { value: 'GD', text: 'Granada' },
      { value: 'GR', text: 'Grecia' },
      { value: 'GL', text: 'Groenlandia' },
      { value: 'GP', text: 'Guadalupe' },
      { value: 'GU', text: 'Guam' },
      { value: 'GT', text: 'Guatemala' },
      { value: 'GY', text: 'Guayana Francesa' },
      { value: 'GN', text: 'Guinea' },
      { value: 'GQ', text: 'Guinea Ecuatorial' },
      { value: 'GW', text: 'Guinea-Bisáu' },
      { value: 'HT', text: 'Haití' },
      { value: 'HN', text: 'Honduras' },
      { value: 'HU', text: 'Hungría' },
      { value: 'IN', text: 'India' },
      { value: 'ID', text: 'Indonesia' },
      { value: 'IQ', text: 'Irak' },
      { value: 'IR', text: 'Irán' },
      { value: 'IE', text: 'Irlanda' },
      { value: 'BV', text: 'Isla Bouvet' },
      { value: 'CX', text: 'Isla de Christmas' },
      { value: 'IS', text: 'Islandia' },
      { value: 'KY', text: 'Islas Caimán' },
      { value: 'CK', text: 'Islas Cook' },
      { value: 'CC', text: 'Islas de Cocos o Keeling' },
      { value: 'FO', text: 'Islas Faroe' },
      { value: 'HM', text: 'Islas Heard y McDonald' },
      { value: 'FK', text: 'Islas Malvinas' },
      { value: 'MP', text: 'Islas Marianas del Norte' },
      { value: 'MH', text: 'Islas Marshall' },
      { value: 'UM', text: 'Islas menores de Estados Unidos' },
      { value: 'PW', text: 'Islas Palau' },
      { value: 'SB', text: 'Islas Salomón' },
      { value: 'SJ', text: 'Islas Svalbard y Jan Mayen' },
      { value: 'TK', text: 'Islas Tokelau' },
      { value: 'TC', text: 'Islas Turks y Caicos' },
      { value: 'VI', text: 'Islas Vírgenes (EE.UU.)' },
      { value: 'VG', text: 'Islas Vírgenes (Reino Unido)' },
      { value: 'WF', text: 'Islas Wallis y Futuna' },
      { value: 'IL', text: 'Israel' },
      { value: 'IT', text: 'Italia' },
      { value: 'JM', text: 'Jamaica' },
      { value: 'JP', text: 'Japón' },
      { value: 'JO', text: 'Jordania' },
      { value: 'KZ', text: 'Kazajistán' },
      { value: 'KE', text: 'Kenia' },
      { value: 'KG', text: 'Kirguistán' },
      { value: 'KI', text: 'Kiribati' },
      { value: 'KW', text: 'Kuwait' },
      { value: 'LA', text: 'Laos' },
      { value: 'LS', text: 'Lesoto' },
      { value: 'LV', text: 'Letonia' },
      { value: 'LB', text: 'Líbano' },
      { value: 'LR', text: 'Liberia' },
      { value: 'LY', text: 'Libia' },
      { value: 'LI', text: 'Liechtenstein' },
      { value: 'LT', text: 'Lituania' },
      { value: 'LU', text: 'Luxemburgo' },
      { value: 'MK', text: 'Macedonia' },
      { value: 'MG', text: 'Madagascar' },
      { value: 'MY', text: 'Malasia' },
      { value: 'MW', text: 'Malaui' },
      { value: 'MV', text: 'Maldivas' },
      { value: 'ML', text: 'Malí' },
      { value: 'MT', text: 'Malta' },
      { value: 'MA', text: 'Marruecos' },
      { value: 'MQ', text: 'Martinica' },
      { value: 'MU', text: 'Mauricio' },
      { value: 'MR', text: 'Mauritania' },
      { value: 'YT', text: 'Mayotte' },
      { value: 'MX', text: 'México' },
      { value: 'FM', text: 'Micronesia' },
      { value: 'MD', text: 'Moldavia' },
      { value: 'MC', text: 'Mónaco' },
      { value: 'MN', text: 'Mongolia' },
      { value: 'MS', text: 'Montserrat' },
      { value: 'MZ', text: 'Mozambique' },
      { value: 'NA', text: 'Namibia' },
      { value: 'NR', text: 'Nauru' },
      { value: 'NP', text: 'Nepal' },
      { value: 'NI', text: 'Nicaragua' },
      { value: 'NE', text: 'Níger' },
      { value: 'NG', text: 'Nigeria' },
      { value: 'NU', text: 'Niue' },
      { value: 'NF', text: 'Norfolk' },
      { value: 'NO', text: 'Noruega' },
      { value: 'NC', text: 'Nueva Caledonia' },
      { value: 'NZ', text: 'Nueva Zelanda' },
      { value: 'OM', text: 'Omán' },
      { value: 'NL', text: 'Países Bajos' },
      { value: 'PA', text: 'Panamá' },
      { value: 'PG', text: 'Papúa-Nueva Guinea' },
      { value: 'PK', text: 'Pakistán' },
      { value: 'PY', text: 'Paraguay' },
      { value: 'PE', text: 'Perú' },
      { value: 'PN', text: 'Pitcairn' },
      { value: 'PF', text: 'Polinesia Francesa' },
      { value: 'PL', text: 'Polonia' },
      { value: 'PT', text: 'Portugal' },
      { value: 'PR', text: 'Puerto Rico' },
      { value: 'QA', text: 'Qatar' },
      { value: 'UK', text: 'Reino Unido' },
      { value: 'CF', text: 'República Centroafricana' },
      { value: 'CZ', text: 'República Checa' },
      { value: 'ZA', text: 'República de Sudáfrica' },
      { value: 'DO', text: 'República Dominicana' },
      { value: 'SK', text: 'República Eslovaca' },
      { value: 'RE', text: 'Reunión' },
      { value: 'RW', text: 'Ruanda' },
      { value: 'RO', text: 'Rumania' },
      { value: 'RU', text: 'Rusia' },
      { value: 'EH', text: 'Sahara Occidental' },
      { value: 'KN', text: 'Saint Kitts y Nevis' },
      { value: 'WS', text: 'Samoa' },
      { value: 'AS', text: 'Samoa Americana' },
      { value: 'SM', text: 'San Marino' },
      { value: 'VC', text: 'San Vicente y Granadinas' },
      { value: 'SH', text: 'Santa Helena' },
      { value: 'LC', text: 'Santa Lucía' },
      { value: 'ST', text: 'Santo Tomé y Príncipe' },
      { value: 'SN', text: 'Senegal' },
      { value: 'SC', text: 'Seychelles' },
      { value: 'SL', text: 'Sierra Leona' },
      { value: 'SG', text: 'Singapur' },
      { value: 'SY', text: 'Siria' },
      { value: 'SO', text: 'Somalia' },
      { value: 'LK', text: 'Sri Lanka' },
      { value: 'PM', text: 'St Pierre y Miquelon' },
      { value: 'SZ', text: 'Suazilandia' },
      { value: 'SD', text: 'Sudán' },
      { value: 'SE', text: 'Suecia' },
      { value: 'CH', text: 'Suiza' },
      { value: 'SR', text: 'Surinam' },
      { value: 'TH', text: 'Tailandia' },
      { value: 'TW', text: 'Taiwán' },
      { value: 'TZ', text: 'Tanzania' },
      { value: 'TJ', text: 'Tayikistán' },
      { value: 'TF', text: 'Territorios franceses del Sur' },
      { value: 'TP', text: 'Timor Oriental' },
      { value: 'TG', text: 'Togo' },
      { value: 'TO', text: 'Tonga' },
      { value: 'TT', text: 'Trinidad y Tobago' },
      { value: 'TN', text: 'Túnez' },
      { value: 'TM', text: 'Turkmenistán' },
      { value: 'TR', text: 'Turquía' },
      { value: 'TV', text: 'Tuvalu' },
      { value: 'UA', text: 'Ucrania' },
      { value: 'UG', text: 'Uganda' },
      { value: 'UY', text: 'Uruguay' },
      { value: 'UZ', text: 'Uzbekistán' },
      { value: 'VU', text: 'Vanuatu' },
      { value: 'VE', text: 'Venezuela' },
      { value: 'VN', text: 'Vietnam' },
      { value: 'YE', text: 'Yemen' },
      { value: 'ZM', text: 'Zambia' },
      { value: 'ZW', text: 'Zimbabue' }
                            // Agrega más opciones aquí
                            ];
    
                            // Crear el elemento select
                            var select = document.createElement('select');
                            select.id = 'pais';
                            select.name = 'pais';
                            select.className = 'form-select'; // Agrega la clase 'form-select' al select
    
                            // Recorrer las opciones y crear los elementos de opción
                            for (var i = 0; i < opciones.length; i++) {
                            var option = document.createElement('option');
                            option.value = opciones[i].value;
                            option.text = opciones[i].text;
                            select.appendChild(option);
    
                            // Seleccionar la opción correspondiente al valor de paisCliente
                            if (opciones[i].value === paisCliente) {
                                option.selected = true;
                            }
                            }
    
                            // Agregar el select al elemento deseado en el DOM
                            var container = document.getElementById('container-pais');
                            container.appendChild(select);
                            </script>
    
                            <script>
                                         // Obtener el valor de la variable JavaScript
                            var provinciaCliente =  window.provinciaCliente;
                            var selectProvincia = $('#provincia');
    
    // Definir las opciones del select
    var opciones = [
        { value: '', text: 'Selecciona una opcion' },
        { value: 'A', text: 'Álava' },
                            { value: 'AB', text: 'Albacete' },
                            { value: 'AL', text: 'Alicante' },
                            { value: 'AM', text: 'Almería' },
                            { value: 'O', text: 'Asturias' },
                            { value: 'AV', text: 'Ávila' },
                            { value: 'BA', text: 'Badajoz' },
                            { value: 'PM', text: 'Baleares' },
                            { value: 'B', text: 'Barcelona' },
                            { value: 'BU', text: 'Burgos' },
                            { value: 'CC', text: 'Cáceres' },
                            { value: 'CA', text: 'Cádiz' },
                            { value: 'S', text: 'Cantabria' },
                            { value: 'CS', text: 'Castellón' },
                            { value: 'CE', text: 'Ceuta' },
                            { value: 'CR', text: 'Ciudad Real' },
                            { value: 'CO', text: 'Córdoba' },
                            { value: 'CU', text: 'Cuenca' },
                            { value: 'GI', text: 'Girona' },
                            { value: 'GR', text: 'Granada' },
                            { value: 'GU', text: 'Guadalajara' },
                            { value: 'SS', text: 'Guipúzcoa' },
                            { value: 'H', text: 'Huelva' },
                            { value: 'HU', text: 'Huesca' },
                            { value: 'J', text: 'Jaén' },
                            { value: 'LO', text: 'La Rioja' },
                            { value: 'GC', text: 'Las Palmas' },
                            { value: 'LE', text: 'León' },
                            { value: 'L', text: 'Lleida' },
                            { value: 'LU', text: 'Lugo' },
                            { value: 'M', text: 'Madrid' },
                            { value: 'MA', text: 'Málaga' },
                            { value: 'ML', text: 'Melilla' },
                            { value: 'MU', text: 'Murcia' },
                            { value: 'NA', text: 'Navarra' },
                            { value: 'OR', text: 'Ourense' },
                            { value: 'P', text: 'Palencia' },
                            { value: 'PO', text: 'Pontevedra' },
                            { value: 'SA', text: 'Salamanca' },
                            { value: 'TF', text: 'Santa Cruz de Tenerife' },
                            { value: 'SG', text: 'Segovia' },
                            { value: 'SE', text: 'Sevilla' },
                            { value: 'SO', text: 'Soria' },
                            { value: 'T', text: 'Tarragona' },
                            { value: 'TE', text: 'Teruel' },
                            { value: 'TO', text: 'Toledo' },
                            { value: 'V', text: 'Valencia' },
                            { value: 'VA', text: 'Valladolid' },
                            { value: 'BI', text: 'Vizcaya' },
                            { value: 'ZA', text: 'Zamora' },
                            { value: 'Z', text: 'Zaragoza' }
        // Agrega más opciones aquí
        ];
    
        // Crear el elemento select
        var select = document.createElement('select');
        select.id = 'provincia';
        select.name = 'provincia';
        select.className = 'form-select'; // Agrega la clase 'form-select' al select
    
        // Recorrer las opciones y crear los elementos de opción
        for (var i = 0; i < opciones.length; i++) {
        var option = document.createElement('option');
        option.value = opciones[i].value;
        option.text = opciones[i].text;
        select.appendChild(option);
    
        // Seleccionar la opción correspondiente al valor de paisCliente
        if (opciones[i].value === provinciaCliente) {
            option.selected = true;
        }
    }
    
    // Agregar el select al elemento deseado en el DOM
    var container = document.getElementById('container-provincia');
    container.appendChild(select);
    
    //funcion actualizar select
    $(document).ready(function() {
      // Función para mostrar u ocultar el select "provincia" según el valor seleccionado del select "pais"
      function mostrarOcultarProvincia() {
        // Obtener el valor seleccionado del select "pais"
        var paisSeleccionado = $('#pais').val();
    
        // Verificar si el valor seleccionado es "ES"
        if (paisSeleccionado === 'ES') {
          // Mostrar el select "provincia" y habilitarlo
          $('#provincia').show().prop('disabled', false);
        } else {
          // Ocultar el select "provincia" y deshabilitarlo
          $('#provincia').hide().prop('disabled', true);
        }
      }
    
      // Llamar a la función cuando se cargue la página y después de un pequeño retraso
      setTimeout(mostrarOcultarProvincia, 100);
    
      // Escuchar los cambios en el select "pais"
      $('#pais').on('change', function() {
        mostrarOcultarProvincia();
      });
    });$(document).ready(function() {
      // Función para mostrar u ocultar el select "provincia" según el valor seleccionado del select "pais"
      function mostrarOcultarProvincia() {
        // Obtener el valor seleccionado del select "pais"
        var paisSeleccionado = $('#pais').val();
    
        // Verificar si el valor seleccionado es "ES"
        if (paisSeleccionado === 'ES') {
          // Mostrar el select "provincia" y habilitarlo
          $('#provincia').show().prop('disabled', false);
        } else {
          // Ocultar el select "provincia" y deshabilitarlo
          $('#provincia').hide().prop('disabled', true);
        }
      }
    
      // Llamar a la función cuando se cargue la página
      mostrarOcultarProvincia();
    
      // Escuchar los cambios en el select "pais"
      $('#pais').on('change', function() {
        mostrarOcultarProvincia();
      });
    });
    </script>
    
    
    
    
                        <div id="container-provincia" class="col-md-4">
                            <label for="provincia">Provincia:</label>
                        </div>
    
                    </div>
    
                    <?php

    echo '<hr>';
    echo '<h6>Producto: </h6>';
                echo '<div class="col-md-4">
                      <label>Producto:</label>
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
                        if ($producto2 == $ID) {
                        echo "<option value='".$producto2."' selected>".$post_title."</option>";
                        } else {
                            echo "<option value='".$ID."'>".$post_title."</option>";
                        }
                  }
                echo '</select>';
                echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Variante del producto (opcional)</label>';
                echo '<input class="form-control" type="text" name="productoVariante" id="productoVariante">';
                echo '</div>';

                $stmt = $conn2->prepare("SELECT MAX(id) AS last_id
                FROM txsxekgr_esinec.wp_wcpdf_invoice_number");
                $stmt->execute(); 
                $data = $stmt->fetchAll();
                foreach($data as $row){
                    $last_id = $row['last_id'];
                    $idInvoice = $last_id + 1;
                }

                echo '<div class="col-md-4">';
                echo '<label>Número de factura (sin escribir ESINEC Y AÑO)</label>';
                echo '<input class="form-control" type="text" name="invoiceNumber" id="invoiceNumber"  value="'.$idInvoice.'">';
                echo '</div>';

                $vatRate = 21;
                $vatAmount = ($importe2 / (100+$vatRate)) * $vatRate;

                $vat_redondeado = ceil($vatAmount * 100) / 100;

                $precio_neto = $importe2 - $vat_redondeado;

                echo '<div class="col-md-4">';
                echo '<label>Importe total (sin IVA)</label>';
                echo '<input class="form-control" type="text" name="orderTotal" id="orderTotal" value="'.$precio_neto.'">';
                echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
                echo '</div>';
                
                echo '<div class="col-md-4">
                <label>Tipo de IVA:</label>
                <select class="form-select" name="orderTax" id="orderTax">';
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='21' selected>21%</option>";
                    echo "<option value='0'>SIN IVA</option>";
                    echo '</select>';
                echo '</div>';

                echo '<div class="col-md-4">
                <label>Tipo de pago:</label>
                <select class="form-select" name="paymentType" id="paymentType">';
                if ($tipoPago2 == 1) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1' selected>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($tipoPago2 == 2) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2' selected>Cash</option>";
                    echo "<option value='3'>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($tipoPago2 == 3) {
                    echo '<option>Selecciona una opción</option>';
                    echo "<option value='1'>Transferencia bancaria</option>";
                    echo "<option value='2'>Cash</option>";
                    echo "<option value='3' selected>Stripe - tarjeta</option>";
                    echo "<option value='4'>Paypal</option>";
                    echo '</select>';
                } elseif ($tipoPago2 == 4) {
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
                
                echo '<hr>';
                echo '<h6>Datos factura:</h6>';
                
                echo '<div class="col-md-4">';
                echo '<label>Fecha del pago</label>';
                echo '<input class="form-control" type="date" name="date" id="date" value="'.$fecha2.'">';
                echo '</div>';
    
                echo '<div class="col-md-4">';
                echo '<label>Número del pago (sólo número entre 1-12)</label>';
                echo '<input class="form-control" type="text" name="numPago2" id="numPago2" value="'.$numPago2.'">';
                echo '</div>';
    
                echo '<div class="col-md-4">
                <label>Estado:</label>
                <select class="form-select" name="status" id="status">';
                    echo '<option value="">Selecciona una opción</option>';
                    echo "<option value='1'>Pendiente de pago</option>";
                    echo "<option value='2' selected>Pagado</option>";
                    echo "<option value='3'>Factura cancelada</option>";
                    echo '</select>';
                echo '</div>';

                echo '<div class="col-md-4">';
                echo '<label>Notas factura (opcional)</label>';
                echo '<input class="form-control" type="text" name="notas" id="notas">';
                echo '</div>';

                echo '<hr>';
                echo '<h5>Comisiones</h5>';
                
                echo '<div class="col-md-6">';
                echo '<label>Comisión de captación - Formato: 00,00 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comision1" id="comision1">';
                echo '</div>';

                echo '<div class="col-md-6">';
                echo '<label>Comisionista 1 (opcional)</label>
                <select class="form-select" name="comisionista1" id="comisionista1">';
                echo '<option selected value="">Selecciona un equipo:</option>';
                    $stmt = $conn2->prepare("SELECT id, equipo
                    FROM txsxekgr_intranet.comercialesEquipos
                    ORDER BY equipo ASC");
                    $stmt->execute(); 
                    $data = $stmt->fetchAll();
                    foreach($data as $row){
                        $id = $row['id'];
                        $equipo = $row['equipo'];
                        echo "<option value='".$id."'>".$equipo."</option>";
                    }
                echo '</select>';
                echo '</div>';

                
                echo '<div class="col-md-6">';
                echo '<label>Comisión de cierre - Formato: 00,00 (opcional)</label>';
                echo '<input class="form-control" type="text" name="comision2" id="comision2">';
                echo '</div>';

                echo '<div class="col-md-6">';
                echo '<label>Comisionista 2 (opcional)</label>';
                echo  '<select class="form-select" name="comisionista2" id="comisionista2">';
                echo '<option selected value="">Selecciona un equipo:</option>';
                $stmt = $conn2->prepare("SELECT id, equipo
                FROM txsxekgr_intranet.comercialesEquipos
                ORDER BY equipo ASC");
                $stmt->execute(); 
                $data = $stmt->fetchAll();
                foreach($data as $row){
                    $id = $row['id'];
                    $equipo = $row['equipo'];
                    echo "<option value='".$id."'>".$equipo."</option>";
                }
            echo '</select>';
            echo '</div>';
                
            echo "</form>";
      
        ?>