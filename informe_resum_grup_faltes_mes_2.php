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
 * $Id$
 */
// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");

$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_RESUM_GRUP_FALTES_MES_1;
$name_of="Escollir informe";
$name_of2="Monthly Summary of unjustified absences";


//We load here common header application
require_once _INCLUDES."common-header.php";

$utils= new utils();

$RSRC = array();
$VALS = array();



//Recuperem variables de sessi� i les simplifiquem per a m�s comoditat
$codi_professor = $_SESSION['codi_professor'];
$usuari = $_SESSION['usuari'];

$str_data_inicial = date('Y-m-d', strtotime($_POST['data_inicial']));
$str_data_final =  date('Y-m-d', strtotime($_POST['data_final']));
$codi_grup = $_POST['grup'];
$mes = $_POST['mes'];
$ano = $_POST['ano'];

$_SESSION['codi_grup']=$codi_grup;

	$mes_char = array();
	$mes_char = array(January, February, March, April, May, June, July, August, September, October, November, December);
	//$Dates="Resum d'incidencies del grup ".$codi_grup." al mes de ".$mes_char[$mes-1];
	$smarty->assign('codi_grup',$codi_grup);
	$smarty->assign('mes',$mes_char[$mes-1]);
	
	
	$VALS['codi_grup'] = $codi_grup;
	
	//Miro quans dies té aquest mes segons l'any
	if ($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
		$dia = 31;
	}
	
	if ($mes==4 || $mes==6 || $mes==9 || $mes==11) {
		$dia = 30;
	}
	
	if ($mes==2){
		if (($ano % 4 == 0) && ($ano % 100 != 0) || ($ano % 400 == 0)){
			$dia=29;
		}
		else{
			$dia=28;
		}	
	}
	setlocale(LC_TIME, "ca_ES");
	$str_data_inicial=$ano."-".$mes."-01";
	$str_data_inicial=strftime("%Y-%m-%d",strtotime("$str_data_inicial"));
	$str_data_final=$ano."-".$mes."-".$dia;
	$str_data_final=strftime("%Y-%m-%d",strtotime("$str_data_final"));
	
	$VALS['str_data_inicial'] = $str_data_inicial;
	$VALS['str_data_final'] = $str_data_final;
	
	//echo $VALS['str_data_inicial'];
	
	$_SESSION['str_data_inicial']=$str_data_inicial;
	$_SESSION['str_data_final']=$str_data_final;
	$_SESSION['mes']=$mes;
	
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
			    //echo("Unable to search ldap server<br>");
			   // echo("msg:'".ldap_error($ds)."'</br>");#check the message again
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
			// Usuari i contrasenya vàlids (Control seguretat 1)
	ldap_close($ds);
	$st_co='\'';
	$st_co.=join('\', \'', $students_codes);
	$st_co.='\'';
	$alumnes=array();
		$VALS['codi_alumne']=$st_co;
		
		$utils->get_global_resources($RSRC,"db/sql_querys_inc.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		
	    $result = $ConTut->Execute($RSRC['informe_resum_faltes_mes_2']) or die($ConTut->ErrorMsg());
		$color="#d0d0d0"; //variable per alternar el color de les files
		
		$l=0;
	    while (!$result->EOF) {
			
			$alumne= new student();
			$codi_alumne = $result->fields['codi_alumne'];
			$ldapconfig['host'] = _LDAP_SERVER;
			#Només cal indicar el port si es diferent del port per defecte
			$ldapconfig['port'] = _LDAP_PORT;
			$ldapconfig['basedn'] = $dngrup;
					
			$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
					
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
					
			$password=_LDAP_PASSWORD;
			$dn=_LDAP_USER;					
					
			if ($bind=ldap_bind($ds, $dn, $password)) {
				if ($bind=ldap_bind($ds)) {
					
				  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
					$filter = "(&(objectClass=inetOrgPerson)("._LDAP_USER_ID."=".$codi_alumne."))";
					
					if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
					    //echo("Unable to search ldap server<br>");
					   // echo("msg:'".ldap_error($ds)."'</br>");#check the message again
					} else {
					    $number_returned = ldap_count_entries($ds,$search);
					    ldap_sort($ds, $search, "cn"); 
					    $info = ldap_get_entries($ds, $search);
					    for ($i=0; $i<$info["count"];$i++) {
							$students_names2=$info[0]['cn'][0];
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
			$alumne->name = $students_names2;
			$alumne->fj = $result->fields['falta'];
			$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
					$alumnes[]=$alumne;
					// Pasem al registre següent del RS			        
			$result->MoveNext(); //següent alumne
		}	
	$smarty->assign('alumnes',$alumnes);
	$smarty->assign('Dates',$Dates);
	$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
	$smarty->display('informe_resum_grup_faltes_mes_2.tpl');

//We load here common foot application
	$smarty->display('foot.tpl');
?>