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
	$breadcrumbs = [array("link" => "index.php","text" => "Home"), array("link" => "#","text" => "Ingreso")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function registerBreadcrumbs(){
	$breadcrumbs = [array("link" => "index.php","text" => "Home"), array("link" => "#","text" => "Registrarse")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function comBreadcrumbs(){
	if(sessionEsAdministracion())
	$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Comisiones")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function matBreadcrumbs(){
	if(sessionEsAdministracion())
	$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Materias")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function userBreadcrumbs(){
	if(sessionEsAdministracion())
	$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Usuarios")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function formMatBreadcrumbs(){
	if(sessionEsAdministracion())
	$breadcrumbs = [array("link" => "administrador.php","text" => "Home"),array("link" => "materias.php","text" => "Materias") ,array("link" => "#","text" => "Formulario Materias")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function formComBreadcrumbs(){
	if(sessionEsAdministracion())
	$breadcrumbs = [array("link" => "administrador.php","text" => "Home"),array("link" => "comisiones.php","text" => "Comisiones") ,array("link" => "#","text" => "Formulario Comisiones")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function formUserBreadcrumbs(){
	if(sessionEsAdministracion())
	$breadcrumbs = [array("link" => "administrador.php","text" => "Home"),array("link" => "usuarios.php","text" => "Usuarios") ,array("link" => "#","text" => "Formulario Usuarios")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function formConsBreadcrumbs(){
	if(sessionEsProfesor())
	$breadcrumbs = [array("link" => "profesor.php","text" => "Home"),array("link" => "consultas.php","text" => "Consultas") ,array("link" => "#","text" => "Formulario Consulta")] ;	
	return generateBreadcrumbs($breadcrumbs);
}


function horariosBreadcrumbs(){
	if(sessionEsAdministracion())
	$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Horarios Consultas")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function preguntasFrecuentesBreadcrumbs(){
	if(sessionEsAdministracion())
		$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;
	else $breadcrumbs = [array("link" => "index.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;	

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
		$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;
	else $breadcrumbs = [array("link" => "index.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;	

	return generateBreadcrumbs($breadcrumbs);
}


function contactBreadcrumbs(){
	if(sessionEsAdministracion())
		$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;
	else $breadcrumbs = [array("link" => "index.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;	

	return generateBreadcrumbs($breadcrumbs);
}

function miCuentaBreadcrumbs(){
	if(sessionEsAdministracion())
		$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Mi cuenta")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Mi cuenta")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Mi cuenta")] ;	

	return generateBreadcrumbs($breadcrumbs);
}

function subsBreadcrumbs(){
	if (sessionEsProfesor())	    
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => $_SERVER['HTTP_REFERER'],"text" => "Consultas"),array("link" => "#","text" => "Suscripciones")] ;	

	return generateBreadcrumbs($breadcrumbs);
}

function formConBreadcrumbs(){
	if(sessionEsAdministracion() || sessionEsProfesor())	
	$breadcrumbs = [array("link" => "index.php","text" => "Home"),array("link" => "consultas.php","text" => "Consultas") ,array("link" => "#","text" => "Editar Consulta")] ;	
	return generateBreadcrumbs($breadcrumbs);	
}


function ayudaBreadcrumbs(){
	if(sessionEsAdministracion())
		$breadcrumbs = [array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Ayuda Administrador")] ;
	else if (sessionEsEstudiante())
		$breadcrumbs = [array("link" => "estudiante.php","text" => "Home"), array("link" => "#","text" => "Ayuda Estudiante")] ;
	else if (sessionEsProfesor())
		$breadcrumbs = [array("link" => "profesor.php","text" => "Home"), array("link" => "#","text" => "Ayuda Profesor")] ;	

	return generateBreadcrumbs($breadcrumbs);
}
?>