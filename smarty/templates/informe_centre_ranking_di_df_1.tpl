{*******************************************************************************
Template informe_centre_ranking_di_df_1.tpl @ author: Josep Ramírez @
maintainer: sergi.tur@upc.edu Variables @ @
*******************************************************************************}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#R.C3.A0nquing_d.27incid.C3.A8ncies_del_centre_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>

<center>
<form name="inf_centre_d_h_i" method="post"
	action="informe_centre_ranking_di_df_2.php">
<table border="0" bgcolor="#f6f6f6">
		<tr>
			<td>
			<p>{t}Write the initial date{/t}: 
			</td>
			<td><input type="Text" name="data_inicial" value="01-11-2008"></td>
		</tr>
		<tr>
			<td>{t}Write the end date{/t}: 
			</td>
			<td><input type="Text" name="data_final" value={$DATE}>
			</td>
		</tr>
		<tr>
			<td>{t}Top{/t}: 
			</td>
			<td><input type="Text" name="top" value="10"></td>
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