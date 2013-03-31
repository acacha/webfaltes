{literal}
<script>
	function envia_pdf(){
		window.open("reports/informe_resum_credit_di_df_pdf.php","Resum d'incidències d'un credit entre una data inicial i una data final")
	}
</script>
{/literal}

<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Resum_d.27incid.C3.A8ncies_d.27un_cr.C3.A8dit_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>

<center><table class="stripeMe">
<thead>
	<tr>
		<th align="center" colspan="7">
		{t}Summary of incidences of group {$codi_grup} between {$data_inicial} and {$data_final} credit {$nom_assignatura} {$codi_assignatura}{/t}
	</tr>
</thead>
<tbody>
	<tr bgcolor="#d0d0d0">
		<th align="left">{t}Student{/t}</th> 
			<th align="left"> F </th>
			<th align="left"> FJ </th>
			<th align="left"> R </th>
			<th align="left"> RJ </th>
			<th align="left"> E </th>
			<th align="left">{t}Total Incidents{/t}</th>
	</tr>
	{foreach from=$students item=student}
	<tr bgcolor="#FFFFFF">
		<td>{$student->name}</td>
		{foreach from=$student->total item=total}
		<td>{$total}</td>
		{/foreach}
		<td>{$student->TOTAL_INCIDENCIES}</td>
	</tr>
	{/foreach}
	</tbody>
<tfoot>
			<tr bgcolor="#d0d0d0">
				<th colspan="7" align="center">
				<input type="button" value="{t}View report in pdf{/t}"
					onclick="javascript:envia_pdf();">
				</th>
			</tr>
		</tfoot>

</table></center>
</div>