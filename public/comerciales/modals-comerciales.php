<!-- Modal MODIFICAR COMERCIAL -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalModificaComercial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar comercial</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalModificarComercial">

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnModificarComercial" class="btn btn-primary">Modificar comercial</button>
       </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Añadir nuevo COMERCIAL -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalInsertComercial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!-- div 1 -->
  <div class="modal-dialog modal-xl modal-dialog-scrollable"> <!-- div 2 -->
    <div class="modal-content"> <!-- div 3 -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir nuevo comercial</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalAddSupplyInvoice"> <!-- div 4 -->

      <?php
        # conectare la base de datos
        global $conn;

        // some action goes here under php              
                    echo '<div class="alert alert-success" id="crearComercialMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="crearComercialMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';

            echo '<div class="col-md-4">';
            echo '<label>Comercial:</label>';
            echo '<input class="form-control" type="text" name="comercial2" id="comercial2">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';
            
        echo "</form>";
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnCrearComercial" class="btn btn-primary">Añadir comercial</button>
      </div>
    </div>
  </div>
</div>