<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Miquel Àngel Sebastià López
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
 * $Id: selecalum.php 826 2010-05-24 22:02:21Z joseprmz $
 */

/**
 * @author Carles Añó, Miquel Àngel Sebastià López
 * @name selecalum.php
 * @desc Check Attendance
 */


// Session managment
session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");

//We load here common header application
require_once _INCLUDES.'common-header.php';

$utils = new utils();

$RSRC = array();
$VALS = array();

//Obtain session variables
$teacher_code = $_SESSION['codi_professor'];
$teacher_name = $_SESSION['nom_professor'];
$teacher_surname = $_SESSION['cognom1_professor'];

$group_code = $_GET['codi_grup'];
$assignatura= $_GET['codi_ass'];
$roles = $_SESSION['roles'];
$optativa = $_GET['optativa'];


echo $roles;

$role_sms=0;
$role_mail=0;

$aux=split(",",$roles);


      for($i=0;$i<count($aux);$i++)
      {
      	if($aux[$i]=="SMS")
		{
			$role_sms=1;
		}
		if($aux[$i]=="MAIL")
		{
			$role_mail=1;
		}
      }


$j=0;
$a=0;
$k=1;
$cont=0;
$students=array();
$students_names=array();
$students_codes=array();
$students_jpegPhoto=array();
$students_dni=array();

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
		
if($optativa==0){	
if ($bind=ldap_bind($ds, $dn, $password)) {
	if ($bind=ldap_bind($ds)) {
		
		$filter = "(objectClass=inetOrgPerson)";
		
//		echo "<br/>basedn: ". $ldapconfig['basedn'] ."<br/><br/>";		
//		echo "filter: $filter </br><br/>";
		
		if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
		    echo("Unable to search ldap server<br>");
		    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
		} else {
		    
		    ldap_sort($ds, $search, "sn"); 
		    $info = ldap_get_entries($ds, $search);
		    $entry = ldap_first_entry($ds, $search);
			
			// consulta per mostrar els alumnes afegits 
				$VALS['codi_assignatura']= $assignatura;
				$VALS['codi_grup']= $group_code;
				$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
				$utils->p_dbg($RSRC, "Prova log");
				$afegir_alum = $ConTut->Execute($RSRC['COMPROVAR_LLISTAT_AFEGITS_LDAP']) or die($ConTut->ErrorMsg());
				
				foreach($afegir_alum as $row){
				$afegir_alumne[$cont]['codi_alumne']=$row['codi_alumne'];
				$afegir_alumne[$cont]['nom']=$row['nom'];
				$afegir_alumne[$cont]['sn1']=$row['sn1'];
				$afegir_alumne[$cont]['sn2']=$row['sn2'];
				$afegir_alumne[$cont]['dni']=$row['dni'];
				$cont++;
				}
				
				$counter=$info["count"] + $cont;
				$number_returned = ldap_count_entries($ds,$search) + $cont;
			
			for ($i=0; $i<$counter;$i++) {
				
				if($afegir_alumne[$a]['sn1'] < $info[$j]['sn1'][0] && $afegir_alumne[$a]['sn2'] < $info[$j]['sn2'][0] && $a<$cont){
				//echo $afegir_alumne[$a]['sn1']."---".$info[$j]['sn1'][0]."<br>";

/*************************************************************************************************************************************************/
/* 				si usuari mysql es mes petit que usuari ldap, mostral per pantalla 
/*              consulta per comporvar si esta ocult
/*************************************************************************************************************************************************/
				// comprovem que l'usuari no estigue ocult		
				
				
				// comprovem que l'usuari no estigue ocult		
				
				$VALS['codi_alumne']= $afegir_alumne[$a]['codi_alumne'];
				$VALS['codi_assignatura']= $assignatura;
				$VALS['codi_grup']= $group_code;
				$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
				$utils->p_dbg($RSRC, "Prova log");
				$result = $ConTut->Execute($RSRC['COMPROVAR_OCULT_ALUMNE']) or die($ConTut->ErrorMsg());
				
				$ocultar[$i]="false";
				foreach ($result as $row){
					if($row['codi_alumne']== $afegir_alumne[$a]['codi_alumne']){
					$ocultar[$i]="true";	
					}
				}
				
				$students[]=$k;
				$students_names[$i]=$afegir_alumne[$a]['sn1']." ".$afegir_alumne[$a]['sn2'].", ".$afegir_alumne[$a]['nom'];
				$students_codes[$i]=$afegir_alumne[$a]['codi_alumne'];
				$students_nom[$i]=$afegir_alumne[$a]['nom'];
				$students_sn1[$i]=$afegir_alumne[$a]['sn1'];
				$students_sn2[$i]=$afegir_alumne[$a]['sn2'];
				$students_dni[$i]=$afegir_alumne[$a]['dni'];
				
				$jpeg_data = ldap_get_values_len($ds, $entry, "jpegphoto");
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
				
				$a++;		
				/*************************************************************************************************************************************************/
/* 				
/*************************************************************************************************************************************************/
				}else{
				
				// comprovem que l'usuari no estigue ocult		
				$VALS['codi_alumne']= $info[$j][_LDAP_USER_ID][0];
				$VALS['codi_assignatura']= $assignatura;
				$VALS['codi_grup']= $group_code;
				$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
				$utils->p_dbg($RSRC, "Prova log");
				$result = $ConTut->Execute($RSRC['COMPROVAR_OCULT_ALUMNE']) or die($ConTut->ErrorMsg());
				
				$ocultar[$i]="false";
				foreach ($result as $row){
					if($row['codi_alumne']==$info[$j][_LDAP_USER_ID][0]){
					$ocultar[$i]="true";	
					}
				}
				
					
				$students[]=$k;
				
				$students_names[$i]=$info[$j]['sn1'][0]." ".$info[$j]['sn2'][0].", ".$info[$j]['givenname'][0];
				$students_codes[$i]=$info[$j][_LDAP_USER_ID][0];
				$students_nom[$i]=$info[$j]['sn1'][0];
				$students_sn1[$i]=$info[$j]['sn1'][0];
				$students_sn2[$i]=$info[$j]['sn2'][0];
				$students_dni[$i]=$info[$j]['irispersonaluniqueid'][0];
				$jpeg_data = ldap_get_values_len($ds, $entry, "jpegphoto");
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
				$j=$j+1;
				$entry = ldap_next_entry($ds, $entry);
				
			  }
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

}else{
/*************************************************************************************************************************************************/
/* 				                               aqui tractem les OPTATIVES 
/*************************************************************************************************************************************************/
$contador=0;
$VALS['codi_assignatura']=$assignatura;	
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result_1 = $ConTut->Execute($RSRC['CONSULTA_ALUMNES_PER_GRUP']) or die($ConTut->ErrorMsg());


foreach($result_1 as $row){
$students[]=$k;
$students_names[$contador]=$row['nom'];
$students_codes[$contador]=$row['codi_alumne'];
$ocultar[$contador]='false';
if ($bind=ldap_bind($ds, $dn, $password)) {
} else {
	# Error
}
			// comprovem si ocultem l'usuari o no
			$VALS['codi_alumne']= $row['codi_alumne'];
			$VALS['codi_assignatura']= $assignatura;
			$VALS['codi_grup']= $group_code;
			$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
			$utils->p_dbg($RSRC, "Prova log");
			$result = $ConTut->Execute($RSRC['COMPROVAR_OCULT_ALUMNE']) or die($ConTut->ErrorMsg());
			
			$ocultar[$i]="false";
			foreach ($result as $row){
				if($row['codi_alumne']== $row['codi_alumne']){
				$ocultar[$i]="true";	
				}
			}


$search = ldap_search($ds,"ou=Alumnes,ou=All,dc=iesebre,dc=com", "employeeNumber=".$row['codi_alumne']) or die ("Search failed");
$info = ldap_get_entries($ds, $search);	

$jpeg_filename="/tmp/".$students_codes[$contador].".png";
$jpeg_file[$contador]=$students_codes[$contador].".png";
$contador++;
}
$outjpeg = fopen($jpeg_filename, "wb");
fwrite($outjpeg, $info[0]['jpegphoto'][0]);
fclose ($outjpeg);
$jpeg_data_size = filesize( $jpeg_filename );
$number_returned=$contador;

}

		// Usuari i contrasenya vàlids (Control seguretat 1)
ldap_close($ds);


/******************************************************************************************************
*                                  variables
*******************************************************************************************************/

	$day_code = $_GET['codi_dia'];
	$hour_code = $_GET['codi_hora'];

	if(isset($_GET['codi_hora'])){
	$hour_code=$_GET['codi_hora'];
	$_SESSION['codi_hora']=$hour_code;
	}else{
	$hour_code=$_SESSION['codi_hora'];
	}
$group_code = $_GET['codi_grup'];
$subject_code = $_GET['codi_ass'];
$time_interval= $_GET['time_interval'];

$date=date('Y-m-d', $_SESSION['int_data']);

$date1=date('d-m-Y', $_SESSION['int_data']);

$subject_code_backup = $_GET['codi_ass'];


$ho=explode(" ",$time_interval);
$hora_ini=$ho[0];


/******************************************************************************************************
*                                  detectar horari mati o tarde
*******************************************************************************************************/

$VALS['codi_assignatura']= $assignatura;
$VALS['codi_grup']= $group_code;
$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result_hora = $ConTut->Execute($RSRC['COMPROVAR_HORA']) or die($ConTut->ErrorMsg());


$utils->get_global_resources($RSRC, "db/sql_query.php");
$utils->p_dbg($RSRC, "Prova log");
$interval_horari = $ConTut->Execute($RSRC['INTERVAL_HORARI']) or die($ConTut->ErrorMsg());
$interval= $interval_horari->GetArray();


if($hour_code < 7){
	for($i=0; $i<6; $i++){
	$hours[$i]['codi_hora']=$interval[$i]['codi_hora'];
	$hours[$i]['hora_inici']=$interval[$i]['hora_inici'];
	$hours[$i]['hora_final']=$interval[$i]['hora_final'];
	
	}
}else{
	for($i=0; $i<6; $i++){
	$hours[$i]['codi_hora']=$interval[$i+6]['codi_hora'];
	$hours[$i]['hora_inici']=$interval[$i+6]['hora_inici'];
	$hours[$i]['hora_final']=$interval[$i+6]['hora_final'];
	}	
	
}





/******************************************************************************************************
*                          
*******************************************************************************************************/

	$VALS['int_data_inc'] = $date;
	$VALS['day_code'] = $day_code;
	$VALS['student_code'] = $students_codes;

	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	$utils->p_dbg($RSRC, "Prova log");
	// Execució de la consulta. Si hi ha error, es mostra missatge
	$result = $ConTut->Execute($RSRC['consulta_incidencia3']) or die($ConTut->ErrorMsg());
	$z=0;
	foreach($result as $row){
		$result_inci[$z]['hora_inici']=$row['hora_inici'];
		$result_inci[$z]['codi_hora']=$row['codi_hora'];
		$result_inci[$z]['motiu_curt']=$row['motiu_curt'];
		$result_inci[$z]['codi_alumne']=$row['codi_alumne'];
		$result_inci[$z]['motiu_incidencia']=$row['motiu_incidencia'];
	$z++;
	}


$results=array();
$k=1;
for($l=0;$l<$number_returned;$l++) {

   	$sc=$students_codes[$l];
	$tc=$_SESSION['S_codi_prof'];
	$VALS['group_code'] = $group_code;
	$VALS['int_data_inc'] = $date;
	$VALS['hour_code'] = $hour_code;
	$VALS['day_code'] = $day_code;
	$VALS['subject_code'] = $subject_code;
	$VALS['teacher_code'] = $tc;
	$VALS['student_code']=$sc;
	


	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	$utils->p_dbg($RSRC, "Prova log");
	// Execució de la consulta. Si hi ha error, es mostra missatge
	$result = $ConTut->Execute($RSRC['consulta_incidencia2']) or die($ConTut->ErrorMsg());
	$z=0;
	foreach($result as $row){
		$selected[$row['codi_alumne']][$row['hora_inici']][$row['motiu_incidencia']]="selected";
	$z++;
	}
	
	
	$url1 =  "insereix_inc.php?codi_incidencia=".$incident_code;
	$url1 .= "&codi_alumne=".$students_codes[$l];
	$url1 .= "&codi_dia=".$day_code;
	/*$url1 .= "&codi_hora=".$hour_code;*/
	$url1 .= "&codi_assignatura=".$subject_code;
	$url1 .= "&data_incidencia=".$date;
	$url1 .= "&motiu_incidencia=";
	
	$url6.="&codi_hora=";

	$url2 .= "&nom_professor=".$teacher_name;
	$url2 .= "&cognom1_professor=". $teacher_surname;
	$url2 .= "&codi_professor=". $teacher_code;
	
	$url2 .= "&observacions=";


	$url3 = "insereix_est.php?estat=";
	
	$url4 = "&codi_alumne=".$students_codes[$l];
	$url4 .= "&codi_assignatura=".$subject_code;
	
/*
	$url3 = "insereix_est.php?estat=";
	$url4 = "&codi_assignatura=".$subject_code;
	$url4 .="&codi_alumne=".$students_codes[$l]; */
	
	
	if($optativa==0){
	$url5 =  "ocultar_alumne.php?codi_alumne=".$students_codes[$l];
	$url5 .= "&codi_assignatura=".$subject_code;
	$url5 .= "&codi_grup=".$group_code;
	$url5 .= "&nom=".$students_dni[$l];
	$url5 .= "&sn1=".$students_sn1[$l];
	$url5 .= "&sn2=".$students_sn2[$l];
	$url5 .= "&dni=".$students_dni[$l];
	}else{
	
	$ldapconfig['host'] = _LDAP_SERVER;
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = _LDAP_USER;
	
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	$password=_LDAP_PASSWORD;
	$dn=_LDAP_USER;
	if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
		$search=@ldap_search($ds, $ldapconfig['basedn'],'employeenumber='.$students_codes[$l]);
		$info = ldap_get_entries($ds, $search);
		$url5 =  "ocultar_alumne.php?codi_alumne=".$info[0]['employeenumber'][0];
		$url5 .= "&codi_assignatura=".$subject_code;
		$url5 .= "&codi_grup=".$group_code;
		$url5 .= "&nom=".$info[0]['givenname'][0];
		$url5 .= "&sn1=".$info[0]['sn1'][0];
		$url5 .= "&sn2=".$info[0]['sn2'][0];
		$url5 .= "&dni=".$info[0]['irispersonaluniqueid'][0];
	
		}
	}
	
	}
	
	
	
	
	$results[]=array(
					 'url1' => $url1,
                     'url2' => $url2,
					 'url6' => $url6,
					 'url3' => $url3,
					 'url4' => $url4,
					 'url5' => $url5,
	                 'selected' => $selected,
	                 'i' => $k,
					 'ocultar' => $ocultar[$l],
                     'student_name' => $students_names[$l],
	                 'student_code' => $students_codes[$l],
					 'student_jpegPhotoName' => $jpeg_file[$l],
					 'url3' => $url3,
					 'url4' => $url4);

					
//	$results2[]=array('url1' => $url1,
//                     'url2' => $url2,
//	                 'selected' => $selected,
//	                 'i' => $k,
//                    'student_name' => $students_names[$l],
//	                 'student_code' => $students_codes[$l],
//					 'student_jpegPhotoName' => $jpeg_file[$l]);
//'url1_mail' => $url1_mail,
//'pares_a_notificar' => $pares_a_notificar,
//'selected_mail' => $selected_mail,	
	$k++;
	//$h++;
    $result->MoveNext();
}





$VALS['codi_grup']=$group_code;	
$VALS['codi_assignatura']=$assignatura;
	
$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result_ldap = $ConTut->Execute($RSRC['COMPROVAR_LLISTAT_AFEGITS_LDAP']) or die($ConTut->ErrorMsg());

//Form returns to main page

//Impresio dels vector que contenen els alumnes i els seus codis 
//NOTA: Nomes descomentar per a debugar)
//print_r($students_names);
//print_r($students_codes);
// consulta en la base de dades per mostrar incidencies anteriors del dia! 
$VALS['data']=$date;	
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$incidencies = $ConTut->Execute($RSRC['CONSULTA_INCIDENCIES_ANT']) or die($ConTut->ErrorMsg());

$observacions="";
foreach ($incidencies as $row){
	if(isset($observacions[$row[codi_alumne]])){
	if(!isset($row[observacions]) || $row[observacions]!=""){	
	$observacions[$row[codi_alumne]]=$observacions[$row[codi_alumne]]." / ".$row[hora_inici]."-".$row[observacions];
	}
	}else{
		if(!isset($row[observacions]) || $row[observacions]!=""){	
	$observacions[$row[codi_alumne]]=$row[hora_inici]." - ".$row[observacions];
		}
	}
}




//consulta per tindre les assignatures
$VALS['teacher_code']=$_SESSION['codi_professor'];
$VALS['day_of_week']=$day_code;

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$control_assig = $ConTut->Execute($RSRC['CONSULTA_SELECT_ASSIGN_AVUI_PROF']) or die($ConTut->ErrorMsg());



$VALS['teacher_code']=$_SESSION['codi_professor'];
$VALS['day_of_week']=$day_code;
$VALS['codi_assignatura']=$assignatura;

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$count_ass = $ConTut->Execute($RSRC['CONSULTA_SELECT_ASSIGN_AVUI_PROF_ASS']) or die($ConTut->ErrorMsg());


/*
*  consulta per cercar el grup
*/
$RSRC = array();
$VALS = array();

$utils->get_global_resources($RSRC, "db/sql_query.php");
$utils->p_dbg($RSRC, "Prova log");
$result_grup = $ConTut->Execute($RSRC['consulta_grup']) or die($ConTut->ErrorMsg());

$url6 =  "controlador1.php?nom=pepito";

$smarty->assign('url6',$url6);
$smarty->assign('grup_act',$group_code);
$smarty->assign('ass_act',$assignatura);
$smarty->assign('observacions',$observacions);
$smarty->assign('incidencies',$incidencies);
$smarty->assign('result_grup',$result_grup);

$smarty->assign('ACTION_URL','index.php');

$smarty->assign('ASSIGNATURA',$assignatura);
$smarty->assign('OPTATIVA',$optativa);
$smarty->assign('GROUP_CODE',$group_code);
$smarty->assign('SUBJECT',$subject_code_backup);
$smarty->assign('N_GROUP_STUDENTS',$number_returned);
$smarty->assign('result_ldap',$result_ldap);
$eliminar="true";
$smarty->assign('eliminar',$eliminar);
$smarty->assign('hores',$hours);
$smarty->assign('result_inci',$result_inci);
$smarty->assign('control_assig',$control_assig);
$smarty->assign('count_ass',$count_ass);
$smarty->assign('valor',$valor);




$smarty->assign('SELECTED_DATE',$date1);
$smarty->assign('SELECTED_TIME_INTERVAL',$time_interval);
$arr = array(8,9,10,11,12,13);
$smarty->assign('custid', $arr);
$smarty->assign('results', $results );





//$smarty->assign('role_sms', $role_sms );
//$smarty->assign('role_mail', $role_mail );

$smarty->display('selecalumn.tpl');

//We load here common foot application
$smarty->display('foot.tpl');
?>
