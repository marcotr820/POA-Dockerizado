@extends('layouts.plantillabase')

@section('title', 'Usuarios')

@section('contenido')
    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <div class="card">
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Usuarios
            <div>
                <button type="button" id="nuevo" class="boton blue"><i class="fas fa-plus"></i> Nuevo Usuario</button>
            </div>
        </h5>
        <div class="card-body">
            <table id="usuarios" class="table table-striped table-sm table-bordered" style="width:100%">
                <thead class="thead" style="background-color: skyblue;">
                    <tr>
                        {{-- <td width="5%">ID</td> --}}
                        <td width="15%">USUARIO</td>
                        <td width="20%">ROL</th>
                        <td width="20%">TRABAJADOR</td>
                        <td width="25%">AREA RESPONSABLE</td>
                        <td width="10%">ACCIONES</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('usuarios.modal.form_usuarios')
    
@endsection


@section('js')

    <script>
        $('#usuarios').DataTable({
            "serverSide": true,
            "processing": true,
            "order": [[ 0, "desc" ]],
            "ajax": "{{ route('usuarios.index') }}",
            columns: [
                // { data: 'usuario_id', name:'trabajadores.usuario_id'},
                // { data: 'usuario', name:'usuarios.usuario' },
                // { data: 'nombre', name:'trabajadores.nombre'},
                
                // { data: 'id'},
                { data: 'usuario'},
                { 
                    data: 'roles', name: 'roles.name',
                    render: function(data) {
                        // data es el array de roles
                        let names = data.map(x => `<span class="badge badge-dark p-1">${x.name}</span>`);
                        return names.join(' ');
                    }
                },
                { data: 'nombre', name:'trabajadores.nombre'},
                {
                    data: 'trabajador.unidad.nombre_unidad',
                    render: function(data, type, row) {
                        return row.trabajador.unidad.nombre_unidad;
                    }
                },
                {
                    data: 'uuid',
                        render: function( data, type, row)
                        {
                            if(row.trabajador_id == 1){
                                return ``;
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

    <script src="{{asset('libs/js/validacionform/validar_usuario.js')}}"></script>

@endsection