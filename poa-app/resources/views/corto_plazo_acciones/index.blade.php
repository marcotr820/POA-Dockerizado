@extends('layouts.plantillabase')

@section('title', 'Acciones Corto Plazo')

@section('contenido')
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="15%" class="font-weight-bold">Acción Institucional</td>
                    <td>{{$pei_objetivo_especifico->objetivo_institucional}}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Gerencia</td>
                    <td>{{ $pei_objetivo_especifico->gerencia->nombre_gerencia }}</td>
                </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Acciones Corto Plazo
            <div>
                <a href="{{ route('poa.index') }}" class="boton red"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
                <button type="button" id="nuevo" class="boton blue ml-2"><i class="fas fa-plus"></i> Nueva Accion Corto Plazo</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="corto_plazo_acciones" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                        <td width="30%">ACCION CORTO PLAZO</td>
                        <td width="5%">GESTION</td>
                        <td width="10%">RESULTADO ESPERADO (%)</td>
                        <td width="15%">PRESUPUESTO PROGRAMADO</td>
                        <td width="15%">FECHA INICIO</td>
                        <td width="10%">FECHA FIN</td>
                        <td width="15%">ACCIONES</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('corto_plazo_acciones.modal_corto_plazo_accion.corto_plazo_accion_form')

@endsection

@section('js')
    
    <script>
        var pei_uuid = "{{ $pei_objetivo_especifico->uuid }}";
        $('#corto_plazo_acciones').DataTable({    
            "serverSide": true,
            "processing": true,
            "ajax": `${app_url}/pei_objetivos_especifico/${pei_uuid}/corto_plazo_acciones/`,
            columns: [
                { data: 'accion_corto_plazo'},
                { data: 'gestion'},
                { data: 'resultado_esperado'},
                { 
                    data: 'presupuesto_programado',
                    render: function(data, type, row) {
                    var number = $.fn.dataTable.render.number( ',', '.', 2, 'Bs ').display(data);
                        // row.evaluaciones
                        return number;
                    }
                },
                { data: 'fecha_inicio'},
                { data: 'fecha_fin'},
                {
                    data: 'status',
                    render: function( data, type, row)
                    {
                        switch(data){
                            case 'editar':
                                return `
                                <button class="boton blue" data-edit="" onclick="edit('${row.uuid}')"><i class="fas fa-pen"></i></button>
                                `;
                            break;

                            case 'presentado':
                                return `
                                <div class="btn-group">
                                    <button class="boton blue" data-edit="" onclick="edit('${row.uuid}')"><i class="fas fa-pen"></i></button>
                                    <button class="boton red ml-2" data-delete="" onclick="delet('${row.uuid}')"><i class="fas fa-times-circle"></i></button>
                                </div>
                                `;
                            break;

                            case 'aprobado':
                                if(row.planificacion >= 1){
                                    return '<button class="boton info" data-operaciones="">Operaciones</button>';
                                }
                                else{
                                    return '<button class="boton green" data-planificacion="">Planificacion</button>';
                                }
                            break;

                            case 'monitoreo':
                                return '<button class="boton bg-primary text-white" data-operaciones="">Operaciones</button>';
                            break;
                        }
                    }
                }
            ],
            "columnDefs": [
                {
                    "targets": -1, // your case last column
                    "className": "text-center",
                    // "width": "4%"
                }
            ],
            "language": {
                "url" : "{{ asset('libs/datatables/es-ES.json') }}"
            }
        });
    </script>

    <script src="{{asset('libs/js/validacionform/corto_plazo_accion_validar.js')}}"></script>

@endsection