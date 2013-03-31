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

$selecAlu=$_GET["prova"];
$div=$_GET["div"];

if($div=="0"){
echo "";
}
/*
* mostrem div per seleccionar els alumnes
*/

if(isset($selecAlu)){
// consulta a la base de dades per rellenar el select amb les optatives que contenen la paraula opt
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php");
$utils->p_dbg($RSRC, "Prova log");
$optGrup = $ConTut->Execute($RSRC['CONSULTA_GRUPS']) or die($ConTut->ErrorMsg());
	
?>
    <br>
     Selecciona grup:
    
    <select name="alumne" id="alumne" onChange="javascript:showAlu(this.value,'falseAlu','falseAlu');" >
    <option value="" selected> </option>
    <?php foreach ($optGrup as $row){
     echo "<option value='".$row['codi_grup']."'> ".html_entity_decode($row['codi_grup'])."</option>";} ?>	
    </select>
    
<?php
}?>