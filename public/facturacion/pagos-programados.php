<?php

echo '<div class="container">';
echo '<h1>Facturación</h1>';
echo '<h2>Registro de pagos programados por clientes</h2>';

echo '<p><button type="button" id="btnModificaInscripcion" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalInsertCurso">Crear nuevo pago programado</button></p>';


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

//include_once('modals-cursos.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');