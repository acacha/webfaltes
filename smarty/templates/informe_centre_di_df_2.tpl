{literal}
<script type="text/javascript">
	function envia_pdf(){
		window.open("reports/informe_centre_di_df_pdf.php","Incidències del centre entre una data inicial i una data final ")
	}
</script>
{/literal}

<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Incid.C3.A8ncies_del_centre_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>
<center>
<table border= "1" align= "right">
<thead>
	<tr>
		<td colspan="2">{t}Selected incidents{/t}: </td>
	</tr>
</thead>
<tbody>
	{if $f}
	<td>F</td>
	<td>{t}Unjustified foul{/t}</td>
	</tr>
	{/if} {if $fj}
	<tr>
		<td>FJ</td>
		<td>{t}Justified foul{/t}</td>
	</tr>
	{/if} {if $r}
	<tr>
		<td>R</td>
		<td>{t}Unjustified delay{/t}</td>
	</tr>
	{/if} {if $rj}
	<tr>
		<td>RJ</td>
		<td>{t}Justified delay{/t}</td>
	</tr>
	{/if} {if $e}
	<tr>
		<td>E</td>
		<td>{t}Expulsion{/t}</td>
	</tr>
	{/if}
	</tbody>
</table></center>

<br></br>

<center><table class="stripeMe">
<thead>
	<tr>
		<th align="center" colspan="7"><strong>
		{t}Ranking incident center between{/t} {$DATA_INICIAL} {t}and{/t} 
		{$DATA_FINAL}
		</strong>
	</tr>
</thead>
<tbody>
	<tr>
		<tr>
			{foreach from=$GRUPS item=GRUP}
			<th colspan="{$N_INCIDENCIES}">{$GRUP->codi_grup}</th>
		</tr>
		<tr>
			<th align="left">{t}Student{/t}</th> 
		{if $f}
			<th align="left"> F </th>
		{/if}
		{if $fj}
			<th align="left"> FJ </th>
		{/if}
		{if $r}
			<th align="left"> R </th>
		{/if}
		{if $rj}
			<th align="left"> RJ </th>
		{/if}
		{if $e}
			<th align="left"> E </th>
		{/if}
			<th align="left">{t}Total Incidents{/t}</th>
		</tr>
		{foreach from=$STUDENTS item=STUDENT} {if
		$STUDENT->codi_grup==$GRUP->codi_grup}
		<td>{$STUDENT->name}</td>

		{foreach from=$STUDENT->total item=total}
		<td>{$total}</td>
		{/foreach}

		<td>{$STUDENT->TOTAL_INCIDENCIES}</td>
	</tr>
	{/if} {/foreach} {/foreach}
</tbody>
<tfoot>
			<tr>
				<th colspan="7" align="center">
				<input type="button" value="{t}View report in pdf{/t}"
					onclick="envia_pdf()">
				</th>
			</tr>
		</tfoot>
</table>

</center>
<p></div>