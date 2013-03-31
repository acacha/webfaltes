<?php 
/*---------------------------------------------------------------
 * Webfaltes   File: selec_informe.php
 * Autor: Carles Año   Data:
 * Modifier: Sergi Tur   Data: 24/10/2009
 * Description: Reports Menu
 * Pre condi.:
 * Post cond.:
 ----------------------------------------------------------------*/
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Anyo
 * Coautors: rmz
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
 *$Id$
 */
// Session managment
session_start();

// Includes
include_once("config.inc.php");
include_once("seguretat.inc.php");

$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$name_of="Escollir informe";


//We load here common header application
require_once _INCLUDES.'common-header.php';


$_SESSION['primer_nivell']="informes";

if (isset($_SESSION['es_coordinador'])) {
	if($_SESSION['es_coordinador'] != 0){
		$smarty->assign('is_coordinator', "true");	
		$smarty->assign('group_reports', "true");
	}
}

if (isset($_SESSION['num_grups_tutor'])) {
	if($_SESSION['num_grups_tutor'] > 0 ){
		$smarty->assign('group_reports', "true");
	}
}	
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
$smarty->display('select_informe.tpl');

//We load here common foot application
$smarty->display('foot.tpl');

?>