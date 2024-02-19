@extends('layouts.plantillabase')

@section('title', 'Acciones Mediano Plazo')

@section('contenido')
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="10%" class="font-weight-bold">Pilar</td>
                    <td>
                        ( {{ $resultado->meta->pilar->codigo_pilar }} )
                        {{$resultado->meta->pilar->nombre_pilar}}
                     </td>
                </tr>
                <tr>
                    <td width="10%" class="font-weight-bold">Meta</td>
                    <td>
                        ( {{ $resultado->meta->codigo_meta }} )
                        {{$resultado->meta->nombre_meta}}
                     </td>
                </tr>
                <tr>
                    <td width="10%" class="font-weight-bold">Resultado</td>
                    <td>
                        ( {{ $resultado->codigo_resultado }} ) 
                        {{$resultado->nombre_resultado}}
                     </td>
                </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Acciones Mediano Plazo
            <div>
                <a href="javascript:history.back()" class="boton red mr-3"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
                <button class="boton blue" id="nuevo"><i class="fas fa-plus-circle"></i> Nueva Accion Mediano Plazo</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="acciones_mediano_plazo" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        <td width="10%">CÓDIGO</td></td>
                        <td>ACCIÓN MEDIANO PLAZO</td>
                        <td width="25%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('mediano_plazo_acciones.modal_mediano_plazo_accion.mediano_plazo_accion_form')

@endsection

@section('js')
    
    <script>
        var resultado_uuid = "{{ $resultado->uuid }}";
        $('#acciones_mediano_plazo').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": `${app_url}/resultados/${resultado_uuid}/acciones_mediano_plazo`,
            columns: [
                { data: 'codigo_mediano_plazo', name:'mediano_plazo_acciones.codigo_mediano_plazo'},
                { data: 'accion_mediano_plazo', name:'mediano_plazo_acciones.accion_mediano_plazo'},
                {
                    data: 'uuid',
                    render: function( data, type, row)
                    {
                        return `
                        <div class="btn-group">
                            <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                            <button class="boton red ml-1" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                            <button class='boton default ml-4' data-objetivo_gestion="">Acción Institucional</a>
                        </div>
                        `;
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

    <script src="{{asset('libs/js/validacionform/mediano_plazo_accion_validar.js')}}"></script>

@endsection