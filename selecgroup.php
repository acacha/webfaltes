<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Año
 * Coautors:  Carlos Cristoful Rodriguez
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

/*---------------------------------------------------------------
 * Webfaltes   Fitxer: selecgroup_informe.php
 * Autor: Sergi Tur   Data: 22/10/2009
 * Description: Let's user select a group
 * Pre condi.:
 * Post cond.:
 ----------------------------------------------------------------*/

// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i 
// funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_ADMIN;
$third_level_url=_SECOND_LEVEL_TUTORSHIP;
$name_of="Administrar";
$name_of2="Tutoria";


//Recuperem variables de sessió i les simplifiquem per a més comoditat
$codi_professor = $_SESSION['codi_professor'];


//We load here common header application
require_once _INCLUDES.'common-header.php';

/*
 * selecgroup template variables
 * Variables
 *  @ FORM_ACTION			Action paramater of html
 *  @ FORM_TITLE           Form Title
 *  @ $butonTitle			Form button title
 *
 */

$action_form = 
	(isset($_GET['form_action']))? $_GET['form_action'] : _DEFAULT_ACTION_FORM;
$smarty->assign('FORM_ACTION',$action_form);
$smarty->assign('FORM_TITLE',T_('Select group:'));


if($_SESSION['es_coordinador'] != 0){
	
	$utils = new utils();//declarem l'objecte utils de la classe utils
	$RSRC = array();
	$VALS = array();

	/*$sql  = "SELECT codi_grup";
	$sql .= " FROM grup";
	$sql .= " WHERE nivell_educatiu = 'ESO' OR nivell_educatiu = 'Inform' ";
	$sql .= "OR nivell_educatiu= 'BA' OR nivell_educatiu= 'promo' OR
	nivell_educatiu= 'AC'";
	$sql .= " ORDER BY nivell_educatiu, codi_grup"; */

	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");
 	$result = $ConTut->Execute($RSRC['sql_selec_coordinador']) 
 	or die($ConTut->ErrorMsg());

	
	$groups = array();
	while (list($codi_grup)=$result->fields) {
		$groups[$codi_grup]="$codi_grup";
		$result->MoveNext(); //next group
	}
} else {
	
	$utils = new utils();//declarem l'objecte utils de la classe utils
	$RSRC = array();
	$VALS = array();
	
	/*
	$sql  = "SELECT codi_grup";
	$sql .= " FROM grup";
	$sql .= " WHERE tutor='$codi_professor'";
	*/

	$VALS['codi_professor'] = $codi_professor;
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");


 	$result_2= $ConTut->Execute($RSRC['sql_selec_tutor']) or 
 	die($ConTut->ErrorMsg());
	echo $RSRC['sql_selec_tutor'];
 	/*$result_2= $ConTut->Execute($RSRC['sql_selec_tutor']) or 
 	die($ConTut->ErrorMsg());*/


	$groups = array();
	while (list($codi_grup)=$result_2->fields) {
		$groups[$codi_grup]="$codi_grup";
		$result_2->MoveNext(); //next group
	}
	$result_2->Close();
}
//print_r($groups);
$smarty->assign('myGroups',$groups);
$smarty->assign('butonTitle',T_('Accept'));
$smarty->display('selecgroup.tpl');

//We load here common foot application
$smarty->display('foot.tpl');
?>