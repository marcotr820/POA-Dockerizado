<?php

namespace App\Http\Controllers;

use App\Models\CortoPlazoAcciones;
use App\Models\Pilares;
use App\Models\Trabajadores;
use App\Models\Unidades;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Http\Request;

class DeterminarRequerimientosController extends Controller
{
    public function index(Unidades $unidad){
        $date = Carbon::now()->addYear();
            $pilares = Pilares::select('gestion_pilar')
                ->groupBy('gestion_pilar')
                ->orderBy('gestion_pilar', 'ASC')
                ->get();
        if ($pilares->count()) {
            // si existe un pilar para la gestion siguiente se buscara los pilares con la gestion siguiente, si no se mostrara los pilares de la ultima gestion creada
            if ($pilares->last()->gestion_pilar == $date->year) {
                $gestion = $date->year;
            }else{
                $gestion = $pilares->last()->gestion_pilar;
            }
        }

        if (isset($gestion)) {
            $corto_plazo_acciones = CortoPlazoAcciones::join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
            ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->select('corto_plazo_acciones.*')
            ->orderBy('corto_plazo_acciones.id', 'asc')
            ->where('pilares.gestion_pilar', $gestion)
            ->where('unidades.id', $unidad->id)
            ->get();
        } else {
            $corto_plazo_acciones = [];
        }

        return view('reporte_requerimientos.index', compact('unidad', 'corto_plazo_acciones'));
    }

    public function requerimientos_pdf(Unidades $unidad)
    {
        $date = Carbon::now()->addYear();
            $pilares = Pilares::select('gestion_pilar')
                ->groupBy('gestion_pilar')
                ->orderBy('gestion_pilar', 'ASC')
                ->get();
        if ($pilares->count()) {
            // si existe un pilar para la gestion siguiente se buscara los pilares con la gestion siguiente, si no se mostrara los pilares de la ultima gestion creada
            if ($pilares->last()->gestion_pilar == $date->year) {
                $gestion = $date->year;
            }else{
                $gestion = $pilares->last()->gestion_pilar;
            }
        }

        if (isset($gestion)) {
            $corto_plazo_acciones = CortoPlazoAcciones::join('trabajadores', 'trabajadores.id', '=', 'corto_plazo_acciones.trabajador_id')
            ->join('unidades', 'unidades.id', '=', 'trabajadores.unidad_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->select('corto_plazo_acciones.*')
            ->orderBy('corto_plazo_acciones.id', 'asc')
            ->where('pilares.gestion_pilar', $gestion)
            ->where('unidades.id', $unidad->id)
            ->get();
        } else {
            $corto_plazo_acciones = [];
        }
        // return view('reporte_operaciones_tareas.reporte_pdf', compact('trabajador', 'acciones_corto_plazo'));
        $view = view('reporte_requerimientos.pdf_requerimientos', compact('unidad', 'corto_plazo_acciones'));
        $html = $view->render();
        PDF::SetTitle('Reporte Determinación Requerimientos');
        // Custom Header
        $gerencia = $unidad->gerencia;
        if(Pilares::count()){
            $v = Pilares::select('gestion_pilar')->groupBy('gestion_pilar')->orderBy('gestion_pilar', 'ASC')->get()->last();
            $gestion_pilar = $v->gestion_pilar;
        } else {
            $gestion_pilar = 'nulo';
        }
        PDF::setHeaderCallback(function($pdf) use ($gestion_pilar, $gerencia, $unidad) {
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(3); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 11);
            // Title
            $pdf->Cell(0, 7, 'Determinación de Requerimientos', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->SetFont('helvetica', '', 9);
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "Gerencia: $gerencia->nombre_gerencia", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "Unidad: $unidad->nombre_unidad", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "Gestion: $gestion_pilar", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
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

        // PDF::SetTitle('My Report');
        // PDF::SetMargins(7, 18, 7);
        PDF::SetAutoPageBreak(TRUE, 12); /*margin bottom*/
        PDF::SetMargins(5, 19, 5, true);   //SetMargins($left, $top, $right = -1, $keepmargins = false)
        PDF::addPage('L', 'A4'); //hoja horizontal carta
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('pdfXd.pdf', 'I');
    }

    public function pdf(Trabajadores $trabajador){
        $corto_plazo_acciones = CortoPlazoAcciones::where('trabajador_id', $trabajador->id)->get();
        // return view('reporte_requerimientos.pdf_requerimientos', compact('corto_plazo_acciones'));
        $view =  view('reporte_requerimientos.pdf_requerimientos', compact('corto_plazo_acciones'));
        $html = $view->render();
        $nombre_trabajador = $trabajador->nombre;
        $gerencia = $trabajador->unidad->gerencia->nombre_gerencia;
        $gestion = '2022';
        PDF::SetTitle('TITULO_ejemplooo');
        // Custom Header
        PDF::setHeaderCallback(function($pdf) use ($nombre_trabajador, $gerencia, $gestion) {
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(3); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 12);
            // Title
            $pdf->Cell(0, 7, 'Determinacion de requerimientos', 0, 1, 'C', 0, '', 0, false, 'M', 'M');

            $pdf->Ln(1); /*ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 5, 'Trabajador: '.$nombre_trabajador, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(2);
            $pdf->Cell(0, 5, 'Gerencia:'.$gerencia.' Gestion: '.$gestion, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
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
        // $corto_plazo_acciones = $trabajador->corto_plazo_acciones;
        // return view('reporte_requerimientos.pdf_requerimientos', compact('corto_plazo_acciones'));
    }
}