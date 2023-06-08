<?php

$submitPage = "";
$messageRequired = "";
$activePage = "";

if ($submitPage === TRUE) {
	$messageRequired = "Required";
}

$activePageClientes = $activePageFacturacion = $activePageProveedores = $activePageAyuda = "";

if ($activePage == "history") {
	$activePageClientes = "active";
} elseif ($activePage == "hispantic") {
	$activePageFacturacion = "active";
} elseif ($activePage == "library") {
	$activePageProveedores = "active";
} elseif ($activePage == "ayuda") {
	$activePageAyuda = "active";
}

echo '
	<div class="text-end">';


	$loggedInUser = ($_SESSION['user']['id']);
	$url = APP_SERVER . "/controller/route.php?type=user&id=" . $loggedInUser;
	//call api
	$input = file_get_contents($url);
	$arr = json_decode($input, true);
	$obj = $arr[0];
	
	$welcome = 'Bienvenido, '.$obj['firstName']. ' '.$obj['lastName'].'';
	echo ''.$welcome.'';
	echo ' | <a href="'.APP_SERVER.'/logout">(Salir)</a>
	</div>

	<div class="container-fluid text-center" style="padding-top:20px;padding-bottom:25px">
		<h1 class="text-center"><a href="'.APP_SERVER.'/admin">Intranet</a></h1>
	</div>
	
	<div class="container-fluid text-center">
		<nav class="navbar navbar-expand-lg bg-body-tertiary text-center" data-bs-theme="dark" style="display:block;margin-top:10px;margin-bottom:35px">
			<button class="navbar-toggler text-center" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon text-center"></span>
			</button>
		<div class="collapse navbar-collapse justify-content-center menuHeader" id="navbarTogglerDemo01">
		<ul class="navbar-nav text-center">
				<li class="nav-item">
					<a class="nav-link '.$activePageClientes.'" id="clientes" href="'.APP_SERVER.'/clientes/">Clientes</a>
				</li>

				<li class="nav-item">
					<a class="nav-link '.$activePageFacturacion.'" id="facturacion" href="'.APP_SERVER.'/facturacion/">Facturación</a>
				</li>

				<li class="nav-item">
					<a class="nav-link '.$activePageProveedores.'" href="'.APP_SERVER.'/proveedores/">Proveedores</a>
				</li>

				<li class="nav-item">
					<a class="nav-link '.$activePageAyuda.'" href="'.APP_SERVER.'/ayuda/">Ayuda</a>
				</li>

				<li class="nav-item">
					
				</li>
			</ul>
		</nav>
	</div>';