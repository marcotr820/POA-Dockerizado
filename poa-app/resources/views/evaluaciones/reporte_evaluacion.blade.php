<style>
    
</style>
@forelse ($corto_plazo_acciones as $cpa)
    <table cellspacing="0" cellpadding="5" border="0.5">
        <thead>
            <tr style="background-color: #eee; font-size: 7px;">
                <th>
                    <b>Accion corto plazo:</b> {{ $cpa->accion_corto_plazo }}
                    <hr>
                    <b>Fecha Inicio:</b> {{ $cpa->fecha_inicio }} &nbsp;&nbsp; <b>Fecha Fin:</b> {{ $cpa->fecha_fin }}
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($cpa->evaluaciones()->exists())
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="2" style="font-size: 7px; text-align:left;">
                            <tr style="font-weight: bold;">
                                <td style="border-bottom-width:0.1px;">Trimestre</td>
                                <td style="border-bottom-width:0.1px;">Resultado Esperado</td>
                                <td style="border-bottom-width:0.1px;">Resultado <br> Logrado</td>
                                <td style="border-bottom-width:0.1px;">Eficacia</td>
                                <td style="border-bottom-width:0.1px;">Presupuesto <br> (Bs.)</td>
                                <td style="border-bottom-width:0.1px;">Presupuesto Ejecutado (Bs.)</td>
                                <td style="border-bottom-width:0.1px;">Ejecución (%)</td>
                                <td style="border-bottom-width:0.1px;">Relacion Avance (%)</td>
                            </tr>
                            @foreach ($cpa->evaluaciones as $evaluacion)
                                <tr>
                                    <td>{{ ucfirst( str_replace("_", " ", $evaluacion->trimestre)) }}</td>
                                    <td>{{ $evaluacion->resultado_esperado }} %</td>
                                    <td>{{ $evaluacion->resultado_logrado }} %</td>
                                    <td>{{ $evaluacion->eficacia }} %</td>
                                    <td>{{ number_format($evaluacion->presupuesto, 2, '.', ',') }}</td>
                                    <td>{{ number_format($evaluacion->presupuesto_ejecutado, 2, '.', ',') }}</td>
                                    <td>{{ $evaluacion->ejecucion }} %</td>
                                    <td>{{ $evaluacion->relacion_avance }} %</td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td style="border-top-width:0.1px;"></td>
                                    <td style="border-top-width:0.1px;"></td>
                                    <td style="border-top-width:0.1px;"></td>
                                    <td style="border-top-width:0.1px;"></td>
                                    <td style="border-top-width:0.1px;"><b>Total</b></td>
                                    <td style="border-top-width:0.1px;">{{ number_format($cpa->evaluaciones->sum('presupuesto_ejecutado'), 2, '.', ',') }}</td>
                                    <td style="border-top-width:0.1px;">{{ $cpa->evaluaciones->sum('ejecucion') }} %</td>
                                    <td style="border-top-width:0.1px;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            @else
                <tr style="font-size: 8px;">
                    <td>Sin evaluaciones.</td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <table>
        <tr style="line-height: 15px;"><td></td></tr>
    </table>
@empty
    <table cellspacing="0" cellpadding="5" border="0.5" style="font-size: 8px;">
        <tr>
            <td>No se encontraron registros.</td>
        </tr>
    </table>
@endforelse