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



if (isset($_POST['return']))
	{
	header("Location: index.php");
	}

if (isset($_POST['modify']))
	{
	//header("Location: modifying_profile_father.php");
	}

$utils = new utils();

$RSRC = array();
$VALS = array();

//variables
$father_code = $_SESSION['codi_pare'];
$father_name= $_SESSION['nom_pare'];
$address= $_SESSION['adreca'];
$postcode= $_SESSION['codi_postal'];
$city= $_SESSION['ciutat'];
$user= $_SESSION['usuari'];
$password= $_SESSION['password'];
$email= $_SESSION['email'];
$mobile_phone= $_SESSION['telefon_mobil'];
$vol_sms= $_SESSION['vol_sms'];
$vol_email= $_SESSION['vol_email'];
$is_father= $_SESSION['es_pare'];
$profile_photo=$_SESSION['foto_perfil_pa'];
$profile_photo_small=$_SESSION['foto_perfil_pa_small'];
$profile_photo_medium=$_SESSION['foto_perfil_pa_medium'];
$aux=$_SESSION['foto_perfil_pr'];

if($vol_sms==1){
	$vol_sms='Yes';
}else{
	$vol_sms='No';
}

if($vol_email==1){
	$vol_email='Yes';
}else{
	$vol_email='No';
}

if($is_father==1){
	$is_father='Yes';
}else{
	$is_father='No';
}

if ($profile_photo_medium == NULL){

	$profile_photo_medium=_PROFILE_NULL_PATH;
	//$status=" bd buida";
}else{
	$profile_photo_medium=_BASE_PATH_HTML."/".$profile_photo_medium;
	//$status="foto a la bd";

}
	
//We load here common header application
require_once _INCLUDES.'common-header.php';

$smarty->assign('father_code', $father_code );
$smarty->assign('father_name', $father_name );
$smarty->assign('address', $address );
$smarty->assign('postcode', $postcode );
$smarty->assign('city', $city );
$smarty->assign('user', $user );
$smarty->assign('password', $password );
$smarty->assign('email', $email );
$smarty->assign('mobile_phone', $mobile_phone );
$smarty->assign('vol_sms', $vol_sms );
$smarty->assign('vol_email', $vol_email );
$smarty->assign('is_father', $is_father );
$smarty->assign('profile_photo', $profile_photo );
$smarty->assign('profile_photo_small', $profile_photo_small );
$smarty->assign('profile_photo_medium', $profile_photo_medium );
$smarty->display('profile_father.tpl');

//We load here common foot application
$smarty->display('foot.tpl');
?>