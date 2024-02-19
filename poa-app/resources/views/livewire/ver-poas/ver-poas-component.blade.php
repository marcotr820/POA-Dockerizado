<div>
    {{--  --}}
    <div class="form-row">
        <div class="col">
            <label><strong>Gerencia</strong></label>
            <select wire:model="SelectedGerencia" class="form-control">
                <option>Seleccione...</option>
                @foreach ($gerencias as $g)
                    <option value="{{ $g->id }}">{{ $g->nombre_gerencia }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            
            <label><strong>Unidad</strong></label>
            <select wire:model="SelectedtUnidad" class="form-control">
                <option hidden selected>Seleccione...</option>
                @if (!is_null($SelectedGerencia))
                    @foreach ($unidades as $u)
                        <option value="{{ $u->uuid }}">{{ $u->nombre_unidad }}</option>
                    @endforeach
                @endif
            </select>
            
        </div>
    </div>
    <table class="" width="100%">
        <thead style="text-align: center; background-color: #ccccff;">
            <tr>
                <th width="22%">ACCIONES CORTO PLAZO</th>
                <th width="10%">RESULTADO ESPERADO DE GESTION (%)</th>
                <th width="20%">OPERACIONES</th>
                <th width="20%">ACTIVIDADES</th>
                <th width="15%">RESULTADOS INTERMEDIOS ESPERADOS</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="text-align: center; background-color: #fff;">
            @if (!is_null($SelectedtUnidad))
                <div class="mt-2 d-flex justify-content-end">
                    <div class="x-dropdown">
                        <button class="x-dropdown-button boton default">Ver Reporte</button>
                        <ul class="x-dropdown-menu menu-right">
                            <li>
                                <a href="{{ route('operaciones_tareas.index', $SelectedtUnidad) }}" target="_blank">Operaciones Tareas</a>
                            </li>
                            <li>
                                <a href="{{ route('requerimientos.index', $SelectedtUnidad) }}" target="_blank">Requerimientos</a>
                            </li>
                        </ul>
                    </div>
                </div>
                @forelse ($corto_plazo_acciones as $acp)
                    <tr>
                        <td
                        <?php $row_acc = 0;
                        if ($acp->operaciones->count() >= 1) { $row_acc += $acp->operaciones->count(); }
                        foreach ($acp->operaciones as $op) {
                            if ($op->actividades->count() > 1) {
                                $row_acc += $op->actividades->count() - 1;
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
                                echo  $row_op > 1 ? "rowspan='$row_op'" : '';
                                ?>
                                >{{ $op->nombre_operacion }}</td>
                                {{-- primera actividad primera operacion --}}
                                @forelse ($op->actividades as $act)
                                    @if ($loop->first)
                                        <?php $var_op = $op ?>
                                        <td>{{$act->nombre_actividad}}</td>
                                        <td>{{$act->resultado_esperado}}</td>
                                        <td
                                            width="10%"
                                            <?php $row_btn = 0;
                                            if ($acp->operaciones->count() >= 1) { $row_btn += $acp->operaciones->count(); }
                                            foreach ($acp->operaciones as $op) {
                                                if ($op->actividades->count() > 1) {
                                                    $row_btn += $op->actividades->count() - 1;
                                                }
                                            }
                                            echo $row_btn > 1 ?  "rowspan='$row_btn'" : '';
                                            ?>
                                        >
                                            <a href="{{ route('actividades_accion_corto_plazo', $acp->uuid) }}" class="boton blue" target="_blank">Ver detalle</a>
                                        </td>
                                    @endif
                                @empty
                                    <td></td>
                                    <td></td>
                                    <td
                                    width="10%"
                                    <?php $row_btn = 0;
                                    if ($acp->operaciones->count() >= 1) { $row_btn += $acp->operaciones->count(); }
                                    foreach ($acp->operaciones as $op) {
                                        if ($op->actividades->count() > 1) {
                                            $row_btn += $op->actividades->count() - 1;
                                        }
                                    }
                                    echo $row_btn > 1 ?  "rowspan='$row_btn'" : '';
                                    ?>
                                    ><a href="{{ route('actividades_accion_corto_plazo', $acp->uuid) }}" class="boton blue" target="_blank">Ver detalle</a>
                                    </td>
                                @endforelse
                            @endif
                        @empty
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endforelse
                    </tr>

                    {{-- demas actividades primera operacion --}}
                    @if (isset($var_op))
                        @foreach ($var_op->actividades as $act)
                            @if (!$loop->first)
                                <tr>
                                    <td>{{$act->nombre_actividad}}</td>
                                    <td>{{$act->resultado_esperado}}</td>
                                </tr>
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
                                echo  $row_op > 1 ? "rowspan='$row_op'" : '';
                                ?>
                                >{{ $op->nombre_operacion }}</td>
                                {{-- primera actividad demas operaciones --}}
                                @forelse ($op->actividades as $act)
                                    @if ($loop->first)
                                        <?php $var_op2 = $op ?>
                                        <td>{{$act->nombre_actividad}}</td>
                                        <td>{{$act->resultado_esperado}}</td>
                                    @endif
                                @empty
                                    <td></td>
                                    <td></td>
                                @endforelse
                            </tr>

                            {{-- demas actividades demas operaciones --}}
                            @if (isset($var_op2))
                                @foreach ($var_op2->actividades as $act)
                                    @if (!$loop->first)
                                        <tr>
                                            <td>{{$act->nombre_actividad}}</td>
                                            <td>{{$act->resultado_esperado}}</td>
                                        </tr>
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
            @else
                <tr>
                    <td colspan="6">No se encontraron registros.</td>
                </tr>
            @endif

        </tbody>
    </table>
    {{--  --}}
</div>
