<?php

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";

$url = 'https://esinec.com/wp-json/wc/v3/customers';

$usuario = array(
    'email' => 'prueba@esinec.com',
    'first_name' => 'PruebaUser1',
    'last_name' => 'PruebaUser1',
    'username' => 'nombre_pruena',
    'password' => 'sdfw3r0v@@@ðvfwerªª',
    'role' => 'customer',
    'billing' => array(
        'first_name' => 'PruebaUser1',
        'last_name' => 'PruebaUser1',
        'company' => '',
        'address_1' => 'Dirección',
        'address_2' => '',
        'city' => 'Ciudad',
        'state' => 'Estado',
        'postcode' => 'Código Postal',
        'country' => 'País',
        'email' => 'prueba@esinec.com',
        'phone' => '123456789',
    ),
    'shipping' => array(
        'first_name' => 'PruebaUser1',
        'last_name' => 'PruebaUser1',
        'company' => '',
        'address_1' => 'Dirección',
        'address_2' => '',
        'city' => 'Ciudad',
        'state' => 'Estado',
        'postcode' => 'Código Postal',
        'country' => 'País',
    ),
);

$data = json_encode($usuario);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode(WC_API_KEY . ':' . WC_API_SECRET),
));

$response = curl_exec($ch);

if ($response === false) {
    die('Error al crear el usuario: ' . curl_error($ch));
}

$user = json_decode($response);

if (isset($user->id)) {
    echo 'Usuario creado con éxito. ID: ' . $user->id;
} else {
    echo 'Error al crear el usuario: ' . $response;
}

curl_close($ch);

?>