<?php

require_once '../utils/usuario-tipos.php';
require_once '../utils/db.php';

if(!(
	isset($_POST['tipo'])
	&& isset($_POST['legajo'])
	&& isset($_POST['contrasenia'])
	&& isset($_POST['nombre'])
	&& isset($_POST['apellido'])
	&& isset($_POST['email'])
)){
	header("Location: ../ingreso.php?errores=".urlencode(json_encode(['Faltan datos.'])));
	die;
}

$tipoNumero=(int)$_POST['tipo'];
$tipo=numeroAUsuarioTipo($tipoNumero);

session_start(['read_and_close'=>true]);

if($tipo!=UsuarioTipos::ESTUDIANTE && !sessionEsAdministracion()){
	header("Location: ../ingreso.php?errores=".urlencode(json_encode(['No tinene los permisos suficientes.'])));
	die;
}

$errores=[];

$legajo=(int)trim($_POST['legajo']);
if(!$legajo)
	$errores[]= "El campo Legajo debe ser numerico.";

$contrasenia=trim($_POST['contrasenia']);
if(empty($contrasenia)){
	$errores[]= "La contraseña no debe estar vacia.";
}else{
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

if(count($errores)){
	header("Location: ../ingreso.php?errores=".urlencode(json_encode($errores)));
	die;
}else{
	if(getOne($legajo)){
		$errores[]= "El usuario ya existe.";
		header("Location: ../registro.php?errores=".urlencode(json_encode($errores)));
	} else{
		insertUsuario($nombre, $apellido, $email, $legajo, $contrasenia, $tipoNumero);
		$success = "¡Usuario registrado con exito! Se encuentra listo para iniciar sesión ";
        header("Location: ../registro.php?success=".urlencode($success));
	}
}


function getOne($legajo){
    $db=new MysqliWrapper();
   
    $sql = "SELECT * FROM usuarios WHERE legajo=? ";
    $resultado = $db->prepared($sql,[$legajo]);
    $registros = mysqli_num_rows($resultado);

	if($registros == 1){
		return true;
	}else{
		return false;
	}
}


function insertUsuario($nombre, $apellido, $email, $legajo, $contrasenia, $tipoNumero){
	$db=new MysqliWrapper();
	$db->prepared(
		"INSERT INTO `usuarios` (`nombre_completo`,`correo`,`legajo`,`contrasenia`,`tipo_id`) VALUES (?,?,?,?,?)"
		,[$nombre.' '.$apellido,$email,$legajo,$contrasenia,$tipoNumero]
	);
  }
?>
