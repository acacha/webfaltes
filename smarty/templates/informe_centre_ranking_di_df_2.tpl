{*******************************************************************************
Template informe_centre_ranking_di_df_2.tpl @ author: Josep Ramírez @
maintainer: sergi.tur@upc.edu Classe: @ student @ @
*******************************************************************************}
{literal}
<script>
	function envia_pdf(){
		window.open("reports/informe_centre_ranking_di_df_pdf.php","Rànquing incidències del centre entre una data inicial i una data final")
	}
</script>
{/literal}

<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#R.C3.A0nquing_d.27incid.C3.A8ncies_del_centre_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>
<center><table class="stripeMe">
<thead>
	<tr>
		<th align="center" colspan="4">
		{t}Ranking incident center between{/t} {$STR_DATA_INICIAL}
		{t}and{/t} {$STR_DATA_FINAL}
	</tr>
	</thead>
	<tbody>
	<tr>
		<th>{t}Position{/t}</th>
		<th>{t}Estudiant{/t}</th>
		<th>{t}Group{/t}</th>
		<th>{t}Total fouls not justified{/t}</th>
	</tr>
	{foreach from=$STUDENTS item=STUDENT}
	<tr>
		<td>{$STUDENT->posicio}</td>
		<td>{$STUDENT->name}</td>
		<td>{$STUDENT->id_group}</td>
		<td>{$STUDENT->TOTAL_INCIDENCIES}</td>
	</tr>
	{/foreach}
	</tbody>
	<tfoot>
			<tr>
				<th colspan="5" align="center">
				<input type="button" value="{t}View report in pdf{/t}"
					onclick="javascript:envia_pdf();">
				</th>
			</tr>
		</tfoot>

</table>
</center>
</div>
