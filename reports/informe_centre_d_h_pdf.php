<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Alfred Monllaó Calvet
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
 * $Id$
 */

session_start();
// Incloem els fitxers necessaris: ADODB, seguretat, connexió, configuració i funcions
include_once("../config.inc.php");
include_once("../seguretat.inc.php");


$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$utils = new utils();
$RSRC = array();

//Recuperem les variables necessàries per executar les consultes
$students_codes_0=array();
$grup=array();
$grup_ant=array();
$l=0;
if($_SESSION['es_coordinador'] != 0){
	
					$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
					$utils->p_dbg($RSRC, "Prova log");
					$result_1 = $ConTut->Execute($RSRC['CONSULTA_GRUP_NIVELL_EDUCATIU']) or die($ConTut->ErrorMsg());
					$hi_ha_incidencies = 0;
					$students = array();
					 while (!$result_1->EOF) {
					 		$codi_grup=$result_1->fields['codi_grup'];
					 		$nom_grup=$result_1->fields['nom_grup'];
					 		$j=0;
					 		$dngrup = cercaGrup($codi_grup);
							$ldapconfig['host'] = _LDAP_SERVER;
							#Només cal indicar el port si es diferent del port per defecte
							$ldapconfig['port'] = _LDAP_PORT;
							$ldapconfig['basedn'] = $dngrup;
									
							$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
									
							ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
									
							$password=_LDAP_PASSWORD;
									#$dn="cn=admin,".$ldapconfig['basedn'];
							$dn=_LDAP_USER;
									
							$primer_cop = 1;
							if ($bind=ldap_bind($ds, $dn, $password)) {
								if ($bind=ldap_bind($ds)) {
								  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
									$filter = "(objectClass=inetOrgPerson)";
									
									if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
									    echo("Unable to search ldap server<br>");
									    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
									} else {
									    $number_returned1 = ldap_count_entries($ds,$search);
									    ldap_sort($ds, $search, "cn"); 
									    $info = ldap_get_entries($ds, $search);
									    for ($i=0; $i<$info["count"];$i++) {
											$students_codes_0[$i]=$info[$j][_LDAP_USER_ID][0];
											$j=$j+1;
							     		}
									}
									    
								} else {
									echo("Unable to bind anonymously<br>");
									echo("msg:".ldap_error($ds)."<br>");
								}
							} else {
								echo("Unable to bind to server.</br>");

								echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
									  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
									  #we can figure out the right pattern by searching the user tree
									  #remember to turn on the anonymous search on the ldap server
									  
							}
							ldap_close($ds);
							for ($m=0;$m<$number_returned1;$m++){
							$VALS['codi_alumne']=$students_codes_0[$m];
							$VALS['codi_grup'] = $codi_grup;
							$VALS['str_data_informe'] = '2010-09-15';
							$VALS['hora_informe'] = '5';
							$VALS['motius_informe'] = '(1,2,3,4,5)';
							$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
							$utils->p_dbg($RSRC, "Prova log");
							$result_2 = $ConTut->Execute($RSRC['CONSULTA_FALTES_HORA_GRUP_ALUMNE']) or die($ConTut->ErrorMsg());
							//$primer_cop = 1;
							$color="#d0d0d0"; //variable per alternar el color de 
							                  //les files
							$students_names=array();
							$teachers_names=array();
							$j=0;
							$k=0;
							while (!$result_2->EOF) {					
								$codi_alumne=$result_2->fields['codi_alumne'];
								$motiu_curt=$result_2->fields['motiu_curt'];
								$nom_assignatura=$result_2->fields['nom_assignatura'];
								$codi_professor=$result_2->fields['codi_professor'];
								$codi_grup2=$codi_grup;
								$dngrup = cercaGrup($codi_grup2);
								$ldapconfig['host'] = _LDAP_SERVER;
								#Només cal indicar el port si es diferent del port per defecte
								$ldapconfig['port'] = _LDAP_PORT;
								$ldapconfig['basedn'] = $dngrup;
										
								$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
										
								ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
										
								$password=_LDAP_PASSWORD;
										#$dn="cn=admin,".$ldapconfig['basedn'];
								$dn=_LDAP_USER;
										
										
								if ($bind=ldap_bind($ds, $dn, $password)) {
									if ($bind=ldap_bind($ds)) {
									  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
										$filter = "(&(objectClass=inetOrgPerson)(employeeNumber=".$codi_alumne."))";
										
										if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
										    echo("Unable to search ldap server<br>");
										    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
										} else {
										    $number_returned = ldap_count_entries($ds,$search);
										    ldap_sort($ds, $search, "cn"); 
										    $info = ldap_get_entries($ds, $search);
										    for ($i=0; $i<$info["count"];$i++) {
												$students_names[0]=$info[0]['cn'][0];
												$j=$j+1;
								     		}
										}
										    
									} else {
										echo("Unable to bind anonymously<br>");
										echo("msg:".ldap_error($ds)."<br>");
									}
								} else {
									echo("Unable to bind to server.</br>");
	
									echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
										  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
										  #we can figure out the right pattern by searching the user tree
										  #remember to turn on the anonymous search on the ldap server
										  
								}
								ldap_close($ds);
								$ldapconfig['host'] = _LDAP_SERVER;
								#Només cal indicar el port si es diferent del port per defecte
								$ldapconfig['port'] = _LDAP_PORT;
								$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
										
								$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
										
								ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
										
										
								if ($bind=ldap_bind($ds, $dn, $password)) {
									
									if ($bind=ldap_bind($ds)) {
									  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
										$filter = "(&(objectClass=inetOrgPerson)(employeeNumber=".$codi_professor."))";
										
										if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
										    echo("Unable to search ldap server<br>");
										    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
										} else {
										    $number_returned = ldap_count_entries($ds,$search);
										    ldap_sort($ds, $search, "cn"); 
										    $info = ldap_get_entries($ds, $search);
										    for ($i=0; $i<$info["count"];$i++) {
												$teachers_names[0]=$info[0]['cn'][0];
												$k=$k+1;
								     		}
										}
										    
									} else {
										echo("Unable to bind anonymously<br>");
										echo("msg:".ldap_error($ds)."<br>");
									}
								} else {
									echo("Unable to bind to server.</br>");
										
									echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
										  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
										  #we can figure out the right pattern by searching the user tree
										  #remember to turn on the anonymous search on the ldap server
										  
								}
								ldap_close($ds);
								
								$student=new student();
								$smarty->assign('CODI_GRUP',$codi_grup2);
								//if($students_names[0] && $teachers_names[0]){
								$student->name=$students_names[0];
								$student->motiu_curt=$motiu_curt;
								$student->nom_assignatura=$nom_assignatura;
								$student->nom_professor=$teachers_names[0];
								$student->nom_group=$codi_grup2;
								//}
								$results[]=array('i' => $l,
								'primer_cop' => $primer_cop,
								'grup' => $codi_grup2);
								$l++;
								if ($primer_cop){
									$smarty->assign('PRIMER_COP',$primer_cop);
									//print "<table border=\"1\" width=\"700\"> <table border=\"0\" width=\"700\"> <tr><td colspan=\"5\" bgcolor = \"#d0d0d0\"><h3> ".$codi_grup." </h3></td></tr> ";
									//print"<tr bgcolor = \"#d0d0d0\"><th width=\"250\" align =\"left\"> &nbsp; Alumne/a &nbsp;</th><th align =\"left\" width=\"100\"> &nbsp; Incidència &nbsp;</th><th align =\"left\" width=\"150\">&nbsp; Assignatura &nbsp;</th><th align =\"left\"  colspan=2  width=\"200\">&nbsp;Professor/a &nbsp;</th></tr>";
									$primer_cop = 0;
									$hi_ha_incidencies = 1;
								}
								
								$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
								$smarty->assign('COLOR',$color);
								//print"<tr bgcolor=".$color."><td> &nbsp;".$nom_alumne." &nbsp;</td><td> &nbsp;".strtoupper($motiu_curt)." &nbsp;</td><td>&nbsp; ".$nom_assignatura."&nbsp;</td><td colspan =\"2\">&nbsp;".$nom_professor."&nbsp;".$cognom1_professor."&nbsp;</td></tr>";
								$students[]=$student;
								foreach ($students as $student){
									$data[]=array($student->name,$student->motiu_curt,$student->nom_assignatura,$student->nom_professor." ".$student->cognom1_professor);
									}
								$result_2->MoveNext(); //següent incidència
								}
								$color="#ffffff"; //variable per alternar el color
												 // de les files
								//print "</table></table><p>";
							$result_2->Close();
	
							}
						$result_1->MoveNext(); //següent grup
						}
						$result_1->Close();
						}

//Munto el vector de dades

//Munto la capçalera
$header=array('Alumne/a','Incidència','Assignatura','Professor');
//nova instància amb capçalera
$pdf=new institut_ebre_new();
//Marge esquerre
$pdf->SetLeftMargin(23);
//Nova pàgina
$pdf->AddPage();
//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc i per últim el tamany
$pdf->SetFont('Arial','B',12);

//Capçalera
//color
$pdf->SetFillColor(150,150,150);
//variable que ens indica si la cel·la s'ha de pintar o no
$fill=true;
//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació, color)
$pdf->Cell(150,12,utf8_decode($codi),1,0,'C',$fill);
//Salt de línia
$pdf->Ln();
//ens indica en quina columna ens trobem
$x=0;
$pdf->SetFont('Arial','',8);
//recorrem el vector de la capçalera i imprimim cada camp en una casella
foreach($header as $col){
	if($x==0)
	$pdf->Cell(70,7,utf8_decode($col),1,0,'L',$fill);
	else{
		if($x==1)
		$pdf->Cell(30,7,utf8_decode($col),1,0,'L',$fill);
		else{
			if($x==2)
			$pdf->Cell(20,7,utf8_decode($col),1,0,'L',$fill);
			else{
				$pdf->Cell(30,7,utf8_decode($col),1,0,'L',$fill);
			}
		}
	}
	$x=$x+1;
}

$pdf->Ln();

//Dades
$pdf->SetFillColor(219,219,219);
$fill=false;
//recorrem la matriu de dades i imprimim cada camp en una casella
foreach($data as $row)
{
	$x=0;
	foreach($row as $col){
		if($x==0)
		$pdf->Cell(70,7,utf8_decode($col),1,0,'L',$fill);
		else{
			if($x==1)
			$pdf->Cell(30,7,utf8_decode($col),1,0,'L',$fill);
			else{
				if($x==2)
				$pdf->Cell(20,7,utf8_decode($col),1,0,'L',$fill);
				else{
					$pdf->Cell(30,7,utf8_decode($col),1,0,'L',$fill);
				}
			}
		}
		$x=$x+1;
	}
	//canviem el valor per fer el pijama
	$fill=!$fill;
	$pdf->Ln();
}
//enviem tot al pdf
//$pdf->Output();
?>