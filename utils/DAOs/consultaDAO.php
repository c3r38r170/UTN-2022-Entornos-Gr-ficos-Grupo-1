<?php

require_once(dirname(__DIR__,1) . '\db.php');

function search($cons, $offset=0, $limit=10){	

	$db=new MysqliWrapper();

	$sql =
		"SELECT
		    c.id  
			, u.nombre_completo
			, mat.nombre
			, com.numero
			, c.hora_desde
			, c.hora_hasta
			, c.dia_de_la_semana
			, c.aula
		FROM consultas c
			INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
			INNER JOIN comision com ON com.id=mc.comision_id
			INNER JOIN materia mat ON mat.id=mc.materia_id
			INNER JOIN usuarios u ON u.id=c.profesor_id
		WHERE (u.nombre_completo
			LIKE ?
			OR mat.nombre LIKE ?
			OR com.numero LIKE ? )
			AND c.fecha  = (
 				   SELECT MAX(fecha)
    			   FROM consultas 
					)
		LIMIT $limit OFFSET $offset";

	$rs_result = $db->prepared($sql,['%'.$cons.'%','%'.$cons.'%','%'.$cons.'%']);
	$consult = $rs_result->fetch_all(MYSQLI_ASSOC);
	
	$rs_result->free();
		
	return $consult;
}


?>