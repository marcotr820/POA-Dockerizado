@extends('layouts.plantillabase')

@section('title', 'Metas')

@section('contenido')
    <div class="card">
        <div class="bg-light p-2">
            <table class="table table-bordered table-sm m-0">
              <tr>
                  <td width="10%" class="font-weight-bold">Pilar</td>
                  <td>
                    ( {{ $pilar->codigo_pilar }} )
                    {{ $pilar->nombre_pilar }}
                  </td>
              </tr>
            </table>
        </div>
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista de Metas
            <div>
                <a href="javascript:history.back()" class="boton red mr-2"><i class="fas fa-arrow-left"></i> Volver Atrás</a>
                <button class="boton blue" id="nuevo"><i class="fas fa-plus"></i> Nueva Meta</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="metas" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                        <td width="10%">CODIGO</td>
                        <td>META</td>
                        <td width="20%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('metas.modal_meta.meta_form')

@endsection

@section('js')
    <script>
        const pilar_uuid = "{{ $pilar->uuid }}";
        $('#metas').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": `${app_url}/pilares/{{ $pilar->uuid }}/metas`,
            columns: [
                { data: 'codigo_meta', name:'metas.codigo_meta'},
                { data: 'nombre_meta', name:'metas.nombre_meta'},
                {
                    data: 'uuid',
                    render: function( data, type, row)
                    {
                        return `
                        <div class="btn-group">
                            <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                            <button class="boton red ml-1" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                            <button class='boton default ml-4' data-resultados="">Resultados</a>
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

    <script src="{{asset('libs/js/validacionform/meta_validar.js')}}"></script>

@endsection