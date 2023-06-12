<?php

$url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');

if (isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];
} else {
    $idCliente = $_POST['idCliente'];
}

// Construir la URL de la solicitud
$url = 'https://esinec.com/wp-json/wc/v3/customers/' . $idCliente;

// Configurar la autenticación
$auth = base64_encode(WC_API_KEY . ':' . WC_API_SECRET);

// Configurar la solicitud cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic ' . $auth
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Realizar la solicitud GET
$response = curl_exec($ch);

// Verificar si hubo errores en la solicitud
if (curl_errno($ch)) {
    $error_message = curl_error($ch);
    echo "Error: " . $error_message;
} else {
    // Solicitud exitosa
    $customer_data = json_decode($response);

        // Obtén los datos relevantes del cliente
        $first_name = $customer_data->first_name;
        $last_name = $customer_data->last_name;
        $email = $customer_data->email;
        $phone = $customer_data->phone;
        $address = $customer_data->address_1;
        $city = $customer_data->city;
        $state = $customer_data->state;
        $country = $customer_data->country;
        $postcode = $customer_data->postcode;
        
    // Obtén el valor de "_billing_nif" si existe
    if (isset($customer_data->meta_data)) {
        foreach ($customer_data->meta_data as $meta) {
            if ($meta->key === '_billing_nif') {
                $billing_nif = $meta->value;
                break;
            }
        }
    }

}

 // Mostrar los datos en un formulario para modificar             
                        echo '<div class="alert alert-success" id="modificarCobroMessageOk" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ADD_OK_MESSAGE.'</h6>
                        </div>';
                
                        echo '<div class="alert alert-danger" id="modificarCobroMessageErr" style="display:none;role="alert">
                        <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                        <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                        </div>
                        ';
    
            echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';

            echo '<input type="hidden" name="id2" id="id2" value="'.$id_old.'">';

            echo '<div class="col-md-4">';
            echo '<label>Nombre</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$first_name.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Apellidos</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$last_name.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Dirección postal</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$address.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Ciudad</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$city.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Provincia</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$state.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Código postal (opcional)</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$postcode.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>País</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$country.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Teléfono (opcional)</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$phone.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Email</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$email.'">';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>DNI/NIF/CIF</label>';
            echo '<input class="form-control" type="text" name="asistencia2" id="asistencia2" value="'.$billing_nif.'">';
            echo '</div>';
                
            echo "</form>";
      
        ?>