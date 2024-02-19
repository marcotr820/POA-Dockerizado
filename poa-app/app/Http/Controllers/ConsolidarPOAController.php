<?php

namespace App\Http\Controllers;

use App\Models\Gerencias;
use App\Models\MedianoPlazoAcciones;
use App\Models\PeiObjetivosEspecificos;
use App\Models\Pilares;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Http\Request;

class ConsolidarPOAController extends Controller
{
    public function index()
    {
        $gerencias = Gerencias::get();
        $pilar_gestion = Pilares::select('gestion_pilar')->groupBy('gestion_pilar')->orderBy('gestion_pilar', 'asc')->get();
        return view('consolidar.index', compact('gerencias', 'pilar_gestion'));

        // $objs = PeiObjetivosEspecificos::select('pei_objetivos_especificos.*')
        //     ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
        //     ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
        //     ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        //     ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
        //     ->where('pilares.gestion_pilar', 2023)
        //     ->where('pei_objetivos_especificos.gerencia_id', 3)
        //     ->orderBy('id', 'asc')
        //     // ->with('mediano_plazo_accion.resultado.meta.pilar')
        //     ->get();

    }

    public function pdf_consolidar(Request $request)
    {
        $gestion = $request->gestion;
        abort_if( !Pilares::where('gestion_pilar', $gestion)->exists(), 404);

        $gerencia = Gerencias::where('uuid', $request->gerencia)->firstOrFail();

        // wherehas solo devolvera las acciones mediano plazo que contengan la condicion dada
        $mediano_plazo_acciones = MedianoPlazoAcciones::select('mediano_plazo_acciones.*')->whereHas('pei_objetivos_especificos', function($q) use ($gerencia){
                $q->where('gerencia_id', $gerencia->id);
            })->with(['pei_objetivos_especificos' => function($q) use ($gerencia){
                // 'corto_plazo_acciones.operaciones.actividades.tareas_especificas'
                $q->where('gerencia_id', $gerencia->id)->with(['corto_plazo_acciones' => function($query){
                    $query->where('status', 'aprobado')
                        ->Orwhere('status', 'monitoreo')
                        ->with('operaciones.actividades.items');
                }])->orderBy('id', 'asc');
            }])
            ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->where('pilares.gestion_pilar', $request->gestion)
            ->orderBy('id', 'asc')
            ->get();

        // return $mediano_plazo_acciones = MedianoPlazoAcciones::select('mediano_plazo_acciones.*')->with(['pei_objetivos_especificos' => function($q) use ($gerencia){
        //     // 'corto_plazo_acciones.operaciones.actividades.tareas_especificas'
        //     $q->where('gerencia_id', $gerencia->id)->with(['corto_plazo_acciones' => function($query){
        //         $query->where('status', 'aprobado')->Orwhere('status', 'monitoreo');
        //     }])->orderBy('id', 'asc');
        // }])
        // ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
        // ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        // ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
        // ->where('pilares.gestion_pilar', $request->gestion)
        // ->orderBy('id', 'asc')
        // // ->limit(2)
        // ->get();

        // return view('consolidar.pdf_consolidar', compact('pilares'));
        $view = view('consolidar.pdf_consolidar', compact('mediano_plazo_acciones', 'gestion', 'gerencia'));

        $html = $view->render();
        PDF::SetTitle('Generar Reporte');
        PDF::setHeaderCallback(function($pdf) use ($gerencia, $gestion) {
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(3); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 11);
            // Title
            $pdf->Cell(0, 7, 'Reporte Consolidado Plan Operativo Anual', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            // $pdf->Ln(1); /*ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', '', 9);
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "Gerencia: $gerencia->nombre_gerencia", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "Gestion: $gestion", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        });

        PDF::setFooterCallback(function($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY(-12);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // date_default_timezone_set('America/La_Paz');
            // $fecha = date("Y-m-d H:i:s");
            // Page number
            $pdf->Cell(0,10,'',0,0,'L');
            $pdf->Cell(10, 10, 'Página '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        });

        PDF::SetMargins(5, 20, 5); //SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, 10); //margin boton del documento

        // ---------------------------------------------------------
        // add a page
        PDF::AddPage('L', 'A4');
        PDF::SetFont('helvetica', '', 8);
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output("Reporte_POA_$gestion.pdf", 'I');
    }
}
