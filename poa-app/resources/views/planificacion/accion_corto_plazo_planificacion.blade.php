@extends('layouts.plantillabase')

@section('title', 'Lista Acciones Planificación')

@section('contenido')
    <style>
        table{
            font-size: 13px;
        }
    </style>
    <div class="card">
        <h5 class="card-header">Planificar Acciones Corto Plazo</h5>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="table">
                <thead class="" style="background-color: skyblue">
                    <tr>
                        <th width="55%">ACCION CORTO PLAZO</th>
                        <th width="15%">FECHA INICIO</th>
                        <th width="15%">FECHA FIN</th>
                        <th width="15%">PLANIFICAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($corto_plazo_acciones as $cpa)
                        <tr>
                            <td>{{ $cpa->accion_corto_plazo }}</td>
                            <td>{{ $cpa->fecha_inicio }}</td>
                            <td>{{ $cpa->fecha_fin }}</td>
                            @if ($cpa->planificacion()->exists())
                                <td>
                                    <a href="{{ route('planificacion.index', $cpa->uuid) }}" class="boton blue" data-planificacion="">Planificacion</a>
                                </td>
                            @else
                                <td>
                                    <a href="{{ route('planificacion.index', $cpa->uuid) }}" class="boton red" data-planificacion=""><i class="fas fa-exclamation-triangle"></i> Planificacion</a>
                                </td>
                            @endif
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
