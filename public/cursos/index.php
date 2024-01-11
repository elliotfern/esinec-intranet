<?php
# conectar la base de datos
$activePage = "clientes";
global $conn;

echo '<div class="container">';
echo '<h1>Gestión de Clientes</h1>';
echo '<h2>Registro de inscripción a los cursos de ESINEC</h2>';

echo '<p><button type="button" id="btnModificaInscripcion" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalInsertCurso">Crear nuevo código de curso</button></p>';

echo '<p><button type="button" id="btnInsertEdicion" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalInsertEdicion">Crear nueva edición</button></p>';

echo "<hr>";

    echo '<div class="'.TABLE_DIV_CLASS.'">';
    echo '<table class="table table-striped datatable" id="inscripcionCursos">
        <thead class="'.TABLE_THREAD.'">
        <tr>
            <th>Curso/Edición</th>
            <th>Número de inscritos</th>
            <th>Ver inscritos</th>
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

include_once('modals-cursos.php');

# footer
include_once(APP_ROOT. '/inc/footer.php');