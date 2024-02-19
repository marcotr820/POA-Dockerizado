<style>
   table th, td{
      border: 0.5px solid #000;
   }
   table{
      font-size: 6px;
      border-collapse: collapse;
      text-align:center;
   }
</style>

<table id="operaciones_tareas" width="100%" style="padding: 4px;">
    <thead>
        <tr style="background-color: #ddd; font-weight:bold;">
            <th>ACCION CORTO PLAZO</th>
            <th>RESULTADO ESPERADO DE GESTION EXPRESADO EN (%)</th>
            <th>OPERACIONES</th>
            <th>ACTIVIDADES</th>
            <th>RESULTADOS INTERMEDIOS ESPERADOS</th>
            <th>TAREAS ESPECIFICAS</th>
            {{-- <th>UNIDAD EJECUTORA</th> --}}
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
                        if ($act->tareas_especificas->count() > 1) {
                            $row_acc += $act->tareas_especificas->count() - 1;
                        }
                    }
                }
                echo $row_acc > 1 ?  'rowspan="'.$row_acc.'"' : '';
                ?>
                >{{ $acp->accion_corto_plazo }}</td>
                <td <?php echo $row_acc > 1 ?  'rowspan="'.$row_acc.'"' : ''; ?> >{{$acp->resultado_esperado}}</td>
                {{-- primera operacion de cada accion corto plazo --}}
                @forelse ($acp->operaciones as $op)
                    @if ($loop->first)
                        <td
                        <?php $row_op = 0;
                        if ($op->actividades->count() >= 1) {
                            $row_op += $op->actividades->count();
                        }
                        foreach ($op->actividades as $act) {
                            if ($act->tareas_especificas->count() > 1) {
                                $row_op += $act->tareas_especificas->count() - 1;
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
                                if ($act->tareas_especificas->count() > 1) {
                                    $row_act += $act->tareas_especificas->count();
                                }
                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                ?>
                                >{{$act->nombre_actividad}}</td>
                                <td <?php echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : ''; ?> >{{$act->resultado_esperado}}</td>
                                {{-- primera tarea_especifica primera actividad --}}
                                @forelse ($act->tareas_especificas as $tar)
                                    @if ($loop->first)
                                    <?php $var_act = $act; ?>
                                        <td>{{$tar->nombre_tarea}}</td>
                                        {{-- <td>unidad ejecjutora</td> --}}
                                    @endif
                                @empty
                                    <td></td>
                                    <td></td>
                                @endforelse
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

            {{-- demas tareas especificas primera actividad --}}
            @if (isset($var_act))
                @foreach ($var_act->tareas_especificas as $tar)
                    @if (!$loop->first)
                        <tr>
                            <td>{{$tar->nombre_tarea}}</td>
                            {{-- <td>unidad ejecjutora</td> --}}
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
                            if ($act->tareas_especificas->count() > 1) {
                                    $row_act += $act->tareas_especificas->count();
                                }
                            echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                            ?>
                            >{{$act->nombre_actividad}}</td>
                            <td <?php echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : ''; ?> >{{$act->resultado_esperado}}</td>
                            @forelse ($act->tareas_especificas as $tar)
                                @if ($loop->first)
                                    <?php $var_act = $act; ?>
                                    <td>{{$tar->nombre_tarea}}</td>
                                    {{-- <td>unidad ejecjutora</td> --}}
                                @endif
                            @empty
                                <td></td>
                                <td></td>
                            @endforelse
                        </tr>

                        {{-- demas tareas especificas  --}}
                        @if (isset($var_act))
                            @foreach ($var_act->tareas_especificas as $tar)
                                @if (!$loop->first)
                                    <tr>
                                        <td>{{$tar->nombre_tarea}}</td>
                                        {{-- <td>unidad ejecutora</td> --}}
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
                            if ($act->tareas_especificas->count() > 1) {
                                $row_op += $act->tareas_especificas->count() - 1;
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
                                if ($act->tareas_especificas->count() > 1) {
                                    $row_act += $act->tareas_especificas->count();
                                }
                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                ?>
                                >{{$act->nombre_actividad}}</td>
                                <td <?php echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : ''; ?> >{{$act->resultado_esperado}}</td>
                                {{-- primera tareas especifica primera actividad demas operaciones --}}
                                @forelse ($act->tareas_especificas as $tar)
                                    @if ($loop->first)
                                        <?php $var_act = $act; ?>
                                        <td>{{$tar->nombre_tarea}}</td>
                                        {{-- <td>unidad ejecutora</td> --}}
                                    @endif
                                @empty
                                    <td></td>
                                    <td></td>
                                @endforelse
                            @endif
                        @empty
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endforelse
                    </tr>

                    {{-- demas tareas especificas primera actividad demas operaciones --}}
                    @if (isset($var_act))
                        @foreach ($var_act->tareas_especificas as $tar)
                            @if (!$loop->first)
                                <tr>
                                    <td>{{$tar->nombre_tarea}}</td>
                                    {{-- <td>unidad ejecutora</td> --}}
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
                                    if ($act->tareas_especificas->count() > 1) {
                                        $row_act += $act->tareas_especificas->count();
                                    }
                                    echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                    ?>
                                    >{{$act->nombre_actividad}} ++</td>
                                    <td <?php echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : ''; ?> >{{$act->resultado_esperado}}</td>
                                    {{-- primera tarea especifica demas actividades demas operaciones --}}
                                    @forelse ($act->tareas_especificas as $tar)
                                        @if ($loop->first)
                                            <td>{{$tar->nombre_tarea}}</td>
                                            {{-- <td>unidad ejecutora</td> --}}
                                        @endif
                                    @empty
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                </tr>

                                {{-- demas tarea especifica demas actividades demas operaciones --}}
                                @foreach ($act->tareas_especificas as $tar)
                                    @if (!$loop->first)
                                        <tr>
                                            <td>{{$tar->nombre_tarea}}</td>
                                            {{-- <td>unidad ejecutora</td> --}}
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
</table>

   {{-- @if ($acp != $loop->last)
      <div pagebreak="true"></div>
   @endif --}}
