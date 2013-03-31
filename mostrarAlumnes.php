<?php 

$grup= $_GET["grup"];

session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");
$dngrup = cercaGrup($grup);

$ldapconfig['host'] = _LDAP_SERVER;
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] =   'cn=admin,dc=iesebre,dc=com';
		
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
$password=_LDAP_PASSWORD;
$dn="cn=admin,dc=iesebre,dc=com";

if ($bind=ldap_bind($ds, $dn, $password)) {
} else {
	# Error
}

$dn=$dngrup;

$search = ldap_search($ds, $dn, "sn=*") or die ("Search failed");
$info = ldap_get_entries($ds, $search);

$i=0;

foreach($info as $row){
$ass[$i]=$row["sn"][0];
$resul[$i]["nom"]=strtoupper($row["givenname"][0]);
$resul[$i]["sn1"]=strtoupper($row["sn1"][0]);
$resul[$i]["dni"]=$row["irispersonaluniqueid"][0];
$resul[$i]["codi"]=$row["employeenumber"][0];
$resul[$i]["complet"]=$resul[$i]["sn"] .", ".$resul[$i]["nom"] ." ". $resul[$i]["dni"] ;

$i++;
}

array_multisort($ass,SORT_ASC,$resul);


echo "<b>Seleccioneu un alumne: </b><select name='alumne' id='alumne'>";
echo "<option value='' selected></option>";
       for($n=0; $n<$i; $n++){
        echo "<option value='".$resul[$n]['codi']."'> ".$resul[$n]['nom']." ".$resul[$n]["sn1"]."</option>";
		} 	
echo  "</select>";
echo "&nbsp;&nbsp;";
echo "<input type='hidden' value='validar' name='validar'>";
echo "<input type='submit' value='validar'>";

?>