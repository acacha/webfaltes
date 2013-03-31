<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Alfred Monllaó Calvet & Sergi Tur Badenas
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
include_once(_DIR_CONNEXIO."/seguretat.inc.php");
include_once(_DIR_ADODB."/adodb.inc.php");
include_once(_DIR_CONNEXIO."/webfaltes_con.php");
include_once(_BASE_PATH."/funcions.php");
require_once(_INCLUDES."/localization.php");
include_once(_INCLUDES."/db/sql_querys_inc.php");
include_once(_DIR_CONNEXIO."webfaltes_ldap_con.php");

include_once("../funcions_ldap.php");

//Active DEBUG
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
  
//Smarty
//require_once _INCLUDES."smarty.php";
$utils = new utils();
 
$RSRC = array();
$VALS = array();

//Crido a la classe pdf
//Per tenir capçalera informe_pdf.php // sense capçalera fpdf.php
require_once("/usr/share/php/fpdf/fpdf.php");

$usuari = $_SESSION['usuari'];

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$teachers=array();
//Carrego la classe amb els valors corresponents
$j=0;
	$teachers_names=array();
	$teachers_givennames=array();
	$teachers_sn1=array();
	$teachers_sn2=array();
	$teachers_codes=array();
	
	$ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;
//	$ldapconfig['basedn'] = 'ou=Profes,ou=All,dc=iesebre,dc=com';
	$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
			
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
			
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			
	$password=_LDAP_PASSWORD;
			#$dn="cn=admin,".$ldapconfig['basedn'];
	$dn=_LDAP_USER;
			
			
	if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
			
		  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
			$filter = "(&(employeeNumber=*)(objectClass=inetOrgPerson))";
			
			if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
			    echo("Unable to search ldap server<br>");
			    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
			} else {
			    $number_returned = ldap_count_entries($ds,$search);
			    ldap_sort($ds, $search, "employeeNumber"); 
			    $info = ldap_get_entries($ds, $search);
			    $entry = ldap_first_entry($ds, $search);
			    for ($i=0; $i<$info["count"];$i++) {
					$teachers_names[$i]=$info[$j]['cn'][0];
					$teachers_sn1[$i]=$info[$j]['sn1'][0];
					$teachers_sn2[$i]=$info[$j]['sn2'][0];
					$teachers_givennames[$i]=$info[$j]['givenname'][0];
					$teachers_codes[$i]=$info[$j]['employeenumber'][0];
			    	$jpeg_data = @ldap_get_values_len($ds, $entry, "jpegphoto");
				//print_r($jpeg_data);
				/*$photo_filename="/tmp/".$students_codes[$i].".png";
				$outphoto = fopen ($photo_filename,"wb");*/
				$jpeg_filename="/tmp/".$teachers_codes[$i].".jpg";
				$jpeg_file[$i]=$teachers_codes[$i].".jpg";
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
			  
	}
			// Usuari i contrasenya vàlids (Control seguretat 1)
	ldap_close($ds);
	for($p=0;$p<$number_returned;$p++){
		$teacher= new teacher();
		$teacher->code = $teachers_codes[$p];
		//Separo els possibles noms compostos per l'espai en blanc
		$name = split(" ",$teachers_names[$p]);
		//màxim 9 caràcters al nom
		/*$name[2] = str_split($name[2],15);
		$name[0] = str_split($name[0],15);*/
		//Ens quedem el primer vector de 9 caràcters
		
		$teacher->name = $teachers_givennames[$p];
                $teacher->surname1 = $teachers_sn1[$p];
                $teacher->surname2 = $teachers_sn2[$p]; 

		$teacher->foto = $jpeg_file[$p];
		//Si no hi ha foto en carrego una altra
	/*	if ($teacher->foto==""){
			$teacher->foto="imatges/teachers/perfil.jpeg";
		}*/
		$teachers[]=$teacher;
		//$result->MoveNext();
	}


//Crido la classe
$pdf=new fpdf();
//Defineixo els marges
$pdf->SetMargins(10,10,10);
//Obro una pàgina
$pdf->AddPage();
//$pdf->AddPage("P","A3");
//Es la posicio exacta on comença a escriure
$x=7;//10
$y=15;//24

$pdf->Image(_BASE_PATH."/imatges/logo_iesebre_2010_11.jpg",$x+2,5,40,15);
//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc
$pdf->SetFont('Arial','B',15);
//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació)
$pdf->SetXY(10,10);
$pdf->Cell(190,6,"PROFESSORAT "._ANY_COMENCAMENT_CURS."-"._ANY_FINALITZACIO_CURS,0,0,C);
$y=$y+6;

//Guardo les coordenades inicials de x i y
$x_start=$x;
$y_start=$y;

//Inicio les columnes i les files a 0
$col=0;
$row=0;

//Paràmetres de tamany de les fotos, $xx indica l'amplada de la foto, $yy indica
//l'altura de cada camp del professor, l'altura de la foto es 3 vegades aquest valor
//En cas de tocar aquest paràmetres caldria revisar el màxim de columnes i files  
$xx=11;//10//Amplada horitzontal de cada professor es tocada segons el nombre de professors que hi haguin

//Sergi Tur
//Si no s'indica l'amplada vertical es posa el que toca per mantenir les proporcions
//Fotos originals: 147x186:1.265306122
//Mida: 12x15,183673464
//$yy=5;//3//Amplada vertical de cada professor es tocada segons el nombre de professors que hi haguin

//No és l'açada de la FOTO! És la alçada del que ocupa cada bloc de profe (foto+dades)
$yy=4.75;

//Amb aquestes fòrmules defineixo les coordenades de cada camp de cada professor
//Fòrmula: posició inicial de x/y * columna * camps de cada professor 

//Ampla de la columna amb el nom i cognoms del professor
$x_name=12;
//Ampla de la columna de carrecs
$x_post=9;

$x=$x_start+$col*($xx+$x_name+$x_post);
$x1=$x_start+$col*($xx+$x_name+$x_post)+$x_name;
$x2=$x_start+$col*($xx+$x_name+$x_post)+$x_name+$x_post;

$y=$y_start+$row*$yy*3;
$y1=$y_start+$row*$yy*3+$yy;
$y2=$y_start+$row*$yy*3+$yy*2;

//La i és el marge entre professors
$i=0;
$page_one=true;

//Imprimeixo sempre els conserges i secretàries en una posició fixa el primer cop
//TODO: Obtenir les dades de les carpetes personal de Gosa:
        
//Posició inicial conserges:
$initial_x_personal=161;
$initial_y_personal=242;

$width_personal_foto=10;
        
$pdf->SetFont('Arial','B',8);
$pdf->Text($initial_x_personal+3,$initial_y_personal-2,utf8_decode("CONSERGES"));                
//Foto                
$pdf->Image(_BASE_PATH."/imatges/Jordi Caudet.jpg",$initial_x_personal,$initial_y_personal,$width_personal_foto);                
$pdf->SetFont('Arial','',5);                
//Nom                
$pdf->Text($initial_x_personal+1,$initial_y_personal+14,utf8_decode("Jordi"));                
//Cognom                
$pdf->Text($initial_x_personal+1,$initial_y_personal+16,utf8_decode("Caudet"));                
$pdf->Image(_BASE_PATH."/imatges/Leonor Agramunt.jpg",$initial_x_personal+14,$initial_y_personal,$width_personal_foto);                
$pdf->Text($initial_x_personal+15,$initial_y_personal+14,utf8_decode("Leonor"));                  
$pdf->Text($initial_x_personal+15,$initial_y_personal+16,utf8_decode("Agramunt"));                
$pdf->Image(_BASE_PATH."/imatges/Jaume Benaiges.jpg",$initial_x_personal+28,$initial_y_personal,$width_personal_foto);                
$pdf->Text($initial_x_personal+30,$initial_y_personal+14,utf8_decode("Jaume"));                
$pdf->Text($initial_x_personal+30,$initial_y_personal+16,utf8_decode("Benaiges"));                

$pdf->SetFont('Arial','B',8);                
$pdf->Text($initial_x_personal+3,$initial_y_personal+21,utf8_decode("SECRETÀRIES"));                
$pdf->Image(_BASE_PATH."/imatges/Cinta Tomàs.jpg",$initial_x_personal,$initial_y_personal+22,$width_personal_foto);                
$pdf->SetFont('Arial','',5);                
$pdf->Text($initial_x_personal+1,$initial_y_personal+36,utf8_decode("Cinta"));                
$pdf->Text($initial_x_personal+1,$initial_y_personal+38,utf8_decode("Tomas"));                
$pdf->Image(_BASE_PATH."/imatges/Mari Mar Pla.jpg",$initial_x_personal+14,$initial_y_personal+22,$width_personal_foto);                
$pdf->Text($initial_x_personal+15,$initial_y_personal+36,utf8_decode("Mari Mar"));                
$pdf->Text($initial_x_personal+15,$initial_y_personal+38,utf8_decode("Pla"));                
$pdf->Image(_BASE_PATH."/imatges/Eva Tafalla.jpg",$initial_x_personal+28,$initial_y_personal+22,$width_personal_foto);                
$pdf->Text($initial_x_personal+29,$initial_y_personal+36,utf8_decode("Eva"));                
$pdf->Text($initial_x_personal+29,$initial_y_personal+38,utf8_decode("Tafalla"));                

//Si escrivim per la sortida aleshores no es podrà utilitzar PDF (headers already sent...)
//echo "prova!";

function cmpTeachers($a, $b)	{
    return strnatcmp($a->code, $b->code);
}
    
usort($teachers, "cmpTeachers");
        
foreach($teachers as $teacher)
{
	//Començo a imprimir els professors
	//$pdf->SetFont('Courier','',5);
	//$pdf->Text(coordenada x, coordenada y, text)
	$pdf->SetFont('Arial','B',6);
	$pdf->SetTextColor(255,0,0);
	$pdf->Text($x,$y,utf8_decode($teacher->code));
	$pdf->SetFont('Arial','',4);
	$pdf->SetTextColor(0,0,0);
	
	//Columna nom complet
	//TODO: Cal tallar els noms a una mida màxima?
	//Alternativa: lletra més petita si supera una mida màxima
	$pdf->Text($x,$y1-2,utf8_decode($teacher->name));
	$pdf->Text($x,$y2-4,utf8_decode($teacher->surname1));
	$pdf->Text($x,$y+9,utf8_decode($teacher->surname2));

	$i=0;
	$VALS['codi_professor']=$teacher->code;
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	$utils->p_dbg($RSRC, "Prova log");
	$result_set = $ConTut->Execute($RSRC['CARREGA_CARREC_DEPARTAMENT']) or die($ConTut->ErrorMsg());
	while (!$result_set->EOF) {
			$i++;
			$carrec1=$result_set->fields['carrec1'];
			$carrec2=$result_set->fields['carrec2'];
			$departament1=$result_set->fields['departament1'];
			$departament2=$result_set->fields['departament2'];
			$result_set->MoveNext();
	}
	$result_set->Close();
	$pdf->Text($x+22,$y,utf8_decode($carrec1));
	$pdf->Text($x+22,$y1-1,utf8_decode($carrec2));
	$pdf->Text($x+22,$y2-2,utf8_decode($departament1));
	$pdf->Text($x+22,$y+12,utf8_decode($departament2));
	if(file_exists("/tmp/".$teacher->foto)){
		$pdf->Image("/tmp/".$teacher->foto,$x1-2,$y-2,$xx);
	}else{
		$pdf->Image(_BASE_PATH."/imatges/default_medium.jpg",$x1-2,$y-2,$xx);	
	}
	/*$pdf->SetFont('Courier','',4);
	$pdf->Text($x2,$y,utf8_decode($teacher->department));
	$pdf->Text($x2,$y1,utf8_decode($teacher->position));
	$pdf->Text($x2,$y2,utf8_decode($teacher->position2));*/
	//incremento la fila
	$row++;
	//incremento el marge
	$i=$i+0.3;

	//Recàlculo les coordenades
	$y=$y_start+$i+$row*$yy*3;
	$y1=$y_start+$i+$row*$yy*3+$yy;
	$y2=$y_start+$i+$row*$yy*3+$yy*2;

	//màxim de files per pàgina 
	if($row>18){//26//Maxim de registre per columnes si es toca el tamny del professor tambe es tocara aquesta dada.
		//incremento la columna
		$col++;
		//reinicio les files i el marge
		$row=0;
		$i=0;
		//Recàlculo les coordenades
		$x=$x_start+$col*($xx+$x_name+$x_post);   
		$x1=$x_start+$col*($xx+$x_name+$x_post)+$x_name;
		$x2=$x_start+$col*($xx+$x_name+$x_post)+$x_name+$x_post;
		
		$y=$y_start+$i+$row*$yy*3;
		$y1=$y_start+$i+$row*$yy*3+$yy;
		$y2=$y_start+$i+$row*$yy*3+$yy*2;

	}
	//Quan arribem a la última fila vigilem de no escriure a sobre dels conserges i secretàries
	if($col==5 && $row==21 && $page_one){
		//Ho tornem a posar tot a 0 i obrim una nova pàgina
		$col=0;
		$row=0;
		$i=0;
		$x=$x_start+$col*$xx;
		$x1=$x_start+$col*$xx*3+$xx;
		$x2=$x_start+$col*$xx*3+$xx*2;

		$y=$y_start+$i+$row*$yy*3;
		$y1=$y_start+$i+$row*$yy*3+$yy;
		$y2=$y_start+$i+$row*$yy*3+$yy*2;
		$page_one=false;
		$pdf->AddPage();
	}
}
//enviem tot al pdf
$pdf->Output("Professorat_"._ANY_COMENCAMENT_CURS."-"._ANY_FINALITZACIO_CURS."_(".date("d-m-Y").").pdf", "I");
?>
