<?php
/*
 Variables de la plantilla index.tpl
 @ title				Web page's title
 @ HEADER_LOGO_PATH		Path to header logo
 @ user_name			User name to show at header
 @ time					Current time
 @ menu_options			Associative array with menu options names and URLs
 */

//Localització i internacionalització
//header('Content-Type: text/html; charset=UTF-8'); 
?>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<script language="javascript" type="text/javascript" src="/javascript/jquery/jquery.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
$(".stripeMe tr").mouseover(function(){
$(this).addClass("over");
});
$(".stripeMe tr").mouseout(function(){
$(this).removeClass("over");
});
$(".stripeMe tr:even").addClass("alt");
});
</script>

<style type="text/css">

tr.alt td
{
	background: #A9D0F5;
}

tr.over td
{
	background: #81BEF7;
}

a:link {
	text-decoration: none;
	/*border-bottom: 1px dotted #f60;
	color: #f60;*/
	font-weight: bold;
}

</style>

<?php

require_once _INCLUDES.'localization.php';

$smarty->assign('title', "Control d'incidències");

$user_name=null;
$user_type=null;
$user_code=null;
$user_loginname=null;
if(trim($_SESSION['S_stop'])  == "0" ) {
	if(($_SESSION['user_type'])  == "professor")
	{
		$user_name=nom_profe($_SESSION['usuari'], $ConTut);
		$show_profile=_BASE_PATH_HTML.'/profile.php';
		$user_type="Professor";
		$user_code=$_SESSION['codi_professor'];
		$user_loginname=$_SESSION['usuari'];
	}
	if(($_SESSION['user_type'])  == "alumne")
	{
		$user_name=nom_alumne($_SESSION['codi_alumne'], $ConTut);
		$show_profile=_BASE_PATH_HTML.'/profile_student.php';
		$user_type="Alumne";
		$user_code=$_SESSION['usuari'];
		$user_name=$_SESSION['usuari'];
	}
	/*if(($_SESSION['user_type'])  == "pare")
	{
		$user_name=nom_pare($_SESSION['codi_pare'], $ConTut);
		$show_profile=_BASE_PATH_HTML.'/profile_father.php';
		$user_type="Pare/Mare";
		$user_code=$_SESSION['codi_pare'];
		$user_name=$_SESSION['usuari'];
	}*/
	if(($_SESSION['user_type'])  == "responsable")
	{
		//$user_name=nom_pare($_SESSION['codi_pare'], $ConTut);
		$show_profile=_BASE_PATH_HTML.'/responsable.php';
		$user_name=$_SESSION['cn'];
		//$user_type="Pare/Mare";
		//$user_code=$_SESSION['codi_pare'];
		//$user_name=$_SESSION['usuari'];
	}
	
}
if ($user_name != null) {
	$smarty->assign('user_name',$user_name);
	$smarty->assign('show_profile',$show_profile);
}

$smarty->assign('HEADER_LOGO_PATH',_HEADER_LOGO_PATH);
$smarty->assign('LOGO_ACCES_PROFILE_PATH',_LOGO_ACCES_PROFILE_PATH);


$smarty->assign('time',strftime("%A, %d de %B de %Y, %R"));

if(trim($_SESSION['S_stop'])  == "0" ) {
	$menu_options=array();
	$menu_options = array();
	if(($_SESSION['user_type'])  != "responsable")
	{
		$menu_options[_BASE_PATH_HTML.'/index.php'] = _('Check Attendance');
	}

	if (isset($_SESSION['num_grups_tutor'])) {
		if($_SESSION['num_grups_tutor'] >= 1 || $_SESSION['es_coordinador']){
			$menu_options[_BASE_PATH_HTML.'/tutoria.php'] = T_('Tutorship');
		}	
	}
	
	if (isset($_SESSION['es_coordinador'])) {
		if ($_SESSION['es_coordinador']) {
			$menu_options[_BASE_PATH_HTML.'/menuAdministrar.php'] = T_('Administrar');
			$administrar="true";
			
		
			
			
			
			//$menu_options[_BASE_PATH_HTML.'/administrar.php'] = T_('Administration');
		}
	}	
	
	if(($_SESSION['user_type'])  == "responsable")
	{
		//$menu_options[_BASE_PATH_HTML.'/responsable.php'] = T_('Absences');
		//$menu_options[_BASE_PATH_HTML.'/surveys/websurveys.php'] = T_('Surveys');
	}
	else
	{
		
		//$menu_options[_BASE_PATH_HTML.'/surveys/websurveys.php'] = T_('Surveys');
		$menu_options[_BASE_PATH_HTML.'/selec_informe.php'] = T_('Reports');
	}

	$menu_options[_BASE_PATH_HTML.'/index.php?stop=1'] = T_('Close Session');
	$user=$_SESSION['usuari'];
	
	if (isset($_SESSION['substitut'])) {
		$codi_profe_substituit = $_SESSION['codi_substituit'];
		$text="Substitut profe ". $codi_profe_substituit ;
		$smarty->assign('substitut', $text );
		$smarty->assign('user_code', $_SESSION['codi_professor_real']);
	} else {
		$smarty->assign('user_code', $user_code);
	}
	$smarty->assign('user_type', $user_type);
	$smarty->assign('user_name', $user_name);
	$smarty->assign('user_loginname', $user_loginname);
	$smarty->assign('user', $user);
	$smarty->assign('menu_options', $menu_options);
}

$smarty->assign('first_level_url', $first_level_url);
$smarty->assign('second_level_url', $second_level_url);
$smarty->assign('third_level_url', $third_level_url);
$smarty->assign('name_of', $name_of);
$smarty->assign('name_of2', $name_of2);
$smarty->assign('administrar', $administrar);
/*
echo "<a class='molletes' href=".$first_level_url.">Inici</a>";
if($second_level_url)
{
echo " > ";
echo "<a class='molletes' href=".$second_level_url.">$name_of</a>";
}

if($third_level_url)
{
echo " > ";
echo "<a class='molletes' href=".$third_level_url.">$name_of2</a>";
}
*/

$smarty->display('index.tpl');


?>
