<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/utils/DAOs/periodoDAO.php';

class PeriodoControlador{
	static function periodoActual(){
		return PeriodoDAO::periodoActual();
	}
}

?>