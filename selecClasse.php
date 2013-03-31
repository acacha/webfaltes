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


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="Stylesheet" href="css/styles.css" />
</head>
<body>
<div class="contenedor_pestañes">    
 <div id="menu">
    <br><br><br>
    <table style="border:0" align="center">
    <tr style="border:0" height="120"><td style="border:0">
    <a href="addClasse.php"><img src='imatges/add1.png' name="GESTIÓ CLASSES" height=75px width=75px> Afegir una nova classe</a>
    <br>
    </td></tr>
    <tr style="border:0" height="120"><td style="border:0">
    <a href="listClasse.php"><img src='imatges/list.png' name="GESTIÓ CLASSES" height=75px width=75px>Llistar classes existents</a>
    </td></tr>
    </table>

</div>
</body>
</html>