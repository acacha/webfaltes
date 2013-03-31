{literal}
<script>
	function envia_pdf(){
		window.open("reports/informe_resum_grup_faltes_mes_pdf.php","Informe mensual de faltes injustificades")
	}
</script>
{/literal}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Resum_mensual_de_faltes_injustificades"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>


<center>
<table class="stripeMe">
	<thead>
		<tr>
			<th align="center" colspan="7">
				{t}Resum de faltes injustificades del grup {$codi_grup} al més de {$mes}{/t}
		</tr>
	</thead>
	<tbody>
		<tr>
			<th align="left">{t}Estudiant{/t}</th> 
			<th align="left">{t}Faltes injustificades{/t}</th>
		</tr>
		{foreach from=$alumnes item=alumne}
		<tr bgcolor="#f6f6f6">
			<td>{$alumne->name}</td>
			<td>{$alumne->fj}</td>
		</tr>
		{/foreach}

		</tbody>
		<tfoot>
			<tr bgcolor="#d0d0d0">
				<th colspan="5" align="center">
				<input type="button" value="{t}Veure informe en PDF{/t}"
					onclick="javascript:envia_pdf();">
				</th>
			</tr>
		</tfoot>
	</table>
</center>
</div>
