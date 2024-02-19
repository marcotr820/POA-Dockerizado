<div class="modal fade animado" id="modal" data-backdrop="static" data-keyboard="false" tabindex="" aria-hidden="true">
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

            <div class="modal-body pb-0" data-block="btn">
                <button class="boton red btn-block" id="u_password">Restablecer Password</button>
            </div>

            <form action="" method="POST" id="form" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="col-form-label"><b>Usuario: <span class="text-danger">*</span> </b></label>
                        <select class="form-control select2" data-error="select" id="trabajador_id" name="trabajador_id"
                            style="width:100%;" required>
                            <option value="">seleccione...</option>
                        </select>
                        <span class="text-danger" data-error="span" id="trabajador_id-error"></span>
                    </div>

                    <div class="form-group" data-block="input">
                        <label for="Password"><b>Password: <span class="text-danger">*</span> </b></label>
                        <input class="validacion form-control" data-error="input" type="password" id="password"
                            name="password">
                        <span class="text-danger" data-error="span" id="password-error"></span>
                    </div>

                    <div class="form-group m-0">
                        <label class="d-block m-0"><b>Listado de Roles:</b></label>
                        <span class="text-danger error-text" data-error="span" id="roles-error"></span>
                        @foreach ($roles as $role)
                            <div>
                                <label class="d-block">
                                    <input type="checkbox" data-role="rol{{ $role->id }}" class="mr-1"
                                        name="roles[]" value="{{ $role->id }}">
                                    {{ $role->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnGuardar" class="boton blue">Guardar</button>
                    <button type="button" class="boton default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ******************************************************** MODAL DELETE *********************************************************** --}}
<div class="modal fade animado" id="modal_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Borrar Usuario</h5>
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
                    <button type="submit" class="boton red">Borrar</button>
                    <button type="button" class="boton default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>

        </div>
    </div>
</div>
