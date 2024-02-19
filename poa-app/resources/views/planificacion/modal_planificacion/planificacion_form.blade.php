<div class="modal fade animado" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
        {{-- OVERLAY --}}
        <div class="overlay">
          <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
      {{--  --}}
       <div class="modal-header">
         <h5 class="modal-title text-dark" id="exampleModalLabel"></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>

       <form action="" method="" id="form_planificacion" autocomplete="off">
         @csrf
         <div class="modal-body">
            <div class="alert alert-danger m-0" role="alert">
              <strong>¡¡ Todos los campos deben sumar el 100% !!</strong>
            </div>

            <span class="text-danger error-text" data-error="span" id="error_validacion-error"></span>

            <div class="form-group" id="lista">
              @foreach ($trimestres as $trimestre)
              <div class="form-group">
                <label class="col-form-label"><b>{{ ucfirst( str_replace("_", " ", $trimestre) ) }}</b></label>
                <input class="form-control" data-error="input" name="{{$trimestre}}" id="{{$trimestre}}" placeholder="planificado..." required>
                <span class="text-danger" data-error="span" id="{{$trimestre}}-error"></span>
              </div>
              @endforeach
            </div>
         </div>

         <div class="modal-footer">
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
        <h5 class="modal-title">Borrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="" method="" id="form_delete">  
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