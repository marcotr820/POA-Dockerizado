@extends('layouts.plantillabase')
@section('contenido')
<style>
    table{
        font-size: 0.7rem;
    }
    table th, td{
        border:.5px solid #737373;
        padding: 5px;
    }
</style>
    <div class="card">
        <div class="card-header">
            <h6><b>Trabajador:</b> {{$trabajador->nombre}}</h6>
            <h6><b>Gerencia:</b> {{$trabajador->unidad->gerencia->nombre_gerencia}}</h6>
            <h6 class="m-0"><b>Unidad:</b> {{$trabajador->unidad->nombre_unidad}}</h6>
        </div>
        <div class="card-header">
            Determinacion de requerimientos <a href="{{ route('requerimientos.pdf', $trabajador) }}" class="boton default" target="_blank"><i class="fas fa-file-pdf"></i> Generar PDF</a>
        </div>
        <div class="card-body p-2">
        <table width="100%">
            <thead style="background-color: skyblue">
                <tr>
                    <th>ACCION CORTO PLAZO</th>
                    <th>OPERACIONES</th>
                    <th>ACTIVIDADES</th>
                    <th>BIEN O SERVICIO ITEM</th>
                    <th>FECHA REQUERIDA</th>
                    <th>PARTIDA</th>
                    <th>PRESUPUESTO</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($trabajador->corto_plazo_acciones as $acp)
                    <tr>
                        <td class="dd" rowspan="{{$acp->operaciones->count() + $acp->actividades->count() + $acp->items->count() + 1}}">{{$acp->accion_corto_plazo}}</td>
                        @foreach ($acp->operaciones as $op)
                            <tr>
                                <td rowspan="{{$op->actividades->count() + $op->items->count() + 1}}">{{$op->nombre_operacion}}</td>
                                @foreach ($op->actividades as $act)
                                    <tr>
                                        <td rowspan="{{$act->items->count() + 1}}">{{$act->nombre_actividad}}</td>
                                        @foreach ($act->items as $item)
                                            <tr>
                                                <td>{{$item->bien_servicio}}</td>
                                                <td>{{$item->fecha_requerida}}</td>
                                                <td>{{$item->partida->codigo_partida}}</td>
                                                <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                            </tr>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tr>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">El trabajador No cuenta con registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
@endsection

@section('js')

@endsection