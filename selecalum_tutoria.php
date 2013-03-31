<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Amado Domenech
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
 *
 * $Id:selecalum_tutoria.php 1370 2010-09-17 09:14:47Z irent88 $  
 */
/**
 * Aquest arxiu el que fa es mostrar els alumnes per als quals un prefessor/a es el seu tutor/a
 * i permet controlar les incidencies, en cas de intentar vore les incidencies d'un curs posterior, 
 * et mostrara un missatge de error.
 * @author Amado Domenech Antequera
 * @license GNU
 * @see selecalum_tutoria.php
 */


// Session managment
session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");



$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_ADMIN;
$third_level_url=_SECOND_LEVEL_TUTORSHIP;
$name_of="Administrar";
$name_of2="Tutoria";


//We load here common header application
require_once _INCLUDES.'common-header.php';

/************************************************************/
$utils = new utils();
 
$RSRC = array();
$VALS = array();

/************************************************************/
//Obtain session variables
$teacher_code = $_SESSION['codi_professor'];
$user = $_SESSION['usuari'];
$teacher_name = $_SESSION['nom_professor'];
$teacher_surname = $_SESSION['cognom1_professor'];

/*if ($_SESSION['num_grups_tutor'] == 1){
	$group_code = $_SESSION["tutor_de_1"];
}else{
	$group_code = $_POST['group'];
}*/
$group_code = $_POST['group'];
if(isset($_POST['data'])){
	$int_data = strtotime($_POST['data']);
}else{
	$int_data = time();
}

//comprovem que aquesta data sigui del curs actual (entre 1-9-2008 i 24-6-2009)
$data_incorrecta=false;
if ($int_data < strtotime('01-09-'._ANY_COMENCAMENT_CURS) or $int_data > strtotime('24-06-'._ANY_FINALITZACIO_CURS)){
	$data_incorrecta=true;
	/*print "<p><blink><b>Només es pot passar llista per les dates del curs 08-09";
	print "entre 15-09-2008 i el 24-06-2009.</blink> <p><blink>"*/
	$data=date('d-m-Y',$int_data);
	$smarty->assign('data_incorrecta', $data_incorrecta);
	$smarty->assign('DATA', $data);
	/*print " no és una data vàlida</b></blink>";*/

	$int_data = time();
}

$_SESSION['int_data']=$int_data;

/* remove this comment for weekly tutorship
 //he de calcular la data del dilluns anterior o igual a $data --($data_dl)
 //$n=1 dilluns, $n=2 dimarts, ...
 $n=date("N", $data);
 //Ara hem d'atrassar $n-1 dies
 $data_dilluns = $data - (($n-1) * 24 * 60 * 60);
 //he de calcular la data del divendres posterior o igual a $data --($data_dv)
 $data_divendres = $data_dilluns + (4 * 24 * 60 * 60);
 */

//comment this lines for weekly tutorship
$int_monday_date = $int_data;
$int_friday_date = $int_data;

//Obtain and associative array with day names
$days=array();
//for ($day_code=date("N", $int_monday_date)+1; $day_code <= date("N", $int_friday_date)+1; ++$day_code) {
for ($day_code=date("N", $int_monday_date)+1; $day_code <= date("N", $int_friday_date)+1; ++$day_code) {
	//For every day obtain min_hour and max_hour

	$VALS['day_code'] = $day_code-1;
	$VALS['group_code'] = $group_code;	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	$utils->p_dbg($RSRC, "Prova log");
	$result = $ConTut->Execute($RSRC['CONSULTA_HORAI_HORAF_DUN_GRUP']) or die($ConTut->ErrorMsg());

	if (!$result->EOF){
		$initial_hour_code[$day_code-1] = (int)($result->Fields('min'));
		$final_hour_code[$day_code-1] = (int)($result->Fields('max'));
	}
	$result ->Close();

	$num_hours = $final_hour_code[$day_code-1] - $initial_hour_code[$day_code-1] + 1;

	//remove this line for weekly tutorship
	//$day = $data_dilluns + ($day_code - 2) * 24 * 60 * 60;

	//comment this lines for weekly tutorship
	$day = $int_data;
	
	$days[]=array(	'N_TIME_INTERVALS' => $num_hours,
              	  	'DAY_OF_WEEK' => strftime("%A", $day));
}

$hours=array();
for ($day_code=date("N", $int_monday_date)+1; $day_code <= date("N", $int_friday_date)+1; ++$day_code){
	for($hour_code = $initial_hour_code[$day_code-1]; $hour_code <= $final_hour_code[$day_code-1]; $hour_code++){
		
		
		$VALS['hour_code'] = $hour_code;
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$result_1= $ConTut->Execute($RSRC['CONSULTA_HORAI_HORAF']) or die ($ConTut->ErrorMsg());

		$initial_hour="";
		$final_hour="";
		if (!$result_1->EOF){
			$initial_hour =  $result_1->Fields('hora_inici');
			$final_hour =  $result_1->Fields('hora_final');
		}
		
		$hours[]=array(	'INITIAL_HOUR' => $initial_hour,
              	  	'FINAL_HOUR' => $final_hour);	
		$result_1 ->Close();
	}
}

$hours=array();
for ($day_code=date("N", $int_monday_date)+1; $day_code <= date("N", $int_friday_date)+1; ++$day_code){
	for($hour_code = $initial_hour_code[$day_code-1]; $hour_code <= $final_hour_code[$day_code-1]; $hour_code++){

		$VALS['hour_code'] = $hour_code;
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$result_1= $ConTut->Execute($RSRC['CONSULTA_HORAI_HORAF']) or die ($ConTut->ErrorMsg());

		if (!$result_1->EOF){
			$initial_hour =  $result_1->Fields('hora_inici');
			$final_hour =  $result_1->Fields('hora_final');
		}
		
		$hours[]=array(	'INITIAL_HOUR' => $initial_hour,
              	  	'FINAL_HOUR' => $final_hour);	
		$result_1 ->Close();
	}
}
$j=0;
$k=1;
$students=array();
$students_names=array();
$students_codes=array();
//Obtain students of selected group
$VALS['group_code'] = $group_code;
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$dngrup = cercaGrup($group_code);
		$ldapconfig['host'] = _LDAP_SERVER;
		#Només cal indicar el port si es diferent del port per defecte
		$ldapconfig['port'] = _LDAP_PORT;
		$ldapconfig['basedn'] = $dngrup;
		
		$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		$password=_LDAP_PASSWORD;
		#$dn="cn=admin,".$ldapconfig['basedn'];
		$dn=_LDAP_USER;
		
		
		if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
		
		    //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
		    $filter = "(objectClass=inetOrgPerson)";
		
		    if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
		      echo("Unable to search ldap server<br>");
		      echo("msg:'".ldap_error($ds)."'</br>");#check the message again
		    } else {
		      $number_returned = ldap_count_entries($ds,$search);
		      ldap_sort($ds, $search, "cn"); 
		      $info = ldap_get_entries($ds, $search);
		      $entry = ldap_first_entry($ds, $search);
		      for ($i=0; $i<$info["count"];$i++) {
		      			$students[]=$k;
						$students_names[$i]=$info[$j]['cn'][0];
						$students_codes[$i]=$info[$j][_LDAP_USER_ID][0];
											$jpeg_data = ldap_get_values_len($ds, $entry, "jpegphoto");
					//print_r($jpeg_data);
					/*$photo_filename="/tmp/".$students_codes[$i].".png";
					$outphoto = fopen ($photo_filename,"wb");*/
					$jpeg_filename="/tmp/".$students_codes[$i].".png";
					$jpeg_file[$i]=$students_codes[$i].".png";
			  		 for( $l=0; $l<$jpeg_data['count']; $l++ ) {
						$outjpeg = fopen($jpeg_filename, "wb");
						fwrite($outjpeg, $jpeg_data[$l]);
						fclose ($outjpeg);
						$jpeg_data_size = filesize( $jpeg_filename );
						if( $jpeg_data_size < 6 ) {
						echo "jpegPhoto contains errors<br />";
						echo '<a href="javascript:deleteJpegPhoto();" style="color:red; font-size: 75%">Delete Photo</a>';
						continue;
						}
			   		 }
					
					
					/*fwrite($outphoto,filesize($jpeg_data[0]));
					fclose ($outphoto);*/
					
					$j=$j+1;
					$entry = ldap_next_entry($ds, $entry);	
		       }
		    }
		    
		  } else {
		    echo("Unable to bind anonymously<br>");
		    echo("msg:".ldap_error($ds)."<br>");
		  }
		} else {
		
		  echo("Unable to bind to server.</br>");
		
		  echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
		  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
		  #we can figure out the right pattern by searching the user tree
		  #remember to turn on the anonymous search on the ldap server
		  
		}
		// Usuari i contrasenya vàlids (Control seguretat 1)
		ldap_close($ds);
//$result_2 = $ConTut->Execute($RSRC['MOSTRAR_ALUMNES_GRUP']) or die($ConTut->ErrorMsg());
$day_code=date("N", $int_data)+1;
$int_data_inc=date("Y-m-d", $int_data);

$k=1;

$results1=array();
for($l=0;$l<$number_returned;$l++) {
	$results=array();
	for ($day_code=date("N", $int_monday_date)+1; $day_code <= date("N", $int_friday_date)+1; ++$day_code){
		for($hour_code = $initial_hour_code[$day_code-1]; $hour_code <= $final_hour_code[$day_code-1]; $hour_code++){
			$sc=$students_codes[$l];
			$tc=$_SESSION['S_codi_prof'];
			$day_code2= $day_code-1;
			$VALS['day_code']=$day_code2;
			$VALS['hour_code']=$hour_code;
			$VALS['student_code']=$sc;
			$VALS['int_data_inc']=$int_data_inc;
			$VALS['teacher_code']=$tc;	
			$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
			$utils->p_dbg($RSRC, "Prova log");
			$result_3 = $ConTut->Execute($RSRC['CONSULTA_INCIDENCIA_SELECALUM_TUTORIA']) or die($ConTut->ErrorMsg());
			$incident_code="";
			$subject_code="";
			$reason_incident="";
			if (!$result_3->EOF){
				$incident_code  = $result_3->Fields('codi_incidencia');
				$subject_code = $result_3->Fields('codi_assignatura');
				$reason_incident = $result_3->Fields('motiu_incidencia');
				$result_3->Close();
			}
						
			settype($reason_incident, "integer");
			for ($i=0;$i<=5;$i++) {
				$selected[$i]="";
			}
			if ($reason_incident=='') {
				$i=0;
			}else {
				$i = $reason_incident;
			}
			$tc=$_SESSION['S_codi_prof'];
			$VALS['day_code']=$day_code-1;
			$VALS['hour_code']=$hour_code;
			$VALS['teacher_code']=$teacher_code;
			$VALS['codi_grup']=$group_code;	
			$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
			$utils->p_dbg($RSRC, "Prova log");
			$result_4 = $ConTut->Execute($RSRC['CONSULTA_ASSIGNATURA_ALUMNE_SENSE_INC']) or die($ConTut->ErrorMsg());
			if (!$result_4->EOF){
				$subject_code = $result_4->Fields('codi_assignatura');
				$result_4->Close();
			}
			if($subject_code==""){
				$subject_code="Tutoria";
			}
			$selected[$i] = "selected";
			$url1 =  "insereix_inc.php?codi_incidencia=".$incident_code;
			$url1 .= "&codi_alumne=".$students_codes[$l];
			$url1 .= "&codi_dia=".$day_code2;
			$url1 .= "&codi_hora=".$hour_code;
			$url1 .= "&codi_assignatura=".$subject_code;
			$url1 .= "&data_incidencia=".$int_data_inc;
			$url1 .= "&motiu_incidencia=";
			//Here we insert --> this.value
			$url2 = "&justificant=";
			if (isset($justificant)) {
				$url2 .= $justificant;
			} else {
				$url2 .= "";
			}
			$url2 .= "&observacions=";
			if (isset($observacions)) {
				$url2 .= $observacions;
			} else {
				$url2 .= "";
			}
			$url2 .= "&nom_professor=".$teacher_name;
			$url2 .= "&cognom1_professor=".$teacher_surname;
			$url2 .= "&codi_professor=".$teacher_code;
			
			$results[]=array(	'url1' => $url1,
                     			'url2' => $url2,
	                 			'selected' => $selected);
		}
	}
	                 	
	$results1[]=$results;	
	//$result_2->MoveNext(); //següent alumne
}

$smarty->assign('ACTION1_URL',$_SERVER['PHP_SELF']);
$smarty->assign('GROUP_CODE', $group_code);
$smarty->assign('N_GROUP_STUDENTS',$number_returned);
//$result_2->close();//següent alumne
$smarty->assign('ACTION2_URL',"selecgroup.php?form_action=selecalum_tutoria.php");
$smarty->assign('SELECTED_DATE',strftime("%A, %d de %B de %Y", $int_friday_date));
$smarty->assign('N_TIME_INTERVALS', $num_hours);
$smarty->assign('DAY_OF_WEEK',strftime("%A", $day));

$smarty->assign('days',$days);

$smarty->assign('hours',$hours);

//Impresio dels vector que contenen els alumnes i els seus codis 
//NOTA: Nomes descomentar per a debugar)
//echo "<br/>";
//echo "students_names:".print_r($students_names)."<br><br/>";
//echo "students_codes:".print_r($students_codes)."<br><br/>";


$smarty->assign('students',$students);
$smarty->assign('any_curs_c',_ANY_COMENCAMENT_CURS);
$smarty->assign('any_curs_f',_ANY_FINALITZACIO_CURS);
$smarty->assign('students_names',$students_names);
$smarty->assign('students_codes',$students_codes);
$smarty->assign('students_JpegPhoto',$jpeg_file);
$smarty->assign('results1',$results1);

$smarty->display('selecalum_tutoria.tpl');

//We load here common foot application
$smarty->display('foot.tpl');
?>