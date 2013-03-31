{literal}
<script>
	function envia_pdf(){
		window.open("reports/informe_resum_grup_di_df_pdf.php","Resum d'incidències d'un grup entre una data inicial i una data final")
	}

	function carta_pdf(){
		window.open("reports/carta_informe_resum_grup_di_df_pdf.php","Comunicat als pares")
	}
</script>
{/literal}

<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Resum_d.27incid.C3.A8ncies_d.27un_grup_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>

<center><table class="stripeMe">
<thead>
		<tr height="20">
			<th align="center" colspan="7">
				<strong>
					<p> 
					{t}Summary of incidences of group {$codi_grup} between {$data_inicial} and {$data_final}{/t}
					<p>
				</strong>
			</td>				
		</tr>
	</thead>
	<tbody>
		<tr>
			<th align="left">{t}Student{/t}</th> 
			<th align="left"> F </th>
			<th align="left"> FJ </th>
			<th align="left"> R </th>
			<th align="left"> RJ </th>
			<th align="left"> E </th>
			<th align="left">{t}Total Incidents{/t}</th>
		</tr>
		
		{foreach from=$alumnes item=alumne}
		<tr bgcolor="#f6f6f6">
		   		<td>{$alumne->name}</td>
			   		{foreach from=$alumne->total item=total}
						<td>{$total}</td> 
					{/foreach}
				<td>{$alumne->TOTAL_INCIDENCIES}</td>
		</tr>
		{/foreach}</tbody>
		<tfoot>
			<tr>
				<th colspan="7" align="center">
				<input type="button" value="{t}View report in pdf{/t}"
					onclick="javascript:envia_pdf();">
				<input type="button" value="{t}Communicated to parents{/t}"
					onclick="javascript:carta_pdf();">	
				</th>
			</tr>
		</tfoot>
		
	</table></center>
	</div>