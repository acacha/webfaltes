<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: ester & ivan
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
 */
/*$Id:informe_centre_di_df_1.php 1400 2010-09-22 08:03:49Z irent88 $*/
/**
 * Aquest progrma serveix per a generar una serie d'opcions, per a despres fer 
 * la consulta amb aquestes opcions. Es a dir pots dir si mostres o no per 
 * faltes, per expulsions, per faltes justificades, etc..
 * @author Ivan Gomez Romero
 * @license GNU
 * @see informe_centre_di_df_1.php
 * @copyright 2010
 */

// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i
// funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_CENTRE_DI_DF_1;
$name_of="Escollir informe";
$name_of2="Incidències del centre entre una data inicial i una data final ";


//We load here common header application
require_once _INCLUDES.'common-header.php';

				
				$imprimir_data= date('d-m-Y');
				$smarty->assign('IMPRIMIR_DATA', $imprimir_data);
			
				$imprimir_data_2= date('d-m-Y');
				$smarty->assign('IMPRIMIR_DATA_2', $imprimir_data_2);
/*We load here common foot application*/
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
$smarty->display('foot.tpl');
$smarty->display('informe_centre_di_df_1.tpl');
$smarty->display('foot.tpl');
?>