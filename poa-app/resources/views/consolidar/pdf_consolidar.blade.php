<style>
    table{
        font-size: 5px;
    }
    .datos-head{
        background-color: #eee;
        font-size: 7px;
    }
</style>
<?php $total_programado = 0; ?>
@forelse ($mediano_plazo_acciones as $mpa)
    @if ($mpa->pei_objetivos_especificos->count())
        <table cellspacing="0" cellpadding="2" border="0.5" class="datos-head">
            <thead>
                <tr>
                    <td width="12%"><b>Pilar</b></td>
                    <td width="88%">
                        ( {{  $mpa->resultado->meta->pilar->codigo_pilar }} ) 
                        {{ $mpa->resultado->meta->pilar->nombre_pilar }}</td>
                </tr>
                <tr>
                    <td width="12%"><b>Meta</b></td>
                    <td width="88%">
                        ( {{ $mpa->resultado->meta->codigo_meta }} ) 
                        {{ $mpa->resultado->meta->nombre_meta }}</td>
                </tr>
                <tr>
                    <td width="12%"><b>Resultado</b></td>
                    <td width="88%">
                        ( {{ $mpa->resultado->codigo_resultado }} ) 
                        {{ $mpa->resultado->nombre_resultado }}</td>
                </tr>
                <tr>
                    <td width="12%"><b>Acción Mediano Plazo</b></td>
                    <td width="88%">
                        ( {{ $mpa->codigo_mediano_plazo }} ) 
                        {{ $mpa->accion_mediano_plazo }}</td>
                </tr>
            </thead>
        </table>
        {{--  --}}
        <table cellspacing="0" cellpadding="3" border="0.5" style="margin-bottom: 10px;">
            <thead>
                <tr style="text-align: center;font-weight:bold;background-color: #eee;">
                    <th rowspan="2">Acción Institucional Específica</th>
                    <th rowspan="2">Accion corto plazo Gestion {{ $gestion }}</th>
                    <th rowspan="2">Presupuesto Programado Gestion {{ $gestion }}</th>
                    <th rowspan="2">Unidad Responsable</th>
                    <th rowspan="2">fecha prevista de inicio</th>
                    <th rowspan="2">fecha prevista de finalización</th>
                    {{-- <th rowspan="2">Resultado esperado Gestion {{ $gestion }}</th> --}}
                    <th rowspan="2">Operaciones</th>
                    <th rowspan="2">Actividades</th>
                    <th rowspan="2">Tareas especificas</th>
                    <th rowspan="2">Requerimiento (Bienes o Servicios)</th>
                    <th rowspan="2">Presupuesto (Bs) (Bienes o Servicios)</th>
                    <th rowspan="2">Partida</th>
                    <th colspan="4">Cronograma de Ejecución Accion Corto Plazo Por Trimestre / (100%)</th>

                </tr>
                <tr style="text-align: center;font-weight:bold;background-color: #eee;">
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
                                    if ($act->items->count() > 1) {
                                        $row_obj += $act->items->count() - 1;
                                    }
                                }
                            }
                        }
                        echo $row_obj > 1 ? 'rowspan="'.$row_obj.'"' : '';
                        ?>
                        >{{ $obj->objetivo_institucional }}</td>
                        {{-- corto plazo acciones --}}
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
                                        if ($act->items->count() > 1) {
                                            $row_cpa += $act->items->count() - 1;
                                        }
                                    }
                                }
                                echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : '';
                                ?>
                                >{{ $cpa->accion_corto_plazo }}</td>
                                <td <?php echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : ''; ?> >{{ number_format($cpa->presupuesto_programado, 2, ".", ",") }} Bs.</td>
                                <td <?php echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : ''; ?> >{{ $cpa->trabajador->unidad->nombre_unidad }}</td>
                                <td <?php echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : ''; ?> >{{ $cpa->fecha_inicio }}</td>
                                <td <?php echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : ''; ?> >{{ $cpa->fecha_fin }}</td>
                                {{-- primera operacion --}}
                                @forelse ($cpa->operaciones as $op)
                                    <?php $var_cpa = $cpa; ?>
                                    @if ($loop->first)
                                        <td
                                        <?php $row_op = 0;
                                        if ($op->actividades->count() >= 1) { $row_op += $op->actividades->count(); }
                                        foreach ($op->actividades as $act) {
                                            if ($act->items->count() > 1) {
                                                $row_op += $act->items->count() - 1;
                                            }
                                        }
                                        echo $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
                                        ?>
                                        >{{ $op->nombre_operacion }}</td>
                                        {{-- primera actividad --}}
                                        @forelse ($op->actividades as $act)
                                            <?php $var_op = $op; ?>
                                            @if ($loop->first)
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >{{ $act->nombre_actividad }}</td>
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >
                                                    <ul style="font-size: 5px;">
                                                        @foreach ($act->tareas_especificas as $tar)
                                                            <li>{{ $tar->nombre_tarea }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                {{-- primeta item --}}
                                                @forelse ($act->items as $itm)
                                                    <?php $var_act = $act ?>
                                                    @if ($loop->first)
                                                        <td>{{ $itm->bien_servicio }}</td>
                                                        <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                        <td>{{ $itm->partida->codigo_partida }}</td>
                                                        <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->primer_trimestre != 0){echo $cpa->planificacion->primer_trimestre." %";} ?> </td>
                                                        <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->segundo_trimestre != 0){echo $cpa->planificacion->segundo_trimestre." %";} ?></td>
                                                        <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->tercer_trimestre != 0){echo $cpa->planificacion->tercer_trimestre." %";} ?></td>
                                                        <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->cuarto_trimestre != 0){echo $cpa->planificacion->cuarto_trimestre." %";} ?></td>
                                                    @endif

                                                @empty
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->primer_trimestre != 0){echo $cpa->planificacion->primer_trimestre." %";} ?> </td>
                                                    <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->segundo_trimestre != 0){echo $cpa->planificacion->segundo_trimestre." %";} ?></td>
                                                    <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->tercer_trimestre != 0){echo $cpa->planificacion->tercer_trimestre." %";} ?></td>
                                                    <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->cuarto_trimestre != 0){echo $cpa->planificacion->cuarto_trimestre." %";} ?></td>
                                                @endforelse
                                            @endif

                                        @empty
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->primer_trimestre != 0){echo $cpa->planificacion->primer_trimestre." %";} ?> </td>
                                            <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->segundo_trimestre != 0){echo $cpa->planificacion->segundo_trimestre." %";} ?></td>
                                            <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->tercer_trimestre != 0){echo $cpa->planificacion->tercer_trimestre." %";} ?></td>
                                            <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->cuarto_trimestre != 0){echo $cpa->planificacion->cuarto_trimestre." %";} ?></td>
                                        @endforelse
                                    @endif
                                    
                                @empty
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php if($cpa->planificacion()->exists() && $cpa->planificacion->primer_trimestre != 0){echo $cpa->planificacion->primer_trimestre." %";} ?></td>
                                <td><?php if($cpa->planificacion()->exists() && $cpa->planificacion->segundo_trimestre != 0){echo $cpa->planificacion->segundo_trimestre." %";} ?></td>
                                <td><?php if($cpa->planificacion()->exists() && $cpa->planificacion->tercer_trimestre != 0){echo $cpa->planificacion->tercer_trimestre." %";} ?></td>
                                <td><?php if($cpa->planificacion()->exists() && $cpa->planificacion->cuarto_trimestre != 0){echo $cpa->planificacion->cuarto_trimestre." %";} ?></td>
                                @endforelse
                            @endif
                        @empty
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @endforelse
                    </tr>

                    {{-- demas items --}}
                    @if (isset($var_act))
                        @foreach ($var_act->items as $itm)
                            @if (!$loop->first)
                                <tr>
                                    <td>{{ $itm->bien_servicio }}</td>
                                    <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                    <td>{{ $itm->partida->codigo_partida }}</td>
                                </tr>
                            @endif
                        @endforeach
                        <?php unset($var_act) ?>
                    @endif

                    {{-- demas activividades --}}
                    @if (isset($var_op))
                        @forelse ($var_op->actividades as $act)
                            @if (!$loop->first)
                                <tr>
                                    <td
                                    <?php $row_act = 0;
                                    if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                    echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                    ?>
                                    >{{ $act->nombre_actividad }}</td>
                                    <td
                                    <?php $row_act = 0;
                                    if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                    echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                    ?>
                                    >
                                        <ul style="font-size: 5px;">
                                            @foreach ($act->tareas_especificas as $tar)
                                                <li>{{ $tar->nombre_tarea }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    {{-- primer item --}}
                                    @forelse ($act->items as $itm)
                                        <?php $var_act = $act ?>
                                        @if ($loop->first)
                                            <td>{{ $itm->bien_servicio }}</td>
                                            <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                            <td>{{ $itm->partida->codigo_partida }}</td>
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
                                {{-- demas items --}}
                                @if (isset($var_act))
                                    @foreach ($var_act->items as $itm)
                                        @if (!$loop->first)
                                            <tr>
                                                <td>{{ $itm->bien_servicio }}</td>
                                                <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                <td>{{ $itm->partida->codigo_partida }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <?php unset($var_act) ?>
                                @endif
                            @endif

                        @empty
                        
                        @endforelse
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
                                        if ($act->items->count() > 1) {
                                            $row_op += $act->items->count() - 1;
                                        }
                                    }
                                    echo $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
                                    ?>
                                    >{{ $op->nombre_operacion }}</td>
                                    {{-- primera actividad --}}
                                    @forelse ($op->actividades as $act)
                                        <?php $var_op = $op; ?>
                                        @if ($loop->first)
                                            <td
                                            <?php $row_act = 0;
                                            if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                            echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                            ?>
                                            >{{ $act->nombre_actividad }}</td>
                                            <td
                                            <?php $row_act = 0;
                                            if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                            echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                            ?>
                                            >
                                                <ul style="font-size: 5px;">
                                                    @foreach ($act->tareas_especificas as $tar)
                                                        <li>{{ $tar->nombre_tarea }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            {{-- primera item --}}
                                            @forelse ($act->items as $itm)
                                                <?php $var_act = $act ?>
                                                @if ($loop->first)
                                                    <td>{{ $itm->bien_servicio }}</td>
                                                    <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                    <td>{{ $itm->partida->codigo_partida }}</td>
                                                @endif
                                            @empty
                                            <td></td>
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
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                </tr>

                                {{-- demas items --}}
                                @if (isset($var_act))
                                    @forelse ($var_act->items as $itm)
                                        @if (!$loop->first)
                                            <tr>
                                                <td>{{ $itm->bien_servicio }}</td>
                                                <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                <td>{{ $itm->partida->codigo_partida }}</td>
                                            </tr>
                                        @endif
                                    @empty
                                    
                                    @endforelse
                                    <?php unset($var_act) ?>
                                @endif

                                {{-- demas actividades --}}
                                @if (isset($var_op))
                                    @forelse ($var_op->actividades as $act)
                                        @if (!$loop->first)
                                            <tr>
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >{{ $act->nombre_actividad }}</td>
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >
                                                    <ul style="font-size: 5px;">
                                                        @foreach ($act->tareas_especificas as $tar)
                                                            <li>{{ $tar->nombre_tarea }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                {{-- primer item --}}
                                                @forelse ($act->items as $itm)
                                                    <?php $var_act = $act ?>
                                                    @if ($loop->first)
                                                        <td>{{ $itm->bien_servicio }}</td>
                                                        <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                        <td>{{ $itm->partida->codigo_partida }}</td>
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
                                            {{-- demas items --}}
                                            @if (isset($var_act))
                                                @foreach ($var_act->items as $itm)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td>{{ $itm->bien_servicio }}</td>
                                                            <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                            <td>{{ $itm->partida->codigo_partida }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <?php unset($var_act) ?>
                                            @endif
                                        @endif

                                    @empty
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                    <?php unset($var_op) ?>
                                @endif
                            @endif
                        @endforeach
                        <?php unset($var_cpa) ?>
                    @endif
                    
                    {{-- demas acciones corto plazo --}}
                    @if (isset($var_obj))
                        @forelse ($var_obj->corto_plazo_acciones as $cpa)
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
                                            if ($act->items->count() > 1) {
                                                $row_cpa += $act->items->count() - 1;
                                            }
                                        }
                                    }
                                    echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : '';
                                    ?>
                                    >{{ $cpa->accion_corto_plazo }}</td>
                                    <td <?php echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : ''; ?> >{{ number_format($cpa->presupuesto_programado, 2, ".", ",") }} Bs.</td>
                                    <td <?php echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : ''; ?> >{{ $cpa->trabajador->unidad->nombre_unidad }}</td>
                                    <td <?php echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : ''; ?> >{{ $cpa->fecha_inicio }}</td>
                                    <td <?php echo $row_cpa > 1 ? 'rowspan="'.$row_cpa.'"' : ''; ?> >{{ $cpa->fecha_fin }}</td>
                                    {{-- primera operacion demas acciones corto plazo --}}
                                    @forelse ($cpa->operaciones as $op)
                                        <?php $var_cpa = $cpa; ?>
                                        @if ($loop->first)
                                            <td
                                            <?php $row_op = 0;
                                            if ($op->actividades->count() >= 1) { $row_op += $op->actividades->count(); }
                                            foreach ($op->actividades as $act) {
                                                if ($act->items->count() > 1) {
                                                    $row_op += $act->items->count() - 1;
                                                }
                                            }
                                            echo $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
                                            ?>
                                            >{{ $op->nombre_operacion }}</td>
                                            {{--primera actividad --}}
                                            @forelse ($op->actividades as $act)
                                                <?php $var_op = $op; ?>
                                                @if ($loop->first)
                                                    <td
                                                    <?php $row_act = 0;
                                                    if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                    echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                    ?>
                                                    >{{ $act->nombre_actividad }}</td>
                                                    <td
                                                    <?php $row_act = 0;
                                                    if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                    echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                    ?>
                                                    >
                                                        <ul style="font-size: 5px;">
                                                            @foreach ($act->tareas_especificas as $tar)
                                                                <li>{{ $tar->nombre_tarea }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    {{-- primeta item --}}
                                                    @forelse ($act->items as $itm)
                                                        <?php $var_act = $act ?>
                                                        @if ($loop->first)
                                                            <td>{{ $itm->bien_servicio }}</td>
                                                            <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                            <td>{{ $itm->partida->codigo_partida }}</td>
                                                            <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->primer_trimestre != 0){echo $cpa->planificacion->primer_trimestre." %";} ?> </td>
                                                            <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->segundo_trimestre != 0){echo $cpa->planificacion->segundo_trimestre." %";} ?></td>
                                                            <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->tercer_trimestre != 0){echo $cpa->planificacion->tercer_trimestre." %";} ?></td>
                                                            <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->cuarto_trimestre != 0){echo $cpa->planificacion->cuarto_trimestre." %";} ?></td>
                                                        @endif

                                                    @empty
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->primer_trimestre != 0){echo $cpa->planificacion->primer_trimestre." %";} ?> </td>
                                                        <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->segundo_trimestre != 0){echo $cpa->planificacion->segundo_trimestre." %";} ?></td>
                                                        <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->tercer_trimestre != 0){echo $cpa->planificacion->tercer_trimestre." %";} ?></td>
                                                        <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->cuarto_trimestre != 0){echo $cpa->planificacion->cuarto_trimestre." %";} ?></td>
                                                    @endforelse
                                                @endif

                                            @empty
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->primer_trimestre != 0){echo $cpa->planificacion->primer_trimestre." %";} ?> </td>
                                                <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->segundo_trimestre != 0){echo $cpa->planificacion->segundo_trimestre." %";} ?></td>
                                                <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->tercer_trimestre != 0){echo $cpa->planificacion->tercer_trimestre." %";} ?></td>
                                                <td rowspan="<?php if($row_cpa > 1){echo $row_cpa;} ?>"> <?php if($cpa->planificacion()->exists() && $cpa->planificacion->cuarto_trimestre != 0){echo $cpa->planificacion->cuarto_trimestre." %";} ?></td>
                                            @endforelse
                                        @endif

                                    @empty
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php if($cpa->planificacion()->exists() && $cpa->planificacion->primer_trimestre != 0){echo $cpa->planificacion->primer_trimestre." %";} ?></td>
                                        <td><?php if($cpa->planificacion()->exists() && $cpa->planificacion->segundo_trimestre != 0){echo $cpa->planificacion->segundo_trimestre." %";} ?></td>
                                        <td><?php if($cpa->planificacion()->exists() && $cpa->planificacion->tercer_trimestre != 0){echo $cpa->planificacion->tercer_trimestre." %";} ?></td>
                                        <td><?php if($cpa->planificacion()->exists() && $cpa->planificacion->cuarto_trimestre != 0){echo $cpa->planificacion->cuarto_trimestre." %";} ?></td>
                                    @endforelse
                                </tr>

                                {{-- demas items --}}
                                @if (isset($var_act))
                                    @foreach ($var_act->items as $itm)
                                        @if (!$loop->first)
                                            <tr>
                                                <td>{{ $itm->bien_servicio }}</td>
                                                <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                <td>{{ $itm->partida->codigo_partida }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <?php unset($var_act) ?>
                                @endif

                                {{-- demas actividades --}}
                                @if (isset($var_op))
                                    @forelse ($var_op->actividades as $act)
                                        @if (!$loop->first)
                                            <tr>
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >{{ $act->nombre_actividad }}</td>
                                                <td
                                                <?php $row_act = 0;
                                                if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                ?>
                                                >
                                                    <ul style="font-size: 5px;">
                                                        @foreach ($act->tareas_especificas as $tar)
                                                            <li>{{ $tar->nombre_tarea }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                {{-- primer item --}}
                                                @forelse ($act->items as $itm)
                                                    <?php $var_act = $act ?>
                                                    @if ($loop->first)
                                                        <td>{{ $itm->bien_servicio }}</td>
                                                        <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                        <td>{{ $itm->partida->codigo_partida }}</td>
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
                                            {{-- demas items --}}
                                            @if (isset($var_act))
                                                @foreach ($var_act->items as $itm)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td>{{ $itm->bien_servicio }}</td>
                                                            <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                            <td>{{ $itm->partida->codigo_partida }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <?php unset($var_act) ?>
                                            @endif
                                        @endif

                                    @empty
                                    
                                    @endforelse
                                    <?php unset($var_op) ?>
                                @endif

                                {{-- demas operaciones --}}
                                @if (isset($var_cpa))
                                    @forelse ($var_cpa->operaciones as $op)
                                        @if (!$loop->first)
                                            <tr>
                                                <td
                                                <?php $row_op = 0;
                                                if ($op->actividades->count() >= 1) { $row_op += $op->actividades->count(); }
                                                foreach ($op->actividades as $act) {
                                                    if ($act->items->count() > 1) {
                                                        $row_op += $act->items->count() - 1;
                                                    }
                                                }
                                                echo $row_op > 1 ? 'rowspan="'.$row_op.'"' : '';
                                                ?>
                                                >{{ $op->nombre_operacion }}</td>
                                                {{-- primera actvididad --}}
                                                @forelse ($op->actividades as $act)
                                                    <?php $var_op = $op; ?>
                                                    @if ($loop->first)
                                                        <td
                                                        <?php $row_act = 0;
                                                        if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                        echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                        ?>
                                                        >{{ $act->nombre_actividad }}</td>
                                                        <td
                                                        <?php $row_act = 0;
                                                        if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                        echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                        ?>
                                                        >
                                                            <ul style="font-size: 5px;">
                                                                @foreach ($act->tareas_especificas as $tar)
                                                                    <li>{{ $tar->nombre_tarea }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        {{-- primer item --}}
                                                        @forelse ($act->items as $itm)
                                                            <?php $var_act = $act ?>
                                                            @if ($loop->first)
                                                                <td>{{ $itm->bien_servicio }}</td>
                                                                <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                                <td>{{ $itm->partida->codigo_partida }}</td>
                                                            @endif
                                                        @empty
                                                        <td></td>
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
                                                    <td></td>
                                                    <td></td>
                                                @endforelse
                                            </tr>

                                            {{-- demas items --}}
                                            @if (isset($var_act))
                                                @foreach ($var_act->items as $itm)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td>{{ $itm->bien_servicio }}</td>
                                                            <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                            <td>{{ $itm->partida->codigo_partida }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <?php unset($var_act) ?>
                                            @endif

                                            {{-- demas actividades --}}
                                            @if (isset($var_op))
                                                @forelse ($var_op->actividades as $act)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td
                                                            <?php $row_act = 0;
                                                            if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                            echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                            ?>
                                                            >{{ $act->nombre_actividad }}</td>
                                                            <td
                                                            <?php $row_act = 0;
                                                            if ($act->items->count() >= 1) { $row_act += $act->items->count(); }
                                                            echo $row_act > 1 ? 'rowspan="'.$row_act.'"' : '';
                                                            ?>
                                                            >
                                                                <ul style="font-size: 5px;">
                                                                    @foreach ($act->tareas_especificas as $tar)
                                                                        <li>{{ $tar->nombre_tarea }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </td>
                                                            {{-- primer item --}}
                                                            @forelse ($act->items as $itm)
                                                                <?php $var_act = $act ?>
                                                                @if ($loop->first)
                                                                    <td>{{ $itm->bien_servicio }}</td>
                                                                    <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                                    <td>{{ $itm->partida->codigo_partida }}</td>
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
                                                        {{-- demas items --}}
                                                        @if (isset($var_act))
                                                            @foreach ($var_act->items as $itm)
                                                                @if (!$loop->first)
                                                                    <tr>
                                                                        <td>{{ $itm->bien_servicio }}</td>
                                                                        <td>{{ number_format($itm->presupuesto, 2, ".", ",") }} Bs.</td>
                                                                        <td>{{ $itm->partida->codigo_partida }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            <?php unset($var_act) ?>
                                                        @endif
                                                    @endif

                                                @empty
                                                
                                                @endforelse
                                                <?php unset($var_op) ?>
                                            @endif

                                        @endif

                                    @empty
                                    
                                    @endforelse
                                    <?php unset($var_cpa) ?>
                                @endif
                            @endif

                        @empty
                        
                        @endforelse
                        <?php unset($var_obj) ?>
                    @endif

                    

                    {{-- contador de total pressupuestos --}}
                    <?php
                    foreach ($obj->corto_plazo_acciones as $cpa) {
                        foreach ($cpa->operaciones as $op) {
                            foreach ($op->actividades as $act) {
                                foreach ($act->items as $itm) {
                                    $total_programado += $itm->presupuesto;
                                }
                            }
                        }
                    }
                    ?>
                @empty
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    {{-- calculamos el total de presupuesto por accion mediano plazo --}}
                    <?php $total_x_mediano_plazo_accion = 0;
                    foreach ($mpa->pei_objetivos_especificos as $obj) {
                        foreach ($obj->corto_plazo_acciones as $cpa) {
                            foreach ($cpa->operaciones as $op) {
                                foreach ($op->actividades as $act) {
                                    foreach ($act->items as $itm) {
                                        $total_x_mediano_plazo_accion += $itm->presupuesto;
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    <td><b>TOTAL</b></td>
                    <td><b>{{ number_format($total_x_mediano_plazo_accion, 2, ".", ",") }} Bs.</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        {{-- <br pagebreak="true" /> --}}
        <table border="0">
            <tr style="line-height: 20px;"> 
            <td></td>
            </tr>
        </table>
    @else
    @endif



    @if ($loop->last)
        <table cellspacing="0" cellpadding="2" border="0.5">
            <tr style="font-weight:bold;  background-color: #002b80; color:#fff;">
                <td>GERENCIA</td>
                <td>TOTAL PPTP. PROGRAMADO</td>
            </tr>
            <tr>
                <td>{{ $gerencia->nombre_gerencia }}</td>
                <td>{{ number_format($total_programado, 2, ".", ",") }} Bs.</td>
            </tr>
        </table>
    @endif

@empty
    <table cellspacing="0" cellpadding="5" border="0.5" style="font-size: 10px;text-align:center;">
        <tr>
            <td>No se encontraron resultados.</td>
        </tr>
    </table>
@endforelse 