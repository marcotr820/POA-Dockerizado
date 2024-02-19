@extends('layouts.plantillabase')

@section('title', 'Crear Evaluación')

@section('contenido')
<style>
    table{
        font-size: 12px;
    }
    table td{
        padding: 5px;
        border: 0.5px solid #737373;
    }
</style>
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0" style="font-size: 14px;">
                <tr>
                    <td width="15%" class="font-weight-bold">Acción Corto Plazo</td>
                    <td>{{$corto_plazo_accion->accion_corto_plazo}}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Presupuesto Aprobado:</td>
                    <td>{{ number_format($corto_plazo_accion->presupuesto_programado, 2, '.', ',') }} Bs.</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Fecha Inicio</td>
                    <td>{{ $corto_plazo_accion->fecha_inicio }}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Fecha Fin</td>
                    <td>{{ $corto_plazo_accion->fecha_fin }}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Presupuesto Restante</td>
                    <td>{{ number_format($corto_plazo_accion->presupuesto_programado - $corto_plazo_accion->evaluaciones->sum('presupuesto_ejecutado'), 2, '.', ',') }} Bs.</td>
                </tr>
            </table>
            <div>
                {{-- <a href="{{ route('planificacion_evaluacion') }}" class="boton red"><i class="fas fa-arrow-left"></i> Volver Atrás</a> --}}
                <a href="{{ route('acciones_corto_plazo.evaluacion') }}" class="boton red mt-2"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
            </div>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="m-0">Lista de Evaluaciones</h5>
            {{-- verificamos que estamos dentro de las fechas que tenemos que evaluarnos para mostrar el boton de evaluar --}}
            
            @if (!$corto_plazo_accion->planificacion()->exists())
                <div class="alert alert-danger border-danger m-0" role="alert">
                    Por favor Registre su Planificación.
                </div>
            @endif

            @if (!empty($trimestre))
                {{-- verificamos si la evaluacion ya tiene un registro para no repetir evaluaciones por trimestre --}}
                @if (!$corto_plazo_accion->evaluaciones->where('trimestre', $trimestre)->first())
                    <button type="button" id="nuevo" class="boton blue ml-2"><i class="fas fa-plus"></i> Evaluar</button>
                @endif
            @endif
        </div>
        <div class="card-body">
            <table class="" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        <td rowspan="2" style="text-align: center;" width="13%">Trimestre</td>
                        <td colspan="3" class="text-center">RESULTADOS</td>
                        <td colspan="3" class="text-center">PRESUPUESTO</td>
                        <td>RELACION AVANCE</td>
                        <td rowspan="2" class="text-center">Accion</td>
                        <tr>
                            <td>Esperados</td>
                            <td>Logrados</td>
                            <td>Eficacia %</td>
                            <td>Presupuesto</td>
                            <td>Ejecutado</td>
                            <td>Ejecucion %</td>
                            <td>Avance %</td>
                        </tr>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($corto_plazo_accion->evaluaciones as $evaluacion)
                        <tr>
                            <td>{{ ucfirst( str_replace("_", " ", $evaluacion->trimestre) ) }}</td>
                            <td>{{ $evaluacion->resultado_esperado }}%</td>
                            <td>{{ $evaluacion->resultado_logrado }}%</td>
                            <td>{{ $evaluacion->eficacia }}%</td>
                            <td>{{ number_format($evaluacion->presupuesto, 2, '.', ',') }} Bs.</td>
                            <td>{{ number_format($evaluacion->presupuesto_ejecutado, 2, '.', ',') }} Bs.</td>
                            <td>{{ $evaluacion->ejecucion }}%</td>
                            <td>{{ $evaluacion->relacion_avance }}%</td>
                            @if ($evaluacion->trimestre == $trimestre)
                                <td class="text-center">
                                    <button class="boton blue" data-edit="{{ $evaluacion->uuid }}" onclick="edit('{{ $evaluacion->uuid }}')">Editar</button>
                                </td>
                            @else
                                <td class="text-center text-muted">Evaluado</td>
                            @endif
                        </tr>
                        @if ($loop->last)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><b>Total:</b></td>
                                <td>{{ number_format($corto_plazo_accion->evaluaciones->sum('presupuesto_ejecutado'), 2, '.', ',') }} Bs.</td>
                                <td>{{ $corto_plazo_accion->evaluaciones->sum('ejecucion') }}%</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td class="text-center text-muted" colspan="9">No se encontraron evaluaciones.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('evaluaciones.modal_evaluacion.evaluacion_form')

@endsection

@section('js')
    <script>
        var corto_plazo_accion_uuid = "{{ $corto_plazo_accion->uuid }}";
    </script>
   <script src="{{asset('libs/js/validacionform/evaluacion_validar.js')}}"></script>
@endsection