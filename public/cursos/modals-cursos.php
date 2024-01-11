<!-- Modal MODIFICAR EDICION -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalModificaEdicion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar datos de edición</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalModificarEdicion">

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnModificarEdicion" class="btn btn-primary">Modificar edición</button>
       </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Añadir nuevo CURSO -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalInsertCurso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!-- div 1 -->
  <div class="modal-dialog modal-xl modal-dialog-scrollable"> <!-- div 2 -->
    <div class="modal-content"> <!-- div 3 -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir nuevo código de curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalAddSupplyInvoice"> <!-- div 4 -->

      <?php
        # conectare la base de datos
        global $conn;

        // some action goes here under php              
                    echo '<div class="alert alert-success" id="crearCodigoMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="crearCodigoMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';

            echo '<div class="col-md-4">';
            echo '<label>Código del curso</label>';
            echo '<input class="form-control" type="text" name="codigo" id="codigo">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';
            
        echo "</form>";
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnCrearCodigo" class="btn btn-primary">Añadir código</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Añadir nueva EDICION curso -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalInsertEdicion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!-- div 1 -->
  <div class="modal-dialog modal-xl modal-dialog-scrollable"> <!-- div 2 -->
    <div class="modal-content"> <!-- div 3 -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir nueva Edición de curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalAddSupplyInvoice"> <!-- div 4 -->

      <?php
        # conectare la base de datos
        global $conn;

        // some action goes here under php              
                    echo '<div class="alert alert-success" id="crearEdicionMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="crearEdicionMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';

            echo '<div class="col-md-4">
                  <label>Código producto inscripción:</label>
                  <select class="form-select" name="curso" id="curso">';
            echo '<option selected value="">Selecciona una opción</option>';
             global $conn;
             $stmt = $conn->prepare("SELECT id, codigo
              FROM codigoCurso
              ORDER BY codigo ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['id'];
                  $codigo = $row['codigo'];
                  echo "<option value='".$ID."'>".$codigo."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Edición del curso</label>';
            echo '<input class="form-control" type="text" name="edicion" id="edicion">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';
            
        echo "</form>";
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnCrearEdicion" class="btn btn-primary">Añadir edición</button>
      </div>
    </div>
  </div>
</div>
