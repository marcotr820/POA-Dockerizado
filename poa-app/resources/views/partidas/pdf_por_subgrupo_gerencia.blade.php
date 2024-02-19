<style>
    table{
        font-size: 6px;
    }
</style>
<table cellspacing="0" cellpadding="5" border="1" style="border-color:gray;text-align:center;">
    <thead>
        <tr style="background-color:#686D76;color:white;font-weight:bold;">
            <th width="10%">Codigo</th>
            <th width="70%">Partida</th>
            <th width="20%">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($partidas as $p)
            <tr>
                <td width="10%">{{ $p->codigo_partida }}</td>
                <td width="70%">{{ $p->nombre_partida }}</td>
                <td width="20%">{{ number_format($p->items->sum('presupuesto'), 2, ".", ",") }} Bs.</td>
                @php
                    $total = $total + $p->items->sum('presupuesto');
                @endphp
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background-color:#ddd;font-weight:bold;">
            <td></td>
            <td>TOTAL</td>
            <td>{{ number_format($total, 2, ".", ",") }} Bs.</td>
        </tr>
    </tfoot>
</table>