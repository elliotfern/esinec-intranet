<!-- Modal Añadir nuevo cobro -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalCrearCobro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!-- div 1 -->
  <div class="modal-dialog modal-xl modal-dialog-scrollable"> <!-- div 2 -->
    <div class="modal-content"> <!-- div 3 -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir nuevo cobro programado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalAddSupplyInvoice"> <!-- div 4 -->

      <?php
        # conectare la base de datos
        global $conn;

        // some action goes here under php              
                    echo '<div class="alert alert-success" id="crearCobroMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="crearCobroMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';
        global $conn2;

            echo '<div class="col-md-4">
                  <label>Cliente:</label>
                  <select class="form-select" name="cliente" id="cliente">';
            echo '<option value="">Selecciona un cliente</option>';
              $stmt = $conn2->prepare("SELECT u.ID, m1.meta_value as first_name, m2.meta_value as last_name
              FROM wp_users u
              JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'first_name'
              JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name'
              WHERE u.ID IN (
                SELECT user_id FROM wp_usermeta
                WHERE meta_key = 'wp_capabilities'
                AND meta_value LIKE '%customer%'
              )
              ORDER BY m2.meta_value ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['ID'];
                  $first_name = $row['first_name'];
                  $last_name = $row['last_name'];
                  if ($customer_id == $ID) {
                      echo "<option value='".$ID."' selected>".$last_name.", ".$first_name."</option>";
                  } else {
                      echo "<option value='".$ID."'>".$last_name.", ".$first_name."</option>";
                  }
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Producto:</label>
                  <select class="form-select" name="producto" id="producto">';
            echo '<option selected value="">Selecciona una opción</option>';
              $stmt = $conn2->prepare("SELECT ID, post_title
              FROM wp_posts
              WHERE post_type = 'product'
              AND post_status = 'publish'
              ORDER BY post_title ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['ID'];
                  $post_title = $row['post_title'];
                  echo "<option value='".$ID."'>".$post_title."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Importe total (sólo número)</label>';
            echo '<input class="form-control" type="text" name="importe" id="importe">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';


            echo '<div class="col-md-4">
            <label>Tipo de pago:</label>
            <select class="form-select" name="tipoPago" id="tipoPago">';
            echo '<option selected value="">Selecciona una opción</option>';
            echo "<option value='1'>Transferencia bancaria</option>";
            echo "<option value='2'>Cash</option>";
            echo "<option value='3'>Stripe - tarjeta</option>";
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Fecha del pago</label>';
            echo '<input class="form-control" type="date" name="fecha" id="fecha">';
            echo '<label style="color:#dc3545;display:none" id="AutCognom1Check">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Número del pago (sólo número entre 1-12)</label>';
            echo '<input class="form-control" type="text" name="numPago" id="numPago">';
            echo '<label style="color:#dc3545;display:none" id="AutCognom1Check">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
            <label>Estado:</label>
            <select class="form-select" name="estado" id="estado">';
            echo '<option selected value="">Selecciona una opción</option>';
            echo "<option value='1'>Pendiente de pago</option>";
            echo "<option value='2'>Pagado</option>";
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';
            
        echo "</form>";
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnCrearCobro" class="btn btn-primary">Añadir cobro</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Añadir nueva inscripcion -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalCrearInscripcion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir nueva inscripción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalAddSupplyInvoice">

      <?php
        # conectare la base de datos
        global $conn;
        // some action goes here under php                
                    echo '<div class="alert alert-success" id="nuevaInscripcionMessageOk" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ADD_OK_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ADD_OK_MESSAGE.'</h6>
                    </div>';
            
                    echo '<div class="alert alert-danger" id="nuevaInscripcionMessageErr" style="display:none;role="alert">
                    <h4 class="alert-heading"><strong>'.ERROR_TYPE_MESSAGE_SHORT.'</h4></strong>
                    <h6>'.ERROR_TYPE_MESSAGE.'</h6>
                    </div>
                    ';

        echo '<form method="POST" action="" id="modalFormAddSupplyCompanny" class="row g-3">';
        global $conn2;

            echo '<div class="col-md-4">
                  <label>Cliente:</label>
                  <select class="form-select" name="cliente" id="cliente">';
            echo '<option value="">Selecciona un cliente</option>';
              $stmt = $conn2->prepare("SELECT u.ID, m1.meta_value as first_name, m2.meta_value as last_name
              FROM wp_users u
              JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'first_name'
              JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name'
              WHERE u.ID IN (
                SELECT user_id FROM wp_usermeta
                WHERE meta_key = 'wp_capabilities'
                AND meta_value LIKE '%customer%'
              )
              ORDER BY m2.meta_value ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['ID'];
                  $first_name = $row['first_name'];
                  $last_name = $row['last_name'];
                  if ($customer_id == $ID) {
                      echo "<option value='".$ID."' selected>".$last_name.", ".$first_name."</option>";
                  } else {
                      echo "<option value='".$ID."'>".$last_name.", ".$first_name."</option>";
                  }
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Código producto inscripción:</label>
                  <select class="form-select" name="codigo" id="codigo">';
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

            echo '<div class="col-md-4">
            <label>Edición curso</label>
            <select class="form-select" name="edicion" id="edicion">';
            echo '<option selected value="">Selecciona una opción</option>';
            global $conn;
            $stmt = $conn->prepare("SELECT id, edicion
              FROM edicionCurso
              ORDER BY edicion ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['id'];
                  $edicion = $row['edicion'];
                  echo "<option value='".$ID."'>".$edicion."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Asistencia (opcional)</label>';
            echo '<input class="form-control" type="text" name="asistencia" id="asistencia">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Importe total (sólo número)</label>';
            echo '<input class="form-control" type="text" name="importeTotal" id="importeTotal">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Comercial captación (opcional)</label>
                  <select class="form-select" name="captacionComercial" id="captacionComercial">';
            echo '<option selected value="">Selecciona una opción</option>';
             global $conn;
             $stmt = $conn->prepare("SELECT id, comercial
              FROM comercial
              ORDER BY comercial ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID = $row['id'];
                  $comercial = $row['comercial'];
                  echo "<option value='".$ID."'>".$comercial."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">
                  <label>Comercial cierre (opcional)</label>
                  <select class="form-select" name="comercialCierre" id="comercialCierre">';
            echo '<option selected value="">Selecciona una opción</option>';
             global $conn;
             $stmt = $conn->prepare("SELECT id, comercial
              FROM comercial
              ORDER BY comercial ASC");
              $stmt->execute(); 
              $data = $stmt->fetchAll();
              foreach($data as $row){
                  $ID2 = $row['id'];
                  $comercial2 = $row['comercial'];
                  echo "<option value='".$ID2."'>".$comercial2."</option>";
              }
            echo '</select>';
            echo '<label style="color:#dc3545;display:none" id="countryCheck">* Missing data</label>';
            echo '</div>';

            echo '<div class="col-md-4">';
            echo '<label>Notas (opcional)</label>';
            echo '<input class="form-control" type="text" name="notas" id="notas">';
            echo '<label style="color:#dc3545;display:none" id="AutNomCheck">* Invalid data</label>';
            echo '</div>';

        echo "</form>";
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnNuevaInscripcion" class="btn btn-primary">Añadir inscripción</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal MODIFICAR INSCRIPCION -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalModificaInscripcion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar datos de inscripción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalModificarInscripcion">

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnModificarInscripcion" class="btn btn-primary">Modificar inscripción</button>
       </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal MODIFICAR PAGO -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="btnModificaPagos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar datos de pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalModificarPago">

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnModificarPago" class="btn btn-primary">Modificar pago</button>
       </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal BOTON PAGO "COBRADO" - ACTUALIZANDO DATOS -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="actualizarPago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex align-items-center justify-content-center" id="bodyModalModificarPago">

      <h5>Actualizando el estado del pago</h5>
      <p><img src="<?php echo APP_SERVER;?>/inc/img/loading.gif" alt="Cargando" width="64" height="64" ></p>
      </div>

    </div>
  </div>
</div>

<!-- Modal CREAR FACTURA INTRANET -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalCrearFacturaIntranet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear factura en Intranet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalCrearFactura">

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnCrearFacturaIntranet" class="btn btn-primary">Crear factura</button>
       </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal MODIFICAR FACTURA INTRANET -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalModificarFactura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar factura en Intranet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalModificarFactura">

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnModificarFacturaIntranet" class="btn btn-primary">Modificar factura</button>
       </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal MODIFICAR DATOS CLIENTE -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalModificarDatosCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar datos cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalModificarCliente">

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnModificarDatosCliente" class="btn btn-primary">Modificar cliente</button>
       </form>
      </div>
    </div>
  </div>
</div>