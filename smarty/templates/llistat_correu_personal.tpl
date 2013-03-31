{literal}
<script type="text/javascript">
function checked2()
{

 	if(document.tipus_informe.chk.checked==true){
 		x = document.forms[0];
 		x.action = "reports/Llistat_alumnes_grup.php";
 	}else{
 		x = document.forms[0];
 		x.action = "reports/Llistat_alumnes_grup_sense_foto.php";
 	}
}
</script>
{/literal}

<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Resum_d.27incid.C3.A8ncies_d.27un_grup_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>

<center>
<form name="tipus_informe" method="post" action="mailing_list_report.php">
<table border="0" bgcolor="#f6f6f6">
	<tr>
		<td>
		<p>{t}All personal e-mails from the Institute{/t}: 
		</td>
	</tr>	
	<tr>
		<td>
			<textarea rows="19" cols="60">{foreach from=$student_mail item=student}{$student}{/foreach}</textarea>
				
			</select>
		</td>
	</tr>
	<tr>
		<td>
		<center><input type="submit" value="{t}Tornar{/t}"></center>
		</td>
	</tr>
</table>
</form>
</center>
</div>
