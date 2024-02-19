<div class="modal fade animado" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- OVERLAY --}}
            <div class="overlay">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            {{--  --}}
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Estado Acción Corto Plazo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="" id="form">
                @csrf
                <div class="modal-body">
                    <div>
                        <label class="m-0">
                            <strong>Accion corto plazo:</strong>
                        </label>
                        <p id="accion_corto_plazo"></p>
                        <label class="m-0">
                            <strong>Presupuesto Programado:</strong>
                        </label>
                        <p><span id="presupuesto_accion"></span> Bs.</p>
                    </div>
                    <div class="form-group">
                        <label>
                            <strong>Cambiar Estado Accion corto plazo:</strong>
                        </label>
                        <select name="status" id="status" class="form-control">
                            <option value="editar">Editar Presupuesto</option>
                            <option value="presentado">Presentado</option>
                            <option value="aprobado">Aprobar Presupuesto</option>
                            <option value="monitoreo">Solo Monitoreo</option>
                        </select>
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
