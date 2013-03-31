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
$val=$_GET['valor'];
require_once _INCLUDES.'common-header.php';
?>
<html>
<head>
<script language="javascript" type="text/javascript">
function mostrar(){
document.getElementById('uno').style.display="block";
}
</script>
<script language="javascript">
	function showDiv(str){
	if (str==""){
	  document.getElementById("div").innerHTML="";
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
				document.getElementById("div").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","controlador2.php?valor="+str,true);
	xmlhttp.send();
	 for(i=0;i<=2000;i++)
	{
	setTimeout('return 0',1);
	
	} 
			
	if (str==""){
	  document.getElementById("div").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp2=new XMLHttpRequest();
	  }
	else{// code for IE6, IE5
	  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp2.onreadystatechange=function(){
	  if (xmlhttp2.readyState==4 && xmlhttp.status==200)
		{
				document.getElementById("divModificar").innerHTML=xmlhttp2.responseText;
		}
	  }
	xmlhttp2.open("GET","controlador2.php?valor2="+str,true);
	xmlhttp2.send();
	}
	
	function prova(str){
		if (str==""){
		  document.getElementById("divModificar").innerHTML="";
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
					document.getElementById("divModificar").innerHTML=xmlhttp.responseText;
			}
		  }
		xmlhttp.open("GET","controlador2.php?modificar="+str,true);
		xmlhttp.send();
	
	}
</script>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="Stylesheet" href="css/styles.css" />
</head>
<body>

<div class="contenedor_pestañes">
	<br><br>
    <div id="panel 1">
    <?php 
	if($val=="assignatura"){
	
			// consulta a la base de dades per rellenar el select amb les assignatures que contenen la paraula opt
			$utils->get_global_resources($RSRC, "db/sql_querys_inc.php");
			$utils->p_dbg($RSRC, "Prova log");
			$ass = $ConTut->Execute($RSRC['CONSULTA_ASSIGNATURES']) or die($ConTut->ErrorMsg());
			?>
             <form name="addAss" action="controlador2.php" method="POST" >
             <br>
             <b style="text-align:center"><img src='imatges/add1.png' name="GESTIÓ CLASSES" height=25px width=25px>&nbsp;&nbsp;AFEGIR ASSIGNATURA:</b>
             <br><br>
             Codi assignatura: <input type="text" name="codi_ass" id="codi_ass" value=""> &nbsp;&nbsp;&nbsp;
             Nom assignatura: <input type="text" name="nom_ass" id="nom_ass" value="">&nbsp;&nbsp;&nbsp;
             <input type="submit" name="acceptar" value="acceptar" id="acceptar" style="text-align:right">
             </form>
             <br>

             <b><img src='imatges/list.png' name="GESTIÓ CLASSES" height=25px width=25px> &nbsp;&nbsp;MODIFICAR ASSIGNATURA:</b><br><br>
            
            <select name="assignatura" id="assignatura"  onChange=" showDiv(this.value);">
            <?php foreach ($ass as $row){
             echo "<option value='".$row['codi_assignatura']."'> ".utf8_encode($row['nom_assignatura'])."</option>";}
             echo "</select>";	
	}else{
		// consulta a la base de dades per rellenar el select amb les optatives que contenen la paraula opt
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php");
		$utils->p_dbg($RSRC, "Prova log");
		$opt = $ConTut->Execute($RSRC['CONSULTA_OPTATIVES']) or die($ConTut->ErrorMsg());
	 ?>
	 
          <form name="addAss" action="controlador2.php" method="POST">
        	 <b style="text-align:center"><img src='imatges/add1.png' name="GESTIÓ CLASSES" height=25px width=25px>&nbsp;&nbsp;AFEGIR ASSIGNATURA:</b>
         	 <br><br>
         	 Codi assignatura: <input type="text" name="codi_op" id="codi_op" value=""> &nbsp;&nbsp;&nbsp;
         	 Nom assignatura: <input type="text" name="nom_op" id="nom_op" value="">&nbsp;&nbsp;&nbsp;
          	<input type="submit" name="acceptar" value="acceptar" id="acceptar" style="text-align:right">
          </form>
    
     	<br>

         <b><img src='imatges/list.png' name="GESTIÓ CLASSES" height=25px width=25px> &nbsp;&nbsp;Selecciona <?php echo _MATERIA;?>:</b><br><br>
        <select name="optatives" id="optatives"  onChange=" showDiv(this.value);" >
         <option value="" selected> </option>
    	<?php foreach ($opt as $row){
         echo "<option value='".$row['codi_assignatura']."'> ".utf8_encode($row['nom_assignatura'])."</option>";}
         echo "</select>";
		?>

		<div id="div" class="div">
        </div>
        <br><br>
        <div id="divModificar" class="divModificar">
        </div>

        <?php	
        }
     ?>
    <div id="div" class="div">
    </div>
     <br>
    <div id="divModificar" class="divModificar">
    </div>
   
    
     
    
    </div>
    </div>



</div>
</body>
</html>