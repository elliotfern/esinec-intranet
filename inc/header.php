<?php

session_start();
if(!isset($_SESSION['user'])):
	header('Location: '.APP_ROOT.' /login');
	exit();
endif;

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
        $substring = "/public_html/gestion";
        $result = str_replace($substring, "", $rootDirectory);
        $path = $result . "/pass/connection.php";
        require_once($path);

require_once(APP_ROOT . '/inc/functions.php');
require_once(APP_ROOT . '/inc/header_html.php');
require_once(APP_ROOT . '/inc/header_nav.php');