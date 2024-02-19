@extends('layouts.plantillabase')

@section('title', 'Gerencias')

@section('contenido')
    
    <div class="card">
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Gerencias
            <div>
                <button type="button" id="nuevo" class="boton blue"><i class="fas fa-plus-circle"></i> Nueva Gerencia</button>
            </div>
        </h5>
        <div class="card-body">
            {{-- <div class="loading"><h5 class="m-0"><b>Loading...</b></h5></div> --}}
            {{-- <article style="display: none"> --}}
                <table id="gerencias" class="table table-striped table-sm table-bordered" style="width:100%;">
                    <thead style="background-color: skyblue;">
                        <tr>
                            {{-- <td width="5%">ID</td> --}}
                            <td>NOMBRE GERENCIA</td>
                            <td width="10%">ACCIONES</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            {{-- </article> --}}
            
        </div>
    </div>

    @include('gerencias.modal_gerencia.gerencia_form')

@endsection

@section('js')
    <script>
        $('#gerencias').DataTable({
            "serverSide": true,
            "processing": true,
            "order": [[ 0, "desc" ]],
            "ajax": "{{ route('gerencias.index') }}",
            columns: [
                // { data: 'id'},
                { data: 'nombre_gerencia'},
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
            },
            "initComplete": function( settings, json ) {
                // document.querySelector('article').style.display = 'block';
                // document.querySelector('.loading').style.display = 'none';
            },
        });
    </script>
    
    <script src="{{asset('libs/js/validacionform/gerencia_validar.js')}}"></script>
@endsection