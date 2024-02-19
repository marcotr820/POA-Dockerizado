@extends('layouts.plantillabase')

@section('title', 'Partidas')

@section('contenido')
<style>
    .table-loading{
        opacity: 0;
        height: 0;
        pointer-events: none;
    }
    .table-loading.show{
        opacity: 1;
        height: 100%;
        pointer-events: visible;
    }
</style>
    <div class="card">
        <h5 class="card-header py-1 d-flex justify-content-between align-items-center">
            Lista Partidas
            <div>
                <a href="{{ route('partidas.gestion') }}" class="boton default">Generar Reporte Por Gestión</a>
                <button type="button" id="nuevo" class="boton blue"><i class="fas fa-plus-circle"></i> Nuevo Partida</button>
            </div>
        </h5>
        <div class="card-body">
            <h5 class="loading m-0">Loading...</h5>
            <article class="table-loading">
                <table id="partidas" class="table table-striped table-sm table-bordered" style="width:100%">
                    <thead class="thead border-dark" style="background-color: skyblue;">
                        <tr>
                            {{-- <td width='5%'>ID</td> --}}
                            <td>PARTIDA</td>
                            <td>CODIGO PARTIDA</td>
                            <td>TIPO PARTIDA</td>
                            <td width="10%">ACCIONES</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </article>
            
        </div>
    </div>

    @include('partidas.modal_partida.partida_form')


@endsection

@section('js')
    <script src="{{asset('libs/js/validacionform/partida_validar.js')}}"></script>
    <script>
        $('#partidas').DataTable({
            "serverSide": true,
            "processing": true,
            "order": [0, "desc"],
            "ajax": "{{ route('partidas.index' )}}",
            columns: [
                // { data: 'id'},
                { data: 'nombre_partida'},
                { data: 'codigo_partida'},
                { data: 'tipo_partida'},
                { 
                    data: 'uuid',
                    render: function( data, type, row)
                    {
                        return `
                        <div class="btn-group">
                            <button class="boton blue mr-2" data-edit="" onclick="edit('${data}')"><i class="fas fa-pen"></i></button>
                            <form class="d-inline" data-formdelete="">
                                @csrf
                                <button type="submit" class="boton red"><i class="fas fa-times-circle"></i></button>
                            </form>
                        <div>
                        `;
                    },
                    orderable: false
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
            },
            "initComplete": function( settings, json ) {
                document.querySelector('.table-loading').classList.add('show');
                document.querySelector('.loading').style.display = 'none';
            },
        });
    </script>
@endsection