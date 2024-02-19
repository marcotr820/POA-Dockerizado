<div class="modal fade animado" id="modal" data-backdrop="static" data-keyboard="false" tabindex="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{--  --}}
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

            <form action="" method="POST" id="form" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><b>Nombre Rol <span class="text-danger">*</span></b></label>
                        <input type="text" class="form-control" data-error="input" id="nombre_rol" name="nombre_rol"
                            placeholder="ingrese el nombre del rol..." required>
                        <span class="text-danger" data-error="span" id="nombre_rol-error"></span>
                    </div>

                    <div class="form-group">
                        <label for=""><b>Lista Permisos <span class="text-danger">*</span></b></label>
                        <span class="text-danger" data-error="span" id="permisos-error"></span>
                        @foreach ($permisos as $permiso)
                            <div>
                                <label>
                                    <input type="checkbox" class="mr-1" name="permisos[]"
                                        value="{{ $permiso->id }}" data-permiso="permiso{{ $permiso->id }}">
                                    <span style="color: black">{{ $permiso->name }}</span>
                                </label>
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
                <h5 class="modal-title">Borrar Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="" id="form_delete">
                @csrf
                <div class="modal-body p-3">
                    <div>
                        ¿Esta seguro de eliminar a <b><span class="message bg-light text-danger p-1"></span></b>? ¡Una
                        vez eliminado, se perderá para siempre!
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
