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
 */
/*$Id:informe_resum_credit_di_df_1.php 1411 2010-10-13 09:58:44Z irent88 $*/
/**
 * Aplicatiu d'incidencies de webfaltes
 * @author Carles Añó, Ester Almela
 * @desc Informe resum d'incidències dels alumnes d'un grup entre una data 
 * incial i una final
 * @see informe_resum_grup_di_df_1.php
 */


////////////////////////////////////////////////////////////////////////////////
//Falta connectar amb l'arxiu que mostri el resultat de la consulta			  //
//Falta que el select del grup, sgueixi sent un select despres d'haver canviat//
//la selecció, per si el profe es repensa.		                              //
////////////////////////////////////////////////////////////////////////////////

// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i
// funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_RESUM_CREDIT_DI_DF_1;
$name_of="Escollir informe";
$name_of2="Resum d'incidències d'un credit entre una data inicial i una data final";

//We load here common header application
require_once _INCLUDES.'common-header.php';


//Recuperem variables de sessió i les simplifiquem per a més comoditat
$codi_professor = $_SESSION['codi_professor'];
$usuari = $_SESSION['usuari'];


//el primer cop seleccionem el codi del grup, un cop seleccionat ja podem anar
// a mostrar l'informe
$hihacodi_grup = false; // No hi ha grup per defecte
$Enviar = false;

if (isset($_POST["codi_grup"])){
	$hihacodi_grup = true; //Si hi ha codi grup
	$codi_grup = $_POST["codi_grup"];
	$smarty->assign('codigrup_seleccionat', $codi_grup);
}
if ((isset($_POST["Enviar"]) AND ($_POST["Enviar"]=='True'))){
	$Enviar	= true; //ho hem d'enviar
}
// URL de destino

$url =  (($hihacodi_grup) AND
($Enviar))?"informe_resum_credit_di_df_2.php":"";



//recuperem les variables que hem passat mitjançant (fent trampa amb) el mètode
// GET
//$codi_dia = $_GET['codi_dia'];
//$codi_hora = $_GET['codi_hora'];
//$codi_grup = $_GET['codi_grup'];
//$codi_assignatura = $_GET['codi_ass'];
//$data = date('Y-m-d');

//el grup del qual el professor  és tutor
//$codi_grup = $_SESSION['tutor_de'];

//$int_data=date('Y-m-d', $_SESSION['data']);
$smarty->assign('hihacodi_grup', $hihacodi_grup);
$smarty->assign('URL',$url);


$utils = new utils();
$RSRC = array();
$VALS = array();

$VALS['codi_professor'] = $codi_professor;

if($_SESSION['es_coordinador'] != 0)
//si es coordinador mostrem tots els grups
{
	$utils->get_global_resources($RSRC,"db/sql_querys_inc.php",$VALS);
	$utils->p_dbg($RSRC, "Prova log");
	$result_6 = $ConTut->Execute($RSRC['COORDINADOR_MOSTRA_GRUPS'])
	or die($ConTut->ErrorMsg());
}
else
//si no és coordinador mostrem els grups dels quals és tutor o en 
// els que imparteix crèdits.
{
	$utils->get_global_resources($RSRC,"db/sql_querys_inc.php",$VALS);
	$utils->p_dbg($RSRC, "Prova log");
	$result_6 = $ConTut->Execute($RSRC['NO_COORDINADOR_MOSTRA_GRUPS_IMPARTEIX'])
	or die($ConTut->ErrorMsg());

}

$grups = array();
while (list($codi_grup)=$result_6->fields)
{
	if ($hihacodi_grup)
	{

		if($codi_grup == $_POST["codi_grup"])
		{
			$seleccionat = "selected";
		}
		else
		{
			$seleccionat = "";
		}
	}
	else
	{
		$seleccionat = "";
	}
	$grups[$codi_grup]="$codi_grup";
	$result_6->MoveNext(); //següent grup
}
$result_6->Close();

$smarty->assign('grups',$grups);



$credits = array();

$Final_date= date('d-m-Y');
$smarty->assign('Final_date',$Final_date);


if (isset($_POST["codi_grup"])){
	$codi_grup = $_POST["codi_grup"];

	$VALS['codi_professor'] = $codi_professor;
	$VALS['codi_grup'] = $codi_grup;

	if($_SESSION['es_coordinador'] != 0)//si es coordinador mostrem tots els grups
	{//consulta que permet saber els crèdits que imparteix el profe al grup
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$result = $ConTut->Execute($RSRC['COORDINADOR_MOSTRA_CREDIT'])
		or die($ConTut->ErrorMsg());
	}
	
	
	//consulta que permet saber els crèdits que imparteix el profe al grup
	else
	{
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$result = $ConTut->Execute($RSRC['NO_COORDINADOR_MOSTRA_CREDIT'])
		or die($ConTut->ErrorMsg());
	}
	
	
	//si només imparteix un crèdit el mostrem sense més
	if ($result->RecordCount() == 1)
	{
		$codi_assignatura = $result->Fields('codi_assignatura');
		$nom_assignatura = $result->Fields('nom_assignatura');
		$smarty->assign('codi_assignatura',$codi_assignatura);
		$smarty->assign('nom_assignatura',$nom_assignatura);
		$credits[$codi_assignatura]="$codi_assignatura";			
	}
	else
	{
		//si n'imparteix més d'un donem l'opció de triar el que es vol
			
		//muntem el selec i lensenyem
		while (list($codi_assignatura, $nom_assignatura)=$result->fields) 
		{
			$smarty->assign('codi_assignatura',$codi_assignatura);
			$smarty->assign('nom_assignatura',$nom_assignatura);
			$credits[$codi_assignatura]="$codi_assignatura";
			$result->MoveNext(); //següent grup
		}
	}
	$result->Close();
	$smarty->assign('credits',$credits);
	//http://www.anieto2k.com/2008/05/27/combos-dependientes-accesibles-php-jquery/
}
//We load here common foot application.
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
$smarty->display('informe_resum_credit_di_df_1.tpl');
$smarty->display('foot.tpl');


?>