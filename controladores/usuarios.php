<?php

require_once '../utils/db.php';

// * Solo nos interesa saber la existencia, no el valor.
if(isset($_POST['delete'])){
	// * baja lógica
	$db->prepared("UPDATE `usuarios` SET `baja`=1 WHERE `id`=?",[$_POST['id']]);
	header('Location: /usuarios.php');

// * Solo nos interesa saber la existencia, no el valor.
}elseif(isset($_POST['edit'])){
	$db->prepared(
		"UPDATE `usuarios`
		SET
			`nombre_completo`=?
			,`correo`=?
		WHERE `id`=?",[
			$_POST['correo']
			,$_POST['nombre_completo']
			,$_POST['id']
		]);

	header("Location: /form_usuarios.php?id={$_POST['id']}&success=".urlencode('Se ha editado la información del usuario.'));
	
// * Solo nos interesa saber la existencia, no el valor.
}elseif(isset($_POST['create'])){
	$res=$db->prepared(
		"INSERT INTO usuarios (
			`nombre_completo`
			,`correo`
			,`legajo`
			,`contrasenia`
			,`tipo_id`
		) VALUES (
			?
			,?
			,?
			,'".password_hash($_POST['contrasenia'],PASSWORD_DEFAULT)."'
			,".(int)$_POST['tipo_id']."
		)"
		,[
			$_POST['nombre_completo']
			,$_POST['correo']
			,$_POST['legajo']
		]
	);
	$usuarioID=$db->insert_id();
	header("Location: /form_usuarios.php?id=$usuarioID&success=".urlencode('Se ha creado el usuario.'));
}

?>