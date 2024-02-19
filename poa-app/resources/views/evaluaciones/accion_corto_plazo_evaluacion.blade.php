@extends('layouts.plantillabase')

@section('title', 'Lista Acciones Evaluación')

@section('contenido')
    <style>
        table{
            font-size: 13px;
        }
    </style>
    <div class="card">
        <h5 class="card-header">Evaluar Acciones Corto Plazo</h5>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="table">
                <thead class="" style="background-color: skyblue">
                    <tr>
                        <th width="55%">ACCION CORTO PLAZO</th>
                        <th width="15%">FECHA INICIO</th>
                        <th width="15%">FECHA FIN</th>
                        <th width="15%">EVALUAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($corto_plazo_acciones as $cpa)
                        <tr>
                            <td>{{ $cpa->accion_corto_plazo }}</td>
                            <td>{{ $cpa->fecha_inicio }}</td>
                            <td>{{ $cpa->fecha_fin }}</td>
                            {{-- controlamos que el btn de evaluacion se habilite cuando los años sean iguales --}}
                            @if ( (\Carbon\Carbon::now()->year) == (\Carbon\Carbon::createFromDate($cpa->fecha_inicio)->year))
                            {{-- @if ( 2023 == (\Carbon\Carbon::createFromDate($cpa->fecha_inicio)->year) ) --}}
                                <td>
                                    <a href="{{ route('evaluacion.index', $cpa->uuid) }}" class="boton default">Evaluar</a>
                                </td>
                            @else
                                <td></td>
                            @endif

                            {{-- @if ( (\Carbon\Carbon::now() > \Carbon\Carbon::createFromDate($cpa->fecha_inicio)) &&
                                (\Carbon\Carbon::now() < \Carbon\Carbon::createFromDate($cpa->fecha_fin)) )
                                <td> <a href="{{ route('evaluacion.index', $cpa->uuid) }}" class="boton default">Evaluar</a> </td>
                            @else
                                <td></td>
                            @endif --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "columnDefs": [
                    {
                        "targets": -1, // your case last column
                        "className": "text-center",
                        // "width": "4%"
                    }
                ],
                "language": {
                    "url": "{{ asset('libs/datatables/es-ES.json') }}"
                }
            });
        });
    </script>
@endsection
