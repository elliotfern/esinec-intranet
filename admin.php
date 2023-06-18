<?php
echo '<div class="container">';
?>

<div class="container text-center" style="margin-bottom:50px">
    
    <div class="row" style="margin-top:55px;background-color:#C1C1C1;padding:25px;border:1px solid black;">
        <h2><a href="<?php echo APP_SERVER;?>/clientes/">01. Gestión de Clientes</a></h2>
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
        <h2> <a href="<?php echo APP_SERVER;?>/facturacion/">02. Facturación</a></h2>
        <div class="col">
            <a href="<?php echo APP_SERVER;?>/facturacion/todos"><img src="<?php echo APP_SERVER;?>/inc/img/accounting.png" alt="Facturación" width="64" height="64" >
            <h4>01. Listado completo de facturas</h4></a>
        </div>

        <div class="col">
        <a href="<?php echo APP_SERVER;?>/facturacion/pagos-programados/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>02. Registro pagos programados</h4></a>
        </div>

        <div class="col">
        <a href="<?php echo APP_SERVER;?>/facturacion/pagos-programados/mensuales/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>03. Registro pagos programados mensuales</h4></a>
        </div>

        </div>

    <div class="row" style="margin-top:55px;background-color:#C1C1C1;padding:25px;border:1px solid black;">
    <h2>03. Gestión de cursos</h2>
    <div class="col">
        <a href="<?php echo APP_SERVER;?>/cursos/"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
            <h4>04. Registro inscripción cursos</h4></a>
        </div>
        
    </div>

    <div class="row" style="margin-top:55px;background-color:#C1C1C1;padding:25px;border:1px solid black;">
    <h2>04. Comerciales / reclutadores</h2>
        <div class="col">
            <a href="<?php echo APP_SERVER;?>/comerciales/listado"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
                <h4>01. Añadir/modificar comerciales</h4></a>
        </div>

        <div class="col">
            <a href="<?php echo APP_SERVER;?>/comerciales/pagos/mensuales"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
                <h4>02. Pago de comisiones a comerciales</h4></a>
        </div>

        <div class="col">
            <a href="<?php echo APP_SERVER;?>/comerciales/reclutadores"><img src="<?php echo APP_SERVER;?>/inc/img/tasks.png" alt="Clientes" width="64" height="64">
                <h4>03. Añadir/modificar reclutadores</h4></a>
        </div>
        
    </div>


</div>

<?php
# footer
require_once(APP_ROOT . '/inc/footer.php');
