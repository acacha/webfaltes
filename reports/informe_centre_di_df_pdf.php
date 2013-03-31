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
$str_data_inicial = $_SESSION['str_data_inicial'];
$str_data_final = $_SESSION['str_data_final'];
$matriu_motius_informe=$_SESSION['matriu_motius_informe'];
$motius_informe=$_SESSION['motius_informe'];
$capçalera_pdf=$_SESSION['capçalera_pdf'];

//Carrego el fitxer amb les consultes
$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
$utils->p_dbg($RSRC, "Prova log");
//Executo la consulta corresponent
$result_1 = $ConTut->Execute($RSRC['CONSULTA_CODI_GRUP_NOM_GRUP_ESO_INFORMATICA_BATX']) or die($ConTut->ErrorMsg());
$grups=array();
$students=array();

//Carrego la classe amb els valors corresponents
while (list($codi_grup, $nom_grup)=$result_1->fields)
{
		$j=0;
		$number_returned=0;
		$students_names=array();
		$students_codes=array();
		$grup=new grups();
		$codi_grup=$result_1->fields['codi_grup'];

		$grup->codi_grup=$result_1->fields['codi_grup'];//$codi_grup;
		$grup->nom_grup=$nom_grup;//$nom_grup;
		$group=$codi_grup;
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
		/*generar vector on posarem alumnes*/
		$color="#d0d0d0"; //variable per alternar el color de les files
		//$grup->codi_grup=$codi_grup;//$codi_grup;
		//$grup->nom_grup=$nom_grup;//$nom_grup;
		for($l=0;$l<$number_returned;$l++) {

			$student=new student();
			$student->name=$students_names[$l];
			$student->codi_grup=$group;//$codi_grup;

			/*echo $student->name."student->grup= ";
			echo $student->codi_grup."grup->codi_grup=";
			echo $grup->codi_grup."<br>";*/
			/*print------------- "<td> ".$nom."</td> ";*/

			$TOTAL_INCIDENCIES = 0;
			//per cada alumne mostrem les seves incidències, per cada incidència
			$totals=array();
			for ($n=1; $n <= 5; ++$n)
			{
				if ($matriu_motius_informe[$n] == 0) continue;

				$VALS['motius_informe']= $motius_informe;
				$VALS['str_data_inicial']= $str_data_inicial;
				$VALS['str_data_final']= $str_data_final;
				$VALS['n']= $n;
				$VALS['codi_alumne'] = $students_codes[$l];//$codi_alumne;

				$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
				$utils->p_dbg($RSRC, "Prova log");
				$result2 = $ConTut->Execute($RSRC['CONSULTA_RECOMPTE']) or die($ConTut->ErrorMsg());
				
				if (!$result2->EOF)
				{
					$total  = $result2->Fields('total');
					$TOTAL_INCIDENCIES = $TOTAL_INCIDENCIES + $total;
					$result2->Close();
				}
				$totals[]=$total;

			}
			$student->total=$totals;

			$student->TOTAL_INCIDENCIES=$TOTAL_INCIDENCIES;
			// Pasem al registre següent del RS	

			//$result->MoveNext(); //següent alumne

			/* ja tenim els valors plens i els assignem dintre del vector */
			/* fer un print amb el vector per veure les coherencies */

			$students[]=$student;
			
		}
		//$result->Close();
		//}
		$grups[]=$grup;
		$result_1->MoveNext(); //següent grup	
}
	//$result_2->Close();
	$result_1->Close();	
//Partim la capçalera per les comes per poder-la carregar al vector
$capçalera=split(",",$capçalera_pdf);

//calculo quantes parts de la capçalera
$cap=0;
foreach ($capçalera as $item){
	$cap++;
}
//munto el vector de la capçalera
$header[]="Alumne/a";
$x=0;
while ($x != $cap){
	$header[]=$capçalera[$x];
	$x++;
}
$header[]="Total Incidències";

//nova instància amb capçalera
$pdf=new institut_ebre_new();
//Marge esquerre
$pdf->SetLeftMargin(23);

//Cabecera
//variable que ens indica si la cel·la s'ha de pintar o no
$fill=true;
//Poso les dates amb el format corresponent
$date_i=strftime("%d-%m-%Y",strtotime("$str_data_inicial"));
$date_f=strftime("%d-%m-%Y",strtotime("$str_data_final"));
//Ens indica si és el primer cop
$first=true;
//Recorrem els grups i per cada grup mostrem tots els alumnes i les seves incidències
$k=0;
foreach ($grups as $grup){
	//Nova pàgina
	$pdf->AddPage();
	//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc i per últim el tamany
	$pdf->SetFont('Times','',13);
	//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació, color)
	$pdf->Cell(150,12,utf8_decode("    INFORME D'INCIDÈNCIES DEL CENTRE ENTRE EL ".
	$date_i." I EL ".$date_f),0,0,'C');
	//color
	$pdf->SetFillColor(150,150,150);
	$pdf->SetFont('Arial','B',11);
	//variable que ens indica si la cel·la s'ha de pintar o no
	$fill=true;
	//Salt de línia
	$pdf->Ln();
	$pdf->Cell(150,12,utf8_decode($grup->codi_grup),0,0,'C');
	$pdf->Ln();
	$x=0;
	//Header
	$pdf->SetFont('Arial','',10);
	//recorrem el vector de la capçalera i imprimim cada camp en una casella
	foreach($header as $col){
		if($x==0){
			$pdf->Cell(70,7,utf8_decode($col),1,0,'L',$fill);
			if($first){
				$cap++;
				$first=false;
			}
		}
		else{
			if($x!=0 && $x!=$cap)
				$pdf->Cell(10,7,utf8_decode($col),1,0,'C',$fill);
			else{
				$pdf->Cell(35,7,utf8_decode($col),1,0,'C',$fill);
			}
		}
		$x++;
	}
	$pdf->Ln();

	//Data
	$pdf->SetFillColor(219,219,219);
 	$fill=false;
 	$pdf->SetFont('Arial','',8);
 	//recorrem els estudiants i per cada estudiant el total d'incidències i imprimim cada camp en una casella
	foreach($students as $student){
		if ($student->codi_grup==$grup->codi_grup){
			$pdf->Cell(70,7,utf8_decode($student->name),1,0,'L',$fill);
			foreach ($student->total as $total){
				$pdf->Cell(10,7,utf8_decode($total),1,0,'C',$fill);
			}
			$pdf->Cell(35,7,utf8_decode($student->TOTAL_INCIDENCIES),1,0,'C',$fill);
			//canviem el valor per fer el pijama
			$fill=!$fill;
			$pdf->Ln();
		}
	}

}
//enviem tot al pdf
$pdf->Output();
?>