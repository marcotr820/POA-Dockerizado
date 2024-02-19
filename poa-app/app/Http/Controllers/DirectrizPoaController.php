<?php

namespace App\Http\Controllers;

use App\Models\MedianoPlazoAcciones;
use App\Models\Metas;
use App\Models\Pilares;
use App\Models\Resultados;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Barryvdh\DomPDF\Facade\Pdf as DPDF;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
class DirectrizPoaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:PLANIFICADOR']);
    }

    public function index()
    {
        $gestion_pilares = Pilares::select('gestion_pilar')->groupBy('gestion_pilar')->orderBy('gestion_pilar', 'asc')
            // ->addSelect([
            //     'total_metas_pilar' => Metas::selectRaw('COUNT(*)')
            //     ->whereColumn('metas.pilar_id', 'pilares.id')
            // ])
            // ->addSelect([
            //     'total_resultados_pilar' => Resultados::selectRaw('COUNT(*)')
            //     ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            //     ->whereColumn('metas.pilar_id', 'pilares.id')
            // ])
            // ->addSelect([
            //     'total_mediano_plazo_pilar' => MedianoPlazoAcciones::selectRaw('COUNT(*)')
            //     ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
            //     ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            //     ->whereColumn('metas.pilar_id', 'pilares.id')
            // ])
            ->get();
        return view('directriz_poa.index', compact('gestion_pilares'));
    }

    public function directriz_pdf(Request $request)
    {
        // $pilares = Pilares::query()->select('id', 'nombre_pilar')
        //     ->addSelect([
        //         'total_mediano_plazo_pilar' => MedianoPlazoAcciones::selectRaw('COUNT(*)')
        //         ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
        //         ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        //         ->whereColumn('metas.pilar_id', 'pilares.id')
        //     ])
        //     ->get();

        $pilares = Pilares::where('gestion_pilar', $request->gestion)->orderBy('id', 'asc')->with('metas.resultados.acciones_mediano_plazo.pei_objetivos_especificos')->get();

        $view = view('directriz_poa.directriz_pdf', compact('pilares'));
        $html = $view->render();
        PDF::SetTitle('Directriz POA');
        // Custom Header
        if($pilares){
            $gestion = $request->gestion;
        } else {
            $gestion = 'nulo';
        }
        PDF::setHeaderCallback(function($pdf) use ($gestion){
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(3); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 12);
            // Title
            $pdf->Ln(2); /*ESPACIO ENTRE LINEAS*/
            $pdf->Cell(0, 7, 'Reporte Directriz POA', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1); /*ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "Gestion: $gestion", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
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
        PDF::SetAutoPageBreak(TRUE, 12); /*margin bottom*/
        PDF::SetMargins(5, 19, 5, true);   //SetMargins($left, $top, $right = -1, $keepmargins = false)
        PDF::addPage('L', 'A4'); //hoja horizontal carta
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('pdfXd.pdf', 'I');

    }
}
