<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas
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

//Crido a la classe pdf
//Per tenir capçalera informe_pdf.php // sense capçalera fpdf.php
//require(_BASE_PATH."/pdf/informe_pdf.php");

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$utils = new utils();
$RSRC = array();
$VALS = array();

//echo "Codi Grup:". $codi_grup . "</br>";

//Recuperem les variables necessàries per executar les consultes
$usuari = $_SESSION['usuari'];
$str_data_inicial=$_SESSION['str_data_inicial'];
$str_data_final=$_SESSION['str_data_final'];
$top=$_SESSION['top'];

//carrego les variables de les funcions
$VALS['str_data_inicial'] = $str_data_inicial;
$VALS['str_data_final'] = $str_data_final;
$VALS['top'] = $top;
$ixx=1;
$j=0;
$num=0;
$teachers_names= array();
$teachers_codes= array();
$groups_codes= array();
$groups_names= array();
					$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
					$utils->p_dbg($RSRC, "Prova log");
					$result_1 = $ConTut->Execute($RSRC['CONSULTA_GRUP_NIVELL_EDUCATIU']) or die($ConTut->ErrorMsg());
					while (!$result_1->EOF) {
					 		$groups_codes[$num]=$result_1->fields['codi_grup'];
					 		$groups_names[$num]=$result_1->fields['nom_grup'];
					 		$VALS['codi_grup'] = $groups_codes[$num];
							$utils->get_global_resources($RSRC,"db/sql_querys_inc.php", $VALS);
							$utils->p_dbg($RSRC, "Prova log");
							$result = $ConTut->Execute($RSRC['selec_grup_tutor']) or die($ConTut->ErrorMsg());
							while(!$result->EOF) {
								$nom_g=$result->fields['nom_grup'];
								$codi_tutor= $result->fields['tutor'];
								$result->MoveNext();
							}
							$result->Close();

							$ldapconfig['host'] = _LDAP_SERVER;
							#Només cal indicar el port si es diferent del port per defecte
							$ldapconfig['port'] = _LDAP_PORT;
							$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
									
							$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
									
							ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
									
							$password=_LDAP_PASSWORD;
									#$dn="cn=admin,".$ldapconfig['basedn'];
							$dn=_LDAP_USER;
									
									
							if ($bind=ldap_bind($ds, $dn, $password)) {
								if ($bind=ldap_bind($ds)) {
									
								  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
									$filter = "("._LDAP_USER_ID."=".$codi_tutor.")";
									
									if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
									    echo("Unable to search ldap server<br>");
									    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
									} else {
									    $number_returned = ldap_count_entries($ds,$search);
									    ldap_sort($ds, $search, "cn"); 
									    $info = ldap_get_entries($ds, $search);
									    for ($i=0; $i<$info["count"];$i++) {
											$teachers_names[$j]=$info[0]['cn'][0];
											$teachers_codes[$j]=$info[0][_LDAP_USER_ID][0];
											$j++;
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
									// Usuari i contrasenya vàlids (Control seguretat 1)
							ldap_close($ds);
							$num++;
						$result_1->MoveNext();
					 }
					 $result_1->Close();
/*$dngrup = cercaGrup($codi_grup);
	$students_names=array();
	$students_codes=array();
	
	$ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = $dngrup;
			
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
			
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			
	$password=_LDAP_PASSWORD;
	$dn=_LDAP_USER;		
			
			
	if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
			
		  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
			$filter = "(objectClass=inetOrgPerson)";
			
			if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
			    echo("Unable to search ldap server<br>");
			    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
			} else {
			    $number_returned = ldap_count_entries($ds,$search);
			    ldap_sort($ds, $search, "cn"); 
			    $info = ldap_get_entries($ds, $search);
			   	$entry = ldap_first_entry($ds, $search);
			    for ($i=0; $i<$info["count"];$i++) {
				$students_names[$i]=$info[$j]['cn'][0];
				$students_codes[$i]=$info[$j]['employeenumber'][0];
				//NOTA: Li diem jpeg_data tot i que realment a Ldap podem haver 
				//fotos d'altre format. De fet les fotos dels alumnes són PNG
				$jpeg_data = ldap_get_values_len($ds, $entry, "jpegphoto");
				//print_r($jpeg_data);
				/*$photo_filename="/tmp/".$students_codes[$i].".png";
				$outphoto = fopen ($photo_filename,"wb");*/
				//PHOTO FILE PATH:
				/*$jpeg_filename="/tmp/".$students_codes[$i]."_alpha.png";
				//SAVE BASENAME for after use:
				$jpeg_file[$i]=$students_codes[$i].".png";
				for( $l=0; $l<$jpeg_data['count']; $l++ ) {
					$outjpeg = fopen($jpeg_filename, "wb");
					fwrite($outjpeg, $jpeg_data[$l]);
					fclose ($outjpeg);
					$jpeg_data_size = filesize( $jpeg_filename );
					if( $jpeg_data_size < 6 ) {
						echo "jpegPhoto contains errors<br />";
						echo '<a href="javascript:deleteJpegPhoto();" style="color:red; font-size: 75%">Delete Photo</a>';
						continue;
					}
		     		}
		            //Convert image to image without Alpha Channel: TODO: Try to use TCPDF instead of FPDF		
		            //We need imagemagick installed on server
		            //http://acacha.org/mediawiki/index.php/Imagemagick#Eliminar_el_canal_Alfa
		            //convert 201011-406.png -background white -flatten +matte 201011-406_no.png
		            $cmd="/usr/bin/convert $jpeg_filename -background white -flatten +matte /tmp/$jpeg_file[$i]";
		            //echo "$cmd"."</br>";
		            exec($cmd);
		            
			    $j=$j+1;	    
			    $entry = ldap_next_entry($ds, $entry);
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
			  
	}*/
			// Usuari i contrasenya vàlids (Control seguretat 1)
	//ldap_close($ds);
	
	//print "<table border=1>";
		/*$st_co='\'';
		$st_co.=join('\', \'', $students_codes);
		$st_co.='\'';*/

//Em quedo amb els camps que vull del vector auxiliar
/*foreach ($data1 as $row){
	$data[]=array($row[$students_names[0]]);
}*/

//Munto la capçalera
$header=array('Codi Grup','Nom Grup','Codi Tutor/a','Nom Tutor/a');

//Poso les dates amb el format que m'interessa
$date_i=strftime("%d-%m-%Y",strtotime("$str_data_inicial"));
$date_f=strftime("%d-%m-%Y",strtotime("$str_data_final"));

//Nova instància de la classe sense capçalera
$pdf=new institut_ebre_new();
//Marge esquerre
$pdf->SetLeftMargin(15);
//Nova pàgina
$pdf->AddPage();
//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc i per últim el tamany
$pdf->SetFont('Arial','',12);

//Capçalera
//color
$pdf->SetFillColor(150,150,150);
//variable que ens indica si la cel·la s'ha de pintar o no
$fill=true;
//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació, color)
$pdf->Cell(180,0,"Llistat de tutors per als grups. ",0,0,'C');
//Salt de línia
$pdf->Ln(7);
//ens indica en quina columna ens trobem
$x=0;
$pdf->SetFont('Arial','',11);
//recorrem el vector de la capçalera i imprimim cada camp en una casella
foreach($header as $col){
	if($x==0)
		$pdf->Cell(20,8,utf8_decode($col),1,0,'C',$fill);
	else{
		if($x==1)
			//$pdf->Cell(10,8,utf8_decode($col),1,0,'C',$fill);
			$pdf->Cell(60,8,utf8_decode($col),1,0,'C',$fill);
		else{
			if($x==2)
				$pdf->Cell(25,8,utf8_decode($col),1,0,'C',$fill);
			
			else{
				$pdf->Cell(60,8,utf8_decode($col),1,0,'C',$fill);
			}
		}
	}
	$x=$x+1;
}

$pdf->Ln();

//Dades
$pdf->SetFillColor(219,219,219);
$fill=false;
$pdf->SetFont('Arial','',8);
//recorrem la matriu de dades i imprimim cada camp en una casella
$x=0;
for($t=0;$t<$num;$t++){

	$pdf->Cell(20,8,$groups_codes[$t],1,0,'C',$fill);
	$pdf->Cell(60,8,utf8_decode($groups_names[$t]),1,0,'C',$fill);
	$pdf->Cell(25,8,$teachers_codes[$t],1,0,'C',$fill);
	$pdf->Cell(60,8,utf8_decode($teachers_names[$t]),1,0,'C',$fill);
		
	//$fill=!$fill;
	$pdf->Ln();
}
//enviem tot al pdf
$today = date('Y_m_d');   
//$pdf->Output();
$pdf->Output("Tutors_dels_grups_("._ANY_COMENCAMENT_CURS."-"._ANY_FINALITZACIO_CURS.")_".$today.".pdf","I");
?>
