<?php
echo '<div class="container">';
echo '<h1>Gestión de Clientes</h1>';
echo '<h2>Clientes de ESINEC</h2>';

echo "<a href='https://esinec.com/wp-admin/user-new.php' role='button' aria-pressed='true' target='_blank' class='btn btn-success btn-sm'>Dar de alta nuevo cliente</a>";

echo "<hr>";

    echo '<div class="'.TABLE_DIV_CLASS.'">';
    echo '<table class="table table-striped datatable" id="clientesFactura">
        <thead class="'.TABLE_THREAD.'">
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Ciudad</th>
            <th>Teléfono</th>
            <th>Actualizar datos</th>
            <th>Ver facturas</th>
    </tr>
    </thead>
    <tbody>
    <tr>
       
    </tr>
 </tbody>
    </table>
    </div>
    
</div>';

//include_once('modals-clientes.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');