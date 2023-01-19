<?php

require_once '../utils/db.php';
require_once '../utils/usuario-tipos.php';

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


if(!count($errores)){
	$contrasenia_existente = "";
	$sql = "SELECT * FROM usuarios where legajo= ?";
	$resultado = $db->prepared($sql,[$legajo]);
	if(!($resultado && $resultado->num_rows)){
		$errores[]="Legajo incorrecto";
	}else{
		$usuarioRow=$resultado->fetch_array();
		$contrasenia_existente = $usuarioRow['contrasenia'];
		mysqli_free_result($resultado);

	//validamos pass de html = pass con hash de la db
		if(password_verify($contrasenia, $contrasenia_existente)){
			session_start();
			$_SESSION['usuario'] = $legajo;
			$_SESSION['tipo'] = numeroAUsuarioTipo((int)$usuarioRow['tipo_id']);

			$pagina;
			switch ($_SESSION['tipo']) {
			case UsuarioTipos::ESTUDIANTE:
				$pagina='index.php';
				break;
			case UsuarioTipos::PROFESOR:
				$pagina='index.php';
				break;
			case UsuarioTipos::ADMINISTRACION:
				$pagina='index.php';
				break;
			}
			// TODO hacemos un redirect a la vista correspondiente del usuario logueado
			header("location: ../".$pagina);

			die;
		} else{
			$errores[]= "Contraseña incorrecta";
		}
	}
}

header("Location: ../ingreso.php?errores=".urlencode(json_encode($errores)));

?>