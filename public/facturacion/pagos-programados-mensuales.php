<?php

$url_server = "https://" . $_SERVER['HTTP_HOST'];

echo '<div class="container">';
echo '<h1>Facturación</h1>';
echo '<h2>Registro de pagos programados por meses</h2>';

echo "<hr>";

    echo '<div class="'.TABLE_DIV_CLASS.'">';
    echo '<table class="table table-striped datatable" id="pagosProgramadosClientesMensuales">
        <thead class="'.TABLE_THREAD.'">
        <tr>
            <th>Mes</th>
            <th>Núm. pagos</th>
            <th>Total pagos mes</th>
            <th>Total pagos pendientes</th>
            <th>Total pagos cobrados</th>
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