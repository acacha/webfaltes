
<?php
header("Content-Type: text/html;charset=utf-8");
session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");


// variables per fer consulta a la bd
$utils = new utils();
$RSRC = array();
$VALS = array();


// recuperem les variables enviades de selecalumgrup2
$q=$_GET["q"];
if(isset($_GET["q"])){
$_SESSION['q']=$_GET["q"];
}
$a=$_GET["txt"];
$ass=$_GET["ass"];
$txtass=$_GET["txtass"];
$txtalu=$_GET["txtalu"];



/*
* mostrem div per seleccionar els alumnes
*/


/*
* opció optativa, if false ve del select i no eliminem res, else ve del polsar eliminar alumne i esborrem alumne de la llista.  
*/
if(isset($q)){
if($a=="falseOpt"){	
$VALS['ass']=$q;
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result_1 = $ConTut->Execute($RSRC['CONSULTA_ASSIGNATURA_GRUP']) or die($ConTut->ErrorMsg());




if(isset($result_1) && (count($result_1)>0)){
echo "<table border='0'>";
echo "<tr><td><b> Alumnes optativa:</b></td></tr>";
foreach ($result_1 as $row){
  echo "<tr>";
   $var1='"'.$row['codi_alumne'].'"';
  $var='"'.$row['codi_assignatura'].'"';
 // echo "<td><a href='controlador2.php?codi=".$row['codi_alumne']."'><img src='imatges/elim.gif' height=10px width=10px>&nbsp</a>"; 
 echo "<td><a href='#'  onclick='javascript:showOpt(".$var.",". $var1.");'><img src='imatges/elim.gif' height=10px width=10px></a>";
  echo "&nbsp".$row['nom']."</td>";
  echo "</tr>";
}
echo "</table>";
}else{
echo "no hi ha alumnes";
}
}else{

$VALS['ass']=$q;
$VALS['alu']=$a;	

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result_1 = $ConTut->Execute($RSRC['ELIMINAR_ALUMNE_GRUP']) or die($ConTut->ErrorMsg());

$VALS['ass']=$q;
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result_1 = $ConTut->Execute($RSRC['CONSULTA_ASSIGNATURA_GRUP']) or die($ConTut->ErrorMsg());




if(isset($result_1) && (count($result_1)>0)){
echo "<table border='0'>";
echo "<tr><td><b> Alumnes optativa:</b></td></tr>";
foreach ($result_1 as $row){
  echo "<tr>";
   $var1='"'.$row['codi_alumne'].'"';
  $var='"'.$row['codi_assignatura'].'"';
 // echo "<td><a href='controlador2.php?codi=".$row['codi_alumne']."'><img src='imatges/elim.gif' height=10px width=10px>&nbsp</a>"; 
 echo "<td><a href='#'  onclick='javascript:showOpt(".$var.",". $var1.");'><img src='imatges/elim.gif' height=10px width=10px></a>";
  echo "&nbsp".$row['nom']."</td>";
  echo "</tr>";
}
echo "</table>";
}else{
echo "no hi ha alumnes";
}

}
}

if(isset($ass)){
if($txtass == "falseAlu"){
	
	/*
	* configuració de ldap per cercar els alumnes d'un grup 
	*/
	
	$dngrup = cercaGrup($ass);
	$ldapconfig['host'] = _LDAP_SERVER;
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = $dngrup;	
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);	
	$password=_LDAP_PASSWORD;
	$dn=_LDAP_USER;
	if ($bind=ldap_bind($ds, $dn, $password)) {
	} else {
		# Error
	}
	$filter = "(objectClass=inetOrgPerson)";
	$search = ldap_search($ds, $ldapconfig['basedn'], $filter) or die ("Search failed");
	$info = ldap_get_entries($ds, $search);


	/*
	* taula que és mostra incialment amb tots els alumnes d'un grup
	*/
	echo "<table border='0'>";
	echo "<tr><td><b> Alumnes grup:</b></td></tr>";
    
	//declarem variables necessaries per a les funcions javascript
	$ass='"'.$ass.'"';
	$op='"'.$_SESSION['q'].'"';
	$tt="falseOpt";
	$text='"'.$tt.'"';
	
	//recorrem els alumnes un per un 
	for($i=0; $i<count($info); $i++) {
	     $var1='"'.$info[$i]['employeenumber'][0].'"';
	     $var='"'.$info[$i]['cn'][0].'"';
		 echo "<tr>";
		 echo "<td><a href='#'  onclick='javascript:showAlu(".$ass.",".$var1.",". $var."); javascript:showOpt(".$op.",".$text.");'><img src='imatges/Add.png' height=13px width=13px></a>";
		 echo "&nbsp".$info[$i]['cn'][0]."</td>";
		 echo "</tr>";
	}
	echo "</table>";


}else{

	/*
	* consulta a la base de dades per insertar alumne dintre d'un grup
	*/
	$VALS['optativa']=$_SESSION['q'];
	$VALS['number']=$txtass;	
	$VALS['cn']=$txtalu;
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	$utils->p_dbg($RSRC, "Prova log");
	$result_1 = $ConTut->Execute($RSRC['ADD_ALUMNE_GRUP']) or die($ConTut->ErrorMsg());
	
	
	/*
	* configurem ldap per cercar l'alumne, fem la funció cercar grup i ens retorna el path del grup
	*/
	$dngrup = cercaGrup($ass);
	$ldapconfig['host'] = _LDAP_SERVER;
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = $dngrup;	
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);	
	$password=_LDAP_PASSWORD;
	$dn=_LDAP_USER;
	if ($bind=ldap_bind($ds, $dn, $password)) {
	} else {
		# Error
	}
	$filter = "(objectClass=inetOrgPerson)";
	$search = ldap_search($ds, $ldapconfig['basedn'], $filter) or die ("Search failed");
	$info = ldap_get_entries($ds, $search);


	// declarem variables fixec
	$ass='"'.$ass.'"';
	$op='"'.$_SESSION['q'].'"';
	$tt="falseOpt";
	$text='"'.$tt.'"';



echo "<table border='0'>";
echo "<tr><td><b> Alumnes grup:</b></td></tr>";
	for($i=0; $i<count($info); $i++) {
	echo "<tr>";
	$var1='"'.$info[$i]['employeenumber'][0].'"';
	$var='"'.$info[$i]['cn'][0].'"';
	echo "<td><a href='#'  onclick='javascript:showAlu(".$ass.",".$var1.",". $var."); javascript:showOpt(".$op.",".$text.");'><img src='imatges/Add.png' height=13px width=13px></a>";
	echo "&nbsp".$info[$i]['cn'][0]."</td>";
	echo "</tr>";
	}
echo "</table>";

}
}


?> 
