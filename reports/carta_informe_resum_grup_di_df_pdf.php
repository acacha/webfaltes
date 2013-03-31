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
include_once(_DIR_CONNEXIO."seguretat.inc.php");

//Crido a la classe pdf
//Per tenir capçalera informe_pdf.php // sense capçalera fpdf.php


$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$utils = new utils();
$RSRC = array();

//Recuperem les variables necessàries per executar les consultes
$usuari = $_SESSION['usuari'];
$codi_grup=$_SESSION['codi_grup'];
$str_data_inicial=$_SESSION['str_data_inicial'];
$str_data_inicial=strftime("%Y-%m-%d",strtotime("$str_data_inicial"));
$str_data_inicial_ca=strftime("%d-%m-%Y",strtotime("$str_data_inicial"));
$str_data_final=$_SESSION['str_data_final'];
$str_data_final=strftime("%Y-%m-%d",strtotime("$str_data_final"));
$str_data_final_ca=strftime("%d-%m-%Y",strtotime("$str_data_final"));
$date=date('Y-m-d');
//Localització de la data
setlocale(LC_TIME, "ca_ES.utf-8");
$date=strftime("%d de %B de %Y",strtotime("$date"));


			$students=array();
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
	
	 $filter = "("._LDAP_GROUP."=".$codi_grup.")";
		
	 if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
		echo("Unable to search ldap server<br>");
		echo("msg:'".ldap_error($ds)."'</br>");#check the message again
	 } else {
		      $number_returned = ldap_count_entries($ds,$search);
		      $info = ldap_first_entry($ds, $search);
		      $info1= ldap_get_dn($ds, $info);
		      $grup_complet=$info1;
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
					$ldapconfig['basedn'] = $grup_complet;
									
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
		ldap_close($ds);
		
    for($l=0;$l<$number_returned;$l++) {
			//print "<tr bgcolor=".$color."> ";
			//print "<td> ".$nom."</td> "; 
			$student= new student();
			$student->name= $students_names[$l];
		
		$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
		
			$TOTAL_INCIDENCIES = 0;
			$total = array();
			//per cada alumne mostrem les seves incidéncies, per cada incidéncia
				
				for ($n=1; $n <= 5; ++$n){
				$total = array();
					/*
						$sql2  = "SELECT COUNT(*) AS total";
						$sql2 .= " FROM incidencia";
						$sql2 .= " WHERE codi_alumne = '$codi_alumne'";
						$sql2 .= " AND motiu_incidencia = '$n'";
						$sql2 .= " AND data_incidencia BETWEEN '$str_data_inicial' AND '$str_data_final'";
					*/
						//print $sql2;
						$VALS['n'] = $n;
						$VALS['str_data_final'] = $str_data_final;
						$VALS['str_data_inicial'] = $str_data_inicial;
						$VALS['codi_alumne']= $students_codes[$l];

						$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
						$utils->p_dbg($RSRC, "Prova log");
					
						$result2 = $ConTut->Execute($RSRC['informe_resum_grup_di_df_2__1']) or die($ConTut->ErrorMsg());
						if (!$result2->EOF){
							$total = $result2->Fields('total');
							$TOTAL_INCIDENCIES = $TOTAL_INCIDENCIES + $total;
							$totals[$n]=$total;
							$result2->Close();
				        }
						//print "<td> ".$total."</td> ";   
				}
				//print "<td> ".$TOTAL_INCIDENCIES."</td></tr> ";
				$student->total=$totals;
				$student->TOTAL_INCIDENCIES= $TOTAL_INCIDENCIES;
				$students[]=$student;
				//print_r($student);
				// Pasem al registre següent del RS				        
				//$result->MoveNext(); //següent alumne
		}	
	$month=date('m');
   	if ($month>8){
   		$curs=date('Y')."-".(date('Y')+1);
   	}
   	else{
   		$curs=(date('Y')-1)."-".date('Y');
   	}
	//Nova instància de la classe sense capçalera
	$pdf=new fpdf();
	
	//Recorrec tots els estudiants i per a cada 1 imprimeixo 2 còpies	
	foreach($students as $student){
		//Nova pàgina
		$pdf->AddPage();
		for($x=2;$x!=0;$x--){
			//Marge esquerre
			$pdf->SetLeftMargin(29);
			//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc i per últim el tamany
		    $pdf->SetFont('Times','B',12);
		    //Capçalera
		    //$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació)
		    $pdf->Cell(50,8,utf8_decode("Institut de l'Ebre"),0,0,'L');
		    $pdf->Cell(50,8,utf8_decode("E/A-Cicles Formatius"),0,0,'C');
		    $pdf->Cell(50,8,utf8_decode("Curs "._ANY_COMENCAMENT_CURS."-"._ANY_FINALITZACIO_CURS),0,0,'R');
		    //Salt de línia
		    $pdf->Ln();
		    $pdf->Cell(50,8,utf8_decode("        Tortosa"),0,0,'L');
	    	$pdf->Ln();
		    $pdf->Cell(150,10,utf8_decode("_____________________________________________________"),0,0,'C');
		    $pdf->SetLeftMargin(23);
		    $pdf->Ln();   
	    	$pdf->Ln();  
		    $pdf->SetFont('Times','B',12);
		    $pdf->Cell(150,10,utf8_decode("COMUNICAT DE FALTES D'ASSISTÈNCIA DE L'ALUMNAT"),0,0,'C');
		    $pdf->Ln();
		    $pdf->Ln();
			$pdf->SetFont('Times','B',8);
			$pdf->MultiCell(150,8,utf8_decode("L'alumne ".$student->name." del grup ".$codi_grup." té entre el ".$str_data_inicial_ca." i el ".$str_data_final_ca." ".$student->TOTAL_INCIDENCIES." incidències, de les quals ".$student->total[2]." hores són faltes justificades i ".$student->total[1]." hores són injustificades. A més ha arribat ".$student->total[3]." vegades amb retard  a classe i ".$student->total[4]." vegades amb retard justificat. Per últim ha estat expulsat ".$student->total[5]." vegades, cosa que poso en coneixement de vostè
		
				El tutor/la tutora
			
				Tortosa, $date"));
			
			if($x%2==0){
				$pdf->Ln();
				$pdf->Ln();
				$pdf->MultiCell(150,8,"-----------------------------------------------------------------------------------------------------------------------------------------------------------");
				$pdf->Ln();
				
			}		
		}
}
//enviem tot al pdf
$pdf->Output();
?>