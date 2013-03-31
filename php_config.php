<?php
include_once("funcions.php");
include_once("funcions_ldap.php");

//ADODB
if (!is_readable("/usr/share/php/adodb/adodb.inc.php")){
    echo "<div style='background-color: #FFCCCC;border: 2px solid #FF0000;margin: 0 10px 10px;
    padding: 10px;text-align: center;'><b>ERROR!</b> No existeix la llibreria adodb.inc.php, fitxer: <b>   
    /usr/share/php/adodb/adodb.inc.php</b><br/> No podreu utilitzar la connexió a base de dades de l'aplicació
    fins que no instal·leu aquesta llibreria .Consulteu la 
    <a href=\"http://acacha.org/mediawiki/index.php/Webfaltes#Instal.C2.B7lar_depend.C3.A8ncies\">
    documentació de l'aplicació</a></div>"; 
}
else    {
    require_once("/usr/share/php/adodb/adodb.inc.php");
} 
//include_once("/usr/share/php/adodb/adodb.inc.php");


//Localization
include_once _INCLUDES.'localization.php';

//Smarty
//check smarty
if (!is_readable("/usr/share/php/smarty3/Smarty.class.php")){
	if (!is_readable("/usr/share/php/smarty/Smarty.class.php")){
		echo "<div style='background-color: #FFCCCC;border: 2px solid #FF0000;margin: 0 10px 10px;
    	padding: 10px;text-align: center;'><b>ERROR!</b> No existeix la llibreria Smarty3 ni/o Smarty, fitxers: <b>
		/usr/share/php/smarty3/Smarty.class.php,/usr/share/php/smarty/Smarty.class.php</b><br/> Consulteu la 
		<a href=\"http://acacha.org/mediawiki/index.php/Webfaltes#Instal.C2.B7lar_depend.C3.A8ncies\">
		documentació de l'aplicació</a></div>";
		exit();	
	}
	else {
		require_once("/usr/share/php/smarty/Smarty.class.php");
	}
} else {	
	require_once("/usr/share/php/smarty3/Smarty.class.php");
}
#Check smarty compile dir
if (!is_writable("/var/spool/webfaltes")){
	echo "<div style='background-color: #FFCCCC;border: 2px solid #FF0000;margin: 0 10px 10px;
    padding: 10px;text-align: center;'><b>ERROR!</b> No existeix la carpeta: <b>
	/var/spool/gosa </b> o no és modificable per l'usuari www-data.<br/> Consulteu la 
	<a href=\"http://acacha.org/mediawiki/index.php/Webfaltes#Configuraci.C3.B3_d.27Smarty\">
	documentació de l'aplicació</a></div>";	
	exit();
}

global $smarty;
$smarty = new Smarty();

//FPDF
if (!is_readable("/usr/share/php/fpdf/fpdf.php")){
	echo "<div style='background-color: #FFCCCC;border: 2px solid #FF0000;margin: 0 10px 10px;
    padding: 10px;text-align: center;'><b>ERROR!</b> No existeix la llibreria FPDF, fitxer: <b>
	/usr/share/php/fpdf/fpdf.php</b><br/> No podreu imprimir informes en PDF fins que 
	no instal·leu aquesta llibreria .Consulteu la 
	<a href=\"http://acacha.org/mediawiki/index.php/Webfaltes#Instal.C2.B7lar_depend.C3.A8ncies\">
	documentació de l'aplicació</a></div>";	
}
else	{
	require_once("/usr/share/php/fpdf/fpdf.php");
}  

include_once("informe_pdf.php");

//SMARTY
$smarty->template_dir = _SMARTY_TEMPLATES_FOLDER;
$smarty->compile_dir = _SMARTY_TEMPLATES_C_FOLDER;
$smarty->caching= false;
//No cal
//$smarty->config_dir = _SMARTY_CONFIGS_FOLDER;

//MySQL connection
include_once(_CONFIG_DIR."/"._MYSQL_CONNECTION_FILE);
//Ldap connection
include_once(_CONFIG_DIR."/"._LDAP_CONNECTION_FILE);



/// Establim paràmetres regionals en català dies, hora, moneda, numérics
// ca -> Català spS -> Castellà ..... (en windows)
// Alerta! Definicions diferents per a Windows i Linux
//setlocale(LC_ALL,"ca");  // Definició per a Windows
setlocale(LC_ALL,"ca_ES"); // Definició per a Linux
?>