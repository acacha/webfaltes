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
$codi_assignatura=$_SESSION['codi_assignatura'];
$str_data_inicial=$_SESSION['str_data_inicial'];
$str_data_final=$_SESSION['str_data_final'];

//vector amb els mesos de l'any
$mes_char = array(Gener,Febrer,Març,Abril,Maig,Juny,Juliol,Agost,Setembre,Octubre,Novembre,Desembre);

$VALS['codi_assignatura'] = $codi_assignatura;

$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");

$result = $ConTut->Execute($RSRC['CONSULTA_NOM_ASSIGNATURA']) or die($ConTut->ErrorMsg());
if (!$result->EOF){
	$nom_assignatura = $result->Fields('nom_assignatura');
}
//el grup del qual el professor és tutor
//$codi_grup = $_SESSION['tutor_de'];

//$data=date('Y-m-d', $_SESSION['data']);

$str_di = date('d-m-Y', strtotime($str_data_inicial));
$str_df = date('d-m-Y', strtotime($str_data_final));


//$resum_incidencies="Resum d'incidències del grup ".$codi_grup. " entre el ".$_POST['data_inicial']." i el ".$_POST['data_final'];
//$credit="del crèdit ".$nom_assignatura." (".$codi_assignatura.")";	
	
	$students = array();
	$j=0;
	$students_names=array();
	$students_codes=array();
	$ixx = 0;
	
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
				    //echo("Unable to search ldap server<br>");
				    //echo("msg:'".ldap_error($ds)."'</br>");#check the message again
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
				//echo("Unable to bind anonymously<br>");
				//echo("msg:".ldap_error($ds)."<br>");
			}
		} else {
			//echo("Unable to bind to server.</br>");
				
			//echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
				  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
				  #we can figure out the right pattern by searching the user tree
				  #remember to turn on the anonymous search on the ldap server
				  
		}
	ldap_close($ds);

	for($l=0;$l<$number_returned;$l++) {
	
		$student=new student();
		$student->name=$students_names[$l];
		
		$color=($color=="#f6f6f6")?"#d0d0d0":"#f6f6f6";
//		print "<tr bgcolor=".$color."> ";
		$TOTAL_INCIDENCIES = 0;
		//per cada alumne mostrem les seves incidències, per cada incidència
		$totals = array();
		for ($n=1; $n <= 5; ++$n){

			$VALS['codi_alumne'] = $students_codes[$l];
			$VALS['n'] = $n;
			$VALS['str_data_inicial'] = $str_data_inicial;
			$VALS['str_data_final'] = $str_data_final;

			$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
			$utils->p_dbg($RSRC, "Prova log");

			$result2 = $ConTut->Execute($RSRC['CONSULTA_INCIDENCIA_ALUMNE']) or die($ConTut->ErrorMsg());
			if (!$result2->EOF){

				$total  = $result2->Fields('total');
				$TOTAL_INCIDENCIES = $TOTAL_INCIDENCIES + $total;
				$totals[$n]=$total;
				$result2->Close();
			}
		}
		$student->total=$totals;
		$student->TOTAL_INCIDENCIES=$TOTAL_INCIDENCIES;
		$students[]=$student;
		// Pasem al registre següent del RS	

		$data[] = array_merge(array('codi'=>$students_codes[$ixx],'nom'=>$student->name,'total1'=>$student->total[1],'total2'=>$student->total[2],'total3'=>$student->total[3],'total4'=>$student->total[4],'total5'=>$student->total[5], 'total_incidencies'=>$student->TOTAL_INCIDENCIES));
		$ixx = $ixx+1;

		$result->MoveNext(); //següent alumne
	}
//Vector amb la capçalera
$header=array('Codi','Alumne/a','F','FJ','R','RJ','E','Total incidències');

//Nova instància de la classe sense capçalera
$pdf=new institut_ebre_new();
//Marge esquerre
$pdf->SetLeftMargin(23);
//Nova pàgina
$pdf->AddPage();
//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc i per últim el tamany
$pdf->SetFont('Times','',11);

//Capçalera
//color
$pdf->SetFillColor(150,150,150);
//variable que ens indica si la cel·la s'ha de pintar o no
$fill=true;

//Poso les dates amb el format que m'interessa
$date_i=strftime("%d-%m-%Y",strtotime("$str_data_inicial"));
$date_f=strftime("%d-%m-%Y",strtotime("$str_data_final"));
//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació, color)
$pdf->Cell(160,12,utf8_decode("RESUM D'INCIDÈNCIES DEL GRUP ".$codi_grup." 
	ENTRE EL ".$date_i." I EL ".$date_f." DEL CRÈDIT ".$codi_assignatura),0,0,'C');
//Salt de línia
$pdf->Ln();
//ens indica en quina columna ens trobem
$x=0;
$pdf->SetFont('Arial','',10);
//recorrem el vector de la capçalera i imprimim cada camp en una casella
foreach($header as $col){
	if($x==0)
	$pdf->Cell(20,7,utf8_decode($col),1,0,'C',$fill);
	else{
		if($x==1)
		$pdf->Cell(60,7,utf8_decode($col),1,0,'L',$fill);
		else{
			if($x==6 || $x==2 || $x==3 || $x==4 || $x==5)
			$pdf->Cell(10,7,utf8_decode($col),1,0,'C',$fill);
			else{
				$pdf->Cell(30,7,utf8_decode($col),1,0,'C',$fill);
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
		$pdf->Cell(20,7,utf8_decode($col),1,0,'C',$fill);
		else{
			if($x==1)
			$pdf->Cell(60,7,utf8_decode($col),1,0,'L',$fill);
			else{
				if($x==6 || $x==2 || $x==3 || $x==4 || $x==5)
				$pdf->Cell(10,7,utf8_decode($col),1,0,'C',$fill);
				else{
					$pdf->Cell(30,7,utf8_decode($col),1,0,'C',$fill);
				}
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
$pdf->Output("Resum_incidencies_".$codi_grup."_".$codi_assignatura."_".$date_i."_".$date_f.".pdf", "I");
?>