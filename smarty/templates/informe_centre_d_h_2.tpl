{literal}
<script>
	function envia_pdf(){
		alert ('hola');
		document.form1.submit();
	}
</script>
{/literal}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Incid.C3.A8ncies_del_centre_del_dia_d_a_l.27hora_h"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>
<!--<h3> Informe d'incidències del centre del {$DATA} de {$HORA_INICI} a {$HORA_FINAL}</h3>  -->
<form id="form" name="form1" action="reports/informe_centre_d_h_pdf.php" method="get">
{if $PRIMER_COP eq 1}
<center>
<table border="1">
	<thead>
		<tr>
			<td colspan="2">{t}Selected incidents{/t}:</td>
		</tr>
	</thead>
	<tbody>
		{if $F eq 1}
		<tr>
			<td>F</td>
			<td>{t}Unjustified foul{/t}</td>
		</tr>
		{/if} {if $FJ eq 1}
		<tr>
			<td>FJ</td>
			<td>{t}Justified foul{/t}</td>
		</tr>
		{/if} {if $R eq 1}
		<tr>
			<td>R</td>
			<td>{t}Unjustified delay{/t}</td>
		</tr>
		{/if} {if $RJ eq 1}
		<tr>
			<td>RJ</td>
			<td>{t}Justified delay{/t}</td>
		</tr>
		{/if} {if $E eq 1}
		<tr>
			<td>E</td>
			<td>{t}Expulsion{/t}</td>
		</tr>
		{/if}
	</tbody>
</table>
</center>
<br></br>
{/if}
{foreach from=$results item=i}
<center>
{if $i.primer_cop eq 1}

<table class="stripeMe" width="600px">
	<thead>
		<tr>
			<th align="center" colspan="7">GRUP: {$i.grup}
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>{t}Estudiant{/t}</th>
			<th>{t}Incidència{/t}</th>
			<th>{t}Crèdit/Mòdul{/t}</th>
			<th>{t}Professor{/t}</th>
		</tr>
		{/if}

		{foreach from=$students item=student}
		{if $i.primer_cop eq 1}
		{if $i.grup eq $student->nom_group}
		<tr>
			<td>{$student->name}</td>
			<td>{$student->motiu_curt}</td>
			<td>{$student->nom_assignatura}</td>
			<td colspan="2">{$student->nom_professor}
			{$student->cognom1_professor}</td>
		</tr>
		{/if}
		{/if}
		{/foreach}
		{/foreach}
	</tbody>
	{if $PRIMER_COP eq 1}
	<tfoot>
		<tr>
			<th colspan="5" align="center"><input type="submit"
				value="{t}View report in pdf{/t}" >
			</th>

		</tr>
	</tfoot>{/if}
</table>
</center>
<p><h1>{if $HI_HA_INCIDENCIES eq 0} {t}There is no incidence to this day at this time{/t} {/if}</h1></p>
</form>
</div>
