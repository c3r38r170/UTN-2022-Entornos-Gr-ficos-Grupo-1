<?php

/* 
contrasenia
nombre
apellido
email */

require_once '../utils/usuario-tipos.php';

$errores = [];

if(!haIngresado()){
	header('Location: index.php');
}

// ! Definición de $contrasenia
if(!isset($_POST['contrasenia']) || !($contrasenia=trim($_POST["contrasenia"]))){
	$errores[] = 'Ingrese contraseña.';
}

// ! Definición de $nombre
if(!isset($_POST['nombre_completo']) || !($nombre=trim($_POST["nombre_completo"]))){
	$errores[] = 'Ingrese nombre.';
}

// ! Definición de $correo
if(!isset($_POST['correo']) || !($correo=trim($_POST["correo"]))){
	$errores[] = 'Ingrese correo electrónico.';
}

if(count($errores)){
	header('Location: ../mi_cuenta.php?errores='.urlencode(json_encode($errores)));
	die;
}else{
	require_once '../utils/db.php';

	session_start();

	$res=$db->prepared(
		'UPDATE `usuarios` SET
			`contrasenia` = ?,
			`nombre_completo` = ?,
			`correo` = ?
		WHERE `legajo` = '.$_SESSION['legajo']
		,[
			password_hash($contrasenia,PASSWORD_DEFAULT),
			$nombre,
			$correo
		]
	);

	if($res){
		$_SESSION['nombre_completo']=$nombre;
		$_SESSION['correo']=$correo;
		
		header('Location: ../mi_cuenta.php?success='.urlencode('Se han actualizado los datos de la cuenta.'));
		die;
	}
}

?>