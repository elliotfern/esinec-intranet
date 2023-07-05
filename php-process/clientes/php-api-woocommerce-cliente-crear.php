<?php

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once( $rootDirectory . "/inc/php/functions.php");


  // insert data to db  
    if (empty($_POST["first_name"])) {
        $hasError = true;
      } else {
        $first_name = data_input($_POST['first_name']);
    }

    if (empty($_POST["last_name"])) {
        $hasError = true;
      } else {
        $last_name = data_input($_POST['last_name']);
    }

    if (empty($_POST["address_1"])) {
        $hasError = true;
      } else {
        $address = data_input($_POST['address_1']);
    }

    if (empty($_POST["city"])) {
        $hasError = true;
      } else {
        $city = data_input($_POST['city']);
    }

    if (empty($_POST["state"])) {
        $hasError = true;
      } else {
        $state = data_input($_POST['state']);
    }

    if (empty($_POST["country"])) {
        $hasError = true;
      } else {
        $country = data_input($_POST['country']);
    }

    if (empty($_POST["postcode"])) {
        $postcode = "";
      } else {
        $postcode = data_input($_POST['postcode']);
    }

    if (empty($_POST["phone"])) {
        $phone = "";
      } else {
        $phone = data_input($_POST['phone']);
    }

    if (empty($_POST["email"])) {
        $hasError = true;
      } else {
        $email = data_input($_POST['email']);
    }

    if (empty($_POST["_billing_nif"])) {
        $billing_nif = "";
      } else {
        $billing_nif = data_input($_POST['_billing_nif']);
    }


// Definir la URL de la API de WooCommerce y las credenciales de autenticación
$url = 'https://esinec.com/wp-json/wc/v3/customers/';

function generarPassword($longitud = 8) {
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';

    $max = strlen($caracteres) - 1;

    for ($i = 0; $i < $longitud; $i++) {
        $index = mt_rand(0, $max);
        $password .= $caracteres[$index];
    }

    return $password;
}

function unirNombres($firstName, $lastName) {
    // Eliminar espacios y caracteres especiales del first name
    $firstName = preg_replace('/[^A-Za-z0-9]/', '', $firstName);
    
    // Eliminar espacios y caracteres especiales del last name
    $lastName = preg_replace('/[^A-Za-z0-9]/', '', $lastName);
    
    // Convertir a minúsculas
    $firstName = strtolower($firstName);
    $lastName = strtolower($lastName);
    
    // Unir los nombres sin espacios
    $nombreCompleto = $firstName . $lastName;
    
    return $nombreCompleto;
}

$nombreCompleto = unirNombres($first_name, $last_name);

// Generar una contraseña de longitud 10
$contrasena = generarPassword(10);

// Datos actualizados del usuario
$usuario = array(
    'first_name' => $first_name,
    'last_name' => $last_name,
    'username' => $nombreCompleto,
    'password' => $contrasena,
    'email' => $email,
    'role' => 'customer',
    'billing' => array(
        'first_name' => $first_name,
        'last_name' => $last_name,
        'address_1' => $address,
        'city' => $city,
        'state' => $state,
        'country' => $country,
        'postcode' => $postcode,
        'phone' => $phone,
        'email' => $email,          
    ),
    'meta_data' => array(
        array(
            'key' => 'billing_nif',
            'value' => $billing_nif
        )
    )
);

if (!isset($hasError)) {
    // Convertir el arreglo en formato JSON
    $data = json_encode($usuario);

    // Claves de API de WooCommerce
    $consumer_key = WC_API_KEY;
    $consumer_secret = WC_API_SECRET;

    // Configurar la solicitud cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(WC_API_KEY . ':' . WC_API_SECRET),
    ));

    // Realizar la solicitud cURL
    $response = curl_exec($ch);

    if ($response === false) {
        $response = array(
            'status' => 'error',
            'message' => curl_error($ch)
        );
    } else {
        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode === 200 || $httpCode === 201) {
            $response = array(
                'status' => 'success',
                'message' => 'Cliente dado de alta exitosamente'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Error al dar de alta el cliente: ' . $httpCode
            );
        }
    }

    // Cerrar la sesión cURL
    curl_close($ch);
} else {
    // response output - data error
    $response = array(
        'status' => 'error',
        'message' => 'Datos incompletos o inválidos'
    );
}

header("Content-Type: application/json");
echo json_encode($response);
?>