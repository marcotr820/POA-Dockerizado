<style>
    table{
        border-collapse: collapse;
        font-size: 6px;
        text-align: center;
    }
    th, td{
        /* border:.5px solid #a6a6a6; */
        border:.5px solid #000;
    } 
</style>
{{-- <table width="50%">
    <tr>
        <td rowspan="5">accion</td>
        <td rowspan="2">op</td>
        <td>act</td>
    </tr>
    <tr>
        <td>act1</td>
    </tr>
    demas operaciones
    <tr>
        <td>op1</td>
    </tr>
    <tr>
        <td rowspan="2">op2</td>
        <td>act2</td>
    </tr>
    
    <tr>
        <td>act2.2</td>
    </tr>

    <tr>
        <td>accion2</td>
    </tr>
</table>
<p>****************************************</p> --}}
<table id="" width="100%" style="padding: 5px;">
    <thead>
        <tr style="background-color: #ddd;font-weight: bold;">
            <th>ACCION CORTO PLAZO</th>
            <th>OPERACIONES</th>
            <th>ACTIVIDADES</th>
            <th>ITEM / SERVICIO</th>
            <th>FECHA REQUERIDA</th>
            <th>PARTIDA</th>
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
                echo $row_acc > 1 ?  'rowspan="'.$row_acc.'"' : '';
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
                        echo  $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
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
                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
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
                            echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
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
                        echo  $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
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
                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
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
                                    echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                    ?>
                                    >{{$act->nombre_actividad}} ++</td>
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
            <td><b>TOTAL</b></td>
            <?php $total = 0; ?>
            @foreach ($corto_plazo_acciones as $cpa)
                <?php $total += $cpa->items->sum('presupuesto') ?>
            @endforeach
            <td>{{number_format($total, 2, ".", ",")}} Bs.</td>
        </tr>
    </tfoot>
</table>