{******************************************************************************* 
Main Template 
@ author: sergi.tur@upc.edu 
@ maintainer: sergi.tur@upc.edu
Variables 
 @ FORM_ACTION			Action paramater of html 
 @ FORM_TITLE           Form Title
 @ $butonTitle			Form button title
*******************************************************************************}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<center>
<form name="selecgroup" method="post" action="{$FORM_ACTION}">
<table border="0" bgcolor="#f6f6f6">
	<tr>
		<td>
		 <p>{$FORM_TITLE}
		</td>
		<td>
		{html_options name=group options=$myGroups}
	</tr>
	<tr>
		<td colspan="2" align="center">
		<p><br>
		<input type="submit" value="{$butonTitle}">
		</td>
	</tr>
</table>
</form>
</center>
</div>