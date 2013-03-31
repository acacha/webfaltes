<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: rmz, Pau Gomez
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
 *$Id:logout.php 411 2010-03-19 18:27:17Z pg0mez $
 */

/**
 * Webfaltes
 * @author Carles Añó, Pau Gómez, rmz
 * @desc Pàgina que es torna quan NO s'ha pogut validar l'usuari.
 * @see logout.php, logout.tpl
 */

// Iniciem (recuperem) la sessió (cal posar-ho al capdamunt de cada script)
session_start();

include("config.inc.php");


$_SESSION['S_stop'] = 1;

require_once _INCLUDES.'common-header.php';

// Gestionem error si ve descripció d'error a través de coockie.
if (isset($_COOKIE['err'])){
    $err_descrip = $_COOKIE['err'];
} else {
   	$err_descrip = _ERR_001;
}

$err_descrip000 = _ERR_000;

$administrador = _ADMINISTRADOR;

$smarty->assign('administrador', $administrador);

$smarty->assign('err_descrip000',$err_descrip000);

$smarty->assign('err_descrip',$err_descrip);
	
$smarty->display('logout.tpl');
?>