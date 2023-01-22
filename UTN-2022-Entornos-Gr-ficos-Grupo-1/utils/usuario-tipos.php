<?php

session_start(['read_and_close'=>true]);

/* ! Para PHP 7. En PHP 8 se usa https://www.php.net/manual/en/language.types.enumerations.php */
abstract class UsuarioTipos{
	const ESTUDIANTE = 1;
	const PROFESOR = 2;
	const ADMINISTRACION = 3;
}

function sessionEsAdministracion(){
	return $_SESSION['tipo']==UsuarioTipos::ADMINISTRACION;
}

function sessionEsEstudiante(){
	return $_SESSION['tipo']==UsuarioTipos::ESTUDIANTE;
}

function sessionEsProfesor(){
	return $_SESSION['tipo']==UsuarioTipos::PROFESOR;
}

function numeroAUsuarioTipo($n){
	switch($n){
		case 1:
			return UsuarioTipos::ESTUDIANTE;
			break;
		case 2:
			return UsuarioTipos::PROFESOR;
			break;
		case 3:
			return UsuarioTipos::ADMINISTRACION;
			break;
	}
}

function haIngresado(){
	return isset($_SESSION['tipo']);
}

?>