<?php
/**
 * @author Carles Añó
 * @desc Mostra un rànquing dels alumnes amb més faltes d'assistència
 * @see informe_centre_ranking_di_df_2.php
 */

/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: rmz
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
 *$Id:informe_centre_ranking_di_df_2.php 1373 2010-09-18 14:12:55Z acacha $
 */


// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_CENTRE_RANKING_DI_DF_1;
$name_of="Escollir informe";
$name_of2="Rànquing incidències del centre entre una data inicial i una data final ";

//recoollim les variables passades pel formulari 
$str_data_inicial = date('Y-m-d', strtotime($_POST['data_inicial']));
$str_data_final = date('Y-m-d', strtotime($_POST['data_final']));
$top =$_POST['top'];
settype($top, "integer");

$_SESSION['str_data_inicial'] = $str_data_inicial;
$_SESSION['str_data_final'] = $str_data_final;
$_SESSION['top'] = $top;

//We load here common header application
require_once _INCLUDES.'common-header.php';

$smarty->assign('STR_DATA_INICIAL',$str_data_inicial);
$smarty->assign('STR_DATA_FINAL',$str_data_final);
if($_SESSION['es_coordinador'] != 0)
{
	$j=0;
	$students_names=array();
	$students_codes=array();
	
	$ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;
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
			// Usuari i contrasenya vàlids (Control seguretat 1)
	ldap_close($ds);
	//print "<table border=1>";
		$st_co='\'';
		$st_co.=join('\', \'', $students_codes);
		$st_co.='\'';

		$utils = new utils();
		$RSRC = array();
		$VALS = array();
		$students=array();
		$VALS['str_data_inicial'] = $str_data_inicial;
		$VALS['str_data_final'] = $str_data_final;	
		$VALS['codi_alumne'] = $st_co;
		$VALS['top'] = $top;
		
		$utils->p_dbg($RSRC, "COMPTA_INCIDENCIES");
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
					
		$result_1 = $ConTut->Execute($RSRC['COMPTA_INCIDENCIES2']) or die($ConTut->ErrorMsg());
		$n = 0; //Comptador que ens indicara la posició del alumne.
		$students_names2=array();
		while (list($codi_alumne, $total)=$result_1->fields)
		{
			$n++;//
			$student = new student();//Crear objecte estudiant
			$color="#d0d0d0"; //variable per alternar el color de les files
			$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
			$j=0;
			
			
			$ldapconfig['host'] = _LDAP_SERVER;
			#Només cal indicar el port si es diferent del port per defecte
			$ldapconfig['port'] = _LDAP_PORT;
			$ldapconfig['basedn'] = _LDAP_STUDENT_BASE_DN;
					
			$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
					
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
					
			$password=_LDAP_PASSWORD;
			$dn=_LDAP_USER;					
					
			if ($bind=ldap_bind($ds, $dn, $password)) {
				if ($bind=ldap_bind($ds)) {
					
				  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
					$filter = "(&(objectClass=inetOrgPerson)("._LDAP_USER_ID."=".$codi_alumne."))";
					
					if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
					    echo("Unable to search ldap server<br>");
					    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
					} else {
					    //$number_returned = ldap_count_entries($ds,$search);
					    //TODO number_returned=1 sinó error
					 	//$info = ldap_get_entries($ds, $search);
					 	$info = ldap_first_entry($ds, $search);
			 		    $dnb = ldap_get_dn($ds, $info);
			 		    //$dnc = ldap_explode_dn($dnb, 0);
			 		    $dnc=explode  ( ","  , $dnb    );
			 		    unset($dnc[0]);
						$array = array_values($dnc);	
						unset($dnc[1]);
						$array = array_values($dnc);	
			 		    $dnd=implode ( ",", $dnc);
			 		    $dne=cercagrupAlumne($dnd);
					    $students_names2 = ldap_get_values($ds, $info, "cn"); 
						$j=$j+1;
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
			$student->name=$students_names2[0];//passar el nom del alumne
			$student->id_group=$dne[0];//passar el codi de grup del alumne
			$student->TOTAL_INCIDENCIES=$total;//Passar les incidencies totals del alumne
			$student->posicio=$n;//Passar la variable n(posicio)
			$students[]=$student;//Passar l'objecte estudiant ple al vector estudiants
			$result_1->MoveNext(); //següent grup						
		}
	$smarty->assign('STUDENTS',$students);//Passem el vector d'estudiants a la plantilla
	$result_1->Close();	
}	
	
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
//We load here common foot application
$smarty->display('informe_centre_ranking_di_df_2.tpl');
$smarty->display('foot.tpl');

?>