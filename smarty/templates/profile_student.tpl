{literal}
<script type="text/javascript">

function retorna(){
	document.location= "index.php";
}

</script>
{/literal}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes">
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/M%C3%B2dul_Gesti%C3%B3_de_Dades_Externa"><img src="/webfaltes/imatges/Ajuda.gif"></img></a></div>
<br></br>
<form name="form1" method="post" action="http://192.168.0.8/gosa/"  enctype="multipart/form-data">
<table width="50%" border="0"  align="center" bgcolor="#f6f6f6">
<thead>
	<tr>
		<td colspan="5" class="titol_taula" align="center">{t}Student profile{/t}
	</tr>
</thead>
<tbody>
	<tr>
		<td width="5%">&nbsp;&nbsp;</td>
		<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td width="5%">&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Code{/t}</strong></td>
		<td>{$student_code}</td>
		{if $foto eq NULL}<td rowspan="5"><img alt="Foto Perfil" title="Foto Perfil" src="imatges/default.jpg" width="100%" height="100%" ></img></td> {else}<td rowspan="5"><img alt="Foto Perfil" title="Foto Perfil" src="view_jpeg_photo.php?file={$foto}" width="100%" height="100%"></img></td>{/if}
		<!--<td rowspan="5"><img src="{$profile_photo_medium}" ></td><!--width="131.34px" height="83px" -->
		<td></td>
	</tr>
		<tr>
		<td></td>
		<td><strong>{t}DNI{/t}</strong></td>
		<td>{$dni}</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Name{/t}</strong></td>
		<td>{$student_name}</td>
		<td></td>
	</tr>
		<tr>
		<td></td>
		<td><strong>{t}Surames{/t}</strong></td>
		<td>{$student_surname}</td>
		<td></td>
	</tr>
			<tr>
		<td></td>
		<td><strong>{t}Gender{/t}</strong></td>
		<td>{$sexe}</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Address{/t}</strong></td>
		<td>{$address}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Fixed telephone{/t}</strong></td>
		<td>{$fixed_telephone}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Mobile phone{/t}</strong></td>
		<td>{$mobile_phone}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Email{/t}</strong></td>
		<td>{$email}</td>
		<td></td>
		<td></td>
	</tr>
	
		<tr>
		<td></td>
		<td><strong>{t}Personal email{/t}</strong></td>
		<td>{$p_email}</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td><strong>{t}User{/t}</strong></td>
		<td>{$user}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Group{/t}</strong></td>
		<td>{$group}<a href="timetable.php?src=grup:{$group}"><img title="Timetable" src="imatges/timetable_icon.gif" border="0" hspace="5px" align="middle"></a></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Web Page{/t}</strong></td>
		<td>{$web}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Tutor{/t}</strong></td>
		<td><a href="{$show_profile}?op={$op}&teacher_code={$t_code}">{$t_name} {$t_surname} ({$t_code})</a> {$t_email}<a href="timetable.php?src=profe:{$t_code}"><img title="Timetable" src="imatges/timetable_icon.gif" border="0" hspace="5px" align="middle"></a></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><strong>{t}Other teacher{/t}</strong></td>
		<td>
		
{foreach from=$teachers item=professor}
	<a href="{$show_profile}?op={$op}&teacher_code={$professor->codi_professor}">{$professor->nom_professor} {$professor->cognom1_professor} ({$professor->codi_professor})</a> {$professor->email}<a href="timetable.php?src=profe:{$professor->codi_professor}"><img title="Timetable" src="imatges/timetable_icon.gif" border="0" hspace="5px" align="middle"></a><br>
{/foreach}
 
		</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="5" align="center">
			<input type="submit" name="modify" value="{t}Modify{/t}">
			<input type="button" name="return" onclick="retorna()" value="{t}Return{/t}">
		</td>
	</tr>
</tbody>
</table>
<!--{t}{$status}{/t}-->

</div>

