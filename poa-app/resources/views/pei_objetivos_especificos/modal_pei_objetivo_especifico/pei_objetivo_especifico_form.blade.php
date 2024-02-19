<div class="modal fade animado" id="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        {{-- OVERLAY --}}
        <div class="overlay">
          <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
      {{--  --}}
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="" method="" id="form" autocomplete="off">  
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="" class="col-form-label"><b>Acción Institucional Especifica <span class="text-danger">*</span></b></label>
              <textarea name="objetivo_institucional" data-error="textarea" id="objetivo_institucional" class="form-control" rows="3" required></textarea>
              <span class="text-danger" data-error="span" id="objetivo_institucional-error"></span>
            </div>

            <div class="form-group">
              <label for=""><b>Ponderacion (%)<span class="text-danger">*</span></b></label>
              <input type="number" data-error="input" class="form-control" name="ponderacion" id="ponderacion" required>
              <span class="text-danger" data-error="span" id="ponderacion-error"></span>
            </div>

            <div class="form-group">
              <label for=""><b>Indicador de proceso <span class="text-danger">*</span></b></label>
              {{-- <input type="text" data-error="input" class="form-control" name="indicador_proceso" id="indicador_proceso"> --}}
              <textarea data-error="textarea" class="form-control" name="indicador_proceso" id="indicador_proceso" rows="3" required></textarea>
              <span class="text-danger" data-error="span" id="indicador_proceso-error"></span>
            </div>

            <div class="form-group">
              <label for=""><b>Gerencia Responsable <span class="text-danger">*</span></b></label>
              <select id="gerencia_id" data-error="select" name="gerencia_id" class="form-control custom-select" required>
                  <option value="">Seleccione...</option>
                  @foreach ($gerencias as $gerencia)
                  <option value="{{$gerencia->id}}">{{$gerencia->nombre_gerencia}}</option>
                  @endforeach
              </select>
              <span class="text-danger" data-error="span" id="gerencia_id-error"></span>  
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
            ¿Esta seguro de eliminar a <b><span class="message bg-light text-danger p-1"></span></b>? ¡Una vez eliminado, se perderá para siempre!
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