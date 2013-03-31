{******************************************************************************* 
Template selecgrup_tutoria.tpl 
@ author: Josep Ràmirez
@ maintainer: sergi.tur@upc.edu
Variables 
 @
 @
*******************************************************************************}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<br></br><br></br>
	<center>
	<form name="tipus_informe" method="post" action="selecalum_tutoria.php">
	<table border = "0">
	<tr>
	<td><p>Selecciona el grup:</td>
	<td>
	<select name="grup">
	{html_options options=$CODIS_GRUP}
	</select>
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">	<p><br><input type="submit" value="Tutoritza!"></td>
	</tr>
	</table>
	</form>
	</center>
