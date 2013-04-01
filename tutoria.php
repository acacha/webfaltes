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
/*---------------------------------------------------------------
 * Webfaltes   File: tutoria.php
 * Autor: Sergi Tur   Data: 22/10/2009
 * Description: Tutorship menu
 * Pre condi.:
 * Post cond.:
 ----------------------------------------------------------------*/

// Session managment
session_start() ;

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");
$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_ADMIN;
$third_level_url=_SECOND_LEVEL_TUTORSHIP;
$name_of="Administrar";
$name_of2="Tutoria";


//We load here common header application
require_once _INCLUDES.'common-header.php';

/*
 * tutoria.tpl template variables
 * @ menu_options			Associative array with menu options names and URLs
 */



$menu_options = array();
$menu_options['selecgroup.php?form_action=selecalum_tutoria.php'] =
	T_('Groups Tutorship');

$smarty->assign('menu_options', $menu_options);

$smarty->display('tutoria.tpl');

//We load here common foot application
$smarty->display('foot.tpl');
?>