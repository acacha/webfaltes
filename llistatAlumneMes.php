<?php
header('Content-Type: text/html; charset=UTF-8');
?>

<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
* Copyright (c) 2010, Sergi Tur Badenas _Carles A–—
* autor: Josep Llaó Angelats
*
*/

// Session managment
session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");

//We load here common header application
require_once _INCLUDES.'common-header.php';
$utils = new utils();

$RSRC = array();
$VALS = array();

$VALS['codi_professor'] = $_SESSION['codi_professor'];
$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['GRUPS_INFORME_RESUM']) or die($ConTut->ErrorMsg());
$i=0;
foreach ($result as $row){
$var[$i]= $row['codi_grup'];
$i++;
}


$dngrup = cercaGrup($var[0]);


if (isset($_SESSION['es_coordinador']) && $_SESSION['es_coordinador'] != 0){

$ldapconfig['host'] = _LDAP_SERVER;
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] =   _LDAP_USER;
		
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
$password=_LDAP_PASSWORD;
$dn=_LDAP_USER;

if ($bind=ldap_bind($ds, $dn, $password)) {
} else {
	# Error
}

 $dn="ou=Alumnes,ou=All,dc=iesebre,dc=com";

$search = ldap_search($ds, $dn, "sn=*") or die ("Search failed");
$info = ldap_get_entries($ds, $search);	
	
}else{
$ldapconfig['host'] = _LDAP_SERVER;
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] = _LDAP_USER;
		
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
$password=_LDAP_PASSWORD;
$dn= _LDAP_USER;

if ($bind=ldap_bind($ds, $dn, $password)) {
} else {
	# Error
}

 $dn=$dngrup;

$search = ldap_search($ds, $dn, "sn=*") or die ("Search failed");
$info = ldap_get_entries($ds, $search);
}
$i=0;

foreach($info as $row){
$ass[$i]=$row["sn"][0];
$resul[$i]["nom"]=strtoupper($row["givenname"][0]);
$resul[$i]["sn"]=strtoupper($row["sn"][0]);
$resul[$i]["dni"]=$row["irispersonaluniqueid"][0];
$resul[$i]["complet"]=$resul[$i]["sn"] .", ".$resul[$i]["nom"] ." ". $resul[$i]["dni"] ;

$i++;
}

array_multisort($ass,SORT_ASC,$resul);


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
</head>
<body>

<div class="contenedor_pestañes">


<h1>SELECCIONA UN ALUMNE</h1>


<form name="el_data" action="llistatAlumneMes2.php" method="post">
<select name="alumne" id="alumne">
<?php 
foreach ($resul as $row){?>
   <option value='<?php echo $row['dni'];?>'><?php echo $row['complet'];?> </option>
 <?php } ?>
</select>
<input type="submit" value="validar">
</form>

</div>
</body>
</html>

