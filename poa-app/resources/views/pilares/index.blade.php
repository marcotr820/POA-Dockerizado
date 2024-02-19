@extends('layouts.plantillabase')

@section('title', 'Pilares')

@section('contenido')
    <div class="card">
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista de Pilares
            <div>
                {{-- <button class="boton default mr-1" data-directriz=""><i class="fas fa-file-pdf"></i> Directriz PDF</button> --}}
                <button class="boton blue" id="nuevo"><i class="fas fa-plus"></i> Nuevo Pilar</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="pilares" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                      <td width="10%">CÓDIGO</td>
                      <td>PILAR</td>
                      <td>GESTION</td>
                      <td width="20%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('pilares.modal_pilar.form_pilar')

@endsection

@section('js')
    <script>
        $('#pilares').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('pilares.index') }}",
            columns: [
                { data: 'codigo_pilar'},
                { data: 'nombre_pilar'},
                { data: 'gestion_pilar'},
                // { data: 'btn_pilares'},
                {
                    data: 'uuid',
                    render: function( data, type, row)
                    {
                        return `
                        <div class="btn-group">
                            <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                            <button class="boton red ml-1" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
                            <button class='boton default ml-4' data-metas="">Metas</a>
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

    <script src="{{asset('libs/js/validacionform/pilar_validar.js')}}"></script>

@endsection