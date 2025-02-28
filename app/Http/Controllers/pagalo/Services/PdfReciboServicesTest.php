<?php

namespace App\Http\Controllers\pagalo\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\pagalo\Models\Contrib;
use App\Http\Controllers\pagalo\Models\IngCaja;
use App\Http\Controllers\pagalo\Models\DetCaja;
use Illuminate\Support\Facades\DB;

class PdfReciboServicesTest
{
    public function generateRecibo($nroRecibo, $outputMode = 'I', $codigoContribuyente = null)
    {
        header('Content-Type: text/html; charset=ISO-8859-1');
        $contribuyente = Contrib::where('FACODCONTR', $codigoContribuyente)->first();

        $recibo = IngCaja::where('FACODCONTR', $codigoContribuyente)
            ->where('FANROOPERA', $nroRecibo)
            ->first();
        
        $caja = $recibo->FANROCAJA;
        $fecha = Carbon::parse($recibo->FDFECCAJA)->format('Y-d-m');
        $hora = Carbon::parse($recibo->FAHORAOPER)->format('H:i:s');

        $fecha_recibo = $fecha;

        $operacion = $recibo->FANROOPERA;
        $detalles_recibo = null;

        try {
            $sqlsrv_sims = DB::connection('sqlsrv_rentas');
            $sqlsrv_sims->beginTransaction();

            $sqlsrv_sims->statement("EXEC sp_caja_reimpresion_recibos_2024 ?, ?, ?, ?", array($fecha_recibo, $caja, $operacion, 'TR'));
            $detalles_recibo = $sqlsrv_sims->select("EXEC dbo.SP_CAJA_TMPRECIBO_REIMPRESION_2024 @vdfecha = ?, @vcnrocaja = ?, @vcnroopera = ?", array($fecha_recibo, $caja, $operacion));
            $sqlsrv_sims->statement("DELETE FROM REIMPRECIBO WHERE FECHA = ? AND CAJA = ? AND OPERACION = ?", array($fecha_recibo, $caja, $operacion));
            $sqlsrv_sims->commit();

        } catch (\Exception $e) {
            $sqlsrv_sims->rollBack();
            return response()->json(array('error' => $e->getMessage()), 500);
        }
        
        #$fpdf = new CustomFpdf('P', 'mm', array(100,230));
        $fpdf = new CustomFpdf('P', 'mm', 'A4');
        $fpdf->AddPage();
        $fpdf->AliasNbPages();
        $fpdf->SetTitle('Recibo de pago');
        $fpdf->Image('assets/images/logo-dark.png', 5, 5, 50);
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->Ln(15);
        $fpdf->SetX(5);
        $fpdf->Cell(80, 4, 'MUNICIPALIDAD DISTRITAL', 0, 1, 'L');
        $fpdf->Ln(1);
        $fpdf->SetX(5);
        $fpdf->Cell(80, 4, 'R.U.C. 20131378468', 0, 1, 'L');
        $fpdf->Ln(1);
        $fpdf->SetX(5);
        $fpdf->Cell(80, 4, 'Cod. Postal: Lima 34,', 0, 1, 'L');
        $fpdf->Ln(1);
        $fpdf->SetX(5);
        $fpdf->Cell(80, 4, utf8_decode('Jr. Manuel Iribarren Nº 155 - PERÚ'), 0, 1, 'L');
        $fpdf->Ln(1);
        $fpdf->SetX(5);
        $fpdf->Cell(80, 4, 'Telf: (01) 748-3838', 0, 1, 'L');
        $fpdf->Ln(1);
        $fpdf->SetX(5);
        $fpdf->Cell(80, 4, 'WhatsApp: (01) 241 0413', 0, 1, 'L');
        $fpdf->Ln(6);

        $fpdf->SetXY(120, 35);
        $fpdf->SetFont('Arial', 'B', 8);
        $fpdf->MultiCell(65, 4, 'CONTRIBUYENTE', 0, 'L');
        
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->Ln(1);
       $fpdf->SetXY(120, 40);
        $fpdf->Cell(80, 4, utf8_decode($contribuyente->FANOMCONTR), 0, 1, 'L');
        $fpdf->Ln(1);
       $fpdf->SetXY(120, 45);
        $fpdf->Cell(80, 4, 'Codigo: '.utf8_decode($contribuyente->FACODCONTR), 0, 1, 'L');
        $fpdf->Ln(1);
        #$fpdf->SetX(5);
        #$fpdf->Cell(80, 4, 'Dirección: '.utf8_decode($contribuyente->FACODCONTR), 0, 1, 'L');
        
        $y = $fpdf->GetY();
        #LADO DERECHO
        $fpdf->SetXY(120, 15);
        $fpdf->SetFont('Arial', '', 35);
        $fpdf->Cell(80, 4, 'Comprobante', 0, 1, 'R');
        $fpdf->SetXY(120, 22);
        $fpdf->SetFont('Arial', '', 14);
        $fpdf->Cell(80, 4, $detalles_recibo[0]->SITUACION, 0, 1, 'R');

        $fpdf->Ln(4);
        $fpdf->SetXY(120, 55);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(80, 4, 'Recibo Nro.: '.$operacion, 0, 1, 'L');
        $fpdf->Ln(1);
        $fpdf->SetX(120);
        $fpdf->Cell(80, 4, 'Fecha y Hora: '.$fecha_recibo.' '.$hora, 0, 1, 'L');


        #FIN LADO DERECHO
        $fpdf->Ln(8);
        $header = array('PERIODO', 'RECIBO', 'FECHA VENC.', 'MONTO', 'GASTOS', 'MORAS', 'COSTAS', 'DESCUENTO', 'TOTAL');
        $aligns = array('C', 'C', 'C', 'R', 'R', 'R', 'R', 'R', 'R');
        $headerWidth = array(20, 15, 25, 20, 20, 20, 20, 25, 30);
        
        $fpdf->SetX(5);
        $fpdf->SetFont('Arial', 'B', 9);
        $i = 0;
        foreach ($header as $col) {
            $fpdf->Cell($headerWidth[$i], 6, utf8_decode($col),1, 0 , $aligns[$i]);
            $i++;
        }
        $fpdf->Ln();

        $fpdf->SetFont('Arial', '', 7);
        $total_pagado = 0;
        $anexo_group = null;
        $anexo = null;
        foreach ($detalles_recibo as $detalle) {

            if ($anexo_group !== $detalle->QUIEBRE) {
                $anexo_group = $detalle->QUIEBRE;
                $anexo = $detalle->QUIEBRE;
                
                $fpdf->SetX(5);
                $fpdf->SetTextColor(0, 0, 255);
                $fpdf->MultiCell(190, 4, trim($detalle->TRIBUTO).' '.utf8_decode(trim($detalle->DESCRIPCION)), 0);
                $fpdf->SetTextColor(0, 0, 0);
                $fpdf->Ln(1);
            }
            $beneficio = trim($detalle->DESCUENTO) ? $detalle->DESCUENTO : 0;

            $total = $detalle->INSOLUTO+$detalle->EMISION+$detalle->MORAS+$detalle->COSTAS-$beneficio;
            $fpdf->SetX(5);
            $fpdf->Cell($headerWidth[0], 4, $detalle->PERIODO, 1, 0, 'C');
            $fpdf->Cell($headerWidth[1], 4, $detalle->RECIBO, 1, 0, 'C');
            $fpdf->Cell($headerWidth[2], 4, Carbon::parse($detalle->FECHA_VENCIMIENTO)->format('d/m/Y'), 1, 0, 'C');
            #$fpdf->Cell($headerWidth[3], 4, $detalle->SITUACION, 1, 0, 'R');
            $fpdf->Cell($headerWidth[3], 4, number_format($detalle->INSOLUTO,2), 1, 0, 'R');
            $fpdf->Cell($headerWidth[4], 4, number_format($detalle->EMISION,2), 1, 0, 'R');
            $fpdf->Cell($headerWidth[5], 4, number_format($detalle->MORAS,2), 1, 0, 'R');
            $fpdf->Cell($headerWidth[6], 4, number_format($detalle->COSTAS,2), 1, 0, 'R');
            $fpdf->Cell($headerWidth[7], 4, number_format($beneficio,2), 1, 0, 'R');
            $fpdf->Cell($headerWidth[8], 4, number_format($total,2), 1, 0, 'R');
            $fpdf->Ln();
            $total_pagado += $total;

        }

        $fpdf->Ln(4);
        $fpdf->SetX(5);
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(190, 6, 'TOTAL CANCELADO: S/. '.number_format($total_pagado,2), 'BT', 1, 'C');
        $fpdf->Ln(4);
        $fpdf->SetX(5);
        $fpdf->SetFont('Arial', '', 9);
        $fpdf->Cell(90, 4, 'Recibo Nro: '.$operacion, 0, 1, 'L');
        $fpdf->SetX(5);
        

        // Decidir si se descarga o se visualiza
        if ($outputMode === 'D') {
            return $fpdf->Output('D', "Recibo_$nroRecibo.pdf");
        } elseif ($outputMode === 'S') {
            return $fpdf->Output('S'); // Devuelve el PDF como string
        } else {
            return $fpdf->Output('I', "Recibo_$nroRecibo.pdf");
        }
    }
}
class CustomFpdf extends Fpdf
{
    function Header()
    {
    }
    function Footer()
    {
    }
}