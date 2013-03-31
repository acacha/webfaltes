<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Amado Domenech Antequera
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
 */

// Session managment
session_start();

// Includes
include_once("config.inc.php");
include_once(_DIR_CONNEXIO."seguretat.inc.php");


if (isset($_POST['return']))
	{
	header("Location: index.php");
	}

if (isset($_POST['modify']))
	{
	//header("Location: modifying_profile_student.php");
	}

$utils = new utils();
$RSRC = array();
$VALS = array();

$j=0;
$codi_alumne=$_GET['codi_alumne'];
$op=1;
$show_profile=_BASE_PATH_HTML.'/profile.php';
//variables
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
		$filter = "(&(objectClass=inetOrgPerson)("._LDAP_USER_ID."=".$codi_alumne."))";
		$justthese= array("givenname", "sn1", "uid","irispersonaluniqueid", "gender", "mobile", "telephonenumber", "labeleduri", "email", "postaladdress");
		if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter, $justthese))) {
		    echo("Unable to search ldap server<br>");
		    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
		} else {
		    $number_returned = ldap_count_entries($ds,$search);
		    ldap_sort($ds, $search, "cn"); 
		    $info = ldap_get_entries($ds, $search);
		    $entry = ldap_first_entry($ds, $search);
		    #Per a saber els profes que te un alumne hem de saber el grup, per aixo ens guardem el dn del usuari cercat amb ldap_get_dn. 
		    #Pero nomes ens interesa una part del dn, rdn, per tant dividim les parts en un array amb explode_dn i finalment concatenem el que 
		    #ens interesa per despres fer la busqueda del grup.
		    $rdn=ldap_explode_dn(ldap_get_dn($ds, $entry), 0);
		    $student_dn=$rdn[2].",".$rdn[3].",".$rdn[4].",".$rdn[5].",".$rdn[6].",".$rdn[7].",".$rdn[8].",".$rdn[9];

		    
		    for ($i=0; $i<$info["count"];$i++) {		    	
				$student_name=$info[0]['givenname'][0];
				$student_surname=$info[0]['sn1'][0]." ".$info[0]['sn2'][0];
				$student_user=$info[0]['uid'][0];
				$student_dni=$info[0]['irispersonaluniqueid'][0];
				$student_sexe=$info[0]['gender'][0];
				$student_mobil=$info[0]['mobile'][0];
				$student_fixe=$info[0]['telephonenumber'][0];
				$student_web=$info[0]['labeleduri'][0];
				$student_pers_mail=$info[0]['email'][0];
				$student_adreca=$info[0]['postaladdress'][0];

				//$students_jpegPhoto[$i]=$info[$j]['jpegphoto'][0];
				//echo $info[$j]['jpegphoto'][0];
				
				$jpeg_data = ldap_get_values_len($ds, $entry, "jpegphoto");
				//print_r($jpeg_data);
				/*$photo_filename="/tmp/".$students_codes[$i].".png";
				$outphoto = fopen ($photo_filename,"wb");*/
				$jpeg_filename="/tmp/".$codi_alumne.".png";
				$jpeg_file=$codi_alumne.".png";
		    for( $l=0; $l<$jpeg_data['count']; $l++ ) {
					$outjpeg = fopen($jpeg_filename, "wb");
					fwrite($outjpeg, $jpeg_data[0]);
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
$ldapconfig['basedn'] = $student_dn;
#-------a partir daqui farem la busqueda del grup
		$filter = "(&(objectClass=organizationalUnit)("._LDAP_GROUP."=*))";
		$justthese= array(_LDAP_GROUP);
		if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter, $justthese))) {
		    echo("Unable to search ldap server<br>");
		    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
		} else {
		    $number_returned = ldap_count_entries($ds,$search);
		    ldap_sort($ds, $search, "cn"); 
		    $info = ldap_get_entries($ds, $search);
		    $entry = ldap_first_entry($ds, $search);
		    for ($i=0; $i<$info["count"];$i++) {
				$student_group=$info[0][_LDAP_GROUP][0];
				$entry = ldap_next_entry($ds, $entry);

   
			}	
		}
//echo $student_group;
#Busquem els profes d'un grup
	$VALS['grup'] = $student_group;
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	$utils->p_dbg($RSRC, "Prova log");
 	$result= $ConTut->Execute($RSRC['selec_profe_grup']) or die($ConTut->ErrorMsg());
  	
  	while (!$result->EOF){
  		
  		$codi_profe=$result->Fields('codi_professor');
  		#Busquem les dades de profe
		$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
		$filter = "(&(objectClass=inetOrgPerson)("._LDAP_USER_ID."=".$codi_profe."))";
		$justthese= array("givenname", "sn1", "carlicense");
		if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter, $justthese))) {
		    echo("Unable to search ldap server<br>");
		    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
		} else {
		    $number_returned = ldap_count_entries($ds,$search);
		    ldap_sort($ds, $search, "cn"); 
		    $info = ldap_get_entries($ds, $search);
		    $entry = ldap_first_entry($ds, $search);
		    
		    $VALS['codi_profe'] = $codi_profe;
			$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
			$utils->p_dbg($RSRC, "Prova log");
 			$result_2= $ConTut->Execute($RSRC['es_tutor_grup']) or die($ConTut->ErrorMsg());
 			$existeix=$result_2->Fields('codi_grup');
 			//si existeix te algun valor guardat vol dir que el profe es un tutor, per tant es guardara en les variables de tutor
		    if ($existeix){
			    for ($i=0; $i<$info["count"];$i++) {
			    	$tutor_code=$codi_profe;
			    	$tutor_name=$info[0]['givenname'][0];
					$tutor_surname=$info[0]['sn1'][0]." ".$info[0]['sn2'][0];
					$tutor_email=$info[0]['carlicense'][0];
					$entry = ldap_next_entry($ds, $entry);				
	   
				}//tanquem for
		    	
		    }else{
			    for ($i=0; $i<$info["count"];$i++) {
			    	$other_teacher_code=$codi_profe;
			    	$other_teacher_name=$info[0]['givenname'][0];
					$other_teacher_surname=$info[0]['sn1'][0]." ".$info[0]['sn2'][0];
					$other_teacher_email=$info[0]['carlicense'][0];
					$professor = new professor();
					$professor->codi_professor=$other_teacher_code;
					$professor->nom_professor=$other_teacher_name;
					$professor->cognom1_professor=$other_teacher_surname;
					$professor->email=$other_teacher_email;
					$teachers[]=$professor;
					$entry = ldap_next_entry($ds, $entry);
				}//tanquem for
		    	
		    }//tanquem if consulta tutor
		    $result_2->MoveNext();
		    	
		}//tanquem if consulta ldap
  		
  		
  		
  		$result->MoveNext();
  	}//tanquem while pas codi profes
  	
 	//$codi_tutor=$result->fields('tutor'); // per a mostrar un tutor nomes
	$result->Close();

	
#fi busqueda grup
} else {
	echo("Unable to bind to server.</br>");
		
	echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
		  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
		  #we can figure out the right pattern by searching the user tree
		  #remember to turn on the anonymous search on the ldap server		  
}
		// Usuari i contrasenya vàlids (Control seguretat 1)
ldap_close($ds);

if ($email== NULL)
	{$email=$student_user."@iesebre.com";}

if ($profile_photo_medium == NULL){

	$profile_photo_medium=_PROFILE_NULL_PATH;
	//$status=" bd buida";
}else{
	$profile_photo_medium=_BASE_PATH_HTML."/".$profile_photo_medium;
	//$status="foto a la bd";

}


//We load here common header application
require_once _INCLUDES.'common-header.php';

$smarty->assign('show_profile',$show_profile);
$smarty->assign('student_code', $codi_alumne );
$smarty->assign('student_name', $student_name );
$smarty->assign('student_surname', $student_surname);
$smarty->assign('address', $student_adreca );
$smarty->assign('mobile_phone', $student_mobil );
$smarty->assign('fixed_telephone', $student_fixe );
$smarty->assign('dni', $student_dni );
$smarty->assign('sexe', $student_sexe );
$smarty->assign('user', $student_user);
$smarty->assign('foto', $jpeg_file );
$smarty->assign('email', $email );
$smarty->assign('p_email', $student_pers_mail );
$smarty->assign('web', $student_web);
$smarty->assign("teachers", $teachers);
$smarty->assign('t_code', $tutor_code);
$smarty->assign('t_name', $tutor_name);
$smarty->assign('t_surname', $tutor_surname);
$smarty->assign('t_email', $tutor_email);
$smarty->assign('op', $op);
$smarty->assign('group', $student_group);
$smarty->display('profile_student.tpl');

//We load here common foot application
$smarty->display('foot.tpl');


?>