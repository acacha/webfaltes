{*******************************************************************************
Main Template @ author: sergi.tur@upc.edu @ maintainer:
sergi.tur@upc.edu Variables @ title Web page's title @ HEADER_LOGO_PATH
Path to header logo @ user_name User name to show at header @ time
Current time @ menu_options Associative array with menu options names
and URLs
*******************************************************************************}

<title>{$title}</title>
<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="stylesheet" type="text/css" href="css/calendar.css" />
<script type="text/javascript" src="javascript/ajax_insert_absence.js"> 
</script>
<script type="text/javascript" src="javascript/calendar.php"> 
</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- Here goes the header -->
<div class="header">
		<img src="{$HEADER_LOGO_PATH}" width="100%" height="100">	
</div>
<div class="contenedor_molletes">
<a class='molletes' href="{$first_level_url}">Inici</a>
{if isset($second_level_url)}
<a class='molletes' href="{$second_level_url}"> > {$name_of}</a>
{/if}
{if isset($third_level_url)}
<a class='molletes' href="{$third_level_url}"> > {$name_of2}</a>
{/if}
</div>
<!-- Here goes navigation menu -->
<div class="contenedor_pestañesup">

<ul>
{foreach from=$menu_options key=k item=v}
<li><a class="pestaña" href="{$k}">{$v}<span id="texto1" class="solapa">
</span></a></li>
{/foreach}</ul>	<a class="usuari"href="{$show_profile}">
{if isset($substitut)}
<font size="-2" color="red">{$substitut}: </font>
{/if}
{$user_name} 
{if isset($user_type)}
 (<font size="-2"><b>Usuari</b>: {$user_loginname} <b>Rol</b>:{$user_type} <b>Codi</b>:{$user_code}</font>)
{/if} <img src="{$LOGO_ACCES_PROFILE_PATH}"></img></a>



</div>