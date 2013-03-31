<?php 


// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)	
session_start();
// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions	
include_once("config.inc.php");	
include_once("seguretat.inc.php");


$utils = new utils();

$RSRC = array();
$VALS = array();


//Recuperem variables de sessió i les simplifiquem per a més comoditat	
	
$codi_alumne = $_GET['codi_alumne'];		
$codi_assignatura = $_GET['codi_assignatura'];	
$codi_grup = $_GET['codi_grup'];	
$nom = $_GET['nom'];	
$sn1 = $_GET['sn1'];
$sn2 = $_GET['sn2'];	
$dni = $_GET['dni'];

	$VALS['codi_alumne']= $codi_alumne;
	$VALS['codi_assignatura']= $codi_assignatura;
	$VALS['codi_grup']= $codi_grup;
	$VALS['nom']= $nom;
	$VALS['sn1']= $sn1;
	$VALS['sn2']= $sn2;
	$VALS['dni']= $dni;
	
	$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
	$utils->p_dbg($RSRC, "Prova log");
	$result = $ConTut->Execute($RSRC['COMPROVAR_OCULT_ALUMNE']) or die($ConTut->ErrorMsg());
	$trobat="false";
	foreach ($result as $row){
		if($row['codi_alumne']==$codi_alumne){
		$trobat="true";	
		}
	}
	if($trobat=="true"){
	
		$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$result = $ConTut->Execute($RSRC['ELIMINAR_ALUMNE_OCULTS']) or die($ConTut->ErrorMsg());	
	}else{
	
		$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$result = $ConTut->Execute($RSRC['INSEREIX_ALUMNES_OCULTS']) or die($ConTut->ErrorMsg());	
	}

?>


