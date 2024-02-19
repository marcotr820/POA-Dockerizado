@extends('layouts.plantillabase')

@section('title', 'Trabajadores')

@section('contenido')
    <div class="card">
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Trabajadores
            <div>
                <button type="butto1n" id="nuevo" class="boton blue"><i class="fas fa-plus"></i> Nuevo Trabajador</button>
            </div>
        </h5>
        <div class="card-body">
            <div class="loading"><b><h5 class="m-0">Loading...</h5></b></div>
            <article style="display:none;">
                <table id="trabajadores" class="table table-striped table-bordered table-sm" style="width:100%;">
                    <thead class="thead" style="background-color: skyblue">
                        <tr>
                            {{-- <td width="5%">ID</td> --}}
                            <td width="10%">DOCUMENTO</td>
                            <td width="20%">NOMBRE</td>
                            <td width="15%">CARGO</td>
                            <td width="15%">UNIDAD</td>
                            <td width="15%">GERENCIA</td>
                            <td width="10%">ACCIONES</td>
                        </tr>
                    </thead>
                </table>
            </article>
        </div>
    </div>

    @include('trabajadores.modal_trabajador.form_trabajador')

@endsection

@section('js')
    <script>

        $('#trabajadores').DataTable({
        // "initComplete": function( settings, json ) {
        // document.getElementById('trabajadores').style.display = 'table';
        // document.querySelector('.loading').style.display = 'none';
        // },
        "serverSide": true,
        "processing": true,
        // "order": [[ 0, "desc" ]],
        "ajax": "{{ route('trabajadores.index') }}",
        columns: [
            // { data: 'id', name: 'trabajadores.id'},
            { data: 'documento', name: 'trabajadores.documento'},
            { data: 'nombre', name: 'trabajadores.nombre'},
            { data: 'cargo', name:'trabajadores.cargo'},
            { data: 'nombre_unidad', name:'unidades.nombre_unidad'},
            { data: 'nombre_gerencia', name:'gerencias.nombre_gerencia'},
            {
                data: 'uuid',
					render: function( data, type, row)
					{
                        if(row.id == 1){
                            return ``;
                        }else{
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
        'columnDefs': [
            {
                "targets": -1, // your case last column
                "className": "text-center",
                // "width": "4%"
            }
        ],
        "language": {
                "url" : "{{ asset('libs/datatables/es-ES.json') }}"
        }
        }).on('xhr.dt', function ( e, settings, json, xhr ){
            document.querySelector('article').style.display = 'block';
            document.querySelector('.loading').style.display = 'none';
        });
    </script>

    <script src="{{asset('libs/js/validacionform/validar_trabajador.js')}}"></script>
@endsection