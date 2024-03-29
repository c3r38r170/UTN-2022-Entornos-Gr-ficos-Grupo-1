<?php


require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/periodoDAO.php'));
//require_once $_SERVER['DOCUMENT_ROOT'].'/utils/DAOs/periodoDAO.php';

class PeriodoControlador{
	static function periodoActual(){
		return PeriodoDAO::periodoActual();
	}
	static function obtenerTodos(){
		return PeriodoDAO::obtenerTodos();
	}
	static function crear($periodo){
		return PeriodoDAO::crear($periodo);
	}
	static function eliminar($periodo){
		return PeriodoDAO::eliminar($periodo);
	}
}

// POST handlers

// * Solo nos interesa saber la existencia, no el valor.
if(isset($_POST['crear'])){
	PeriodoControlador::crear($_POST);
	header('Location: ../periodos.php');
}

// * Solo nos interesa saber la existencia, no el valor.
if(isset($_POST['delete'])){
	PeriodoControlador::eliminar($_POST);
	header('Location: ../periodos.php');
}

?>