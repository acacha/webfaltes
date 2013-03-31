<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Ester Almela Sánchez
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
 * $Id$
 */

// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)	
session_start();
// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions	
include_once("config.inc.php");	
include_once("seguretat.inc.php");

//echo "holaaaaaaaa";
$utils = new utils();

$RSRC = array();
$VALS = array();

//Recuperem variables de sessió i les simplifiquem per a més comoditat	
$usuari = $_SESSION['S_usuari'];
$codi_professor = $_SESSION['codi_professor'];	
$codi_alumne = $_GET['codi_alumne'];
//echo $codi_alumne;
$codi_assignatura = $_GET['codi_assignatura'];
//echo $codi_assignatura;
$estat = $_GET['estat'];
//echo $estat;

	
 
  $VALS['codi_assignatura']= $codi_assignatura;
  $VALS['codi_alumne']= $codi_alumne;
  $VALS['estat']=$estat;
  
  $utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

  $utils->p_dbg($RSRC, "Prova log");				
  
 

  // Execució de la consulta. Si hi ha error, es mostra missatge
  $result = $ConTut->Execute($RSRC['INSEREIX_EST_1']) or die($ConTut->ErrorMsg());
  if (!$result->EOF)
  { 		
    $codi =  $result->Fields('codi_alumne');
  }
  
  $result->Close();
  if (!isset($codi))
  {
  	
		$VALS['codi_alumne']= $codi_alumne;
		$VALS['codi_assignatura']= $codi_assignatura;
		$VALS['estat']= $estat;
			
	    $utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	
		$utils->p_dbg($RSRC, "Prova log");
		
		$sql2=$RSRC['INSEREIX_EST_2'];
  }	


else
{
	$VALS['codi_assignatura']= $codi_assignatura;
	$VALS['estat']= $estat;

	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

	$utils->p_dbg($RSRC, "Prova log");
	
	$sql2=$RSRC['INSEREIX_EST_3'];
}
// Execució de la consulta. Si hi ha error, es mostra missatge	
//Aquest possible error s'ha de consultar en logs/php_error.log		

echo "\n";
//echo $sql2;
$result2 = $ConTut->Execute($sql2) or die($ConTut->ErrorMsg());	
$result2->Close();	
//$sql3 .= "COMMIT" 	
//$result3 = $ConTut->Execute($sql3) or die($ConTut->ErrorMsg());
?>