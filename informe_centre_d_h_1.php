<?php
/* 
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Pau Gomez & Albert Mestre 
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
 *$Id:informe_centre_d_h_1.php 1329 2010-07-16 12:30:48Z irent88 $
 *
 */

/**
 * Webfaltes
 * @author Carles Añó, Pau Gómez
 * @desc Informe resum d'incidències del centre un dia determinat a una hora
 * 		determinada. Selecció del dia i la hora i els tipus d'incidències.
 * @see informe_centre_d_h_1.php, informe_centre_d_h_1.tpl
 */

// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració
// i funcions

include_once("config.inc.php");
include_once("seguretat.inc.php");



$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_CENTRE_D_H_1;
$name_of="Escollir informe";
$name_of2="Incidències del centre del dia d a l'hora h";


//We load here common header application
require_once _INCLUDES.'common-header.php';

//Declaració de arrays
$utils = new utils();

$RSRC = array();

	$imprimir_data= date('d-m-Y');
	$smarty->assign('imprimir_data', $imprimir_data);
	
	$smarty->assign('group_hidden_field',$codi_grup);

		
	// CONSULTA SQL    mostrar les possibles hores 
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php");
		$utils->p_dbg($RSRC, "Prova log");
		$result = $ConTut->Execute($RSRC['MOSTRAR_HORES']) or die($ConTut->ErrorMsg());
	// FI CONSULTA
	
		$hores=array();
		
		while (list($codi_hora, $hora_inici, $hora_final)=$result->fields) {
		$hores["$codi_hora"]=$hora_inici. " - " . $hora_final;
		
						$result->MoveNext(); //seguent grups*/
		}

		$smarty->assign('hores',$hores);
		
		$result->Close();
			
//We load here common foot application
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);
$smarty->display('informe_centre_d_h_1.tpl');
$smarty->display('foot.tpl');
?>