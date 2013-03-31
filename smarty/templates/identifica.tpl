{literal}
<script type="text/javascript">
function identify()
{
	
	var Index = document.getElementById("person").selectedIndex;
   

    if(Index == 2)
	{
		document.location='identifica_pare.php';
	}
	if(Index == 1)
	{ 
		document.location='identifica_alumne.php';	 
	}
	if(Index == 0)
	{
		document.location='identifica.php';
	}
} 

</script>
{/literal}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<script language="javascript" type="text/javascript"
	src="css/login/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all"
	href="css/login/niceforms-default.css" />
</head>

<body>
<a href="{$smarty.const._URL} "><img src="imatges/capsalera.jpeg" /></a>
<br></br>


<h1>ACCÉS A L'INTRANET DEL CENTRE</h1>
<br><br/>
<div id="container">
<form name="form1" method="post" action="{$URL_ACTION_FORM}"
	class="niceform"><br></br>
<fieldset><legend>{t}User autentication{/t}</legend>
<dl>
	<dt><label for="person">{t}Role{/t}</label></dt>
	<dd><select name="person" id="person" onChange="identify();" >
	{if $tipusSelected eq 0}
		<option value="$_TEACHER" selected>{t}Professor{/t}</option>
	{else}
    	<option value="$_TEACHER" >{t}Professor{/t}</option>	
	{/if}
	{if $tipusSelected eq 1}
		<option value="$_STUDENT" selected>{t}Estudiant{/t}</option>
	{else}
		<option value="$_STUDENT">{t}Estudiant{/t}</option>
	{/if}
	{if $tipusSelected eq 2}
		<option value="$_FATHER" selected>{t}Pare/Mare{/t}</option>
	{else}	
		<option value="$_FATHER">{t}Pare/Mare{/t}</option>
	{/if}
	</select></dd>
</dl>
<dl>
	<dt><label for="usuari">{t}User{/t}:</label></dt>
	<dd><input type="text" name="usuari" id="email" size="20"
		maxlength="20" /></dd>
</dl>
<dl>
	<dt><label for="password">{t}Password{/t}:</label></dt>
	<dd><input type="password" name="contrasenya" size="20"
		maxlength="20" /></dd>
</dl>

<dl></dl>

<center><input type="submit" name="enviar" value="{t}Send{/t}"></input><input
	type="reset" name="esborrar" value="{t}Reset{/t}"></input></center>
<p></p>
<a href="form_recovery_password.php">{t}I forget my password{/t}</a>
</fieldset>
</form>

<div align="center">
<img src="imatges/nav.png" width="200px" height="80px"/>
</div>
</div>


</body>
</html>