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

<br><br>
    <div id="panel 1">
    
    <div id="classe" class="classe">
    <?php
    $utils->get_global_resources($RSRC, "db/sql_querys_inc.php");
	$utils->p_dbg($RSRC, "Prova log");
	$grup = $ConTut->Execute($RSRC['CONSULTA_GRUPS']) or die($ConTut->ErrorMsg());
	$ass = $ConTut->Execute($RSRC['CONSULTA_ASSIGNATURA']) or die($ConTut->ErrorMsg());
	$dia = $ConTut->Execute($RSRC['CONSULTA_DIA']) or die($ConTut->ErrorMsg());
	$hora = $ConTut->Execute($RSRC['CONSULTA_HORA']) or die($ConTut->ErrorMsg());
	$llico = $ConTut->Execute($RSRC['CONSULTA_LLICO']) or die($ConTut->ErrorMsg());
	

	$max=0;
	foreach($llico as $row){
		if($max < (int)$row['codi_llico']){
			$max=(int)$row['codi_llico'];
		}
	}
	
	
		$ldapconfig['host'] = _LDAP_SERVER;
		$ldapconfig['port'] = _LDAP_PORT;
		$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
		
		$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		$password=_LDAP_PASSWORD;
		$dn=_LDAP_USER;
				
    ?>
    <form name="validar clas" action="controlador2.php" method="post">
    <table id="table3" align="center">
    
    <tr>
    <td>CODI LLIÇO: </td>
    <td>
     <?php echo $max+1;
	 $_SESSION['maxCodi']=$max+1;
	 ?>
     
    </td>
    </tr><tr>
    <td>CODI GRUP: </td>
    <td>
    <select name="grup" id="grup">
     <option value="" selected> </option>
    <?php foreach ($grup as $row){?>
     <option value="<?php echo $row['codi_grup'];?>"> <?php echo $row['nom_grup'];?></option>
    <?php }?>
    </select>	
    </td>
    </tr><tr>
    <td>CODI PROFESSOR: </td>
    <td>
    <?php 
	if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
		$search=@ldap_search($ds, $ldapconfig['basedn'],'sn=*');
		ldap_sort($ds, $search, "cn");
		$info = ldap_get_entries($ds, $search);
		?>
		<select name="profes" id="profes">
         <option value="" selected> </option>
		<?php foreach ($info as $row){
		if(isset($row['employeenumber'][0])){
		?>
        
		 <option value="<?php echo $row['employeenumber'][0];?>"> <?php echo $row['cn'][0];?></option>
		<?php }}?>
		</select>
		<?php
		}
	}
	?>
    </td>
    </tr><tr>
    <td>CODI ASSIGNATURA: </td>
    <td>
    <select name="assignatura" id="assignatura" >
     <option value="" selected> </option>
    <?php foreach ($ass as $row){
	if(isset( $row['codi_assignatura'])){
	?>
     <option value="<?php echo $row['codi_assignatura'];?>"> <?php echo utf8_encode($row['nom_assignatura']);?></option>
    <?php }}?>
    </select>	
    </td>
    </tr><tr>
    <td>AULA: </td>
    <td><input type="text" name="aula" id="aula" value=""></td>
    </tr><tr>
    <td>DIA: </td>
    <td>
    <select name="dia" id="dia" >
     <option value="" selected> </option>
    <?php foreach ($dia as $row){?>
     <option value="<?php echo $row['codi_dia'];?>"> <?php echo $row['dia_llarg'];?></option>
    <?php }?>
    </select>	
    </td>
    </tr><tr>
    <td>Hora: </td>
    <td>
    <select name="hora" id="hora" >
     <option value="" selected> </option>
    <?php foreach ($hora as $row){?>
     <option value="<?php echo $row['codi_hora'];?>"> <?php echo $row['hora_inici']." - ". $row['hora_final'];?></option>
    <?php }?>
    </select>	
    </td>
    </tr><tr>
    <td></td><td></td>
    </tr><tr>
    <td></td><td><input type="submit" name="validar" value="validar"> </td>
    
    </table>
    </form>
    </div>
    
    </div>


</div>
</body>
</html>