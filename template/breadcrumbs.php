<?php

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

function contactBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Contacto")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function comBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Comisiones")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function matBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Materias")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function formMatBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"),array("link" => "materias.php","text" => "Materias") ,array("link" => "#","text" => "Cargar Materias")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function formComBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"),array("link" => "comisiones.php","text" => "Comisiones") ,array("link" => "#","text" => "Cargar Comisiones")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function horariosBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Horarios")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function consultasBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Consultas")] ;	
	return generateBreadcrumbs($breadcrumbs);
}

function preguntasFrecuentesBreadcrumbs(){
	$breadcrumbs = [array("link" => "ingreso.php","text" => "Home"), array("link" => "#","text" => "Preguntas Frecuentes")] ;	
	return generateBreadcrumbs($breadcrumbs);
}


?>