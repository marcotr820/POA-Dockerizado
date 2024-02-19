@extends('layouts.plantillabase')

@section('title', 'Tareas Especificas')

@section('contenido')
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="15%" class="font-weight-bold">Acción Corto Plazo</td>
                    <td>{{$actividad->operacion->corto_plazo_accion->accion_corto_plazo}}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Operación</td>
                    <td>{{$actividad->operacion->nombre_operacion}}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Actividad</td>
                    <td>{{$actividad->nombre_actividad}}</td>
                </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista de Tareas Especificas
            <div>
                <a href="javascript:history.back()" class="boton red"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
                @if ($actividad->operacion->corto_plazo_accion->status != 'monitoreo')
                    <button type="button" id="nuevo" class="boton blue ml-2"><i class="fas fa-plus"></i> Nueva Tarea Especifica</button>
                @endif
            </div>
        </h5>
        <div class="card-body">
            <table id="tareas_especificas" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        {{-- <td width='5%'>ID</td> --}}
                        <td>TAREA ESPECIFICA</td>
                        {{-- <th>RESULTADO ESPERADO</th> --}}
                        <td width="15%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('tareas_especificas.modal_tarea_especifica.tarea_especifica_form')


@endsection

@section('js')
    
    <script src="{{asset('libs/js/validacionform/tarea_especifica_validar.js')}}"></script>
    <script>
        var actividad_uuid = "{!!$actividad->uuid!!}";
        $('#tareas_especificas').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": `${app_url}/actividades/${actividad_uuid}/tareas_especificas/`,
            columns: [
                // { data: 'id'},
                { data: 'nombre_tarea'},
                // { data: 'resultado_esperado'},
                {
                    data: 'uuid',
                    render: function( data, type, row)
                    {
                        if(row.status_accion_corto_plazo == 'monitoreo'){
                            return '';
                        } else {
                            return `
                            <div class="btn-group">
                                <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                                <button class="boton red ml-2" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                            </div>
                            `;
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
        })
    </script>

@endsection