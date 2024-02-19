@extends('layouts.plantillabase')

@section('title', 'Unidades')

@section('contenido')
    <div class="card">
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Unidades
            <div>
                <button type="button" id="nuevo" class="boton blue"><i class="fas fa-plus"></i> Nuevo Unidad</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="unidades" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        {{-- <td width="5%">ID</td> --}}
                        <td>UNIDAD</td>
                        <td>GERENCIA</td>
                        <td width="10%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('unidades.modal_unidades.unidad_form')

@endsection

@section('js')
<script>
    $('#unidades').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
        // "ajax": "{{ url('datatable/unidad') }}", //otra forma de llamar a la ruta por su url
        "ajax": "{{ route('unidades.index') }}",
        columns: [
            // {data: 'id', name: 'unidades.id'},
            {data: 'nombre_unidad', name: 'unidades.nombre_unidad'},
            {data: 'nombre_gerencia', name: 'gerencias.nombre_gerencia'},
            {
                data: 'uuid',
                render: function( data, type, row)
                {
                    return `
                    <div class="btn-group">
                        <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                        <form class="d-inline" data-formdelete="">
                            @csrf
                            <button type="submit" class="boton red ml-2"><i class="fas fa-times-circle"></i></button>
                        </form>
                    </div>
                    `;
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
    });
</script>
<script src="{{asset('libs/js/validacionform/unidad_validar.js')}}"></script>
@endsection