<?php

# conectare la base de datos
$activePage = "";


echo '<div class="container">';
?>

<div class="container text-center" style="padding:25px;margin-top:25px;margin-bottom:50px;">
    <div class="row">
    <div class="col">
        <a href="<?php echo APP_SERVER;?>/clientes/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>01. Gestión de Clientes</h4></a>
        </div>

        <div class="col">
            <a href="<?php echo APP_SERVER;?>/facturacion/"><img src="<?php echo APP_SERVER;?>/inc/img/accounting.png" alt="Facturación" width="64" height="64" >
            <h4>02. Facturación</h4></a>
        </div>

        <div class="col">
        <a href="<?php echo APP_SERVER;?>/proveedores"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Proveedores" width="64" height="64">
            <h4>03. Proveedores</h4></a>
        </div>

    </div>


    <div class="row" style="margin-top:55px;">
    <div class="col">
        <a href="<?php echo APP_SERVER;?>/cursos/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>04. Registro inscripción cursos</h4></a>
        </div>
        
        <div class="col">
        <a href="<?php echo APP_SERVER;?>/facturacion/pagos-programados/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>05. Registro pagos programados</h4></a>
        </div>
       

    </div>

    <div class="row" style="margin-top:55px;">
    <div class="col">
        <a href="<?php echo APP_SERVER;?>/comerciales/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>06. Añadir/modificar comerciales</h4></a>
        </div>
        
    
    </div>


</div>

<?php
# footer
require_once(APP_ROOT . '/inc/footer.php');
