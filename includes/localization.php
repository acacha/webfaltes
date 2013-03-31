<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Pau Gómez 
 *
 * This library is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation; either version 2.1 of the License, or (at your option)
 * any later version.
 * 
 * This library is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with this library; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 * http://www.fsf.org/licensing/licenses/lgpl.txt
 *
 *$Id$
 *
 */

// define constants
define("_PROJECT_DIR", realpath('./'));
define("_LOCALE_DIR", _PROJECT_DIR .'/locales');
define("_DEFAULT_LOCALE", 'ca_ES.UTF8');

if (!is_readable("/usr/share/php/php-gettext/gettext.inc")){
	echo "<div style='background-color: #FFCCCC;border: 2px solid #FF0000;margin: 0 10px 10px;
    padding: 10px;text-align: center;'><b>ERROR!</b> No existeix la llibreria gettext per a PHP, fitxer: <b>
	/usr/share/php/php-gettext/gettext.inc</b><br/> Consulteu la 
	<a href=\"http://acacha.org/mediawiki/index.php/Webfaltes#Instal.C2.B7lar_depend.C3.A8ncies\">
	documentació de l'aplicació</a></div>";	
	exit();
}
else {
	require_once("/usr/share/php/php-gettext/gettext.inc");
}

//Nom utilitzat per l'exemple localization_example.php
$supported_locales = array('en_US', 'sr_CS', 'de_CH','es_ES');
$encoding = 'UTF-8';

//Agafar el locale del paràmetre lang
$locale = (isset($_GET['lang']))? $_GET['lang'] : _DEFAULT_LOCALE;
//DEFAULT_LOCALE = ca_ES.UTF8

// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'messages';
T_bindtextdomain($domain, _LOCALE_DIR);
T_bind_textdomain_codeset($domain, $encoding);
T_textdomain($domain);

// gettext setup
#setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
#$domain = 'messages';
#bindtextdomain($domain, _LOCALE_DIR);
#bind_textdomain_codeset($domain, $encoding);
#textdomain($domain);

//header("Content-type: text/html; charset=$encoding");
?>