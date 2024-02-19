@extends('layouts.plantillabase')

@section('title', 'Ver POA Unidad')

@section('contenido')
    <div class="card">
        <h5 class="card-header">Acciones Corto Plazo Unidad</h5>
        <div class="card-body">
            <h6 class="card-title"><strong>Gerencia:</strong> {{ $unidad->gerencia->nombre_gerencia }}</h6>
            <h6 class="card-title"><strong>Unidad:</strong> {{ $unidad->nombre_unidad }}</h6>
            <h6 class="card-title"><strong>Total Programado:</strong> {{ number_format($corto_plazo_acciones->sum("presupuesto_programado"), 2, '.', ',') }} Bs.</h6>
            <a href="{{ url()->previous() }}" class="boton red mb-3"><i class="fas fa-arrow-left"></i> Volver Atras</a>
            <table class="table table-striped table-bordered" id="table">
                <thead style="background-color: skyblue;">
                    <td>ACCION CORTO PLAZO</td>
                    <td>PRESUPUESTO PROGRAMADO</td>
                </thead>
                <tbody>
                    @foreach ($corto_plazo_acciones as $cpa)
                        <tr>
                            <td>{{ $cpa->accion_corto_plazo }}</td>
                            <td>{{ number_format($cpa->presupuesto_programado, 2, '.', ',') }} Bs.</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<!-- @section('js')
    <script>
        $('#table').DataTable({
            "language": {
                "url": "{{ asset('libs/datatables/es-ES.json') }}"
            }
        });
    </script>
@endsection -->
