{*******************************************************************************
selecalumn_tutoria.tpl template @ author: sergi.tur@upc.edu @
maintainer: sergi.tur@upc.edu Variables @ ACTION1_URL First action form
URL @ GROUP_CODE Group code @ ACTION2_URL Second action form URL @
SELECTED_DATE Selected date @ N_TIME_INTERVALS Number of time intervals
@ DAY_OF_WEEK Day of week
*******************************************************************************}
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<script type="text/javascript">
{literal}
var bas_cal,dp_cal,ms_cal;      
window.onload = function () {
  dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('popup_container'));
};
{/literal}
</script>
<div class="contenedor_pestañes"><br></br>
{if $data_incorrecta }
<p><blink><b>Només es pot passar llista per les dates
del curs {$any_curs_c}-{$any_curs_f} entre 01-09-{$any_curs_c} i el 24-06-{$any_curs_f}.</blink>
<p><blink> {$DATA} no és una data vàlida</b></blink> {/if}

<table align="center" bgcolor="#f6f6f6">
	<tr>
		<form name="el_data" action="{$ACTION1_URL}" method="post">
		<td>{t}Choose date (dd-mm-aaaa format):{/t}</td>
		<td><input id="popup_container" type="text" name="data"
			value="{$TODAY}" /></td>
		<input type="hidden" name="group" value="{$GROUP_CODE}">
		<td><input type="submit" value="{t}Change{/t}"></td>
	</tr>
	</form>
</table>

<form name="form1" method="post" action="{$ACTION2_URL}"><br></br>


	<center>	<table >
		<thead>
			<tr>
				<th align="center" colspan="8">
				{t}Check Attendance{/t}<br />
				</strong> {t}Group{/t}: {$GROUP_CODE} ({$N_GROUP_STUDENTS} {t}students{/t}) <br />
				{t}Date{/t}: {$SELECTED_DATE}</td>
		</thead><tbody>
		
				<tr>
					<th>&nbsp;</th>

					{foreach from=$days item=day}
					<th colspan="{$day.N_TIME_INTERVALS}" align="center"><font
						size="4">{$day.DAY_OF_WEEK}</font></th>
					{/foreach}

				</tr>

				<tr>
					<th>&nbsp;</th>
					{foreach from=$hours item=hour}
					<th align="center">{$hour.INITIAL_HOUR}<br />
					{$hour.FINAL_HOUR}</th>
					{/foreach}
				</tr>
				{section name=student loop=$students}
				<tr class="{cycle values='tr0,tr1'}">
					<td>
					{if $students_JpegPhoto[student] eq NULL} <img alt="Foto Perfil" title="Foto Perfil" src="imatges/default_small.jpg" height="61px" width="48px"></img> {else}<img alt="Foto Perfil" title="Foto Perfil" src="view_jpeg_photo.php?file={$students_JpegPhoto[student]}" height="61px" width="48px"></img>{/if} <a href="profile_student.php?codi_alumne={$students_codes[student]}"> {$smarty.section.student.iteration}. {$students_names[student]} ({$students_codes[student]})</a></td>

					{section name=result loop=$results1[student]}
			
					<td><font size="2"> <label> <select
						name="tipus_incidencia"
						onChange="javascript:ProcessXML(
		    '{$results1[student][result].url1}'+this.value+
		    '{$results1[student][result].url2}')">
						<option value="0"{$results1[student][result].selected[0]}>
						</option>
						<option value="1"{$results1[student][result].selected[1]} >F</option>
						<option value="2"{$results1[student][result].selected[2]} >FJ</option>
						<option value="3"{$results1[student][result].selected[3]} >R</option>
						<option value="4"{$results1[student][result].selected[4]} >RJ</option>
						<option value="5"{$results1[student][result].selected[5]} >E</option>

					</select> </label> </font></td>

					{/section}

				</tr>
				{/section}
		</tbody>
		<tfoot>
		
		<tr>
				<th colspan="7" align="center">
				<input type="submit" name="enviat"
			value="{t}Return{/t}">
				</th>
			</tr>
		</tfoot>
		</table></center>
</form>
</div>
