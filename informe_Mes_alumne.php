<?php 
session_start();
// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions
include_once("config.inc.php");
include_once(_DIR_CONNEXIO."seguretat.inc.php");



//Crido a la classe pdf
//Per tenir capçalera informe_pdf.php // sense capçalera fpdf.php
//require(_BASE_PATH."/pdf/informe_pdf.php");

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$utils = new utils();
$RSRC = array();
$VALS = array();
$dniAlumne=$_GET['dniAlumne'];
$int_mes =$_GET['mes'];
$int_any = $_GET['any'];
$int_data=$_GET['data'];

//configurem ldap
$ldapconfig['host'] = _LDAP_SERVER;
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] = _LDAP_USER;
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

$password=_LDAP_PASSWORD;
$dn=_LDAP_USER;
			
	if ($bind=ldap_bind($ds, $dn, $password)) {
	}else{
	# Error
	}

$search = ldap_search($ds, "ou=Alumnes,ou=All,dc=iesebre,dc=com","irispersonaluniqueid=".$dniAlumne) or die ("Search failed");
$info = ldap_get_entries($ds, $search);
	
$cn=$info[0]['cn'][0];
$dni=$dniAlumne;
$number=$info[0]['employeenumber'][0];
	

if(isset($_GET['data'])){
	$int_data =date("Y-m-d", strtotime($_GET['data']));
}else{
	$int_data = strftime( "%Y-%m-%d", time());
}

	

$VALS['dni']=$dni;
$VALS['number']=$number;
$VALS['data']=$int_data;
$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['consulta_incidencia_conserges']) or die($ConTut->ErrorMsg());


function getMonthDays($Month, $Year)
{
   //Si la extensión que mencioné está instalada, usamos esa.
   if( is_callable("cal_days_in_month"))
   {
      return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
   }
   else
   {
      //Lo hacemos a mi manera.
      return date("d",mktime(0,0,0,$Month+1,0,$Year));
   }
}



$pdf = new FPDF();

$pdf=new institut_ebre_new();
//Marge esquerre
$pdf->SetLeftMargin(15);
//Nova pàgina
$pdf->AddPage();
//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc i per últim el tamany
$pdf->SetFont('Arial','',12);

//Capçalera
//color
$pdf->SetFillColor(150,150,150);
//variable que ens indica si la cel·la s'ha de pintar o no
$fill=true;
$pdf->Cell(150,0,"Llista de faltes de l'aulmne ".utf8_decode($cn),0,0,'C');
//Salt de línia
$pdf->Ln(7);
//ens indica en quina columna ens trobem
$x=0;


$cap=array('Nom assignatura','Tipus falta','data','hora');

$pdf->Cell(40,8,'Nom assignatura',1,0,'L',$fill);
$pdf->Cell(30,8,'Tipus falta',1,0,'L',$fill);
$pdf->Cell(25,8,'Data',1,0,'L',$fill);
$pdf->Cell(25,8,'Hora',1,0,'L',$fill);
$pdf->Cell(50,8,'Observacions',1,0,'L',$fill);

$pdf->Ln();

//Dades
$pdf->SetFillColor(219,219,219);
$fill=false;
$pdf->SetFont('Arial','',8);

foreach($result as $row){
	if($row['motiu_llarg']!='sense incidencia'){
	$pdf->Cell(40,8,utf8_decode($row['nom_assignatura']),1,0,'L',$fill);
	$pdf->Cell(30,8,utf8_decode($row['motiu_llarg']),1,0,'L',$fill);
	$pdf->Cell(25,8,utf8_decode($row['data_incidencia']),1,0,'L',$fill);
	$pdf->Cell(25,8,utf8_decode($row['hora_inici']),1,0,'L',$fill);
	$pdf->Cell(50,8,utf8_decode($row['observacions']),1,0,'L',$fill);
	//$fill=!$fill;
	$pdf->Ln();
	}
}
$pdf->Output('','');
?>