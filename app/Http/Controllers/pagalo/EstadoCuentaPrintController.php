<?php

namespace App\Http\Controllers\pagalo;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\pagalo\Models\Contrib;

class EstadoCuentaPrintController extends Controller
{
    // public function dataEstadoCuenta($anio_desde,$anio_hasta){

    //     $codigo = Session::get('SESS_CODIGO_CONTRI');

    //     unset($parametros);
    //     $parametros[] = array('@lsp_facodcontr',$codigo);
    //     $parametros[] = array('@lsp_facodtribu','');
    //     $parametros[] = array('@lsp_faanotribui',$anio_desde);
    //     $parametros[] = array('@lsp_faanotribuf',$anio_hasta);
    //     $parametros[] = array('@lsp_faanexoi','0000');
    //     $parametros[] = array('@lsp_faanexof','9999');
    //     $parametros[] = array('@lsp_faestrecib','P');
    //     $parametros[] = array('@lsp_fatipo','3');
    //     $parametros[] = array('@lsp_nocon','');
    //     $parametros[] = array('@lsp_notam','');
    //     $parametros[] = array('@lsp_faestado','PENDIENTE');
    //     $parametros[] = array('@ldt_fechaact',date('d-m-Y H:i:s'));
    //     $arbEcuenta = ejec_store_procedure_sql_sims("DBO.SP_RENTAS_LISTADO_CTACTE",$parametros);
    //     return $arbEcuenta;
    // }
    public function dataEstadoCuenta($anio_desde,$anio_hasta){

        $codigo = Session::get('SESS_CODIGO_CONTRI');

        unset($parametros);
        $parametros[] = array('@pfacodcontr',$codigo);
        $arbEcuenta = ejec_store_procedure_sql_sims("DBO.SP_CTACTE_ONLINE_2024",$parametros);
        return $arbEcuenta;
    }

    public function generatePdf(Request $request)
    {   
        header('Content-Type: text/html; charset=ISO-8859-1');
        
        $contribuyente = Contrib::where('FACODCONTR', Session::get('SESS_CODIGO_CONTRI'))->first();

        $fpdf = new CustomFpdf();
        $fpdf->AddPage();
        $fpdf->AliasNbPages();
        $fpdf->SetTitle('Estado de cuenta');
        $fpdf->Image('assets/images/logo-dark.png', 10, 10, 30);

        $fpdf->SetFont('Arial', '', 8);
        $fpdf->SetXY(40,13);
        $fpdf->Cell(65, 4, 'MUNICIPALIDAD DISTRITAL DE ANCÓN', 0, 1, 'R');
        $fpdf->Cell(61, 4, 'Gerencia de Rentas', 0, 1, 'R');
        
        
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(0, 10, 'ESTADO DE CUENTA', 0, 1, 'C');

        // Información del contribuyente
        $fpdf->SetX(5);
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->Cell(0, 4, 'Contribuyente: '.$contribuyente->FACODCONTR.' '.$contribuyente->FANOMCONTR, 0, 1);
        $fpdf->Ln(1);
        $fpdf->SetX(5);
        $fpdf->Cell(0, 4, 'Dom. fiscal: '.$contribuyente->direccion(), 0, 1);
        $fpdf->Ln(1);
        
        // Agregar tabla de impuestos
        $header = ['Tributo','Año', 'No.Recibo','Pe', 'Fec Venc.', 'Situación', 'Estado', 'Insoluto', 'Reajuste', 'Emisión', 'Costas','Total', 'Dscto','Total Pagar'];
        $headerWidth = [25, 8, 15, 5, 15, 15, 15, 15, 15, 15, 13, 15, 13, 17];

        #$data = $this->dataEstadoCuenta($request->anno_desde,$request->anno_hasta);
        $desde = 1995;
        $hasta = date('Y');
        $data = $this->dataEstadoCuenta($desde,$hasta);
        
        $fpdf->SetX(5);
        // Encabezados
        $fpdf->SetFont('Arial', 'B', 8);
        $i = 0;
        foreach ($header as $col) {
            $fpdf->Cell($headerWidth[$i], 7, utf8_decode($col), 1);
            #$fpdf->MultiCell($headerWidth[$i], 7, utf8_decode($col), 1);
            $i++;
        }
        $fpdf->Ln();

        // Datos
        $fpdf->SetFont('Arial', '', 7);
    
        $anio_group = null;
        $anexo_group = null;
        $tributo_group = null;

        $total_insoluto = 0;
        $total_reajuste = 0;
        $total_emision = 0;
        $total_costas = 0;
        $total_sub = 0;
        $total_dscto = 0;
        $total_total = 0;
        $total_pagar_group = 0;

        $total_pago = 0;
        $total_insoluto_g = 0;
        $total_reajuste_g = 0;
        $total_emision_g = 0;
        $total_costas_g = 0;
        $total_sub_g = 0;
        $total_dscto_g = 0;

        $total_fila = 0;

        $total_insoluto_s = 0;
        $total_reajuste_s = 0;
        $total_emision_s = 0;
        $total_costas_s = 0;
        $total_sub_s = 0;
        $total_dscto_s = 0;
        $total_pagar_group_s = 0;
        $total_total_s = 0;

        foreach ($data as $row) {
            $i = 0;
            $total_fila = $row->INSOLUTO+$row->FNMORA+$row->FNGASADMIN+$row->COSTAS-$row->DESCUENTO;


            $total_pago += $total_fila;
            $total_insoluto_g += $row->INSOLUTO;
            $total_reajuste_g += $row->FNMORA;
            $total_emision_g += $row->FNGASADMIN;
            $total_costas_g += $row->COSTAS;
            $total_dscto_g += $row->DESCUENTO;
            $total_sub_g += $row->SUB_TOTAL;

            if($anio_group !== null && $anio_group != $row->FAANOTRIBU || $anexo_group != $row->FAANEXO){
                if($total_pagar_group>0):
                    $fpdf->SetFont('Arial', 'B', 8);
                    $fpdf->SetX(5);
                    $fpdf->Cell($headerWidth[0], 6, 'Subtotal', 'T');
                    $fpdf->Cell($headerWidth[1], 6, '', 'T');
                    $fpdf->Cell($headerWidth[2], 6, '', 'T');
                    $fpdf->Cell($headerWidth[3], 6, '', 'T');
                    $fpdf->Cell($headerWidth[4], 6, '', 'T');
                    $fpdf->Cell($headerWidth[5], 6, '', 'T');
                    $fpdf->Cell($headerWidth[6], 6, '', 'T');
                    $fpdf->Cell($headerWidth[7], 6, number_format($total_insoluto,2), 'T');
                    $fpdf->Cell($headerWidth[8], 6, number_format($total_reajuste,2), 'T');
                    $fpdf->Cell($headerWidth[9], 6, number_format($total_emision,2), 'T');
                    $fpdf->Cell($headerWidth[10], 6, number_format($total_costas,2), 'T');
                    $fpdf->Cell($headerWidth[11], 6, number_format($total_sub,2), 'T');
                    $fpdf->Cell($headerWidth[12], 6, number_format($total_dscto,2), 'T');
                    $fpdf->SetTextColor(255, 0, 0);
                    $fpdf->Cell($headerWidth[13], 6, number_format($total_pagar_group,2), 'T');
                    $fpdf->SetTextColor(0, 0, 0);
                    $fpdf->Ln();
                
                endif;

                $total_insoluto = 0;
                $total_reajuste = 0;
                $total_emision = 0;
                $total_costas = 0;
                $total_sub = 0;
                $total_dscto = 0;
                $total_total = 0;
                $total_pagar_group = 0;
            }

            // if($tributo_group !== null && $tributo_group != $row->FADESTRIBU){
                
            //         $fpdf->SetFont('Arial', 'B', 8);
            //         $fpdf->SetX(5);
            //         $fpdf->Cell($headerWidth[0], 6, 'Subtotal Tributo', 'T');
            //         $fpdf->Cell($headerWidth[1], 6, '', 'T');
            //         $fpdf->Cell($headerWidth[2], 6, '', 'T');
            //         $fpdf->Cell($headerWidth[3], 6, '', 'T');
            //         $fpdf->Cell($headerWidth[4], 6, '', 'T');
            //         $fpdf->Cell($headerWidth[5], 6, '', 'T');
            //         $fpdf->Cell($headerWidth[6], 6, '', 'T');
            //         $fpdf->Cell($headerWidth[7], 6, number_format($total_insoluto_s,2), 'T');
            //         $fpdf->Cell($headerWidth[8], 6, number_format($total_reajuste_s,2), 'T');
            //         $fpdf->Cell($headerWidth[9], 6, number_format($total_emision_s,2), 'T');
            //         $fpdf->Cell($headerWidth[10], 6, number_format($total_costas_s,2), 'T');
            //         $fpdf->Cell($headerWidth[9], 6, number_format($total_sub,2), 'T');
            //         $fpdf->Cell($headerWidth[11], 6, number_format($total_dscto_s,2), 'T');
            //         $fpdf->SetTextColor(255, 0, 0);
            //         $fpdf->Cell($headerWidth[12], 6, number_format($total_pagar_group_s,2), 'T');
            //         $fpdf->SetTextColor(0, 0, 0);
            //         $fpdf->Ln();
                
            //         $total_insoluto_s = 0;
            //         $total_reajuste_s = 0;
            //         $total_emision_s = 0;
            //         $total_costas_s = 0;
            //         $total_dscto_s = 0;
            //         $total_total_s = 0;
            //         $total_pagar_group_s = 0;
            // }
            

            #agregar fila si en caso tiene anexo el grupo, quedaria de esta manera "ANEXO: 0001 - ARBITRIOS 2023 - aqui va direccion"
            if($anexo_group !== null && $anexo_group != $row->FAANEXO){
                $fpdf->SetFont('Arial', 'I', 7);
                $fpdf->SetX(5);
                $fpdf->SetTextColor(0, 0, 255);
                $fpdf->Cell($headerWidth[0], 4, utf8_decode(trim($row->DOMICILIO_PREDIO)));
                $fpdf->SetTextColor(0, 0, 0);
                $fpdf->Ln();
                $fpdf->SetFont('Arial', 'I', 7);
                $fpdf->SetX(5);
                $fpdf->Cell($headerWidth[0], 4, 'USO: '.utf8_decode(trim($row->USO_PREDIO)));
                $fpdf->Cell($headerWidth[0], 4, 'AUTOAVALUO: '.$row->AUTOAVALUO);
                $fpdf->SetTextColor(0, 0, 0);
                $fpdf->Ln();
            }

            $total_pagar_group += $row->INSOLUTO+$row->FNMORA+$row->FNGASADMIN+$row->COSTAS-$row->DESCUENTO;
            $total_insoluto += $row->INSOLUTO;
            $total_reajuste += $row->FNMORA;
            $total_emision += $row->FNGASADMIN;
            $total_costas += $row->COSTAS;
            $total_sub += $row->SUB_TOTAL;
            $total_dscto += $row->DESCUENTO;
            $total_total += $total_pagar_group;
            
            $total_pagar_group_s += $row->INSOLUTO+$row->FNMORA+$row->FNGASADMIN+$row->COSTAS-$row->DESCUENTO;
            $total_insoluto_s += $row->INSOLUTO;
            $total_reajuste_s += $row->FNMORA;
            $total_emision_s += $row->FNGASADMIN;
            $total_costas_s += $row->COSTAS;
            $total_sub_s += $row->SUB_TOTAL;
            $total_dscto_s += $row->DESCUENTO;
            $total_total_s += $total_pagar_group_s;


            $fpdf->SetFont('Arial', '', 7);
            $fpdf->SetX(5);
            $fpdf->Cell($headerWidth[0], 4, $row->FADESTRIBU, 0);
            $fpdf->SetFont('Arial', 'B', 7);
            $fpdf->Cell($headerWidth[1], 4, $row->FAANOTRIBU, 0);
            $fpdf->SetFont('Arial', '', 7);
            $fpdf->Cell($headerWidth[2], 4, $row->FANRORECIB, 0);
            $fpdf->Cell($headerWidth[3], 4, $row->FAPERIODO, 0);
            $fpdf->Cell($headerWidth[4], 4, Carbon::parse($row->FECVENC)->format('d/m/Y'), 0);
            $fpdf->Cell($headerWidth[5], 4, $row->SITUACION, 0);
            $fpdf->Cell($headerWidth[6], 4, $row->ESTADO, 0);
            $fpdf->Cell($headerWidth[7], 4, number_format($row->INSOLUTO,2), 0);
            $fpdf->Cell($headerWidth[8], 4, number_format($row->FNMORA,2), 0);
            $fpdf->Cell($headerWidth[9], 4, number_format($row->FNGASADMIN,2), 0);
            $fpdf->Cell($headerWidth[10], 4, number_format($row->COSTAS,2), 0);
            $fpdf->Cell($headerWidth[11], 4, number_format($row->SUB_TOTAL,2), 0);
            $fpdf->Cell($headerWidth[12], 4, number_format($row->DESCUENTO,2), 0);
            $fpdf->SetTextColor(255, 0, 0);
            $fpdf->Cell($headerWidth[13], 4, number_format($total_fila,2), 0);
            $fpdf->SetTextColor(0, 0, 0);
            $fpdf->Ln();

            $anio_group = $row->FAANOTRIBU;
            $anexo_group = $row->FAANEXO;
            $tributo_group = $row->FADESTRIBU;
        }

        if($anio_group !== null) {

            $fpdf->SetFont('Arial', 'B', 8);
            $fpdf->SetX(5);
            $fpdf->Cell($headerWidth[0], 4, 'Subtotal', 'T');
            $fpdf->Cell($headerWidth[1], 4, '', 'T');
            $fpdf->Cell($headerWidth[2], 4, '', 'T');
            $fpdf->Cell($headerWidth[3], 4, '', 'T');
            $fpdf->Cell($headerWidth[4], 4, '', 'T');
            $fpdf->Cell($headerWidth[5], 4, '', 'T');
            $fpdf->Cell($headerWidth[6], 4, '', 'T');
            $fpdf->Cell($headerWidth[7], 4, number_format($total_insoluto, 2), 'T');
            $fpdf->Cell($headerWidth[8], 4, number_format($total_reajuste, 2), 'T');
            $fpdf->Cell($headerWidth[9], 4, number_format($total_emision, 2), 'T');
            $fpdf->Cell($headerWidth[10], 4, number_format($total_costas, 2), 'T');
            $fpdf->Cell($headerWidth[11], 4, number_format($total_sub, 2), 'T');
            $fpdf->Cell($headerWidth[12], 4, number_format($total_dscto, 2), 'T');
            $fpdf->SetTextColor(255, 0, 0);
            $fpdf->Cell($headerWidth[13], 4, number_format($total_pagar_group, 2), 'T');
            $fpdf->SetTextColor(0, 0, 0);
            $fpdf->Ln();
        }
        // if($tributo_group !== null) {

        //     $fpdf->SetFont('Arial', 'B', 8);
        //     $fpdf->SetX(5);
        //     $fpdf->Cell($headerWidth[0], 4, 'Subtotal Tributo', 'T');
        //     $fpdf->Cell($headerWidth[1], 4, '', 'T');
        //     $fpdf->Cell($headerWidth[2], 4, '', 'T');
        //     $fpdf->Cell($headerWidth[3], 4, '', 'T');
        //     $fpdf->Cell($headerWidth[4], 4, '', 'T');
        //     $fpdf->Cell($headerWidth[5], 4, '', 'T');
        //     $fpdf->Cell($headerWidth[6], 4, number_format($total_insoluto_s, 2), 'T');
        //     $fpdf->Cell($headerWidth[7], 4, number_format($total_reajuste_s, 2), 'T');
        //     $fpdf->Cell($headerWidth[8], 4, number_format($total_emision_s, 2), 'T');
        //     $fpdf->Cell($headerWidth[9], 4, number_format($total_costas_s, 2), 'T');
        //     $fpdf->Cell($headerWidth[10], 4, number_format($total_dscto_s, 2), 'T');
        //     $fpdf->SetTextColor(255, 0, 0);
        //     $fpdf->Cell($headerWidth[11], 4, number_format($total_pagar_group_s, 2), 'T');
        //     $fpdf->SetTextColor(0, 0, 0);
        //     $fpdf->Ln();
        // }
        $fpdf->Ln(4);
        #suma total a pagar
        $fpdf->SetFont('Arial', 'B', 7);
        $fpdf->SetX(5);
        $fpdf->Cell($headerWidth[0], 6, 'DEUDA TOTAL', 'TB');
        $fpdf->Cell($headerWidth[1], 6, '', 'TB');
        $fpdf->Cell($headerWidth[2], 6, '', 'TB');
        $fpdf->Cell($headerWidth[3], 6, '', 'TB');
        $fpdf->Cell($headerWidth[4], 6, '', 'TB');
        $fpdf->Cell($headerWidth[5], 6, '', 'TB');
        $fpdf->Cell($headerWidth[6], 6, '', 'TB');
        $fpdf->Cell($headerWidth[7], 6, number_format($total_insoluto_g, 2), 'TB');
        $fpdf->Cell($headerWidth[8], 6, number_format($total_reajuste_g, 2), 'TB');
        $fpdf->Cell($headerWidth[9], 6, number_format($total_emision_g, 2), 'TB');
        $fpdf->Cell($headerWidth[10], 6, number_format($total_costas_g, 2), 'TB');
        $fpdf->Cell($headerWidth[11], 6, number_format($total_sub_g, 2), 'TB', 0, 'L');
        $fpdf->Cell($headerWidth[12], 6, number_format($total_dscto_g, 2), 'TB', 0, 'L');
        $fpdf->Cell($headerWidth[13], 6, number_format($total_pago, 2), 'TB', 0, 'L');
        $fpdf->Ln();
        $fpdf->Output('I', 'EstadoCuenta.pdf');
        exit;
            #'I', // I: Abre el diálogo de impresión, D: Descarga el archivo, F: Guarda el archivo en el servidor
            #'EstadoCuenta.pdf' // Nombre del archivo
        
        // Salida
        //return response($fpdf->Output(), 200)->header('Content-Type', 'application/pdf');
    }
}

class CustomFpdf extends Fpdf
{
    function Header()
    {
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'R');
        $this->Ln(10);
        $this->SetXY(181, 15);
        $this->Cell(0, 10, utf8_decode('Fecha: ').date('d/m/Y'), 0, 0, 'L');
        $this->Ln(10);
        $this->SetXY(181, 20);
        $this->Cell(0, 10, utf8_decode('Vía: Web'), 0, 0, 'L');
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm desde abajo
        #$this->SetY(-15);
        // Arial italic 8
        #$this->SetFont('Arial', 'I', 8);
        // Número de página
        #$this->Cell(0, 10, 'Página '.$this->PageNo().'/{nb}', 0, 0, 'R');
    }
}