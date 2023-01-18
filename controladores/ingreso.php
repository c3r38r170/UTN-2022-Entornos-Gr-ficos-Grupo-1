<?php

require_once '../utils/db.php';

$legajo = $_POST["legajo"];
$contrasenia = $_POST["contrasenia"];
$errores = [];

if(empty($legajo)){
	$errores[]= "El campo Legajo esta vacio";
}else{
// TODO revisar que el legajo sea único
	if(!ctype_digit($legajo)){
		$errores[]= "El campo Legajo debe ser numerico";
	}
}
if(empty($contrasenia)){
	$errores[]= "El campo Contraseña esta vacio";
}


if(!$errores){
	if(loguear($legajo,$contrasenia)){
		// TODO $_SESSION
		$_SESSION['usuario'] = $legajo;
		// TO DO hacemos un redirect a la vista correspondiente del usuario logueado
		header("location: ../index.php");
		die;
	} else{
		$errores[]= "Error autentificacion";
	}
}

header("Location: ../ingreso.php?errores=".urlencode(json_encode($errores)));


function loguear($legajo, $contrasenia){

	$db=new MysqliWrapper();
	$contrasenia_existente = "";
	$sql = "SELECT * FROM usuarios where legajo= ?";
    $resultado = $db->prepared($sql,[$legajo]);
    $contrasenia_existente = $resultado->fetch_array()['contrasenia'];
	mysqli_free_result($resultado);

	if(password_verify($contrasenia, $contrasenia_existente)){ //validamos pass de html = pass con hash de la db
		return true ;
	}else{
		return false;
	}
}

?>