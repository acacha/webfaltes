<?php

$old_level_reporting=error_reporting();
error_reporting(E_ALL ^ E_NOTICE);


/*
*cercar un grup
*/
$RSRC['consulta_grup'] = <<<EOF
SELECT codi_grup, nom_grup FROM grup;
EOF;

/*
*cercar un grup
*/
$RSRC['FALTES_USER'] = <<<EOF
SELECT * FROM incidencia where codi_alumne='{$VALS['codi_alumne']}' order by data_incidencia ASC;
EOF;

/*
* consulta hora
*/
$RSRC['Consulta_hora'] = <<<EOF
SELECT codi_hora, hora_inici, hora_final FROM interval_horari where codi_hora={$VALS['codi_hora']};
EOF;

/*
* consulta dia
*/
$RSRC['Consulta_dia'] = <<<EOF
SELECT * FROM dia_setmana where codi_dia='{$VALS['codi_dia']}';
EOF;


/*
* consulta motiu incidencia
*/
$RSRC['Consulta_motiu_incidencia'] = <<<EOF
SELECT * FROM descripcio_motius_incidencia where motiu_incidencia='{$VALS['motiu_incidencia']}';
EOF;

/*
* consulta motiu incidencia
*/
$RSRC['Consulta_assignatura'] = <<<EOF
SELECT * FROM assignatura where codi_assignatura='{$VALS['codi_assignatura']}';
EOF;


/*
*  Llistat tutor grup
*/ 
$RSRC['GRUPS_INFORME_RESUM'] = <<<EOF
SELECT codi_grup,nom_grup,nivell_educatiu FROM grup
WHERE tutor='{$VALS['codi_professor']}'
ORDER BY nivell_educatiu, codi_grup;

EOF;


/*
* llistat faltes alumnes mes
*/

$RSRC['consulta_incidencia_conserges_list'] = <<<EOF
SELECT codi_alumne, motiu_curt,motiu_llarg, hora_inici, incidencia.motiu_incidencia, incidencia.observacions, incidencia.codi_dia, incidencia.codi_hora, incidencia.codi_assignatura, assignatura.nom_assignatura, incidencia.data_incidencia, dia_setmana.dia_llarg
FROM incidencia  
inner join (interval_horari) ON interval_horari.codi_hora=incidencia.codi_hora
inner join (dia_setmana) ON dia_setmana.codi_dia=incidencia.codi_dia
inner join (assignatura) ON assignatura.codi_assignatura=incidencia.codi_assignatura 
inner join (descripcio_motius_incidencia) ON descripcio_motius_incidencia.motiu_incidencia = incidencia.motiu_incidencia  
WHERE codi_alumne = '{$VALS['number']}' && MONTH(data_incidencia) = MONTH('{$VALS['data']}') order by incidencia.data_incidencia, interval_horari.codi_hora;

EOF;


/**
 *  consulta per mostrar el pdf de l'alumne mes
 */
 
$RSRC['consulta_incidencia_conserges'] = <<<EOF
SELECT codi_alumne, motiu_curt,motiu_llarg, hora_inici, incidencia.motiu_incidencia, incidencia.observacions, incidencia.codi_dia, incidencia.codi_hora, incidencia.codi_assignatura, assignatura.nom_assignatura, incidencia.data_incidencia, dia_setmana.dia_llarg
FROM incidencia  
inner join (interval_horari) ON interval_horari.codi_hora=incidencia.codi_hora
inner join (dia_setmana) ON dia_setmana.codi_dia=incidencia.codi_dia
inner join (assignatura) ON assignatura.codi_assignatura=incidencia.codi_assignatura 
inner join (descripcio_motius_incidencia) ON descripcio_motius_incidencia.motiu_incidencia = incidencia.motiu_incidencia  
WHERE codi_alumne = '{$VALS['number']}' && MONTH(data_incidencia) = MONTH('{$VALS['data']}') order by data_incidencia, hora_inici;

EOF;


/*
* INSEREIX_ALUMNES_OCULTS
*/
$RSRC['INSEREIX_ALUMNES_OCULTS'] = <<<EOF
INSERT INTO ocultar_alumne (codi_alumne, codi_assignatura,codi_grup, nom, sn1, sn2, dni) VALUES ({$VALS['codi_alumne']},'{$VALS['codi_assignatura']}','{$VALS['codi_grup']}','{$VALS['nom']}','{$VALS['sn1']}','{$VALS['sn2']}','{$VALS['nom']}') ;

EOF;


/*
*  comprovar si un alumne està ocult
*/

$RSRC['COMPROVAR_OCULT_ALUMNE'] = <<<EOF
SELECT * FROM ocultar_alumne WHERE codi_alumne={$VALS['codi_alumne']} && codi_assignatura='{$VALS['codi_assignatura']}' && codi_grup='{$VALS['codi_grup']}';
EOF;


/*
*  ELIMINAR ALUMNE OCULT
*/
$RSRC['ELIMINAR_ALUMNE_OCULTS'] = <<<EOF
DELETE FROM ocultar_alumne WHERE codi_alumne={$VALS['codi_alumne']} && codi_assignatura='{$VALS['codi_assignatura']}' && codi_grup='{$VALS['codi_grup']}';
EOF;


/*
*  comprovar llistat alumnes afegits a les llistes ldap
*/

$RSRC['COMPROVAR_LLISTAT_AFEGITS_LDAP'] = <<<EOF
SELECT * FROM afegir_alumne WHERE codi_assignatura='{$VALS['codi_assignatura']}' && codi_grup='{$VALS['codi_grup']}';
EOF;




$RSRC['INSEREIX_ALUMNES_LDAP'] = <<<EOF
INSERT INTO afegir_alumne (codi_alumne,codi_assignatura,codi_grup, nom, sn1, sn2, dni) VALUES ({$VALS['codi_alumne']},'{$VALS['codi_assignatura']}','{$VALS['codi_grup']}','{$VALS['nom']}','{$VALS['sn1']}','{$VALS['sn2']}', '{$VALS['dni']}') ;

EOF;

/*
* ELIMINAR ALUMNE DE LDAP
*/
$RSRC['DELETE_ALUMNES_LDAP'] = <<<EOF
delete  FROM afegir_alumne WHERE codi_assignatura='{$VALS['codi_assignatura']}' && codi_grup='{$VALS['codi_grup']}' && codi_alumne= {$VALS['codi_alumne']};

EOF;


/*
*  comprovar llistat alumnes afegits a les llistes ldap
*/

$RSRC['COMPROVAR_ALUMNE_AFEGITS_LDAP'] = <<<EOF
SELECT * FROM afegir_alumne WHERE codi_assignatura='{$VALS['codi_assignatura']}' && codi_grup='{$VALS['codi_grup']}' && codi_alumne= {$VALS['codi_alumne']};
EOF;

/*
*  comprovar llistat alumnes afegits a les llistes ldap
*/

$RSRC['COMPROVAR_HORA'] = <<<EOF
SELECT * FROM classe
inner join (interval_horari) ON interval_horari.codi_hora=classe.codi_hora
WHERE codi_assignatura='{$VALS['codi_assignatura']}' && codi_grup='{$VALS['codi_grup']}';
EOF;

/*
*  comprovar llistat alumnes afegits a les llistes ldap
*/

$RSRC['INTERVAL_HORARI'] = <<<EOF
SELECT * FROM interval_horari;
EOF;

?>