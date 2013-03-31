<?php
 /*
  * webfaltes - https://sourceforge.net/projects/webfaltes/
  * Copyright (c) 2010, Sergi Tur Badenas ,Carles Añó
  * Coautors: Ivan Gomez Romero
  *
  * This library is free software you can redistribute it and/or modify it under
  * the terms of the GNU Lesser General Public License as published by the Free
  * Software Foundation; either version 2.1 of the License, or (at your option)
  * any later version.
  * 
  * This library is distributed in the hope that it will be useful, but WITHOUT
  * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
  * FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
  * for more details.
  * 
  * 
  * You should have received a copy of the GNU Lesser General Public License
  * along with this library; if not, write to the Free Software Foundation,Inc.,
  * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
  * http://www.fsf.org/licensing/licenses/lgpl.txt
  *
  *$Id:informe_centre_d_h_2.php 1397 2010-09-21 07:48:11Z irent88 $
  */ 
/*---------------------------------------------------------------
* Aplicatiu d'incidencies   Fitxer: informe_centre_d_h_1.php
* Autor: Carles Año   Data:
* Descripció: Informe resum d'incidéncies del centre un dia determinat a una 
* hora determinada. Selecció del dia i la hora i els tipus d'incidencies
* Pre condi.:
* Post cond.:
----------------------------------------------------------------*/



// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració 
//i funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$utils = new utils();
 
$RSRC = array();
$VALS = array();

$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_CENTRE_D_H_1;
$name_of="Escollir informe";
$name_of2="Incidències del centre del dia d a l'hora h";

//We load here common header application
require_once _INCLUDES.'common-header.php';


//recoollim les variables passades pel formulari 
$str_data_informe = date('Y-m-d', strtotime($_POST['data_informe']));
$separador = "";
$motius_informe = "(";
if(isset($_POST['f']) AND $_POST['f'] <>""){
	$motius_informe .= $_POST['f'];
	$separador = ",";
	}
if(isset($_POST['fj']) AND $_POST['fj'] <>""){
	$motius_informe .= $separador.$_POST['fj'];
	$separador = ",";
	}
if(isset($_POST['r']) AND $_POST['r'] <>""){
	$motius_informe .= $separador.$_POST['r'];
	$separador = ",";
}
if(isset($_POST['rj']) AND $_POST['rj'] <>""){
	$motius_informe .= $separador.$_POST['rj'];
	$separador = ",";
}
if(isset($_POST['e']) AND $_POST['e'] <>""){
	$motius_informe .= $separador.$_POST['e'];
	
	}
	$motius_informe .= ")";

	
	
$separador = "";
$motius_informe2 = "";
if(isset($_POST['f']) AND $_POST['f'] <>""){
	$motius_informe2 .= $_POST['f'];
	$separador = ",";
	}
if(isset($_POST['fj']) AND $_POST['fj'] <>""){
	$motius_informe2 .= $separador.$_POST['fj'];
	$separador = ",";
	}
if(isset($_POST['r']) AND $_POST['r'] <>""){
	$motius_informe2 .= $separador.$_POST['r'];
	$separador = ",";
}
if(isset($_POST['rj']) AND $_POST['rj'] <>""){
	$motius_informe2 .= $separador.$_POST['rj'];
	$separador = ",";
}
if(isset($_POST['e']) AND $_POST['e'] <>""){
	$motius_informe2 .= $separador.$_POST['e'];
	
	}
	$motius_informe2 .= "";

	
$hora_informe=$_POST['hora_informe'];

$_SESSION['hora_informe']=$hora_informe;
$_SESSION['motius_informe']=$motius_informe;
$_SESSION['str_data_informe']=$str_data_informe;


//print $codi_hora;

//print $motius_informe;

//mostrem el títol de l'informe amb la data i l'hora seleccionades
$smarty->assign('DATA',strftime("%A, %d de %B de %Y", strtotime($_POST['data_informe'])));
$smarty->assign('HORA_INICI',hora_inici($hora_informe, $ConTut));
$smarty->assign('HORA_FINAL',hora_final($hora_informe, $ConTut));
//print "<h3> Informe d'incidències del centre del ".strftime("%A, %d de %B de %Y", strtotime($_POST['data_informe'])).", de ".hora_inici($hora_informe, $ConTut)." a ".hora_final($hora_informe, $ConTut)."</h3>";


//mostrem els motius d'incidéncia seleccionats
//print "<table border=\"1\" align=\"right\"><tr><td colspan = \"2\"   bgcolor=\"#d0d0d0\">Incidéncies seleccionades: </td> </tr>";
$f=0;
if(isset($_POST['f']) AND $_POST['f'] <>""){
	//print "<td> F </td> <td> Falta no justificada </td></tr>";
	$f=1;
	$smarty->assign('F',$f);
	}
$fj=0;
if(isset($_POST['fj']) AND $_POST['fj'] <>""){
	//print "<tr><td> FJ </td> <td> Falta justificada </td></tr>";
	$fj=1;
	$smarty->assign('FJ',$fj);
	}
$r=0;
if(isset($_POST['r']) AND $_POST['r'] <>""){
	//print "<tr><td> R </td> <td> Retard no justificada </td></tr>";
	$r=1;
	$smarty->assign('R',$r);
}
$rj=0;
if(isset($_POST['rj']) AND $_POST['rj'] <>""){
	//print "<tr><td> RJ </td> <td> Retard justificat </td></tr>";
	$rj=1;
	$smarty->assign('RJ',$rj);
}
$e=0;
if(isset($_POST['e']) AND $_POST['e'] <>""){
	//print "<tr><td> E </td> <td> Expulsió </td></tr>";
	$e=1;
	$smarty->assign('E',$e);
	}
//print "</table>";


$students_codes_0=array();
$grup=array();
$grup_ant=array();
$l=0;
if($_SESSION['es_coordinador'] != 0){
	
					$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
					$utils->p_dbg($RSRC, "Prova log");
					$result_1 = $ConTut->Execute($RSRC['CONSULTA_GRUP_NIVELL_EDUCATIU']) or die($ConTut->ErrorMsg());
					
					$hi_ha_incidencies = 0;
					$students = array();
					 while (list($codi_grup, $nom_grup)=$result_1->fields) {
					 		$j=0;
					 		$dngrup = cercaGrup($codi_grup);
							$ldapconfig['host'] = _LDAP_SERVER;
							#Només cal indicar el port si es diferent del port per defecte
							$ldapconfig['port'] = _LDAP_PORT;
							$ldapconfig['basedn'] = $dngrup;
									
							$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
									
							ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
									
							$password=_LDAP_PASSWORD;
									#$dn="cn=admin,".$ldapconfig['basedn'];
							$dn=_LDAP_USER;
									
							$primer_cop = 1;
							if ($bind=ldap_bind($ds, $dn, $password)) {
								if ($bind=ldap_bind($ds)) {
								  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
									$filter = "(objectClass=inetOrgPerson)";
									
									if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
									    echo("Unable to search ldap server<br>");
									    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
									} else {
									    $number_returned1 = ldap_count_entries($ds,$search);
									    ldap_sort($ds, $search, "cn"); 
									    $info = ldap_get_entries($ds, $search);
									    for ($i=0; $i<$info["count"];$i++) {
											$students_codes_0[$i]=$info[$j][_LDAP_USER_ID][0];
											$j=$j+1;
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
							ldap_close($ds);
							for ($m=0;$m<$number_returned1;$m++){
							$VALS['codi_alumne']=$students_codes_0[$m];
							$VALS['codi_grup'] = $codi_grup;
							$VALS['str_data_informe'] = $str_data_informe;
							$VALS['hora_informe'] = $hora_informe;
							$VALS['motius_informe'] = $motius_informe;
							$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
							$utils->p_dbg($RSRC, "Prova log");
							$result_2 = $ConTut->Execute($RSRC['CONSULTA_FALTES_HORA_GRUP_ALUMNE']) or die($ConTut->ErrorMsg());
							//$primer_cop = 1;
							$color="#d0d0d0"; //variable per alternar el color de 
							                  //les files
							$students_names=array();
							$teachers_names=array();
							$j=0;
							$k=0;
							while (list($codi_alumne, $motiu_curt, $nom_assignatura, $codi_professor)=$result_2->fields) {					
								$codi_grup2=$codi_grup;
								$dngrup = cercaGrup($codi_grup2);
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
										$filter = "(&(objectClass=inetOrgPerson)(employeeNumber=".$codi_alumne."))";
										
										if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
										    echo("Unable to search ldap server<br>");
										    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
										} else {
										    $number_returned = ldap_count_entries($ds,$search);
										    ldap_sort($ds, $search, "cn"); 
										    $info = ldap_get_entries($ds, $search);
										    for ($i=0; $i<$info["count"];$i++) {
												$students_names[0]=$info[0]['cn'][0];
												$j=$j+1;
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
								ldap_close($ds);
								$ldapconfig['host'] = _LDAP_SERVER;
								#Només cal indicar el port si es diferent del port per defecte
								$ldapconfig['port'] = _LDAP_PORT;
								$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
										
								$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
										
								ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
										
								$password=_LDAP_PASSWORD;
								$dn=_LDAP_USER;
										
								if ($bind=ldap_bind($ds, $dn, $password)) {
									
									if ($bind=ldap_bind($ds)) {
									  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
										$filter = "(&(objectClass=inetOrgPerson)(employeeNumber=".$codi_professor."))";
										
										if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
										    echo("Unable to search ldap server<br>");
										    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
										} else {
										    $number_returned = ldap_count_entries($ds,$search);
										    ldap_sort($ds, $search, "cn"); 
										    $info = ldap_get_entries($ds, $search);
										    for ($i=0; $i<$info["count"];$i++) {
												$teachers_names[0]=$info[0]['cn'][0];
												$k=$k+1;
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
								ldap_close($ds);
								
								$student=new student();
								$smarty->assign('CODI_GRUP',$codi_grup2);
								//if($students_names[0] && $teachers_names[0]){
								$student->name=$students_names[0];
								$student->motiu_curt=$motiu_curt;
								$student->nom_assignatura=$nom_assignatura;
								$student->nom_professor=$teachers_names[0];
								$student->nom_group=$codi_grup2;
								//}
								$results[]=array('i' => $l,
								'primer_cop' => $primer_cop,
								'grup' => $codi_grup2);
								$l++;
								if ($primer_cop){
									$smarty->assign('PRIMER_COP',$primer_cop);
									//print "<table border=\"1\" width=\"700\"> <table border=\"0\" width=\"700\"> <tr><td colspan=\"5\" bgcolor = \"#d0d0d0\"><h3> ".$codi_grup." </h3></td></tr> ";
									//print"<tr bgcolor = \"#d0d0d0\"><th width=\"250\" align =\"left\"> &nbsp; Alumne/a &nbsp;</th><th align =\"left\" width=\"100\"> &nbsp; Incidència &nbsp;</th><th align =\"left\" width=\"150\">&nbsp; Assignatura &nbsp;</th><th align =\"left\"  colspan=2  width=\"200\">&nbsp;Professor/a &nbsp;</th></tr>";
									$primer_cop = 0;
									$hi_ha_incidencies = 1;
								}
								
								$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
								$smarty->assign('COLOR',$color);
								//print"<tr bgcolor=".$color."><td> &nbsp;".$nom_alumne." &nbsp;</td><td> &nbsp;".strtoupper($motiu_curt)." &nbsp;</td><td>&nbsp; ".$nom_assignatura."&nbsp;</td><td colspan =\"2\">&nbsp;".$nom_professor."&nbsp;".$cognom1_professor."&nbsp;</td></tr>";
								$students[]=$student;
								$result_2->MoveNext(); //següent incidència
								}
								$color="#ffffff"; //variable per alternar el color
												 // de les files
								//print "</table></table><p>";
							$result_2->Close();
	
							}
						$result_1->MoveNext(); //següent grup
						}
						$result_1->Close();
						}
					$smarty->assign('HI_HA_INCIDENCIES',$hi_ha_incidencies);
					//if (!$hi_ha_incidencies){
						//print "No hi ha cap incidéncia per aquest dia a aquesta hora.";
					//}
$link=_BASE_PATH_HTML."/reports/informe_centre_d_h_pdf.php?motius_informe=".$motius_informe;
$smarty->assign('link', $link);
$smarty->assign('results', $results );
$smarty->assign('students',$students);
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
$smarty->display('informe_centre_d_h_2.tpl');
//We load here common foot application
$smarty->display('foot.tpl');
?>
