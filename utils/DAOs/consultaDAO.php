<?php

require_once(dirname(__DIR__,1) . '\db.php');


class ConsultaDAO{
  static function search($cons, $offset=0, $limit=10,$idTeacher=0){	

		$idTeacher = $idTeacher?
			"AND c.profesor_id=".$idTeacher
			:'';

		$db=new MysqliWrapper();

		// * Como pensamos en mostrar las consultas de acá a una semana, en una semana todas las consultas se van a dar, así que mostramos todas.
		// * Después, al confirmar o suscribirse o lo que sea que se haga primero, la instancia se genera con el próximo día de consulta, que debería ser dentro de la próxima semana.

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
				, c.enlace
			FROM consultas c
				INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
				INNER JOIN comision com ON com.id=mc.comision_id
				INNER JOIN materia mat ON mat.id=mc.materia_id
				INNER JOIN usuarios u ON u.id=c.profesor_id
			WHERE (
				u.nombre_completo LIKE ?
				OR mat.nombre LIKE ?
				OR com.numero LIKE ? )
				AND c.fecha  = (
					SELECT MAX(fecha)
					FROM consultas 
				)
				".$idTeacher."		
			LIMIT $limit OFFSET $offset";

		$rs_result = $db->prepared($sql,['%'.$cons.'%','%'.$cons.'%','%'.$cons.'%']);
		if($rs_result){
			$consult = $rs_result->fetch_all(MYSQLI_ASSOC);
			
			$rs_result->free();
				
			return $consult;
		}else return [];
  }

static function getAll($offset=0, $limit=10){
	
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
		WHERE c.fecha  = (
					SELECT MAX(fecha)
					FROM consultas 
				)	
		LIMIT $limit OFFSET $offset";

	$rs_result = $db->query($sql);
	$consult = $rs_result->fetch_all(MYSQLI_ASSOC);
	
	$rs_result->free();
		
	return $consult;
}

static function teacherCon($idTeacher,$offset=0, $limit=10){
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
			, c.enlace
		FROM consultas c
			INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
			INNER JOIN comision com ON com.id=mc.comision_id
			INNER JOIN materia mat ON mat.id=mc.materia_id
			INNER JOIN usuarios u ON u.id=c.profesor_id
		WHERE c.profesor_id = ?
			AND c.fecha  = (
 				   SELECT MAX(fecha)
    			   FROM consultas 
					)
		LIMIT $limit OFFSET $offset";

	$rs_result = $db->prepared($sql,[$idTeacher]);
	$consult = $rs_result->fetch_all(MYSQLI_ASSOC);
	
	$rs_result->free();
		
	return $consult;
  } 
}
?>