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
include_once("seguretat.inc.php");


#----------ldap--------------------------------------
$ldapconfig['host'] = _LDAP_SERVER;
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
		
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
$password=_LDAP_PASSWORD;
		#$dn="cn=admin,".$ldapconfig['basedn'];
$dn=_LDAP_USER;
#-------------------------------------------------

if (isset($_POST['return']))
	{
	header("Location: index.php");
	}

if (isset($_POST['modify']))
	{
	//header("Location: modifying_profile.php");
	}

$utils = new utils();

$RSRC = array();
$VALS = array();



$op=$_REQUEST['op'];
//echo $op;
if ($op){
	$teacher_code=$_GET['teacher_code'];
	//echo $codi_profe;
	if ($bind=ldap_bind($ds, $dn, $password)) {
		
	  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
		$filter = "(&(objectClass=inetOrgPerson)("._LDAP_USER_ID."=".$teacher_code."))";
		$justthese= array("givenname", "sn1", "sn2", "uid","carlicense");
		if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter, $justthese))) {
		    echo("Unable to search ldap server<br>");
		    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
		} else {
		    $number_returned = ldap_count_entries($ds,$search);
		    ldap_sort($ds, $search, "cn"); 
		    $info = ldap_get_entries($ds, $search);
		    //echo $info;
		    $entry = ldap_first_entry($ds, $search);
	    //echo $entry;
		    for ($i=0; $i<$info["count"];$i++) {		    	
				$teacher_name=$info[0]['givenname'][0];
				$teacher_surname1=$info[0]['sn1'][0];
				$teacher_surname2=$info[0]['sn2'][0];
				$usuari=$info[0]['uid'][0];
				//echo $user;
				$email=$info[0]['carlicense'][0];


				//$students_jpegPhoto[$i]=$info[$j]['jpegphoto'][0];
				//echo $info[$j]['jpegphoto'][0];
				
				$jpeg_data = ldap_get_values_len($ds, $entry, "jpegphoto");
				//print_r($jpeg_data);
				/*$photo_filename="/tmp/".$students_codes[$i].".png";
				$outphoto = fopen ($photo_filename,"wb");
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
				
				
				fwrite($outphoto,filesize($jpeg_data[0]));
				fclose ($outphoto);*/
				
				$j=$j+1;
				$entry = ldap_next_entry($ds, $entry);
   
	}	
}
	
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
	

}else{
	//variables
$teacher_code = $_SESSION['codi_professor'];
$teacher_name= $_SESSION['nom_professor'];
$teacher_surname1= $_SESSION['cognom1_professor'];
$teacher_surname2= $_SESSION['cognom2_professor'];
$usuari= $_SESSION['usuari'];
//$password= $_SESSION['password'];
$email= $_SESSION['email'];
	
}//fi if op
if($is_coordinator==1){
	$is_coordinator='Yes';
}else{
	$is_coordinator='No';
}
//echo $profile_photo_medium;
//echo _PROFILE_PHOTO;
if ($profile_photo_medium == NULL){

	$profile_photo_medium=_PROFILE_NULL_PATH;
	//$status=" bd buida";
}else{
	$profile_photo_medium=_BASE_PATH_HTML."/".$profile_photo_medium;
	//$status="foto a la bd";

}

if ($email== NULL)
	{$email=$usuari."@iesebre.com";}
	

require_once _INCLUDES.'common-header.php';

$smarty->assign('teacher_code', $teacher_code );
$smarty->assign('teacher_name', $teacher_name );
$smarty->assign('teacher_surname1', $teacher_surname1 );
$smarty->assign('teacher_surname2', $teacher_surname2 );
$smarty->assign('user', $usuari );
$smarty->assign('password', $password );
$smarty->assign('email', $email );
$smarty->display('profile.tpl');

//We load here common foot application
$smarty->display('foot.tpl');


?>