<?php

# conectare la base de datos
$activePage = "";


echo '<div class="container">';
?>

<div class="container text-center" style="margin-bottom:50px">
    
    <div class="row" style="margin-top:55px;background-color:#C1C1C1;padding:25px;border:1px solid black;">
        <h2>01. Gestión de Clientes</h2>
        <div class="col">
            <a href="<?php echo APP_SERVER;?>/clientes/alta"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
                <h4>01. Alta nuevo cliente</h4></a>
            </div>

            <div class="col">
            <a href="<?php echo APP_SERVER;?>/clientes/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
                <h4>02. Listado completo de clientes</h4></a>
            </div>

        </div>

        <div class="row" style="margin-top:55px;background-color:#C1C1C1;padding:25px;border:1px solid black;">
        <h2>02. Facturación</h2>
        <div class="col">
            <a href="<?php echo APP_SERVER;?>/facturacion/"><img src="<?php echo APP_SERVER;?>/inc/img/accounting.png" alt="Facturación" width="64" height="64" >
            <h4>01. Facturación</h4></a>
        </div>

        </div>

    <div class="row" style="margin-top:55px;background-color:#C1C1C1;padding:25px;border:1px solid black;">
    <h2>03. Gestión de cursos</h2>
    <div class="col">
        <a href="<?php echo APP_SERVER;?>/cursos/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>04. Registro inscripción cursos</h4></a>
        </div>
        
        <div class="col">
        <a href="<?php echo APP_SERVER;?>/facturacion/pagos-programados/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>05. Registro pagos programados</h4></a>
        </div>
       

    </div>

    <div class="row" style="margin-top:55px;background-color:#C1C1C1;padding:25px;border:1px solid black;">
    <h2>04. Comerciales</h2>
    <div class="col">
        <a href="<?php echo APP_SERVER;?>/comerciales/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>06. Añadir/modificar comerciales</h4></a>
        </div>
        
    </div>


</div>

<?php
# footer
require_once(APP_ROOT . '/inc/footer.php');
