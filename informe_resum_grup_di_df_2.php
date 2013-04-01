<?php
/*---------------------------------------------------------------
* Aplicatiu d'incidencies   Fitxer: selecgrup_informe.php
* Autor: Carles Año   Data:
* Descripció: Informe resum d'incidències dels alumnes entre una data incial i una final
* Pre condi.:
* Post cond.:
----------------------------------------------------------------*/
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Anyo
 * Coautors: Jordi Cid Royo
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
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_RESUM_GRUP_DI_DF_1;
$name_of="Escollir informe";
$name_of2="Resum d'incidències d'un grup entre una data inicial i una data final";

//We load here common header application
require_once _INCLUDES.'common-header.php';

$utils= new utils();

$RSRC = array();
$VALS = array();



//Recuperem variables de sessi� i les simplifiquem per a m�s comoditat
$codi_professor = $_SESSION['codi_professor'];
$usuari = $_SESSION['usuari'];

//recuperem les variables que hem passat mitjançant (fent trampa amb) el mètode GET
//$codi_dia = $_GET['codi_dia'];
//$codi_hora = $_GET['codi_hora'];
//$codi_grup = $_GET['codi_grup'];
//$codi_assignatura = $_GET['codi_ass'];
//$data = date('Y-m-d');

$str_data_inicial = date('Y-m-d', strtotime($_POST['data_inicial']));
$str_data_final =  date('Y-m-d', strtotime($_POST['data_final']));
$codi_grup = $_POST['grup'];
$_SESSION['codi_grup']= $codi_grup;
$_SESSION['str_data_inicial']= $str_data_inicial;
$_SESSION['str_data_final']= $str_data_final;


//el grup del qual el professor  es tutor
//$codi_grup = $_SESSION['tutor_de'];

//$data=date('Y-m-d', $_SESSION['data']);
		

	$str_di = date('d-m-Y', strtotime($str_data_inicial));
	$str_df = date('d-m-Y', strtotime($str_data_final));
	
	//$Dates="Resum d'incidencies del grup ".$codi_grup."entre el ".$_POST['data_inicial']." i el ".$_POST['data_final'];
	$smarty->assign('codi_grup',$codi_grup);
	$smarty->assign('data_inicial',$_POST['data_inicial']);
	$smarty->assign('data_final',$_POST['data_final']);
	
	//fem la consulta per recuperar els alumnes del grup	
	/*
	$sql  = "SELECT codi_alumne, nom_alumne";
	$sql .= " FROM alumne INNER JOIN student_groups ON (alumne.codi_alumne=student_groups.student_code)";
    $sql .= " WHERE student_groups.group_code = '$codi_grup'";
	$sql .= " ORDER BY nom_alumne";
	*/

	/*$VALS['codi_grup'] = $codi_grup;
	
	$utils->get_global_resources($RSRC,"db/sql_querys_inc.php", $VALS);
	$utils->p_dbg($RSRC, "Prova log");
	
    $result = $ConTut->Execute($RSRC['informe_resum_grup_di_df_2__2']) or die($ConTut->ErrorMsg());*/
	
	$color="#d0d0d0"; //variable per alternar el color de les files
	
			$alumnes=array();
			$j=0;
			$students_names=array();
			$students_codes=array();
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
					for ($i=0; $i<$info["count"];$i++) {
					$students_names[$i]=$info[$j]['cn'][0];
					$students_codes[$i]=$info[$j][_LDAP_USER_ID][0];
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
    for($l=0;$l<$number_returned;$l++) {
			$alumne= new student();
			//print "<tr bgcolor=".$color."> ";
			//print "<td> ".$nom."</td> "; 
		$alumne->name= $students_names[$l];
		
		$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
		
			$TOTAL_INCIDENCIES = 0;
			$total = array();
			//per cada alumne mostrem les seves incidéncies, per cada incidéncia
				for ($n=1; $n <= 5; ++$n){
					$total = array();
					/*
						$sql2  = "SELECT COUNT(*) AS total";
						$sql2 .= " FROM incidencia";
						$sql2 .= " WHERE codi_alumne = '$codi_alumne'";
						$sql2 .= " AND motiu_incidencia = '$n'";
						$sql2 .= " AND data_incidencia BETWEEN '$str_data_inicial' AND '$str_data_final'";
					*/
						//print $sql2;
						$VALS['n'] = $n;
						$VALS['str_data_final'] = $str_data_final;
						$VALS['str_data_inicial'] = $str_data_inicial;
						$VALS['codi_alumne']= $students_codes[$l];

						$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
						$utils->p_dbg($RSRC, "Prova log");
					
						$result2 = $ConTut->Execute($RSRC['informe_resum_grup_di_df_2__1']) or die($ConTut->ErrorMsg());
						if (!$result2->EOF){
							$total = $result2->Fields('total');
							$TOTAL_INCIDENCIES = $TOTAL_INCIDENCIES + $total;
							$totals[$n]=$total;
							$result2->Close();
				        }
						//print "<td> ".$total."</td> ";   
				}
				//print "<td> ".$TOTAL_INCIDENCIES."</td></tr> ";
		
				$alumne->total=$totals;
				$alumne->TOTAL_INCIDENCIES= $TOTAL_INCIDENCIES;
				$alumnes[]=$alumne;
				// Pasem al registre següent del RS				        
				//$result->MoveNext(); //següent alumne
		}	
		//echo $RSRC['informe_resum_grup_di_df_2__2']; 
		//echo $RSRC['informe_resum_grup_di_df_2__1'];  
		 //}
		//</table>
	$smarty->assign('alumnes',$alumnes);
	$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
	$smarty->display('informe_resum_grup_di_df_2.tpl');

//We load here common foot application
	$smarty->display('foot.tpl');
?>