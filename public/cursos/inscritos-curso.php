<?php

if(isset($params['id'])) {
    $idCurso = $params['id'];
}

echo '<div class="container">';
echo '<h1>Gestión de Clientes</h1>';
echo '<h2>Registro de inscripción curso</h2>';

        //call api
        //read json file from url in php
        $url = APP_SERVER . "/controller/cursos.php?type=curso&id=" .$idCurso;
        $input = file_get_contents($url);
        $arr = json_decode($input, true);
        $vault = $arr[0];

        $edicion2 = $vault['edicion'];
        $curso2 = $vault['codigo'];

echo '<h4>'.$curso2.' '.$edicion2.'</h4>';  
        

echo '<input type="hidden" id="idCurso" name="idCurso" value="'.$idCurso.'">';

echo "<hr>";

    echo '<div class="'.TABLE_DIV_CLASS.'">';
    echo '<table class="table table-striped datatable" id="tablaClientesInscripcionCurso">
        <thead class="'.TABLE_THREAD.'">
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Ver ficha cliente</th>
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