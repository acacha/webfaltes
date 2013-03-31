<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");
$utils = new utils();
$RSRC = array();
$VALS = array();

$eliminar=="false";
$nom=$_GET['nom'];
$sn1=$_GET['sn1'];
$sn2=$_GET['sn2'];
$dni=$_GET['dni'];
$codi=$_GET['codi'];
$grup=$_GET['grup'];
$codi_alumne=$_GET['codi_alumne'];
$ass=$_GET['ass'];
$assignatura=$_GET['assignatura'];
$eliminar=$_GET['eliminar'];

echo $eliminar;
if($eliminar=="true"){


$VALS['codi_grup']=$grup;
$VALS['codi_assignatura']=$assignatura;
$VALS['codi_alumne']=$codi_alumne;

$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['DELETE_ALUMNES_LDAP']) or die($ConTut->ErrorMsg());	
echo $VALS['codi_grup']."-".$VALS['codi_assignatura']."-".$VALS['codi_alumne'];

}else{

$VALS['nom']=$nom;	
$VALS['sn1']=$sn1;
$VALS['sn2']=$sn2;	
$VALS['dni']=$dni;
$VALS['codi_alumne']=$codi;	
$VALS['codi_grup']=$grup;
$VALS['codi_assignatura']=$ass;

	
$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['INSEREIX_ALUMNES_LDAP']) or die($ConTut->ErrorMsg());	
}

?>
