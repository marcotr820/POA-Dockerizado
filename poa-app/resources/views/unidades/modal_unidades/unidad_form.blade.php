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
                    <div class="form-group">
                        <label for="" class="col-form-label"><b>Nombre Unidad: <span
                                    class="text-danger">*</span></b></label>
                        <input type="text" id="nombre_unidad" class="form-control" name="nombre_unidad"
                            data-error="input" placeholder="Nombre unidad..." required>
                        <span class="text-danger" id="nombre_unidad-error" data-error="span"></span>
                    </div>

                    <div class="form-group">
                        <label for=""><b>Gerencia: <span class="text-danger">*</span></b></label>
                        <select id="gerencia_id" class="form-control custom-select" name="gerencia_id"
                            data-error="select" required>
                            <option value="" hidden selected>Seleccione...</option>
                            @foreach ($gerencias as $gerencia)
                                <option style="padding: 5px" value="{{ $gerencia->id }}">
                                    {{ $gerencia->nombre_gerencia }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="gerencia_id-error" data-error="span"></span>
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
