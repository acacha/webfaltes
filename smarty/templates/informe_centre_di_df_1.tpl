<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Incid.C3.A8ncies_del_centre_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>

<center>
<form name="inf_centre_d_h_i" method="post"
	action="informe_centre_di_df_2.php">
<table border="0" bgcolor="#f6f6f6">
	<tr>
		<td>
		<p>{t}Write the initial date{/t}: 
		</td>
		<td><input type="Text" name="data_inicial"
			value="{$IMPRIMIR_DATA}"></td>
	</tr>
	<td>{t}Write the end date{/t}: </td>
	<td><input type="Text" name="data_final"
		value="{$IMPRIMIR_DATA_2}"></td>
	<tr>
		<td valign="top">
		<p>{t}Select the type of incident{/t}
		</td>
		<td>
		<p><input type="checkbox" name="f" value="1" checked>F
		<p><input type="checkbox" name="fj" value="2" checked>FJ</p>
		<p><input type="checkbox" name="r" value="3" checked>R</p>
		<p><input type="checkbox" name="rj" value="4" checked>RJ</p>
		<p><input type="checkbox" name="e" value="5" checked>E</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<p><br>
		<center><input type="submit" value="{t}View report{/t}"></center>
		</td>
	</tr>

</table>
</form>
</center>
</div>