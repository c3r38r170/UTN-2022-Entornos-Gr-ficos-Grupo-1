<?php

require_once '../utils/db.php';

if(isset($_POST['delete'])){
	// * baja lógica
	$db->prepared("UPDATE `usuarios` SET `baja`=1 WHERE `id`=?",[$_POST['id']]);
	header('Location: /usuarios.php');
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
}

?>