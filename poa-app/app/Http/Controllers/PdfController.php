<?php

namespace App\Http\Controllers;

use App\Models\CortoPlazoAcciones;
use App\Models\Gerencias;
use App\Models\Partidas;
use App\Models\Pilares;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF as PDF;

use function PHPUnit\Framework\isEmpty;

class PdfController extends Controller
{
    public function pdf_partida_grupo(Request $request)
    {
        // $gestion = $request->gestion;
        // return Gerencias::with(["items" => function($q) use ($gestion){
        //     $q->select('items.*')
        //     ->join('actividades as act1', 'act1.id', '=', 'items.actividad_id')
        //     ->join('operaciones as op1', 'op1.id', '=', 'actividades.operacion_id')
        //     ->join('corto_plazo_acciones as cpa1', 'cpa1.id', '=', 'operaciones.corto_plazo_accion_id')
        //     ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
        //     ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
        //     ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
        //     ->join('metas', 'metas.id', '=', 'resultados.meta_id')
        //     ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
        //     ->where('pilares.gestion_pilar', $gestion);
        // }])->get();

        // $grupos_partidas = [];
        // $i = 0;
        // $partidas = Partidas::get();
        // foreach ($partidas as $p) {
        //     if($i != substr($p->codigo_partida, 0,1)){
        //         $grupo = [];
        //         array_push($grupo, $p->codigo_partida);
        //         array_push($grupos_partidas, $grupo);
        //         $i++;
        //     }
        // }
        // // return $grupos_partidas;
        
        $gestion = $request->gestion;

        abort_if( !Pilares::where('gestion_pilar', $gestion)->exists(), 404);

        PDF::SetTitle('Generar Reporte');
        PDF::setHeaderCallback(function($pdf) use ($gestion){
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(3); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 12);
            // Title
            $pdf->Ln(2); /*ESPACIO ENTRE LINEAS*/
            $pdf->Cell(0, 7, 'Reporte Por Grupo Partida', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1); /*ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "Gestion: $gestion", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        });

        PDF::SetMargins(10, 20, 10); //SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // ---------------------------------------------------------
        // add a page
        PDF::AddPage();

        PDF::SetFont('helvetica', '', 8);

        //
        $array = [];
        $partidas = Partidas::with(["items" => function($q) use ($gestion){
            $q->select('items.*')
            ->join('actividades', 'actividades.id', '=', 'items.actividad_id')
            ->join('operaciones', 'operaciones.id', '=', 'actividades.operacion_id')
            ->join('corto_plazo_acciones', 'corto_plazo_acciones.id', '=', 'operaciones.corto_plazo_accion_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->where('pilares.gestion_pilar', $gestion);
        }])->orderBy('id', 'asc')->get();
        $i = 0;
        $last_id = $partidas->last()->id; 
        foreach ($partidas as $p) {
            if( $i != substr($p->codigo_partida, 0,1) )
            {
                if (isset($grupo)) {
                    array_push($array, $grupo);
                }
                $grupo = [];
                $i++;
            }

            if( $i == substr($p->codigo_partida, 0,1) ){
                array_push($grupo, $p);
            }

            if( $p->id == $last_id ){
                array_push($array, $grupo);
            }
        }
        // return $array[0][0]->items->sum('presupuesto');
        // return $array;
        $tbl = '';
        $tbl .= <<<EOD
        <table cellspacing="0" cellpadding="5" border="1" style="border-color:gray;text-align:center;">
            <thead>
            <tr style="background-color:#686D76;color:white;font-weight:bold;">
                <th>Grupo</th>
                <th>Partida</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
        EOD;
            $total = 0;
            for ($i=0; $i <= count($array) - 1 ; $i++) { 
                foreach ($array[$i] as $p) {
                    $sum_x_grupo = 0;
                    foreach ($array[$i] as $sub_partida) {
                        $sum_x_grupo += $sub_partida->items->sum('presupuesto');
                        $total += $sub_partida->items->sum('presupuesto');
                    }
                    $total_x_grupo = number_format($sum_x_grupo, 2, ".", ",");
                    $tbl .= <<<EOD
                    <tr>
                        <td> $p->codigo_partida </td>
                        <td> $p->nombre_partida </td>
                        <td> $total_x_grupo Bs.</td>
                    </tr>
                    EOD;
                    break;
                }
            }
            $total = number_format($total, 2, ".", ",");
            $tbl .= <<<EOD
            <tr>
                <td colspan="2"><b>TOTAL</b></td>
                <td><b>$total Bs.</b></td>  
            </tr>
            EOD;
        $tbl .= <<<EOD
            </tbody>
        </table>
        EOD; 

        PDF::writeHTML($tbl, true, false, false, false, '');

        // PDF::writeHTML($tbl, true, false, false, false, '');
        PDF::Output("partida_grupo_$gestion.pdf", 'I');
    }

    public function pdf_sub_grupos_partidas(Request $request)
    {
        $gestion = $request->gestion;
        // return Pilares::where('gestion_pilar', $gestion)->exists();
        abort_if( !Pilares::where('gestion_pilar', $gestion)->exists(), 404);
        PDF::SetTitle('Generar Reporte');
        PDF::setHeaderCallback(function($pdf) use ($gestion){
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(3); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 12);
            // Title
            $pdf->Ln(2); /*ESPACIO ENTRE LINEAS*/
            $pdf->Cell(0, 7, 'Reporte Por Sub Grupo Partida', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1); /*ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', '', 10);
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

        // $gestion = Pilares::select('gestion_pilar')->where('gestion_pilar', 2020)->get();
        $partidas = Partidas::with(["items" => function($q) use ($gestion){
            $q->select('items.*')
            ->join('actividades', 'actividades.id', '=', 'items.actividad_id')
            ->join('operaciones', 'operaciones.id', '=', 'actividades.operacion_id')
            ->join('corto_plazo_acciones', 'corto_plazo_acciones.id', '=', 'operaciones.corto_plazo_accion_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->where('pilares.gestion_pilar', $gestion);
        }])->orderBy('id', 'asc')->get();

        PDF::SetMargins(10, 20, 10); //SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, 10);
        // ---------------------------------------------------------
        // add a page
        PDF::AddPage();
        // return view('partidas.pdf_sub_grupos', compact('partidas', 'gestion'));
        $view = view('partidas.pdf_sub_grupos', compact('partidas', 'gestion'));
        $html = $view->render();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('pdfXd.pdf', 'I');
    }

    public function pdf_gerencia_grupo_partidas(Request $request)
    {
        $gestion = $request->gestion;
        
        abort_if( !Pilares::where('gestion_pilar', $gestion)->exists(), 404);

        $gerencia = Gerencias::where('uuid', $request->gerencia_uuid)->firstOrFail();
        $partidas = Partidas::with(["items" => function($q) use ($gestion, $gerencia){
            $q->select('items.*')
            ->join('actividades', 'actividades.id', '=', 'items.actividad_id')
            ->join('operaciones', 'operaciones.id', '=', 'actividades.operacion_id')
            ->join('corto_plazo_acciones', 'corto_plazo_acciones.id', '=', 'operaciones.corto_plazo_accion_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->where('pei_objetivos_especificos.gerencia_id', $gerencia->id)
            ->where('pilares.gestion_pilar', $gestion);
        }])->orderBy('id', 'asc')->get();
        $array_partidas = [];
        $i = 0;
        $last_id = $partidas->last()->id; 
        foreach ($partidas as $p) {
            // substraemos el primer digito
            if( $i != substr($p->codigo_partida, 0,1) )
            {
                if (isset($grupo)) {
                    array_push($array_partidas, $grupo);
                }
                $grupo = [];
                $i++;
            }

            if( $i == substr($p->codigo_partida, 0,1) ){
                array_push($grupo, $p);
            }

            if( $p->id == $last_id ){
                array_push($array_partidas, $grupo);
            }
        }

        PDF::SetTitle('Generar Reporte');
        PDF::setHeaderCallback(function($pdf) use ($gestion, $gerencia){
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(3); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 12);
            // Title
            $pdf->Ln(2); /*ESPACIO ENTRE LINEAS*/
            $pdf->Cell(0, 7, 'Reporte Partidas por Gerencia', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1); /*ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 5, "Gerencia: $gerencia->nombre_gerencia", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1);
            $pdf->Cell(0, 5, "Gestion: $gestion", 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        });
        PDF::SetMargins(10, 20, 10); //SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, 10);
        // ---------------------------------------------------------
        // add a page
        PDF::AddPage();
        // return $array_partidas;
        $view = view('partidas.pdf_por_grupo_gerencia', compact('array_partidas'));
        $html = $view->render();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('pdfXd.pdf', 'I');
    
    }

    public function pdf_gerencia_subgrupo_partidas(Request $request)
    {
        $gestion = $request->gestion;
        
        abort_if( !Pilares::where('gestion_pilar', $gestion)->exists(), 404);

        $gerencia = Gerencias::where('uuid', $request->gerencia_uuid)->firstOrFail();
        $partidas = Partidas::with(["items" => function($q) use ($gestion, $gerencia){
            $q->select('items.*')
            ->join('actividades', 'actividades.id', '=', 'items.actividad_id')
            ->join('operaciones', 'operaciones.id', '=', 'actividades.operacion_id')
            ->join('corto_plazo_acciones', 'corto_plazo_acciones.id', '=', 'operaciones.corto_plazo_accion_id')
            ->join('pei_objetivos_especificos', 'pei_objetivos_especificos.id', '=', 'corto_plazo_acciones.pei_objetivo_especifico_id')
            ->join('mediano_plazo_acciones', 'mediano_plazo_acciones.id', '=', 'pei_objetivos_especificos.mediano_plazo_accion_id')
            ->join('resultados', 'resultados.id', '=', 'mediano_plazo_acciones.resultado_id')
            ->join('metas', 'metas.id', '=', 'resultados.meta_id')
            ->join('pilares', 'pilares.id', '=', 'metas.pilar_id')
            ->where('pei_objetivos_especificos.gerencia_id', $gerencia->id)
            ->where('pilares.gestion_pilar', $gestion);
        }])->orderBy('id', 'asc')->get();

        PDF::SetTitle('Generar Reporte');
        PDF::setHeaderCallback(function($pdf) use ($gestion, $gerencia){
            $image_file = K_PATH_IMAGES.'logo_elapas.png'; //vendor/tecnickcom/examples/images
            $pdf->Image($image_file, 5, 2, 32, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
            // Set font
            $pdf->Ln(3); /*centrar y dar margin-top al title ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', 'B', 12);
            // Title
            $pdf->Ln(2); /*ESPACIO ENTRE LINEAS*/
            $pdf->Cell(0, 7, 'Reporte Partidas Por SubGrupo Gerencia', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(1); /*ESPACIO ENTRE LINEAS*/
            $pdf->SetFont('helvetica', '', 10);
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

        PDF::SetMargins(10, 20, 10); //SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, 10);
        // ---------------------------------------------------------
        // add a page
        PDF::AddPage();
        // return $array_partidas;
        $view = view('partidas.pdf_por_subgrupo_gerencia', compact('partidas', 'gestion'));
        $html = $view->render();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('pdfXd.pdf', 'I');
    }
}
