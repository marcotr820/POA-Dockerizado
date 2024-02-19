@extends('layouts.plantillabase')

@section('title', 'Reporte Tareas Especificas')

@section('contenido')
<style>
    #table{
        font-size: 11px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: 600;
        text-align: center;
    }
    #table tr td{
        /* border: 0.5px solid #b3b3b3; */
        padding: 4px;
    }
</style>
    <div class="card">
        <div class="card-header">
            <table class="table table-bordered table-sm m-0">
                <tr>
                    <td width="15%" class="font-weight-bold">Acción corto plazo</td>
                    <td>{{$actividad->operacion->corto_plazo_accion->accion_corto_plazo}}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Operación</td>
                    <td>{{$actividad->operacion->nombre_operacion}}</td>
                </tr>
                <tr>
                    <td width="15%" class="font-weight-bold">Actividad</td>
                    <td>{{$actividad->nombre_actividad}}</td>
                </tr>
            </table>
            <a href="javascript:history.back()" class="boton red mt-2"><i class="fas fa-arrow-left"></i> Volver Atras</a>
        </div>
        <div class="card-body">
            <h5 class="card-title">Lista de tareas especificas</h5>
            <table width="100%" id="table" class="table table-striped table-sm table-bordered">
                <thead style="background-color: skyblue; text-align: center;">
                    <tr>
                        <td width="8%">ID</td>
                        <td>TAREA ESPECIFICA</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($actividad->tareas_especificas as $tar)
                        <tr>
                            <td>{{$tar->id}}</td>
                            <td>{{$tar->nombre_tarea}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No se encontraron registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });
</script>
@endsection
