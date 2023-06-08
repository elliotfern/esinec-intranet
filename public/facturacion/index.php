<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '<div class="container">';
echo '<h1>Facturación</h1>';

echo '<ul>';
echo '<li><a href="'.APP_SERVER.'/facturacion/todos">Listado histórico de facturas</a></li>';
echo '</ul>';

echo '</div>';


# footer
include_once(APP_ROOT. '/inc/footer.php');