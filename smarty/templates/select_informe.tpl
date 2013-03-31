<link rel="stylesheet" type="text/css" href="css/styless.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Manual_d.27usuari"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>

<center><br></br>
                <table bgcolor="#f6f6f6">
                <thead>
                        <tr align="center">
                                <td class="titol_taula">
                                {t}Center Reports{/t}
                                </td>
                        </tr>
                </thead>
                <tbody>

{if isset($is_coordinator)}
	
			
            <tr>
				<td align="center">
				 <a href="informe_per_alumne.php">
				 Informe Faltes Alumne</a>
			</tr>
            <tr>
				<td align="center">
				 <a href="informe_centre_d_h_1.php">
				 {t}Center incidents at d day and h hour{/t}</a>
			</tr>
			<tr>
				<td align="center"> 
				 <a href="informe_centre_di_df_1.php">
				 {t}Center incidents between initial and final date{/t}</a>
			</tr>
			<tr>
				<td align="center"> 
				 <a href="informe_centre_ranking_di_df_1.php"> 
				 {t}Incidents ranking between initial and final date{/t}</a>
			</tr>
{/if}

			<tr>
				<td align="center"> 
				 <a href="reports/informe_centre_professors_pdf.php"> 
				 {t}Llençol de professors{/t}</a>
			</tr>
			<tr>
				<td align="center"> 
				 <a href="reports/Llistat_grup_tutor.php"> 
				 {t}Reports group tutors{/t}</a>
			</tr>
			<tr>
			<td align="center">
                                 <a href="mailing_list_report.php">
                                 {t}Mailing list of students{/t}</a>

<!--     
       </tr>
			
			<tr> 
           <td align="center">
                                 <a href="class_lists_report.php">
                                 {t}Class Lists{/t}</a>
           </tr>          
-->
		</tbody>
		</table>
	</center>


        <center><br></br>
                <table bgcolor="#f6f6f6">
                <thead>
                        <tr align="center">
                                <td class="titol_taula">
                                        {t}Group reports{/t}
                                </td>
                        </tr>
                </thead>
                <tbody> 

	  <tr>
                                <td align="center">
                                 <a href="class_list_report.php">
                                   {t}Class list{/t}</a>
                                </td>
                        </tr>
                <tr>
                                <td align="center">
                                 <a href="class_sheet_report.php">
                                   {t}Llençol d'estudiants d'un grup{/t}</a>
                                </td>
                </tr>


{if isset($group_reports)}

                </tr>

			<tr>
				<td align="center"> 
				 <a href="informe_resum_grup_di_df_1.php"> 
			   {t}Group incidents summary between initial and final date{/t}</a>
				</td>
			</tr>
			<tr>
				<td align="center"> 
				 <a href="informe_resum_grup_faltes_mes_1.php"> 
			   {t}Monthly Summary of unjustified absences{/t}</a>
				</td>
			</tr>
		</tbody>
		</table>
	</center>
{/if}


<center>		<br></br>
	<table bgcolor="#f6f6f6">
	<thead>
		<tr align="center">
			<td class="titol_taula">
			{t}Subject report{/t} 
			</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center"> 
			 <a href="informe_resum_credit_di_df_1.php"> 
			 {t}Subject incidents summary between initial and final date{/t}</a>
			</td>
		</tr>
		</tbody>
	</table>
</center>
</div>
