@extends('layouts.plantillabase')

@section('title', 'Resultados')

@section('contenido')
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="10%" class="font-weight-bold">Pilar</td>
                    <td>
                        ( {{ $meta->pilar->codigo_pilar }} )
                        {{$meta->pilar->nombre_pilar}}
                     </td>
                </tr>
                <tr>
                    <td width="10%" class="font-weight-bold">Meta</td>
                    <td>
                        ( {{ $meta->codigo_meta }} )
                        {{$meta->nombre_meta}}
                     </td>
                </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista de Resultados
            <div>
                <a href="javascript:history.back()" class="boton red mr-3"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
                <button class="boton blue" id="nuevo"><i class="fas fa-plus-circle"></i> Nuevo Resultado</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="resultados" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                        <td width="10%">CODIGO</td>
                        <td>RESULTADO</td>
                        <td width="26%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('resultados.modal_resultado.resultado_form')

@endsection

@section('js')
    
    <script>
        var meta_uuid = "{{ $meta->uuid }}";
        $('#resultados').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": `${app_url}/metas/${meta_uuid}/resultados`,
        columns: [
            { data: 'codigo_resultado', name:'resultados.codigo_resultado'},
            { data: 'nombre_resultado'},
            {
                data: 'uuid',
                render: function( data, type, row)
                {
                    return `
                    <div class="btn-group">
                        <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                        <button class="boton red ml-1" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                        <button class='boton default ml-4' data-mediano="">mediano plazo acciones</a>
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

    <script src="{{asset('libs/js/validacionform/resultado_validar.js')}}"></script>

@endsection