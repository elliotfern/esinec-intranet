<?php

$url2 = $_SERVER['SERVER_NAME'];

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
$substring = "/public_html/gestion";
$result = str_replace($substring, "", $rootDirectory);
$path = $result . "/pass/connection.php";
require_once($path);

require_once($rootDirectory . '/inc/variables.php');

if (isset($_POST['idCobro'])) {
    $idCobro = $_POST['idCobro'];
} else {
    $idCobro = $_POST['idCobro'];
}

     ?>
            <div class="alert alert-success" id="EliminarCobroMessageOk" style="display:none;role=alert">
                    <h4 class="alert-heading"><strong><?php echo ADD_OK_MESSAGE_SHORT;?></h4></strong>
                    <h6><?php echo ADD_OK_MESSAGE;?></h6>
                    </div>
            
                    <div class="alert alert-danger" id="EliminarCobroMessageErr" style="display:none;role=alert">
                    <h4 class="alert-heading"><strong><?php echo ERROR_TYPE_MESSAGE_SHORT;?></h4></strong>
                    <h6><?php echo ERROR_TYPE_MESSAGE;?></h6>
                    </div>
            
      <form method="POST" action="" id="modalFormEliminarCobroPendiente" class="row g-3">
     <?php

      echo '<input type="hidden" name="id" id="id" value="'.$idCobro.'">';
      ?>

      <h4>¿Estás seguro que quieres eliminar este cobro pendiente?</h4>

      </form>