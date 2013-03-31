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
<br><br><br>
    <div id="panel 1">
<?php 
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php");
$utils->p_dbg($RSRC, "Prova log");
$grupBD = $ConTut->Execute($RSRC['CONSULTA_GRUPS']) or die($ConTut->ErrorMsg());
$assBD = $ConTut->Execute($RSRC['CONSULTA_ASSIGNATURA']) or die($ConTut->ErrorMsg());
$diaBD = $ConTut->Execute($RSRC['CONSULTA_DIA']) or die($ConTut->ErrorMsg());
$horaBD = $ConTut->Execute($RSRC['CONSULTA_HORA']) or die($ConTut->ErrorMsg());
$llicoBD = $ConTut->Execute($RSRC['CONSULTA_LLICO']) or die($ConTut->ErrorMsg());


$ldapconfig['host'] = _LDAP_SERVER;
$ldapconfig['port'] = _LDAP_PORT;
$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;

$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

$password=_LDAP_PASSWORD;
$dn=_LDAP_USER;
				

$grup=$_GET["codi_grup"];
$llico=$_GET['codi_llico'];
$assignatura=$_GET['codi_assignatura'];
$professor=$_GET['codi_professor'];
$dia=$_GET['codi_dia'];
$hora=$_GET['codi_hora'];
$aula=$_GET['codi_aula'];
?>
<form action="controlador2.php" name="modificar" method="post">

<input type="hidden" name="llicoHI" value="<?php echo $llico;?>">
<input type="hidden" name="assignaturaHI"  value="<?php echo $assignatura;?>">
<input type="hidden" name="professorHI" value="<?php echo $professor;?>">
<input type="hidden" name="aulaHI"  value="<?php echo $aula;?>">
<input type="hidden" name="grupHI"  value="<?php echo $grup;?>">
<input type="hidden" name="diaHI" value="<?php echo $dia;?>">
<input type="hidden" name="horaHI" value="<?php echo $hora;?>">

 <table id="table3" align="center">
    
    <tr>
    <td>CODI LLIÇO:</td>
    <td><input type="text" name="llico" value="<?php echo $llico;?>"></td>
    </tr>
    <td>CODI GRUP:</td>
    <td><select name="grup" id="grup">
    <?php foreach ($grupBD as $row){
	if($row['codi_grup']== $grup){?>
	<option value="<?php echo $row['codi_grup'];?>" selected> <?php echo $row['nom_grup'];?></option>
	<?php }else{
	?>
     <option value="<?php echo $row['codi_grup'];?>"> <?php echo $row['nom_grup'];?></option>
    <?php }}?>
    </select>	</td>
    </tr>
    <tr>
    <td>CODI PROFESSOR:</td>
    <td>
    <?php 
	if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
		$search=@ldap_search($ds, $ldapconfig['basedn'],'sn=*');
		$info = ldap_get_entries($ds, $search);
		?>
		<select name="profesModificar" id="profesModificar">

		<?php foreach ($info as $row){
		if(isset($row['employeenumber'][0])){
			if(($row['employeenumber'][0])==$professor){
			?><option value="<?php echo $row['employeenumber'][0];?>" selected> <?php echo $row['cn'][0];?></option><?php
			}else{
		?>
        
		 <option value="<?php echo $row['employeenumber'][0];?>"> <?php echo $row['cn'][0];?></option>
		<?php }}}?>
		</select>
		<?php
		}
	}
	?>
    </td>
    </tr>
    <tr>
    <td>CODI ASSIGNATURA:</td>
    <td>
    <select name="assignatura" id="assignatura" >
    <?php 
	foreach ($assBD as $row){
	if(isset( $row['codi_assignatura'])){
		if($row['codi_assignatura']==$assignatura){
		?><option value="<?php echo $row['codi_assignatura'];?>" selected> <?php echo utf8_encode($row['nom_assignatura']);?></option><?php
		}else{
	?>
     <option value="<?php echo $row['codi_assignatura'];?>"> <?php echo utf8_encode($row['nom_assignatura']);?></option>
    <?php }}}?>
    </select>	
    </td>
    </tr>
    <tr>
    <td>CODI AULA:</td>
     <td><input type="text" name="aula" value="<?php echo $aula;?>"></td>
    </tr>
    <tr>
    <td>CODI DIA:</td>
    <td>
     <select name="dia" id="dia" >
    <?php foreach ($diaBD as $row){
    if($codi_dia==$row['codi_dia']){?>
	<option value="<?php echo $row['codi_dia'];?>" selected> <?php echo $row['dia_llarg'];?></option>	
	<?php }else{?>
     <option value="<?php echo $row['codi_dia'];?>"> <?php echo $row['dia_llarg'];?></option>
    <?php }}?>
    </select>	
    </td>
    </tr>
    <tr>
    <td>CODI HORA:</td>
    <td>
     <select name="hora" id="hora" >
    <?php foreach ($horaBD as $row){
    if($hora==$row['codi_hora']){?>
    <option value="<?php echo $row['codi_hora'];?>" selected> <?php echo $row['hora_inici']." - ". $row['hora_final'];?></option>
    <?php }else{?>
     <option value="<?php echo $row['codi_hora'];?>"> <?php echo $row['hora_inici']." - ". $row['hora_final'];?></option>
    <?php }}?>
    </select>	
    </td>
    </tr>
    <tr>
    <td></td>
    <td><input type="submit" value="validar"></td>
    </tr>
    </table>
</form>

</div>
</div>
</body>
</html>