<div class="modal fade animado" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{--  --}}
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label"><b>Nombre Permiso: <span class="text-danger">*</span> </b></label>
                                <input class="form-control" data-error="input" name="nombre_permiso"
                                    id="nombre_permiso" placeholder="Ingrese el nombre del permiso..." required>
                                <span class="text-danger" data-error="span" id="nombre_permiso-error"></span>
                            </div>
                        </div>
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
