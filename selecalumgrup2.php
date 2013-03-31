
<?php
/**
* @author Josep Llaó Angelats
* @name selecalumgrup2.php
* josepllao@ebre.cat
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

?>

<!-- utilitzem la funcio getalumnegrup-->

<script language="javascript">

function showOpt(str,txt)
{
if (str=="")
  {
  document.getElementById("txtoptativa").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		    document.getElementById("txtoptativa").innerHTML=xmlhttp.responseText;
	}
  }
 for(i=0;i<=2000;i++)
	{
	setTimeout('return 0',1);
	
	} 
xmlhttp.open("GET","getalumnegrup2.php?q="+str+"&txt="+txt,true);
xmlhttp.send();
}

</script>

<script language="javascript">


function showAlu(str,txt, txt2)
{
if (str=="")
  {
  document.getElementById("txtalumnes").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		    document.getElementById("txtalumnes").innerHTML=xmlhttp.responseText;
	}
  }
xmlhttp.open("GET","getalumnegrup2.php?ass="+str+"&txtass="+txt+"&txtalu="+txt2,true);
xmlhttp.send();
}

</script>

<script language="javascript">

function showProva(str,txt, div){
	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp3=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp3.onreadystatechange=function()
  {
  if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
    {
		    document.getElementById("txtalumnes").innerHTML=xmlhttp3.responseText;
	}
  }

xmlhttp3.open("GET","getalumnegrup3.php?div="+div,true);
xmlhttp3.send();
	

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		    document.getElementById("prova").innerHTML=xmlhttp.responseText;
	}
  }

xmlhttp.open("GET","getalumnegrup3.php?prova="+str,true);
xmlhttp.send();


if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp2=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp2.onreadystatechange=function()
  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    {
		    document.getElementById("txtoptativa").innerHTML=xmlhttp2.responseText;
	}
  }

xmlhttp2.open("GET","getalumnegrup2.php?q="+str+"&txt="+txt,true);
xmlhttp2.send();


}
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="Stylesheet" href="css/styles.css" />
</head>
<body>
<div class="contenedor_pestañes">

<?php
   // consulta a la base de dades per rellenar el select amb les optatives que contenen la paraula opt
    $utils->get_global_resources($RSRC, "db/sql_querys_inc.php");
    $utils->p_dbg($RSRC, "Prova log");
    $opt = $ConTut->Execute($RSRC['CONSULTA_OPTATIVES']) or die($ConTut->ErrorMsg());
    
    // consulta a la base de dades per rellenar el select amb les optatives que contenen la paraula opt
    $utils->get_global_resources($RSRC, "db/sql_querys_inc.php");
    $utils->p_dbg($RSRC, "Prova log");
    $optGrup = $ConTut->Execute($RSRC['CONSULTA_GRUPS']) or die($ConTut->ErrorMsg());
?>
    <br>

<div id="panel1" class="panel1">
    <h3>Relaci&oacute; Alumne / Assignatura:</h3>
 
    <!-- select per mostar les optatives-->
    
    &nbsp&nbsp&nbsp;
    Selecciona optativa:
    
    <select name="optatives" id="optatives"  onChange=" showProva(this.value,'falseOpt', '0');">
    <option value="" selected> </option>
    <?php foreach ($opt as $row){
     echo "<option value='".$row['codi_assignatura']."'> ".html_entity_decode($row['nom_assignatura'])."</option>";} ?>	

    </select>

<div id="prova" class="prova">
</div>
<br>
    
   
<div id="quadran" class="quadran">

<div id="txtalumnes" class="txtalumnes">
</div>
<div id="txtoptativa" class="txtoptativa">
</div>
</div>



</div>

</div>

</body>
</html>


