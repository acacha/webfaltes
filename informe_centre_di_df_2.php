<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Anyo
 * Coautors: Albert Mestre Algueró
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
 * $Id:informe_centre_di_df_2.php 1368 2010-09-16 12:01:49Z irent88 $
 */
/*---------------------------------------------------------------
 * Aplicatiu d'incidencies   Fitxer: informe_centre_d_h_1.php
 * Autor: Carles Añó   Data:
 * Descripcio: Informe resum d'incidències del centre un dia determinat a una 
 * hora determinada. Seleccio del dia i la hora i els tipus d'incidencies
 * Pre condi.:
 * Post cond.:
 ----------------------------------------------------------------*/

// Iniciem (recuperem) la sessio (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexio, configuracio i
//funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_CENTRE_DI_DF_1;
$name_of="Escollir informe";
$name_of2="Incidències del centre entre una data inicial i una data final ";

//We load here common header application
require_once _INCLUDES.'common-header.php';

//recollim les variables passades pel formulari
$str_data_inicial = date('Y-m-d', strtotime($_POST['data_inicial']));
$str_data_final = date('Y-m-d', strtotime($_POST['data_final']));
$separador = "";
$motius_informe = "(";
$n_incidencies = 0;
$matriu_motius_informe;
$capçalera_pdf="";
if(isset($_POST['f']) AND $_POST['f'] <>""){
	$motius_informe .= $_POST['f'];
	$separador = ",";
	$n_incidencies += 1;
	$matriu_motius_informe[1]=1;
	$capçalera_pdf.="F";
}else{
	$matriu_motius_informe[2]=0;
}
if(isset($_POST['fj']) AND $_POST['fj'] <>""){
	$motius_informe .= $separador.$_POST['fj'];
	$separador = ",";
	$n_incidencies += 1;
	$matriu_motius_informe[2]=2;
	$capçalera_pdf.=$separador."FJ";
}else{
	$matriu_motius_informe[2]=0;
}
if(isset($_POST['r']) AND $_POST['r'] <>""){
	$motius_informe .= $separador.$_POST['r'];
	$separador = ",";
	$n_incidencies += 1;
	$matriu_motius_informe[3]=3;
	$capçalera_pdf.=$separador."R";
}else{
	$matriu_motius_informe[3]=0;
}
if(isset($_POST['rj']) AND $_POST['rj'] <>""){
	$motius_informe .= $separador.$_POST['rj'];
	$separador = ",";
	$n_incidencies += 1;
	$matriu_motius_informe[4]=4;
	$capçalera_pdf.=$separador."RJ";
}else{
	$matriu_motius_informe[4]=0;
}
if(isset($_POST['e']) AND $_POST['e'] <>""){
	$motius_informe .= $separador.$_POST['e'];
	$n_incidencies += 1;
	$matriu_motius_informe[5]=5;
	$capçalera_pdf.=$separador."E";
}else{
	$matriu_motius_informe[5]=0;
}
$motius_informe .= ")";

//print_r($matriu_motius_informe);
$_SESSION['motius_informe']=$motius_informe;
$_SESSION['matriu_motius_informe']=$matriu_motius_informe;
$_SESSION['str_data_inicial']=$str_data_inicial;
$_SESSION['str_data_final']=$str_data_final;
$_SESSION['capçalera_pdf']=$capçalera_pdf;

//comprovem les dates que ens han passat

//mostrem el titol de l'informe amb la data i l'hora seleccionades
//print "<h3> Informe d'incidències del centre entre el 
//".strftime("%A, %d de %B de %Y", strtotime($_POST['data_informe'])).", de
//".hora_inici($hora_informe, $ConTut)." a ".hora_final($hora_informe, $ConTut)
//."</h3>";

//mostrem els motius d'incidència seleccionats
$smarty->assign('f',false);
$smarty->assign('fj',false);
$smarty->assign('r',false);
$smarty->assign('rj',false);
$smarty->assign('e',false);

if(isset($_POST['f']) AND $_POST['f'] <>""){
	$smarty->assign('f', true);
}
if(isset($_POST['fj']) AND $_POST['fj'] <>""){
	$smarty->assign('fj',true);
}
if(isset($_POST['r']) AND $_POST['r'] <>""){
	$smarty->assign('r',true);
}
if(isset($_POST['rj']) AND $_POST['rj'] <>""){
	$smarty->assign('rj',true);
}
if(isset($_POST['e']) AND $_POST['e'] <>""){
	$smarty->assign('e',true);
}

$smarty->assign('DATA_INICIAL',$_POST['data_inicial']);
$smarty->assign('DATA_FINAL',$_POST['data_final']);

if($_SESSION['es_coordinador'] != 0){

	$utils = new utils();
	$RSRC = array();
	$VALS = array();

	$VALS['nom_grup'] = $nom_grup;
	$VALS['nivell_educatiu'] = $nivell_educatiu;

	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	//$utils->p_dbg($RSRC, "Prova log");
	$result_1 = $ConTut->Execute($RSRC['CONSULTA_CODI_GRUP_NOM_GRUP_ESO_INFORMATICA_BATX']) or die($ConTut->ErrorMsg());
	$hi_ha_incidencies = 0;
	$n_incidencies +=2; //per afegir les columnesecho del nom de l'alumne i la del total de faltes
	$smarty->assign('N_INCIDENCIES',$n_incidencies);
	$grups=array();
	$students=array();
	while (!$result_1->EOF){
			$codi_grup=$result_1->Fields('codi_grup');
			$nom_grup=$result_1->Fields('nom_grup');
			$grup=new grups();
	
			$smarty->assign('f',false);
			$smarty->assign('fj',false);
			$smarty->assign('r',false);
			$smarty->assign('rj',false);
			$smarty->assign('e',false);
	
			if(isset($_POST['f']) AND $_POST['f'] <>""){
				$smarty->assign('f', true);
			}
			if(isset($_POST['fj']) AND $_POST['fj'] <>""){
				$smarty->assign('fj',true);
			}
			if(isset($_POST['r']) AND $_POST['r'] <>""){
				$smarty->assign('r',true);
			}
			if(isset($_POST['rj']) AND $_POST['rj'] <>""){
				$smarty->assign('rj',true);
			}
			if(isset($_POST['e']) AND $_POST['e'] <>""){
				$smarty->assign('e',true);
			}
	
			/*$VALS['codi_alumne'] = $codi_alumne;
			$VALS['nom_alumne'] = $nom_alumne;
			$VALS['codi_grup'] = $codi_grup;*/
	
	
	
			//$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
			//$utils->p_dbg($RSRC, "Prova log");
			//$result= $ConTut->Execute($RSRC['CONSULTA_RECUPERA_ALUMNES_GRUP']) or die($ConTut->ErrorMsg());
	
			$j=0;
			$number_returned=0;
			$students_names=array();
			$students_codes=array();
			$dngrup = cercaGrup($codi_grup);
			$ldapconfig['host'] = _LDAP_SERVER;
			#Només cal indicar el port si es diferent del port per defecte
			$ldapconfig['port'] = _LDAP_PORT;
			//$ldapconfig['basedn'] = $dngrup;
			$ldapconfig['basedn'] = _LDAP_STUDENT_BASE_DN;
			
					
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
					    //echo("Unable to search ldap server<br>");
					    //echo("msg:'".ldap_error($ds)."'</br>");#check the message again
					} else {
					    $number_returned = ldap_count_entries($ds,$search);
					    ldap_sort($ds, $search, _LDAP_USER_ID); 
					    $info = ldap_get_entries($ds, $search);
					    for ($i=0; $i<$info["count"];$i++) {
							$students_names[$i]=$info[$j]['cn'][0];
							$students_codes[$i]=$info[$j][_LDAP_USER_ID][0];
							$j=$j+1;
			     		}
					}
					    
				} else {
					//echo("Unable to bind anonymously<br>");
					//echo("msg:".ldap_error($ds)."<br>");
				}
				//print_r($students_codes);
			} else {
				//echo("Unable to bind to server.</br>");
					
				//echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
					  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
					  #we can figure out the right pattern by searching the user tree
					  #remember to turn on the anonymous search on the ldap server
					  
			}
			ldap_close($ds);
			/*generar vector on posarem alumnes*/
			$color="#d0d0d0"; //variable per alternar el color de les files
			$grup->codi_grup=$codi_grup;//$codi_grup;
			$grup->nom_grup=$nom_grup;//$nom_grup;
			for($l=0;$l<$number_returned;$l++) {
	
				$student=new student();
				/* creem nou objecte student (no fa falta degut a que ja esta dintre de funcions.php)*/
				$color="#ffffff";
				$student->name=$students_names[$l];
				$student->codi_grup=$group;//$codi_grup;
				/*print------------- "<td> ".$nom."</td> ";*/
				$TOTAL_INCIDENCIES = 0;
				//per cada alumne mostrem les seves incidències, per cada incidència
				$totals=array();
				for ($n=1; $n <= 5; $n++)
				{
					if ($matriu_motius_informe[$n] == 0) continue;
	
					$VALS['motius_informe']= $motius_informe;
					$VALS['str_data_inicial']= $str_data_inicial;
					$VALS['str_data_final']= $str_data_final;
					$VALS['n']= $n;
					$VALS['codi_alumne'] = $students_codes[$l];//$codi_alumne;
	
					$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
					$utils->p_dbg($RSRC, "Prova log");
					$result2 = $ConTut->Execute($RSRC['CONSULTA_RECOMPTE']) or die($ConTut->ErrorMsg());

					if (!$result2->EOF)
					{
						$total  = $result2->Fields('total');
						$TOTAL_INCIDENCIES = $TOTAL_INCIDENCIES + $total;
						$result2->Close();
					}
					$totals[]=$total;
	
				}
				$student->total=$totals;
	
				$student->TOTAL_INCIDENCIES=$TOTAL_INCIDENCIES;
				// Pasem al registre següent del RS	
	
				//$result->MoveNext(); //següent alumne
	
				/* ja tenim els valors plens i els assignem dintre del vector */
				/* fer un print amb el vector per veure les coherencies */
	
				//$students[]=$student;
			}
			$smarty->assign('STUDENTS',$students);
//			$result->Close();
			//}
			$grups[]=$grup;
	
			 //següent grup	
			$result_1->MoveNext();
		}
	
		//$smarty->assign('GRUPS',$grups);
		//$result_2->Close();
	$result_1->Close();
}

//$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
$smarty->display('informe_centre_di_df_2.tpl');
$smarty->display('foot.tpl');

?>