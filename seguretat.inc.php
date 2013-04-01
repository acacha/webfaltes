<?php
// Comprovaci� de seguretat:
// Si:
//  - $_SESSION['S_stop'] no ha estat definida
//  - $_SESSION['S_stop'] �s cert (1) -> cal parar
//  - si passem per GET la variable $stop amb el valor 1 -> cal parar
// En tots aquests casos, redireccionem a  pantalla d'identificaci�, sense entrar al men�
// Tot i que podria funcionar amb un sol if, el desglossem per a majot claredat i per
// evitar eventuals problemes amb missatges de warning

// Comprovem variable de sessi� S_stop
// Si no tenim definida la variable de sessi� S_stop...
if (!isset($_SESSION['S_stop']))
{
	session_unset(); // esborrem totes les variables de sessi� 
	header ("Location: "._BASE_PATH_HTML."/identifica.php");  //redirigim a identificaci�
}
// Si la tenim definida i -es igual a 1 ...	
else if ((trim($_SESSION['S_stop']) == "1"))
{
	session_unset(); // esborrem totes les variables de sessi�
	header ("Location: "._BASE_PATH_HTML."/identifica.php");  //redirigim a identificaci�
}

// Comprovem varible stop (passada des d'un link)
// Si s'ha passat 'stop' ...	
if (isset($_GET['stop']))

	// Si val 1 ...
	 if ($_GET['stop'] == 1){
		session_unset(); // esborrem totes les variables
		$_SESSION['S_stop']=1; // posem  S_stop a 1 per si de cas
		header ("Location: "._BASE_PATH_HTML."/identifica.php");  //redirigim a identificaci�
}
?>