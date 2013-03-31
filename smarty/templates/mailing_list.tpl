{literal}
<script type="text/javascript">
function rad2(ctrl){
    for(i=0;i<ctrl.length;i++){
        if(ctrl[i].checked==true){
            l=ctrl[i].value;
        }
	}
	if(l=='P'){
		x = document.forms[0];
 		x.action = "Llistat_correu_personal_alumnes.php";
	}else if(l=='C'){
 		x = document.forms[0];
 		x.action = "Llistat_correu_centre_alumnes.php";
	}else if(l=='A'){
 		x = document.forms[0];
 		x.action = "Llistat_correu_centre_personal_alumnes.php";
	}
}
</script>
{/literal}
<body onload="rad2(document.tipus_informe.opcio)"></body>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes"><br></br>
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/modul_informes#Resum_d.27incid.C3.A8ncies_d.27un_grup_entre_una_data_inicial_i_una_data_final"><img src="{$BASE_PATH_HTML}/imatges/Ajuda.gif"></img></a></div>
<center>
<form name="tipus_informe" method="post" action="Llistat_alumnes_grup.php">
<table border="0" bgcolor="#f6f6f6">
	<tr>
		<tr>
		<td>
		<p>{t}Select an option{/t}: 
		</td>
		</tr>
		<td>
		<input type="radio" name="opcio" checked="checked" onchange="rad2(document.tipus_informe.opcio)" value="P">{t}Personal accounts{/t}
		</td>
		</tr>
		<tr>
		<td>
		<input type="radio" name="opcio" onchange="rad2(document.tipus_informe.opcio)" value="C">{t}Center accounts{/t}
		</td>
		</tr>
		<tr>
		<td>
		<input type="radio" name="opcio" onchange="rad2(document.tipus_informe.opcio)" value="A">{t}Booth accounts{/t}
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<p>
		<br>
		<center><input type="submit" value="{t}View report{/t}"></center>
		</td>
	</tr>
</table>
</form>
</center>
</div>
