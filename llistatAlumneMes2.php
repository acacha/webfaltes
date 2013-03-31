


<?php
header('Content-Type: text/html; charset=UTF-8');
?>

<?php
/*
* @autho Josep Llaó Angelats
* @name consergeAlumne.php
* @desc Check Attendance
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
if(isset($_POST['alumne'])){
$_SESSION['alumne']=$_POST['alumne'];

}
$dniAlumne=$_SESSION['alumne'];

   
$ldapconfig['host'] = _LDAP_SERVER;
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] =  _LDAP_USER;

$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

$password=_LDAP_PASSWORD;
$dn=_LDAP_USER;
			
	if ($bind=ldap_bind($ds, $dn, $password)) {
	}else{
	# Error
	}

$search = ldap_search($ds, "ou=Alumnes,ou=All,dc=iesebre,dc=com","irispersonaluniqueid=".$dniAlumne) or die ("Search failed");
$info = ldap_get_entries($ds, $search);
	
$cn=$info[0]['cn'][0];
$dni=$dniAlumne;
$number=$info[0]['employeenumber'][0];
	
if(isset($_POST['data'])){
	$int_data =date("Y-m-d", strtotime($_POST['data']));
}else{
	$int_data = strftime( "%Y-%m-%d", time());
}


	

$VALS['dni']=$dni;
$VALS['number']=$number;
$VALS['data']=$int_data;
$utils->get_global_resources($RSRC, "db/sql_query.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['consulta_incidencia_conserges_list']) or die($ConTut->ErrorMsg());




$var_mes['January']=Gener;
$var_mes['February']=Febrer; 
$var_mes['March']=Març; 
$var_mes['April']=Abril; 
$var_mes['May']=Maig;
$var_mes['June']=Juny;
$var_mes['July']=Juliol; 
$var_mes['August']=Agost; 
$var_mes['September']=Setembre; 
$var_mes['October']=Octubre;
$var_mes['November']=Novembre; 
$var_mes['December']=Desembre;
$var_dia['Monday']=Dilluns;
$var_dia['Tuesday']=Dimarts;
$var_dia['Wednesday']=Dimecres;
$var_dia['Thursday']=Dijous;
$var_dia['Friday']=Divendres;
$var_dia['Saturday']=Dissabte;
$var_dia['Sunday']=Diumenge;


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sin título</title>
<script type="text/javascript">
var bas_cal,dp_cal,ms_cal;      
window.onload = function () {
  dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('popup_container'));
};
</script>
</head>

<body>
<div class="contenedor_pestañes"><br>

<h1>INCIDÈNCIES DE FALTES ASSISTÈNCIA:</h1>
<!-- Mostrar dni i nom de l'alumne-->

<?php 

$dia_mes= date("F", strtotime($int_data));
echo "<b>DNI: </b>".$dni.",  <b>NOM:</b> ".$cn.",  <b>MES:</b> ".$var_mes[$dia_mes];
 ?>
<br><br>

<?php 
if(isset($_POST['data'])){
	$int_mes =date("m", strtotime($_POST['data']));
	$int_any =date("y", strtotime($_POST['data']));
}else{
	$int_mes = strftime( "%m", time());
	$int_any = strftime( "%Y", time());
}
?>

<div name="pdf" style="float:right"><a href='informe_Mes_alumne.php?dniAlumne=<?php echo $dniAlumne;?>&mes=<?php echo $int_mes;?>&any=<?php echo $int_any;?>&data=<?php echo $int_data;?>' style=" float:right"><img src="imatges/pdf.png" width="35" height="35"/>&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<!-- mostrar calendari -->
<form name="el_data" action="llistatAlumneMes2.php" method="post">
 Escollir una data (forma dd-mm-aaaa):

 <input id="popup_container" type="text" name="data" value="<?php echo $TODAY;?>"/>
 <input type="hidden" name="group" value="$GROUP_CODE"> 
 <input type="submit" value="Canviar">
</form>


<?php
function getMonthDays($Month, $Year)
{
   //Si la extensión que mencioné está instalada, usamos esa.
   if( is_callable("cal_days_in_month"))
   {
      return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
   }
   else
   {
      //Lo hacemos a mi manera.
      return date("d",mktime(0,0,0,$Month+1,0,$Year));
   }
}
//Obtenemos los dias


$varMes= getMonthDays($int_mes, $int_any);
$hours_Mati= array('08:00','09:00','10:00','11.30','12.30','13.30');
$hours_tarde= array('15:30','16:30','17:30','19.00','20.00','21.00');
$days=array('1','2','3','4','5');
$trobat="false";

if(isset($result) || isset($result[0]['hora_inici'])){
$hours=$hours_Mati;
}else{
foreach($result as $row){
	foreach($hours_Mati as $hrow){
		if($row['hora_inici']==(int)$hrow){
		$trobat="true";
		}
	}
	if($trobat=="true"){
	$hours=$hours_Mati;
	}else{
	$hours=$hours_tarde;
	}
	
}}


?>


<table align="center">
<tr><thead><th></th>
<?php 
foreach($hours as $hrow){
echo "<th style='min-width:100px'>".$hrow."</th>";
}
?>
</thead></tr>
<?php for($i=1; $i<=$varMes; $i++){?>

<tr>
<?php $dia=date("l",mktime(0,0,0,$int_mes,$i,$int_any));
if($var_dia[$dia]=="Diumenge" || $var_dia[$dia]=="Dissabte"){?>
	<td BGCOLOR="#7db9e8"><?php
 	echo "<b>".$var_dia[$dia].", ".$i."</b>";?></td>
	<?php foreach($hours as $hrow){
		echo "<td bgcolor='#7db9e8'></td>";
		}
}else{
?>
<td><?php

 	echo "<b>".$var_dia[$dia].", ".$i."</b>";?></td>
	<?php foreach($hours as $hrow){
		$varB=0;
		foreach($result as $row){
			$my_mes =date("d", strtotime($row['data_incidencia']));
			if(($i==(int)$my_mes) && ($row['hora_inici']==(int)$hrow)){
				echo "<td style='max-width:150'>";
				echo "<b>".$row['codi_assignatura']."</b><br>".$row['motiu_llarg']."<br>".$row['observacions'];
				echo "</td>";
				$varB=1;
			}
		}
		if($varB==0){
		echo "<td></td>";
		}
	}
}
echo "</tr>";
}?>

<tr><tfoot>
        <th colspan=" <?php echo count($hours)+1;?> " align="center">
        <form method="post" action="llistatAlumneMes.php">
        <input type="submit" name="enviat" value="Return">
        </form>
        </th>
    </tr>
    </tfoot>

</table>

</div>
</body>
</html>


