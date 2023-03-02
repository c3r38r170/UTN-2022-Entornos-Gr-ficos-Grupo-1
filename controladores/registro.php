<?php

require_once '../utils/usuario-tipos.php';
require_once '../utils/db.php';
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/usuarioDAO.php'));


if(!(
	isset($_POST['tipo'])
	&& isset($_POST['legajo'])
	&& isset($_POST['contrasenia'])
	&& isset($_POST['nombre'])
	&& isset($_POST['apellido'])
	&& isset($_POST['email'])
)){
	header("Location: ../registro.php?errores=".urlencode(json_encode(['Faltan datos.'])));
	die;
}

$tipoNumero=(int)$_POST['tipo'];
$tipo=numeroAUsuarioTipo($tipoNumero);

session_start(['read_and_close'=>true]);

if($tipo!=UsuarioTipos::ESTUDIANTE && !sessionEsAdministracion()){
	header("Location: ../index.php?errores=".urlencode(json_encode(['No tinene los permisos suficientes.'])));
	die;
}

$errores=[];

$legajo=(int)trim($_POST['legajo']);
if(!$legajo)
	$errores[]= "El campo Legajo debe ser numerico.";

$contrasenia=trim($_POST['contrasenia']);
if(empty($contrasenia)){
	$errores[]= "La contraseña no debe estar vacia.";
}else if (strlen($contrasenia) <= 6){
	$errores[]= "La contraseña es demasiado corta. Debe contener mas de 6 caracteres";
}
else{
	$contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
}	

$nombre=trim($_POST['nombre']);
if(empty($nombre))
	$errores[]= "El nombre no debe estar vacio.";
			
$apellido=trim($_POST['apellido']);
if(empty($apellido))
	$errores[]= "El apellido no debe estar vacio.";

$email=trim($_POST['email']);
if(empty($email))
	$errores[]= "El correo electrónico no debe estar vacio.";
	
if(!preg_match('/^[a-zA-Z0-9áéíóúñÑ ]+$/u', $nombre))          
	$errores[]= "El campo Nombre debe ser alfanumerico";
	

if(!preg_match('/^[a-zA-Z0-9áéíóúñÑ ]+$/u', $apellido))          
	$errores[]= "El campo Apellido debe ser alfanumerico";

if(count($errores)){
	header("Location: ../registro.php?errores=".urlencode(json_encode($errores)));
	die;
}else{
	if(UsuarioDAO::getOne($legajo)){
		$errores[]= "El usuario ya existe.";
		header("Location: ../registro.php?errores=".urlencode(json_encode($errores)));
	} else{
		UsuarioDAO::insertUsuario($nombre, $apellido, $email, $legajo, $contrasenia, $tipoNumero);
		$success = "¡Usuario registrado con exito! Se encuentra listo para iniciar sesión ";
        header("Location: ../registro.php?success=".urlencode($success));
	}
}

?>
