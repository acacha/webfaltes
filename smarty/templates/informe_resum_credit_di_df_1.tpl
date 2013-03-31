<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Resum_d.27incid.C3.A8ncies_d.27un_cr.C3.A8dit_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>

<center>
<form name="tipus_informe" method="POST" action="{$URL}">
<table border="1" bgcolor="#f6f6f6">
	<tr>
		<td>
		<p>{t}Group{/t}: 
		</td>
		<td><select name="codi_grup" onChange="this.form.submit()">
			
			<option value="-1">{t}Select group:{/t}</option>
			{html_options options=$grups selected=$codigrup_seleccionat}
		</select></td>
	</tr>
	{if $hihacodi_grup}
	<tr>

		<td>
		<p>{t}Credit{/t}: 
		</td>
		<td><select id="codi_assignatura" name="codi_assignatura">
			<option value="-1">{t}Select credit:{/t} </option>
			 {html_options options=$credits}
		</select></td>

	</tr>
	{/if}
	<tr>
		<td>
		<p>{t}Write the initial date{/t}: 
		</td>
		<td><input type="Text" name="data_inicial" value="01-11-2008"></td>
	</tr>
	<tr>
		<td>
		<p>{t}Write the end date{/t}: 
		</td>
		<td><input type="Text" name="data_final" value="{$Final_date}"></input></td>
	</tr>
	
	<tr>
		<td colspan="2" align="center">
		<p><br><input type="hidden" name="Enviar" value="False">
		<center><input type="submit" value="{t}View report{/t}" onClick="ho_envio();"></center>
		</td>
	</tr>
	

	</form>
	</center>
	</table>
	</form>
	</center>
	</div>
	