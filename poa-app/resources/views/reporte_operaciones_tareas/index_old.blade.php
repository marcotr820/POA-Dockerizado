@extends('layouts.plantillabase')
@section('contenido')
    <style>
        table {
            font-size: 0.6rem;
        }

        table th,
        td {
            border: .5px solid #737373;
            padding: 5px;
        }

    </style>
    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <!--token para cambiar de estado-->
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <div class="card">
        <div class="card-header">
            <h6><b>Trabajador:</b> {{ $trabajador->nombre }}</h6>
            <h6 class="m-0"><b>Gerencia:</b> {!! $trabajador->unidad->gerencia->nombre_gerencia !!}</h6>
        </div>
        <div class="card-header">
            Determinacion de operaciones y tareas<a href="{{ route('operaciones_tareas_pdf', $trabajador) }}"
                class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-file-pdf"></i> Generar PDF</a>
        </div>
        <div class="card-body p-2">
            <table width="100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                        <th>ACCION CORTO PLAZO</th>
                        <th>OPERACIONES</th>
                        <th>ACTIVIDADES</th>
                        <th>TAREAS ESPECIFICAS</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($trabajador->corto_plazo_acciones as $corto_plazo_accion)
                        <tr>
                            <td
                                rowspan="{{ $corto_plazo_accion->operaciones->count() +$corto_plazo_accion->actividades->count() +$corto_plazo_accion->tareas_especificas->count() +1 }}">
                                {{ $corto_plazo_accion->accion_corto_plazo }}->{{ $corto_plazo_accion->id }}
                            </td>
                        </tr>
                        @foreach ($corto_plazo_accion->operaciones as $operacion)
                            <tr>
                                <td
                                    rowspan="{{ $operacion->actividades->count() + $operacion->tareas_especificas->count() + 1 }}">
                                    {{ $operacion->tareas_especificas->count() }}***{{ $operacion->nombre_operacion }}->{{ $operacion->id }}
                                </td>
                            </tr>
                            @foreach ($operacion->actividades as $actividad)
                                <tr>
                                    <td rowspan="{{ $actividad->tareas_especificas->count() + 1 }}">
                                        {{ $actividad->nombre_actividad }}->{{ $actividad->id }}
                                    </td>
                                </tr>
                                @foreach ($actividad->tareas_especificas as $tarea_especifica)
                                    <tr>
                                        <td rowspan="">
                                            {{ $tarea_especifica->nombre_tarea }}->{{ $tarea_especifica->id }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach

                    @empty
                        <tr>
                            <td colspan="5">El Trabajador No Cuenta con registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('libs/js/estado_trabajadores.js') }}"></script>
@endsection
