<?php
// require 'libpdf/jlpdf.php';
// require 'libpdf/rpdf.php';
// require 'model/querys.php';

// if ($_GET)
//     $param = $_GET;
// else if ($_POST)
//     $param = $_POST;

// $c_idcont = base64_decode($param['c_idcont']);

// $GetDdjj=query::GetDdjj($c_idcont);
// $ddjj=$GetDdjj->ddjj;

// if(!$ddjj){
//   echo "No hay Cuponera";
//   exit;
// }

// class Cuponera extends RPDF {

//     public function __construct($o = 'P', $m = 'mm', $f = 'A5') {
//         parent::__construct($o, $m, $f);
//     }

//     function Footer1(){
//         $this->SetFont('Arial','B',6);
//         $this->SetY(-15);
//         $this->setX(5);
//         $this->Cell(140,5,'LUGARES DE PAGO MUNICIPALIDAD DE LA VICTORIA','T',1,'C');
//         $this->setX(5);
//         $this->Cell(140,4,'Pago en Tesoreria Municipalidad - HORARIO : L-V 8am a 7pm , Sab. 9am a 1 pm','T',1,'C');
//         $this->setX(5);
//         $this->Cell(140,4,'Pagos en linea : www.munilavictoria.gob.pe','B',1,'C');

//     }

//     function footerHr(){
//         $this->SetFont('Arial','B',6);
//         $this->SetY(-15);
//         $this->setX(5);
//         $this->Cell(50,3,'IMPORTANTE',0,1,'L');
//         $this->setX(5);
//         $this->MultiCell(140,3,utf8_decode('Esta información tendra efectos de Declaración Jurada del Impuesto Predial para el presente año si no se presenta observación alguna hasta el 29 de febrero del 2021'),0,1,'C');
//         $this->setX(5);
//         $this->Cell(140,4,'Page '.$this->PageNo().'/{nb}',0,0,'R');
//         // $this->Cell(140,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
//     }

//     function footerPu(){
//         $this->SetFont('Arial','',6);
//         $this->SetY(-20);
//         $this->setX(5);
//         $this->MultiCell(140,3,utf8_decode('EL PRESENTE DOCUMENTO SUSTITUYE SU OBLIGACIÓN DE PRESENTAR LA DECLARACIÓN JURADA ANUAL 2020. LOS DATOS CONTENIDOS EN ELLA SE CONSIDERAN VÁLIDOS MIENTRAS NO PRESENTE UNA DECLARACIÓN JURADA SUSTITUTORIA, CUYO PLAZO VENCE EL 29/02/2020, SIN PERJUICIO DE LA FISCALIZACIÓN POSTERIOR POR PARTE DE LA ADMINISTRACIÓN ART. 14 DEL D.S. 156-2004-EF'),1,1,'C');
//         $this->setX(5);
//         $this->SetFont('Arial','B',6);
//         $this->Cell(140,4,'Page '.$this->PageNo().'/{nb}',0,1,'R');
//     }

//     function footerHlp(){
//         $this->SetFont('Arial','B',6);
//         $this->SetY(-40);
//         $this->setX(5);
//         $this->Cell(140,27,'',1,0);
//         $this->setX(5);
//         $this->Cell(140,3,utf8_decode('IMPORTANTE'),0,1,'L');
//         $this->SetFont('Arial','',6);

//         $this->setX(5);
//         $this->MultiCell(140,3,utf8_decode('Recuerde, si efectua el pago al contado de todo el Impuesto Predial hasta el 27 de febrero de 2021, no está sujeto a la variación de índice de Precios al por Mayor.'),0,1,'L');
//         $this->Ln(2);
//         $this->setX(5);
//         $this->MultiCell(140,3,utf8_decode('* El monto mínimo del Impuesto Predial es el 0.6% de la UIT vigente en el año, según lo establecido en el Art. 13 del TUO de la Ley de Tributación Municipal aprobado por D.S. Nº 156-2004-EF'),0,1,'L');
//         $this->Ln(2);
//         $this->setX(5);
//         $this->MultiCell(140,3,utf8_decode('* La UIT para el ejercicio 2021 es de S/ 4,400 Soles, según lo establecido en el D. S. Nº 392-2020-EF publicado el 15 de diciembre de 2020.'),0,1,'L');
//         $this->Ln(2);
//         $this->setX(5);
//         $this->MultiCell(140,3,utf8_decode('* Derecho de emsión 2021 Ordenanza Nº 357-2020/MLV publicado en el diario oficial El Peruano el 18 de diciembre de 2020.'),0,1,'L');
//         $this->setX(5);
//         $this->SetFont('Arial','B',6);
//         $this->Cell(140,4,'Page '.$this->PageNo().'/{nb}',0,1,'R');
//     }

//     function footerHla(){
//         $this->SetFont('Arial','B',6);
//         $this->SetY(-15);
//         $this->setX(5);
//         $this->Cell(140,10,'',1,0);
//         $this->setX(5);
//         $this->Cell(140,3,utf8_decode('ORDENANZA Nº 352/MLV'),0,1,'L');
//         $this->setX(5);
//         $this->SetFont('Arial','B',6);
//         $this->Cell(140,4,'Page '.$this->PageNo().'/{nb}',0,1,'R');
//     }

//     function getCuotas(){
//       header("Content-Type: text/plain");
//       $data = array(
//         'success'=>true,
//         'total'=>4,
//         'data'=>array(
//           array('cuota'=>1, 'fecvenc'=>'27/02/', 'lp'=>4.11, 'pj'=>1, 'serena'=>2, 'emision'=>0, 'total'=>33, 'docu'=>'0167081'),
//           array('cuota'=>2, 'fecvenc'=>'31/05/', 'lp'=>4.39, 'pj'=>1, 'serena'=>2, 'emision'=>0, 'total'=>33, 'docu'=>'0167081'),
//           array('cuota'=>3, 'fecvenc'=>'31/08/', 'lp'=>3.11, 'pj'=>1, 'serena'=>2, 'emision'=>0, 'total'=>33, 'docu'=>'0167081'),
//           array('cuota'=>4, 'fecvenc'=>'30/11/', 'lp'=>3.83, 'pj'=>1, 'serena'=>2, 'emision'=>0, 'total'=>33, 'docu'=>'0167081'),
//         )
//       );     
//       echo json_encode($data);
//     }

//     public function pag1() {
//       $this->setXY(0,0);
//       $this->Image('imagescuponera/p1.jpeg', 0, 0, 150);
//     }

//     public function pag2() {
//       $this->setXY(0,0);
//       $this->Image('imagescuponera/p2.jpeg', 0, 0, 150);
//     }

//     public function HR($GetHr) {
//         $this->setXY(0,0);

//         /*CABECERA*/
//         // Logo
//         $this->Image('imagescuponera/logo_fondo.jpeg',25,50,100);
//         $this->Image('imagescuponera/logo.jpg',5,3,25,16);
//         // $this->SetFont('Arial','',6);

//         // Arial bold 15
//         $this->SetFont('Arial','B',9);
//         // Movernos a la derecha
//         // $this->Cell(149,1,'',1,0,'L');
//         $this->setXY(30,5);
//         $this->Cell(87,4,'DECLARACION JURADA DE IMPUESTO PREDIAL 2021',0,0,'C');
//         $this->ln();
//         $this->setX(30);
//         $this->SetFont('Helvetica','',8);
//         $this->Cell(87,4,utf8_decode('T.U.O. DE LA LEY DE TRIBUTACIÓN MUNICIPAL'),0,0,'C');
//         $this->ln();
//         $this->setX(30);
//         $this->SetFont('Helvetica','B',8);
//         $this->Cell(87,3,utf8_decode('(Art. 14 del D.S. N° 156-2004-EF)'),0,0,'C');

//         $this->setXY(130,10);
//         $this->SetFont('Helvetica','B',35);
//         $this->Cell(10,3,'HR',0,0,'C');
//         $this->setXY(130,18);
//         $this->SetLineWidth(0.3);
//         $this->Rect(125, 4, 20, 13);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(10,3,utf8_decode('HOJA RESUMEN'),0,0,'C');
        
//         $this->ln();
//         $this->setXY(105,22);
//         $this->SetFont('Helvetica','B',6);
//         $this->Cell(10,3,utf8_decode('N° D.J. MECANIZADA'),0,0,'C');
//         $this->setXY(130,22.5);
//         $this->Cell(10,3,$GetHr[0]->nrodjmeca,0,1,'C');
//         $this->RoundedRect(125, 22, 20, 4, 1, '1234','FD');
//         // $this->Rect(125, 22, 20, 4);

//         $this->setX(70);
//         /*******EN CABECERA**********/

//         /********cuerpo******************/
//         $withColor = false;
//         $yCuerpo = 25;
//         $this->setXY(4,$yCuerpo);
//         // $this->SetTextColor(0,120,0);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'DATOS DEL CONTRIBUYENTE',0,0,'L');
//         $this->ln();
//         $yr=$this->GetY();
//         $this->setX(5);
//         $this->SetFont('Arial','',6);
//         $this->SetFillColor(93, 93, 164);//227 227 227
//         $this->SetTextColor(18,18,17);
//         // $this->SetTextColor(255,255,255);
//         $this->MultiCell(22,3,utf8_decode('CÓDIGO CONTRIBUYENTE'),1,'C',$withColor);
//         $this->setXY(27,$yr);
//         $this->MultiCell(22,3,utf8_decode('TIPO DE CONTRIBUYENTE'),1,'C',$withColor);
//         $this->setXY(49,$yr);
//         $this->MultiCell(74,6,utf8_decode('APELLIDOS Y NOMBRES / RAZÓN SOCIAL'),1,'C',$withColor);
//         $this->setXY(123,$yr);
//         $this->MultiCell(22,6,utf8_decode('DNI/RUC/OTROS'),1,'C',$withColor);
//         $this->setX(5);
//         $this->Cell(22,4,$GetHr[0]->codigo,1,0,'C'); // codigo contribuyente
//         $this->setXY(27,$yr+6);
//         $this->Cell(22,4,$GetHr[0]->tipo,1,0,'C'); // tipo contribuyente
//         $this->setXY(49,$yr+6);
//         $this->Cell(74,4,$GetHr[0]->nomcontr,1,0,'C'); // apellido y nombres / razon social
//         $this->setXY(123,$yr+6);
//         $this->Cell(22,4,$GetHr[0]->dniruc,1,0,'C'); // dni/ruc/otros
//         $this->ln(5);

//         //Domicilio fiscal
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'DOMICILIO FISCAL',0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+15);
//         $this->MultiCell(70,4,utf8_decode('DISTRITO'),1,'C',$withColor);
//         $this->setXY(75,$yr+15);
//         $this->MultiCell(70,4,utf8_decode('URBANIZACIÓN'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(70,4,$GetHr[0]->distrito,1,0,'C'); //distrito
//         $this->setXY(75,$yr+19);
//         $this->Cell(70,4,$GetHr[0]->conjurbano,1,0,'C'); // urbanización

//         $this->ln(5);
//         $this->setXY(5,$yr+23);
//         $this->MultiCell(32,4,utf8_decode('VIA'),1,'C',$withColor);
//         $this->setXY(37,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('NÚMERO 1'),1,'C',$withColor);
//         $this->setXY(51,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('NÚMERO 2'),1,'C',$withColor);
//         $this->setXY(65,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('LETRA'),1,'C',$withColor);
//         $this->setXY(75,$yr+23);      
//         $this->MultiCell(14,4,utf8_decode('DPTO'),1,'C',$withColor);
//         $this->setXY(89,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('MANZANA'),1,'C',$withColor);
//         $this->setXY(103,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('LOTE'),1,'C',$withColor);
//         $this->setXY(117,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('EDIFICIO'),1,'C',$withColor);
//         $this->setXY(131,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('BLOCK'),1,'C',$withColor);
        
//         $this->setX(5);
//         $this->Cell(32,4,$GetHr[0]->via,1,0,'C'); //via
//         $this->setXY(37,$yr+27);
//         $this->Cell(14,4,$GetHr[0]->numero,1,0,'C'); // número1 
//         $this->setXY(51,$yr+27);
//         $this->Cell(14,4,$GetHr[0]->numero2,1,0,'C'); // número2
//         $this->setXY(65,$yr+27);
//         $this->Cell(10,4,$GetHr[0]->letra,1,0,'C'); // letra
//         $this->setXY(75,$yr+27);
//         $this->Cell(14,4,$GetHr[0]->departamento,1,0,'C'); // dpto
//         $this->setXY(89,$yr+27);
//         $this->Cell(14,4,$GetHr[0]->manzana,1,0,'C'); // manzana
//         $this->setXY(103,$yr+27);
//         $this->Cell(14,4,$GetHr[0]->lote,1,0,'C'); // lote
//         $this->setXY(117,$yr+27);
//         $this->Cell(14,4,$GetHr[0]->edificio,1,0,'C'); // edificio
//         $this->setXY(131,$yr+27);
//         $this->Cell(14,4,$GetHr[0]->block,1,0,'C'); // block

//         $this->setXY(5,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('INTERIOR'),1,'C',$withColor);
//         $this->setXY(19,$yr+31);
//         $this->MultiCell(10,4,utf8_decode('TIENDA'),1,'C',$withColor);
//         $this->setXY(29,$yr+31);
//         $this->MultiCell(8,4,utf8_decode('PISO'),1,'C',$withColor);
//         $this->setXY(37,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('STAND'),1,'C',$withColor);
//         $this->setXY(51,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('OFICINA'),1,'C',$withColor);
//         $this->setXY(65,$yr+31);
//         $this->MultiCell(10,4,utf8_decode('SUB.MZ'),1,'C',$withColor);
//         $this->setXY(75,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('SUB.LT'),1,'C',$withColor);
//         $this->setXY(89,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('SONTANO'),1,'C',$withColor);
//         $this->SetFont('Arial','',5.5);
//         $this->setXY(103,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('MEZZANINE'),1,'C',$withColor);
//         $this->SetFont('Arial','',6);
//         $this->setXY(117,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('SECCIÓN'),1,'C',$withColor);
//         $this->setXY(131,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('UNID.INM'),1,'C',$withColor);
        
//         $this->setX(5);
//         $this->Cell(14,4,$GetHr[0]->interior,1,0,'C'); // interior
//         $this->setXY(19,$yr+35);
//         $this->Cell(10,4,$GetHr[0]->tienda,1,0,'C'); // tienda
//         $this->setXY(29,$yr+35);
//         $this->Cell(8,4,$GetHr[0]->piso,1,0,'C'); // piso
//         $this->setXY(37,$yr+35);
//         $this->Cell(14,4,$GetHr[0]->stand,1,0,'C'); // stand
//         $this->setXY(51,$yr+35);
//         $this->Cell(14,4,$GetHr[0]->oficina,1,0,'C'); // oficina
//         $this->setXY(65,$yr+35);
//         $this->Cell(10,4,$GetHr[0]->submanzana,1,0,'C'); // sub mz
//         $this->setXY(75,$yr+35);
//         $this->Cell(14,4,$GetHr[0]->sublote,1,0,'C'); // sub lt
//         $this->setXY(89,$yr+35);
//         $this->Cell(14,4,$GetHr[0]->sotano,1,0,'C'); // sotano
//         $this->SetFont('Arial','',5.5);
//         $this->setXY(103,$yr+35);
//         $this->Cell(14,4,$GetHr[0]->mezzanine,1,0,'C'); // mezzanine
//         $this->SetFont('Arial','',6);
//         $this->setXY(117,$yr+35);
//         $this->Cell(14,4,$GetHr[0]->seccion,1,0,'C'); // sección
//         $this->setXY(131,$yr+35);
//         $this->Cell(14,4,$GetHr[0]->unidadinmob,1,0,'C'); // unid inm 
//         $this->ln(5);

//         // DATOS DEL CONYUQUE / REPRESENTANTE LEGAL
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5, utf8_decode('DATOS DEL CONYUQUE / REPRESENTANTE LEGAL'),0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+45);
//         $this->MultiCell(40,4,utf8_decode('TIPO DE EVALUACIÓN'),1,'C',$withColor);
//         $this->setXY(45,$yr+45);
//         $this->MultiCell(80,4,utf8_decode('APELLIDOS Y NOMBRES'),1,'C',$withColor);
//         $this->setXY(125,$yr+45);
//         $this->MultiCell(20,4,utf8_decode('DNI'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(40,4,$GetHr[0]->vinculo,1,0,'C'); // tipo de evaluación
//         $this->setXY(45,$yr+49);
//         $this->Cell(80,4,$GetHr[0]->vinapenom,1,0,'C'); // apellidos y nombres
//         $this->setXY(125,$yr+49);
//         $this->Cell(20,4,$GetHr[0]->vindni,1,0,'C'); // dni
//         $this->ln(5);

//         // INFORMACIÓN DE CONTACTO
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5, utf8_decode('INFORMACIÓN DE CONTACTO'),0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+58);
//         $this->MultiCell(25,4,utf8_decode('TELÉFONO FIJO'),1,'C',$withColor);
//         $this->setXY(30,$yr+58);
//         $this->MultiCell(25,4,utf8_decode('TELÉFONO CELULAR'),1,'C',$withColor);
//         $this->setXY(55,$yr+58);
//         $this->MultiCell(25,4,utf8_decode('FAX'),1,'C',$withColor);
//         $this->setXY(80,$yr+58);
//         $this->MultiCell(65,4,utf8_decode('CORREO ELECTRÓNICO'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(25,4,$GetHr[0]->telfijo,1,0,'C'); // telefono fijo
//         $this->setXY(30,$yr+62);
//         $this->Cell(25,4,$GetHr[0]->celular,1,0,'C'); // telefono celular
//         $this->setXY(55,$yr+62);
//         $this->Cell(25,4,$GetHr[0]->fax,1,0,'C'); // fax
//         $this->setXY(80,$yr+62);
//         $this->Cell(65,4,$GetHr[0]->correo,1,0,'C'); // correo electronico
//         $this->ln(5);

//         // INAFECTO / BENEFICIO TRIBUTARIO DE PENSIONISTA
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5, utf8_decode('INAFECTO / BENEFICIO TRIBUTARIO DE PENSIONISTA'),0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+71);
//         $this->MultiCell(25,4,utf8_decode('RÉGIMEN'),1,'C',$withColor);
//         $this->setXY(30,$yr+71);
//         $this->MultiCell(25,4,utf8_decode('UIT DEDUCIBLE'),1,'C',$withColor);
//         $this->setXY(55,$yr+71);
//         $this->MultiCell(25,4,utf8_decode('% DE INAFECTACIÓN'),1,'C',$withColor);
//         $this->setXY(80,$yr+71);
//         $this->MultiCell(25,4,utf8_decode('Nº DE PREDIOS'),1,'C',$withColor);
//         $this->setXY(105,$yr+71);
//         $this->MultiCell(40,4,utf8_decode('BASE IMPONIBLE AFECTA (S/)'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(25,4,$GetHr[0]->regimen,1,0,'C'); // regimen
//         $this->setXY(30,$yr+75);
//         $this->Cell(25,4,$GetHr[0]->uitdedu,1,0,'C'); // uit deducile
//         $this->setXY(55,$yr+75);
//         $this->Cell(25,4,$GetHr[0]->porcinaf,1,0,'C'); // % de inafectación
//         $this->setXY(80,$yr+75);
//         $this->Cell(25,4,$GetHr[0]->nropred,1,0,'C'); // nro de predios
//         $this->setXY(105,$yr+75);
//         $this->Cell(40,4,number_format((float)$GetHr[0]->baseimp, 2, '.', ','),1,0,'C'); // base imponible afecta
//         $this->ln(5);

//         // RELACIÓN DE PREDIOS
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5, utf8_decode('RELACIÓN DE PREDIOS'),0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+84);
//         $this->MultiCell(10,6,utf8_decode('ANEXO'),1,'C',$withColor);
//         $this->setXY(15,$yr+84);
//         $this->MultiCell(85,6,utf8_decode('UBICACIÓN DEL PREDIO'),1,'C',$withColor);
//         $this->setXY(100,$yr+84);
//         $this->MultiCell(18,6,utf8_decode('AUTOVALÚO S/'),1,'C',$withColor);
//         $this->setXY(118,$yr+84);
//         $this->MultiCell(10,6,utf8_decode('%PROP'),1,'C',$withColor);
//         $this->setXY(128,$yr+84);
//         $this->MultiCell(17,3,utf8_decode('AUTOVALÚO AFECTO'),1,'C',$withColor);

//         $yy = $yr+90;
//         foreach ($GetHr as $predios) {
//           $this->SetFont('Arial','',6);
//           $this->setXY(5,$yy);
//           $this->Cell(10,4,$predios->anexo,1,0,'C'); // anexo
//           $this->setXY(15,$yy);
//           $this->Cell(85,4,utf8_decode($predios->direccion),1,0,'L'); // ubicacion del predio
//           $this->setXY(100,$yy);
//           $this->Cell(18,4,number_format((float)$predios->autovaluo, 2, '.', ','),1,0,'C'); // autovaluo
//           $this->setXY(118,$yy);
//           $this->Cell(10,4,number_format((float)$predios->porprop, 2, '.', ','),1,0,'C'); // prop
//           $this->setXY(128,$yy);
//           $this->Cell(17,4,number_format((float)$predios->autoafec, 2, '.', ','),1,0,'C'); // autovaluo afecto
//           $yy=$yy+4;
//         }

//         /************cuerpo********************/
//         $this->InFooter=true;
//         $this->footerHr();
//     }

//     public function PU($GetPU,$GetDetPU) {
//         $this->setXY(0,0);

//         /*CABECERA*/
//         // Logo
//         $this->Image('imagescuponera/logo_fondo.jpeg',25,50,100);
//         $this->Image('imagescuponera/logo.jpg',5,3,25,16);
//         // $this->SetFont('Arial','',6);

//         // Arial bold 15
//         $this->SetFont('Arial','B',9);
//         // Movernos a la derecha
//         // $this->Cell(149,1,'',1,0,'L');
//         $this->setXY(30,5);
//         $this->Cell(87,4,'DECLARACION JURADA DE IMPUESTO PREDIAL 2021',0,0,'C');
//         $this->ln();
//         $this->setX(30);
//         $this->SetFont('Helvetica','',8);
//         $this->Cell(87,4,utf8_decode('T.U.O. DE LA LEY DE TRIBUTACIÓN MUNICIPAL'),0,0,'C');
//         $this->ln();
//         $this->setX(30);
//         $this->SetFont('Helvetica','B',8);
//         $this->Cell(87,3,utf8_decode('(Art. 14 del D.S. N° 156-2004-EF)'),0,0,'C');

//         $this->setXY(130,10);
//         $this->SetFont('Helvetica','B',35);
//         $this->Cell(10,3,'PU',0,0,'C');
//         $this->setXY(130,18);
//         $this->SetLineWidth(0.3);
//         $this->Rect(125, 4, 20, 13);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(10,3,utf8_decode('PREDIO URBANO'),0,0,'C');
        
//         $this->ln();
//         $this->setXY(105,22);
//         $this->SetFont('Helvetica','B',6);
//         $this->Cell(10,3,utf8_decode('N° D.J. MECANIZADA'),0,0,'C');
//         $this->setXY(130,22.5);
//         $this->Cell(10,3,$GetPU[0]->nrodjmeca,0,1,'C');
//         $this->RoundedRect(125, 22, 20, 4, 1, '1234','FD');
//         // $this->Rect(125, 22, 20, 4);

//         /*******EN CABECERA**********/
//         /********cuerpo******************/
//         $withColor = false;
//         $yCuerpo = 25;
//         $this->setXY(4,$yCuerpo);
//         // $this->SetTextColor(0,120,0);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'DATOS DEL CONTRIBUYENTE',0,0,'L');
//         $this->ln();
//         $yr=$this->GetY();
//         $this->setX(5);
//         $this->SetFont('Arial','',6);
//         $this->SetFillColor(93, 93, 164);
//         $this->SetTextColor(18,18,17);
//         // $this->SetTextColor(255,255,255);
//         $this->MultiCell(22,3,utf8_decode('CÓDIGO CONTRIBUYENTE'),1,'C',$withColor);
//         $this->setXY(27,$yr);
//         $this->MultiCell(96,6,utf8_decode('APELLIDOS Y NOMBRES / RAZÓN SOCIAL'),1,'C',$withColor);
//         $this->setXY(123,$yr);
//         $this->MultiCell(22,6,utf8_decode('DNI/RUC/OTROS'),1,'C',$withColor);
//         $this->setX(5);
//         $this->Cell(22,4,$GetPU[0]->codcontrib,1,0,'C'); // codigo contribuyente
//         $this->setXY(27,$yr+6);
//         $this->Cell(96,4,$GetPU[0]->apenom,1,0,'C'); // apellido y nombres / razon social
//         $this->setXY(123,$yr+6);
//         $this->Cell(22,4,$GetPU[0]->dniruc,1,0,'C'); // dni/ruc/otros
//         $this->ln(5);

//         // DATOS DEL PREDIO
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'DATOS DEL PREDIO',0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('ANEXO'),1,'C',$withColor);
//         $this->setXY(15,$yr+15);
//         $this->MultiCell(34,4,utf8_decode('VIA'),1,'C',$withColor);
//         $this->setXY(49,$yr+15);
//         $this->MultiCell(14,4,utf8_decode('NÚMERO 1'),1,'C',$withColor);
//         $this->setXY(63,$yr+15);
//         $this->MultiCell(14,4,utf8_decode('NÚMERO 2'),1,'C',$withColor);
//         $this->setXY(77,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('LETRA'),1,'C',$withColor);
//         $this->setXY(87,$yr+15);
//         $this->MultiCell(14,4,utf8_decode('INTERIOR'),1,'C',$withColor);
//         $this->setXY(101,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('BLOCK'),1,'C',$withColor);
//         $this->setXY(111,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('PISO'),1,'C',$withColor);
//         $this->setXY(121,$yr+15);
//         $this->MultiCell(14,4,utf8_decode('EDIFICIO'),1,'C',$withColor);
//         $this->setXY(135,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('DPTO'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(10,4,$GetPU[0]->anexo,1,0,'C'); //anexo
//         $this->setXY(15,$yr+19);
//         $this->Cell(34,4,$GetPU[0]->via,1,0,'C'); //via
//         $this->setXY(49,$yr+19);
//         $this->Cell(14,4,$GetPU[0]->numero,1,0,'C'); //numero 1
//         $this->setXY(63,$yr+19);
//         $this->Cell(14,4,$GetPU[0]->numero2,1,0,'C'); //numero 2
//         $this->setXY(77,$yr+19);
//         $this->Cell(10,4,$GetPU[0]->letra,1,0,'C'); //letra
//         $this->setXY(87,$yr+19);
//         $this->Cell(14,4,$GetPU[0]->interior,1,0,'C'); //interior
//         $this->setXY(101,$yr+19);
//         $this->Cell(10,4,$GetPU[0]->block,1,0,'C'); //block
//         $this->setXY(111,$yr+19);
//         $this->Cell(10,4,$GetPU[0]->piso,1,0,'C'); //piso
//         $this->setXY(121,$yr+19);
//         $this->Cell(14,4,$GetPU[0]->edificio,1,0,'C'); //edificio
//         $this->setXY(135,$yr+19);
//         $this->Cell(10,4,$GetPU[0]->departamento,1,0,'C'); //dpto

//         $this->SetFont('Arial','',4);
//         $this->setXY(5,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('MANZANA'),1,'C',$withColor);
//         $this->setXY(15,$yr+23);
//         $this->MultiCell(7,4,utf8_decode('LOTE'),1,'C',$withColor);
//         $this->setXY(22,$yr+23);
//         $this->MultiCell(7,4,utf8_decode('STAND'),1,'C',$withColor);
//         $this->setXY(29,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('OFICINA'),1,'C',$withColor);
//         $this->setXY(37,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('SUB MZ'),1,'C',$withColor);
//         $this->setXY(45,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('SUB LT'),1,'C',$withColor);
//         $this->setXY(53,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('TIENDA'),1,'C',$withColor);
//         $this->setXY(61,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('SÓTANO'),1,'C',$withColor);
//         $this->setXY(69,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('AZOTEA'),1,'C',$withColor);
//         $this->setXY(77,$yr+23);
//         $this->MultiCell(9,4,utf8_decode('SECCIÓN'),1,'C',$withColor);
//         $this->setXY(86,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('UNI. INM'),1,'C',$withColor);
//         $this->setXY(94,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('DEPOS'),1,'C',$withColor);
//         $this->setXY(102,$yr+23);
//         $this->MultiCell(8,4,utf8_decode('ESTAC'),1,'C',$withColor);
//         $this->setXY(110,$yr+23);
//         $this->MultiCell(35,4,utf8_decode('URBANIZACIÓN'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(10,4,$GetPU[0]->manzana,1,0,'C'); //MANZANA
//         $this->setXY(15,$yr+27);
//         $this->Cell(7,4,$GetPU[0]->lote,1,0,'C'); //LOTE
//         $this->setXY(22,$yr+27);
//         $this->Cell(7,4,$GetPU[0]->stand,1,0,'C'); //STAND
//         $this->setXY(29,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->oficina,1,0,'C'); //OFICINA
//         $this->setXY(37,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->submanzana,1,0,'C'); //SUB MZ
//         $this->setXY(45,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->sublote,1,0,'C'); //SUB LT
//         $this->setXY(53,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->tienda,1,0,'C'); //TIENDA
//         $this->setXY(61,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->sotano,1,0,'C'); //SÓTANO
//         $this->setXY(69,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->azotea,1,0,'C'); //AZOTEA
//         $this->setXY(77,$yr+27);
//         $this->Cell(9,4,$GetPU[0]->seccion,1,0,'C'); //SECCIÓN
//         $this->setXY(86,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->unidadinmob,1,0,'C'); //NID .INM
//         $this->setXY(94,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->deposito,1,0,'C'); //DEPOS
//         $this->setXY(102,$yr+27);
//         $this->Cell(8,4,$GetPU[0]->estacionam,1,0,'C'); //ESTAC
//         $this->setXY(110,$yr+27);
//         $this->Cell(35,4,$GetPU[0]->conjurbano,1,0,'C'); //URBANIZACIÓN

//         $this->Ln();
//         $this->SetFont('Arial','',6);
//         $this->setX(5);
//         $this->MultiCell(24,4,utf8_decode('REFERENCIA'),1,'C',$withColor);
//         $this->setXY(29,$yr+31);
//         $this->Cell(116,4,utf8_decode($GetPU[0]->referencia),1,0,'C'); //referencia

//         $this->Ln();
//         $this->setX(5);
//         $this->MultiCell(16,4,utf8_decode('ESTADO'),1,'C',$withColor);
//         $this->setXY(21,$yr+35);
//         $this->MultiCell(8,4,utf8_decode('ZONA'),1,'C',$withColor);
//         $this->setXY(29,$yr+35);
//         $this->MultiCell(30,4,utf8_decode('TIPO DE PREDIO'),1,'C',$withColor);
//         $this->setXY(59,$yr+35);
//         $this->MultiCell(30,4,utf8_decode('USO DEL PREDIO'),1,'C',$withColor);
//         $this->setXY(89,$yr+35);
//         $this->MultiCell(35,4,utf8_decode('CONDICIÓN DE PROPIEDAD'),1,'C',$withColor);
//         $this->setXY(124,$yr+35);
//         $this->MultiCell(21,4,utf8_decode('% PROPIEDAD'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(16,4,utf8_decode($GetPU[0]->estado),1,0,'C'); //ESTADO
//         $this->setXY(21,$yr+39);
//         $this->Cell(8,4,$GetPU[0]->zona,1,0,'C'); //ZONA
//         $this->setXY(29,$yr+39);
//         $this->Cell(30,4,utf8_decode($GetPU[0]->tipo),1,0,'C'); //TIPO DE PREDIO
//         $this->SetFont('Arial','',5);
//         $this->setXY(59,$yr+39);
//         $this->Cell(30,4,utf8_decode($GetPU[0]->uso),1,0,'C'); //USO DEL PREDIO
//         $this->SetFont('Arial','',6);
//         $this->setXY(89,$yr+39);
//         $this->Cell(35,4,utf8_decode($GetPU[0]->condicion),1,0,'C'); //CONDICIÓN DE PROPIEDAD
//         $this->setXY(124,$yr+39);
//         $this->Cell(21,4,$GetPU[0]->porcprop,1,0,'C'); //% PROPIEDAD
//         $this->Ln();

//         // INAFECTACIÓN / EXONERACIÓN / BENEFICIO TRIBUTARIO DE PENSIONISTA
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,utf8_decode('INAFECTACIÓN / EXONERACIÓN / BENEFICIO TRIBUTARIO DE PENSIONISTA'),0,0,'L');
        
//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+47);
//         $this->MultiCell(28,4,utf8_decode('RÉGIMEN'),1,'C',$withColor);
//         $this->setXY(33,$yr+47);
//         $this->MultiCell(28,4,utf8_decode('UIT DEDUCIBLE'),1,'C',$withColor);
//         $this->setXY(61,$yr+47);
//         $this->MultiCell(28,4,utf8_decode('% DE INAFECTACIÓN'),1,'C',$withColor);
//         $this->setXY(89,$yr+47);
//         $this->MultiCell(28,4,utf8_decode('FECHA INICIO'),1,'C',$withColor);
//         $this->setXY(117,$yr+47);
//         $this->MultiCell(28,4,utf8_decode('ACTUALIZACIÓN'),1,'C',$withColor);

//         $this->Ln();
//         $this->setXY(5,$yr+51);
//         $this->Cell(28,4,utf8_decode($GetPU[0]->regimen),1,0,'C'); // regimen
//         $this->setXY(33,$yr+51);
//         $this->Cell(28,4,$GetPU[0]->uitdedu,1,0,'C'); // uit deductible
//         $this->setXY(61,$yr+51);
//         $this->Cell(28,4,$GetPU[0]->porcinaf,1,0,'C'); // % de inefactacion
//         $this->setXY(89,$yr+51);
//         $this->Cell(28,4,$GetPU[0]->fecinicio,1,0,'C'); // fecha inicio
//         $this->setXY(117,$yr+51);
//         $this->Cell(28,4,$GetPU[0]->actualiza,1,0,'C'); // actualizacion
//         $this->ln();

//         // DETERMINACIÓN DEL VALOR DE LA CONSTRUCCIÓN
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',6);
//         $this->Cell(100,5,utf8_decode('DETERMINACIÓN DEL VALOR DE LA CONSTRUCCIÓN'),0,0,'L');
//         $this->ln(5);

//         $yc = $this->getY();
//         $this->setXY(30,$yc);
//         $this->MultiCell(35,6,'CATEGORIAS',1,'C',$withColor);
//         $this->setXY(84,$yc);
//         $this->MultiCell(16,3,'VALOR UNIT. DEPREC.',1,'C',$withColor);
//         $this->setXY(110,$yc);
//         $this->MultiCell(17,6,utf8_decode('ÁREA COMÚN'),1,'C',$withColor);

//         $this->TextWithDirection(8,$yr+75,'NIVEL','U');
//         $this->TextWithDirection(13,$yr+82,utf8_decode('AÑO DE LA CONST.'),'U');
//         $this->TextWithDirection(18,$yr+81,utf8_decode('CLASIFICACIÓN'),'U');
//         $this->TextWithDirection(23,$yr+81,utf8_decode('MATERIAL PRED.'),'U');
//         $this->TextWithDirection(28,$yr+82,utf8_decode('ESTADO CONSERV.'),'U');
//         $this->TextWithDirection(32,$yr+80,utf8_decode('MUROS Y'),'U');
//         $this->TextWithDirection(34,$yr+81,utf8_decode('COLUMNAS'),'U');
//         $this->TextWithDirection(38,$yr+80,utf8_decode('TECHOS'),'U');
//         $this->TextWithDirection(43,$yr+79,utf8_decode('PISOS'),'U');
//         $this->TextWithDirection(47,$yr+81,utf8_decode('PUERTAS Y'),'U');
//         $this->TextWithDirection(49,$yr+81,utf8_decode('VENTANAS'),'U');
//         $this->TextWithDirection(53,$yr+79,utf8_decode('REVEST.'),'U');
//         $this->TextWithDirection(58,$yr+79,utf8_decode('BAÑOS'),'U');
//         $this->TextWithDirection(62,$yr+83,utf8_decode('INSTAL ELECT.'),'U');
//         $this->TextWithDirection(64,$yr+83,utf8_decode('Y SANITARIAS'),'U');
//         $this->TextWithDirection(67,$yr+72,utf8_decode('VALOR'),'R');
//         $this->TextWithDirection(66,$yr+75,utf8_decode('UNITARIO'),'R');
//         $this->TextWithDirection(69,$yr+78,utf8_decode('M2'),'R');
//         $this->TextWithDirection(81,$yr+81,utf8_decode('INCREMENTO 5%'),'U');
//         $this->TextWithDirection(85.5,$yr+75,utf8_decode('%'),'R');
//         $this->TextWithDirection(91,$yr+75,utf8_decode('VALOR'),'R');
//         $this->TextWithDirection(102,$yr+72,utf8_decode('ÁREA'),'R');
//         $this->TextWithDirection(101,$yr+75,utf8_decode('CONST'),'R');
//         $this->TextWithDirection(103,$yr+78,utf8_decode('M2'),'R');
//         $this->TextWithDirection(112,$yr+75,utf8_decode('M2'),'R');
//         $this->TextWithDirection(119,$yr+75,utf8_decode('VALOR'),'R');
//         $this->TextWithDirection(129,$yr+72,utf8_decode('VALOR DE LA'),'R');
//         $this->TextWithDirection(128,$yr+75,utf8_decode('CONSTRUCCIÓN'),'R');

//         $yy = $yr+85;
//         foreach ($GetDetPU as $pisos) {
//           $this->SetFont('Arial','',6);
//           $this->setXY(5,$yy);
//           $this->Cell(5,3,$pisos->nivel,1,0,'C'); // nivel
//           $this->setXY(10,$yy);
//           $this->Cell(5,3,$pisos->anioconst,1,0,'C'); // año de la construcción
//           $this->setXY(15,$yy);
//           $this->Cell(5,3,$pisos->clasif,1,0,'C'); // clasificación
//           $this->setXY(20,$yy);
//           $this->Cell(5,3,$pisos->material,1,0,'C'); // material pred
//           $this->setXY(25,$yy);
//           $this->Cell(5,3,$pisos->conserva,1,0,'C'); // ESTADO CONSERV
//           $this->setXY(30,$yy);
//           $this->Cell(5,3,$pisos->muros,1,0,'C'); // muros y columnas
//           $this->setXY(35,$yy);
//           $this->Cell(5,3,$pisos->techo,1,0,'C'); // techo
//           $this->setXY(40,$yy);
//           $this->Cell(5,3,$pisos->piso,1,0,'C'); // pisos
//           $this->setXY(45,$yy);
//           $this->Cell(5,3,$pisos->puerta,1,0,'C'); // puertas y ventanas
//           $this->setXY(50,$yy);
//           $this->Cell(5,3,$pisos->reves,1,0,'C'); // revest
//           $this->setXY(55,$yy);
//           $this->Cell(5,3,$pisos->banios,1,0,'C'); // baños
//           $this->setXY(60,$yy);
//           $this->Cell(5,3,$pisos->instala,1,0,'C'); // instalaciones electricas y sanitarias
//           $this->setXY(65,$yy);
//           $this->Cell(12,3,$pisos->valuni,1,0,'C'); // valor unitario m2
//           $this->setXY(77,$yy);
//           $this->Cell(7,3,number_format((float)$pisos->increm, 2, '.', ','),1,0,'C'); // incremento del 5%
//           $this->setXY(84,$yy);
//           $this->Cell(5,3,$pisos->pordepre,1,0,'C'); // %
//           $this->setXY(89,$yy);
//           $this->Cell(11,3,$pisos->valdeprec,1,0,'C'); // valor
//           $this->setXY(100,$yy);
//           $this->Cell(10,3,$pisos->areaconst,1,0,'C'); // area construccion m2
//           $this->setXY(110,$yy);
//           $this->Cell(8,3,number_format((float)$pisos->porcomun, 2, '.', ','),1,0,'C'); // m2
//           $this->setXY(118,$yy);
//           $this->Cell(9,3,$pisos->valcomun,1,0,'C'); // valor
//           $this->setXY(127,$yy);
//           $this->Cell(18,3,$pisos->valconstr,1,0,'C'); // valor de la construccion
//           $yy = $yy+3;
//         }
        
//         $this->line(5,90,145,90);
//         $this->line(5,90,5,115);
//         $this->line(10,90,10,115);
//         $this->line(15,90,15,115);
//         $this->line(20,90,20,115);
//         $this->line(25,90,25,115);
//         $this->line(30,90,30,115);
//         $this->line(35,96,35,115);
//         $this->line(40,96,40,115);
//         $this->line(45,96,45,115);
//         $this->line(50,96,50,115);
//         $this->line(55,96,55,115);
//         $this->line(60,96,60,115);
//         $this->line(65,90,65,115);
//         $this->line(77,90,77,115);
//         $this->line(84,90,84,115);
//         $this->line(89,96,89,115);
//         $this->line(100,96,100,115);
//         $this->line(110,90,110,115);
//         $this->line(118,96,118,115);
//         $this->line(127,96,127,115);
//         $this->line(145,90,145,115);


//         $y = 165;
//         $this->setXY(4,$y);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,utf8_decode('DATOS DEL TERRENO'),0,0,'L');

//         $y = 170;
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$y);
//         $this->MultiCell(20,4,utf8_decode('ÁREA (M2)'),1,'C',$withColor);
//         $this->setXY(25,$y);
//         $this->MultiCell(25,4,utf8_decode('ÁREA COMÚN (M2)'),1,'C',$withColor);
//         $this->setXY(50,$y);
//         $this->MultiCell(25,4,utf8_decode('VALOR ARANCELARIO'),1,'C',$withColor);
//         $this->setXY(5,$y+4);
//         $this->Cell(20,4,$GetPU[0]->areaterr,1,0,'C'); //ÁREA (M2)
//         $this->Cell(25,4,number_format((float)$GetPU[0]->areacom, 2, '.', ','),1,0,'C'); //ÁREA COMÚN (M2)
//         $this->Cell(25,4,$GetPU[0]->arancel,1,0,'C'); //VALOR ARANCELARIO

//         $y = 180;
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$y);
//         $this->MultiCell(35,4,utf8_decode('FECHA DE ADQUISICIÓN'),1,'C',$withColor);
//         $this->setXY(5,$y+4);
//         $this->Cell(35,4,$GetPU[0]->fecadqui,1,0,'C'); //FECHA DE ADQUISICIÓN

//         $xb = 120;
//         $yb = 158;

//         $this->SetFont('Arial','',6);

//         $this->setXY($xb-25,$yb+4);
//         $this->Cell(25,4,utf8_decode('VALOR TOTAL CONSTRUCCIÓN'),0,0,'R');
//         $this->Cell(25,4,$GetPU[0]->valtotconst,1,0,'R'); //VALOR TOTAL CONSTRUCCIÓN
        
//         $this->setXY($xb-25,$yb+8);
//         $this->Cell(25,4,'VALOR OTRAS INSTALACIONES',0,0,'R');
//         $this->Cell(25,4,number_format((float)$GetPU[0]->valotrinst, 2, '.', ','),1,0,'R'); //VALOR OTRAS INSTALACIONES


//         $this->setXY($xb-25,$yb+12);
//         $this->Cell(25,4,'VALOR DEL TERRENO',0,0,'R');
//         $this->Cell(25,4,$GetPU[0]->valterreno,1,0,'R'); //VALOR DEL TERRENO

//         $this->setXY($xb-25,$yb+16);
//         $this->Cell(25,4,'TOTAL AUTOAVALUO',0,0,'R');
//         $this->Cell(25,4,$GetPU[0]->autovaluo,1,0,'R'); //TOTAL AUTOAVALUO

//         $xb = 120;
//         $yb = 180;
        
//         $this->SetFont('Arial','',6);
//         $this->setXY($xb,$yb);
//         $this->MultiCell(25,4,utf8_decode('FECHA EMISIÓN'),1,'R',$withColor);
//         $this->setXY($xb,$yb+4);
//         $this->Cell(25,4,$GetPU[0]->fecemisi,1,0,'R'); //FECHA EMISIÓN
        
//         /********cuerpo******************/
//         $this->InFooter=true;
//         $this->footerPu();
//     }

//     public function HLP($GetHlp) {
//         $this->setXY(0,0);

//         /*CABECERA*/
//         // Logo
//         $this->Image('imagescuponera/logo_fondo.jpeg',25,50,100);
//         $this->Image('imagescuponera/logo.jpg',5,3,25,16);
//         // $this->SetFont('Arial','',6);

//         // Arial bold 15
//         $this->SetFont('Arial','B',9);
//         // Movernos a la derecha
//         // $this->Cell(149,1,'',1,0,'L');
//         $this->setXY(30,5);
//         $this->Cell(87,4,'DECLARACION JURADA DE IMPUESTO PREDIAL 2021',0,0,'C');
//         $this->ln();
//         $this->setX(30);
//         $this->SetFont('Helvetica','',8);
//         $this->Cell(87,4,utf8_decode('T.U.O. DE LA LEY DE TRIBUTACIÓN MUNICIPAL'),0,0,'C');
//         $this->ln();
//         $this->setX(30);
//         $this->SetFont('Helvetica','B',8);
//         $this->Cell(87,3,utf8_decode('(Art. 14 del D.S. N° 156-2004-EF)'),0,0,'C');

//         $this->setXY(126.5,10);
//         $this->SetFont('Helvetica','B',35);
//         $this->Cell(10,3,'HLP',0,0,'C');
//         $this->setXY(126.5,18);
//         $this->SetLineWidth(0.3);
//         $this->Rect(118, 4, 27, 13);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(10,3,utf8_decode('HOJA DE LIQUIDACIÓN'),0,0,'C');
//         $this->setXY(126.5,21);
//         $this->Cell(10,3,utf8_decode('DE IMPUESTO PREDIAL'),0,0,'C');
        
//         $this->ln();
//         $this->setXY(100,26);
//         $this->SetFont('Helvetica','B',6);
//         $this->Cell(10,3,utf8_decode('N° D.J. MECANIZADA'),0,0,'C');
//         $this->setXY(126,26);
//         $this->Cell(10,3,$GetHlp[0]->nrodjmeca,0,1,'C');
//         $this->RoundedRect(118, 25, 27, 4, 1, '1234','FD');
//         // $this->Rect(118, 25, 27, 4);
//         /* end cabecera*/

//         //Datos del contribuyente
//         $withColor = false;
//         $yCuerpo = 25;
//         $this->setXY(4,$yCuerpo);
//         // $this->SetTextColor(0,120,0);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'DATOS DEL CONTRIBUYENTE',0,0,'L');
//         $this->ln();
//         $yr=$this->GetY();
//         $this->setX(5);
//         $this->SetFont('Arial','',6);
//         $this->SetFillColor(93, 93, 164);
//         $this->SetTextColor(18,18,17);
//         $this->MultiCell(22,3,utf8_decode('CÓDIGO CONTRIBUYENTE'),1,'C',$withColor);
//         $this->setXY(27,$yr);
//         $this->MultiCell(96,6,utf8_decode('APELLIDOS Y NOMBRES / RAZÓN SOCIAL'),1,'C',$withColor);
//         $this->setXY(123,$yr);
//         $this->MultiCell(22,6,utf8_decode('DNI/RUC/OTROS'),1,'C',$withColor);
//         $this->setX(5);
//         $this->Cell(22,4,$GetHlp[0]->codigo,1,0,'C'); // codigo contribuyente
//         $this->setXY(27,$yr+6);
//         $this->Cell(96,4,$GetHlp[0]->nomcontr,1,0,'C'); // apellido y nombres / razon social
//         $this->setXY(123,$yr+6);
//         $this->Cell(22,4,$GetHlp[0]->dniruc,1,0,'C'); // dni/ruc/otros
//         $this->ln(5);

//         //Domicilio fiscal
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'DOMICILIO FISCAL',0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+15);
//         $this->MultiCell(70,4,utf8_decode('DISTRITO'),1,'C',$withColor);
//         $this->setXY(75,$yr+15);
//         $this->MultiCell(70,4,utf8_decode('URBANIZACIÓN'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(70,4,$GetHlp[0]->distrito,1,0,'C'); //distrito
//         $this->setXY(75,$yr+19);
//         $this->Cell(70,4,$GetHlp[0]->conjurbano,1,0,'C'); // urbanización

//         $this->ln(5);
//         $this->setXY(5,$yr+23);
//         $this->MultiCell(32,4,utf8_decode('VIA'),1,'C',$withColor);
//         $this->setXY(37,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('NÚMERO 1'),1,'C',$withColor);
//         $this->setXY(51,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('NÚMERO 2'),1,'C',$withColor);
//         $this->setXY(65,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('LETRA'),1,'C',$withColor);
//         $this->setXY(75,$yr+23);      
//         $this->MultiCell(14,4,utf8_decode('DPTO'),1,'C',$withColor);
//         $this->setXY(89,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('MANZANA'),1,'C',$withColor);
//         $this->setXY(103,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('LOTE'),1,'C',$withColor);
//         $this->setXY(117,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('EDIFICIO'),1,'C',$withColor);
//         $this->setXY(131,$yr+23);
//         $this->MultiCell(14,4,utf8_decode('BLOCK'),1,'C',$withColor);
        
//         $this->setX(5);
//         $this->Cell(32,4,$GetHlp[0]->via,1,0,'C'); //via
//         $this->setXY(37,$yr+27);
//         $this->Cell(14,4,$GetHlp[0]->numero,1,0,'C'); // número1 
//         $this->setXY(51,$yr+27);
//         $this->Cell(14,4,$GetHlp[0]->numero2,1,0,'C'); // número2
//         $this->setXY(65,$yr+27);
//         $this->Cell(10,4,$GetHlp[0]->letra,1,0,'C'); // letra
//         $this->setXY(75,$yr+27);
//         $this->Cell(14,4,$GetHlp[0]->departamento,1,0,'C'); // dpto
//         $this->setXY(89,$yr+27);
//         $this->Cell(14,4,$GetHlp[0]->manzana,1,0,'C'); // manzana
//         $this->setXY(103,$yr+27);
//         $this->Cell(14,4,$GetHlp[0]->lote,1,0,'C'); // lote
//         $this->setXY(117,$yr+27);
//         $this->Cell(14,4,$GetHlp[0]->edificio,1,0,'C'); // edificio
//         $this->setXY(131,$yr+27);
//         $this->Cell(14,4,$GetHlp[0]->block,1,0,'C'); // block

//         $this->setXY(5,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('INTERIOR'),1,'C',$withColor);
//         $this->setXY(19,$yr+31);
//         $this->MultiCell(10,4,utf8_decode('TIENDA'),1,'C',$withColor);
//         $this->setXY(29,$yr+31);
//         $this->MultiCell(8,4,utf8_decode('PISO'),1,'C',$withColor);
//         $this->setXY(37,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('STAND'),1,'C',$withColor);
//         $this->setXY(51,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('OFICINA'),1,'C',$withColor);
//         $this->setXY(65,$yr+31);
//         $this->MultiCell(10,4,utf8_decode('SUB.MZ'),1,'C',$withColor);
//         $this->setXY(75,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('SUB.LT'),1,'C',$withColor);
//         $this->setXY(89,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('SONTANO'),1,'C',$withColor);
//         $this->SetFont('Arial','',5.5);
//         $this->setXY(103,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('MEZZANINE'),1,'C',$withColor);
//         $this->SetFont('Arial','',6);
//         $this->setXY(117,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('SECCIÓN'),1,'C',$withColor);
//         $this->setXY(131,$yr+31);
//         $this->MultiCell(14,4,utf8_decode('UNID.INM'),1,'C',$withColor);
        
//         $this->setX(5);
//         $this->Cell(14,4,$GetHlp[0]->interior,1,0,'C'); // interior
//         $this->setXY(19,$yr+35);
//         $this->Cell(10,4,$GetHlp[0]->tienda,1,0,'C'); // tienda
//         $this->setXY(29,$yr+35);
//         $this->Cell(8,4,$GetHlp[0]->piso,1,0,'C'); // piso
//         $this->setXY(37,$yr+35);
//         $this->Cell(14,4,$GetHlp[0]->stand,1,0,'C'); // stand
//         $this->setXY(51,$yr+35);
//         $this->Cell(14,4,$GetHlp[0]->oficina,1,0,'C'); // oficina
//         $this->setXY(65,$yr+35);
//         $this->Cell(10,4,$GetHlp[0]->submanzana,1,0,'C'); // sub mz
//         $this->setXY(75,$yr+35);
//         $this->Cell(14,4,$GetHlp[0]->sublote,1,0,'C'); // sub lt
//         $this->setXY(89,$yr+35);
//         $this->Cell(14,4,$GetHlp[0]->sotano,1,0,'C'); // sotano
//         $this->SetFont('Arial','',5.5);
//         $this->setXY(103,$yr+35);
//         $this->Cell(14,4,$GetHlp[0]->mezzanine,1,0,'C'); // mezzanine
//         $this->SetFont('Arial','',6);
//         $this->setXY(117,$yr+35);
//         $this->Cell(14,4,$GetHlp[0]->seccion,1,0,'C'); // sección
//         $this->setXY(131,$yr+35);
//         $this->Cell(14,4,$GetHlp[0]->unidadinmob,1,0,'C'); // unid inm

//         $this->setXY(5,$yr+39);
//         $this->MultiCell(20,4,utf8_decode('REFERENCIA'),1,'C',$withColor);

//         $this->setXY(25,$yr+39);
//         $this->Cell(120,4,$GetHlp[0]->referencia,1,0,'C'); // referencia
//         $this->ln(5);

//         // INAFECTACIÓN / EXONERACIÓN / BENEFICIO TRIBUTARIO DE PENSIONISTA
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,utf8_decode('INAFECTACIÓN / EXONERACIÓN / BENEFICIO TRIBUTARIO DE PENSIONISTA'),0,0,'L');
        
//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+48);
//         $this->MultiCell(35,4,utf8_decode('RÉGIMEN'),1,'C',$withColor);
//         $this->setXY(40,$yr+48);
//         $this->MultiCell(35,4,utf8_decode('Nº DE PREDIOS DECLARADOS'),1,'C',$withColor);
//         $this->setXY(75,$yr+48);
//         $this->MultiCell(35,4,utf8_decode('BASE IMPONIBLE'),1,'C',$withColor);
//         $this->setXY(110,$yr+48);
//         $this->MultiCell(35,4,utf8_decode('BASE IMPONIBLE AFECTA (S/)'),1,'C',$withColor);

//         $this->Ln();
//         $this->setXY(5,$yr+52);
//         $this->Cell(35,4,$GetHlp[0]->regimen,1,0,'C'); //regimen
//         $this->setXY(40,$yr+52);
//         $this->Cell(35,4,$GetHlp[0]->nropred,1,0,'C'); // nro de predios declarados
//         $this->setXY(75,$yr+52);
//         $this->Cell(35,4,$GetHlp[0]->baseimp,1,0,'C'); // base imponible
//         $this->setXY(110,$yr+52);
//         $this->Cell(35,4,$GetHlp[0]->baseimpafe,1,0,'C'); // base imponible afecta
//         $this->ln();

//         // CRITERIO PARA LA DETERMINACIÓN DEL IMPUESTO PREDIAL
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,utf8_decode('CRITERIO PARA LA DETERMINACIÓN DEL IMPUESTO PREDIAL'),0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+60);
//         $this->MultiCell(45,3,utf8_decode('TRAMOS DEL AUTOVALUO SOLES (UIT EN S/ 4, 400.00)'),1,'C',$withColor);
//         $this->setXY(50,$yr+60);
//         $this->MultiCell(15,6,utf8_decode('ALICUOTA'),1,'C',$withColor);
//         $this->setXY(65,$yr+60);
//         $this->MultiCell(35,6,utf8_decode('BASE IMPONIBLE POR TRAMOS'),1,'C',$withColor);
//         $this->setXY(100,$yr+60);
//         $this->MultiCell(45,6,utf8_decode('IMPUESTO ANUAL EN (S/)'),1,'C',$withColor);

//         $criterios = array(
//           array('texto'=>'HASTA 15 UIT', 'alicuota'=> '0.2%', 'base'=> $GetHlp[0]->bitramo1, 'impanual'=> $GetHlp[0]->impanual1),
//           array('texto'=>'Más de 15 UIT hasta 60 UIT', 'alicuota'=> '0.6%', 'base'=> $GetHlp[0]->bitramo2, 'impanual'=> $GetHlp[0]->impanual2),
//           array('texto'=>'Más de 60 UIT', 'alicuota'=> '0.6%', 'base'=> $GetHlp[0]->bitramo3, 'impanual'=> $GetHlp[0]->impanual3),
//           //array('item'=>4,'texto'=>'BASE IMPONIBLE AFECTA / IMPUESTO ANUAL S/', 'alicuota'=> '', 'base'=> $GetHlp[0]->bitramot, 'impanual'=> $GetHlp[0]->impanualt),
//         );

//         $yy = $yr+66;
//         foreach ($criterios as $key => $value) {
//           $this->setXY(5,$yy);
//           $this->Cell(60,5,utf8_decode($value['texto']),1,0,'C');
//           $this->setXY(50,$yy);
//           $this->Cell(15,5,$value['alicuota'],1,0,'C'); // alicuota
//           $this->setXY(65,$yy);
//           $this->Cell(35,5,number_format((float)$value['base'], 2, '.', ','),1,0,'R'); // base imponible por tramos
//           $this->setXY(100,$yy);
//           $this->Cell(45,5,number_format((float)$value['impanual'], 2, '.', ','),1,0,'R'); // impuesto anual en s/
//           $yy=$yy+5;
//         }

//         $ya = $yy;
//         $this->setXY(5,$ya);
//         $this->Cell(60,5,utf8_decode('BASE IMPONIBLE AFECTA / IMPUESTO ANUAL S/'),1,0,'C');
//         $this->setXY(65,$ya);
//         $this->Cell(35,5,number_format((float)$GetHlp[0]->bitramot, 2, '.', ','),1,0,'R');
//         $this->setXY(100,$ya);
//         $this->Cell(45,5,number_format((float)$GetHlp[0]->impanualt, 2, '.', ','),1,0,'R');

//         $ya = $yy+5;
//         // LIQUIDACIÓN DEL IMPUESTO PREDIAL
//         $this->setXY(4,$ya);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,utf8_decode('LIQUIDACIÓN DEL IMPUESTO PREDIAL'),0,0,'L');

//         $ya = $ya+5;
//         $this->SetFont('Arial','',6);
//         $this->setXY(41,$ya);
//         $this->MultiCell(60,3,utf8_decode('IMPORTES (S/)'),1,'C',$withColor);
//         $this->setXY(5,$ya);
//         $this->MultiCell(16,4.5,utf8_decode('CUOTA TRIMESTRAL'),1,'C',$withColor);
//         $this->setXY(21,$ya);
//         $this->MultiCell(20,4.5,utf8_decode('FECHA VENCIMIENTO'),1,'C',$withColor);
//         $this->setXY(41,$ya+3);
//         $this->MultiCell(20,6,utf8_decode('INSOLUTO'),1,'C',$withColor);
//         $this->setXY(61,$ya+3);
//         $this->MultiCell(20,3,utf8_decode('DERECHO DE EMISIÓN'),1,'C',$withColor);
//         $this->setXY(81 ,$ya+3);
//         $this->MultiCell(20,6,utf8_decode('IMPORTE TOTAL'),1,'C',$withColor);
//         $this->setXY(101,$ya);
//         $this->MultiCell(44,9,utf8_decode('DOCUMENTOS DE DEUDA'),1,'C',$withColor);

//         $periodos = array(
//           array('cuota'=>1, 'fecvenc'=> '27/02/', 'insoluto'=> $GetHlp[0]->insolutot_1, 'emision'=> $GetHlp[0]->emision1, 'total'=>$GetHlp[0]->imptotal1, 'recibo'=>$GetHlp[0]->recibo1),
//           array('cuota'=>2, 'fecvenc'=> '31/05/', 'insoluto'=> $GetHlp[0]->insolutot_2, 'emision'=> '0.00', 'total'=>$GetHlp[0]->imptotal2, 'recibo'=>''),
//           array('cuota'=>3, 'fecvenc'=> '31/08/', 'insoluto'=> $GetHlp[0]->insolutot_3, 'emision'=> '0.00', 'total'=>$GetHlp[0]->imptotal3, 'recibo'=>''),
//           array('cuota'=>4, 'fecvenc'=> '30/11/', 'insoluto'=> $GetHlp[0]->insolutot_4, 'emision'=> '0.00', 'total'=>$GetHlp[0]->imptotal4, 'recibo'=>''),
//           array('cuota'=>'ANUAL', 'fecvenc'=> '27/02/', 'insoluto'=> $GetHlp[0]->insolutoa, 'emision'=> $GetHlp[0]->emision1, 'total'=>$GetHlp[0]->imptotala, 'recibo'=>''),
//         );

//         $year = date('Y');
//         $yy = $this->getY();
//         foreach ($periodos as $key => $value) {
//           $this->setXY(5,$yy);
//           $this->Cell(16,5,$value['cuota'],1,0,'C');
//           $this->setXY(21,$yy);
//           $this->Cell(20,5,$value['fecvenc'].$year,1,0,'C');
//           $this->setXY(41,$yy);
//           $this->Cell(20,5,number_format((float)$value['insoluto'], 2, '.', ','),1,0,'R');
//           $this->setXY(61,$yy);
//           $this->Cell(20,5,number_format((float)$value['emision'], 2, '.', ','),1,0,'R');
//           $this->setXY(81 ,$yy);
//           $this->Cell(20,5,number_format((float)$value['total'], 2, '.', ','),1,0,'R');
//           $this->setXY(101,$yy);
//           $this->Cell(44,5,$value['recibo'],1,0,'C');
//           $yy = $yy+5;
//         }

//         /************CUERPO*********/
//         $this->InFooter=true;
//         $this->footerHlp();
//     }

//     public function HLA($GetHLA) {
//         $this->setXY(0,0);

//         /*CABECERA*/
//         // Logo
//         $this->Image('imagescuponera/logo_fondo.jpeg',25,50,100);
//         $this->Image('imagescuponera/logo.jpg',5,3,25,16);
//         // $this->SetFont('Arial','',6);

//         // Arial bold 15
//         $this->SetFont('Arial','B',9);
//         // Movernos a la derecha
//         // $this->Cell(149,1,'',1,0,'L');
//         $this->setXY(30,5);
//         $this->Cell(87,4,utf8_decode('LIQUIDACIÓN DE ARBITRIOS MUNICIPALES '.date('Y')),0,0,'C');
//         $this->ln();
//         $this->setX(30);
//         $this->SetFont('Helvetica','',8);
//         $this->Cell(87,4,utf8_decode('Ordenanza N° 329-2019/MLV y Ordenanza N° 331-2019/MLV'),0,0,'C');
//         $this->ln();
//         $this->setX(36);
//         $this->SetFont('Helvetica','B',8);
//         $this->MultiCell(75,3,utf8_decode('Acuerdo de Consejo N° 337-2019 de la Municipalidad Metropolitana de Lima'),0,'C');

//         $this->setXY(126.5,10);
//         $this->SetFont('Helvetica','B',35);
//         $this->Cell(10,3,'HLA',0,0,'C');
//         $this->setXY(126.5,18);
//         $this->SetLineWidth(0.3);
//         $this->Rect(118, 4, 27, 13);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(10,3,utf8_decode('HOJA DE LIQUIDACIÓN'),0,0,'C');
//         $this->setXY(126.5,21);
//         $this->Cell(10,3,utf8_decode('DE ARBITRIOS'),0,0,'C');
        
//         $this->ln();
//         $this->setXY(100,26);
//         $this->SetFont('Helvetica','B',6);
//         $this->Cell(10,3,utf8_decode('N° D.J. MECANIZADA'),0,0,'C');
//         $this->setXY(126,26);
//         $this->Cell(10,3,$GetHLA[0]->nrodjmeca,0,1,'C');
//         $this->RoundedRect(118, 25, 27, 4, 1, '1234','FD');
//         // $this->Rect(118, 25, 27, 4);

//         /*******EN CABECERA**********/

//         //Datos del contribuyente
//         $withColor = false;
//         $yCuerpo = 25;
//         $this->setXY(4,$yCuerpo);
//         // $this->SetTextColor(0,120,0);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'DATOS DEL CONTRIBUYENTE',0,0,'L');
//         $this->ln();
//         $yr=$this->GetY();
//         $this->setX(5);
//         $this->SetFont('Arial','',6);
//         $this->SetFillColor(93, 93, 164);
//         $this->SetTextColor(18,18,17);
//         // $this->SetTextColor(255,255,255);
//         $this->MultiCell(20,5,utf8_decode('CÓDIGO'),1,'C',$withColor);
//         $this->setXY(25,$yr);
//         $this->MultiCell(98,5,utf8_decode('APELLIDOS Y NOMBRES / RAZÓN SOCIAL'),1,'C',$withColor);
//         $this->setXY(123,$yr);
//         $this->MultiCell(22,5,utf8_decode('DNI/RUC/OTROS'),1,'C',$withColor);
//         $this->setX(5);
//         $this->Cell(20,4,$GetHLA[0]->codcontrib,1,0,'C'); // codigo contribuyente
//         $this->setXY(25,$yr+5);
//         $this->Cell(98,4,$GetHLA[0]->apenom,1,0,'C'); // apellido y nombres / razon social
//         $this->setXY(123,$yr+5);
//         $this->Cell(22,4,$GetHLA[0]->dniruc,1,0,'C'); // dni/ruc/otros
//         $this->ln(5);

//         // DATOS DEL PREDIO
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'DATOS DEL PREDIO',0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('ANEXO'),1,'C',$withColor);
//         $this->setXY(15,$yr+15);
//         $this->MultiCell(34,4,utf8_decode('VIA'),1,'C',$withColor);
//         $this->setXY(49,$yr+15);
//         $this->MultiCell(14,4,utf8_decode('NÚMERO 1'),1,'C',$withColor);
//         $this->setXY(63,$yr+15);
//         $this->MultiCell(14,4,utf8_decode('NÚMERO 2'),1,'C',$withColor);
//         $this->setXY(77,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('LETRA'),1,'C',$withColor);
//         $this->setXY(87,$yr+15);
//         $this->MultiCell(14,4,utf8_decode('INTERIOR'),1,'C',$withColor);
//         $this->setXY(101,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('BLOCK'),1,'C',$withColor);
//         $this->setXY(111,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('PISO'),1,'C',$withColor);
//         $this->setXY(121,$yr+15);
//         $this->MultiCell(14,4,utf8_decode('EDIFICIO'),1,'C',$withColor);
//         $this->setXY(135,$yr+15);
//         $this->MultiCell(10,4,utf8_decode('DPTO'),1,'C',$withColor);

//         $this->setX(5);
//         $this->Cell(10,4,$GetHLA[0]->anexo,1,0,'C'); //anexo
//         $this->setXY(15,$yr+19);
//         $this->Cell(34,4,$GetHLA[0]->via,1,0,'C'); //via
//         $this->setXY(49,$yr+19);
//         $this->Cell(14,4,$GetHLA[0]->numero,1,0,'C'); //numero 1
//         $this->setXY(63,$yr+19);
//         $this->Cell(14,4,$GetHLA[0]->numero1,1,0,'C'); //numero 2
//         $this->setXY(77,$yr+19);
//         $this->Cell(10,4,$GetHLA[0]->letra,1,0,'C'); //letra
//         $this->setXY(87,$yr+19);
//         $this->Cell(14,4,$GetHLA[0]->interior,1,0,'C'); //interior
//         $this->setXY(101,$yr+19);
//         $this->Cell(10,4,$GetHLA[0]->block,1,0,'C'); //block
//         $this->setXY(111,$yr+19);
//         $this->Cell(10,4,$GetHLA[0]->piso,1,0,'C'); //piso
//         $this->setXY(121,$yr+19);
//         $this->Cell(14,4,$GetHLA[0]->edificio,1,0,'C'); //edificio
//         $this->setXY(135,$yr+19);
//         $this->Cell(10,4,$GetHLA[0]->departamento,1,0,'C'); //dpto

//         $this->SetFont('Arial','',4);
//         $this->setXY(5,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('MANZANA'),1,'C',$withColor);
//         $this->SetFont('Arial','',5);
//         $this->setXY(15,$yr+23);
//         $this->MultiCell(7,4,utf8_decode('LOTE'),1,'C',$withColor);
//         $this->setXY(22,$yr+23);
//         $this->MultiCell(9,4,utf8_decode('STAND'),1,'C',$withColor);
//         $this->setXY(31,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('OFICINA'),1,'C',$withColor);
//         $this->setXY(41,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('SUB MZ'),1,'C',$withColor);
//         $this->setXY(51,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('SUB LT'),1,'C',$withColor);
//         $this->setXY(61,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('TIENDA'),1,'C',$withColor);
//         $this->setXY(71,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('SÓTANO'),1,'C',$withColor);
//         $this->setXY(81,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('AZOTEA'),1,'C',$withColor);
//         $this->setXY(91,$yr+23);
//         $this->MultiCell(11,4,utf8_decode('SECCIÓN'),1,'C',$withColor);
//         $this->setXY(102,$yr+23);
//         $this->MultiCell(11,4,utf8_decode('UNID.INM'),1,'C',$withColor);
//         $this->setXY(113,$yr+23);
//         $this->MultiCell(10,4,utf8_decode('DEPOS'),1,'C',$withColor);
//         $this->setXY(123,$yr+23);
//         $this->MultiCell(22,4,utf8_decode('ESTACIONAM.'),1,'C',$withColor);

//         $this->SetFont('Arial','',4);
//         $this->setX(5);
//         $this->Cell(10,4,$GetHLA[0]->manzana,1,0,'C'); //manzana
//         $this->SetFont('Arial','',5);
//         $this->setXY(15,$yr+27);
//         $this->Cell(7,4,$GetHLA[0]->lote,1,0,'C'); //lote
//         $this->setXY(22,$yr+27);
//         $this->Cell(9,4,$GetHLA[0]->stand,1,0,'C'); //stand
//         $this->setXY(31,$yr+27);
//         $this->Cell(10,4,$GetHLA[0]->oficina,1,0,'C'); //oficina
//         $this->setXY(41,$yr+27);
//         $this->Cell(10,4,$GetHLA[0]->submanzana,1,0,'C'); //sub mz
//         $this->setXY(51,$yr+27);
//         $this->Cell(10,4,$GetHLA[0]->sublote,1,0,'C'); // sub lt
//         $this->setXY(61,$yr+27);
//         $this->Cell(10,4,$GetHLA[0]->tienda,1,0,'C'); // tienda
//         $this->setXY(71,$yr+27);
//         $this->Cell(10,4,$GetHLA[0]->sotano,1,0,'C'); // sotano
//         $this->setXY(81,$yr+27);
//         $this->Cell(10,4,$GetHLA[0]->azotea,1,0,'C'); // azotea
//         $this->setXY(91,$yr+27);
//         $this->Cell(11,4,$GetHLA[0]->seccion,1,0,'C'); //seccion
//         $this->setXY(102,$yr+27);
//         $this->Cell(11,4,$GetHLA[0]->unidadinmob,1,0,'C'); // unid.inm
//         $this->setXY(113,$yr+27);
//         $this->Cell(10,4,$GetHLA[0]->deposito,1,0,'C'); // depos
//         $this->setXY(123,$yr+27);
//         $this->Cell(22,4,$GetHLA[0]->estacionam,1,0,'C'); // estacionam

//         $this->setXY(5,$yr+31);
//         $this->MultiCell(17,4,utf8_decode('URBANIZACIÓN'),1,'C',$withColor);
//         $this->setXY(22,$yr+31);
//         $this->Cell(49,4,utf8_decode($GetHLA[0]->conjurbano),1,0,'C'); //urbanización
//         $this->setXY(71,$yr+31);
//         $this->MultiCell(17,4,utf8_decode('REFERENCIA'),1,'C',$withColor);
//         $this->setXY(88,$yr+31);
//         $this->Cell(57,4,utf8_decode($GetHLA[0]->referencia),1,0,'C'); //referencia

//         $this->setXY(5,$yr+35);
//         $this->MultiCell(30,4,utf8_decode('CONDICIÓN DE PROPIEDAD'),1,'C',$withColor);
//         $this->setXY(35,$yr+35);
//         $this->MultiCell(25,4,utf8_decode('% DE PROPIEDAD'),1,'C',$withColor);
//         $this->setXY(60,$yr+35);
//         $this->MultiCell(11,4,utf8_decode('ZONA'),1,'C',$withColor);
//         $this->setXY(71,$yr+35);
//         $this->MultiCell(74,4,utf8_decode('USO DEL PREDIO'),1,'C',$withColor);

//         $this->setXY(5,$yr+39);
//         $this->Cell(30,4,utf8_decode($GetHLA[0]->condicion),1,0,'C'); // condicion de propiedad
//         $this->setXY(35,$yr+39);
//         $this->Cell(25,4,$GetHLA[0]->porcprop,1,0,'C'); // % de propiedad
//         $this->setXY(60,$yr+39);
//         $this->Cell(11,4,$GetHLA[0]->zona,1,0,'C'); // zona
//         $this->setXY(71,$yr+39);
//         $this->Cell(74,4,$GetHLA[0]->uso,1,0,'C'); // uso del predio
//         $this->ln();

//         // CRITERIOS PARA LA DETERMINACION DE ARBITRIOS
//         $this->setX(4);
//         $this->SetFont('Helvetica','B',7);
//         $this->Cell(100,5,'CRITERIOS PARA LA DETERMINACION DE ARBITRIOS',0,0,'L');

//         $this->ln(5);
//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$yr+47);
//         $this->MultiCell(140,4,utf8_decode('BARRIDO (I)'),1,'L',$withColor);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+51);
//         $this->MultiCell(10,6,utf8_decode('ZONA'),1,'C',$withColor);
//         $this->setXY(15,$yr+51);
//         $this->MultiCell(19,6,utf8_decode('FRENTE (ml) (a)'),1,'C',$withColor);
//         $this->setXY(34,$yr+51);
//         $this->MultiCell(25,6,utf8_decode('TASA (b)'),1,'C',$withColor);
//         $this->setXY(59,$yr+51);
//         $this->MultiCell(15,3,utf8_decode('IMPORTE (c) = (a) x (b)'),1,'C',$withColor);
//         $this->setXY(74,$yr+51);
//         $this->MultiCell(18,6,utf8_decode('% PROPIEDAD'),1,'C',$withColor);
//         $this->setXY(92,$yr+51);
//         $this->MultiCell(17,3,utf8_decode('BENEFICIO PENSIONISTA'),1,'C',$withColor);
//         $this->setXY(109,$yr+51);
//         $this->MultiCell(36,6,utf8_decode('BARRIDO EN S/ (I)'),1,'C',$withColor);

//         $this->setXY(5,$yr+57);
//         $this->Cell(10,5,$GetHLA[0]->zona,1,0,'C'); //zona
//         $this->setXY(15,$yr+57);
//         $this->Cell(19,5,number_format((float)$GetHLA[0]->frente, 2, '.', ','),1,0,'C'); //frente
//         $this->setXY(34,$yr+57);
//         $this->Cell(25,5,number_format((float)$GetHLA[0]->tasabarrid, 2, '.', ','),1,0,'C'); //tasa
//         $this->setXY(59,$yr+57);
//         $this->Cell(15,5,number_format((float)$GetHLA[0]->impbarrido, 2, '.', ','),1,0,'C'); //importe
//         $this->setXY(74,$yr+57);
//         $this->Cell(18,5,$GetHLA[0]->porcprop,1,0,'C'); // % propiedad
//         $this->setXY(92,$yr+57);
//         $this->Cell(17,5,$GetHLA[0]->benefpens,1,0,'C'); //beneficio pensionista
//         $this->setXY(109,$yr+57);
//         $this->Cell(36,5,number_format((float)$GetHLA[0]->barrido, 2, '.', ','),1,0,'C'); //barrido en s/

//         $this->ln(5);
//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$yr+62);
//         $this->MultiCell(140,4,utf8_decode('RESIDUOS SÓLIDOS (II)'),1,'L',$withColor);
//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+66);
//         $this->MultiCell(10,6,utf8_decode('ZONA'),1,'C',$withColor);
//         $this->setXY(15,$yr+66);
//         $this->MultiCell(19,6,utf8_decode('USO'),1,'C',$withColor);
//         $this->setXY(34,$yr+66);
//         $this->MultiCell(10,2,utf8_decode('A. CONST. (a)'),1,'C',$withColor);
//         $this->setXY(44,$yr+66);
//         $this->MultiCell(15,6,utf8_decode('TASA (b)'),1,'C',$withColor);
//         $this->setXY(59,$yr+66);
//         $this->MultiCell(15,3,utf8_decode('IMPORTE (c) = (a) x (b)'),1,'C',$withColor);
//         $this->setXY(74,$yr+66);
//         $this->MultiCell(18,6,utf8_decode('% PROPIEDAD'),1,'C',$withColor);
//         $this->setXY(92,$yr+66);
//         $this->MultiCell(17,3,utf8_decode('BENEFICIO PENSIONISTA'),1,'C',$withColor);
//         $this->setXY(109,$yr+66);
//         $this->MultiCell(36,6,utf8_decode('BARRIDO SÓLIDOS EN S/ (II)'),1,'C',$withColor);

//         $lenuso = strlen($GetHLA[0]->uso);
//         if ($lenuso>21) {
//           $substr_uso = substr($GetHLA[0]->uso,0,21);
//         }else {
//           $substr_uso = $GetHLA[0]->uso;
//         }

//         $strlen_uso = strlen($substr_uso);
//         // echo strlen('CASA HABITACION'); die();
//         // echo strlen('TIENDA DE BIENES Y/O SERVICIOS'); die();
//         // echo strlen('VENTA DE AUTOPARTES Y REPUESTO'); die();
//         // echo $substr_uso; die();
//         $ya = 5;
//         if ($strlen_uso>15) $ya = 2.5;

//         $this->SetFont('Arial','',6);
//         $this->setXY(5,$yr+72);
//         $this->Cell(10,5,$GetHLA[0]->zona,1,0,'C'); //zona 
//         $this->setXY(15,$yr+72);
//         $this->SetFont('Arial','',4.5);
//         $this->MultiCell(19,$ya,utf8_decode($substr_uso),1,'C'); //uso 2.5 y 6
//         $this->SetFont('Arial','',6);
//         $this->setXY(34,$yr+72);
//         $this->Cell(10,5,$GetHLA[0]->areaconst,1,0,'C'); // a. const
//         $this->setXY(44,$yr+72);
//         $this->Cell(15,5,number_format((float)$GetHLA[0]->tasaresid, 2, '.', ','),1,0,'C'); //tasa
//         $this->setXY(59,$yr+72);
//         $this->Cell(15,5,number_format((float)$GetHLA[0]->impresid, 2, '.', ','),1,0,'C'); //importe
//         $this->setXY(74,$yr+72);
//         $this->Cell(18,5,$GetHLA[0]->porcprop,1,0,'C'); //% propiedad
//         $this->setXY(92,$yr+72);
//         $this->Cell(17,5,$GetHLA[0]->benefpens,1,0,'C'); //beneficio pensionista
//         $this->setXY(109,$yr+72);
//         $this->Cell(36,5,number_format((float)$GetHLA[0]->residuo, 2, '.', ','),1,0,'C'); // barrido solido en s/

//         $this->ln(5);
//         $this->SetFont('Arial','',6);
//         $this->setXY(109,$yr+77);
//         $this->MultiCell(18,3,utf8_decode('LIM. PÚBLICA EN S/'),1,'C',$withColor);
//         $this->setXY(127,$yr+77);
//         $this->MultiCell(18,2,utf8_decode('LIM. PÚBLICA CON TOPE EN S/'),1,'C',$withColor);

//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$yr+83);
//         $this->MultiCell(104,4,utf8_decode('LIMPIEZA PÚBLICA: BARRIDO(I) + RESIDUOS SÓLIDOS(II)'),1,'R',$withColor);
//         $this->SetFont('Arial','',6);
//         $this->setXY(109,$yr+83);
//         $this->Cell(18,4,number_format((float)$GetHLA[0]->limpieza, 2, '.', ','),1,0,'C'); // limpieza publica
//         $this->setXY(127,$yr+83);
//         $this->Cell(18,4,number_format((float)$GetHLA[0]->residuotop, 2, '.', ','),1,0,'C'); // limpieza publica con tope

//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$yr+87);
//         $this->MultiCell(104,4,utf8_decode('IMPORTE MENSUAL LIMPIEZA PÚBLICA: BARRIDO + RESIDUOS SÓLIDOS'),1,'R',$withColor);
//         $this->SetFont('Arial','',6);
//         $this->setXY(109,$yr+87);
//         $this->Cell(36,4,number_format((float)$GetHLA[0]->barridotop, 2, '.', ','),1,0,'C'); // importe mensual limpieza publica, barrido, residuo

//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$yr+92);
//         $this->MultiCell(140,4,utf8_decode('PARQUES Y JARDINES PÚBLICOS'),1,'L',$withColor);
//         $this->SetFont('Arial','',6);


//         $this->setXY(5,$yr+96);
//         $this->MultiCell(10,2.5,utf8_decode('ZONA PJ.'),1,'C',$withColor);
//         $this->setXY(15,$yr+96);
//         $this->MultiCell(29,5,utf8_decode('UBIC. PJ.'),1,'C',$withColor);
//         $this->setXY(44,$yr+96);
//         $this->MultiCell(15,5,utf8_decode('TASA'),1,'C',$withColor);
//         $this->setXY(59,$yr+96);
//         $this->MultiCell(15,5,utf8_decode('IMPORTE'),1,'C',$withColor);
//         $this->setXY(74,$yr+96);
//         $this->MultiCell(18,5,utf8_decode('% PROPIEDAD'),1,'C',$withColor);
//         $this->setXY(92,$yr+96);
//         $this->MultiCell(17,2.5,utf8_decode('BENEFICIO PENSIONISTA'),1,'C',$withColor);
//         $this->setXY(109,$yr+96);
//         $this->MultiCell(18,2.5,utf8_decode('PQ. Y JARDIN EN S/.'),1,'C',$withColor);
//         $this->setXY(127,$yr+96);
//         $this->MultiCell(18,1.7,utf8_decode('PQ. Y JARDIN CON TOPE EN S/.'),1,'C',$withColor);

//         $this->setXY(5,$yr+101);
//         $this->Cell(10,5,$GetHLA[0]->zonapj,1,0,'C'); //zonapj
//         $this->SetFont('Arial','',5);
//         $this->setXY(15,$yr+101);
//         $this->MultiCell(29,2.5,$GetHLA[0]->ubicacion,1,'C'); //ubicacion
//         $this->SetFont('Arial','',6);
//         $this->setXY(44,$yr+101);
//         $this->Cell(15,5,number_format((float)$GetHLA[0]->tasaparque, 2, '.', ','),1,0,'C'); // tasa
//         $this->setXY(59,$yr+101);
//         $this->Cell(15,5,number_format((float)$GetHLA[0]->impparque, 2, '.', ','),1,0,'C'); //importe
//         $this->setXY(74,$yr+101);
//         $this->Cell(18,5,$GetHLA[0]->porcprop,1,0,'C'); //% propiedad
//         $this->setXY(92,$yr+101);
//         $this->Cell(17,5,$GetHLA[0]->benefpens,1,0,'C'); // beneficio pensionista
//         $this->setXY(109,$yr+101);
//         $this->Cell(18,5,number_format((float)$GetHLA[0]->parque, 2, '.', ','),1,0,'C'); //pq y jardines
//         $this->setXY(127,$yr+101);
//         $this->Cell(18,5,number_format((float)$GetHLA[0]->parquetope, 2, '.', ','),1,0,'C'); //pq y jardines con tope

//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$yr+106);
//         $this->MultiCell(104,4,utf8_decode('IMPORTE MENSUAL: PARQUES Y JARDINES '),1,'R',$withColor);
//         $this->SetFont('Arial','',6);
//         $this->setXY(109,$yr+106);
//         $this->Cell(36,4,number_format((float)$GetHLA[0]->pjmensual, 2, '.', ','),1,0,'C');

//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$yr+110.5);
//         $this->MultiCell(140,4,utf8_decode('SERENAZGO'),1,'L',$withColor);
//         $this->SetFont('Arial','',6);

//         $this->setXY(5,$yr+114.5);
//         $this->MultiCell(10,5,utf8_decode('ZONA'),1,'C',$withColor);
//         $this->setXY(15,$yr+114.5);
//         $this->MultiCell(43,5,utf8_decode('USO'),1,'C',$withColor);
//         $this->setXY(58,$yr+114.5);
//         $this->MultiCell(16,5,utf8_decode('TASA'),1,'C',$withColor);
//         $this->setXY(74,$yr+114.5);
//         $this->MultiCell(18,5,utf8_decode('% PROPIEDAD'),1,'C',$withColor);
//         $this->setXY(92,$yr+114.5);
//         $this->MultiCell(17,2.5,utf8_decode('BENEFICIO PENSIONISTA'),1,'C',$withColor);
//         $this->setXY(109,$yr+114.5);
//         $this->MultiCell(18,2.5,utf8_decode('SERENAZGO EN S/.'),1,'C',$withColor);
//         $this->setXY(127,$yr+114.5);
//         $this->MultiCell(18,1.7,utf8_decode('SERENAZGO CON TOPE EN S/.'),1,'C',$withColor);

//         $this->setXY(5,$yr+119.5);
//         $this->Cell(10,5,$GetHLA[0]->zona,1,0,'C'); // zona
//         $this->setXY(15,$yr+119.5);
//         $this->Cell(43,5,$GetHLA[0]->uso,1,0,'C'); //uso
//         $this->setXY(58,$yr+119.5);
//         $this->Cell(16,5,number_format((float)$GetHLA[0]->tasaserena, 2, '.', ','),1,0,'C'); //tasa
//         $this->setXY(74,$yr+119.5);
//         $this->Cell(18,5,$GetHLA[0]->porcprop,1,0,'C'); //% propiedad
//         $this->setXY(92,$yr+119.5);
//         $this->Cell(17,5,$GetHLA[0]->benefpens,1,0,'C'); // beneficio pensionista
//         $this->setXY(109,$yr+119.5);
//         $this->Cell(18,5,number_format((float)$GetHLA[0]->serena, 2, '.', ','),1,0,'C'); //serenazgo
//         $this->setXY(127,$yr+119.5);
//         $this->Cell(18,5,number_format((float)$GetHLA[0]->serenatope, 2, '.', ','),1,0,'C'); //serenazgo con tope

//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$yr+124.5);
//         $this->MultiCell(104,4,utf8_decode('IMPORTE MENSUAL: SERENAZGO'),1,'R',$withColor);
//         $this->SetFont('Arial','',6);
//         $this->setXY(109,$yr+124.5);
//         $this->Cell(36,4,number_format((float)$GetHLA[0]->semensual, 2, '.', ','),1,0,'C');

//         $this->setXY(5,$yr+130);
//         $this->MultiCell(16,4,utf8_decode('CUOTA TRIMESTRAL'),1,'C',$withColor);
//         $this->setXY(21,$yr+130);
//         $this->MultiCell(16,4,utf8_decode('FECHA DE VENCIM.'),1,'C',$withColor);
//         $this->setXY(37,$yr+130);
//         $this->MultiCell(16,4,utf8_decode('LIMPIEZA PÚBLICA'),1,'C',$withColor);
//         $this->setXY(53,$yr+130);
//         $this->MultiCell(18,4,utf8_decode('PARQUES Y JARDINES'),1,'C',$withColor);
//         $this->setXY(71,$yr+130);
//         $this->MultiCell(16,8,utf8_decode('SERENAZGO'),1,'C',$withColor);
//         $this->setXY(87,$yr+130);
//         $this->MultiCell(18,4,utf8_decode('DERECHO DE EMISIÓN'),1,'C',$withColor);
//         $this->setXY(105,$yr+130);
//         $this->MultiCell(22,4,utf8_decode('TOTAL DE ARBITRIOS'),1,'C',$withColor);
//         $this->setXY(127,$yr+130);
//         $this->MultiCell(18,4,utf8_decode('DOCUMENTO DE DEUDA'),1,'C',$withColor);

//         $cuotas = array(
//           array('cuota'=>1, 'fecvenc'=>'27/02/', 'lp'=>$GetHLA[0]->trilimpia, 'pj'=>$GetHLA[0]->triparque, 'serena'=>$GetHLA[0]->triserena, 'emision'=>$GetHLA[0]->costo1, 'total'=>$GetHLA[0]->trimtotal1, 'docu'=>$GetHLA[0]->recibo1),
//           array('cuota'=>2, 'fecvenc'=>'31/05/', 'lp'=>$GetHLA[0]->trilimpia, 'pj'=>$GetHLA[0]->triparque, 'serena'=>$GetHLA[0]->triserena, 'emision'=>$GetHLA[0]->costo1, 'total'=>$GetHLA[0]->trimtotal1, 'docu'=>$GetHLA[0]->recibo2),
//           array('cuota'=>3, 'fecvenc'=>'31/08/', 'lp'=>$GetHLA[0]->trilimpia, 'pj'=>$GetHLA[0]->triparque, 'serena'=>$GetHLA[0]->triserena, 'emision'=>0, 'total'=>$GetHLA[0]->trimtotal2, 'docu'=>$GetHLA[0]->recibo3),
//           array('cuota'=>4, 'fecvenc'=>'30/11/', 'lp'=>$GetHLA[0]->trilimpia, 'pj'=>$GetHLA[0]->triparque, 'serena'=>$GetHLA[0]->triserena, 'emision'=>0, 'total'=>$GetHLA[0]->trimtotal2, 'docu'=>$GetHLA[0]->recibo4),
//         );

//         $year = date('Y');
//         $yy = $yr+138;
//         foreach ($cuotas as $key => $value) {
//           $this->setXY(5,$yy);
//           $this->Cell(16,4,$value['cuota'],1,0,'C'); // cuota trimestral
//           $this->setXY(21,$yy);
//           $this->Cell(16,4,$value['fecvenc'].$year,1,0,'C'); // fec vencimiento
//           $this->setXY(37,$yy);
//           $this->Cell(16,4,number_format((float)$value['lp'], 2, '.', ','),1,0,'R'); // limpieza publica 
//           $this->setXY(53,$yy);
//           $this->Cell(18,4,number_format((float)$value['pj'], 2, '.', ','),1,0,'R'); //parques y jardines
//           $this->setXY(71 ,$yy);
//           $this->Cell(16,4,number_format((float)$value['serena'], 2, '.', ','),1,0,'R'); // serenazgo
//           $this->setXY(87,$yy);
//           $this->Cell(18,4,number_format((float)$value['emision'], 2, '.', ','),1,0,'R'); //derecho emision
//           $this->setXY(105,$yy);
//           $this->Cell(22,4,number_format((float)$value['total'], 2, '.', ','),1,0,'R'); // total arbitrios
//           $this->setXY(127,$yy);
//           $this->Cell(18,4,$value['docu'],1,0,'C'); // documento deuda
//           $yy = $yy+4;
//         }      
//         $t=$this->getY()+4;
//         $this->SetFont('Arial','B',6);
//         $this->setXY(5,$t);
//         $this->Cell(100,4,'PAGO TOTAL ANUAL DE ARBITRIOS MUNICIPALES',1,0,'R');
//         $this->SetFont('Arial','',6);
//         $this->setXY(105,$t);
//         $this->Cell(22,4,$GetHLA[0]->anualtotal,1,0,'R');

//         $this->InFooter=true;
//         $this->footerHla();
//     }

//     public function pagprev() {
//       $this->setXY(0,0);
//       $this->Image('imagescuponera/p2.jpeg', 0, 0, 150);
//     }

//     public function pagfinal() {
//       $this->setXY(0,0);
//       $this->Image('imagescuponera/pfinal.jpeg', 0, 0, 150);
//     }

// }
//     //Set new document PDF
//     $GetHr=query::GetHr($c_idcont,$ddjj);

//     $pdf = new Cuponera();
//     $pdf->AliasNbPages();
//     $pdf->fechaEmision = str_replace("-", "/", date("d-m-Y"));
//     $pdf->AddPage();
//     $pdf->pag1();
//     $pdf->AddPage();
//     $pdf->pag2();
//     $pdf->AddPage();
//     $pdf->HR($GetHr);
    
//     foreach ($GetHr as $predios) {
//      unset($GetPU);
//      unset($GetDetPU);
//      $GetPU=query::GetPU($c_idcont,$predios->anexo);
//      $GetDetPU=query::GetDetPU($c_idcont,$predios->anexo);
//      $pdf->AddPage();
//      $pdf->PU($GetPU,$GetDetPU);
//     }

//     $GetHlp=query::GetHlp($c_idcont);
//     $pdf->AddPage();
//     $pdf->HLP($GetHlp);
    
//     foreach ($GetHr as $predios) {
//      unset($GetHLA);
//      $GetHLA=query::GetHla($c_idcont,$predios->anexo);
//      $pdf->AddPage();
//      $pdf->HLA($GetHLA);
//     }

//     $pdf->AddPage();
//     $pdf->pagprev();
//     $pdf->AddPage();
//     $pdf->pagfinal();
    #$nombre='pdfs/'.$ddjj.'-'.$c_idcont.'.pdf';
    $nombre='pdfs/Cup-16712-TAKEHARA SHIROTA JULIO.pdf';
//    $pdf->Output($nombre);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Cuponera Digital - Municipalidad Distrital de La Victoria">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Cuponera Digital</title>
    <meta charset="utf-8">
</head>
<body>
    <style type="text/css">
        body {
            background-color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            height: 95vh;
            width: 95%;
            margin: 20px auto;
        }

        .fullscreen {
            background-color: #333;
        }
    </style>
    <div class="container" id="container">
    </div>
    <script src="js/libs/jquery.min.js"></script>
    <script src="js/libs/html2canvas.min.js"></script>
    <script src="js/libs/three.min.js"></script>
    <script src="js/libs/pdf.min.js"></script>
    <script type="text/javascript">
        window.PDFJS_LOCALE = {
            pdfJsWorker: 'js/pdf.worker.js'
        };
    </script>
    <script src="js/dist/3dflipbook.js"></script>
    <script type="text/javascript">
        $('#container').FlipBook({
            pdf: '<?php echo $nombre; ?>',
            template: {
                html: 'default-book-view.html',
                styles: [
                    'css/short-black-book-view.css'
                ],
                links: [
                    {
                        rel: 'stylesheet',
                        href: 'css/font-awesome.min.css'
                    }
                ],
                script: 'js/default-book-view.js',
                sounds: {
                    startFlip: 'sounds/start-flip.mp3',
                    endFlip: 'sounds/end-flip.mp3'
                  }
                  
            },
            controlsProps: {
                downloadURL: '<?php echo $nombre; ?>'
            }
        });
    </script>
</body>
<!-- </html> -->