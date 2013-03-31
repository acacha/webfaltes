<!--******************************************************************************* 
Template informe_centre_d_h_1.tpl 
@ author: Albert Mestre
@ maintainer: sergi.tur@upc.edu
Variabless 
 @{$imprimir_data}
 @{$hores}
*******************************************************************************-->
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Incid.C3.A8ncies_del_centre_del_dia_d_a_l.27hora_h"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>
<br></br>
<center>
<form name="inf_centre_d_h_i" method="post"
	action="informe_centre_d_h_2.php">
<table border="0" bgcolor="#f6f6f6">
		<tr>
			<td>
			<p>{t}Write date{/t}:
			</td>
			<td><input type="Text" name="data_informe"
				value="{$imprimir_data}"></input></td>
		</tr>
		<td>{t}Select the time{/t}: </td>
		<td><select name="hora_informe">
			{html_options options=$hores}
		</select></td>
		<tr>
			<td valign="top">
			<p>{t}Select the type of incident{/t}: 
			</td>
			<td>
			<p><input type="checkbox" name="f" value="1" checked>F
			<p><input type="checkbox" name="fj" value="2" checked>FJ
			<p><input type="checkbox" name="r" value="3" checked>R
			<p><input type="checkbox" name="rj" value="4" checked>RJ
			<p><input type="checkbox" name="e" value="5" checked>E
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
			<p><br>
			<center><input type="submit" value="{t}Veure l'informe{/t}"></center>
			</td>
		</tr>
</table>
</form>
</center>
</div>