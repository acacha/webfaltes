<?php
/*---------------------------------------------------------------
* Aplicatiu d'incidencies   Fitxer: class_list_report.php
* Autor: Sergi Tur Badenas   Data: 04/09/2010
* Descripció: Class list
----------------------------------------------------------------*/
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
 *$Id: informe_resum_grup_di_df_1.php 1211 2010-06-02 12:48:07Z ccristoful $
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
$name_of2="Llistes de classe";

//We load here common header application
require_once _INCLUDES.'common-header.php';

//Recuperem variables de sessió i les simplifiquem per a més comoditat
$codi_professor = $_SESSION['codi_professor'];
$usuari = $_SESSION['usuari'];

//el grup del qual el professor  és tutor
if (isset($_SESSION['tutor_de'])) {
	$codi_grup = $_SESSION['tutor_de'];
    }
else {
        $codi_grup= "";
}
//$int_data=date('Y-m-d', $_SESSION['data']);


/*
	<p><br>
	<p><br>
	<center>
	<form name="tipus_informe" method="post" action="informe_resum_grup_di_df_2.php">
	<table border = "0">
	<tr>
	<td><p>Selecciona el grup: </td>
	<td>
	
	<select name="grup">
*/
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
		    	if($i==$info["count"]-1){
		    		$student_mail[$j]=$info[$i]['email'][0];
		    		$j=$j+1;
		    	}else{
			    	if ($info[$i]['email'][0]!=NULL){
					$student_mail[$j]=$info[$i]['email'][0].", ";
					$j=$j+1;
			    	}
		    	}
   
	}	
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
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
$smarty->assign('student_mail', $student_mail);
$smarty->display('llistat_correu_personal.tpl');

//We load here common foot application
$smarty->display('foot.tpl');
?>