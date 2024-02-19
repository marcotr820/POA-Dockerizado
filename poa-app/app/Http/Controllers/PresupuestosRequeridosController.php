<?php

namespace App\Http\Controllers;

use App\Models\CortoPlazoAcciones;
// use Barryvdh\DomPDF\Facade as PDF;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Http\Request;

class PresupuestosRequeridosController extends Controller
{
    public function lista_presupuestos(Request $request)
    {
        if($request->ajax())
        {
            $query = CortoPlazoAcciones::join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
            ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
            ->join('gerencias', 'gerencias.id', '=', 'unidades.gerencia_id')
            ->select('corto_plazo_acciones.accion_corto_plazo', 'corto_plazo_acciones.presupuesto_programado', 'corto_plazo_acciones.fecha_inicio',
            'trabajadores.nombre', 'unidades.nombre_unidad', 'gerencias.nombre_gerencia')
            ->whereBetween('fecha_inicio', [$request->get('fecha_inicio'), $request->get('fecha_fin')]);
            return datatables($query)->make(true);
        }

        return view('presupuestos_requeridos.index');
        
    }

    public function presupuestos_pdf($f_inicio = null, $f_fin = null)
    {
        // return "hi";
        is_null($f_fin) ? $data_fecha_fin = 'nulo' : $data_fecha_fin = $f_fin;
        is_null($f_inicio) ? $data_fecha_inicio = 'nulo' : $data_fecha_inicio = $f_inicio;
        
        $fecha = "Fecha Desde: $data_fecha_inicio Hasta: $data_fecha_fin"; 

        $datos = CortoPlazoAcciones::with('trabajador.unidad.gerencia')->get()->whereBetween('fecha_inicio', [$f_inicio, $f_fin]);
        $view = view('presupuestos_requeridos.presupuestos_pdf', compact('datos'));
        $html = $view->render();
        PDF::SetTitle('Reporte Presupuestos Requeridos');
        // Custom Header
        PDF::setHeaderCallback(function($pdf) use ($fecha) {
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(4); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 12);
            // Title
            $pdf->Cell(0, 7, 'Reporte Presupuestos Requeridos', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1); /*ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "$fecha", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        });
        // Custom Footer
        PDF::setFooterCallback(function($pdf) {
                // Position at 15 mm from bottom
                $pdf->SetY(-12);
                // Set font
                $pdf->SetFont('helvetica', 'I', 8);
                date_default_timezone_set('America/La_Paz');
                $fecha = date("Y-m-d H:i:s");
                // Page number
                $pdf->Cell(0,10,$fecha,0,0,'L');
                $pdf->Cell(10, 10, 'Página '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        });

        // PDF::SetMargins(7, 18, 7);
        PDF::SetAutoPageBreak(TRUE, 12); /*margin bottom*/
        PDF::SetMargins(5, 19, 5, true);   //SetMargins($left, $top, $right = -1, $keepmargins = false)
        PDF::addPage('L', 'A4'); //hoja horizontal carta
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('pdfXd.pdf', 'I');
    }
}
