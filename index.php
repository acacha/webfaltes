<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Alfred Monllaó Calvet 
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
 * $Id:index.php 1350 2010-09-08 06:39:48Z irent88 $
 */

/**
 * Webfaltes
 * @author Carles Añó, Sergi Tur Badenas, Alfred Monllaó Calvet
 * @desc Pàgina inicial de l'aplicatiu
 */

// Session managment
session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");

/* Check if we need to run setup */
//echo _CONFIG_DIR."/"._CONFIG_FILE;

if (!file_exists(_CONFIG_DIR."/"._CONFIG_FILE)) {
    header("location:setup.php");
    exit();
}



/* Set header */
header("Content-type: text/html; charset=UTF-8");

$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;

//We load here common header application
require_once _INCLUDES.'common-header.php';

//include("breadcrumbs.php");
$utils = new utils();

$RSRC = array();
$VALS = array();



//variables
$teacher_code = $_SESSION['codi_professor'];


//això hauria de ser una funció/////////////////////////
//anem a veure si aquest professor és tutor d'algun grup

$VALS['teacher_code'] = $teacher_code;

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");

$result_4 = $ConTut->Execute($RSRC['CONSULTA_COMPROVA_TUTOR']) or die($ConTut->ErrorMsg());
/*
 $nombre_grups = 0;
 while (list($codi_grup)=$result->fields) {
 ++$nombre_grups;
 //montem l'array associatiu $TUTOR, amb els camps :
 $TUTOR['nombre_grups'] per guardar de quants grups �s tutor el professor
 $TUTOR['1'] codi del primer grup que és tutor
 $TUTOR['2'] codi del segon grup que és tutor
 etc...

 $TUTOR['nombre_grups']=$nombre_grups;
 $TUTOR['$nombre_grups']=$codi_grup;

 */
$n = 0; //número de grups dels quals el professor és tutor

if (!$result_4->EOF){
	//$codi_grup =  $result_4->Fields('codi_grup');


	while (list($codi_grup)=$result_4->fields) {
		++$n;
		$_SESSION["tutor_de_$n"] = $codi_grup;
		$result_4->MoveNext(); //següent grup
	}
}
else {
	$codi_grup = 0;
}

$result_4 ->Close();

$_SESSION['
'] = $n;


/*
 for ($i=0; $i<=$n;$i++){
 print "Tutor de ".$_SESSION["tutor_de_$i"]."<p>";
 }
 */


//hem de veure si el professor que ha fet login és un coordinador

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");

$result_5 = $ConTut->Execute($RSRC['CONSULTA_COMPROVA_COORDINADOR']) or die($ConTut->ErrorMsg());

if (!$result_5->EOF){
	$es_coordinador =  $result_5->Fields('es_coordinador');
}
else {
	$es_coordinador = 0;
}

$result_5 ->Close();

//Guardem el grup en una variable de sessió
$_SESSION['es_coordinador'] = $es_coordinador;

/*
 *
 * index1.tpl template variables
 * @ variable  aaa
 */

//Obtain date. Default date is today,but users can change the date
if(isset($_GET['str_data'])){
	//print "data_GET=".$_GET['str_data']."<p>";
	$int_date = strtotime($_GET['str_data']);
	//$_GET['data']="";
}elseif(isset($_SESSION['int_data']) and $_SESSION['int_data'] != ""){
	//print "data_SESSION=".$_SESSION['int_data']."<p><br>";
	$int_date = $_SESSION['int_data'];
	//print '$data='.$int_date."<p>";
	//$_GET['data']="";
}
else{
	$int_date = time();
	//print "data_AVUI=".$int_date."<p>";
}

//comprovem que aquesta data sigui del curs actual (entre 1-9-2008 i 24-6-2009)
if ($int_date < strtotime('01-09-'._ANY_COMENCAMENT_CURS) or $int_date > strtotime('24-06-'._ANY_FINALITZACIO_CURS)){
	print "<p><blink><b>Només es pot passar llista per les dates del curs "._ANY_COMENCAMENT_CURS."-"._ANY_FINALITZACIO_CURS." entre 01-09-"._ANY_COMENCAMENT_CURS." i el 24-06-"._ANY_FINALITZACIO_CURS.".</blink> <p><blink>".date('d-m-Y',$int_date)." no és una data vàlida</b></blink>";
	$int_date = time();
}

$_SESSION['int_data']=$int_date;

$smarty->assign('TODAY', date('d-m-Y'));
$smarty->assign('SELECTED_DAY',date('d-m-Y',$int_date));
$smarty->assign('ACTION_URL',$_SERVER['PHP_SELF']);

//Obtain day of week in mysql style: 2->Monday, 3->Thurday... (obsolet)
//$day_of_week = date('N', $int_date) % 7 + 1;

//Obtain day of week in untis style: 1->Monday, 2->Thurday...
$day_of_week = date('N', $int_date) % 7;
//Consulta de selecció de les assignatures d'avui corresponents al professor que ha iniciat la sessi�

$VALS['day_of_week'] = $day_of_week;

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");

// Execució de la consulta. Si hi ha error, es mostra missatge
$result = $ConTut->Execute($RSRC['CONSULTA_SELECT_ASSIGN_AVUI_PROF']) or die($ConTut->ErrorMsg());


$results=array();
while (list($subject_name,$group_name,$codi_grup,$day_code,$hour_code,
            $subject_code, $init_hour, $finish_hour, $optativa)=$result->fields) {
            	
    $time_interval = $init_hour." - ".$finish_hour;
    $url  = "selecalum.php"."?".session_name()."=".session_id();
    $url .= "&codi_dia=".$day_code."&codi_hora=".$hour_code;
    $url .= "&codi_grup=".$codi_grup."&codi_ass=".$subject_code;
    $url .= "&time_interval=".$time_interval;
	$url .= "&optativa=".$optativa;
    
    $subject_name = $subject_name;
  
    $results[]=array('time_interval' => $time_interval,
                     'url' => $url,
                     'group_name' => $group_name,
                     'subject_name' => utf8_encode($subject_name));
	$result->MoveNext();
}

$smarty->assign('results', $results );

$smarty->display('index1.tpl');

//We load here common foot application
$smarty->display('foot.tpl');
?>

