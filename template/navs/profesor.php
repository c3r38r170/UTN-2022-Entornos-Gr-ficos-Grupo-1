<?php
	require_once 'template/nav-function.php';
	nav([
		'Mi Cuenta'=>'mi_cuenta.php'
		,'Consultas'=>'consultas.php'
		,'Sobre Nosotros'=>'contacto.php'
		,'Preguntas Frecuentes'=>'preguntas_frecuentes.php'
        ,'Cerrar Sesión'=>'controladores/cierre-sesion.php'
	]);
?>