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

$selecAssignatura=$_GET["rass"];
$valAP=$_GET["valor"];
$val2=$_GET["valor2"];
$modificar=$_GET["modificar"];
$eliminar=$_GET["eliminar"];
$codi_ass=$_GET["codi_assignatura"];
$nom_ass=$GET["nom_assignatura"];
$optativa=$GET["optativa"];
$add_codi_ass=$_POST['codi_ass'];
$add_nom_ass=$_POST['nom_ass'];
$add_codi_op=$_POST['codi_op'];
$add_nom_op=$_POST['nom_op'];
$modificar_codi_op=$_POST['modificar_codi_op'];
$modificar_nom_op=$_POST['modificar_nom_op'];
$modificar_optativa=$_POST['modificar_optativa'];
$profes=$_POST["profes"];
$profesModificar=$_POST["profesModificar"];
$llicoHI=$_POST['llicoHI'];
$eliminarMo=$_GET['eliminarMo'];




/*
* si el valor que passem ens diu que mostrem selecAssignatura.php:
*/
if(isset($selecAssignatura)){
	$valor="assignatura";	
		?>
		
	<input type="radio" name="assignarura" id="assignatura" value="Assignatura" onclick = "location.href='selecAssignatura.php?valor=assignatura'")> Assignatura
	<input type="radio" name="optativa" id="optativa" value="optativa" onclick = "location.href='selecAssignatura.php?valor=optativa'")> <?php echo _MATERIA;

/*
* si el valor que passem ens diu que mostrem la taula d'optatives:
*/
}else if(isset($valAP)){
		
		// consultes assignatures optatives
		$VALS['valAP']=$valAP;
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$ass = $ConTut->Execute($RSRC['CONSULTA_ASS_OPT']) or die($ConTut->ErrorMsg());
		
		// div assignatures 
		echo '<div id="divAssig" classe="divAssig">';
		//taula que rellenem les dades 
		echo "<br><br><table align='center' id='table2'>";
		echo "<th>CODI ASSIGNATURA</th><th>NOM ASSIGNATURA</th><th>ASS / OP</th><th>MODIFICAR</th><th>ELIMINAR</th>";
		
		//foreach que recorre les assignatures
		foreach ($ass as $row){?>
        <?php 
		$_SESSION['codi_assignatura']=$row['codi_assignatura'];
		$_SESSION['nom_assignatura']=$row['nom_assignatura'];
		$_SESSION['optativa']=$row['optativa'];
		?>
		<tr><td><?php echo $row['codi_assignatura']; ?></td><td><?php echo $row['nom_assignatura']; ?></td><td><?php echo $row['optativa']; ?></td>
		<td align="center" style="vertical-align:middle"><a href='#' onclick='javascript:prova();'><img src='imatges/editar.png' name="GESTIÓ CLASSES" height=20px width=20px></a></td>
		<td align="center" style="vertical-align:middle"><a href='controlador2.php?eliminar=eliminar&codi_assignatura=<?php echo $row["codi_assignatura"];?> &nom_assignatura= <?php echo $row["nom_assignatura"];?> &optativa=<?php echo $row["optativa"];?>' style="alignment-adjust:central; vertical-align:central"><img src='imatges/eliminar.png' style="display:block" name="GESTIÓ CLASSES" height=20px width=20px></a></td></tr>
		<?php }
		echo '</table></div>';
		
	

/*
* si seleecionem l'opció de modificar
*/
}else if(isset($val2)){
	echo"";

}else if(isset($modificar)) {
		 echo '<form name="divoculto" action="controlador2.php" method="POST">';
         echo '<table id="table3" align="center">';
      	 echo '<tr>';
         echo '<td> codi assignatura:</td><td><input type="text" name="modificar_codi_op" id="modificar_codi_op" value="'.$_SESSION["codi_assignatura"] .'" ></td></tr>';
         echo '<td> nom assignatura:</td><td><input type="text" name="modificar_nom_op" id="modificar_nom_op" value="'.utf8_encode($_SESSION["nom_assignatura"]).'" ></td></tr>';
         echo '<td>'._MATERIA.' (0/1)</td><td><input type="text" name="modificar_optativa" id="modificar_optativa" value="'. $_SESSION["optativa"].'"></td><tr>';
         echo '<td></td><td><input type="submit" value"validar" name="enviar"></td></tr>';	

/*
* si seleecionem l'opció de eliminiar
*/
}else if(isset($eliminar)) {
	
		$VALS['codi_assignatura']=$codi_ass;
		$VALS['nom_assignatura']=$nom_ass;
		$VALS['optativa']=$optativa;
		
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$ass = $ConTut->Execute($RSRC['DELETE_OPTATIVA_ASSIGNATURA']) or die($ConTut->ErrorMsg());
	
	if($optativa==1){
	?>
	<body onLoad="location.href='selecAssignatura.php?valor=optativa';">
	</body>
    <?php
	}else if($optativa==0){
	?>
	<body onLoad="location.href='selecAssignatura.php?valor=assignatura'">
	</body>
    <?php
	}
}else if(isset($add_codi_ass)) {
		
		$VALS['codi_assignatura']=$add_codi_ass;
		$VALS['nom_assignatura']=$add_nom_ass;
		$VALS['optativa']=0;
		
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$ass = $ConTut->Execute($RSRC['ADD_ASSIGNATURA']) or die($ConTut->ErrorMsg());
		
		?>
        <body onLoad=" location.href='selecAssignatura.php?valor=assignatura';">
        </body>
        <?php

}else if(isset($add_codi_op)) {
	
		$VALS['codi_assignatura']=$add_codi_op;
		$VALS['nom_assignatura']=$add_nom_op;
		$VALS['optativa']=1;
		
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$ass = $ConTut->Execute($RSRC['ADD_OPTATIVA']) or die($ConTut->ErrorMsg());
		?>
        <body onLoad="location.href='selecAssignatura.php?valor=optativa'">
        </body>
        <?php
}else if(isset($modificar_codi_op)){
	
		$VALS['codi_assignatura']=$modificar_codi_op;
		$VALS['nom_assignatura']=$modificar_nom_op;
		$VALS['optativa']=$modificar_optativa;
		
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
		$utils->p_dbg($RSRC, "Prova log");
		$ass = $ConTut->Execute($RSRC['MODIFICAR_OPTATIVA']) or die($ConTut->ErrorMsg());
		
	if($optativa==1){
	?>
	<body onLoad="location.href='selecAssignatura.php?valor=optativa';">
	</body>
    <?php
	}else if($optativa==0){
	?>
	<body onLoad="location.href='selecAssignatura.php?valor=assignatura'">
	</body>
    <?php
	}

}else if(isset($profes)){
$codiLlico=$_SESSION['maxCodi'];
$grup=$_POST["grup"];
$assignatura=$_POST["assignatura"];
$aula=$_POST["aula"];
$dia=$_POST["dia"];
$hora=$_POST["hora"];

$VALS['codi_llico']=$codiLlico;
$VALS['codi_grup']=$grup;
$VALS['codi_professor']=$profes;
$VALS['codi_assignatura']=$assignatura;
$VALS['codi_aula']=$aula;
$VALS['codi_dia']=$dia;
$VALS['codi_hora']=$hora;

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
$utils->p_dbg($RSRC, "Prova log");
$ass = $ConTut->Execute($RSRC['ADD_CLASSE']) or die($ConTut->ErrorMsg());

 ?><body onLoad="location.href='selecClasse.php?'">/body><?php

}else if(isset($_POST['llicoHI'])){

$VALS['codi_llicoHI']=$_POST['llicoHI'];
$VALS['codi_grupHI']=$_POST['grupHI'];
$VALS['codi_professorHI']=$_POST['professorHI'];
$VALS['codi_assignaturaHI']=$_POST['assignaturaHI'];
$VALS['codi_aulaHI']=$_POST['aulaHI'];
$VALS['codi_diaHI']=$_POST['diaHI'];
$VALS['codi_horaHI']=$_POST['horaHI'];

$VALS['codi_llico']=$_POST['llico'];
$VALS['codi_grup']=$_POST["grup"];
$VALS['codi_professor']=$_POST['profesModificar'];
$VALS['codi_assignatura']=$_POST["assignatura"];
$VALS['codi_aula']=$_POST["aula"];
$VALS['codi_dia']=$_POST["dia"];
$VALS['codi_hora']=$_POST["hora"];

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
$utils->p_dbg($RSRC, "Prova log");
$ass = $ConTut->Execute($RSRC['MODIFICAR_CLASSE']) or die($ConTut->ErrorMsg());

 ?><body onLoad="location.href='listClasse.php'"></body><?php
}else if($eliminarMo=="true"){

$VALS['codi_llico']=$_GET['codi_llico'];
$VALS['codi_grup']=$_GET["codi_grup"];
$VALS['codi_professor']=$_GET['codi_professor'];
$VALS['codi_assignatura']=$_GET["codi_assignatura"];
$VALS['codi_aula']=$_GET["codi_aula"];
$VALS['codi_dia']=$_GET["codi_dia"];
$VALS['codi_hora']=$_GET["codi_hora"];

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php",$VALS);
$utils->p_dbg($RSRC, "Prova log");
$ass = $ConTut->Execute($RSRC['ELIMINAR_CLASSE']) or die($ConTut->ErrorMsg());

 ?><body onLoad="location.href='listClasse.php'"></body><?php
}
?>

