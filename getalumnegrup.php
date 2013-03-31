
<?php
session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");

//We load here common header application

$utils = new utils();

$RSRC = array();
$VALS = array();

header("Content-Type: text/html;charset=utf-8");
$q=$_GET["q"];
$a=$_GET["txt"];

if($a=="false"){	
$VALS['ass']=$q;
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result_1 = $ConTut->Execute($RSRC['CONSULTA_ASSIGNATURA_GRUP']) or die($ConTut->ErrorMsg());




if(isset($result_1) && (count($result_1)>0)){
echo "<table border='0'>";
echo "<tr><td><b> alumnes:</b></td></tr>";
foreach ($result_1 as $row){
  echo "<tr>";
   $var1='"'.$row['codi_alumne'].'"';
  $var='"'.$row['codi_assignatura'].'"';
 // echo "<td><a href='controlador2.php?codi=".$row['codi_alumne']."'><img src='imatges/elim.gif' height=10px width=10px>&nbsp</a>"; 
 echo "<td><a href='#'  onclick='javascript:showAlumnes(".$var.",". $var1.");'><img src='imatges/elim.gif' height=10px width=10px></a>";
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
echo "<tr><td><b> alumnes:</b></td></tr>";
foreach ($result_1 as $row){
  echo "<tr>";
   $var1='"'.$row['codi_alumne'].'"';
  $var='"'.$row['codi_assignatura'].'"';
 // echo "<td><a href='controlador2.php?codi=".$row['codi_alumne']."'><img src='imatges/elim.gif' height=10px width=10px>&nbsp</a>"; 
 echo "<td><a href='#'  onclick='javascript:showAlumnes(".$var.",". $var1.");'><img src='imatges/elim.gif' height=10px width=10px></a>";
  echo "&nbsp".$row['nom']."</td>";
  echo "</tr>";
}
echo "</table>";
}else{
echo "no hi ha alumnes";
}

}
?> 
