<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes">
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/M%C3%B2dul_Gesti%C3%B3_de_Dades_Externa"><img src="/webfaltes/imatges/Ajuda.gif"></img></a></div>
<br></br>
{literal}
<script type="text/javascript">

function retorna(){
	document.location= "index.php";
}

</script>
{/literal}
<form name="form1" method="post" action="http://192.168.0.8/gosa/"  enctype="multipart/form-data">
<table width="50%" border="0"  align="center" bgcolor="#f6f6f6">
<thead>
	<tr>
		<td colspan="5" class="titol_taula" align="center">{t}Teacher profile{/t}
	</tr>
</thead>
<tbody>
	<tr>
		<td width="5%">&nbsp;&nbsp;</td>
		<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Code{/t}</td>
		<td>{$teacher_code}</td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Name{/t}</td>
		<td>{$teacher_name}</td>

	</tr>
	<tr>
		<td></td>
		<td>{t}Surname1{/t}</td>
		<td>{$teacher_surname1}</td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Surname2{/t}</td>
		<td>{$teacher_surname2}</td>
	</tr>
	<tr>
		<td></td>
		<td>{t}User{/t}</td>
		<td>{$user}</td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Email{/t}</td>
		<td>{$email}</td>

	</tr>
	<tr>
		<td colspan="5" align="center">
			<input type="submit" name="modify" value="{t}Modify{/t}">
			<input type="button" onclick="retorna()" name="return" value="{t}Return{/t}">
		</td>
	</tr>
</tbody>
</table>
<!--{t}{$status}{/t}-->

</div>
