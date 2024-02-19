{{-- @extends('layouts.plantillabase')

@section('title', 'Planificación y Evaluación')

@section('contenido')
    <div class="card p-2">
        <div class="cabecera_pagina">
            <h5 class="m-0">Lista Acciones corto plazo</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center p-2">
            <h5 class="card-title m-0">Planificacion y Evaluacion</h5>
        </div>
        <div class="card-body p-2">
            <table id="corto_plazo_acciones" class="table table-striped table-sm display" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        <td width="25%">ACCION CORTO PLAZO</td>
                        <td width="10%">FECHA INICIO</td>
                        <td width="10%">FECHA FIN</td>
                        <td width="7%">PLANIFICACION</td>
                        <td width="5%">EVALUACION</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@section('js')
    
    <script>
        $('#corto_plazo_acciones').DataTable({    
            "serverSide": true,
            "processing": true,
            "ajax": "{{route('planificacion_evaluacion')}}",
            columns: [
                { data:'accion_corto_plazo'},
                { data:'fecha_inicio'},
                { data:'fecha_fin'},
                {
                    data: 'uuid',
                    render: function ( data, type, row ) {
                        if(row.count_planificacion !== 1){
                            return '<button class="boton red" data-planificacion=""><i class="fas fa-exclamation-triangle"></i> Planificacion</button>';
                        }else{
                            return '<button class="boton blue" data-planificacion="">Planificacion</button>';
                        }
                    }
                },
                {
                    data: 'corto_plazo_acciones.fecha_inicio',
                    render: function ( data, type, row ) {
                        var fecha_inicio = Date.parse(row.fecha_inicio);
                        var fecha_fin = Date.parse(row.fecha_fin);
                        var fecha_actual = Date.now();
                        var poa_evaluacion = "{!!Auth::guard('usuario')->user()->trabajador->poa_evaluacion!!}";
                        if(fecha_actual > fecha_inicio && fecha_actual < fecha_fin && poa_evaluacion === '1'){
                            return '<button class="boton default" data-evaluar="">Evaluar</button>';
                        }
                        else{
                            return '';
                        }
                    }
                }
            ],
            "language": {
                "url" : "{{ asset('libs/datatables/es-ES.json') }}"
            }
        });
    </script>

    <script src="{{asset('libs/js/validacionform/planificacion_evaluacion.js')}}"></script>

@endsection --}}