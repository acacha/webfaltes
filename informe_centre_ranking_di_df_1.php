<?php
/**
 * @author Carles Añó
 * @desc Seleccionar les dates i el número d'alumnes per mostrar al rànquing
 * @see informe_centre_ranking_di_df_1.php
 */

/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
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
 *$Id:informe_centre_ranking_di_df_1.php 1211 2010-06-02 12:48:07Z ccristoful $
 */
// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");

$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_CENTRE_RANKING_DI_DF_1;
$name_of="Escollir informe";
$name_of2="Rànquing incidències del centre entre una data inicial i una data final ";

//We load here common header application
require_once _INCLUDES.'common-header.php';

$date=date('d-m-Y');
$smarty->assign('DATE',$date);/* print date('d-m-Y')*/; 
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
//We load here common foot application
$smarty->display('informe_centre_ranking_di_df_1.tpl');
$smarty->display('foot.tpl');
?>