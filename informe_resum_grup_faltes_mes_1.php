<?php
/*---------------------------------------------------------------
* Aplicatiu d'incidencies   Fitxer: informe_resum_grup_di_df_1.php
* Autor: Carles Añó   Data:
* Descripció: Informe resum d'incidències dels alumnes d'un grup entre una data incial i una final
* Pre condi.:
* Post cond.:
----------------------------------------------------------------*/
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Alfred Monllaó Calvet
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
// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_RESUM_GRUP_FALTES_MES_1;
$name_of="Escollir informe";
$name_of2="Monthly Summary of unjustified absences";


//We load here common header application
require_once _INCLUDES."common-header.php";

//Recuperem variables de sessió i les simplifiquem per a més comoditat
$codi_professor = $_SESSION['codi_professor'];
$usuari = $_SESSION['usuari'];

//el grup del qual el professor  és tutor
if (isset($_SESSION['tutor_de'])) {
	$codi_grup = $_SESSION['tutor_de'];
    }
else {
        $codi_grup= "";
}
$es_coordinador=$_SESSION['es_coordinador'];
$smarty->assign('es_coordinador', $es_coordinador);
//$int_data=date('Y-m-d', $_SESSION['data']);
$codis_grup =array();
 
				if($es_coordinador != 0){

					$utils = new utils();

					$RSRC = array();
					$VALS = array();

					$utils->p_dbg($RSRC, "GRUPS_INFORME_RESUM_COORD");
					$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
					
					$result_6 = $ConTut->Execute($RSRC['GRUPS_INFORME_RESUM_COORD']) or die($ConTut->ErrorMsg());
								
					
					
					 while (list($codi_grup)=$result_6->fields) {
						$codis_grup[] = $codi_grup;
					 	//print "<option>".$codi_grup;
						$result_6->MoveNext(); //seg�ent grup
						}
						$result_6->Close();
				}else{
						
						$utils = new utils();

						$RSRC = array();
						$VALS = array();
		
						$VALS['codi_professor'] = $codi_professor;
      					
			
						$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

						$utils->p_dbg($RSRC, "Prova log");
						
						$result_7 = $ConTut->Execute($RSRC['GRUPS_INFORME_RESUM']) or die($ConTut->ErrorMsg());
										
					 while (list($codi_grup)=$result_7->fields) {
					 	$codis_grup[] = $codi_grup;
						//print "<option>".$codi_grup;
						$result_7->MoveNext(); //següent grup
					}
					$result_7->Close();
			}
	$years=array();
			
	$first_year=2008;
	$current_year = date('Y');
	while ($current_year>=$first_year){
		$years[]=$current_year;
		$current_year--; 
	}
	
	$current_month = date('m');
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);	
$smarty->assign('current_month', $current_month);
$smarty->assign('codis_grup', $codis_grup);
$smarty->assign('years', $years);
$smarty->display('informe_resum_grup_faltes_mes_1.tpl');
//We load here common foot application
$smarty->display('foot.tpl');
?>