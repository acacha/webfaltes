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
	
	
		$ldapconfig['host'] = _LDAP_SERVER;
		$ldapconfig['port'] = _LDAP_PORT;
		$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
		
		$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		$password=_LDAP_PASSWORD;
		$dn=_LDAP_USER;
				
    ?>
    <form name="listClasse" action="listClasse.php" method="post">
    <table id="table3" align="center">
    <tr>
    <th>CODI GRUP:</th><th>CODI PROFESSOR:</th><th>CODI ASSIGNATURA:</th>
    </tr><tr>
    <td>
    <select name="grup" id="grup">
    <option value="" selected> </option>
    <?php foreach ($grup as $row){?>
     <option value="<?php echo $row['codi_grup'];?>"> <?php echo $row['nom_grup'];?></option>
    <?php }?>
    </select>	
   
    </td>
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

    <td>
    <input type="submit" name="cercar" value="cercar" onClick="">
    </td>
    </tr>
    </table>
    <form>
    </div>
    <?php if(isset($_POST['profes'])){
		
	$grup=$_POST["grup"];
	$assignatura=$_POST["assignatura"];
	$profes=$_POST["profes"];	
	
	if($_POST["grup"] != ""){
	$VALS['codi_grup']=$grup;
	}else{
	$VALS['codi_grup']='%';
	}
	if($_POST["profes"]!= ""){
	$VALS['codi_professor']=$profes;
	}else{
	$VALS['codi_professor']='%';
	}
	if($_POST["assignatura"] != ""){
	$VALS['codi_assignatura']=$assignatura;
	}else{
	$VALS['codi_assignatura']='%';
	}

	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
	$utils->p_dbg($RSRC, "Prova log");
	$listC = $ConTut->Execute($RSRC['LLISTAR_CLASSE']) or die($ConTut->ErrorMsg());		
	?>
	
	<table id="table3" align="center">
    <tr>
    <th>CODI LLIÇO:</th><th>CODI GRUP:</th><th>CODI PROFESSOR:</th><th>CODI ASSIGNATURA:</th><th>CODI AULA:</th><th>CODI DIA:</th><th>CODI HORA:</th><th>MODIFICAR</th><th>ELIMINAR</th>
    </tr><tr>
    <?php foreach($listC as $row){
	echo "<td>".$row['codi_llico']."</td><td>".$row['codi_grup']."</td><td>".$row['codi_professor']."</td><td>".$row['codi_assignatura']."</td><td>".$row['codi_aula']."</td><td>".$row['codi_dia']."</td><td>".$row['codi_hora']."</td><td><a href='modificarClasse.php?codi_llico=".$row['codi_llico']."&codi_grup=".$row['codi_grup']."&codi_professor=".$row['codi_professor']."&codi_assignatura=".$row['codi_assignatura']."&codi_aula=".$row['codi_aula']."&codi_dia=".$row['codi_dia']."&codi_hora=".$row['codi_hora']."'><img src='imatges/editar.png' name='modificar' height=20px width=20px></a></td><td><a href='controlador2.php?eliminarMo=true&codi_llico=".$row['codi_llico']."&codi_grup=".$row['codi_grup']."&codi_professor=".$row['codi_professor']."&codi_assignatura=".$row['codi_assignatura']."&codi_aula=".$row['codi_aula']."&codi_dia=".$row['codi_dia']."&codi_hora=".$row['codi_hora']."'><img src='imatges/eliminar.png' name='eliminar' height=20px width=20px></a></td><tr>";
	}?>
    </table>
	<?php
	}

	?>
    
    </div>


</div>
</body>
</html>