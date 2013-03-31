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
	$students_names=array();
	$students_codes=array();
	
	$ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = _LDAP_STUDENT_BASE_DN;
			
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
			
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			
	$password=_LDAP_PASSWORD;
			#$dn="cn=admin,".$ldapconfig['basedn'];
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
			    for ($i=0; $i<$info["count"];$i++) {
					$students_names[$i]=$info[$j]['cn'][0];
					$students_codes[$i]=$info[$j][_LDAP_USER_ID][0];
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
			// Usuari i contrasenya vàlids (Control seguretat 1)
	ldap_close($ds);
	//print "<table border=1>";
		$st_co='\'';
		$st_co.=join('\', \'', $students_codes);
		$st_co.='\'';

		$utils = new utils();
		$RSRC = array();
		$VALS = array();
		$students=array();
		$VALS['str_data_inicial'] = $str_data_inicial;
		$VALS['str_data_final'] = $str_data_final;	
		$VALS['codi_alumne'] = $st_co;
		$VALS['top'] = $top;
		
		$utils->p_dbg($RSRC, "COMPTA_INCIDENCIES");
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
					
		$result_1 = $ConTut->Execute($RSRC['COMPTA_INCIDENCIES2']) or die($ConTut->ErrorMsg());
		$n = 0; //Comptador que ens indicara la posició del alumne.
		$student = new student();//Crear objecte estudiant
		$students_names2=array();
		$j=0;
		while (list($codi_alumne,$codi_grup, $total)=$result_1->fields)
		{
			$n++;//
			$color="#d0d0d0"; //variable per alternar el color de les files
			$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
			$ldapconfig['host'] = _LDAP_SERVER;
			#Només cal indicar el port si es diferent del port per defecte
			$ldapconfig['port'] = _LDAP_PORT;
			$ldapconfig['basedn'] = _LDAP_STUDENT_BASE_DN;
					
			$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
					
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
					
			$password=_LDAP_PASSWORD;
					#$dn="cn=admin,".$ldapconfig['basedn'];
			$dn=_LDAP_USER;
					
					
			if ($bind=ldap_bind($ds, $dn, $password)) {
				if ($bind=ldap_bind($ds)) {
					
				  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
					$filter = "(&(objectClass=inetOrgPerson)("._LDAP_USER_ID."=".$result_1->fields['codi_alumne']."))";
					if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
					    echo("Unable to search ldap server<br>");
					    echo("msg:'".ldap_error($ds)."'</br>");#check the message again
					} else {
					   	$info = ldap_first_entry($ds, $search);
			 		    $dnb = ldap_get_dn($ds, $info);
			 		    //$dnc = ldap_explode_dn($dnb, 0);
			 		    $dnc=explode  ( ","  , $dnb    );
			 		    unset($dnc[0]);
						$array = array_values($dnc);	
						unset($dnc[1]);
						$array = array_values($dnc);	
			 		    $dnd=implode ( ",", $dnc);
			 		    $dne=cercagrupAlumne($dnd);
					    $students_names2 = ldap_get_values($ds, $info, "cn"); 
						$j=$j+1;
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
			$data1[] = array_merge(array('num'=>$ixx,'nom'=>$students_names2[0], 'group_code'=>$dne[0]),$result_1->fields);
			$ixx = $ixx+1;
			$result_1->moveNext();
		}
			
$result_1->Close();

//Em quedo amb els camps que vull del vector auxiliar
foreach ($data1 as $row){
	$data[]=array($row[num],$row[nom],$row[group_code],$row[total]);
}

//Munto la capçalera
$header=array('','Alumne/a','Grup','Total faltes no justificades');

//Poso les dates amb el format que m'interessa
$date_i=strftime("%d-%m-%Y",strtotime("$str_data_inicial"));
$date_f=strftime("%d-%m-%Y",strtotime("$str_data_final"));

//Nova instància de la classe sense capçalera
$pdf=new institut_ebre_new();
//Marge esquerre
$pdf->SetLeftMargin(30);
//Nova pàgina
$pdf->AddPage();
//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc i per últim el tamany
$pdf->SetFont('Times','',12);

//Capçalera
//color
$pdf->SetFillColor(150,150,150);
//variable que ens indica si la cel·la s'ha de pintar o no
$fill=true;
//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació, color)
$pdf->Cell(150,12,utf8_decode("RÀNQUING D'INCIDÈNCIES DEL CENTRE ENTRE EL "
.$date_i." I EL ".$date_f),0,0,'C');
//Salt de línia
$pdf->Ln(15);
//ens indica en quina columna ens trobem
$x=0;
$pdf->SetFont('Arial','',10);
//recorrem el vector de la capçalera i imprimim cada camp en una casella
foreach($header as $col){
	if($x==0)
		$pdf->Cell(10,7,utf8_decode($col),1,0,'C',$fill);
	else{
		if($x==1)
		$pdf->Cell(70,7,utf8_decode($col),1,0,'L',$fill);
		else{
			if($x==2)
			$pdf->Cell(20,7,utf8_decode($col),1,0,'C',$fill);
			else{
				$pdf->Cell(50,7,utf8_decode($col),1,0,'C',$fill);
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
foreach($data as $row)
{
	$x=0;
	foreach($row as $col){
		if($x==0)
		$pdf->Cell(10,7,utf8_decode($col),1,0,'C',$fill);
		else{
			if($x==1)
			$pdf->Cell(70,7,utf8_decode($col),1,0,'L',$fill);
			else{
				if($x==2)
				$pdf->Cell(20,7,utf8_decode($col),1,0,'C',$fill);
				else{
					$pdf->Cell(50,7,utf8_decode($col),1,0,'C',$fill);
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
$pdf->Output('Ranquing_incidencies_'.$date_i.'-'.$date_f.'.pdf',"I");
?>