<?php

require_once(dirname(__DIR__,1) . '\db.php');

// TODO DRY en las partes comunes de las consultas. quizá una funcion contruirSelect($where):string o select($where,$parametros : array|null):array

class ConsultaDAO{
	static function getById(int $id){
		$db=new MysqliWrapper();

		$sql =
			"SELECT
					c.id  
				, c.profesor_id
				, u.nombre_completo
				, mc.materia_id
				, mat.nombre as nombre_materia
				, mc.comision_id
				, com.numero as numero_comision
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
			WHERE 
				c.id=$id
				AND c.fecha  = (
					SELECT MAX(fecha)
					FROM consultas 
				)
			LIMIT 1";

		$rs_result = $db->query($sql);
		if($rs_result && $rs_result->num_rows){
			$consult = $rs_result->fetch_assoc();
			
			$rs_result->free();
				
			return $consult;
		}else return null;
	}

  static function search($cons, $offset=0, $limit=10, $idTeacher=0){	

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
				, mc.materia_id
				, mat.nombre as nombre_materia
				, mc.comision_id
				, com.numero as numero_comision
				, c.hora_desde
				, c.hora_hasta
				, c.dia_de_la_semana
				, c.aula
				, c.fecha
				, c.enlace
			FROM consultas c
				INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
				INNER JOIN comision com ON com.id=mc.comision_id
				INNER JOIN materia mat ON mat.id=mc.materia_id
				INNER JOIN usuarios u ON u.id=c.profesor_id
			WHERE (
				u.nombre_completo LIKE ?
				OR mat.nombre as nombre_materia LIKE ?
				OR com.numero as numero_comision LIKE ? )
				AND c.fecha  = (
					SELECT MAX(fecha)
					FROM consultas 
				)
				$idTeacher
			LIMIT $limit OFFSET $offset";

		$rs_result = $db->prepared($sql,['%'.$cons.'%','%'.$cons.'%','%'.$cons.'%']);
		// TODO realizar el mismo chequeo en getAll y teacherCon
		if($rs_result){
			$consult = $rs_result->fetch_all(MYSQLI_ASSOC);
			
			$rs_result->free();
				
			return $consult;
		}else return [];
  }

	static function getAll($offset=0, $limit=10, $idTeacher=0){
		
		$db=new MysqliWrapper();

		$sql =
			"SELECT
					c.id
				, u.nombre_completo
				, mc.materia_id
				, mat.nombre as nombre_materia
				, mc.comision_id
				, com.numero as numero_comision
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
			".(
				$idTeacher?
					"AND c.profesor_id=".$idTeacher
					:''
			)."
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
				, mc.materia_id
				, mat.nombre as nombre_materia
				, mc.comision_id
				, com.numero as numero_comision
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

  static function conInfo($conId){
	$db=new MysqliWrapper();
	
		$sql =
		"SELECT		    
			mat.nombre
			, com.numero			
			, c.aula
			, c.hora_desde
			, c.hora_hasta
			, c.enlace
			, c.fecha 
			, c.dia_de_la_semana
		FROM consultas c
			INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
			INNER JOIN comision com ON com.id=mc.comision_id
			INNER JOIN materia mat ON mat.id=mc.materia_id			
		WHERE c.id = ?";			
	$rs_result = $db->prepared($sql,[$conId]);
	$consult = $rs_result->fetch_assoc();

	$rs_result->free();
		
	return $consult;
  }
  
}
?>