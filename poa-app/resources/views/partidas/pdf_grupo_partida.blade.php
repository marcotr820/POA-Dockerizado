<style>
    table{
        font-size: 6px;
        text-align: center;
    }
</style>
<table border="0.5" cellpadding="5">
    <thead>
        <tr style="background-color:#686D76;color:white;font-weight:bold;">
            <th>Gerencia</th>
            @foreach ($grupos_partidas as $gp)
                <th>{{ $gp[0] }}</th>
            @endforeach
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        foreach ($gerencias as $g) {
            echo "<tr>";
                echo "<td>$g->nombre_gerencia</td>";
                $total_x_grupo = 0;
                for ($i=1; $i <= count($grupos_partidas) ; $i++) { 
                    $sum = 0;
                    foreach ($g->unidades as $unidad) {
                        foreach ($unidad->trabajadores as $trabajador) {
                            foreach ($trabajador->corto_plazo_acciones as $cpa) {
                                foreach ($cpa->items as $item) {
                                    if ($i == substr($item->partida->codigo_partida, 0,1)) {
                                        $sum += $item->presupuesto;
                                        $total_x_grupo += $item->presupuesto;
                                        $total += $item->presupuesto;
                                    }
                                }
                            }
                        }
                    }
                    echo "<td>".number_format($sum, 2, ".", ",")."</td>";
                }
                echo "<td>".number_format($total_x_grupo, 2, ".", ",")."</td>";
            echo "</tr>";
        }    
        ?>
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
            <td><b>Total</b></td>
            <td>{{ number_format($total, 2, ".", ",") }}</td>
        </tr>
    </tfoot>
</table>