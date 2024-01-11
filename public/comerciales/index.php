<?php
# conectar la base de datos
$activePage = "clientes";
global $conn;

echo '<div class="container">';
echo '<h1>Gestión de Comerciales ESINEC</h1>';

echo '<p><button type="button" id="btnNuevoComercial" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalInsertComercial">Dar de alta nuevo comercial</button></p>';


echo "<hr>";

    echo '<div class="'.TABLE_DIV_CLASS.'">';
    echo '<table class="table table-striped datatable" id="comerciales">
        <thead class="'.TABLE_THREAD.'">
        <tr>
            <th>Comercial</th>
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

include_once('modals-comerciales.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');