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
 *$Id:informe_resum_grup_di_df_1.php 1211 2010-06-02 12:48:07Z ccristoful $
 */
// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start() ;

// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions
include_once("config.inc.php");
include_once("seguretat.inc.php");


$first_level_url=_FIRST_LEVEL_TAKE_ATTENDACE_URL;
$second_level_url=_SECOND_LEVEL_REPORTS;
$third_level_url=_THIRD_LEVEL_REPORTS_RESUM_GRUP_DI_DF_1;
$name_of="Escollir informe";
$name_of2="Resum d'incidències d'un grup entre una data inicial i una data final";

//We load here common header application
require_once _INCLUDES.'common-header.php';

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
//$int_data=date('Y-m-d', $_SESSION['data']);


/*
	<p><br>
	<p><br>
	<center>
	<form name="tipus_informe" method="post" action="informe_resum_grup_di_df_2.php">
	<table border = "0">
	<tr>
	<td><p>Selecciona el grup: </td>
	<td>
	
	<select name="grup">
*/
				if($_SESSION['es_coordinador'] != 0){

					$utils = new utils();

					$RSRC = array();
					$VALS = array();

					$utils->p_dbg($RSRC, "GRUPS_INFORME_RESUM_COORD");
					$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
					
					$result_6 = $ConTut->Execute($RSRC['GRUPS_INFORME_RESUM_COORD']) or die($ConTut->ErrorMsg());
					
					
					$Group_code=array();
					
					 while (list($codi_grup)=$result_6->fields) {
	
						//print "<option>".$codi_grup;	
						$Group_code[]= $codi_grup;
						$smarty->assign('Group_code',$Group_code);

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
					 	
						//print "<option>".$codi_grup;
						
					 	$Group_code[]= $codi_grup;
						$smarty->assign('Group_code',$Group_code);
						
						$result_7->MoveNext(); //següent grup
					}
					$result_7->Close();
				}
						
					
			$Final_date=date('d-m-Y');  //Sta comentat 133.

	
	
	/*
	</select>
	</td>
	</tr>
	<tr>
	<td><p>Escriu la data inicial:</td>
	<td><input type="Text" name="data_inicial" value="01-11-2008"></td>
	</tr>
	<tr>
	<td><p>Escriu la data final:</td>
	<td><input type="Text" name="data_final" value= <?php print date('d-m-Y'); ?> > </td>
	</tr>
	<tr>
	<td colspan="2" align="center">	<p><br><input type="submit" value="Veure informe"></td>
	</tr>
	</table>
	</form>
	</center>
	<?php
	/*

	//fem la consulta per recuperar els alumnes del grup	
	$sql  = "SELECT codi_alumne, nom_alumne";
	$sql .= " FROM alumne ";
    $sql .= " WHERE codi_grup = '$codi_grup'";
    $result = $ConTut->Execute($sql) or die($ConTut->ErrorMsg());
	
	
	$color="#f6f6f6"; //variable per alternar el color de les files
    while (list($codi_alumne, $nom)=$result->fields) {
		$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
		print "<tr bgcolor=".$color."> ";
			print "<td> ".$nom."</td> ";
			$TOTAL_INCIDENCIES = 0;
			//per cada alumne mostrem les seves incid�ncies, per cada incid�ncia
				for ($n=1; $n <= 5; ++$n){
						$sql2  = "SELECT COUNT(*) AS total";
						$sql2 .= " FROM incidencia";
						$sql2 .= " WHERE codi_alumne = '$codi_alumne'";
						$sql2 .= " AND motiu_incidencia = '$n'";
							
						$result2 = $ConTut->Execute($sql2) or die($ConTut->ErrorMsg());
						
						if (!$result2->EOF){ 
						
							$total  = $result2->Fields('total');
							$TOTAL_INCIDENCIES = $TOTAL_INCIDENCIES + $total;
							
							$result2->Close();
				        }
						print "<td> ".$total."</td> ";
				}
				print "<td> ".$TOTAL_INCIDENCIES."</td></tr> ";
								    // Pasem al registre seg�ent del RS				        
						
						$result->MoveNext(); //seg�ent alumne
						}
					//}					
	*/

$smarty->assign('Final_date',$Final_date);
$smarty->assign('BASE_PATH_HTML', _BASE_PATH_HTML);	
$smarty->display('informe_resum_grup_di_df_1.tpl');

//We load here common foot application
$smarty->display('foot.tpl');
?>