@extends('layouts.plantillabase')

@section('title', 'Ver Evaluación Trabajador')

@section('contenido')
<style>
    table .thead td{
        border: 1px solid #ccc;
        font-size: 10px;
    }
    table tfoot{
        border-top: 1px solid;
        /* border-bottom: 1px solid; */
    }
</style>
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="10%" class="font-weight-bold">Gerencia</td>
                    <td>{{ $trabajador->unidad->gerencia->nombre_gerencia }}</td>
                </tr>
                <tr>
                    <td width="10%" class="font-weight-bold">Unidad</td>
                    <td>{{ $trabajador->unidad->nombre_unidad }}</td>
                </tr>
                <tr>
                    <td width="10%" class="font-weight-bold">Trabajador</td>
                    <td>{{ $trabajador->nombre }}</td>
                </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista de Evaluaciones
            <div>
                <a href="{{ route('estados_trabajadores.index') }}" class="boton red"><i class="fas fa-arrow-left"></i> Volver atras</a>
                {{-- <a href="{{ route('evaluaciones_graficas', $trabajador->uuid) }}" class="boton blue ml-2">Ver Gráficas Resultados</a>
                <a href="{{ route('evaluaciones_presupuesto_graficas', $trabajador->uuid) }}" class="boton purple ml-2">Ver Gráficas Presupuesto</a> --}}
                <a class="boton default ml-2" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fas fa-file-pdf"></i> Generar Reporte</a>
            </div>
        </h5>
        <div class="row m-0">
            <div class="col">
              <div class="collapse multi-collapse" id="multiCollapseExample1">
                <div class="card card-body text-center p-3">
                    <form action="{{ route('reporte_evaluaciones', $trabajador->uuid) }}" target="_blank">
                        @csrf @method('get')
                        <div class="form-group mb-2 row d-flex justify-content-center">
                            <div class="col-xs-2">
                                <label>Seleccione la Gestión.</label>
                                <select class="form-control" name="gestion" id="gestion" required>
                                    <option value="">__Seleccione__</option>
                                    @foreach ($pilares as $p)
                                        <option value="{{ $p->gestion_pilar }}">{{ $p->gestion_pilar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="boton blue">Enviar</button>
                    </form>
                </div>
              </div>
            </div>
        </div>

        <div class="card-body">
            @if (!$corto_plazo_acciones->isEmpty())
                <table id="table" width="100%">
                    <thead hidden>
                        <tr><td></td></tr>
                    </thead>
                    <tbody>
                        @forelse ($corto_plazo_acciones as $cpa)
                            <tr>
                                <td>
                                    <div class="card border border-dark">
                                        <div class="card-header bg-dark text-white p-1 pl-2">
                                            <b>Accion Corto Plazo: </b>{{ $cpa->accion_corto_plazo }}
                                            <p class="m-0">
                                                <b>Fecha Inicio: </b>{{ $cpa->fecha_inicio }} &nbsp;&nbsp; <b>Fecha Fin: </b> {{ $cpa->fecha_fin }} 
                                                &nbsp;
                                                @if ($cpa->evaluaciones()->exists())
                                                    <a href="{{ route('evaluacion_graficas', $cpa->uuid) }}" class="boton default">ver gráficas</a>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="card-body p-0">
                                            @if ($cpa->evaluaciones()->exists())
                                                <table width="100%" class="tabla-evaluacion">
                                                    <thead class="thead">
                                                        <tr>
                                                            <td rowspan="2" style="text-align:center;border-bottom:1px solid;" width="13%">Trimestre</td>
                                                            <td colspan="3" class="text-center">RESULTADOS</td>
                                                            <td colspan="3" class="text-center">PRESUPUESTO</td>
                                                            <td>RELACION AVANCE</td>
                                                            <tr>
                                                                <td style="border-bottom:1px solid;">Esperados</td>
                                                                <td style="border-bottom:1px solid;">Logrados</td>
                                                                <td style="border-bottom:1px solid;">Eficacia %</td>
                                                                <td style="border-bottom:1px solid;">Presupuesto</td>
                                                                <td style="border-bottom:1px solid;">Ejecutado</td>
                                                                <td style="border-bottom:1px solid;">Ejecucion %</td>
                                                                <td style="border-bottom:1px solid;">Avance %</td>
                                                            </tr>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($cpa->evaluaciones as $evaluacion)
                                                            <tr>
                                                                <td class="text-center">{{ ucfirst( str_replace("_", " ", $evaluacion->trimestre) ) }}</td>
                                                                <td>{{ $evaluacion->resultado_esperado }} %</td>
                                                                <td>{{ $evaluacion->resultado_logrado }} %</td>
                                                                <td>{{ $evaluacion->eficacia }} %</td>
                                                                <td>{{ number_format($evaluacion->presupuesto, 2, '.', ',') }} Bs.</td>
                                                                <td>{{ number_format($evaluacion->presupuesto_ejecutado, 2, '.', ',') }} Bs.</td>
                                                                <td>{{ $evaluacion->ejecucion }} %</td>
                                                                <td>{{ $evaluacion->relacion_avance }} %</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td class="text-center"><b>Total</b></td>
                                                            <td>{{ number_format($cpa->evaluaciones->sum('presupuesto_ejecutado'), 2, '.', ',') }} Bs.</td>
                                                            <td>{{ $cpa->evaluaciones->sum('ejecucion') }} %</td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            @else
                                                <div class="alert alert-light text-dark m-0" role="alert">
                                                    Sin evaluaciones.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            @else
                <div class="alert alert-light text-dark m-0 p-0" role="alert">
                    No se encontraron registos.
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                // "lengthMenu": [4, 8, 15, 30],
                "language": {
                    "url" : "{{ asset('libs/datatables/es-ES.json') }}"
                }
            });
        } );
    </script>
@endsection
