@extends('layouts.plantillabase')

@section('title', 'Roles')

@section('contenido')
    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <div class="card">
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Roles
            <div>
                <button type="button" id="nuevo_rol" class="boton blue"><i class="fas fa-plus"></i> Nuevo Rol</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="roles" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue">
                    <tr>
                        {{-- <td width="5%">ID</td> --}}
                        <td width="">ROL</td>
                        <td width="10%">ACCIONES</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @include('roles.modal_roles.rol_form')
    
@endsection


@section('js')

    <script>
        $('#roles').DataTable({
            "serverSide": true,
            "processing": true,
            "order": [[ 0, "desc" ]],
            "ajax": "{{route('roles.index')}}",
            columns: [
                // { data: 'id'},
                { data: 'name'},
                {
                    data: 'id',
                    render: function( data, type, row)
                    {
                        return `
                        <div class="btn-group">
                            <button class="boton blue" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                            <button class="boton red ml-2" data-delete="" onclick="delet('${data}')"><i class="fas fa-times-circle"></i></button>
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
        })
    </script>

    <script src="{{asset('libs/js/validacionform/rol_validar.js')}}"></script>

@endsection