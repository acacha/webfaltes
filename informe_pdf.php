<?php

class institut_ebre extends FPDF
{
   	//Cabecera de página
   	function Header()
   	{
   		//
   		$month=date('m');
   		if ($month>8){
   			$curs=date('Y')."-".(date('Y')+1);
   		}
   		else{
   			$curs=(date('Y')-1)."-".date('Y');
   		}
		//$this->Image('logo.png',10,8,33);
	    $this->SetLeftMargin(20);
	    $this->SetFont('Arial','B',12);
	    $this->Cell(50,8,utf8_decode("Institut de l'Ebre"),0,0,'L');
	    $this->Cell(50,8,utf8_decode("E/A-Cicles Formatius"),0,0,'C');
	    $this->Cell(50,8,utf8_decode("Curs "._ANY_COMENCAMENT_CURS."-"._ANY_FINALITZACIO_CURS),0,0,'R');
	    $this->Ln();
	    $this->Cell(50,8,utf8_decode("Tortosa"),0,0,'L');	    
//	    $this->Cell(150,10,utf8_decode("_____________________________________________________"),0,0,'C');
	    $this->Ln();   
	    $this->Ln();
	                
   	}
   
	//Pie de página
	function Footer()
	{
		$this->SetXY(0,-10);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,$this->PageNo(),0,0,'C');
	}
}
class institut_ebre_new extends FPDF
{
   	//Cabecera de página
   	function Header()
   	{
   		//
   		$month=date('m');
   		if ($month>8){
   			$curs=date('Y')."-".(date('Y')+1);
   		}
   		else{
   			$curs=(date('Y')-1)."-".date('Y');
   		}
		//$this->Image('logo.png',10,8,33);
	    $this->SetLeftMargin(20);
	    $this->SetFont('Arial','',8);                              //40, 15
	    $this->Image(_BASE_PATH."/imatges/cap_generalitat.jpg",12,10,60,22);
	    $this->Cell(175,8,utf8_decode("Curs: "._ANY_COMENCAMENT_CURS."-"._ANY_FINALITZACIO_CURS),0,0,'R');
	   	$this->Ln();
	    $this->Cell(175,8,utf8_decode("Data: ".date("d-m-Y")),0,0,'R');
	    $this->Ln();
	    $this->Cell(175,8,"Pagina: ".$this->PageNo(),0,0,'R');
	    $this->Ln();
	    //$this->Cell(50,8,utf8_decode("Tortosa"),0,0,'L');	    
//	    $this->Cell(150,10,utf8_decode("_____________________________________________________"),0,0,'C');
	    $this->Ln();   
	   // $this->Ln();                
   	}
   
	//Pie de página
	function Footer()
	{
		$this->SetXY(0,-10);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,$this->PageNo(),0,0,'C');
	}
}
?>