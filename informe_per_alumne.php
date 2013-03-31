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
/*$utils = new utils();

$RSRC = array();
$VALS = array();

$VALS['codi_professor'] = $_SESSION['codi_professor'];
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['GRUPS_INFORME_RESUM']) or die($ConTut->ErrorMsg());
$i=0;
foreach ($result as $row){
$var[$i]= $row['codi_grup'];
$i++;
}


$dngrup = cercaGrup($var[0]);


if($_SESSION['codi_professor'] =="52601122F"){
$ldapconfig['host'] = _LDAP_SERVER;
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] =   'cn=admin,dc=iesdeltebre,dc=net';
		
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
$password=_LDAP_PASSWORD;
$dn="cn=admin,dc=iesdeltebre,dc=net";

if ($bind=ldap_bind($ds, $dn, $password)) {
} else {
	# Error
}

 $dn="ou=Alumnes,ou=All,dc=iesdeltebre,dc=net";

$search = ldap_search($ds, $dn, "sn=*") or die ("Search failed");
$info = ldap_get_entries($ds, $search);	
	
}else{
$ldapconfig['host'] = _LDAP_SERVER;
#Només cal indicar el port si es diferent del port per defecte
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] =   'cn=admin,dc=iesdeltebre,dc=net';
		
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
$password=_LDAP_PASSWORD;
$dn="cn=admin,dc=iesdeltebre,dc=net";

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
//$resul[$i]=$row["dn"];
//$resul[$i]=$row["dn"];
//$resul[$i]=$row["dn"];
$i++;
}

array_multisort($ass,SORT_ASC,$resul);
/*
$VALS['dni']=$dni;
$VALS['number']=$number;
$VALS['data']=$int_data;
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['consulta_incidencia_pares']) or die($ConTut->ErrorMsg());
*/
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sin título</title>


<style type="text/css" title="currentStyle">
			@import "libs/DataTables/media/css/demo_page.css";
			@import "libs/DataTables/media/css/demo_table.css";
			@import "libs/DataTables/examples/TableTools/media/css/TableTools.css";
</style>
		<script type="text/javascript" charset="utf-8" src="libs/DataTables/media/js/jquery.js"></script>
		<script type="text/javascript" charset="utf-8" src="libs/DataTables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8" src="libs/DataTables/examples/TableTools/media/js/ZeroClipboard.js"></script>
		<script type="text/javascript" charset="utf-8" src="libs/DataTables/examples/TableTools/media/js/TableTools.js"></script>
			<script type="text/javascript" charset="utf-8">
				$(document).ready( function () {
			$('#example').dataTable( {
				"sDom": 'T<"clear">lfrtip',
				"oTableTools": {
					"sSwfPath": "libs/DataTables/examples/TableTools/media/swf/copy_csv_xls_pdf.swf"
				}
			} );
		} );
		</script>



<script type="text/javascript">
	var bas_cal,dp_cal,ms_cal;      
	window.onload = function () {
	  dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('popup_container'));
	};

	function showGrup(str){


		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
					document.getElementById("textAlumnes").innerHTML=xmlhttp.responseText;
			}
		  }
		
		xmlhttp.open("GET","mostrarAlumnes.php?grup="+str,true);
		xmlhttp.send();

	}
</script>


</head>

<body>
<div class="contenedor_pestañes" style="overflow:inherit; min-height:760px; height:auto;"><br>

<h3 style="color:#039">Selecciona un grup i un usuari per cercar: </h3>


<?php 

/*
*  consulta per cercar el grup
*/
$RSRC = array();
$VALS = array();

$utils->get_global_resources($RSRC, "db/sql_query.php");
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['consulta_grup']) or die($ConTut->ErrorMsg());


?>


<form name="usuari" action="informe_per_alumne.php" method="post">
<table id="table3" align="center" style=" background:#C2DBEB; -moz-border-radius: 50px;
border-radius: 20px; width:1000px;">
 
    <tr>
    <td></td>
    <td><b>Seleccioneu un grup: </b><select name="grup" id="grup" onChange="showGrup(this.value);">
       <option value="" selected></option>
	   <?php 
       foreach($result as $row){
        echo "<option value='".$row['codi_grup']."'> ".$row['codi_grup']." - ".$row['nom_grup']."</option>";
		} ?>	
     
    </select></td>
    <td style="width:14"></td>
    <td><div id="textAlumnes" class="textAlumnes"></div></td>
    </tr>
</table>
</form>



<?php if(isset($_POST['validar'])){

$codi_grup=$_POST['grup'];
$codi_alumne=$_POST['alumne'];


$dngrup = cercaGrup($codi_grup);

$ldapconfig['host'] = _LDAP_SERVER;
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

$search = ldap_search($ds, $dn, "employeenumber=".$codi_alumne) or die ("Search failed");
$info = ldap_get_entries($ds, $search);

$VALS['codi_alumne'] = $info[0]['employeenumber'][0];

$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['FALTES_USER']) or die($ConTut->ErrorMsg());


?>
<div style="text-align:left; position:relative;float:left; width:100" >&nbsp;</div>
<div id="container" style="width:1000px; position:relative;float:left; vertical-align:central" align="center">
<div id="demo"  align="center">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"  align="center">
	<thead>
    	<tr>
        <th colspan="6" style="text-align:left;">
        <div style="text-align:left; position:relative;float:left;" ><img src="imatges/logo_j_l.png" width="200px" height="80px"/></div>
        <div style="text-align:left; position:relative;float:left; width:200px" >&nbsp;</div>
        <div style="text-align:left; position:relative;float:left; " >
        <b>Nom:</b> <?php echo $info[0]['givenname'][0]." ".$info[0]["sn"][0]; ?><br/>
        <b>Dni:</b> <?php echo $info[0]["irispersonaluniqueid"][0];?><br/>
         
        </div>
        </th>
        </tr>
		<tr>
			<th>INCIDÈNCIA</th>
			<th>DATA</th>
			<th>DIA</th>
			<th>HORA</th>
			<th>ASSIGNATURA</th>
            <th>PROFESSOR</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>INCIDÈNCIA</th>
			<th>DATA</th>
			<th>DIA</th>
			<th>HORA</th>
			<th>ASSIGNATURA</th>
            <th>PROFESSOR</th>
		</tr>
	</tfoot>
	
   
    
    
    
    <tbody>
     <?php 
	foreach($result as $row2){
				$VALS['motiu_incidencia'] = $row2['motiu_incidencia'];
				$VALS['codi_dia'] = $row2['codi_dia'];
				$VALS['codi_hora'] = $row2['codi_hora'];
				$VALS['codi_assignatura'] = $row2['codi_assignatura'];
			
				$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
				$utils->p_dbg($RSRC, "Prova log");
				
				$result = $ConTut->Execute($RSRC['Consulta_motiu_incidencia']) or die($ConTut->ErrorMsg());
				$result_dia = $ConTut->Execute($RSRC['Consulta_dia']) or die($ConTut->ErrorMsg());
				$result_hora = $ConTut->Execute($RSRC['Consulta_hora']) or die($ConTut->ErrorMsg());
				$result_assignatura = $ConTut->Execute($RSRC['Consulta_assignatura']) or die($ConTut->ErrorMsg());
				
				foreach($result as $row){
				$motiu= $row['motiu_llarg'];
				}
				
				foreach($result_hora as $row){
				$hora= $row['hora_inici']." - ".$row['hora_final'];
				}
				
				foreach($result_dia as $row){
				$dia= $row['dia_llarg'];
				}
				/*foreach($result_assignatura as $row){
				$ass= $row['nom_assignatura'];
				}*/
		
		
		
		?>
		<tr class="odd_gradeX">
			<td><?php echo $motiu;?></td>
			<td><?php echo $row2['data_incidencia'];?></td>
			<td><?php
				echo $dia;
			?></td>
			<td><?php 
				echo $hora;
				?>
			</td>
			<td><?php echo $row2['codi_assignatura'];?></td>
            <td><?php echo $row2['nom_professor']." ".$row2['cognom1_professor'];?></td>
		</tr>
		<!--<tr class="even_gradeC">
			<td>Trident</td>
			<td>Internet Explorer 5.0</td>
			<td>Win 95+</td>
			<td class="center">5</td>
			<td class="center">C</td>
		</tr>
		<tr class="odd_gradeA">
			<td>Trident</td>
			<td>Internet Explorer 5.5</td>
			<td>Win 95+</td>
			<td class="center">5.5</td>
			<td class="center">A</td>
		</tr>-->
        <?php } ?>
	</tbody>
</table>
</div>
<div class="spacer"></div>

</div>

<?php 

}
?>



</div>
</body>
</html>