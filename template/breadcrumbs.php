<?php
require_once 'utils/usuario-tipos.php';

function generateBreadcrumbs($breadcrumbs){
	$ul='<ul class="breadcrumbs">';
	foreach($breadcrumbs as $bre) {
		$ul.='<li><a href="'.$bre['link'].'">'.$bre['text'].'</a></li>';
	}
	$ul.='</ul>';
	return $ul;
}

function loginBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Ingreso")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function registerBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Registrarse")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function comBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Comisiones")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function matBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Materias")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function userBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Usuarios")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function formMatBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"),array("link" => "materias.php","text" => "Materias") ,array("link" => "#","text" => "Cargar Materias")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function formComBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"),array("link" => "comisiones.php","text" => "Comisiones") ,array("link" => "#","text" => "Cargar Comisiones")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function horariosBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Horarios Consultas")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function preguntasFrecuentesBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
		$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;
	else $breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;	

	return generateBreadcrumbs($breadcrumbs);
}

function misConsultasBreadcrumbs(){
	if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Mis Consultas")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Mis Consultas")] ;
		
	return generateBreadcrumbs($breadcrumbs);
}

function consultasBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
		$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;
	else $breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;	

	return generateBreadcrumbs($breadcrumbs);
}


function contactBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
		$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;
	else $breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;	

	return generateBreadcrumbs($breadcrumbs);
}

function miCuentaBreadcrumbs(){
	if(sessionEsAdministracion())
	//TODO agregar en "Home" el link del home del administrador
		$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Mi cuenta")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Mi cuenta")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Mi cuenta")] ;	

	return generateBreadcrumbs($breadcrumbs);
}

function subsBreadcrumbs(){
	if (sessionEsProfesor())	    
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => $_SERVER['HTTP_REFERER'],"text" => "Consultas"),array("link" => "#","text" => "Subscripciones")] ;	

	return generateBreadcrumbs($breadcrumbs);
}



?>