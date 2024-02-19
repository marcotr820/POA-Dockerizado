@extends('layouts.plantillabase')

@section('title', 'Determininación de Operaciones y Tareas')

@section('contenido')
    <style>
        table {
            margin: 6px 0;
            font-size: 10px;
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
                <strong>Determinacion de Operaciones y Tareas</strong>
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
            <a href="{{ route('operaciones_tareas_pdf', $unidad->uuid) }}" target="_blank" class="boton default"><i class="fas fa-file-pdf"></i> Generar PDF</a>
        </div>
        <div class="card-body px-1">
            <table id="operaciones_tareas" width="100%">
                <thead style="background-color: #ddd;">
                    <tr>
                        <th>ACCION CORTO PLAZO</th>
                        <th>RESULTADO ESPERADO GESTIÓN EXPRESADO EN (%)</th>
                        <th>OPERACIONES</th>
                        <th>ACTIVIDADES</th>
                        <th>RESULTADOS INTERMEDIOS ESPERADOS</th>
                        <th>TAREAS ESPECIFICAS</th>
                        {{-- <th></th> --}}
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
                            echo $row_acc > 1 ?  "rowspan='$row_acc'" : '';
                            ?>
                            >{{ $acp->accion_corto_plazo }}</td>
                            <td <?php echo $row_acc > 1 ?  "rowspan='$row_acc'" : ''; ?> >{{$acp->resultado_esperado}}</td>
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
                                    echo  $row_op > 1 ? "rowspan='$row_op'" : '';
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
                                            echo $row_act > 1 ? "rowspan='$row_act'" : '';
                                            ?>
                                            >{{$act->nombre_actividad}}</td>
                                            <td <?php echo $row_act > 1 ? "rowspan='$row_act'" : ''; ?> >{{$act->resultado_esperado}}</td>
                                            {{-- primera tarea_especifica primera actividad --}}
                                            @forelse ($act->tareas_especificas as $tar)
                                                @if ($loop->first)
                                                <?php $var_act = $act; ?>
                                                    <td>{{$tar->nombre_tarea}}</td>
                                                    {{-- <td>unidad ejecjutora</td> --}}
                                                @endif
                                            @empty
                                                <td></td>
                                                {{-- <td></td> --}}
                                            @endforelse
                                        @endif
                                    @empty
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{-- <td></td> --}}
                                    @endforelse
                                @endif
                            @empty
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                {{-- <td></td> --}}
                            @endforelse
                        </tr>

                        {{-- demas tareas especificas primera actividad --}}
                        @if (isset($var_act))
                            @foreach ($var_act->tareas_especificas as $tar)
                                @if (!$loop->first)
                                    <tr>
                                        <td>{{$tar->nombre_tarea}}</td>
                                        {{-- <td>unidad ejecjutora UU</td> --}}
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
                                        echo $row_act > 1 ? "rowspan='$row_act'" : '';
                                        ?>
                                        >{{$act->nombre_actividad}}</td>
                                        <td <?php echo $row_act > 1 ? "rowspan='$row_act'" : ''; ?> >{{$act->resultado_esperado}}</td>
                                        @forelse ($act->tareas_especificas as $tar)
                                            @if ($loop->first)
                                                <?php $var_act = $act; ?>
                                                <td>{{$tar->nombre_tarea}}</td>
                                                {{-- <td>unidad ejecjutora KK</td> --}}
                                            @endif
                                        @empty
                                            <td></td>
                                            {{-- <td></td> --}}
                                        @endforelse
                                    </tr>

                                    {{-- demas tareas especificas  --}}
                                    @if (isset($var_act))
                                        @foreach ($var_act->tareas_especificas as $tar)
                                            @if (!$loop->first)
                                                <tr>
                                                    <td>{{$tar->nombre_tarea}}</td>
                                                    {{-- <td>unidad ejecutora MM</td> --}}
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
                                    echo  $row_op > 1 ? "rowspan='$row_op'" : '';
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
                                            echo $row_act > 1 ? "rowspan='$row_act'" : '';
                                            ?>
                                            >{{$act->nombre_actividad}}</td>
                                            <td <?php echo $row_act > 1 ? "rowspan='$row_act'" : ''; ?> >{{$act->resultado_esperado}}</td>
                                            {{-- primera tareas especifica primera actividad demas operaciones --}}
                                            @forelse ($act->tareas_especificas as $tar)
                                                @if ($loop->first)
                                                    <?php $var_act = $act; ?>
                                                    <td>{{$tar->nombre_tarea}}</td>
                                                    {{-- <td>unidad ejecutora tt</td> --}}
                                                @endif
                                            @empty
                                                <td></td>
                                                {{-- <td></td> --}}
                                            @endforelse
                                        @endif
                                    @empty
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        {{-- <td></td> --}}
                                    @endforelse
                                </tr>

                                {{-- demas tareas especificas primera actividad demas operaciones --}}
                                @if (isset($var_act))
                                    @foreach ($var_act->tareas_especificas as $tar)
                                        @if (!$loop->first)
                                            <tr>
                                                <td>{{$tar->nombre_tarea}}</td>
                                                {{-- <td>unidad ejecutora NN3</td> --}}
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
                                                echo $row_act > 1 ? "rowspan='$row_act'" : '';
                                                ?>
                                                >{{$act->nombre_actividad}}</td>
                                                <td <?php echo $row_act > 1 ? "rowspan='$row_act'" : ''; ?> >{{$act->resultado_esperado}}</td>
                                                {{-- primera tarea especifica demas actividades demas operaciones --}}
                                                @forelse ($act->tareas_especificas as $tar)
                                                    @if ($loop->first)
                                                        <td>{{$tar->nombre_tarea}}</td>
                                                        {{-- <td>unidad ejecutora yy</td> --}}
                                                    @endif
                                                @empty
                                                    <td></td>
                                                    {{-- <td></td> --}}
                                                @endforelse
                                            </tr>

                                            {{-- demas tarea especifica demas actividades demas operaciones --}}
                                            @foreach ($act->tareas_especificas as $tar)
                                                @if (!$loop->first)
                                                    <tr>
                                                        <td>{{$tar->nombre_tarea}}</td>
                                                        {{-- <td>unidad ejecutora ee</td> --}}
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
        </div>
    </div>
@endsection

@section('js')
@endsection
