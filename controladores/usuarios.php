<?php

require_once '../utils/db.php';

if(isset($_POST['delete'])){
	// * baja lógica
	$db->prepared("UPDATE `usuarios` SET `baja`=1 WHERE `id`=?",[$_POST['id']]);
	header('Location: ../usuarios.php');
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

		header("Location: ../usuarios.php");        

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
	header("Location: ../form_usuarios.php?id=$usuarioID&success=".urlencode('Se ha creado el usuario.'));
}

?>