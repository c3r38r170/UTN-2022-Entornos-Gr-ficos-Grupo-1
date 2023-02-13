<?php
	require_once 'template/nav-function.php';
	nav([
		'Mi Cuenta'=>'mi_cuenta.php'
		,'Gestionar'=>[
			'Usuarios'=>'usuarios.php'
			,'Comisiones'=>'comisiones.php'
			,'Materias'=>'materias.php'
			,'Consultas'=>'consultas.php'
			,'Horarios Consultas'=>'horarios.php'
		]
		,'Sobre Nosotros'=>'contacto.php'
		,'Ayuda Administrador'=>'ayuda.php'
		,'Preguntas Frecuentes'=>'preguntas_frecuentes.php'
		,'Cerrar Sesión'=>'controladores/cierre-sesion.php'
	]);
?>