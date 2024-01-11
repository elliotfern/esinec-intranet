<?php

$url_server = "https://" . $_SERVER['HTTP_HOST'];

echo '<div class="container">';
echo '<h1>Facturación</h1>';
echo '<h2>Registro de pagos programados por clientes</h2>';

echo '<p><a href="'.$url_server.'/facturacion/pagos-programados/mensuales"><button type="button" id="btnPagosMensuales" class="btn btn-sm btn-primary">Ver pagos mensuales</button></a></p>';

echo "<hr>";

    echo '<div class="'.TABLE_DIV_CLASS.'">';
    echo '<table class="table table-striped datatable" id="pagosProgramadosClientes">
        <thead class="'.TABLE_THREAD.'">
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Total pendiente</th>
            <th></th>
    </tr>
    </thead>
    <tbody>
    <tr>
       
    </tr>
 </tbody>
    </table>
    </div>
    
</div>';

# footer
include_once(APP_ROOT. '/inc/footer.php');