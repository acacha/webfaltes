{*******************************************************************************
index1 This is the template for index.php file (check attendance) @
author: sergi.tur@upc.edu @ maintainer: sergi.tur@upc.edu Variables @
ACTION_URL Action form URL @ TODAY Current day @ SELECTED_DAY Day
selected by user @ results Associative array with groups data @
results.time_interval Group's time interval @ results.url URL to check
attendance @ results.group_name Group's name @ results.subject_name Name
of class
*******************************************************************************}
<link rel="stylesheet" type="text/css" href="css/styles.css"/>

<script type="text/javascript">
{literal}
var bas_cal,dp_cal,ms_cal;      
window.onload = function () {
  dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('popup_container'));
  
};
function hola(){
alert ("hola");
}
{/literal}
</script>
<div class="contenedor_pestañes">
<br></br>
<table align="center" bgcolor="#f6f6f6">
<tr>
	<form id="data" name="el_data" action="{$ACTION_URL}" method="get">
	
		<td>{t}Choose date (dd-mm-aaaa format):{/t}</td>
		<td><input id="popup_container" type="text" name="str_data"
			value="{$TODAY}"  on="javascript:hola();"/></td>
		<td><input type="submit" value="{t}Change{/t}"></td>
	</form>
	<form name="el_data_avui" action="{$ACTION_URL}" method="get"><input
		type="hidden" name="str_data" value="{$TODAY}">
	<td><input type="submit" value="{t}Today{/t}"></td>
	</form>
	</tr>
</table>
<br></br>
<p><p></p>
<p>
<table border="0" align="center" bgcolor="#f6f6f6">
<thead>
	<tr align="center">
		<td colspan="5" class="titol_taula">{t}Check Attendance{/t} {$SELECTED_DAY}</td>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
	</tr>

	<!-- Iteration that shows teacher groups for selected day-->
	{foreach from=$results item=i}
	<tr align="center" class="{cycle values='tr0,tr1'}">
		<td>&nbsp;</td>
		<td>{$i.time_interval}</td>
		<td><a href="{$i.url} ">{$i.group_name}</a></td>
		<td>{$i.subject_name}</td>
		<td>&nbsp;</td>
	</tr>
	{/foreach}
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	</tbody>
</table>
</div>
