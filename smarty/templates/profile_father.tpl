<link rel="stylesheet" type="text/css" href="css/styles.css" />
<div class="contenedor_pestañes">
<div align="right"><a href="http://www.iesebre.com/webfaltes_wiki/index.php/Projectes_de_s%C3%ADntesi/M%C3%B2dul_Gesti%C3%B3_de_Dades_Externa"><img src="/webfaltes/imatges/Ajuda.gif"></img></a></div>
<br></br>
<form name="form1" method="post" action="profile_father.php"  enctype="multipart/form-data">
<table width="50%" border="0"  align="center" bgcolor="#f6f6f6">
<thead>
	<tr>
		<td colspan="5" class="titol_taula" align="center">{t}Father profile{/t}
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
		<td>{t}Code{/t}</td>
		<td>{$father_code}</td>
		<td rowspan="5"><img src="{$profile_photo_medium}" ></td><!--width="131.34px" height="83px" -->
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Name{/t}</td>
		<td>{$father_name}</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Address{/t}</td>
		<td>{$address}</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Postcode{/t}</td>
		<td>{$postcode}</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>{t}City{/t}</td>
		<td>{$city}</td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>{t}User{/t}</td>
		<td>{$user}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Email{/t}</td>
		<td>{$email}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>{t}Mobile phone{/t}</td>
		<td>{$mobile_phone}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>{t}Receive SMS{/t}</td>
		<td>{$vol_sms}</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>{t}Receive EMAIL{/t}</td>
		<td>{$vol_email}</td>
		<td></td>
		<td></td>
	</tr><!--
	<tr>
		<td>&nbsp;</td>
		<td>{t}Is father{/t}</td>
		<td>{t}{$is_father}{/t}</td>
		<td></td>
		<td></td>
	</tr>-->
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
			<input type="submit" name="return" value="{t}Return{/t}">
		</td>
	</tr>
</tbody>
</table>
<!--{t}{$status}{/t}-->

</div>
