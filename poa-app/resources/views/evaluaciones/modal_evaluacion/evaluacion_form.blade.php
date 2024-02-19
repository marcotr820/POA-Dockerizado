<div class="modal fade animado" id="modal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
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

            <form action="" method="POST" id="form" autocomplete="off">
                @csrf   @method('POST')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div>
                                    <p><b>Accion corto plazo:</b> {!! $corto_plazo_accion->accion_corto_plazo !!}</p>
                                    <p><b>Presupuesto Aprobado:</b> {!! number_format($corto_plazo_accion->presupuesto_programado, 2, '.', ',') !!} Bs.</p>
                                </div>
                                <hr>
                                <p><b>Evaluacion Avance <span class="bg-light p-1 border border-dark rounded">{{ ucfirst( str_replace("_", " ", $trimestre) ) }}</span></b></p>
                                <div class="form-row">
                                    <div class="form-group col-md-6 m-0">
                                      <label><b>Resultado Esperado</b></label>
                                      <input class="form-control" value="{{ $resultado_esperado }}%" disabled>
                                    </div>
                                    <div class="form-group col-md-6 m-0">
                                      <label><b>Resultado Logrado</b></label>
                                      <input type="number" class="form-control" data-error="input" name="resultado_logrado" id="resultado_logrado" placeholder="resultado logrado..." required>
                                      <span class="text-danger" data-error="span" id="resultado_logrado-error"></span>
                                    </div>
                                </div>

                                <hr class="mb-2">

                                <p><b>Evaluacion Presupuesto <span class="bg-light p-1 border border-dark rounded">{{ ucfirst( str_replace("_", " ", $trimestre) ) }}</span></b></p>
                                <div class="form-row">
                                    {{-- <div class="form-group col-md-6 m-0">
                                        <label><b>Presupuesto Restante</b></label>
                                        <input type="number" class="form-control" value="{{ $presupuesto_restante }}" data-restante="" disabled>
                                    </div> --}}
                                    <div class="form-group col-md-12 m-0">
                                        <label><b>Presupuesto Ejecutado</b></label>
                                        <input type="number" class="form-control" data-error="input" name="presupuesto_ejecutado" id="presupuesto_ejecutado" placeholder="presupuesto ejecutado..." required>
                                        <span class="text-danger" data-error="span" id="presupuesto_ejecutado-error"></span>
                                    </div>
                                </div>
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
