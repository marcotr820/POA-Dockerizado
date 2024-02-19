@extends('layouts.plantillabase')

@section('title', 'Operaciones')

@section('contenido')
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="15%" class="font-weight-bold">Acción Corto Plazo</td>
                    <td>{{$corto_plazo_accion->accion_corto_plazo}}</td>
                </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista de Operaciones
            <div>
                <a href="javascript:history.back()" class="boton red"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
                @if ($corto_plazo_accion->status != 'monitoreo')
                    <button type="button" id="nuevo" class="boton blue ml-2"><i class="fas fa-plus"></i> Nueva Operacion</button>
                @endif
            </div>
        </h5>
        <div class="card-body">
            <table id="operaciones" class="table table-bordered table-sm table-striped" style="width:100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                        {{-- <td width='5%'>ID</td> --}}
                        <td>OPERACION</td>
                        <td width="20%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('operaciones.modal_operacion.operacion_form')

@endsection

@section('js')
    
    <script src="{{asset('libs/js/validacionform/operacion_validar.js')}}"></script>
    <script>
        var accion_corto_uuid = "{{ $corto_plazo_accion->uuid }}";
        $('#operaciones').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": `${app_url}/corto_plazo_acciones/${accion_corto_uuid}/operaciones`,
            columns: [
                // { data: 'id'},
                { data: 'nombre_operacion'},
                { 
                    data: 'uuid' ,
                    render: function( data, type, row)
                    {
                        if(row.corto_plazo_accion.status == 'monitoreo'){
                            return `
                            <div class="btn-group">
                                <button class='boton default ml-4' data-actividades="">Actividades</a>
                            </div>
                            `;
                        } else {
                            return `
                            <div class="btn-group">
                                <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                                <button class="boton red ml-1" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                                <button class='boton default ml-4' data-actividades="">Actividades</a>
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
        });
    </script>


@endsection