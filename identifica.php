<?php
/*---------------------------------------------------------------
 * Aplicatiu  d'incidències  Fitxer: identifica.php
 * Autor: Carles Añó   Data:
 * Descripció: Identificació d'usuaris
 * Pre condi.:
 * Post cond.:
 ----------------------------------------------------------------*/
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Año
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
 *$Id:identifica.php 1405 2010-09-24 07:18:35Z acacha $
 */
// Inicia sessió
session_start();

// General configuration
include_once("config.inc.php");

if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) { // if request is not secure, redirect to secure url
	$url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('Location: ' . $url);
        exit;
}

if (!is_readable("/usr/share/php/adodb/adodb.inc.php")){
	echo "<div class='login-warning'><b>ERROR!</b> No existeix la llibreria adodb, fitxer: <b>
	/usr/share/php/adodb/adodb.inc.php</b><br/> Consulteu la 
	<a href=\"http://acacha.org/mediawiki/index.php/Webfaltes#Instal.C2.B7lar_depend.C3.A8ncies\">
	documentació de l'aplicació</a></div>";	
} 
else {
	if (is_readable(_CONFIG_DIR."/"._MYSQL_CONNECTION_FILE)) {
    	include_once(_CONFIG_DIR."/"._MYSQL_CONNECTION_FILE);
	}
	else	{
		echo "<div class='login-warning'><b>ERROR!</b> No existeix el fitxer de connexió a MySQL: <b>".
		_CONFIG_DIR."/"._MYSQL_CONNECTION_FILE."</b><br/> Consulteu la 
		<a href=\"http://acacha.org/mediawiki/index.php/Webfaltes#Configuraci.C3.B3_de_l.27aplicaci.C3.B3_webfaltes\">
		documentació de l'aplicació</a></div>";
	}
}

if (is_readable(_CONFIG_DIR."/"._LDAP_CONNECTION_FILE))
    include_once(_CONFIG_DIR."/"._LDAP_CONNECTION_FILE);
else	{
	echo "<div class='login-warning'><b>ERROR!</b> No existeix el fitxer de connexió a Ldap: <b>".
	_CONFIG_DIR."/"._LDAP_CONNECTION_FILE."</b><br/> Consulteu la 
	<a href=\"http://acacha.org/mediawiki/index.php/Webfaltes#Configuraci.C3.B3_de_l.27aplicaci.C3.B3_webfaltes\">
	documentació de l'aplicació</a></div>";
}


// Posem variable de sessió a STOP (=1)
$_SESSION['S_stop'] = 1;

$_SESSION['user_type']="professor";
// Comprovem que s'hagin enviat les dades del formulari
// i les assignem a una variave amb el mateix nom
// per fer-les més manejables
//guardem el num d'usuari en una variable de sessió per qué estigui disponible
if (isset($_POST['enviar'])){
	
	$_SESSION['usuari'] = $_POST['usuari'];
	$usuari      = $_POST['usuari'];
	$contrasenya = $_POST['contrasenya'];
}

$tipusSelected=0;

// Si tenim la variable $usuari definida i té algun contingut...
if ( isset($usuari) && $usuari != "")
{
	// Definim  enllaços per a sortida en cas d'autoritzar o no
	$fitxer_correcte   = "./index.php?"; // fitxer redireccionament si usuari correcte. + interrogant al final
	$fitxer_NOcorrecte = "./logout.php"; // fitxer redireccionament si usuari incorrecte.

	// Creen consulta sql comparant usuari i contrasenya	

	$utils = new utils();

	$RSRC = array();
	$VALS = array();
		
	$VALS['usuari'] = $usuari;
	$VALS['contrasenya'] = MD5($contrasenya);
			
	$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

	$utils->p_dbg($RSRC, "Prova log");

	if (comprovaBINDusuari($usuari, $contrasenya)==TRUE) 
	{
		$ldapconfig['host'] = _LDAP_SERVER;
		#Només cal indicar el port si es diferent del port per defecte
		$ldapconfig['port'] = _LDAP_PORT;
		$ldapconfig['basedn'] = _LDAP_TEACHER_BASE_DN;
		
		$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
		
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		$password=_LDAP_PASSWORD;
		$dn=_LDAP_USER;
				
		if ($bind=ldap_bind($ds, $dn, $password)) {
		if ($bind=ldap_bind($ds)) {
		
		    //$filter = "(&(uid=".$usuari.")(userPassword=".$contrasenya."))";
		    $filter = "(uid=".$usuari.")";
		
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
		// Usuari i contrasenya vàlids (Control seguretat 1)
		$codi_professor=$info[0][_LDAP_USER_ID][0];
		$nom_professor=$info[0]['givenname'][0];
		$cognom1_professor=$info[0]['sn1'][0];
		$cognom2_professor=$info[0]['sn2'][0];
		$usuari=$info[0]['uid'][0];
		ldap_close($ds);

		//----------------
			$utils = new utils();
			$RSRC = array();
			$VALS = array();
				
			$VALS['codi_professor'] = $codi_professor;
					
			/*$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);
		
			$utils->p_dbg($RSRC, "Prova log");
			// Execució consulta. roles profe			
			$rs9 = $ConTut->Execute($RSRC['ROLES_PROFESSOR']) or die($ConTut->ErrorMsg());
			
			//print_r($rs9);
		//----------------
		$roles = "";
		while(!$rs9->EOF)
		{
			$roles.=$rs9->Fields('nom_role').",";
			$rs9->MoveNext();
		}*/
		//$_SESSION['roles'] = $roles;
		
		$_SESSION['codi_professor'] = $codi_professor;
		$_SESSION['S_codi_prof'] = $codi_professor;
		$_SESSION['nom_professor'] = $nom_professor;
		$_SESSION['cognom1_professor'] = $cognom1_professor;
		$_SESSION['cognom2_professor'] = $cognom2_professor;
		$_SESSION['usuari']=$usuari;
		$_SESSION['email'] = $email;
		/*
		$_SESSION['usuari'] = $usuari;
		$_SESSION['password'] = $password;
		$_SESSION['oldpassword'] = $oldpassword;
		$_SESSION['cleartext_password'] = $cleartext_password;
		$_SESSION['es_coordinador'] = $es_coordinador;
		$_SESSION['data_alta'] = girarDatahora($data_alta);
		$_SESSION['data_baixa'] = $data_baixa;
		$_SESSION['foto_perfil_pr'] = $foto_perfil_pr;
		$_SESSION['foto_perfil_pr_small'] = $foto_perfil_pr_small;
		$_SESSION['foto_perfil_pr_medium'] = $foto_perfil_pr_medium;*/

		// Anem a comprovar que aquest professor tingui classes assignades (Control seguretat 2)
		
		//$rs9->Close();
		$utils = new utils();
		$RSRC = array();
		$VALS = array();
		
		$VALS['codi_professor'] = $codi_professor;
			
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

		$utils->p_dbg($RSRC, "Prova log");
						
		// Execució consulta. Tutoria assignada?
		$rs2 = $ConTut->Execute($RSRC['COMPROVAR_CLASSE_ASSIGNADA_PROFESSOR']) or die($ConTut->ErrorMsg());


		// Hem trobar coincidència: tè tutoria.
		if (!$rs2->EOF)
		{
			// Professor assignat a una tutoria activa
			//$_SESSION['S_any_acad'] = $any_acad;
			$_SESSION['S_assignatura']    = $rs2->Fields('nom_asignatura');
			echo $_SESSION['S_assignatura'];
			//$_SESSION['S_nivell']   = $rs2->Fields('nivell');
			//$_SESSION['S_grup']     = $rs2->Fields('grup');
			// Tanquem segona connexió: ja tenim les dades!
			$rs2->Close();

		}
		else
		{
			//Mirar si el profe és substitut
			//Als substituts es posa un codi S{CODI_PROFE_SUBSTITUEIX}
			//$codi_professor
			$codi_profe_substituit = substr($codi_professor, 1);
			if (true) {
			// Professor que no tè cap tutoria activa el curs acadàmic 
			//sol.licitat
				$_SESSION['codi_professor'] = $codi_profe_substituit;
				$_SESSION['S_codi_prof'] = $codi_profe_substituit;
				$_SESSION['codi_professor_real'] = $codi_professor;
				$_SESSION['substitut'] = true;
				$_SESSION['codi_substituit'] = $codi_profe_substituit ;
				$rs2->Close();
			} else {
				session_unset(); // Esborrem (destruïm) variables de sessió
				setcookie("err", _ERR_002, time()+20); // Establim cookie per a missatge d'error
				$rs2->Close();
				header ("Location: $fitxer_NOcorrecte");  // Redireccionem com a no correcte
				exit;	
			}
			
		}
	

		
		// Com que ja hem comprovat que el professor tè tutoria,
		// autoritzem entrada
		$_SESSION['S_stop'] = 0 ;
		//hem de veure si el professor que ha fet login és un coordinador
		$utils = new utils();

		$RSRC = array();
		$VALS = array();
		$VALS['codi_professor'] = $codi_professor;
			
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

		$utils->p_dbg($RSRC, "Prova log");
						
		$result_4 = $ConTut->Execute($RSRC['GRUPS_ASSIGNATS_PROFESSOR']) or die($ConTut->ErrorMsg());

		/*
		 $nombre_grups = 0;
		 while (list($codi_grup)=$result->fields) {
		 ++$nombre_grups;
		 //montem l'array associatiu $TUTOR, amb els camps :
		 $TUTOR['nombre_grups'] per guardar de quants grups és tutor el professor
		 $TUTOR['1'] codi del primer grup que és tutor
		 $TUTOR['2'] codi del segon grup que és tutor
		 etc...

		 $TUTOR['nombre_grups']=$nombre_grups;
		 $TUTOR['$nombre_grups']=$codi_grup;

		 */
		$n = 0; //número de grups dels quals el professor és tutor

		if (!$result_4->EOF)
		{
			//$codi_grup =  $result_4->Fields('codi_grup');

			while (list($codi_grup)=$result_4->fields) 
			{
				++$n;
				$_SESSION["tutor_de_$n"] = $codi_grup;
				$result_4->MoveNext(); //següent grup
			}
		}
		else 
		{
			$codi_grup = 0;
		}

		$result_4 ->Close();
		$_SESSION['num_grups_tutor']= $n;
		//Check if is coordinator
		$utils = new utils();

		$RSRC = array();
		$VALS = array();
		$VALS['codi_professor'] = $codi_professor;
			
		$utils->get_global_resources($RSRC, "db/sql_querys_inc.php", $VALS);

		$utils->p_dbg($RSRC, "Prova log");
						
		$result_5 = $ConTut->Execute($RSRC['COMPROVA_COORDINADOR']) or die($ConTut->ErrorMsg());
		
		if (!$result_5->EOF){
			$es_coordinador =  $result_5->Fields('es_coordinador');
		}
		else {
			$es_coordinador = 0;
		}
		
		$result_5 ->Close();

		//Guardem el grup en una variable de sessió
		$_SESSION['es_coordinador'] = $es_coordinador;
		// Redireccionem com a correcte
		header ("Location: $fitxer_correcte".session_name()."=".session_id());
		exit;
	} else {
		header ("Location: $fitxer_NOcorrecte"); // Redireccionem com a no correcte
		
		
	}

	// Si no hem trobat cap coincidència d'usuari i contrasenya al fitxer...
	$rs1->Close();
	session_unset(); // Esborrem (destruïm) variables de sessió
	//header ("Location: $fitxer_NOcorrecte"); // Redireccionem com a no correcte
	exit;
}


//We load here common header application
$tipusSelected=0;

$smarty->assign('tipusSelected', $tipusSelected);
$smarty->assign('URL_ACTION_FORM', $_SERVER['PHP_SELF']);

$smarty->display('identifica.tpl');

//We load here common foot application
$smarty->display('foot.tpl');

?>
