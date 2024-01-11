<!-- Modal Añadir nuevo cobro --> 
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalCrearCobro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!-- div 1 -->
  <div class="modal-dialog modal-xl modal-dialog-scrollable"> <!-- div 2 -->
    <div class="modal-content"> <!-- div 3 -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir nuevo cobro programado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalAddNuevoCobro"> <!-- div 4 -->

    
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
      <div class="modal-body" id="bodyModalAddNuevoSubscripcion">

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

<!-- Modal ELIMINAR COBRO PENDIENTE -->
<div class="modal fade fade modal-fullscreen-sm-down" data-bs-backdrop="static" id="modalEliminarCobroPendiente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar cobro pendiente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bodyModalEliminarCobro">

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnEliminarCobro" class="btn btn-primary">Eliminar cobro</button>
       </form>
      </div>
    </div>
  </div>
</div>