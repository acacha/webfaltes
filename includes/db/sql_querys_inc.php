<?php

$old_level_reporting=error_reporting();
error_reporting(E_ALL ^ E_NOTICE);

/**
 * TODO 
 * @var String
 */
$RSRC['CONSULTA1'] = <<<EOF
SELECT codi_alumne, nom_alumne, group_code, count( * ) AS total
FROM `incidencia` NATURAL JOIN alumne INNER JOIN student_groups ON (alumne.codi_alumne=student_groups.student_code) 
WHERE motiu_incidencia = 1
AND data_incidencia BETWEEN '{$VALS['str_data_inicial']}' AND '$str_data_final'
AND NOT 
(
student_groups.group_code = '1INFMA'
OR student_groups.group_code = '1INFMB'
OR student_groups.group_code = '2INFM'
OR student_groups.group_code = '1INFS'
OR student_groups.group_code = '2INFS'
)
GROUP BY codi_alumne, nom_alumne, group_code
ORDER BY total DESC
LIMIT 0 , $top 
EOF;
//RMZ-----------------------------------------------------
//informe_resum_grup_di_df_1.php
$RSRC['GRUPS_INFORME_RESUM_COORD'] = <<<EOF
SELECT codi_grup,nom_grup,nivell_educatiu
FROM grup
ORDER BY nivell_educatiu, codi_grup;

EOF;


$RSRC['GRUPS_INFORME_RESUM'] = <<<EOF
SELECT codi_grup,nom_grup,nivell_educatiu
FROM grup
WHERE tutor='{$VALS['codi_professor']}'
ORDER BY nivell_educatiu, codi_grup;

EOF;


//Identifica.php
$RSRC['COMPARACIO_USUARI_CONTRASENYA'] = <<<EOF
SELECT *  FROM professor
WHERE usuari='{$VALS['usuari']}' AND password='{$VALS['contrasenya']}';

EOF;

$RSRC['ROLES_PROFESSOR'] = <<<EOF
SELECT professor.codi_professor, nom_role
FROM professor, role, role_professor
WHERE professor.codi_professor=role_professor.codi_professor
AND role.codi_role=role_professor.codi_role
AND professor.codi_professor={$VALS['codi_professor']};

EOF;

$RSRC['COMPROVAR_CLASSE_ASSIGNADA_PROFESSOR'] = <<<EOF
SELECT nom_assignatura
FROM assignatura, classe
WHERE codi_professor='{$VALS['codi_professor']}' AND classe.codi_assignatura = assignatura.codi_assignatura;

EOF;

$RSRC['GRUPS_ASSIGNATS_PROFESSOR'] = <<<EOF
SELECT codi_grup
FROM grup
WHERE tutor ='{$VALS['codi_professor']}';

EOF;

$RSRC['COMPROVA_COORDINADOR'] = <<<EOF
SELECT es_coordinador
FROM rol_professor
WHERE codi_professor = '{$VALS['codi_professor']}';

EOF;

//informe_centre_ranking_di_df_2.php
/*
 * SELECT codi_alumne, group_code, count( * ) AS total
 * FROM `incidencia` INNER JOIN student_groups ON (incidencia.codi_alumne=student_groups.student_code)
 * WHERE motiu_incidencia = 1 AND incidencia.codi_alumne IN ({$VALS['codi_alumne']})
 * AND data_incidencia BETWEEN '{$VALS['str_data_inicial']} ' AND '{$VALS['str_data_final']}'
 * AND NOT (
 * student_groups.group_code = '1INFMA'
 * OR student_groups.group_code = '1INFMB'
 * OR student_groups.group_code = '2INFM'
 * OR student_groups.group_code = '1INFS'
 * OR student_groups.group_code = '2INFS'
 * )
 * GROUP BY codi_alumne, group_code
 * ORDER BY total DESC
LIMIT 0 , {$VALS['top']}
 */
$RSRC['COMPTA_INCIDENCIES'] = <<<EOF

SELECT codi_alumne, group_code, count( * ) AS total
FROM `incidencia`
WHERE motiu_incidencia = 1 AND incidencia.codi_alumne IN ({$VALS['codi_alumne']})
AND data_incidencia BETWEEN '{$VALS['str_data_inicial']} ' AND '{$VALS['str_data_final']}'
GROUP BY codi_alumne
ORDER BY total DESC
LIMIT 0 , {$VALS['top']}

EOF;





/**
 * 
 * @var unknown_type
 * @author Josep Llaó Angelats
 * @see selecalum.php
 */
 
$RSRC['consulta_incidencia_pares'] = <<<EOF
SELECT codi_alumne, motiu_curt,motiu_llarg, hora_inici, incidencia.motiu_incidencia, incidencia.observacions, incidencia.codi_dia, incidencia.codi_hora, incidencia.codi_assignatura, assignatura.nom_assignatura
FROM incidencia  
inner join (interval_horari) ON interval_horari.codi_hora=incidencia.codi_hora
inner join (assignatura) ON assignatura.codi_assignatura=incidencia.codi_assignatura 
inner join (descripcio_motius_incidencia) ON descripcio_motius_incidencia.motiu_incidencia = incidencia.motiu_incidencia  
WHERE codi_alumne = '{$VALS['number']}' && WEEK(data_incidencia) = WEEK('{$VALS['data']}',1) group by interval_horari.codi_hora

EOF;
/**
 * 
 * @ consultar permisos conserges
 * @author Josep Llaó Angelats
 * @see selecalum.php
 */
 
$RSRC['consulta_permisos_conserge'] = <<<EOF
SELECT es_conserge FROM rol_professor WHERE codi_professor = '{$VALS['dni']}'

EOF;

/**
 * 
 * @var unknown_type
 * @author Josep Llaó Angelats
 * @see open.php
 */
 
$RSRC['CONSULTA_ASSIGNATURA_GRUP'] = <<<EOF
SELECT * FROM grup_alumnes WHERE codi_assignatura = '{$VALS['ass']}'
EOF;



/**
 * 
 * @var eliminar alumne de optativa
 * @author Josep Llaó Angelats
 * @see open.php
 */
 
$RSRC['ELIMINAR_ALUMNE_GRUP'] = <<<EOF
DELETE FROM grup_alumnes WHERE codi_assignatura = '{$VALS['ass']}' && codi_alumne='{$VALS['alu']}'
EOF;

/**
 * 
 * @var add alumne optativa
 * @author Josep Llaó Angelats
 * @see selecalumgrup2.php
 */
 
$RSRC['ADD_ALUMNE_GRUP'] = <<<EOF
INSERT INTO grup_alumnes (codi_assignatura,codi_alumne,nom) VALUES ('{$VALS['optativa']}','{$VALS['number']}' ,'{$VALS['cn']}') 
EOF;

/**
 * 
 * @var add alumnes optativa
 * @author Josep Llaó Angelats
 * @see controlador.php
 */
 
$RSRC['AFEGIR_ALUMNES'] = <<<EOF
INSERT INTO grup_alumnes (codi_assignatura,codi_alumne,nom) VALUES ('{$VALS['optativa']}','{$VALS['key']}' ,'{$VALS['nom']}') 
EOF;

/**
 * 
 * @var add optativa
 * @author Josep Llaó Angelats
 */
 
$RSRC['ADD_OPTATIVA'] = <<<EOF
INSERT INTO assignatura (codi_assignatura,nom_assignatura,optativa) VALUES ('{$VALS['codi_assignatura']}','{$VALS['nom_assignatura']}' ,'{$VALS['optativa']}') 
EOF;

/**
 * 
 * @var add assignatura
 * @author Josep Llaó Angelats
 */
 
$RSRC['ADD_ASSIGNATURA'] = <<<EOF
INSERT INTO assignatura (codi_assignatura,nom_assignatura,optativa) VALUES ('{$VALS['codi_assignatura']}','{$VALS['nom_assignatura']}' ,'{$VALS['optativa']}') 
EOF;

/**
 * 
 * @var Modificar Optativa
 * @author Josep Llaó Angelats
 */
 
$RSRC['MODIFICAR_OPTATIVA'] = <<<EOF
update assignatura 
SET  
codi_assignatura='{$VALS['codi_assignatura']}', 
nom_assignatura='{$VALS['nom_assignatura']}', 
optativa= '{$VALS['optativa']}' 
where 
codi_assignatura= '{$VALS['codi_assignatura']}';
/*nom_assignatura ='{$VALS['nom_assignatura']}' ,
optativa='{$VALS['optativa']}' */
EOF;

/**
 * 
 * eliminar optativa
 * @author Josep Llaó Angelats
 */
 
$RSRC['DELETE_OPTATIVA_ASSIGNATURA'] = <<<EOF
delete from assignatura where codi_assignatura = '{$VALS['codi_assignatura']}'
EOF;


/*
 * SELECT codi_alumne, group_code, count( * ) AS total
 * FROM `incidencia` INNER JOIN student_groups ON (incidencia.codi_alumne=student_groups.student_code)
 * WHERE motiu_incidencia = 1 AND incidencia.codi_alumne IN ({$VALS['codi_alumne']})
 * AND data_incidencia BETWEEN '{$VALS['str_data_inicial']} ' AND '{$VALS['str_data_final']}'
 * GROUP BY codi_alumne, group_code
 * ORDER BY total DESC
 * LIMIT 0 , {$VALS['top']}
 */
$RSRC['COMPTA_INCIDENCIES2'] = <<<EOF

SELECT codi_alumne, count( * ) AS total
FROM `incidencia` 
WHERE motiu_incidencia = 1 AND incidencia.codi_alumne IN ({$VALS['codi_alumne']})
AND data_incidencia BETWEEN '{$VALS['str_data_inicial']} ' AND '{$VALS['str_data_final']}'
GROUP BY codi_alumne
ORDER BY total DESC
LIMIT 0 , {$VALS['top']}

EOF;

//----------------------------------------------------------


/**
 * consulta que ens fa un select del codi del grup, el seu nom per al nivell 
 * educatiu de la ESO, Informàtica o batxillerat i ens l'ordena per nivell
 * educatiu i codi de grup
 * @var CONSULTA_SQL
 * @author Albert_Mestre
 */
/*
 * SELECT codi_grup, nom_grup
 * FROM grup
 * WHERE nivell_educatiu = 'ESO' OR nivell_educatiu = 'Inform' OR nivell_educatiu = 'BA'
 * ORDER BY nivell_educatiu, codi_grup;
 */
$RSRC['CONSULTA_CODI_GRUP_NOM_GRUP_ESO_INFORMATICA_BATX'] = <<<EOF
SELECT codi_grup, nom_grup
FROM grup
ORDER BY nivell_educatiu, codi_grup;
EOF;

/**
 * Aquesta consulta ens diu si has entrar com a coordinador
 * @var array
 * @author Carlos Cristoful Rodriguez
 * @see: selecgroup.php
 */
/*
 * SELECT codi_grup
FROM grup
WHERE nivell_educatiu = 'ESO' OR nivell_educatiu = 'Inform' 
OR nivell_educatiu= 'BA' OR nivell_educatiu= 'promo' OR nivell_educatiu= 'AC' 
ORDER BY nivell_educatiu, codi_grup;
 */
$RSRC['sql_selec_coordinador'] = <<<EOD
SELECT codi_grup
FROM grup
ORDER BY nivell_educatiu, codi_grup;
EOD;

/**
 * Aquesta consulta ens dius si has entrat com a tutor
 * @var array
 * @author Carlos Cristoful Rodriguez
 * @see: selecgroup.php
 */
$RSRC['sql_selec_tutor'] = <<<EOD
SELECT codi_grup
FROM grup
WHERE tutor='{$VALS['codi_professor']}';
EOD;

/**
 * Consulta que ens selecciona el codi_alumne i nom alumne i ens fa una reunió
 * natural dels grups per codi alumne i grup on el codi grup es igual que el que
 * li passem i ens l'ordena per nom d'alumne 
 * @var CONSULTA_SQL
 * @author Albert_Mestre
 */	
$RSRC['CONSULTA_RECUPERA_ALUMNES_GRUP'] = <<<EOF
SELECT codi_alumne, nom_alumne
FROM alumne INNER JOIN student_groups ON (alumne.codi_alumne=student_groups.student_code)
WHERE student_groups.group_code = '{$VALS['codi_grup']}'
ORDER BY nom_alumne
EOF;

/**
 * Consulta que ens fa un recompte de les incidencies agafant el codi d'alumne i
 * el motiu de la incidència i la data entre una data inicial seleccionada i una
 * data final seleccionada
 * @var CONSULTA_SQL
 * @author Albert_Mestre
 */
$RSRC['CONSULTA_RECOMPTE'] = <<<EOF
SELECT COUNT(*) AS total
FROM incidencia
WHERE codi_alumne = '{$VALS['codi_alumne']}'
AND motiu_incidencia = '{$VALS['n']}'
AND motiu_incidencia IN {$VALS['motius_informe']}
AND data_incidencia BETWEEN '{$VALS['str_data_inicial']}' AND '{$VALS['str_data_final']}';
EOF;

/**
 * 
 * @var unknown_type
 * @author Amado Domenech Antequera
 * @see selecalum_tutoria.php
 */
$RSRC['MOSTRAR_ALUMNES_GRUP'] = <<<EOF
SELECT codi_alumne, nom_alumne
FROM alumne
INNER JOIN student_groups
ON (alumne.codi_alumne = student_groups.student_code)
WHERE student_groups.group_code = '{$VALS['group_code']}'
AND data_baixa IS NULL ORDER BY nom_alumne;
EOF;
/**
 * Consta el total de incidencies de un alumne i el motiu que estige entre 
 * la data inicial i la final
 * @var CONSULTA_SQL
 * @author Jordi_cid_royo
 * @see informe_resum_grup_di_df_2
 */
$RSRC['informe_resum_grup_di_df_2__1'] =<<<EOF
SELECT COUNT(*) AS total
FROM incidencia
WHERE codi_alumne = '{$VALS['codi_alumne']}'
AND motiu_incidencia = '{$VALS['n']}'
AND data_incidencia BETWEEN '{$VALS['str_data_inicial']}' AND '{$VALS['str_data_final']}';
EOF;
/**
 * Extreu el codi_alumne i nom_alumne de la taula alumne on el estudiat 
 * te el mateix codi que el codi grup.
 * @var CONSULTA_SQL
 * @author Jordi_cid_royo
 * @see informe_resum_grup_di_df_2
 */
$RSRC['informe_resum_grup_di_df_2__2'] =<<<EOF
SELECT codi_alumne, nom_alumne
FROM alumne INNER JOIN student_groups ON (alumne.codi_alumne=student_groups.student_code)
WHERE student_groups.group_code = '{$VALS['codi_grup']}'
ORDER BY nom_alumne
EOF;

/**
 * Selecciona el codi_grup de de la taula grup on el el nivell_educatiu es ESO
 * o Batxilletat o Informatica o promocio ordenat per nivell_educatiu, codi_grup
 * @see selecgrup_tutoria.php
 * @var CONSULTA_SQL
 * @author Jordi_cid_royo
 */
$RSRC['selecgrup_tutoria__1'] =<<<EOF
SELECT codi_grup
FROM grup
WHERE nivell_educatiu = 'ESO' 
OR nivell_educatiu = 'Inform' 
OR nivell_educatiu= 'BA' 
OR nivell_educatiu= 'promo'
ORDER BY nivell_educatiu, codi_grup
EOF;
/**
 * Selecciona el codi grup relacionat amb el codi professor.
 * @see selecgrup_tutoria.php
 * @var CONSULTA_SQL
 * @author Jordi_cid_royo
 */
$RSRC['selecgrup_tutoria__2'] =<<<EOF
SELECT codi_grup
FROM grup
WHERE tutor='{$VALS['codi_professor']}'
EOF;


/*Funcio de Ivan*/
/** 
 * Funcio que et trau un llistat de grups  
 * @var array/consulta sql
 */
/*
 * SELECT codi_grup, nom_grup
 * FROM grup
 * WHERE nivell_educatiu = 'ESO' OR nivell_educatiu = 'Inform' OR nivell_educatiu = 'BA'
 * ORDER BY nivell_educatiu, codi_grup;
 */
$RSRC['CONSULTA_GRUP_NIVELL_EDUCATIU'] = <<<EOF
SELECT codi_grup, nom_grup
FROM grup
ORDER BY nivell_educatiu, codi_grup;
EOF;

/*Funcio de Ivan*/
/** 
 * Mostra les faltes que han que han comés els alumnes de un o mes grups per a 
 * un dia i una hora determinades.
 * @var array/consulta sql
 */
/*
 * Consulta vella CONSULTA_FALTES_HORA_GRUP_ALUMNE
 * 
 * SELECT nom_alumne, motiu_curt, nom_assignatura, cognom1_professor, nom_professor
 * FROM alumne INNER JOIN student_groups ON (alumne.codi_alumne=student_groups.student_code) NATURAL JOIN incidencia NATURAL JOIN descripcio_motius_incidencia NATURAL JOIN assignatura
 * WHERE student_groups.group_code = '{$VALS['codi_grup']}'
 * AND data_incidencia = '{$VALS['str_data_informe']}'
 * AND codi_hora = {$VALS['hora_informe']}
 * AND motiu_incidencia IN {$VALS['motius_informe']}
 * ORDER BY nom_alumne;
 * 
 * SELECT incidencia.codi_alumne, motiu_curt, nom_assignatura, incidencia.codi_professor
 * FROM incidencia INNER JOIN student_groups ON (incidencia.codi_alumne=student_groups.student_code) NATURAL JOIN descripcio_motius_incidencia NATURAL JOIN assignatura
 * WHERE student_groups.group_code = '{$VALS['codi_grup']}'
 * AND data_incidencia = '{$VALS['str_data_informe']}'
 * AND codi_hora = {$VALS['hora_informe']}
 * AND motiu_incidencia IN {$VALS['motius_informe']}
 * AND incidencia.codi_alumne = {$VALS['codi_all']}
 * ORDER BY incidencia.codi_alumne;
 */
$RSRC['CONSULTA_FALTES_HORA_GRUP_ALUMNE'] = <<<EOF
SELECT incidencia.codi_alumne, descripcio_motius_incidencia.motiu_curt, assignatura.nom_assignatura, incidencia.codi_professor
FROM incidencia
NATURAL JOIN grup
NATURAL JOIN descripcio_motius_incidencia
NATURAL JOIN assignatura
WHERE grup.codi_grup = '{$VALS['codi_grup']}'
AND incidencia.data_incidencia = '{$VALS['str_data_informe']}'
AND incidencia.codi_hora = '{$VALS['hora_informe']}'
AND incidencia.codi_alumne = '{$VALS['codi_alumne']}'
AND incidencia.motiu_incidencia
IN {$VALS['motius_informe']}
ORDER BY incidencia.codi_alumne;
EOF;

/** Aquesta funcio mostra tots els estudiants d'un grup
 * @see studentManagement.php
 * @var array
 * @author Pau Gómez
 */
$RSRC['OBTAIN_ALL_STUDENTS_FROM_GROUP'] = <<<EOF
SELECT codi_alumne, nom_alumne
FROM alumne
WHERE data_baixa IS NULL AND codi_alumne NOT IN (
SELECT codi_alumne
FROM alumne
INNER JOIN student_groups
ON (alumne.codi_alumne = student_groups.student_code)
WHERE student_groups.group_code = '{$VALS['codi_grup']}'
AND data_baixa IS NULL) {$VALS['if_search']} ORDER BY nom_alumne
EOF;

/** Aquesta funcio mostra X estudiants d'un grup
 * @see studentManagement.php
 * @var array
 * @author Pau Gómez
 */
$RSRC['OBTAIN_STUDENTS_FROM_GROUP']  = <<<EOF
SELECT codi_alumne, nom_alumne
FROM alumne
INNER JOIN student_groups
ON (alumne.codi_alumne = student_groups.student_code)
WHERE student_groups.group_code = '{$VALS['codi_grup']}'
AND data_baixa IS NULL
ORDER BY nom_alumne
EOF;

/** Aquesta funcio mostra intervals horaris
 * @see informe_centre_d_h_1.php
 * @var array
 * @author Pau Gómez
 */
$RSRC['MOSTRAR_HORES'] = <<<EOF
SELECT codi_hora, hora_inici, hora_final
FROM interval_horari
EOF;

/**
 * Consulta que ens diu el nom de l'assignatura segons el codi
 * @see informe_resum_credit_di_df_2.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_NOM_ASSIGNATURA'] = <<<EOF
	SELECT nom_assignatura
	FROM assignatura
	WHERE codi_assignatura = '{$VALS['codi_assignatura']}';
EOF;

/**
 * Consulta que recupera els alumnes del grup
 * @see informe_resum_credit_di_df_2.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_RECUPERAR_ALUMNES_GRUP'] = <<<EOF
	SELECT codi_alumne, nom_alumne
	FROM alumne INNER JOIN student_groups 
		ON (alumne.codi_alumne=student_groups.student_code)
    WHERE student_groups.group_code = '{$VALS['codi_grup']}'
    ORDER BY nom_alumne;
EOF;

/**
 * Per cada alumne mostrem les seves incidències, per cada incidència
 * @see informe_resum_credit_di_df_2.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_INCIDENCIA_ALUMNE'] = <<<EOF
	SELECT COUNT(*) AS total
	FROM incidencia
	WHERE codi_alumne = '{$VALS['codi_alumne']}'
		AND codi_assignatura = '{$VALS['codi_assignatura']}'
		AND motiu_incidencia = '{$VALS['n']}'
		AND data_incidencia BETWEEN '{$VALS['str_data_inicial']}' 
		AND '{$VALS['str_data_final']}';
EOF;

/**
 * Consulta que mira si el professor escollit és tutor d'algun grup
 * @see index.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_COMPROVA_TUTOR'] = <<<EOF
	SELECT codi_grup
	FROM grup
	WHERE tutor = '{$VALS['teacher_code']}';
EOF;

/**
 * Consulta que comprova si el professor que ha fet login és un coordinador
 * @see index.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_COMPROVA_COORDINADOR'] = <<<EOF
	SELECT es_coordinador
	FROM rol_professor
	WHERE codi_professor = '{$VALS['teacher_code']}';
EOF;

/**
 * Consulta de selecció de les assignatures d'avui corresponents al 
 * professor que ha iniciat la sessió
 * @see index.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_SELECT_ASSIGN_AVUI_PROF'] = <<<EOF
	SELECT assignatura.nom_assignatura, grup.nom_grup, grup.codi_grup,
		   classe.codi_dia, classe.codi_hora, classe.codi_assignatura,
		   interval_horari.hora_inici, interval_horari.hora_final, optativa
	FROM assignatura
		 NATURAL JOIN classe NATURAL JOIN grup 
		 NATURAL JOIN interval_horari
	WHERE classe.codi_professor = '{$VALS['teacher_code']}'
		  AND  classe.codi_dia = '{$VALS['day_of_week']}'
		  ORDER BY classe.codi_hora, grup.nom_grup
EOF;

$RSRC['CONSULTA_SELECT_ASSIGN_AVUI_PROF_ASS'] = <<<EOF
		SELECT assignatura.nom_assignatura, grup.nom_grup, grup.codi_grup,
		   classe.codi_dia, classe.codi_hora, classe.codi_assignatura,
		   interval_horari.hora_inici, interval_horari.hora_final, optativa, classe.codi_hora
	FROM assignatura
		 NATURAL JOIN classe NATURAL JOIN grup 
		 NATURAL JOIN interval_horari
	WHERE classe.codi_professor = '{$VALS['teacher_code']}'
		  AND  classe.codi_dia = '{$VALS['day_of_week']}'
		  AND  classe.codi_assignatura='{$VALS['codi_assignatura']}'
		  ORDER BY classe.codi_hora, grup.nom_grup
EOF;

/*
 * CONSULTA VELLA 
 * SELECT DISTINCT codi_incidencia		
 * FROM classe NATURAL JOIN alumne LEFT OUTER JOIN (SELECT * FROM incidencia 
 * WHERE data_incidencia = '{$VALS['data_incidencia']}'
 * AND codi_dia='{$VALS['codi_dia']}' 
 * AND codi_hora= '{$VALS['codi_hora']}') AS inc_data USING(codi_alumne)		
 * WHERE classe.codi_dia = '{$VALS['codi_dia']}'
 * AND classe.codi_hora = '{$VALS['codi_hora']}'		
 * AND classe.codi_assignatura = '{$VALS['codi_assignatura']}'
 * AND alumne.codi_alumne = '{$VALS['codi_alumne']}';
 */
/**
 * 
 * @var array
 * @see insereix_inc.php
 * Consulta de selecció dels alumnes corresponents a l'assignatura per el 
 * dia de la setmana indicat, hora indicada, data indicada
 * @author Joan Verge Chillida
 * 
 */

$RSRC['INSEREIX_INC_1'] = <<<EOF
SELECT DISTINCT incidencia.codi_incidencia
FROM classe NATURAL JOIN incidencia
WHERE incidencia.data_incidencia = '{$VALS['data_incidencia']}'
AND incidencia.codi_dia = '{$VALS['codi_dia']}'
AND incidencia.codi_hora = '{$VALS['codi_hora']}'
AND classe.codi_dia = '{$VALS['codi_dia']}'
AND classe.codi_hora = '{$VALS['codi_hora']}'
AND classe.codi_assignatura = '{$VALS['codi_assignatura']}'
AND incidencia.codi_alumne = '{$VALS['codi_alumne']}';		
EOF;

/**
 * 
 * @var array
 * @see insereix_inc.php
 * inserta les dades de:
 * codi_alumne, codi_dia, codi_hora, codi_assignatura, data_incidencia,
 * motiu_incidencia, justificant, observacions, cognom1_professor,
 * nom_professor, codi_professor
 * a la taula insidencia
 * @author Joan Verge Chillida
 */
$RSRC['INSEREIX_INC_2'] = <<<EOF
INSERT INTO incidencia VALUES		
(NULL, '{$VALS['codi_alumne']}', '{$VALS['codi_dia']}', '{$VALS['codi_hora']}',
'{$VALS['codi_assignatura']}', '{$VALS['data_incidencia']}',
'{$VALS['motiu_incidencia']}', '{$VALS['justificant']}','','', '{$VALS['observacions']}',
'{$VALS['cognom1_professor']}', '{$VALS['nom_professor']}',
'{$VALS['codi_professor']}', NOW(),NOW());
EOF;

$RSRC['INSEREIX_INC_5'] = <<<EOF
SELECT motiu_incidencia
FROM incidencia
WHERE codi_incidencia = '{$VALS['codi_incidencia']}'
EOF;


/**
 * Consulta que mostra el grups quan l'usuari és coordinador.
 * @var array
 * @author Ester Almela
 */
//WHERE nivell_educatiu = 'ESO' OR nivell_educatiu = 'Inform' OR nivell_educatiu = 'BA'
$RSRC['COORDINADOR_MOSTRA_GRUPS'] = <<<EOF
SELECT codi_grup
FROM grup

ORDER BY nivell_educatiu, codi_grup
EOF;

/**
 * Consulta que només mostra el grups que imparteix l'usuari conectat.
 * @var array
 * @author Ester Almela
 */
$RSRC['NO_COORDINADOR_MOSTRA_GRUPS_IMPARTEIX'] = <<<EOF
SELECT DISTINCT grup.codi_grup
FROM grup NATURAL JOIN classe
WHERE tutor='{$VALS['codi_professor']}'
OR codi_professor ='{$VALS['codi_professor']}'
ORDER BY nivell_educatiu, grup.codi_grup
EOF;

$RSRC['NO_COORDINADOR_MOSTRA_GRUPS_IMPARTEIX_ALL'] = <<<EOF
SELECT DISTINCT grup.codi_grup, grup.nom_grup, grup.nivell_educatiu
FROM grup NATURAL JOIN classe
WHERE tutor='{$VALS['codi_professor']}'
OR codi_professor ='{$VALS['codi_professor']}'
ORDER BY nivell_educatiu, grup.codi_grup
EOF;

/**
 *Consulta que mostra els crèdits quan l'usuari és coordinador.
 *@var array
 *@author Ester Almela
 */
$RSRC['COORDINADOR_MOSTRA_CREDIT'] = <<<EOF
SELECT DISTINCT codi_assignatura, nom_assignatura
FROM classe NATURAL JOIN assignatura
WHERE codi_grup='{$VALS['codi_grup']}'
EOF;

/**
 *Consulta que mostra els crèdits que imparteix quan l'usuari no és coordinador.
 *@var array
 *@author Ester Almela
 */

$RSRC['NO_COORDINADOR_MOSTRA_CREDIT'] = <<<EOF
SELECT DISTINCT codi_assignatura, nom_assignatura
FROM classe NATURAL JOIN assignatura
WHERE codi_grup='{$VALS['codi_grup']}'
AND codi_professor ='{$VALS['codi_professor']}'
EOF;




$RSRC['COMPROVA_PARE_FILL']= <<<EOF

SELECT codi_alumne
FROM alum_pare
WHERE codi_pare='{$VALS['codi_pare']}'

EOF;




/**
 *Comprova si l'usuari loguejat és un pare.
 *@var array
 *@author Ester Almela
 */

$RSRC['ES_PARE'] = <<< EOF

	SELECT *
	FROM pare
	WHERE usuari = '{$VALS['usuari']}' AND password = '{$VALS['contrasenya']}'
	
EOF;

/**
 *Comprova si l'usuari loguejat és un alumne
 *@var array
 *@author Ester Almela
 */

$RSRC['ES_ALUMNE'] = <<< EOF

	SELECT *
	FROM alumne
	WHERE usuari = '{$VALS['usuari']}' AND password = '{$VALS['contrasenya']}'
	
EOF;

/**
 *Comprova si l'alumne té classes assignades
 *@var array
 *@author Ester Almela
 */

$RSRC['COMPROVAR_CLASSE_ASSIGNADA_ALUMNE'] = <<<EOF
SELECT nom_assignatura
FROM assignatura, classe, student_groups
WHERE student_code='{$VALS['codi_alumne']}' 
AND classe.codi_assignatura = assignatura.codi_assignatura
AND classe.codi_grup = student_groups.group_code;

EOF;

/**
 *Contem les faltes justificades
 *@var array
 *@author Ester Almela
 */
$RSRC['COMPROVAR_FILLS'] = <<<EOF

SELECT nom_alumne AS nom, alumne.codi_alumne
FROM alumne, alum_pare
WHERE codi_pare='{$VALS['codi_pare']}'
AND alumne.codi_alumne=alum_pare.codi_alumne

EOF;

$RSRC['SELECCIO_FJ'] = <<<EOF

SELECT COUNT(codi_incidencia) AS RESULTAT
FROM incidencia 
WHERE data_incidencia BETWEEN '{$VALS['data_inicial']}' AND '{$VALS['data_final']}' 
AND codi_alumne = '{$VALS['codi_alumne']}' 
AND motiu_incidencia = 2

EOF;


/**
 *Contem les faltes injustificades
 *@var array
 *@author Ester Almela
 */

$RSRC['SELECCIO_FI'] = <<<EOF
SELECT COUNT(motiu_incidencia) AS RESULTAT
FROM incidencia
WHERE data_incidencia BETWEEN '{$VALS['data_inicial']}' 
AND '{$VALS['data_final']}'
AND motiu_incidencia = 1
AND codi_alumne = '{$VALS['codi_alumne']}'

EOF;

/**
 *Contem els retads
 *@var array
 *@author Ester Almela
 */

$RSRC['SELECCIO_R'] = <<<EOF
SELECT COUNT(motiu_incidencia) AS RESULTAT
FROM incidencia
WHERE data_incidencia BETWEEN '{$VALS['data_inicial']}' 
AND '{$VALS['data_final']}'
AND motiu_incidencia = 3
AND codi_alumne = '{$VALS['codi_alumne']}'

EOF;

/**
 *Contem els retards justificats
 *@var array
 *@author Ester Almela
 */

$RSRC['SELECCIO_RJ'] = <<<EOF
SELECT COUNT(motiu_incidencia) AS RESULTAT
FROM incidencia
WHERE data_incidencia BETWEEN '{$VALS['data_inicial']}' 
AND '{$VALS['data_final']}'
AND motiu_incidencia = 4
AND codi_alumne = '{$VALS['codi_alumne']}'

EOF;

/**
 *Contem les incidències (explusions)
 *@var array
 *@author Ester Almela
 */

$RSRC['SELECCIO_I'] = <<<EOF
SELECT COUNT(motiu_incidencia) AS RESULTAT
FROM incidencia
WHERE data_incidencia BETWEEN '{$VALS['data_inicial']}' 
AND '{$VALS['data_final']}'
AND motiu_incidencia = 5
AND codi_alumne = '{$VALS['codi_alumne']}'

EOF;

$RSRC['SELECCIO_TF'] = <<<EOF

SELECT COUNT(motiu_incidencia) AS RESULTAT
FROM incidencia
WHERE data_incidencia BETWEEN '{$VALS['data_inicial']}' 
AND '{$VALS['data_final']}'
AND codi_alumne = '{$VALS['codi_alumne']}'

EOF;

$RSRC['COMPROVAR_NOM'] = <<<EOF

SELECT NOM_ALUMNE AS NOM
FROM alumne
WHERE codi_alumne = '{$VALS['codi_alumne']}'

EOF;
/**
 * 
 * @var array
 * @see insereix_est.php
 * Consulta de selecció dels alumnes corresponents a l'assignatura per 
 * a l'estat dels alumnes
 * @author Ester Almela 
 */
$RSRC['INSEREIX_EST_1'] = <<<EOF
SELECT codi_alumne , codi_assignatura, estat 
FROM estat_alumne
WHERE codi_alumne = '{$VALS['codi_alumne']}' 
AND codi_assignatura = '{$VALS['codi_assignatura']}';
EOF;

/**
 * 
 * @var array
 * @see insereix_est.php
 * Consulta de inserció de les dades dels alumnes corresponents a l'assignatura per 
 * a l'estat dels alumnes
 * @author Ester Almela 
 */
$RSRC['INSEREIX_EST_2'] = <<<EOF
INSERT INTO estat_alumne (codi_alumne, codi_assignatura, estat) VALUES ('{$VALS['codi_alumne']}',
'{$VALS['codi_assignatura']}', '{$VALS['estat']}');
EOF;

/**
 * 
 * @var array
 * @see insereix_est.php
 * Consulta de actualització dels alumnes corresponents a l'assignatura per 
 * a l'estat dels alumnes
 * @author Ester Almela 
 */
$RSRC['INSEREIX_EST_3'] = <<<EOF

UPDATE estat_alumne SET estat='{$VALS['estat']}' WHERE codi_alumne='{$VALS['codi_alumne']}' AND
codi_assignatura='{$VALS['codi_assignatura']}';
EOF;

/**
 * 
 * @var array
 * @see selecalum.php
 * Consulta que comprova l'estat dels alumnes
 * @author Ester Almela
 */

$RSRC['CONSULTA_ALUMNES'] = <<<EOF

SELECT estat 
FROM estat_alumne 
WHERE codi_alumne='{$VALS['student_code']}';

EOF;

/**
 * 
 * @var array
 * @see insereix_inc.php
 * Actualitzem el camp motiu d'incidencia de la taula incidencia on el
 * codi_incidencia sigui igual a la variable codi_incidencia
 * @author Joan Verge Chillida
 */
$RSRC['INSEREIX_INC_3'] = <<<EOF
UPDATE incidencia		
SET motiu_incidencia = '{$VALS['motiu_incidencia']}'
WHERE codi_incidencia = '{$VALS['codi_incidencia']}'
EOF;

$RSRC['INSEREIX_INC_4'] = <<<EOF
UPDATE incidencia		
SET observacions= '{$VALS['observacions']}'
WHERE codi_incidencia = '{$VALS['codi_incidencia']}'
EOF;
/**
 * consulta SQL que serveix per registrar les faltes d'incidència dels alumnes 
 * @var array
 * @author Miquel Àngel Sebastià
 */
///$student_code, $student_name, $reason, $subject_code,
//$incident_date, $incident_code, $mail_enviat, $sms_enviat
//Mikel
/*
 * Consulta Vella de "consulta_incidencia"
 * 
 * SELECT DISTINCT alumne.codi_alumne, nom_alumne, motiu_incidencia, 
 * classe.codi_assignatura, data_incidencia, codi_incidencia, mail_enviat, sms_enviat, data_neixement
 * FROM classe NATURAL JOIN alumne INNER JOIN student_groups
 * ON (student_groups.student_code=alumne.codi_alumne)
 * LEFT OUTER JOIN
 * (SELECT * FROM incidencia WHERE data_incidencia = '{$VALS['date']}' AND
 * codi_dia='{$VALS['day_code']}' AND codi_hora= '{$VALS['hour_code']}')
 * AS inc_data USING(codi_alumne)
 * WHERE classe.codi_dia = '{$VALS['day_code']}'
 * AND classe.codi_hora = '{$VALS['hour_code']}'
 * AND classe.codi_assignatura = '{$VALS['subject_code']}'
 * AND student_groups.group_code = '{$VALS['group_code']}'
 * AND alumne.data_baixa IS NULL
 * ORDER BY nom_alumne
 */
$RSRC['consulta_incidencia'] = <<<EOF
SELECT DISTINCT incidencia.codi_alumne, incidencia.motiu_incidencia, 
classe.codi_assignatura, incidencia.data_incidencia, 
incidencia.codi_incidencia
FROM classe INNER JOIN (incidencia) 
ON incidencia.codi_assignatura = classe.codi_assignatura
WHERE data_incidencia = '{$VALS['int_data_inc']}'
AND classe.codi_dia = '{$VALS['day_code']}'
AND classe.codi_hora = '{$VALS['hour_code']}'
AND classe.codi_professor = '{$VALS['teacher_code']}'
AND incidencia.codi_dia = '{$VALS['day_code']}'
AND incidencia.codi_hora = '{$VALS['hour_code']}'
AND incidencia.codi_alumne = '{$VALS['student_code']}';
EOF;

$RSRC['consulta_incidencia2'] = <<<EOF
SELECT DISTINCT incidencia.codi_alumne, incidencia.motiu_incidencia, 
classe.codi_assignatura, incidencia.data_incidencia, 
incidencia.codi_incidencia, interval_horari.codi_hora, interval_horari.hora_inici
FROM classe 
INNER JOIN (incidencia) ON incidencia.codi_assignatura = classe.codi_assignatura
INNER JOIN (interval_horari) ON incidencia.codi_hora = interval_horari.codi_hora
WHERE data_incidencia = '{$VALS['int_data_inc']}'
AND incidencia.codi_dia = '{$VALS['day_code']}'
AND incidencia.codi_alumne = '{$VALS['student_code']}'
order by interval_horari.codi_hora;
EOF;

$RSRC['consulta_incidencia3'] = <<<EOF
SELECT DISTINCT incidencia.codi_alumne, incidencia.motiu_incidencia, 
classe.codi_assignatura, incidencia.data_incidencia, 
incidencia.codi_incidencia, interval_horari.codi_hora, interval_horari.hora_inici,descripcio_motius_incidencia.motiu_curt
FROM classe 
INNER JOIN (incidencia) ON incidencia.codi_assignatura = classe.codi_assignatura
INNER JOIN (interval_horari) ON incidencia.codi_hora = interval_horari.codi_hora
INNER JOIN (descripcio_motius_incidencia) ON incidencia.motiu_incidencia = descripcio_motius_incidencia.motiu_incidencia
WHERE data_incidencia = '{$VALS['int_data_inc']}'
AND incidencia.codi_dia = '{$VALS['day_code']}'
order by interval_horari.codi_hora;
EOF;

/**
 * 
 * @var unknown_type
 * @author Amado Domenech Antequera
 * @see selecalum_tutoria.php
 */
/*
 * Consulta vella de CONSULTA_INCIDENCIA_SELECALUM_TUTORIA
 * SELECT DISTINCT incidencia.codi_alumne,
 * incidencia.motiu_incidencia, classe.codi_assignatura,
 * incidencia.data_incidencia, incidencia.codi_incidencia
 * FROM classe NATURAL JOIN incidencia LEFT OUTER JOIN
 * (SELECT * FROM incidencia
 * WHERE data_incidencia = '{$VALS['$int_data_inc']}' AND 
 * codi_dia='{$VALS['$day_code']}' AND codi_hora= '{$VALS['$hour_code']}')
 * AS inc_data USING(codi_alumne)
 * WHERE classe.codi_dia = '{$VALS['$day_code']}'
 * AND classe.codi_hora = '{$VALS['$hour_code']}'
 * AND incidencia.codi_alumne = '{$VALS['$student_code']}'
 * 
 */
/*CONSULTA_VELLA LDAP
 * SELECT DISTINCT incidencia.codi_alumne, incidencia.motiu_incidencia, 
 * classe.codi_assignatura, incidencia.data_incidencia, 
 * incidencia.codi_incidencia
 * FROM classe, incidencia
 * WHERE data_incidencia = '{$VALS['int_data_inc']}'
 * AND classe.codi_dia = '{$VALS['day_code']}'
 * AND classe.codi_hora = '{$VALS['hour_code']}'
 * AND classe.codi_professor = '{$VALS['teacher_code']}'
 * AND incidencia.codi_dia = '{$VALS['day_code']}'
 * AND incidencia.codi_hora = '{$VALS['hour_code']}'
 * AND incidencia.codi_alumne = '{$VALS['student_code']}'
EOF;
 * 
 */
 //la comento xk vull canviar varios parametres de la consulta (josep llaó)
 /*
$RSRC['CONSULTA_INCIDENCIA_SELECALUM_TUTORIA'] = <<<EOF
SELECT DISTINCT incidencia.codi_alumne, incidencia.motiu_incidencia, 
incidencia.codi_assignatura, incidencia.data_incidencia, 
incidencia.codi_incidencia
FROM classe, incidencia
WHERE data_incidencia = '{$VALS['int_data_inc']}'
AND incidencia.codi_dia = '{$VALS['day_code']}'
AND incidencia.codi_hora = '{$VALS['hour_code']}'
AND incidencia.codi_alumne = '{$VALS['student_code']}'
EOF;*/

$RSRC['CONSULTA_INCIDENCIA_SELECALUM_TUTORIA'] = <<<EOF
SELECT DISTINCT incidencia.codi_alumne, incidencia.motiu_incidencia, 
incidencia.codi_assignatura, incidencia.data_incidencia, 
incidencia.codi_incidencia, incidencia.observacions, descripcio_motius_incidencia.motiu_curt, hora_inici
FROM classe, incidencia 
inner join (descripcio_motius_incidencia) ON descripcio_motius_incidencia.motiu_incidencia = incidencia.motiu_incidencia 
inner join (interval_horari) ON interval_horari.codi_hora=incidencia.codi_hora
WHERE data_incidencia = '{$VALS['int_data_inc']}'
AND incidencia.codi_dia = '{$VALS['day_code']}'
AND incidencia.codi_hora = '{$VALS['hour_code']}'
AND incidencia.codi_alumne = '{$VALS['student_code']}'
EOF;


$RSRC['CONSULTA_ASSIGNATURA_ALUMNE_SENSE_INC'] = <<<EOF
SELECT DISTINCT classe.codi_assignatura
FROM classe
WHERE codi_dia = '{$VALS['day_code']}'
AND codi_hora = '{$VALS['hour_code']}'
AND codi_grup = '{$VALS['codi_grup']}'
AND codi_professor = '{$VALS['teacher_code']}'
EOF;
/**
 * 
 * @var unknown_type
 * @author Amado Domenech Antequera
 * @see selecalum_tutoria.php
 */
$RSRC['CONSULTA_HORAI_HORAF'] = <<<EOF
select hora_inici, hora_final
FROM interval_horari
WHERE codi_hora = '{$VALS['hour_code']}'
EOF;
/**
 * 
 * @var unknown_type
 * @author Amado Domenech Antequera
 * @see selecalum_tutoria.php
 */
$RSRC['CONSULTA_HORAI_HORAF_DUN_GRUP'] = <<<EOF
SELECT MIN(codi_hora) AS min, MAX(codi_hora) AS max
FROM classe
WHERE codi_dia = '{$VALS['day_code']}'
AND codi_grup = '{$VALS['group_code']}'
EOF;

/**
 * 
 * @var unknown_type
 * @author Josep Llaó Angelats
 * @see selecalum.php
 */
$RSRC['CONSULTA_ALUMNES_PER_GRUP'] = <<<EOF
SELECT *
FROM grup_alumnes
WHERE codi_assignatura = '{$VALS['codi_assignatura']}'
EOF;



/**
 * 
 * @var unknown_type
 * @author Josep Llaó Angelats
 * @see selecalum.php
 */
 
$RSRC['CONSULTA_INCIDENCIES_ANT'] = <<<EOF
SELECT codi_alumne, motiu_curt, hora_inici, incidencia.motiu_incidencia, observacions
FROM incidencia  inner join (interval_horari) ON interval_horari.codi_hora=incidencia.codi_hora 
inner join (descripcio_motius_incidencia) ON descripcio_motius_incidencia.motiu_incidencia = incidencia.motiu_incidencia  
WHERE data_incidencia = '{$VALS['data']}' group by codi_alumne,  interval_horari.codi_hora

EOF;


/**
 * 
 * @var unknown_type
 * @author Josep Llaó Angelats
 */
 
$RSRC['CONSULTA_ASSIGNATURES'] = <<<EOF
SELECT *
FROM assignatura
WHERE optativa = 0
EOF;

/**
 * 
 * @var unknown_type
 * @author Josep Llaó Angelats
 * @see addldap.php
 */
 
$RSRC['CONSULTA_OPTATIVES'] = <<<EOF
SELECT *
FROM assignatura
WHERE optativa = 1 
EOF;

$RSRC['CONSULTA_ASS_OPT'] = <<<EOF
SELECT *
FROM assignatura
WHERE codi_assignatura='{$VALS['valAP']}' 
EOF;


/**
 * 
 * consultar grup
 * @author Josep Llaó Angelats
 */
 
$RSRC['CONSULTA_GRUPS'] = <<<EOF
SELECT codi_grup, nom_grup
FROM grup
EOF;

/**
 * 
 * consultar assignatura
 * @author Josep Llaó Angelats
 */
 
$RSRC['CONSULTA_ASSIGNATURA'] = <<<EOF
SELECT codi_assignatura, nom_assignatura
FROM assignatura
EOF;

/**
 * 
 * consultar dia
 * @author Josep Llaó Angelats
 */
 
$RSRC['CONSULTA_DIA'] = <<<EOF
SELECT codi_dia, dia_llarg
FROM dia_setmana
EOF;

/**
 * 
 * consultar hora
 * @author Josep Llaó Angelats
 */
 
$RSRC['CONSULTA_HORA'] = <<<EOF
SELECT *
FROM interval_horari
EOF;

/**
 * 
 * consultar hora
 * @author Josep Llaó Angelats
 */
 
$RSRC['CONSULTA_LLICO'] = <<<EOF
SELECT codi_llico
FROM classe
EOF;

/**
 * 
 * @author Josep Llaó Angelats
 * afegir una nova classe
 */
 
$RSRC['ADD_CLASSE'] = <<<EOF
INSERT INTO classe(codi_llico, codi_grup, codi_professor, codi_assignatura, codi_aula, codi_dia, codi_hora) value ('{$VALS['codi_llico']}','{$VALS['codi_grup']}','{$VALS['codi_professor']}','{$VALS['codi_assignatura']}','{$VALS['codi_aula']}','{$VALS['codi_dia']}','{$VALS['codi_hora']}')
EOF;

/**
 * 
 * @author Josep Llaó Angelats
 * modificar classe
 */
 
$RSRC['MODIFICAR_CLASSE'] = <<<EOF
UPDATE classe 
SET 
codi_llico='{$VALS['codi_llico']}', 
codi_grup='{$VALS['codi_grup']}', 
codi_professor='{$VALS['codi_professor']}', 
codi_assignatura='{$VALS['codi_assignatura']}', 
codi_aula='{$VALS['codi_aula']}', 
codi_dia='{$VALS['codi_dia']}', 
codi_hora='{$VALS['codi_hora']}'

WHERE 
codi_llico='{$VALS['codi_llicoHI']}' AND
codi_grup='{$VALS['codi_grupHI']}' AND
codi_professor='{$VALS['codi_professorHI']}' AND 
codi_assignatura='{$VALS['codi_assignaturaHI']}' AND 
codi_aula='{$VALS['codi_aulaHI']}' AND
codi_dia='{$VALS['codi_diaHI']}' AND
codi_hora='{$VALS['codi_horaHI']}'

EOF;

/**
 * 
 * @author Josep Llaó Angelats
 * eliminar classe
 */
 
$RSRC['ELIMINAR_CLASSE'] = <<<EOF
DELETE from classe 
WHERE 
codi_llico='{$VALS['codi_llico']}' AND
codi_grup='{$VALS['codi_grup']}' AND
codi_professor='{$VALS['codi_professor']}' AND 
codi_assignatura='{$VALS['codi_assignatura']}' AND 
codi_aula='{$VALS['codi_aula']}' AND
codi_dia='{$VALS['codi_dia']}' AND
codi_hora='{$VALS['codi_hora']}'

EOF;
/**
 * 
 * @author Josep Llaó Angelats
 * afegir una nova classe
 */
 
$RSRC['LLISTAR_CLASSE'] = <<<EOF

SELECT * FROM classe WHERE  codi_grup LIKE '{$VALS['codi_grup']}' AND codi_professor LIKE '{$VALS['codi_professor']}' ANd codi_assignatura LIKE '{$VALS['codi_assignatura']}'
EOF;

/**
 * 
 * @author Josep Llaó Angelats
 * @see addldap.php
 */
 
$RSRC['CONSULTA_IMPORT'] = <<<EOF
SELECT *
FROM import_alumnes 
EOF;






/**
 * Aquesta consulta ens mostra la tutoria i el grup
 * @var array
 * @author Carlos Cristoful Rodriguez
 * @see: funcions.php
 */
$RSRC['consulta_tutoria'] = <<<EOF
SELECT etapa, nivell, grup 
FROM tutories ";
WHERE trim(codi) = trim'{$VALS['codi_assignatura']}' 
AND curs_acad = '{$VALS['any']}';
EOF;

/**
 * Aquesta consulta ens mostra el nom i cognom del professor segons el seu codi 
 * @var array
 * @author Carlos Cristoful Rodriguez
 * @see: funcions.php
 */
$RSRC['nom_profe'] = <<<EOF
	SELECT nom_professor, cognom1_professor 
	FROM professor
	WHERE trim(codi_professor) = '{$VALS['codi_prof']}'
EOF;

$RSRC['nom_pare'] = <<<EOF
	SELECT nom_pare 
	FROM pare
	WHERE trim(codi_pare) = '{$VALS['codi_pare']}'
EOF;

$RSRC['nom_alumne'] = <<<EOF
	SELECT nom_alumne 
	FROM alumne
	WHERE trim(codi_alumne) = '{$VALS['codi_alumne']}'
EOF;

/**
 * Aquesta consulta ens mostra els estudis segons la matricula i l'any
 * @var array
 * @author Carlos Cristoful Rodriguez
 * @see: funcions.php
 */
$RSRC['estudis'] = <<<EOF
	SELECT etapa, nivell, grupclasse FROM alumany
	WHERE trim(matricula) = '{$VALS['matricula']}' AND curs_acad ='{$VALS['any']}'
EOF;

/**
 * Aquesta consulta ens mostra l'hora final
 * @var array
 * @author Carlos Cristoful Rodriguez
 * @see: funcions.php
 */
$RSRC['hora_final'] = <<<EOF
SELECT hora_final
FROM interval_horari
WHERE codi_hora = '{$VALS['hora']}';
EOF;

/**
 * 
 * @var array
 * @see funcions.php
 * 
 * @author Joan Verge Chillida
 */
$RSRC['funcions.php_1'] = <<<EOF
INSERT INTO student_groups
(student_code,group_code) VALUES('{$VALS['student_code']}','{$VALS['group_code']}')
EOF;

/**
 * 
 * @var array
 * @see funcions.php
 * 
 * @author Joan Verge Chillida
 */
$RSRC['funcions.php_2'] = <<<EOF
DELETE FROM student_groups
WHERE student_code='{$VALS['student_code']}'
AND group_code='{$VALS['group_code']}'
EOF;

/**
 * 
 * @var array
 * @see funcions.php
 * 
 * @author Joan Verge Chillida
 */
$RSRC['funcions.php_3'] = <<<EOF
SELECT codi_grup
FROM grup
WHERE codi_grup = '{$VALS['group_code']}'
EOF;

/**
 * 
 * @var array
 * @see funcions.php
 * 
 * @author Joan Verge Chillida
 */
$RSRC['funcions.php_4'] = <<<EOF
SELECT codi_alumne
FROM alumne
WHERE codi_alumne = '{$VALS['student_code']}'
EOF;

/**
 * 
 * @var array
 * @see funcions.php
 * 
 * @author Joan Verge Chillida
 */
$RSRC['funcions.php_5'] = <<<EOF
SELECT hora_inici
FROM interval_horari
WHERE codi_hora = '{$VALS['hora']}'
EOF;



///////////////////////////////////////////////////////////////////////////////////////////////
//MODUL D'ENVIAMENT DE CORREUS I SMS----------------BY J.RAMIREZ ------------------------------


//CONSULTA SMS I MAILS MASSIUS
$RSRC['send_mail_num_incidencies'] = <<<EOF
SELECT codi_incidencia, pare.codi_pare, motiu_incidencia, vol_email, telefon_mobil, vol_sms, pare.codi_pare, pare.email, nom_alumne, incidencia.codi_alumne, count(incidencia.codi_alumne), data_incidencia
FROM incidencia, alumne, alum_pare, pare
WHERE data_incidencia = current_date( )
AND incidencia.codi_alumne = alumne.codi_alumne
AND incidencia.codi_alumne = alum_pare.codi_alumne
AND alum_pare.codi_pare = pare.codi_pare
GROUP BY data_incidencia, codi_alumne, pare.codi_pare, motiu_incidencia
EOF;


//PER SABER EL CODI_INCIDENCIA A MANUAL
$RSRC['obtenir_codi_incidencia'] = <<<EOF
SELECT codi_incidencia
FROM incidencia
WHERE codi_hora = '{$VALS['codi_hora']}'
AND codi_alumne = {$VALS['codi_alumne']}
AND codi_dia = '{$VALS['codi_dia']}'
AND data_incidencia = '{$VALS['data_incidencia']}'
AND codi_assignatura = '{$VALS['codi_assignatura']}'
EOF;


//CONSULTA PER ADQUERIR UN HISTORIC DE CORREUS
$RSRC['incidencies_correus'] = <<<EOF
SELECT *
FROM incidencia
WHERE data_incidencia > '{$VALS['data_inicial']}'
AND data_incidencia < '{$VALS['data_final']}'
AND mail_enviat = 0
EOF;

//CONSULTES SMS I MAILS MANUALS(EL QUE S'ENVIEN D'INMEDIAT al passar llista)
$RSRC['send_num_incidencies_manual'] = <<<EOF
SELECT codi_incidencia, hora_inici, hora_final, motiu_incidencia, vol_email, pare.telefon_mobil, vol_sms, pare.codi_pare, pare.email, nom_alumne, incidencia.codi_alumne, data_incidencia
FROM incidencia, alumne, alum_pare, pare, interval_horari
WHERE alumne.codi_alumne = {$VALS['codi_alumne']}
AND codi_incidencia = {$VALS['codi_incidencia']}
AND alumne.codi_alumne = alum_pare.codi_alumne
AND alum_pare.codi_pare = pare.codi_pare
AND interval_horari.codi_hora = incidencia.codi_hora
EOF;

//UPDATES QUE ENS MODIFIQUEN EL CAMP MAIL/SMS ENVIAT A 1 (QUAN UN SMS/CORREU JA HA ESTAT NOTIFICAT)
$RSRC['incidencia_mail_realitzada'] = <<<EOF
UPDATE webfaltes.incidencia SET incidencia.mail_enviat = 1 WHERE incidencia.codi_incidencia = {$VALS['codi_incidencia']}
EOF;

$RSRC['incidencia_sms_realitzada'] = <<<EOF
UPDATE webfaltes.incidencia SET incidencia.sms_enviat = 1 WHERE incidencia.codi_incidencia = {$VALS['codi_incidencia']}
EOF;

$RSRC['incidencia_multisms_realitzada'] = <<<EOF
UPDATE webfaltes.incidencia SET incidencia.sms_enviat = 1 WHERE incidencia.codi_alumne = {$VALS['codi_alumne']}
AND incidencia.data_incidencia = {$VALS['data']}
EOF;

//CONSULTA QUE ENS DIU EL NUM DE INCIDENCIES NOTIFICADES
$RSRC['comprovacio_enviament_mail'] = <<<EOF
SELECT codi_alumne, count( codi_alumne )
FROM incidencia
WHERE data_incidencia = current_date( )
AND mail_enviat =1
AND codi_alumne= {$VALS['codi_alumne']}
GROUP BY codi_alumne
EOF;

//CONSULTA QUE ENS DIU EL NUM DE INCIDENCIES NOTIFICADES
$RSRC['comprovacio_enviament_multisms'] = <<<EOF
SELECT codi_alumne, count( codi_alumne )
FROM incidencia
WHERE data_incidencia = current_date( )
AND sms_enviat =1
AND codi_alumne= {$VALS['codi_alumne']}
GROUP BY codi_alumne
EOF;

//CONSULTES QUE ENS MOSTREN L'ESTAT DE LA INCIDENCIA, SI S'HA ENVIAT EL MAIL I/O EL SMS
$RSRC['comprovacio_enviat_manual'] = <<<EOF
SELECT codi_incidencia, codi_alumne, mail_enviat, sms_enviat
FROM incidencia
WHERE codi_incidencia = {$VALS['codi_incidencia']}
EOF;

$RSRC['comprovacio_enviament_sms'] = <<<EOF
SELECT COUNT (codi_alumne)
FROM incidencia
WHERE data_incidencia = current_date( ) and sms_enviat = 1
EOF;

$RSRC['num_pares_vol_notificacio'] = <<<EOF
SELECT codi_alumne, count( pare.codi_pare )
FROM pare, alum_pare
WHERE pare.codi_pare = alum_pare.codi_pare
AND (vol_email =1 OR vol_sms =1)
AND codi_alumne = {$VALS['codi_alumne']}
GROUP BY codi_alumne
EOF;


///////////////////////////////////////////////////////////////////////////////
//ESTADISTIQUES


//Select_fill -  Falta arreglar el selec codi_pare
$RSRC['Select_fill'] = <<<EOF
SELECT alumne.codi_alumne, alumne.nom_alumne
FROM alumne, pare, alum_pare
WHERE alum_pare.codi_alumne = alumne.codi_alumne
AND alum_pare.codi_pare = pare.codi_pare
AND pare.codi_pare =1
EOF;

//numero de professors
$RSRC['total_professors'] = <<<EOF
SELECT COUNT(codi_professor) AS total
FROM professor
EOF;

//numero de alumnes
$RSRC['total_alumnes'] = <<<EOF
SELECT COUNT(codi_alumne) AS total
FROM alumne
EOF;


//numero de alumnes de baixa
$RSRC['alumnes_actius'] = <<<EOF
SELECT COUNT(codi_alumne) AS total
FROM alumne
WHERE data_baixa is NULL
EOF;

//numero de alumnes actius
$RSRC['alumnes_de_baixa'] = <<<EOF
SELECT COUNT(codi_alumne) AS total
FROM alumne
WHERE data_baixa is NOT NULL
EOF;

//alumnes de tortosa

$RSRC['alumnes_de_tortosa'] = <<<EOF
SELECT COUNT(codi_alumne) AS total
FROM alumne
WHERE ciutat = "Tortosa" OR ciutat = "tortosa"
EOF;

//alumnes que no son de tortosa

$RSRC['alumnes_de_no_tortosa'] = <<<EOF
SELECT COUNT(codi_alumne) AS total
FROM alumne
WHERE ciutat != "Tortosa" AND ciutat != "tortosa"
EOF;

//total de pares
$RSRC['total_pares'] = <<<EOF
SELECT COUNT(codi_pare) AS total
FROM pare
EOF;

//alumnes majors de edat
$RSRC['alumnes_majors'] = <<<EOF
SELECT COUNT(codi_alumne) AS total
FROM alumne
WHERE (YEAR(CURDATE())-YEAR(data_neixement)) - (RIGHT(CURDATE(),5)<RIGHT(data_neixement,5)) > 18
EOF;

//alumnes no majors de edat
$RSRC['alumnes_menors'] = <<<EOF
SELECT COUNT(codi_alumne) AS total
FROM alumne
WHERE (YEAR(CURDATE())-YEAR(data_neixement)) - (RIGHT(CURDATE(),5)<RIGHT(data_neixement,5)) < 18
EOF;

//numero de grups
$RSRC['total_grups'] = <<<EOF
SELECT COUNT(codi_grup) AS total
FROM grup
WHERE tutor is NOT NULL
EOF;

//mitjana de alumnes per grup
$RSRC['total_grups'] = <<<EOF
SELECT COUNT(codi_grup) AS total
FROM grup
WHERE tutor is NOT NULL
EOF;

//Pares qeu volen SMS i pares que no en volen
$RSRC['vol_sms'] = <<<EOF
SELECT COUNT(codi_pare) AS total
FROM pare
WHERE vol_sms = 0 
EOF;

$RSRC['no_vol_sms'] = <<<EOF
SELECT COUNT(codi_pare) AS total
FROM pare
WHERE vol_sms = 1 
EOF;

//Pares que volen correu pares que si que en volen
$RSRC['vol_correu'] = <<<EOF
SELECT COUNT(codi_pare) AS total
FROM pare
WHERE vol_email = 0 
EOF;

$RSRC['no_vol_correu'] = <<<EOF
SELECT COUNT(codi_pare) AS total
FROM pare
WHERE vol_email = 1 
EOF;


//numero tutors
$RSRC['total_tutors'] = <<<EOF
SELECT DISTINCT COUNT(tutor) AS total
FROM grup
WHERE tutor is NOT NULL
EOF;

//Professors per departament
$RSRC['total_tutors'] = <<<EOF
SELECT DISTINCT COUNT(tutor) AS total
FROM grup
WHERE tutor is NOT NULL
EOF;


//ESTADISTIQUES PARES 

$RSRC['total_pares'] = <<<EOF
SELECT COUNT(codi_pare) AS total
FROM pare
EOF;


//faltes

$RSRC['total_faltes'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =1)
AND (codi_alumne ='{$VALS['codi_alumne']}')
EOF;

$RSRC['faltes_per_horari'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE motiu_incidencia =1
AND codi_alumne ='{$VALS['codi_alumne']}'
AND codi_hora ='{$VALS['codi_hora']}'
EOF;

$RSRC['faltes_per_diaset'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE ( motiu_incidencia = 1 )
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND (codi_dia ='{$VALS['codi_dia']}')
EOF;

//faltes just

$RSRC['total_faltes_just'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =2)
AND (codi_alumne ='{$VALS['codi_alumne']}')
EOF;

$RSRC['faltes_just_per_horari'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =2)
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND (codi_hora ='{$VALS['codi_hora']}')
EOF;

$RSRC['faltes_just_per_diaset'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE ( motiu_incidencia = 2 )
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND ( codi_dia ='{$VALS['codi_dia']}')
EOF;

//retards

$RSRC['total_retard'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =3)
AND (codi_alumne ='{$VALS['codi_alumne']}')
EOF;

$RSRC['retard_per_horari'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =3)
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND (codi_hora ='{$VALS['codi_hora']}')
EOF;

$RSRC['retard_per_diaset'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE ( motiu_incidencia = 3 )
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND ( codi_dia ='{$VALS['codi_dia']}')
EOF;

//retards JUSTIFICATS

$RSRC['total_retard_just'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =4)
AND (codi_alumne ='{$VALS['codi_alumne']}')
EOF;

$RSRC['retard_just_per_horari'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =4)
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND (codi_hora ='{$VALS['codi_hora']}')
EOF;

$RSRC['retard_just_per_diaset'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE ( motiu_incidencia = 4 )
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND ( codi_dia ='{$VALS['codi_dia']}')
EOF;

//Expulsions

$RSRC['total_expulsio'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =5)
AND (codi_alumne ='{$VALS['codi_alumne']}')
EOF;

$RSRC['expulsio_per_horari'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE (motiu_incidencia =5)
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND (codi_hora ='{$VALS['codi_hora']}')
EOF;

$RSRC['expulsio_per_diaset'] = <<<EOF
SELECT COUNT( codi_incidencia ) AS total
FROM incidencia
WHERE ( motiu_incidencia = 5 )
AND (codi_alumne ='{$VALS['codi_alumne']}')
AND ( codi_dia ='{$VALS['codi_dia']}')
EOF;


//Professors

$RSRC['selec_groups_professor'] = <<<EOF
SELECT DISTINCT codi_grup
FROM classe
WHERE codi_professor ='{$VALS['codi_professor']}'
EOF;


$RSRC['Alumnes_per_grup']  = <<<EOF
SELECT COUNT( codi_alumne ) AS total
FROM alumne
INNER JOIN student_groups ON ( alumne.codi_alumne = student_groups.student_code )
WHERE student_groups.group_code ='{$VALS['codi_grup']}'
AND data_baixa IS NULL
ORDER BY nom_alumne
EOF;

$RSRC['Faltes_per_grup'] = <<<EOF
SELECT COUNT(codi_incidencia) AS total
FROM incidencia
WHERE motiu_incidencia =1
AND codi_professor = '{$VALS['codi_professor']}'
AND codi_alumne IN (SELECT codi_alumne
					FROM alumne
					INNER JOIN student_groups ON ( alumne.codi_alumne = student_groups.student_code )
					WHERE student_groups.group_code ='{$VALS['codi_grup']}'
					AND data_baixa IS NULL
					ORDER BY nom_alumne )
EOF;

$RSRC['Retards_per_grup']  = <<<EOF
SELECT COUNT(codi_incidencia) AS total
FROM incidencia
WHERE motiu_incidencia =3
AND codi_professor = '{$VALS['codi_professor']}'
AND codi_alumne IN (SELECT codi_alumne
					FROM alumne
					INNER JOIN student_groups ON ( alumne.codi_alumne = student_groups.student_code )
					WHERE student_groups.group_code = '{$VALS['codi_grup']}'
					AND data_baixa IS NULL
					ORDER BY nom_alumne )
EOF;

$RSRC['Expulsio_per_grup']  = <<<EOF
SELECT COUNT(codi_incidencia) AS total
FROM incidencia
WHERE motiu_incidencia =5
AND codi_professor = '{$VALS['codi_professor']}'
AND codi_alumne IN (SELECT codi_alumne
					FROM alumne
					INNER JOIN student_groups ON ( alumne.codi_alumne = student_groups.student_code )
					WHERE student_groups.group_code = '{$VALS['codi_grup']}'
					AND data_baixa IS NULL
					ORDER BY nom_alumne )
EOF;

/* Pau Gomez Cortes
 * ----------------
 * Modul d'enquestes
 * 
 */

$RSRC['SURVEYS_MOSTRA_ENQ'] = <<<EOF
SELECT *
FROM enquesta
WHERE enq_codi = {$VALS['enq_codi']}
EOF;

$RSRC['SURVEYS_MOSTRA_ENQ_COOR'] = <<<EOF
SELECT *
FROM enquesta
EOF;

$RSRC['SURVEYS_MOSTRA_ENQ_GRUP'] = <<<EOF
SELECT *
FROM enquesta
WHERE enq_destinatari = {$VALS['destinatari']}
EOF;

$RSRC['SURVEYS_MOSTRA_ENQ_PROF_NOUS'] = <<<EOF
SELECT *
FROM enquesta
WHERE enq_destinatari = 1 OR enq_destinatari = 5
EOF;

$RSRC['SURVEYS_INSERT_NOVA_ENQ'] = <<<EOF
INSERT INTO enquesta (enq_codi, enq_id, enq_data_ini, enq_data_fi, enq_destinatari)
VALUES('','{$VALS['id_enquesta']}','{$VALS['data_inici']}','{$VALS['data_fi']}',{$VALS['enq_destinatari']})
EOF;

$RSRC['SURVEYS_MOSTRAR_DADES_ENQ'] = <<<EOF
SELECT *
FROM enquesta
WHERE enq_codi = '{$VALS['enq_codi']}'
EOF;

$RSRC['SURVEYS_GET_MAX_CODI'] = <<<EOF
SELECT max(enq_codi) as max
FROM enquesta
EOF;

$RSRC['SURVEYS_MOSTRAR_PREGUNTES'] = <<<EOF
SELECT *
FROM pregunta
WHERE pre_enq_codi = '{$VALS['enq_codi']}'
LIMIT 4 , {$VALS['cont']}
EOF;

$RSRC['SURVEYS_INSERT_NOVA_PRE'] = <<<EOF
INSERT INTO pregunta (pre_codi, pre_enq_codi, pre_text)
VALUES('','{$VALS['enq_codi']}','{$VALS['pre_text']}')
EOF;

$RSRC['SURVEYS_BORRAR_ENQ'] = <<<EOF
DELETE FROM enquesta
WHERE enq_codi = {$VALS['enq_codi']}
EOF;

$RSRC['SURVEYS_BORRAR_PRE'] = <<<EOF
DELETE FROM pregunta
WHERE pre_codi = {$VALS['pre_codi']}
EOF;

$RSRC['SURVEYS_MOSTRAR_ENQ'] = <<<EOF
SELECT *
FROM enquesta
WHERE enq_codi = {$VALS['enq_codi']}
EOF;

$RSRC['SURVEYS_MOD_PRE'] = <<<EOF
UPDATE pregunta		
SET pre_text = '{$VALS['pre_text']}'	
WHERE pre_codi = '{$VALS['pre_codi']}'
EOF;

$RSRC['SURVEYS_BORRAR_PRE_ENQ'] = <<<EOF
DELETE FROM pregunta
WHERE pre_enq_codi = {$VALS['enq_codi']}
EOF;

$RSRC['SURVEYS_MOD_ENQ'] = <<<EOF
UPDATE enquesta		
SET enq_id = '{$VALS['id_enquesta']}',
enq_data_ini = '{$VALS['enq_data_ini']}',
enq_data_fi = '{$VALS['enq_data_fi']}',
enq_destinatari = '{$VALS['enq_destinatari']}'	
WHERE enq_codi = {$VALS['enq_codi']}
EOF;

$RSRC['SURVEYS_INSERT_SAT'] = <<<EOF
INSERT INTO pregunta (pre_codi, pre_enq_codi, pre_text)
VALUES('','{$VALS['enq_codi']}','sat');
EOF;

$RSRC['SURVEYS_INSERT_COM'] = <<<EOF
INSERT INTO pregunta (pre_codi, pre_enq_codi, pre_text)
VALUES('','{$VALS['enq_codi']}','com');
EOF;

$RSRC['SURVEYS_INSERT_BO'] = <<<EOF
INSERT INTO pregunta (pre_codi, pre_enq_codi, pre_text)
VALUES('','{$VALS['enq_codi']}','bo');
EOF;

$RSRC['SURVEYS_INSERT_MIL'] = <<<EOF
INSERT INTO pregunta (pre_codi, pre_enq_codi, pre_text)
VALUES('','{$VALS['enq_codi']}','mil');
EOF;

$RSRC['SURVEYS_COUNT_PREGUNTES'] = <<<EOF
SELECT COUNT(pre_enq_codi) as cont
FROM pregunta
WHERE pre_enq_codi = '{$VALS['enq_codi']}'
GROUP BY pre_enq_codi
EOF;

$RSRC['SURVEYS_GET_CURS_ALUMNE'] = <<<EOF
SELECT group_code
FROM student_groups
WHERE student_code = {$VALS['usuari']}
EOF;

$RSRC['SURVEYS_GET_PRE_SAT'] = <<<EOF
SELECT pre_codi
FROM pregunta
WHERE pre_enq_codi = {$VALS['enq_codi']}
LIMIT 0 , 1
EOF;

$RSRC['SURVEYS_INSERT_R_SATISFACCIO'] = <<<EOF
INSERT INTO resultat (res_codi_pers, res_codi_enq, res_codi_pre, res_curs_alumne, res_valor)
VALUES({$VALS['usuari']},{$VALS['enq_codi']}, {$VALS['pre_codi']}, '{$VALS['curs_alumne']}', {$VALS['res_satisfaccio']})
EOF;

$RSRC['SURVEYS_INSERT_R_OBSERVACIONS'] = <<<EOF
INSERT INTO resultat (res_codi_pers, res_codi_enq, res_codi_pre, res_curs_alumne, res_comentari)
VALUES({$VALS['usuari']},{$VALS['enq_codi']}, {$VALS['pre_codi']}, '{$VALS['curs_alumne']}', '{$VALS['res_observacions']}')
EOF;

$RSRC['SURVEYS_INSERT_R_ASPECTES'] = <<<EOF
INSERT INTO resultat (res_codi_pers, res_codi_enq, res_codi_pre, res_curs_alumne, res_comentari)
VALUES({$VALS['usuari']},{$VALS['enq_codi']}, {$VALS['pre_codi']}, '{$VALS['curs_alumne']}', '{$VALS['res_bones']}')
EOF;

$RSRC['SURVEYS_INSERT_R_MILLORES'] = <<<EOF
INSERT INTO resultat (res_codi_pers, res_codi_enq, res_codi_pre, res_curs_alumne, res_comentari)
VALUES({$VALS['usuari']},{$VALS['enq_codi']}, {$VALS['pre_codi']}, '{$VALS['curs_alumne']}', '{$VALS['res_millores']}')
EOF;

$RSRC['SURVEYS_INSERT_VALOR'] = <<<EOF
INSERT INTO resultat (res_codi_pers, res_codi_enq, res_codi_pre, res_curs_alumne, res_valor)
VALUES({$VALS['usuari']},{$VALS['enq_codi']}, {$VALS['pre_codi']}, '{$VALS['curs_alumne']}', {$VALS['valor']})
EOF;

$RSRC['SURVEYS_N_PERS'] = <<<EOF
SELECT COUNT(res_codi_pers) as pers
FROM resultat
WHERE res_codi_pre = {$VALS['pre_codi']} AND res_valor <> 0
EOF;

$RSRC['SURVEYS_N_PERS_R'] = <<<EOF
SELECT COUNT(res_codi_pers) as pers
FROM resultat
WHERE res_codi_pre = {$VALS['pre_codi']} AND res_valor = {$VALS['x']}
EOF;

/*
 * Les següents 3 consultes, mostren els comentaris de observacions,
 * 	aspectes positius i coses a millorar respectivament.
 * De moment les preguntes referents a aquests camps estan introduides amb el
 * 	text 'com', 'bo', 'mil' per a diferenciar-les de les altres.
 * Aquestes consultes s'haurien de modificar per a buscar aquests comentaris
 * 	sense tenir en compte aquest nom orientatiu, ja que si algu introdueix 
 * 	una pregunta amb algun d'aquests noms (improvable), provocaria un error
 *  a l'hora de consultar aquests comentaris.
 */

$RSRC['SURVEYS_MOSTRAR_COMMENTS'] = <<<EOF
SELECT res_comentari
FROM resultat, pregunta
WHERE resultat.res_codi_pre = pregunta.pre_codi 
AND resultat.res_codi_enq = {$VALS['enq_codi']}
AND pregunta.pre_text = 'com';
EOF;

$RSRC['SURVEYS_MOSTRAR_ASPECTS'] = <<<EOF
SELECT res_comentari
FROM resultat, pregunta
WHERE resultat.res_codi_pre = pregunta.pre_codi 
AND resultat.res_codi_enq = {$VALS['enq_codi']}
AND pregunta.pre_text = 'bo';
EOF;

$RSRC['SURVEYS_MOSTRAR_IMPROVES'] = <<<EOF
SELECT res_comentari
FROM resultat, pregunta
WHERE resultat.res_codi_pre = pregunta.pre_codi 
AND resultat.res_codi_enq = {$VALS['enq_codi']}
AND pregunta.pre_text = 'mil';
EOF;

/*
 * ---------------------------------------------------
 */

$RSRC['SURVEYS_HA_CONTESTAT'] = <<<EOF
SELECT res_codi_pers, res_codi_enq 
FROM resultat
WHERE res_codi_pers = {$VALS['usuari']} AND res_codi_enq = {$VALS['enq_codi']}
EOF;

$RSRC['SURVEYS_MOSTRAR_DATES'] = <<<EOF
SELECT enq_data_ini, enq_data_fi
FROM enquesta
WHERE enq_codi = {$VALS['enq_codi']}
EOF;

/**
 * Per cada alumne que té faltes injustificades les mostrem
 * @see informe_resum_grup_faltes_2.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
/*
 * Consulta vella informe_resum_faltes_mes_2
 * 	SELECT DISTINCT nom_alumne, incidencia.codi_alumne, COUNT(incidencia.motiu_incidencia) AS falta
 * FROM alumne, incidencia, descripcio_motius_incidencia, student_groups
 * WHERE alumne.codi_alumne = incidencia.codi_alumne
 * AND incidencia.motiu_incidencia = descripcio_motius_incidencia.motiu_incidencia
 * AND descripcio_motius_incidencia.motiu_incidencia = '1' 
 * AND alumne.codi_alumne = student_groups.student_code
 * AND group_code ='{$VALS['codi_grup']}'
 * AND data_incidencia BETWEEN '{$VALS['str_data_inicial']}' AND '{$VALS['str_data_final']}'
 * GROUP BY nom_alumne;
 */
$RSRC['informe_resum_faltes_mes_2'] = <<<EOF
	SELECT DISTINCT incidencia.codi_alumne, COUNT(incidencia.motiu_incidencia) AS falta
	FROM incidencia, descripcio_motius_incidencia
	WHERE incidencia.motiu_incidencia = descripcio_motius_incidencia.motiu_incidencia
	AND descripcio_motius_incidencia.motiu_incidencia = '1' 
	AND incidencia.codi_alumne IN ({$VALS['codi_alumne']})
	AND data_incidencia BETWEEN '{$VALS['str_data_inicial']}' AND '{$VALS['str_data_final']}'
	GROUP BY codi_alumne;
EOF;

/**
 * Per cada alumne que té faltes injustificades les mostrem
 * @see informe_resum_grup_faltes_pdf.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['selec_nom_tutor'] = <<<EOD
	SELECT nom_professor, cognom1_professor, cognom2_professor
	FROM grup, professor
	WHERE tutor = codi_professor 
		AND codi_grup='{$VALS['codi_grup']}';
EOD;

$RSRC['selec_grup_tutor'] = <<<EOF
	SELECT nom_grup, tutor
	FROM grup
	WHERE codi_grup='{$VALS['codi_grup']}';
EOF;
$RSRC['selec_tutor_grup'] = <<<EOF
	SELECT tutor
	FROM grup
	WHERE codi_grup='{$VALS['grup']}';
EOF;
/**
 * Seleccionem els codis de profes d'un grup
 * @see profile_student.php
 * @var array
 * @author Amado Domenech Antequera
 */
$RSRC['selec_profe_grup'] = <<<EOF
	SELECT distinct codi_professor
	FROM classe
	WHERE codi_grup='{$VALS['grup']}';
EOF;

/**
 * Comprovem si un profe es tutor d'un grup
 * @see profile_student.php
 * @var array
 * @author Amado Domenech Antequera
 */
$RSRC['es_tutor_grup'] = <<<EOF
	SELECT *
	FROM grup
	WHERE codi_grup='{$VALS['grup']}' AND tutor='{$VALS['codi_profe']}';
EOF;

/**
 * Mostra les incidències en 1 hora determinada al centre
 * @see informe_resum_grup_faltes_pdf.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_INCIDENCIES_HORA_GRUP_ALUMNE'] = <<<EOF
SELECT nom_alumne, motiu_llarg, nom_assignatura, cognom1_professor, nom_professor
FROM alumne INNER JOIN student_groups ON (alumne.codi_alumne=student_groups.student_code) NATURAL JOIN incidencia NATURAL JOIN descripcio_motius_incidencia NATURAL JOIN assignatura
WHERE student_groups.group_code = '{$VALS['codi_grup']}'
AND data_incidencia = '{$VALS['str_data_informe']}'
AND codi_hora = {$VALS['hora_informe']}
AND motiu_incidencia IN {$VALS['motius_informe']}
ORDER BY nom_alumne;
EOF;

/**
 * Mostra les fotos dels professors del centre
 * @see informe_resum_grup_faltes_pdf.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_PROFESSORS_CENTRE'] = <<<EOF
SELECT codi_professor, nom_professor, cognom1_professor, foto_perfil_pr, carrec, descripcio 
FROM professor, departament
WHERE professor.departament = departament.ID 
ORDER BY codi_professor;
EOF;

/**
 * Mostra el nom del grup segons el codi
 * @see informe_resum_grup_faltes_pdf.php
 * @var array
 * @author Alfred Monllaó Calvet
 */
$RSRC['CONSULTA_NOM_GRUP'] = <<<EOF
SELECT nom_grup 
FROM grup
WHERE codi_grup = '{$VALS['codi_grup']}'
EOF;

/**
 * Consulta per a modificar el perfil del professor
 * @see modifying_profile.php
 * @var array
 * @author Amado Domenech Antequera
 */

/************************************************modificar perfil**************************************************************/
												/*profe*/
$RSRC['MODIFICAR_PROFESSOR'] = <<<EOF
UPDATE professor		
SET nom_professor= '{$VALS['teacher_name']}', cognom1_professor='{$VALS['teacher_surname1']}', 
cognom2_professor='{$VALS['teacher_surname2']}', email='{$VALS['email']}'
WHERE codi_professor = '{$VALS['teacher_code']}';
EOF;


$RSRC['MODIFICAR_PASS_PROFESSOR'] = <<<EOF
UPDATE professor		
SET password='{$VALS['password']}', oldpassword='{$VALS['oldpassword']}', cleartext_password='{$VALS['cleartext_password']}' 
WHERE codi_professor = '{$VALS['teacher_code']}';
EOF;


$RSRC['MODIFICAR_FOTO_PROFESSOR'] = <<<EOF
UPDATE professor		
SET foto_perfil_pr='{$VALS['profile_photo']}', foto_perfil_pr_small='{$VALS['profile_photo_small']}', 
foto_perfil_pr_medium='{$VALS['profile_photo_medium']}'
WHERE codi_professor = '{$VALS['teacher_code']}';
EOF;

												/*pare*/
$RSRC['MODIFICAR_PARE'] = <<<EOF
UPDATE pare		
SET nom_pare= '{$VALS['father_name']}', adreca='{$VALS['address']}', codi_postal='{$VALS['postcode']}', ciutat='{$VALS['city']}',
 email='{$VALS['email']}', telefon_mobil='{$VALS['mobile_phone']}', vol_email='{$VALS['vol_email']}', vol_sms='{$VALS['vol_sms']}' 
WHERE codi_pare = '{$VALS['father_code']}';
EOF;


$RSRC['MODIFICAR_PASS_PARE'] = <<<EOF
UPDATE pare		
SET password='{$VALS['password']}', oldpassword='{$VALS['oldpassword']}', cleartext_password='{$VALS['cleartext_password']}' 
WHERE codi_pare = '{$VALS['father_code']}';
EOF;


$RSRC['MODIFICAR_FOTO_PARE'] = <<<EOF
UPDATE pare		
SET foto_perfil_pa='{$VALS['profile_photo']}', foto_perfil_pa_small='{$VALS['profile_photo_small']}', 
foto_perfil_pa_medium='{$VALS['profile_photo_medium']}'
WHERE codi_pare = '{$VALS['father_code']}';
EOF;

												/*alumne*/
$RSRC['MODIFICAR_ALUMNE'] = <<<EOF
UPDATE alumne		
SET nom_alumne= '{$VALS['student_name']}', adreca='{$VALS['address']}', codi_postal='{$VALS['postcode']}', ciutat='{$VALS['city']}', 
telefon_mobil='{$VALS['mobile_phone']}', telefon_fixe='{$VALS['fixed_telephone']}', email='{$VALS['email']}', data_neixement='{$VALS['birthday']}' 
WHERE codi_alumne = '{$VALS['student_code']}';
EOF;


$RSRC['MODIFICAR_PASS_ALUMNE'] = <<<EOF
UPDATE alumne		
SET password='{$VALS['password']}', oldpassword='{$VALS['oldpassword']}', cleartext_password='{$VALS['cleartext_password']}' 
WHERE codi_alumne = '{$VALS['student_code']}';
EOF;


$RSRC['MODIFICAR_FOTO_ALUMNE'] = <<<EOF
UPDATE alumne		
SET foto_perfil_al='{$VALS['profile_photo']}', foto_perfil_al_small='{$VALS['profile_photo_small']}', 
foto_perfil_al_medium='{$VALS['profile_photo_medium']}'
WHERE codi_alumne = '{$VALS['student_code']}';
EOF;

$RSRC['COMPROVAR_USUARI_PROFE'] = <<<EOF
SELECT *
FROM professor
WHERE usuari='{$VALS['usuari']}';
EOF;

$RSRC['COMPROVAR_EMAIL_PROFE'] = <<<EOF
SELECT *
FROM professor
WHERE email='{$VALS['email']}';
EOF;

$RSRC['COMPROVAR_USUARI_EMAIL_PROFE'] = <<<EOF
SELECT *
FROM professor
WHERE usuari='{$VALS['usuari']}' && email='{$VALS['email']}';
EOF;


$RSRC['CADUCITAT'] = <<<EOF
UPDATE professor		
SET data_caducitat= '{$VALS['data_caducitat']}', vol_caducat='{$VALS['vol_caducat']}'
WHERE codi_professor = '{$VALS['codi_professor']}';
EOF;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                          Funcions de gestió                                                  //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
$RSRC['CARREGA_ALUMNES'] = <<<EOF
SELECT * FROM alumne WHERE DATA_BAIXA IS NULL
EOF;
$RSRC['CARREGA_PROFESSORS']= <<<EOF
SELECT *  FROM  professor WHERE DATA_BAIXA IS NULL
EOF;
$RSRC['CARREGA_GRUPS']= <<<EOF
SELECT codi_grup,nom_grup ,nivell_educatiu, grau, descripcio, tutor FROM  grup
EOF;
$RSRC['CARREGA_PARES']= <<<EOF
SELECT * FROM  pare
EOF;
$RSRC['ESBORRA_ALUMNE']= <<<EOF
DELETE FROM alumne WHERE codi_alumne={$VALS['codi_alumne']};
EOF;
$RSRC['ESBORRA_LOGIC_ALUMNE']= <<<EOF
UPDATE alumne SET data_baixa='{$VALS['data']}' WHERE codi_alumne={$VALS['codi_alumne']};
EOF;
$RSRC['ESBORRA_ALUMNES']= <<<EOF
DELETE FROM alumne WHERE codi_alumne IN ({$VALS['chkids']});
EOF;
$RSRC['ESBORRA_LOGIC_ALUMNES']= <<<EOF
UPDATE alumne SET data_baixa='{$VALS['data']}' WHERE codi_alumne IN ({$VALS['chkids']});
EOF;
$RSRC['ESBORRA_PROFESSOR']= <<<EOF
DELETE FROM professor WHERE codi_professor={$VALS['codi_professor']};
EOF;
$RSRC['ESBORRA_LOGIC_PROFESSOR']= <<<EOF
UPDATE professor SET data_baixa='{$VALS['data']}' WHERE codi_professor={$VALS['codi_professor']};
EOF;
$RSRC['ESBORRA_PROFESSORS']= <<<EOF
DELETE FROM professor WHERE codi_professor IN ({$VALS['chkids']});
EOF;
$RSRC['ESBORRA_LOGIC_PROFESSORS']= <<<EOF
UPDATE professor SET data_baixa='{$VALS['data']}' WHERE codi_professor IN ({$VALS['chkids']});
EOF;
$RSRC['ESBORRA_GRUP']= <<<EOF
DELETE FROM grup WHERE codi_grup='{$VALS['codi_grup']}';
EOF;
$RSRC['ESBORRA_GRUPS']= <<<EOF
DELETE FROM grup WHERE codi_grup IN ('{$VALS['chkids']}');
EOF;
$RSRC['ESBORRA_PARE']= <<<EOF
DELETE FROM pare WHERE codi_pare={$VALS['id']};
EOF;
$RSRC['ESBORRA_PARES']= <<<EOF
DELETE FROM pare WHERE codi_pare IN ({$VALS['chkids']});
EOF;
$RSRC['INSERIR_ALUMNE'] = <<<EOF
INSERT INTO alumne (codi_alumne, nom_alumne, adreca, codi_postal, ciutat, telefon_fixe, telefon_mobil, data_neixement, data_alta, foto_perfil_al,foto_perfil_al_small, foto_perfil_al_medium, usuari, password, cleartext_password) VALUES ('{$VALS['id']}','{$VALS['nomcomplet']}', '{$VALS['adreca']}', '{$VALS['codipostal']}','{$VALS['ciutat']}', '{$VALS['telefon']}', '{$VALS['movil']}', '{$VALS['datanaix']}', '{$VALS['data_alta']}', '{$VALS['foto_original']}', '{$VALS['foto_small']}', '{$VALS['foto_medium']}', '{$VALS['usuari']}', MD5('{$VALS['contrasenya']}'), '{$VALS['contrasenya']}');
EOF;
$RSRC['INSERIR_PROFE'] = <<<EOF
INSERT INTO professor (codi_professor, nom_professor,cognom1_professor, cognom2_professor, email, es_coordinador, data_alta, foto_perfil_pr,foto_perfil_pr_small, foto_perfil_pr_medium, usuari, password, cleartext_password, departament, carrec) VALUES ('{$VALS['id']}','{$VALS['nom']}', '{$VALS['cognom1']}', '{$VALS['cognom2']}','{$VALS['email']}', '{$VALS['coordinador']}', '{$VALS['data_alta']}', '{$VALS['foto_original']}', '{$VALS['foto_small']}', '{$VALS['foto_medium']}', '{$VALS['usuari']}', MD5('{$VALS['contrasenya']}'), '{$VALS['contrasenya']}', '{$VALS['departament']}', '{$VALS['carrec']}');
EOF;
$RSRC['INSERIR_GRUP'] = <<<EOF
INSERT INTO grup (codi_grup, nom_grup, nivell_educatiu, grau, descripcio, tutor) VALUES ('{$VALS['id']}','{$VALS['nom']}', '{$VALS['nivell_educatiu']}', '{$VALS['grau']}','{$VALS['descripcio']}', '{$VALS['tutor']}');
EOF;
$RSRC['INSERIR_PARE'] = <<<EOF
INSERT INTO pare (codi_pare, nom_pare, adreca, codi_postal, ciutat, telefon_mobil, email, vol_sms, vol_email, es_pare, foto_perfil_pa,foto_perfil_pa_small, foto_perfil_pa_medium, usuari, password, cleartext_password) VALUES ('{$VALS['id']}','{$VALS['nomcomplet']}', '{$VALS['adreca']}', '{$VALS['codipostal']}','{$VALS['ciutat']}', '{$VALS['movil']}', '{$VALS['email']}', '{$VALS['sms']}', '{$VALS['mail']}', '{$VALS['father']}', '{$VALS['foto_original']}', '{$VALS['foto_small']}', '{$VALS['foto_medium']}', '{$VALS['usuari']}', MD5('{$VALS['contrasenya']}'), '{$VALS['contrasenya']}');
EOF;
$RSRC['DEPARTAMENTS_PROFE'] = <<<EOF
SELECT * FROM departament
EOF;
$RSRC['LLISTAR_DEPARTAMENTS_PROFE'] = <<<EOF
SELECT * FROM departament WHERE ID={$VALS['id']}
EOF;
$RSRC['CARREGA_TUTORS']= <<<EOF
SELECT codi_professor, nom_professor, cognom1_professor, cognom2_professor  FROM  professor WHERE codi_professor='{$VALS['id']}'
EOF;
$RSRC['CARREGA_ALUMNES_MODIFICA'] = <<<EOF
SELECT * FROM alumne WHERE codi_alumne={$VALS['id']}
EOF;
$RSRC['CARREGA_PROFE_MODIFICA'] = <<<EOF
SELECT * FROM professor WHERE codi_professor={$VALS['id']}
EOF;
$RSRC['CARREGA_GRUP_MODIFICA'] = <<<EOF
SELECT * FROM grup WHERE codi_grup='{$VALS['id']}'
EOF;
$RSRC['CARREGA_PARES_MODIFICA'] = <<<EOF
SELECT * FROM pare WHERE codi_pare={$VALS['id']}
EOF;
$RSRC['ACTUALITZA_ALUMNE']= <<<EOF
UPDATE alumne SET codi_alumne={$VALS['id']}, nom_alumne='{$VALS['nom']}', adreca='{$VALS['adreca']}', codi_postal='{$VALS['codipostal']}', ciutat='{$VALS['ciutat']}', telefon_fixe='{$VALS['telefon']}', telefon_mobil='{$VALS['movil']}', data_neixement='{$VALS['datanaix']}', foto_perfil_al='{$VALS['foto_original']}',foto_perfil_al_small='{$VALS['foto_small']}', foto_perfil_al_medium='{$VALS['foto_medium']}', usuari='{$VALS['usuari']}', password=MD5('{$VALS['contrasenya']}'), cleartext_password='{$VALS['contrasenya']}', oldpassword=MD5('{$VALS['contrasenya_vella']}') WHERE codi_alumne={$VALS['id']};
EOF;
$RSRC['ACTUALITZA_PROFE'] = <<<EOF
UPDATE professor SET codi_professor={$VALS['id']}, nom_professor='{$VALS['nom']}',cognom1_professor='{$VALS['cognom1']}', cognom2_professor='{$VALS['cognom2']}', email='{$VALS['email']}', es_coordinador='{$VALS['coordinador']}', foto_perfil_pr='{$VALS['foto_original']}',foto_perfil_pr_small='{$VALS['foto_small']}', foto_perfil_pr_medium='{$VALS['foto_medium']}', usuari='{$VALS['usuari']}', password=MD5('{$VALS['contrasenya']}'), cleartext_password='{$VALS['contrasenya']}', departament='{$VALS['departament']}', carrec='{$VALS['carrec']}', oldpassword=MD5('{$VALS['contrasenya_vella']}') WHERE codi_professor={$VALS['id']};
EOF;
$RSRC['ACTUALITZA_GRUP'] = <<<EOF
UPDATE grup SET codi_grup='{$VALS['id']}', nom_grup='{$VALS['nom']}', nivell_educatiu='{$VALS['nivell_educatiu']}', grau='{$VALS['grau']}', descripcio='{$VALS['descripcio']}', tutor='{$VALS['tutor']}' WHERE codi_grup='{$VALS['id']}';
EOF;
$RSRC['ACTUALITZA_PARE'] = <<<EOF
UPDATE pare SET codi_pare='{$VALS['id']}', nom_pare='{$VALS['nomcomplet']}', adreca='{$VALS['adreca']}', codi_postal='{$VALS['codipostal']}', ciutat='{$VALS['ciutat']}', telefon_mobil='{$VALS['movil']}', email='{$VALS['email']}', vol_sms='{$VALS['sms']}', vol_email='{$VALS['mail']}', es_pare='{$VALS['father']}', foto_perfil_pa='{$VALS['foto_original']}',foto_perfil_pa_small='{$VALS['foto_small']}', foto_perfil_pa_medium='{$VALS['foto_medium']}', usuari='{$VALS['usuari']}', password=MD5('{$VALS['contrasenya']}'), cleartext_password='{$VALS['contrasenya']}', oldpassword=MD5('{$VALS['contrasenya_vella']}') WHERE codi_pare={$VALS['id']};
EOF;
$RSRC['RECUPERA_ALUMNES'] = <<<EOF
SELECT * FROM alumne WHERE DATA_BAIXA IS NOT NULL
EOF;
$RSRC['RECUPERA_ALUMNE']= <<<EOF
UPDATE alumne SET data_baixa=NULL WHERE codi_alumne={$VALS['id']};
EOF;
$RSRC['RECUPERAR_ALUMNES']= <<<EOF
UPDATE alumne SET data_baixa=NULL WHERE codi_alumne IN ({$VALS['chkids']});
EOF;
$RSRC['RECUPERA_PROFESSORS']= <<<EOF
SELECT *  FROM  professor WHERE DATA_BAIXA IS NOT NULL;
EOF;
$RSRC['RECUPERA_PROFESSOR']= <<<EOF
UPDATE professor SET data_baixa=NULL WHERE codi_professor={$VALS['id']};
EOF;
$RSRC['RECUPERAR_PROFESSORS']= <<<EOF
UPDATE professor SET data_baixa=NULL WHERE codi_professor IN ({$VALS['chkids']});
EOF;
$RSRC['CARREGA_CARREC_DEPARTAMENT']= <<<EOF
SELECT carrec1, carrec2, departament1, departament2 FROM carrec_departament WHERE id_professor='{$VALS['codi_professor']}';
EOF;
$RSRC['CARREGA_NOM_GRUP']= <<<EOF
SELECT nom_grup FROM grup WHERE codi_grup='{$VALS['codi_grup']}';
EOF;
$RSRC['INSERT_RECOVERY_PASSWORD'] = <<<EOF
INSERT INTO usuari (codi_usuari, md5sum, estat, data_peticio ) VALUES		
('{$VALS['codi_profe']}', '{$VALS['md5']}',0, NULL);
EOF;
$RSRC['RECOVERY_MD5_PASSWORD'] = <<<EOF
SELECT codi_usuari, estat
FROM usuari
WHERE md5sum='{$VALS['c']}' AND estat=0;
EOF;
$RSRC['RESOLVE_LINK']= <<<EOF
UPDATE usuari SET estat=1 WHERE md5sum='{$VALS['md5']}';
EOF;

error_reporting($old_level_reporting);
?>