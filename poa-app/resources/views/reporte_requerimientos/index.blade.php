@extends('layouts.plantillabase')

@section('title', 'Determinación de Requerimientos')

@section('contenido')
<style>
    table {
        margin: 6px 0;
        font-size: 10px;;
        font-weight: 600;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        text-align: center;
    }
    table th,
    td {
        border: 0.5px solid #808080;
        padding: 4px;
    }
</style>
    <div class="card">
        <div class="bg-light p-2">
            <div>
                <strong>Determinacion de Requerimientos</strong>
            </div>
            <table class="table table-bordered table-sm m-0" style="font-size: 12px; text-align:left;">
                <tr>
                    <td width="10%" class="font-weight-bold">Gerencia</td>
                    <td>{{$unidad->gerencia->nombre_gerencia}}</td>
                </tr>
                <tr>
                    <td width="10%" class="font-weight-bold">Unidad</td>
                    <td>{{$unidad->nombre_unidad}}</td>
                </tr>
            </table>
        </div>
        <div class="card-header py-1">
            <a href="{{ route('poa.ver_poas') }}" class="boton red"><i class="fas fa-arrow-left"></i> Volver atras</a>
            <a href="{{ route('requerimientos.pdf', $unidad) }}" target="_blank" class="boton default"><i class="fas fa-file-pdf"></i> Generar PDF</a>
        </div>
        <div class="card-body px-1">
            <table id="" width="100%">
                <thead style="background-color: #ddd;">
                    <tr>
                        <th>ACCION CORTO PLAZO</th>
                        <th>OPERACIONES</th>
                        <th>ACTIVIDADES</th>
                        <th>ITEM / SERVICIO</th>
                        <th>FECHA REQUERIDA</th>
                        <th width="10%">PARTIDA</th>
                        <th>PRESUPUESTO</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($corto_plazo_acciones as $acp)
                        <tr>
                            <td
                            <?php $row_acc = 0;
                            if ($acp->operaciones->count() >= 1) { $row_acc += $acp->operaciones->count(); }
                            foreach ($acp->operaciones as $op) {
                                if ($op->actividades->count() > 1) {
                                    $row_acc += $op->actividades->count() - 1;
                                }
                                foreach ($op->actividades as $act) {
                                    if ($act->items->count() > 1) {
                                        $row_acc += $act->items->count() - 1;
                                    }
                                }
                            }
                            echo $row_acc > 1 ?  "rowspan='$row_acc'" : '';
                            ?>
                            >{{ $acp->accion_corto_plazo }}</td>
                            {{-- primera operacion de cada accion corto plazo --}}
                            @forelse ($acp->operaciones as $op)
                                @if ($loop->first)
                                    <td
                                    <?php $row_op = 0;
                                    if ($op->actividades->count() >= 1) {
                                        $row_op += $op->actividades->count();
                                    }
                                    foreach ($op->actividades as $act) {
                                        if ($act->items->count() > 1) {
                                            $row_op += $act->items->count() - 1;
                                        }
                                    }
                                    echo  $row_op > 1 ? "rowspan='$row_op'" : '';
                                    ?>
                                    >{{ $op->nombre_operacion }}</td>
                                    {{-- primera actividad primera operacion --}}
                                    @forelse ($op->actividades as $act)
                                        @if ($loop->first)
                                            <?php $var_op = $op ?>
                                            <td
                                            <?php $row_act = 0;
                                            if ($act->items->count() > 1) {
                                                $row_act += $act->items->count();
                                            }
                                            echo $row_act > 1 ? "rowspan='$row_act'" : '';
                                            ?>
                                            >{{$act->nombre_actividad}}</td>
                                            {{-- primer item primera actividad --}}
                                            @forelse ($act->items as $item)
                                                @if ($loop->first)
                                                <?php $var_act = $act; ?>
                                                    <td>{{$item->bien_servicio}}</td>
                                                    <td>{{$item->fecha_requerida}}</td>
                                                    <td>{{$item->partida->codigo_partida}}</td>
                                                    <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                                @endif
                                            @empty
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endforelse
                                        @endif
                                    @empty
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                @endif
                            @empty
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            @endforelse
                        </tr>

                        {{-- demas items primera actividad --}}
                        @if (isset($var_act))
                            @foreach ($var_act->items as $item)
                                @if (!$loop->first)
                                    <tr>
                                        <td>{{$item->bien_servicio}}</td>
                                        <td>{{$item->fecha_requerida}}</td>
                                        <td>{{$item->partida->codigo_partida}}</td>
                                        <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                    </tr>
                                @endif
                            @endforeach
                            <?php unset($var_act); ?>
                        @endif

                        {{-- demas actividades primera operacion --}}
                        @if (isset($var_op))
                            @foreach ($var_op->actividades as $act)
                                @if (!$loop->first)
                                    <tr>
                                        <td
                                        <?php $row_act = 0;
                                        if ($act->items->count() > 1) {
                                                $row_act += $act->items->count();
                                            }
                                        echo $row_act > 1 ? "rowspan='$row_act'" : '';
                                        ?>
                                        >{{$act->nombre_actividad}}</td>
                                        @forelse ($act->items as $item)
                                            @if ($loop->first)
                                                <?php $var_act = $act; ?>
                                                <td>{{$item->bien_servicio}}</td>
                                                <td>{{$item->fecha_requerida}}</td>
                                                <td>{{$item->partida->codigo_partida}}</td>
                                                <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                            @endif
                                        @empty
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        @endforelse
                                    </tr>

                                    {{-- demas items  --}}
                                    @if (isset($var_act))
                                        @foreach ($var_act->items as $item)
                                            @if (!$loop->first)
                                                <tr>
                                                    <td>{{$item->bien_servicio}}</td>
                                                    <td>{{$item->fecha_requerida}}</td>
                                                    <td>{{$item->partida->codigo_partida}}</td>
                                                    <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <?php unset($var_act); ?>
                                    @endif

                                @endif
                            @endforeach
                            <?php $var_op = NULL; ?>
                        @endif

                        {{-- demas operaciones accion corto plazo --}}
                        @foreach ($acp->operaciones as $op)
                            @if (!$loop->first)
                                <tr>
                                    <td
                                    <?php $row_op = 0;
                                    if ($op->actividades->count() >= 1) {
                                        $row_op += $op->actividades->count();
                                    }else{
                                        $row_op++;
                                    }
                                    foreach ($op->actividades as $act) {
                                        if ($act->items->count() > 1) {
                                            $row_op += $act->items->count() - 1;
                                        }
                                    }
                                    echo  $row_op > 1 ? "rowspan='$row_op'" : '';
                                    ?>
                                    >{{ $op->nombre_operacion }}</td>
                                    {{-- primera actividad demas operaciones --}}
                                    @forelse ($op->actividades as $act)
                                        @if ($loop->first)
                                            <?php $var_op2 = $op ?>
                                            <td
                                            <?php $row_act = 0;
                                            if ($act->items->count() > 1) {
                                                $row_act += $act->items->count();
                                            }
                                            echo $row_act > 1 ? "rowspan='$row_act'" : '';
                                            ?>
                                            >{{$act->nombre_actividad}}</td>
                                            {{-- primer item primera actividad demas operaciones --}}
                                            @forelse ($act->items as $item)
                                                @if ($loop->first)
                                                    <?php $var_act = $act; ?>
                                                    <td>{{$item->bien_servicio}}</td>
                                                    <td>{{$item->fecha_requerida}}</td>
                                                    <td>{{$item->partida->codigo_partida}}</td>
                                                    <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                                @endif
                                            @empty
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endforelse
                                        @endif
                                    @empty
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                </tr>

                                {{-- demas items primera actividad demas operaciones --}}
                                @if (isset($var_act))
                                    @foreach ($var_act->items as $item)
                                        @if (!$loop->first)
                                            <tr>
                                                <td>{{$item->bien_servicio}}</td>
                                                <td>{{$item->fecha_requerida}}</td>
                                                <td>{{$item->partida->codigo_partida}}</td>
                                                <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <?php unset($var_act) ?>
                                @endif

                                {{-- demas actividades demas operaciones --}}
                                @if (isset($var_op2))
                                    @foreach ($var_op2->actividades as $act)
                                        @if (!$loop->first)
                                            <tr>
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->items->count() > 1) {
                                                    $row_act += $act->items->count();
                                                }
                                                echo $row_act > 1 ? "rowspan='$row_act'" : '';
                                                ?>
                                                >{{$act->nombre_actividad}}</td>
                                                {{-- primera item demas actividades demas operaciones --}}
                                                @forelse ($act->items as $item)
                                                    @if ($loop->first)
                                                        <td>{{$item->bien_servicio}}</td>
                                                        <td>{{$item->fecha_requerida}}</td>
                                                        <td>{{$item->partida->codigo_partida}}</td>
                                                        <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                                    @endif
                                                @empty
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endforelse
                                            </tr>

                                            {{-- demas item demas actividades demas operaciones --}}
                                            @foreach ($act->items as $item)
                                                @if (!$loop->first)
                                                    <tr>
                                                        <td>{{$item->bien_servicio}}</td>
                                                        <td>{{$item->fecha_requerida}}</td>
                                                        <td>{{$item->partida->codigo_partida}}</td>
                                                        <td>{{number_format($item->presupuesto, 2, ".", ",")}} Bs.</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    <?php unset($var_op2); ?>
                                @endif
                            @endif
                        @endforeach
                        
                    @empty
                        <tr>
                            <td colspan="7">No se encontraron resultados.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5"></td>
                        <th>TOTAL</th>
                        <?php $total = 0; ?>
                        @foreach ($corto_plazo_acciones as $cpa)
                            <?php $total += $cpa->items->sum('presupuesto') ?>
                        @endforeach
                        <th>{{number_format($total, 2, ".", ",")}} Bs.</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('js')
@endsection
