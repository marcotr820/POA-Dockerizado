<style>
    table{
        font-size: 8px;
    }
</style>
<table cellspacing="0" cellpadding="5" border="1" style="border-color:gray;text-align:center;">
    <thead>
        <tr style="background-color:#686D76;color:white;font-weight:bold;">
            <th>Grupo</th>
            <th>Partida</th>
            <th>Presupuesto</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        for ($i=0; $i <= count($array_partidas) - 1 ; $i++) { 
            foreach ($array_partidas[$i] as $p) {
                $sum_x_grupo = 0;
                foreach ($array_partidas[$i] as $sub_partida) {
                    $sum_x_grupo += $sub_partida->items->sum('presupuesto');
                    $total += $sub_partida->items->sum('presupuesto');
                }
                $total_x_grupo = number_format($sum_x_grupo, 2, ".", ",");
                echo "<tr>
                    <td> $p->codigo_partida </td>
                    <td> $p->nombre_partida </td>
                    <td> $total_x_grupo Bs.</td>
                    </tr>";
                break;
            }
        }
        $total = number_format($total, 2, ".", ",");
        echo "<tr>
                <td></td>
                <td colspan='2'><b>TOTAL</b></td>
                <td><b>$total Bs.</b></td>  
            </tr>"
        ?>
    </tbody>
</table>