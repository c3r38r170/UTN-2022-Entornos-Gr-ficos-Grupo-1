<?php

require_once '../utils/db.php';
require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/usuarioDAO.php'));


if(isset($_POST['delete'])){
	// * baja lógica
	$db->prepared("UPDATE `usuarios` SET `baja`=1 WHERE `id`=?",[$_POST['id']]);
	header('Location: ../usuarios.php');
}elseif(isset($_POST['edit'])){

	$errores = [];

	if(!preg_match('/^[a-zA-ZáéíóúñÑ ]+$/u', $_POST['nombre_completo'])){          
		$errores[]= "El campo Nombre Completo no debe contener letras";
	}

	if(count($errores)){
		header("Location: ../form_usuarios.php?id=".$_POST['id']."&errores=".urlencode(json_encode($errores)));
		exit;
	}

	$db->prepared(
		"UPDATE `usuarios`
		SET
			`nombre_completo`=?
			,`correo`=?
		WHERE `id`=?",[			
			$_POST['nombre_completo']
			,$_POST['correo']
			,$_POST['id']
		]);

		header("Location: ../usuarios.php");        

}elseif(isset($_POST['create'])){

	$errores = [];

	if(!isset($_POST['contrasenia']) || !($contrasenia=trim($_POST["contrasenia"]))){
		$errores[] = 'Ingrese contraseña.';
	}else if (strlen($contrasenia) <= 6){
		$errores[]= "La contraseña es demasiado corta. Debe contener mas de 6 caracteres";
	}

	if(!preg_match('/^[a-zA-ZáéíóúñÑ ]+$/u', $_POST['nombre_completo'])){          
		$errores[]= "El campo Nombre Completo no debe contener letras";
	}

	if(count($errores)){
		header("Location: ../form_usuarios.php?errores=".urlencode(json_encode($errores)));
		exit;
	}

    if(UsuarioDAO::getOne($_POST['legajo'])){
		header("Location: ../form_usuarios.php?errores=".urlencode(json_encode(['Ya existe un usuario con ese legajo'])));
		exit;
	}

	$res=$db->prepared(
		"INSERT INTO usuarios (
			`nombre_completo`
			,`correo`
			,`legajo`
			,`contrasenia`
			,`tipo_id`
			,`baja`
		) VALUES (
			?
			,?
			,?
			,'".password_hash($_POST['contrasenia'],PASSWORD_DEFAULT)."'
			,".(int)$_POST['tipo_id']."
			,0
		)"
		,[
			$_POST['nombre_completo']
			,$_POST['correo']
			,$_POST['legajo']
		]
	);
	$usuarioID=$db->insert_id();
	header("Location: ../form_usuarios.php?id=$usuarioID&success=".urlencode('Se ha creado el usuario.'));
}

?>