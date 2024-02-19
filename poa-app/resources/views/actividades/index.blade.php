@extends('layouts.plantillabase')

@section('title', 'Actividades')

@section('contenido')
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="15%" class="font-weight-bold">Acción Corto Plazo</td>
                    <td>{{$operacion->corto_plazo_accion->accion_corto_plazo}}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Operación</td>
                    <td>{{$operacion->nombre_operacion}}</td>
                </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista de Actividades
            <div>
                <a href="javascript:history.back()" class="boton red"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
                @if ($operacion->corto_plazo_accion->status != 'monitoreo')
                    <button type="button" id="nuevo" class="boton blue ml-2"><i class="fas fa-plus"></i> Nueva Actividad</button>
                @endif
            </div>
        </h5>
        <div class="card-body">
            <table id="actividades" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        {{-- <td width="5%">ID</td> --}}
                        <td width="25%">ACTIVIDAD</td>
                        <td width="25%">RESULTADOS INTERMEDIOS ESPERADOS</td>
                        <td width="25%">ITEMS PRESUPUESTO EJECUTADO</td>
                        <td width="25%"">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('actividades.modal_actividad.actividad_form')

@endsection

@section('js')
    <script src="{{asset('libs/js/validacionform/actividad_validar.js')}}"></script>
    <script>
        var operacion_uuid = "{{ $operacion->uuid }}";
        $('#actividades').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": `${app_url}/operaciones/${operacion_uuid}/actividades`,
            columns: [
                // { data: 'id'},
                { data: 'nombre_actividad'},
                { data: 'resultado_esperado'},
                {
                    data: 'items_presupuesto',
                    render: function(data, type, row) {
                    var number = $.fn.dataTable.render.number( ',', '.', 2, 'Bs ').display(data);
                        return number;
                    }
                },
                {
                    data: 'uuid',
                    render: function( data, type, row)
                    {
                        if(row.status_accion_corto_plazo == 'monitoreo'){
                            return `
                            <div class="btn-group">
                                <button class='boton info ml-3' data-tareas="">Tareas</a>
                                <button class='boton green ml-2' data-items="">Items</a>
                            </div>
                            `;
                        } else {
                            return `
                            <div class="btn-group">
                                <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                                <button class="boton red ml-2" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                                <button class='boton info ml-3' data-tareas="">Tareas</a>
                                <button class='boton default ml-2' data-items="">Items</a>
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