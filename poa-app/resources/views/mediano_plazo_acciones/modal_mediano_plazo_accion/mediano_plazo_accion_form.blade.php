<div class="modal fade animado" id="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        {{-- OVERLAY --}}
        <div class="overlay">
          <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
      {{--  --}}
        <div class="modal-header p-2">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="" method="" id="form" autocomplete="off">  
          @csrf  
          <div class="modal-body">
            <div class="form-group">
              <label for="" class="col-form-label"><b>Código Acción Mediano Plazo <span class="text-danger">*</span></b></label>
              <input type="number" data-error="input" class="form-control" name="codigo_mediano_plazo" id="codigo_mediano_plazo">
              <span class="text-danger" data-error="span" id="codigo_mediano_plazo-error"></span>
            </div>
            <div class="form-group">
              <label for="" class="col-form-label"><b>Nombre Accion Mediano Plazo <span class="text-danger">*</span></b></label>
              <textarea data-error="textarea" id="accion_mediano_plazo" name="accion_mediano_plazo" class="form-control" rows="3" required></textarea>
              <span class="text-danger" data-error="span" id="accion_mediano_plazo-error"></span>
            </div>
          </div>

          <div class="modal-footer p-2">
            <button type="submit" id="btnGuardar" class="boton blue">Guardar</button>
            <button type="button" class="boton default" data-dismiss="modal" id="btncancelar">Cancelar</button>
          </div>
        </form>

      </div>
    </div>
</div>

{{-- ***************************************** MODAL DELETE ************************************** --}}
<div class="modal fade animado" id="modal_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Borrar Mediano plazo accion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="" method="POST" id="form_delete">  
        @csrf
        <div class="modal-body p-3">
          <div>
            ¿Esta seguro de eliminar a <b><span class="message bg-light text-danger p-1"></span></b> ? ¡Una vez eliminado, se perderá para siempre!
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="confirm_delete" class="boton red">Borrar</button>
          <button type="button" class="boton default" data-dismiss="modal" id="btncancelar">Cancelar</button>
        </div>
      </form>

    </div>
  </div>
</div>