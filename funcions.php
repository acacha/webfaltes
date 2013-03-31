<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors:  Carlos Cristoful Rodriguez & Joan Verge Chillida 
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
 * $Id:funcions.php 1403 2010-09-23 06:30:37Z acacha $ 
 */


/*---------------------------------------------------------------
 * Webfaltes  File: funcions.php
 * Autor: Carles Añó  Data:
 * Modifier: Sergi Tur Data: 22/10/2009
 * Description: Common functions
 * Pre condi.:
 * Post cond.:
 ----------------------------------------------------------------*/
// Incloem fitxers necessaris

include_once("config.inc.php");

$utils = new utils();

$RSRC = array();
$VALS = array();

/*
 * Returns 0 on success, 1 otherwise
 */
  
function add_student_to_group($student_code, $group_code,$ConTut) {
	
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	
	  $VALS['student_code']= $student_code;
  	  $VALS['group_code']= $group_code;
	
	if (is_valid_student_code($student_code,$ConTut) || 
	    is_valid_group_code($group_code,$ConTut)) {
		/*$sql= "INSERT INTO student_groups ";
		$sql.="(student_code,group_code) VALUES($student_code,'$group_code')";*/
	    
	    $utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
		// a sample debugging call.  Use tail -f on an Apache error_log
 		// to see the output
		$utils->p_dbg($RSRC, "Prova log");
		
		$result = $ConTut->Execute($RSRC['funcions.php_1']) or die($ConTut->ErrorMsg());
		$result->Close();
		return 0;
	} else {
		return 1;
	}    
}


/*
 * Returns 0 on success, 1 otherwise
 */
function remove_student_from_group($student_code, $group_code,$ConTut) {
	
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	
	  $VALS['student_code']= $student_code;
  	  $VALS['group_code']= $group_code;
	
	if (is_valid_student_code($student_code,$ConTut) || 
	    is_valid_group_code($group_code,$ConTut)) {
		/*$sql  = "DELETE FROM student_groups";
		$sql .= " WHERE student_code=".$student_code;
		$sql .= " AND group_code='".$group_code."'";*/
	    	
	    $utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
		// a sample debugging call.  Use tail -f on an Apache error_log
 		// to see the output
		$utils->p_dbg($RSRC, "Prova log");
		
		$result = $ConTut->Execute($RSRC['funcions.php_2']) or die($ConTut->ErrorMsg());
		$result->Close();
		return 0;
	} else {
		return 1;
	}    
}
/**
 * 
 * @param $group_code
 * @param $ConTut
 * @return unknown_type
 */
/**
 * 
 * @param $group_code
 * @param $ConTut
 * @return unknown_type
 */

function is_valid_group_code($group_code,$ConTut) {
	
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	
  	  $VALS['group_code']= $group_code;
	
	/*$sql  = "SELECT codi_grup";
	$sql .= " FROM grup";
	$sql .= " WHERE codi_grup = '$group_code'";*/
  	  
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");
	
	$result = $ConTut->Execute($RSRC['funcions.php_3']) or die($ConTut->ErrorMsg());
	$return_value=0;

	if (!$result->EOF) {
		$return_value=1;
	}else{
		$return_value=0;
	}
	$result->Close();
	return $return_value;
}

/*
 * Returns 1 if $student_code is a valid student code or 0 otherwise
 */
function is_valid_student_code($student_code,$ConTut) {
	
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	
	  $VALS['student_code']= $student_code;

	/*$sql  = "SELECT codi_alumne";
	$sql .= " FROM alumne";
	$sql .= " WHERE codi_alumne = '$student_code'";*/
	  
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");
	
	$result = $ConTut->Execute($RSRC['funcions.php_4']) or die($ConTut->ErrorMsg());
	$return_value=0;

	if (!$result->EOF) {
		$return_value=1;
	}else{
		$return_value=0;
	}
	$result->Close();
	return $return_value;
}

/////////////////////////////////////////////////////
// Funci� mostrar_full_setmanal($grup, $setmana)
//
// Mostra per pantalla el full d'incid�ncies d'un grup i una setmana concreta
// Parametres d'entrada:
//   - $grup: codi del grup
//   - $data: data d'un dia de la setmana de la qual volem veure el full d'incid�ncies
//   - $ConTut: connexi� activa a la base de dades
//////////////////////////////////////////////////////
function mostrar_full_setmanal($codi_grup, $data, $ConTut)
{
	//TODO
}


function mostrar_incidencies_setmanal($alumne, $setmana)
{

	/*
	 * TODO
	 per cada hora de classe de la setmana
		mostrar_incidencia($alumne, $dia, $hora)
		*/

}


function hora_inici($hora, $ConTut)
{
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	
	$VALS['hora']= $hora;
	
	/* donada una hora in (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,) ens retorna un string amb l'hora d'inici */
	/*$sql  = "SELECT hora_inici";
	$sql .= " FROM interval_horari";Aplicació:
Nom Mòdul:
Autor:
Repositòri
SVN:
Usuari:
Password:
Webfaltes
Mòdul Gestió Dades Interna
Ivan Gomez Romero
http://www.sourceforge.net/webfaltes//webfaltes
Anonymous
Anonymous
	$sql .= " WHERE codi_hora = '$hora'";*/
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");
	
	$result = $ConTut->Execute($RSRC['funcions.php_5']) or die($ConTut->ErrorMsg());
	if (!$result->EOF) {
		$hora_inici=$result->Fields('hora_inici');
	}else{
		$hora_inici="00:00";
	}
	$result->Close();
	return $hora_inici;
}

function hora_final($hora, $ConTut)
{
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	/* donada una hora in (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,) ens retorna un string amb l'hora d'inici */
	/*$sql  = "SELECT hora_final";
	$sql .= " FROM interval_horari";
	$sql .= " WHERE codi_hora = '$hora'";*/
	$VALS['hora'] = $hora;
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");

	$result = $ConTut->Execute($RSRC['hora_final']) or die($ConTut->ErrorMsg());
	if (!$result->EOF) {
		$hora_final=$result->Fields('hora_final');
	}else{
		$hora_final="00:00";
	}
	$result->Close();
	return $hora_final;
}

function es_data_del_curs($str_data){
	return $int_data < strtotime('15-09-2008') or $int_data > strtotime('24-06-2009');

}



/////////////////////////////////////////////////////
// Funció estudis(num_matricula, connexió)
//
// Torna els estudis de l'alumne/a per a l'any que li passem
// Parametres d'entrada:
//   - $matricula: número de matrícula
//   - $ConTut: connexió activa a la base de dades
//////////////////////////////////////////////////////
function estudis($matricula, $ConTut, $any)
{
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	/*
	$sql  = "SELECT etapa, nivell, grupclasse FROM alumany ";
	$sql .= "WHERE trim(matricula) = trim('$matricula') ";
	$sql .= "AND curs_acad = $any";*/
	$VALS['any'] = $any;
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");
	
	$result = $ConTut->Execute($RSRC['estudis']) or die($ConTut->ErrorMsg());

	if (!$result->EOF){
		$etapa = $result->Fields('etapa');
		$curs  = $result->Fields('nivell');
		$grup  = $result->Fields('grupclasse');
		$result->Close();

		if ($curs == 1 or $curs == 3) {
			$ordre = "r";
		}elseif ($curs == 2){
			$ordre = "n";
		}elseif ($curs == 4){
			$ordre = "t";
		}

		$torna = $curs.$ordre." ".$etapa." ".$grup;
	}else{
		$torna = "Alumne/a inexistent al fitxer";
	}

	return $torna;
}

/////////////////////////////////////////////////////
// Funció nom_profe(codi_prof, connexió)
//
// Torna el nom del professor/a corresponent
// Parametres d'entrada:
//   - $codi_prof: codi del professor/a
//   - $ConTut: connexió activa a la base de dades
//////////////////////////////////////////////////////
function nom_profe($user, $ConTut)
{
		$ldapconfig['host'] = _LDAP_SERVER;
		#Només cal indicar el port si es diferent del port per defecte
		$ldapconfig['port'] = NULL;
		$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
		
		$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		
		$password=_LDAP_PASSWORD;
		$dn=_LDAP_USER;
				
		if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
			
		    //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
		    $filter = "(uid=".$user.")";
		
		    if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
		      echo("Unable to search ldap server<br>");
		      echo("msg:'".ldap_error($ds)."'</br>");#check the message again
		    } else {
		      $number_returned = ldap_count_entries($ds,$search);
		      $info = ldap_get_entries($ds, $search);
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
		$nom= $info[0]['givenname'][0];
		$cognom1= $info[0]['sn1'][0];
		$cognom2= $info[0]['sn2'][0];
		$torna = $cognom1. " ". $cognom2.", ".$nom;
		ldap_close($ds);

	return $torna;
}

function nom_pare($codi_pare, $ConTut)
{
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	/*
	$sql  = "SELECT nom_professor, cognom1_professor FROM professor ";
	$sql .= "WHERE trim(codi_professor) = trim('$codi_prof')";*/
	$VALS['codi_pare'] = $codi_pare;
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");
	$result = $ConTut->Execute($RSRC['nom_pare']) or die($ConTut->ErrorMsg());

    if (!$result->EOF)
    {
		$nom = $result->Fields('nom_pare');
		//$cognom1 = $result->Fields('cognom1_professor');
		//$cognom2 = $result->Fields('cognom2');
		$result->Close();
		$torna = $nom;
	}
	else
	{
		$torna = "Pare inexistent al fitxer";
	}

	return $torna;
}


function nom_alumne($codi_alumne, $ConTut)
{
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	/*
	$sql  = "SELECT nom_professor, cognom1_professor FROM professor ";
	$sql .= "WHERE trim(codi_professor) = trim('$codi_prof')";*/
	$VALS['codi_alumne'] = $codi_alumne;
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");
	$result = $ConTut->Execute($RSRC['nom_alumne']) or die($ConTut->ErrorMsg());

    if (!$result->EOF)
    {
		$nom = $result->Fields('nom_alumne');
		//$cognom1 = $result->Fields('cognom1_professor');
		//$cognom2 = $result->Fields('cognom2');
		$result->Close();
		$torna = $nom;
	}
	else
	{
		$torna = "Alumne inexistent al fitxer";
	}

	return $torna;
}


/////////////////////////////////////////////////////
// Funció tutoria(codi_prof, connexió, $any)
//
// Torna la tutoria del professor/a per a l'any  que li passem
// Parametres d'entrada:
//   - $codi_prof: codi del professor/a
//   - $ConTut: connexió activa a la base de dades
//   - $any: any acadèmic per al qual sol·licitem
//////////////////////////////////////////////////////
function tutoria($codi_prof, $ConTut, $any)
{
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	/*
	$sql  = "SELECT etapa, nivell, grup FROM tutories ";
	$sql .= "WHERE trim(codi) = trim('$codi_prof') ";
	$sql .= "AND curs_acad = $any";*/
	$VALS['any'] = $any;
	$VALS['codi_prof']=$codi_prof;
	
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
	// a sample debugging call.  Use tail -f on an Apache error_log
 	// to see the output
	$utils->p_dbg($RSRC, "Prova log");
	$result = $ConTut->Execute($RSRC['consulta_tutoria']) or die($ConTut->ErrorMsg());

	if (!$result->EOF){
		$etapa = $result->Fields('etapa');
		$curs  = $result->Fields('nivell');
		$grup  = $result->Fields('grup');
		$result->Close();

		if ($curs == 1 or $curs == 3) {
			$ordre = "r";
		}elseif ($curs == 2){
			$ordre = "n";
		}elseif ($curs == 4){
			$ordre = "t";
		}

		$torna = $curs.$ordre." ".$etapa." ".$grup;
	}else{
		$torna = "Codi de professor inexistent";
	}

	return $torna;
}

/**
 * 
 * @author sergi
 *
 */
class utils {

/*
**    constructor
*/
function utils() {

}

/**
 * 
 *    get_global_resources - update $RSRC[]
 *
 *    This is intended for resource files that
 *    do not change from one language or theme to another.
 *    One example is SQL statements
 */
function get_global_resources(&$RSRC, $context,
                              $VALS = array())
{
    // $VALS is an associative array, it allows us to
    // expand vars of the form: $VAL['foo'] within the
    // resource file..
    include "includes/$context";
}

function p_dbg($an_array, $array_info = "(no info given)") {
    static $dbg_count = 0;

    ob_start();
    $dbg_count++;
    print "[" . $dbg_count . "] $array_info\n";
    print_r($an_array);
    $the_str = ob_get_contents();
    ob_end_clean();
    
    error_log("in p_dbg: ");
    error_log($the_str);
}

}

/**
 * 
 * @author iesebre
 *
 */
class student {
	/**
	 * 
	 * @var unknown_type
	 */
	var $name;
	var $id_group;
	var $nom_group;
	var $posicio;
	var $fj;
	var $motiu_curt;
	var $nom_assignatura;
	/**
	 * @var array
	 */
	var $total;
	var $TOTAL_INCIDENCIES;
}

class alumne
{
	var $codi_alumne;
	var $nom_alumne;
	var $adreca;
	var $codi_postal;
	var $ciutat;
	var $tel_fixe;
	var $tel_mobil;
	var $data_neixement;
	var $data_alta;
	var $data_baixa;
	var $nom_professor;
	var $cognom1_professor;
	var $foto_perfil;
}
class professor
{
	var $codi_professor;
	var $nom_professor;
	var $cognom1_professor;
	var $cognom2_professor;
	var $user;
	var $password;
	var $email;
	var $coordinador;
	var $departament;
	var $carrec;
	var $foto_perfil;
}

class teacher
{
	var $code;
	var $name;
	var $surname1;
	var $foto;
	var $department;
	var $position;
	var $position2;
}
	
class grups{
	
	var $codi_grup;
	var $nom_grup;
	var $nivell;
	
}
class grup{
	
	var $codi_grup;
	var $nom_grup;
	var $nivell;
	var $grau;
	var $descripcio;
	var $tutor;
	
}
class pare
{
	var $codi_pare;
	var $nom_pare;
	var $adreca;
	var $codi_postal;
	var $ciutat;
	var $tel_mobil;
	var $usuari;
	var $email;
	var $vol_sms;
	var $vol_mail;
	var $es_pare;
	var $foto_perfil;
}
class departament{
	var $id;
	var $descripcio;
}

function girarDatahora($data){
	$aux=split(" ", $data);
	$aux2=split("-", $aux[0]);
	$data=$aux[1]." ".$aux2[2]."-".$aux2[1]."-".$aux2[0];
	return $data;
}

function girarData($data){
	$aux=split("-", $data);
	$data=$aux[2]."-".$aux[1]."-".$aux[0];
	
	return $data;
}

function separarNomAlumne($nom){
	$aux=split(", ", $nom);
	$aux2=split(" ", $aux[0]);
	$nomal[0]= $aux[1];
	$nomal[1]= $aux2[0];
	$nomal[2]= $aux2[1];
	return $nomal;
}


function user_exist($user, $ConTut) {
	
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	
	$VALS['usuari']= $user;
	  
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

	$utils->p_dbg($RSRC, "Prova log");
	
	$result = $ConTut->Execute($RSRC['COMPROVAR_USUARI_PROFE']) or die($ConTut->ErrorMsg());
	$return_value=0;

	if (!$result->EOF) {
		$return_value=1;
	}else{
		$return_value=0;
	}
	$result->Close();
	return $return_value;
}

function email_exist($email, $ConTut) {
	
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	
	$VALS['email']= $email;
	  
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

	$utils->p_dbg($RSRC, "Prova log");
	
	$result = $ConTut->Execute($RSRC['COMPROVAR_EMAIL_PROFE']) or die($ConTut->ErrorMsg());
	$return_value=0;

	if (!$result->EOF) {
		$return_value=1;
	}else{
		$return_value=0;
	}
	$result->Close();
	return $return_value;
}


function user_email_exist($user, $email, $ConTut) {
	
	$utils = new utils();
	$RSRC = array();
	$VALS = array();
	
	$VALS['usuari']= $user;
	$VALS['email']= $email;
	  
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

	$utils->p_dbg($RSRC, "Prova log");
	
	$result = $ConTut->Execute($RSRC['COMPROVAR_USUARI_EMAIL_PROFE']) or die($ConTut->ErrorMsg());
	$return_value=0;

	if (!$result->EOF) {
		$return_value=1;
	}else{
		$return_value=0;
	}
	$result->Close();
	return $return_value;
}

function addDate($date,$day)//add days
{
$sum = strtotime(date("Y-m-d h:m:s", strtotime("$date")) . " +$day days");
$dateTo=date('Y-m-d h:m:s',$sum);
return $dateTo;
}
?>
