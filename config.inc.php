<?php
/*
 * webfaltes - https://sourceforge.net/projects/webfaltes/
 * Copyright (c) 2010, Sergi Tur Badenas _Carles Añó
 * Coautors: Ester Almela Sánchez 
 
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
 */
/*$Id:config.inc.php 1327 2010-07-15 12:26:36Z irent88 $*/
/**
 * Aplicatiu d'incidencies de webfaltes
 * @author Carles Añó, Ester Almela
 * @desc Definició de variables
 * @see config.inc.php
 */
 
 
 //fitxers configurables
 
define("_URL","https://www.iesebre.com");
define("_MATERIA","Unitat Formativa");
define("_WIKI","acacha.org/mediawiki/index.php/Webfaltes");


// Constants de centre
define("_CENTRE", "Institut de l'Ebre");
define("_POBLACIO", "Tortosa");
define("_DIRECTOR", "Àngel Aznar");
define("_SECRETARI", "Elisa Puig");
define("_ADMINISTRADOR", "stur ARROBA iesebre.com");
define("_PREFIX_TEACHER_PHOTO", "teacher_");
define("_PREFIX_STUDENT_PHOTO", "student_");
define("_PREFIX_FATHER_PHOTO", "father_");
define("_ANY_COMENCAMENT_CURS", "2012");
define("_ANY_FINALITZACIO_CURS", "2013");

//
define("_CONFIG_DIR","/etc/webfaltes");
define("_CONFIG_FILE","webfaltes.conf");
define("_MYSQL_CONNECTION_FILE","webfaltes_mysql_con.php");
define("_LDAP_CONNECTION_FILE","webfaltes_ldap_con.php");


// Constants directoris aplicatiu
define("_BASE_PATH",dirname(__FILE__));
define("_BASE_PATH_HTML","/webfaltes");
define("_DIR_ADODB",_BASE_PATH."/adodb/");      // directori carpeta ADODB relativa a web
define("_DIR_CONNEXIO",_BASE_PATH."/connexio/"); // directori definició connexions BD
define("_DIR_IMATGES",_BASE_PATH_HTML."/imatges/");   // directori on es troben les imatges
define("_HEADER_LOGO_PATH",_DIR_IMATGES."capsalera.jpeg");
define("_LOGO_ACCES_PROFILE_PATH",_DIR_IMATGES."acces_profile.gif");     
define("_PROFILE_NULL_PATH",_DIR_IMATGES."perfil.jpeg");
define("_PROFILE_PHOTO", "photo/");

// directori on es troben les imatges
define("_LIBS",_BASE_PATH."/libs/");      // Library folders
define("_INCLUDES",_BASE_PATH."/includes/");      // Include folders

// Smarty Folders
define("_SMARTY_TEMPLATES_FOLDER",_BASE_PATH."/smarty/templates");
define("_SMARTY_TEMPLATES_C_FOLDER","/var/spool/webfaltes");
#define("_SMARTY_CONFIGS_FOLDER",_BASE_PATH."/smarty/configs");

define("_DEFAULT_ACTION_FORM", 'selecalum_tutoria.php');

// Constants d'errors
define("_ERR_000","Poseu-vos en contacte amb l'administrador del sistema");
define("_ERR_001","Aquest usuari no està actiu o hi ha un error
                   en el nom d'usuari o la contrasenya ");
define("_ERR_002"," L'usuari/a no té assignada cap tutoria");


define("_FIRST_LEVEL_TAKE_ATTENDACE_URL","/webfaltes/index.php");
define("_SECOND_LEVEL_TUTORSHIP","/webfaltes/tutoria.php");
define("_THIRD_LEVEL_TUT_TUT","/webfaltes/selecgroup.php?form_action=selecalum_tutoria.php");
define("_THIRD_LEVEL_TUT_GES","/webfaltes/selecgroup.php?form_action=StudentManagment.php");
define("_SECOND_LEVEL_REPORTS","/webfaltes/selec_informe.php");
define("_SECOND_LEVEL_STUDENTS","/webfaltes/gestio_alumnes.php");
define("_SECOND_LEVEL_PARES","/webfaltes/gestio_pares.php");
define("_SECOND_LEVEL_PROF","/webfaltes/gestio_profes.php");
define("_SECOND_LEVEL_GRUPS","/webfaltes/gestio_grups.php");
define("_SECOND_LEVEL_SMS","/webfaltes/sms_history_1.php");
define("_SECOND_LEVEL_SURVEYS","/webfaltes/surveys/websurveys.php");
define("_SECOND_LEVEL_ESTADISTIQUES","/webfaltes/selec_estadistiques.php");
define("_SECOND_LEVEL_ADMIN","/webfaltes/administrar.php");


define("_THIRD_LEVEL_REPORTS_CENTRE_D_H_1","/webfaltes/informe_centre_d_h_1.php");
define("_THIRD_LEVEL_REPORTS_CENTRE_DI_DF_1","/webfaltes/informe_centre_di_df_1.php");
define("_THIRD_LEVEL_REPORTS_CENTRE_RANKING_DI_DF_1","/webfaltes/informe_centre_ranking_di_df_1.php");
define("_THIRD_LEVEL_REPORTS_CENTRE_PROFESSORS_PDF","/webfaltes/reports/informe_centre_professors_pdf.php");
define("_THIRD_LEVEL_REPORTS_RESUM_GRUP_DI_DF_1","/webfaltes/informe_resum_grup_di_df_1.php");
define("_THIRD_LEVEL_REPORTS_RESUM_GRUP_FALTES_MES_1","/webfaltes/informe_resum_grup_faltes_mes_1.php");
define("_THIRD_LEVEL_REPORTS_RESUM_CREDIT_DI_DF_1","/webfaltes/informe_resum_credit_di_df_1.php");



include("php_config.php");

?>
