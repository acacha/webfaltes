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
require_once _INCLUDES.'common-header.php';
?>
<html>
<head>
<script language="javascript">

function showRadioAss(str){
if (str==""){
  document.getElementById("radioAss").innerHTML="";
  return;
  }
if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else{// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		    document.getElementById("radioAss").innerHTML=xmlhttp.responseText;
	}
  }
xmlhttp.open("GET","controlador2.php?rass="+str,true);
xmlhttp.send();
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="Stylesheet" href="css/styles.css" />
</head>
<body>
<div class="contenedor_pestañes">

	<!-- div que mostra el menú i selecciona la classe-->
    <div id="menu">
    <br><br><br>
    <table style="border:0" align="center">
    <tr style="border:0" height="100"><td style="border:0">
    <a href="#" style="text-decoration:none" onClick="javascript:showRadioAss('selecRadioASS');"> <img src='imatges/archive.png'  name="GESTIÓ ASSIGNATURES" height=50px width=50px>GESTIÓ ASSIGNATURES</a>
		<div id="radioAss" class="radioAss">
		</div>
    </td></tr>
    <tr style="border:0" height="100"><td style="border:0">
    <a href="selecClasse.php"><img src='imatges/archive.png' name="GESTIÓ CLASSES" height=50px width=50px>GESTIÓ CLASSES</a>
    </td></tr>
    <tr style="border:0" height="100"><td style="border:0">
    <a href="selecalumgrup2.php"><img src='imatges/archive.png' name="GESTIÓ ALUMNES (OPT-UF)" height=50px width=50px>GESTIÓ ALUMNES (OPT-UF)</a>
    </td></tr>
    
    </div>


</div>
</body>
</html>