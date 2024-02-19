<style>
    table{
        font-size: 6px;
    }
    .datos-head{
        background-color: #eee;
        font-size: 7px;
    }
</style>
@forelse ($mediano_plazo_acciones as $mpa)
    @if ($mpa->pei_objetivos_especificos->count())
        <table cellspacing="0" cellpadding="2" border="0.5" class="datos-head">
            <thead>
                <tr>
                    <td width="12%"><b>Pilar</b></td>
                    <td width="88%">{{ $mpa->resultado->meta->pilar->nombre_pilar }}</td>
                </tr>
                <tr>
                    <td width="12%"><b>Meta</b></td>
                    <td width="88%">{{ $mpa->resultado->meta->nombre_meta }}</td>
                </tr>
                <tr>
                    <td width="12%"><b>Resultado</b></td>
                    <td width="88%">{{ $mpa->resultado->nombre_resultado }}</td>
                </tr>
                <tr>
                    <td width="12%"><b>Acción Mediano Plazo</b></td>
                    <td width="88%">{{ $mpa->accion_mediano_plazo }}</td>
                </tr>
            </thead>
        </table>
        {{--  --}}
        <table cellspacing="0" cellpadding="3" border="0.5" style="margin-bottom: 10px;">
            <thead>
                <tr style="text-align: center;background-color:#686D76;color:white;font-weight:bold;">
                    <th rowspan="2">Objetivo Institucional Específico</th>
                    <th rowspan="2">Accion corto plazo Gestion {{ $gestion }}</th>
                    {{-- <th rowspan="2">Presupuesto Programado Gestion {{ $gestion }}</th>
                    <th rowspan="2">fecha prevista de inicio Gestion {{ $gestion }}</th>
                    <th rowspan="2">fecha prevista de finalización Gestion {{ $gestion }}</th>
                    <th rowspan="2">Resultado esperado Gestion {{ $gestion }}</th> --}}
                    <th rowspan="2">Operaciones</th>
                    <th rowspan="2">Actividades</th>
                    <th rowspan="2">Tareas especificas</th>
                    <th rowspan="2">Requerimiento (Bienes o Servicios)</th>
                    <th colspan="2">Presupeusto (Bs)</th>
                    <th colspan="4">Cronograma de ejecución por trimestres</th>

                </tr>
                <tr style="text-align: center;background-color:#686D76;color:white;font-weight:bold;">
                    <th>Funcionamiento</th>
                    <th>Inversión</th>

                    <th>1ER</th>
                    <th>2DO</th>
                    <th>3ER</th>
                    <th>4TO</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mpa->pei_objetivos_especificos as $obj)
                    <tr>
                        <td
                        <?php $row_obj = 0;
                        if ($obj->corto_plazo_acciones->count() >= 1) { $row_obj += $obj->corto_plazo_acciones->count(); }
                        foreach ($obj->corto_plazo_acciones as $cpa) {
                            if($cpa->operaciones->count() > 1){
                                $row_obj += $cpa->operaciones->count() - 1;
                                
                            }
                            foreach ($cpa->operaciones as $op) {
                                if ($op->actividades->count() > 1) {
                                    $row_obj += $op->actividades->count() - 1;
                                }
                                foreach ($op->actividades as $act) {
                                    if ($act->tareas_especificas->count() > 1) {
                                        $row_obj += $act->tareas_especificas->count() - 1;
                                    }
                                }
                            }
                        }
                        echo $row_obj > 1 ? 'rowspan="'.$row_obj.'"' : '';
                        ?>
                        >{{ $obj->objetivo_institucional }}</td>
                        {{--  --}}
                        @forelse ($obj->corto_plazo_acciones as $cpa)
                            <?php $var_obj = $obj ?>
                            @if ($loop->first)
                                <td
                                <?php $row_cpa = 0;
                                if ($cpa->operaciones->count() >= 1) { $row_cpa = $cpa->operaciones->count(); }
                                foreach ($cpa->operaciones as $op) {
                                    if($op->actividades->count() > 1){
                                        $row_cpa += $op->actividades->count() - 1;
                                    }
                                    foreach ($op->actividades as $act) {
                                        if ($act->tareas_especificas->count() > 1) {
                                            $row_cpa += $act->tareas_especificas->count() - 1;
                                        }
                                    }
                                }
                                echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : '';
                                ?>
                                >{{ $cpa->accion_corto_plazo }}</td>
                                {{-- primera operacion --}}
                                @foreach ($cpa->operaciones as $op)
                                    <?php $var_cpa = $cpa; ?>
                                    @if ($loop->first)
                                        <td
                                        <?php $row_op = 0;
                                        if ($op->actividades->count() >= 1) { $row_op += $op->actividades->count(); }
                                        foreach ($op->actividades as $act) {
                                            if ($act->tareas_especificas->count() > 1) {
                                                $row_op += $act->tareas_especificas->count() - 1;
                                            }
                                        }
                                        echo $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
                                        ?>
                                        >{{ $op->nombre_operacion }}</td>
                                        {{-- primera actividad --}}
                                        @foreach ($op->actividades as $act)
                                            <?php $var_op = $op; ?>
                                            @if ($loop->first)
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->tareas_especificas->count() >= 1) { $row_act += $act->tareas_especificas->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >{{ $act->nombre_actividad }}</td>
                                                {{-- primeta tarea --}}
                                                @foreach ($act->tareas_especificas as $tar)
                                                    <?php $var_act = $act ?>
                                                    @if ($loop->first)
                                                        <td>{{ $tar->nombre_tarea }}</td>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @empty
                        @endforelse
                    </tr>

                    {{-- demas tareas especificas --}}
                    @if (isset($var_act))
                        @foreach ($var_act->tareas_especificas as $tar)
                            @if (!$loop->first)
                                <tr>
                                    <td>{{ $tar->nombre_tarea }}</td>
                                </tr>
                            @endif
                        @endforeach
                        <?php unset($var_act) ?>
                    @endif

                    {{-- demas activividades --}}
                    @if (isset($var_op))
                        @foreach ($var_op->actividades as $act)
                            @if (!$loop->first)
                                <tr>
                                    <td
                                    <?php $row_act = 0;
                                    if ($act->tareas_especificas->count() >= 1) { $row_act += $act->tareas_especificas->count(); }
                                    echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                    ?>
                                    >{{ $act->nombre_actividad }}</td>
                                    {{-- primeta tarea especifica --}}
                                    @foreach ($act->tareas_especificas as $tar)
                                        <?php $var_act = $act ?>
                                        @if ($loop->first)
                                            <td>{{ $tar->nombre_tarea }}</td>
                                        @endif
                                    @endforeach
                                </tr>
                                {{-- demas tareas especificas --}}
                                @if (isset($var_act))
                                    @foreach ($var_act->tareas_especificas as $tar)
                                        @if (!$loop->first)
                                            <tr>
                                                <td>{{ $tar->nombre_tarea }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <?php unset($var_act) ?>
                                @endif
                            @endif
                        @endforeach
                        <?php unset($var_op) ?>
                    @endif

                    {{-- demas operaciones primera accion corto plazo --}}
                    @if (isset($var_cpa))
                        @foreach ($var_cpa->operaciones as $op)
                            @if (!$loop->first)
                                <tr>
                                    <td
                                    <?php $row_op = 0;
                                    if ($op->actividades->count() >= 1) { $row_op += $op->actividades->count(); }
                                    foreach ($op->actividades as $act) {
                                        if ($act->tareas_especificas->count() > 1) {
                                            $row_op += $act->tareas_especificas->count() - 1;
                                        }
                                    }
                                    echo $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
                                    ?>
                                    >{{ $op->nombre_operacion }}</td>
                                    {{-- primera actividad --}}
                                    @foreach ($op->actividades as $act)
                                        <?php $var_op = $op; ?>
                                        @if ($loop->first)
                                            <td
                                            <?php $row_act = 0;
                                            if ($act->tareas_especificas->count() >= 1) { $row_act += $act->tareas_especificas->count(); }
                                            echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                            ?>
                                            >{{ $act->nombre_actividad }}</td>
                                            {{-- primera tarea especifica --}}
                                            @foreach ($act->tareas_especificas as $tar)
                                                <?php $var_act = $act ?>
                                                @if ($loop->first)
                                                    <td>{{ $tar->nombre_tarea }}</td>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tr>

                                {{-- demas tareas especificas --}}
                                @if (isset($var_act))
                                    @foreach ($var_act->tareas_especificas as $tar)
                                        @if (!$loop->first)
                                            <tr>
                                                <td>{{ $tar->nombre_tarea }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <?php unset($var_act) ?>
                                @endif

                                {{-- demas actividades --}}
                                @if (isset($var_op))
                                    @foreach ($var_op->actividades as $act)
                                        @if (!$loop->first)
                                            <tr>
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->tareas_especificas->count() >= 1) { $row_act += $act->tareas_especificas->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >{{ $act->nombre_actividad }}</td>
                                                {{-- primeta tarea especifica --}}
                                                @foreach ($act->tareas_especificas as $tar)
                                                    <?php $var_act = $act ?>
                                                    @if ($loop->first)
                                                        <td>{{ $tar->nombre_tarea }}</td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                            {{-- demas tareas especificas --}}
                                            @if (isset($var_act))
                                                @foreach ($var_act->tareas_especificas as $tar)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td>{{ $tar->nombre_tarea }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <?php unset($var_act) ?>
                                            @endif
                                        @endif
                                    @endforeach
                                    <?php unset($var_op) ?>
                                @endif
                            @endif
                        @endforeach
                        <?php unset($var_cpa) ?>
                    @endif
                    
                    {{-- demas acciones corto plazo --}}
                    @if (isset($var_obj))
                        @foreach ($var_obj->corto_plazo_acciones as $cpa)
                            @if (!$loop->first)
                                <tr>
                                    <td
                                    <?php $row_cpa = 0;
                                    if ($cpa->operaciones->count() >= 1) { $row_cpa = $cpa->operaciones->count(); }
                                    foreach ($cpa->operaciones as $op) {
                                        if($op->actividades->count() > 1){
                                            $row_cpa += $op->actividades->count() - 1;
                                        }
                                        foreach ($op->actividades as $act) {
                                            if ($act->tareas_especificas->count() > 1) {
                                                $row_cpa += $act->tareas_especificas->count() - 1;
                                            }
                                        }
                                    }
                                    echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : '';
                                    ?>
                                    >{{ $cpa->accion_corto_plazo }}</td>
                                    {{-- primera operacion demas acciones corto plazo --}}
                                    @foreach ($cpa->operaciones as $op)
                                        <?php $var_cpa = $cpa; ?>
                                        @if ($loop->first)
                                            <td
                                            <?php $row_op = 0;
                                            if ($op->actividades->count() >= 1) { $row_op += $op->actividades->count(); }
                                            foreach ($op->actividades as $act) {
                                                if ($act->tareas_especificas->count() > 1) {
                                                    $row_op += $act->tareas_especificas->count() - 1;
                                                }
                                            }
                                            echo $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
                                            ?>
                                            >{{ $op->nombre_operacion }}</td>
                                            {{--primera actividad --}}
                                            @foreach ($op->actividades as $act)
                                                <?php $var_op = $op; ?>
                                                @if ($loop->first)
                                                    <td
                                                    <?php $row_act = 0;
                                                    if ($act->tareas_especificas->count() >= 1) { $row_act += $act->tareas_especificas->count(); }
                                                    echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                    ?>
                                                    >{{ $act->nombre_actividad }}</td>
                                                    {{-- primeta tarea especifica --}}
                                                    @foreach ($act->tareas_especificas as $tar)
                                                        <?php $var_act = $act ?>
                                                        @if ($loop->first)
                                                            <td>{{ $tar->nombre_tarea }}</td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tr>

                                {{-- demas tareas especificas --}}
                                @if (isset($var_act))
                                    @foreach ($var_act->tareas_especificas as $tar)
                                        @if (!$loop->first)
                                            <tr>
                                                <td>{{ $tar->nombre_tarea }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <?php unset($var_act) ?>
                                @endif

                                {{-- demas actividades --}}
                                @if (isset($var_op))
                                    @foreach ($var_op->actividades as $act)
                                        @if (!$loop->first)
                                            <tr>
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->tareas_especificas->count() >= 1) { $row_act += $act->tareas_especificas->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >{{ $act->nombre_actividad }}</td>
                                                {{-- primeta tarea especifica --}}
                                                @foreach ($act->tareas_especificas as $tar)
                                                    <?php $var_act = $act ?>
                                                    @if ($loop->first)
                                                        <td>{{ $tar->nombre_tarea }}</td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                            {{-- demas tareas especificas --}}
                                            @if (isset($var_act))
                                                @foreach ($var_act->tareas_especificas as $tar)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td>{{ $tar->nombre_tarea }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <?php unset($var_act) ?>
                                            @endif
                                        @endif
                                    @endforeach
                                    <?php unset($var_op) ?>
                                @endif

                                {{-- demas operaciones --}}
                                @if (isset($var_cpa))
                                    @foreach ($var_cpa->operaciones as $op)
                                        @if (!$loop->first)
                                            <tr>
                                                <td
                                                <?php $row_op = 0;
                                                if ($op->actividades->count() >= 1) { $row_op += $op->actividades->count(); }
                                                foreach ($op->actividades as $act) {
                                                    if ($act->tareas_especificas->count() > 1) {
                                                        $row_op += $act->tareas_especificas->count() - 1;
                                                    }
                                                }
                                                echo $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
                                                ?>
                                                >{{ $op->nombre_operacion }}</td>
                                                {{-- primera actvididad --}}
                                                @foreach ($op->actividades as $act)
                                                    <?php $var_op = $op; ?>
                                                    @if ($loop->first)
                                                        <td
                                                        <?php $row_act = 0;
                                                        if ($act->tareas_especificas->count() >= 1) { $row_act += $act->tareas_especificas->count(); }
                                                        echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                        ?>
                                                        >{{ $act->nombre_actividad }}</td>
                                                        {{-- primeta tarea especifica --}}
                                                        @foreach ($act->tareas_especificas as $tar)
                                                            <?php $var_act = $act ?>
                                                            @if ($loop->first)
                                                                {{-- <td>{{ $tar->nombre_tarea }}</td> --}}
                                                                <td>
                                                                    <ul style="text">
                                                                        <li>tarea_1 Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</li>
                                                                        <li>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Minus, hic.</li>
                                                                        <li>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Delectus quibusdam vel sapiente quaerat similique cupiditate.</li>
                                                                    </ul>
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </tr>

                                            {{-- demas tareas especificas --}}
                                            @if (isset($var_act))
                                                @foreach ($var_act->tareas_especificas as $tar)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td>{{ $tar->nombre_tarea }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <?php unset($var_act) ?>
                                            @endif

                                            {{-- demas actividades --}}
                                            @if (isset($var_op))
                                                @foreach ($var_op->actividades as $act)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td
                                                            <?php $row_act = 0;
                                                            if ($act->tareas_especificas->count() >= 1) { $row_act += $act->tareas_especificas->count(); }
                                                            echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                            ?>
                                                            >{{ $act->nombre_actividad }}</td>
                                                            {{-- primeta tarea especifica --}}
                                                            @foreach ($act->tareas_especificas as $tar)
                                                                <?php $var_act = $act ?>
                                                                @if ($loop->first)
                                                                    <td>{{ $tar->nombre_tarea }}</td>
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                        {{-- demas tareas especificas --}}
                                                        @if (isset($var_act))
                                                            @foreach ($var_act->tareas_especificas as $tar)
                                                                @if (!$loop->first)
                                                                    <tr>
                                                                        <td>{{ $tar->nombre_tarea }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            <?php unset($var_act) ?>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <?php unset($var_op) ?>
                                            @endif

                                        @endif
                                    @endforeach
                                    <?php unset($var_cpa) ?>
                                @endif
                            @endif
                        @endforeach
                        <?php unset($var_obj) ?>
                    @endif

                @empty
                @endforelse
            </tbody>
        </table>
        {{-- <br pagebreak="true" /> --}}
        <table border="0">
            <tr style="line-height: 35px;" > 
            <td></td>
            </tr>
        </table>
    @endif
@empty
        <p>nada</p>
@endforelse 