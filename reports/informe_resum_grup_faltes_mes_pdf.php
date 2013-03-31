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
$codi_grup=$_SESSION['codi_grup'];
$str_data_inicial=$_SESSION['str_data_inicial'];
$str_data_final=$_SESSION['str_data_final'];
$mes=$_SESSION['mes'];

//vector amb els mesos de l'any
$mes_char = array(Gener,Febrer,Març,Abril,Maig,Juny,Juliol,Agost,Setembre,Octubre,Novembre,Desembre);


//carrego les variables de les funcions
$VALS['codi_grup'] = $codi_grup;
$VALS['str_data_inicial'] = $str_data_inicial;
$VALS['str_data_final'] = $str_data_final;
/*	$j=0;
	$students_names=array();
	$students_codes=array();

	$ldapconfig['host'] = _LDAP_SERVER;
	#Només cal indicar el port si es diferent del port per defecte
	$ldapconfig['port'] = _LDAP_PORT;
	$ldapconfig['basedn'] = 'ou=Alumnes,ou=All,dc=iesebre,dc=com';
		
	$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
	$password=_LDAP_PASSWORD;
	$dn=_LDAP_USER;		
		
		
	if ($bind=ldap_bind($ds, $dn, $password)) {
	if ($bind=ldap_bind($ds)) {
	
	 $filter = "(physicalDeliveryOfficeName=".$codi_grup.")";
		
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
					$students_codes[$i]=$info[$j]['employeenumber'][0];
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
	$alumnes=array();
	for($l=0;$l<$number_returned;$l++){
			
		$VALS['codi_alumne']=$students_codes[$l];
		
		$utils->get_global_resources($RSRC,"db/sql_querys_inc.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		
	    $result = $ConTut->Execute($RSRC['informe_resum_faltes_mes_2']) or die($ConTut->ErrorMsg());
		$color="#d0d0d0"; //variable per alternar el color de les files
		
		
	
	    while (!$result->EOF) {
			
			$alumne= new student();
			$alumne->name = $students_names[$l];
			$alumne->codi_alumne = $students_codes[$l];
			$alumne->fj = $result->fields['falta'];
			$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
					$alumnes[]=$alumne;
					// Pasem al registre següent del RS				        
					$result->MoveNext(); //següent alumne
			$data[] = array_merge(array('codi'=>$alumne->codi_alumne,'nom'=>$alumne->name,'faltes'=>$alumne->fj));
		}	
	}*/
	$students_names=array();
	$students_codes=array();
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
			
			
	if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
			
		  //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
			$filter = "(objectClass=inetOrgPerson)";
			
			if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
			    //echo("Unable to search ldap server<br>");
			   // echo("msg:'".ldap_error($ds)."'</br>");#check the message again
			} else {
			    $number_returned = ldap_count_entries($ds,$search);
			    ldap_sort($ds, $search, "cn"); 
			    $info = ldap_get_entries($ds, $search);
			    $j=0;
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
	$st_co='\'';
	$st_co.=join('\', \'', $students_codes);
	$st_co.='\'';
	$alumnes=array();
		$VALS['codi_alumne']=$st_co;
		
		$utils->get_global_resources($RSRC,"db/sql_querys_inc.php", $VALS);
		$utils->p_dbg($RSRC, "Prova log");
		
	    $result = $ConTut->Execute($RSRC['informe_resum_faltes_mes_2']) or die($ConTut->ErrorMsg());
		$color="#d0d0d0"; //variable per alternar el color de les files
		
		$l=0;
	    while (!$result->EOF) {
			
			$alumne= new student();
			$codi_alumne = $result->fields['codi_alumne'];
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
					$filter = "(&(objectClass=inetOrgPerson)("._LDAP_USER_ID."=".$codi_alumne."))";
					
					if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
					    //echo("Unable to search ldap server<br>");
					   // echo("msg:'".ldap_error($ds)."'</br>");#check the message again
					} else {
					    $number_returned = ldap_count_entries($ds,$search);
					    ldap_sort($ds, $search, "cn"); 
					    $info = ldap_get_entries($ds, $search);
					    for ($i=0; $i<$info["count"];$i++) {
							$students_names2=$info[0]['cn'][0];
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
			$alumne->name = $students_names2;
			$alumne->fj = $result->fields['falta'];
			$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
					$alumnes[]=$alumne;
					// Pasem al registre següent del RS			
			$data[] = array_merge(array('codi'=>$codi_alumne,'nom'=>$alumne->name,'faltes'=>$alumne->fj));	
			$result->MoveNext(); //següent alumne
		}	
$VALS['codi_grup'] = $codi_grup;
$utils->get_global_resources($RSRC,"db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
$result = $ConTut->Execute($RSRC['selec_grup_tutor']) or die($ConTut->ErrorMsg());

while(!$result->EOF) {
	$nom_g=$result->fields['nom_grup'];
	$codi_tutor= $result->fields['tutor'];
	$result->MoveNext();
}

$result->Close();
	$teachers_names= array();
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
					$teachers_names[$i]=$info[0]['cn'][0];
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



//Vector amb la capçalera
$header=array('Codi','Alumne/a','Faltes injustificades');

//Nova instància de la classe sense capçalera
$pdf=new institut_ebre_new();
//Nova pàgina
$pdf->AddPage();
//Marge esquerre
$pdf->SetLeftMargin(33);
//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc i per últim el tamany
$pdf->SetFont('Times','',18);
//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació, color)
$pdf->Cell(115,10,utf8_decode('FULL MENSUAL DE FALTES'),0,0,'C');
//Salt de línia
$pdf->Ln();
$pdf->SetFont('Times','',10);
$pdf->Cell(30,10,utf8_decode('MES: '.$mes_char[$mes-1]),0);
$pdf->Cell(60,10,utf8_decode('CURS: '.$nom_g),0);
$pdf->Cell(52,10,utf8_decode('TUTOR/A: '.$teachers_names[0]),0);
$pdf->Ln();

//Capçalera
$pdf->SetLeftMargin(45);
//color
$pdf->SetFillColor(150,150,150);
//variable que ens indica si la cel·la s'ha de pintar o no
$fill=true;
$pdf->SetFont('Arial','',10);
//ens indica en quina columna ens trobem
$x=0;
//recorrem el vector de la capçalera i imprimim cada camp en una casella
foreach($header as $col){
	if($x==0)
		$pdf->Cell(20,7,utf8_decode($col),1,0,'C',$fill);
	else{
		if($x==1)
		$pdf->Cell(60,7,utf8_decode($col),1,0,'L',$fill);
		else{
			$pdf->Cell(35,7,utf8_decode($col),1,0,'C',$fill);
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
		$pdf->Cell(20,7,utf8_decode($col),1,0,'C',$fill);
		else{
			if($x==1)
			$pdf->Cell(60,7,utf8_decode($col),1,0,'L',$fill);
			else{
				$pdf->Cell(35,7,utf8_decode($col),1,0,'C',$fill);
			}
		}
		$x=$x+1;
	}
	//canviem el valor per fer el pijama
	$fill=!$fill;
	$pdf->Ln();
}
//Ens col·loquem a 5cm del final de la pàgina
$pdf->SetY(-50);
$pdf->SetFont('Times','',10);
$pdf->Cell(30,7,utf8_decode('Data i signatura del tutor/a'),0);
//enviem tot al pdf
$pdf->Output("Resum_incidencies_".$mes_char[$mes-1]."_".$codi_grup.".pdf", "I");
?>
