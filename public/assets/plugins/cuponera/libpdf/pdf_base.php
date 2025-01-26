<?php

	include("fpdf.php");
	class TSIARReport extends FPDF
	{
		// Attributes

		// Methods 
		function __construct($pOrientation='P', $pFormat='A4')
		{
			parent::__construct($pOrientation, 'mm', $pFormat);
			$this->SetMargins(15, 15, 15);
			$this->SetAutoPageBreak(true, 30);
			$this->AliasNbPages();
		}
		
		public function SIARHeader()
		{
			global $tipo_entidad;
			global $nombre_entidad;
			global $dir_entidad;
			global $ruc_entidad;
			global $tel_entidad;
			global $User;
			// Tipo de Entidad
			$this->SetXY($this->lMargin, $this->tMargin);
			$this->SetFont('Arial', 'B', 9);					
			$LogoWidth = $this->GetStringWidth($tipo_entidad);
			$this->Cell($LogoWidth, 0, $tipo_entidad, 0, 0, "C");
			// Nombre de Entidad
			$this->SetXY($this->lMargin, $this->getY() + 3.5);
			$this->Cell($LogoWidth, 0, $nombre_entidad, 0, 0, "C");
			// Dirección
			$this->SetFont('Arial','',6);
			$this->SetXY($this->lMargin, $this->getY() + 3.5);
			$this->Cell($LogoWidth, 0, $dir_entidad, 0, 0, "C");
			// RUC
			$this->SetFont('Arial','B',9);
			$this->SetXY($this->lMargin, $this->getY() + 3.5);
			$this->Cell($LogoWidth, 0, $ruc_entidad, 0, 0, "C");
			// Telefono
			$this->SetFont('Arial','',6);
			$this->SetXY($this->lMargin, $this->getY() + 3.5);
			$this->Cell($LogoWidth, 0, $tel_entidad, 0, 0, "C");
			
			$DateWidth = $this->GetStringWidth("Usuario: $User");
			$this->SetFont('Arial','',7);
			//Fecha
			$this->SetXY($this->w - $this->rMargin - $DateWidth, $this->tMargin + 3.5);
			$this->Cell($DateWidth, 0, "Fecha:   " . date('d/m/Y'), 0, 0, "L");
			//Hora
			$this->SetXY($this->w - $this->rMargin - $DateWidth, $this->getY() + 3.5);
			$this->Cell($DateWidth, 0, "Hora:     " . date('H:i:s'), 0, 0, "L");
			//Usuario
			$this->SetXY($this->w - $this->rMargin - $DateWidth, $this->getY() + 3.5);
			$this->Cell($DateWidth, 0, "Usuario: " . $User, 0, 0, "L");
		}
		
		public function SIARFooter() 
		{
			global $HostName;
			global $HostIP;
			$this->SetLineWidth(0.1);
			$this->Line($this->lMargin, $this->h - $this->bMargin + 13, $this->w - $this->rMargin, $this->h - $this->bMargin + 13);
			$this->SetY(-20);
			$this->SetFont('Arial','',7);
    		$this->Cell(0, 10, 'Nº de Página: '.$this->PageNo().' / {nb}', 0, 0, 'R');
			$this->SetY(-20);
			$this->SetFont('Arial','',7);
    		$this->Cell(0, 10, 'Host / IP : '.$HostName.' / '.$HostIP, 0, 0, 'L');
		}
		
		public function Header()
		{
			$this->SIARHeader();
		}
		
		public function Footer()
		{
			$this->SIARFooter();
		}
		
	}
	// class CSIARReport

	/*
	 * Clase TSIARDataReport
	*/

	class TSIARDataReport extends TSIARReport
	{
		//Attributes
		public $DataObj;
		public $ReportTitle;
		public $Fields = array();
		public $espacio_Items=3;
	
		//Methods
		/*
		 *
		 */
		public function SetEspacio_Items($espacio)
		{
			$this->espacio_Items=$espacio;
		} 
		 
		function __construct($cData, $pOrientation='P', $pFormat='A4', $pTitle='') 
		{
			parent::__construct($pOrientation, $pFormat);
			$this->DataObj = $cData;
			$this->ReportTitle = $pTitle;
		}
		
		/*
		 *
		 */
		public function Header() 
		{
			global $BeginDate;
			global $EndDate;
			
			$this->SIARHeader();
			$this->SetXY($this->lMargin, $this->GetY() + 10);
			$this->SetFont('Arial', 'B', 12);
    		$this->Cell(0, 0, $this->ReportTitle, 0, 0, 'C');
			$this->SetXY($this->lMargin, $this->GetY() + 10);
			$this->SetFont('Arial', '', 8);
    		$this->Cell(0, 0, "Del $BeginDate al $EndDate", 0, 0, 'L');
			$this->SetXY($this->lMargin, $this->GetY() + 3);
			$this->SetLineWidth(0.3);
			$this->SetFont('Arial', 'B', 7);
			$this->Line($this->lMargin, $this->GetY(), $this->w - $this->rMargin, $this->GetY());
			$this->Line($this->lMargin, $this->GetY()+5, $this->w - $this->rMargin, $this->GetY()+5);
			$this->SetXY($this->lMargin, $this->GetY() + 3);
			foreach($this->Fields as $Field)
				$this->Cell($Field['width'], 0, $Field['alias'], 0, 0, $Field['align']);
			$this->SetXY($this->lMargin, $this->GetY() + 5);

		}
		
		/*
		 *
		 */
		public function AddField($pName = '', $pAlias = '', $pWidth = 0, $pAlign = 'L', $pMulCel = false,$pNumerico=false)
		{
			$this->Fields[$pName] = array('name'=>$pName, 'alias'=>$pAlias, 'width'=>$pWidth, 'align'=>$pAlign, 'mulcel'=>$pMulCel,'numerico'=>$pNumerico);
		}
		
		/*
		 *
		 */
		public function PrintRow()
		{
			$AuxY = $this->GetY();
			$AuxX = $this->GetX();
			$MaxY = $this->GetY();
			foreach($this->Fields as $Field) {
				if($AuxY > $this->GetY()) {
					$MaxY = $this->GetY() + $MaxY - $AuxY;
					$AuxY = $this->GetY();
				}
				$this->SetY($AuxY);
				$this->SetX($AuxX);
				
				$dataArray = $this->DataObj->getRecord();
				
				if($Field['mulcel']) {
					$this->MultiCell($Field['width'], $this->espacio_Items, $dataArray[$Field['name']], 0, $Field['align']);
					$MaxY = ($MaxY > $this->GetY()) ? $MaxY : $this->GetY();
				}
				else if($Field['numerico'])
				{
					$this->Cell($Field['width'], $this->espacio_Items, number_format($dataArray[$Field['name']],2,'.',','), 0, 0, $Field['align']);
				}
				else
					$this->Cell($Field['width'], $this->espacio_Items, $dataArray[$Field['name']], 0, 1, $Field['align']);//Salto de Línea
				$AuxX += $Field['width'];
				
			}
			$this->Ln();
		}
		public function CheckPageBreak($h)
		{
			//If the height h would cause an overflow, add a new page immediately
			if($this->GetY()+$h>$this->PageBreakTrigger)
			{
				$this->AddPage($this->CurOrientation);
			}
		}
		
		public function NbLines($w,$txt)
		{
			//Computes the number of lines a MultiCell of width w will take
			$cw=&$this->CurrentFont['cw'];
			if($w==0)
				$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
				$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb)
			{
				$c=$s[$i];
				if($c=="\n")
				{
					$i++;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
					continue;
				}
				if($c==' ')
					$sep=$i;
				$l+=$cw[$c];
				if($l>$wmax)
				{
					if($sep==-1)
					{
						if($i==$j)
							$i++;
					}
					else
						$i=$sep+1;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
				}
				else
					$i++;
			}
			return $nl;
		}
		
	}
	
?>