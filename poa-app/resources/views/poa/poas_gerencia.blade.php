@extends('layouts.plantillabase')

@section('title', 'Ver POA Gerencias')

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
        <h5 class="card-header">POA Gerencias</h5>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label><b>Gerencia</b> <span class="text-danger">*</span></label>
                    <select class="form-control" id="gerencia" name="gerencia">
                        <option value="" disabled selected>__Seleccione__</option>
                        @foreach ($gerencias as $g)
                            <option value="{{ $g->uuid }}">{{ $g->nombre_gerencia }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <h5 class="loading m-0 mt-2">Loading...</h5>
            <article class="table-loading">
                <table id="table" class="table table-striped table-sm table-bordered" style="width:100%">
                    <thead class="thead" style="background-color: skyblue;">
                        <tr>
                            <td width="45%">UNIDAD</td>
                            <td width="40%">PRESUPUESTO PROGRAMADO</td>
                            <td width="15%">ACCIONES</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </article>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('libs/js/validacionform/poas_gerencia.js')}}"></script>
    <script>
        var URL = "{{ asset('libs/datatables/es-ES.json') }}";
        var t = $('#table').DataTable({
                    "language": {
                        "url": "{{ asset('libs/datatables/es-ES.json') }}"
                    },
                    "initComplete": function( settings, json ) {
                        document.querySelector('.table-loading').classList.add('show');
                        document.querySelector('.loading').style.display = 'none';
                    },
                });
        // t.row.add(['1', '.2', '.3']).draw(false);
    </script>
@endsection
