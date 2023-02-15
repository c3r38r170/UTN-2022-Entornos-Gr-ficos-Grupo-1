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
}

?>