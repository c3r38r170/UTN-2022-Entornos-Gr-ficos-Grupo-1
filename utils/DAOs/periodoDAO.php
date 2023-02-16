<?php

require_once(dirname(__DIR__,1) . '\db.php');

class PeriodoDAO{
	static function periodoActual(){
		global $db;
		
		$res=$db->query("SELECT * FROM `periodos` WHERE `inicio`<=NOW() AND NOW()<=`fin`");
		if($res && $res->num_rows){
			return $res->fetch_assoc();
		}else return null;
	}

	static function obtenerTodos(){
		global $db;
		
		$res=$db->query("SELECT * FROM `periodos` ORDER BY `inicio` DESC");

		return $res->fetch_all(MYSQLI_ASSOC);
	}
	
	static function crear($periodo){
		global $db;
		
		return $db->prepared("INSERT INTO `periodos` VALUES (?,?)",[$periodo['inicio'],$periodo['fin']]);
	}

	static function eliminar($periodo){
		global $db;
		
		return $db->prepared("DELETE FROM `periodos` WHERE `inicio`=? AND `fin`=?",[$periodo['inicio'],$periodo['fin']]);
	}
}

?>