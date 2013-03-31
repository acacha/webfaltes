{*******************************************************************************
Plantilla tutoria @ author: sergi.tur@upc.edu @ maintainer:
sergi.tur@upc.edu Variables @ menu_options Associative array with menu
options names and URLs
*******************************************************************************}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<br></br>
<table border="0" align="center" bgcolor="#f6f6f6">
<thead>
	<tr align="center">
		<td colspan="5" class="titol_taula">{t}Tutorship Menu{/t}</td>
	</tr></thead>
	<tbody>
	<tr>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
	</tr>
	
	{foreach from=$menu_options key=k item=v}
	<tr>
		<td>&nbsp;</td>
		<td align="center"><a href="{$k}">{$v} </a></td>
		<td>&nbsp;</td>
	</tr>
	{/foreach}
	<tr>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>

	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="center"><a href="llistatAlumneMes.php">Llistat de faltes per alumne</a></td>
		<td>&nbsp;</td>
	</tr>
	</tbody>
</table>
</div>