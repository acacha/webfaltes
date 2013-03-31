<?php	
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Joan Verge Chillida
 *
 * This library is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation; either version 2.1 of the License, or (at your option)
 * any later version.
 * 
 * This library is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with this library; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 * http://www.fsf.org/licensing/licenses/lgpl.txt
 *$Id:insereix_inc.php 285 2010-03-05 17:40:30Z jverge $
 */
 

// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)	
session_start();
// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions	
include_once("config.inc.php");	
include_once("seguretat.inc.php");


$utils = new utils();

$RSRC = array();
$VALS = array();

//Recuperem variables de sessió i les simplifiquem per a més comoditat	
$usuari = $_SESSION['S_usuari'];
$codi_professor = $_SESSION['codi_professor'];	
$codi_incidencia = $_GET['codi_incidencia'];	
$codi_alumne = $_GET['codi_alumne'];	
$codi_dia = $_GET['codi_dia'];	
$codi_hora = $_GET['codi_hora'];	
$codi_assignatura = $_GET['codi_assignatura'];	
$data_incidencia = $_GET['data_incidencia'];	
$motiu_incidencia = $_GET['motiu_incidencia'];	
$justificant = $_GET['justificant'];	
$observacions = $_GET['observacions'];
$nom_professor = $_GET['nom_professor'];	
$cognom1_professor = $_GET['cognom1_professor'];
$codi_professor = $_GET['codi_professor'];
//$sql2 = "START TRANSACTION;"		
if ($codi_incidencia == ""){
//comprovem que en realitat no hi ha cap incidencia per aquest dia i aquesta hora. 
//Aixó és per qué si un professor/a posa una F i acte seguit la canvia a p.e. una E, aquesta E ve sense 	
//codi d'incidéncia, però en realitat ja hi ha una incidéncia.	
//Consulta de selecció dels alumnes corresponents a l'assignatura per el dia de la setmana indicat, ho
//ra indicada, data indicada
	
  $VALS['codi_alumne']= $codi_alumne;
  $VALS['codi_dia'] = $codi_dia; 
  $VALS['codi_hora']= $codi_hora;
  $VALS['codi_assignatura']= $codi_assignatura;
  $VALS['data_incidencia']= $data_incidencia;
  $VALS['motiu_incidencia']= $motiu_incidencia;
  $VALS['justificant']= $justificant;
  $VALS['observacions']= $observacions;
  $VALS['cognom1_professor']= $cognom1_professor;
  $VALS['nom_professor']= $nom_professor;
  $VALS['codi_professor']= $codi_professor;	
  
  $utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

  $utils->p_dbg($RSRC, "Prova log");				
  
  //echo $sql;

  // Execuci� de la consulta. Si hi ha error, es mostra missatge
  $result = $ConTut->Execute($RSRC['INSEREIX_INC_1']) or die($ConTut->ErrorMsg());				
  if (!$result->EOF){ 			
    $codi_incidencia =  $result->Fields('codi_incidencia');
    }
    $result->Close();	
}
if ($codi_incidencia == ""){	
	$VALS['codi_alumne']= $codi_alumne;
	$VALS['codi_dia'] = $codi_dia; 
	$VALS['codi_hora']= $codi_hora;
	$VALS['codi_assignatura']= $codi_assignatura;
	$VALS['data_incidencia']= $data_incidencia;
	$VALS['motiu_incidencia']= $motiu_incidencia;
	$VALS['justificant']= $justificant;
	$VALS['observacions']= $observacions;
	$VALS['cognom1_professor']= $cognom1_professor;
	$VALS['nom_professor']= $nom_professor;
	$VALS['codi_professor']= $codi_professor;	

	
    $utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

	$utils->p_dbg($RSRC, "Prova log");
	
	$sql2=$RSRC['INSEREIX_INC_2'];
}
else{
	$VALS['motiu_incidencia']= $motiu_incidencia;
	$VALS['codi_incidencia']= $codi_incidencia;
	$VALS['observacions']= $observacions;
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

	$utils->p_dbg($RSRC, "Prova log");
	
	
	if( $motiu_incidencia != 10){
	$sql2=$RSRC['INSEREIX_INC_3'];
	}else{
	$sql2=$RSRC['INSEREIX_INC_4'];
	}
	

}
// Execució de la consulta. Si hi ha error, es mostra missatge	
//Aquest possible error s'ha de consultar en logs/php_error.log		

echo "\n";
echo $sql2;
$result2 = $ConTut->Execute($sql2) or die($ConTut->ErrorMsg());	
$result2->Close();	
//$sql3 .= "COMMIT" 	
//$result3 = $ConTut->Execute($sql3) or die($ConTut->ErrorMsg());
?>