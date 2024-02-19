<div class="modal fade animado" id="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        {{-- OVERLAY --}}
        <div class="overlay">
          <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
      {{--  --}}
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="" method="" id="form">  
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="" class="col-form-label"><b>Codigo Resultado <span class="text-danger">*</span></b></label>
              <input type="number" data-error="input" class="form-control" name="codigo_resultado" id="codigo_resultado">
              <span class="text-danger" data-error="span" id="codigo_resultado-error"></span>
            </div>
            <div class="form-group">
              <label for="" class="col-form-label"><b>Nombre Resultado <span class="text-danger">*</span></b></label>
              <textarea name="nombre_resultado" id="nombre_resultado" class="form-control" data-error="textarea" cols="30" rows="3" required></textarea>
              {{-- <input type="text" data-error="input" id="nombre_resultado" class="form-control" name="nombre_resultado" autocomplete="off"> --}}
              <span class="text-danger" data-error="span" id="nombre_resultado-error"></span>

              {{-- <select id="select-textarea" class="form-control">
                <option value="">Seleccione</option>
                <option 
                  value="EL 70% DE LA POBLACION URBANA CUENTA CON SERVICIOS DE ALCANTARILLADO">
                  EL 70% DE LA POBLACION URBANA CUENTA CON SERVICIOS DE ALCANTARILLADO
                </option>
                <option value="asd">asd</option>
              </select> --}}
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
        <h5 class="modal-title">Borrar Meta</h5>
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
          <button type="submit" class="boton red">Borrar</button>
          <button type="button" class="boton default" data-dismiss="modal" id="btncancelar">Cancelar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  document.addEventListener('change', (e)=>{
    if (e.target.matches("#select-textarea")) {
      document.getElementById('nombre_resultado').innerHTML = e.target.value;
    }
  })
</script>