<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Resum_mensual_de_faltes_injustificades"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>
<center>
	<form name="tipus_informe" method="post" action="informe_resum_grup_faltes_mes_2.php">
	<table border="0" bgcolor="#f6f6f6">
	<tr>
	<td><p>{t}Select group:{/t} </td>
	<td><select name="grup">
			<option value="-1" selected>Select group
			{html_options values=$codis_grup output=$codis_grup}		
		</select>
	</td>
	</tr>
	<tr>
	<td><p>{t}Selecciona el més:{/t} </td>
	<td><select name="mes">
			<option value="1" {if $current_month eq 1} selected {/if}>{t}Gener{/t}
			<option value="2" {if $current_month eq 2} selected {/if}>{t}Febrer{/t}
			<option value="3" {if $current_month eq 3} selected {/if}>{t}Març{/t}
			<option value="4" {if $current_month eq 4} selected {/if}>{t}Abril{/t}
			<option value="5" {if $current_month eq 5} selected {/if}>{t}Maig{/t}
			<option value="6" {if $current_month eq 6} selected {/if}>{t}Juny{/t}
			<option value="7" {if $current_month eq 7} selected {/if}>{t}Juliol{/t}
			<option value="8" {if $current_month eq 8} selected {/if}>{t}Agost{/t}
			<option value="9" {if $current_month eq 9} selected {/if}>{t}Setembre{/t}
			<option value="10" {if $current_month eq 10} selected {/if}>{t}Octubre{/t}
			<option value="11" {if $current_month eq 11} selected {/if}>{t}Novembre{/t}
			<option value="12" {if $current_month eq 12} selected {/if}>{t}Decembre{/t}
	</select>
	</td>
	</tr>
	<tr>
	<td><p>{t}Selecciona l'any:{/t} </td>
	<td><select name="ano">
			{html_options values=$years output=$years}
	</select>
	</tr>
	<tr>
	<td colspan="2" align="center">	<p><br><center><input type="submit" value="{t}Veure l'informe{/t}"></center></td>
	</tr>
	</table>
	</form>
</center>
</div>