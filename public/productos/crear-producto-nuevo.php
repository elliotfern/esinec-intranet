<?php

// Datos de autenticación de la API de WooCommerce
$consumer_key = 'TU_CONSUMER_KEY';
$consumer_secret = 'TU_CONSUMER_SECRET';

// URL de la tienda WooCommerce
$store_url = 'https://tu-tienda.com';

// Datos del nuevo producto
$product_data = array(
    'name' => 'Nuevo Producto',
    'type' => 'simple',
    'regular_price' => '9.99',
    'description' => 'Descripción del producto',
    'short_description' => 'Breve descripción del producto',
    'categories' => array(
        array('id' => 9)
    ),
    'images' => array(
        array('src' => 'http://ejemplo.com/imagen.jpg')
    )
);

// Crear el producto utilizando la API de WooCommerce
$response = create_product($consumer_key, $consumer_secret, $store_url, $product_data);

// Función para crear un producto utilizando la API de WooCommerce
function create_product($consumer_key, $consumer_secret, $store_url, $product_data) {
    $url = $store_url . '/wp-json/wc/v3/products';

    // Datos del producto en formato JSON
    $data = json_encode($product_data);

    // Configurar la solicitud HTTP
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => $data,
            'ignore_errors' => true
        )
    );
    $context = stream_context_create($options);

    // Autenticación básica con el token de acceso
    $auth = base64_encode($consumer_key . ':' . $consumer_secret);
    $headers = array(
        'Authorization: Basic ' . $auth
    );

    // Realizar la solicitud POST
    $response = file_get_contents($url, false, $context);

    // Obtener los encabezados de respuesta
    $response_headers = $http_response_header;

    // Obtener el código de respuesta HTTP
    $http_code = $response_headers[0];

    // Devolver la respuesta y el código de respuesta HTTP
    return array(
        'response' => $response,
        'http_code' => $http_code
    );
}

// Imprimir la respuesta y el código de respuesta HTTP
echo "Respuesta: " . $response['response'] . "<br>";
echo "Código de respuesta HTTP: " . $response['http_code'];

?>