<style>
  .modal .modal-dialog.modal-xl .modal-content{
    margin-top: -2% !important;
  }
</style>
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

        <form action="" method="" id="form" autocomplete="off">  
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="" class="col-form-label"><b>Nombre Pilar <span class="text-danger">*</span></b></label>
              <textarea data-error="textarea" id="nombre_pilar" class="form-control" name="nombre_pilar" rows="3" placeholder="Descripción pilar..." required></textarea>
              <span class="text-danger" data-error="span" id="nombre_pilar-error"></span>
            </div>

            <div class="row">
              <div class="col">
                <label><b>Codigo Pilar <span class="text-danger">*</span></b></label>
                <input type="text" name="codigo_pilar" id="codigo_pilar" data-error="input" class="form-control" placeholder="Codigo pilar..." required>
                <span class="text-danger" data-error="span" id="codigo_pilar-error"></span>
              </div>
              <div class="col">
                <label><b>Gestion Pilar <span class="text-danger">*</span></b></label>
                <input class="form-control" value="{{ date('Y') + 1}}" data-error="input" type="number" id="gestion_pilar" name="gestion_pilar" placeholder="Gestion pilar..." required>
                <span class="text-danger" data-error="span" id="gestion_pilar-error"></span>
              </div>
            </div>

            {{-- <div class="form-group">
              <label for="" class="col-form-label"><b>Gestion <span class="text-danger">*</span></b></label>
              <input class="form-control" value="{{ date('Y') + 1}}" data-error="input" type="number" id="gestion_pilar" name="gestion_pilar" required>
              <span class="text-danger" data-error="span" id="gestion_pilar-error"></span>
            </div> --}}
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
        <h5 class="modal-title">Borrar Pilar</h5>
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

{{-- ************************************************ modal directriz **************************************************** --}}
<div class="modal fade animado" id="modal_directriz" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
     <div class="modal-header p-1">
        <h5 class="modal-title">Reporte PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
        </button>
     </div>

     <div class="modal-body p-0">
        {{-- <iframe id="iframe_pdf" width="100%" height="600px"></iframe> --}}
        <embed type="application/pdf" id="iframe_pdf" width="100%" style="height: 90vh">
     </div>

    </div>
  </div>
</div>