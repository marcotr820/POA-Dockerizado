<div class="modal fade animado" id="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
        {{-- OVERLAY MODAL --}}
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
              <label for="" class="col-form-label"><b>Nombre Partida: <span class="text-danger">*</span></b></label>
              <input type="text" id="nombre_partida" name="nombre_partida" data-error="input" class="form-control" required placeholder="Nombre partida...">
              <span class="text-danger" data-error="span" id="nombre_partida-error"></span>
            </div>

            <div class="row">
              <div class="col-md-5">
                  <div class="form-group">
                    <label for=""><b>Codigo Partida: <span class="text-danger">*</span></b></label>
                    <input type="text" id="codigo_partida" name="codigo_partida" data-error="input" class="form-control" required placeholder="Codigo partida...">
                    <span class="text-danger" data-error="span" id="codigo_partida-error"></span>
                  </div>
              </div>

              <div class="col-md-7">
                  <div class="form-group">
                      <label for=""><b>Tipo Partida: <span class="text-danger">*</span></b></label>
                      <select id="tipo_partida" name="tipo_partida" data-error="select" required class="form-control custom-select">
                        <option value="" disabled selected>Seleccione...</option>
                        <option value="FUNCIONAMIENTO">FUNCIONAMIENTO</option>
                        <option value="INVERSIÓN">INVERSIÓN</option>
                      </select>
                      <span class="text-danger" data-error="span" id="tipo_partida-error"></span>
                  </div>
              </div>
            </div> 
          </div>
          <div class="modal-footer">
              <button class="boton blue">Guardar</button>
              <button type="button" class="boton default" data-dismiss="modal" id="btncancelar">Cancelar</button>
          </div>
        </form>

     </div>
   </div>
</div>