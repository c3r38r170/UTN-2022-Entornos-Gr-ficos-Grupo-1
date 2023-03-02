<?php
session_start(['read_and_close'=>true]);
	
require_once 'utils/usuario-tipos.php';
if(!sessionEsAdministracion()){
	header('Location: index.php');
	die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- TODO css propio-->
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/ingreso.css">
	<title>Usuario</title>	
	<style>
      .oculto {
        display: none;
      }
	</style>
</head>
<body>
<?php 
	require_once 'template/header.php';
    require_once 'template/navs/administracion.php';
		require_once 'template/breadcrumbs.php'; 
    echo formUserBreadcrumbs();
?>

<?php

$editando=isset($_GET['id']) && !empty($_GET['id']);


if($editando){
	require_once 'utils/DAOs/usuarioDAO.php';

	$usuario=UsuarioDAO::getUserByID((int)$_GET['id']);
}

?>
<div class="formulario">
	<form action="controladores/usuarios.php" class="form" method="post">
		<input type="hidden" value="<?=isset($_GET['id']) ? $_GET['id'] : ""?>" name="id">
		<h2 class="form_titulo">Usuarios</h2>            
		<p class="form_parrafo"> Datos del usuario </p>
		<p class="form_campos_requeridos"> * Campos requeridos</p>
		<div class="formulario_contenedor">
			<div class="formulario_grupo">
				<input type="text" id="leg" name="legajo" class="form_input" placeholder="" value="<?= $editando ? $usuario['legajo'] : "" ?>" required <?= $editando ? "disabled" : "" ?>>
				<label for="leg" class="form_label">Legajo <span class="campos_requeridos"> * </span></label>				
			</div>
			<div class="formulario_grupo">
				<input type="text" id="nombre" name="nombre_completo" class="form_input" placeholder="" value="<?= $editando ? $usuario['nombre_completo'] : "" ?>" required>
				<label for="nombre" class="form_label">Nombre Completo <span class="campos_requeridos"> * </span></label>
			</div>
			<div class="formulario_grupo">
				<input type="email" id="correo" name="correo" class="form_input" placeholder="" value="<?= $editando ? $usuario['correo'] : "" ?>" required>
				<label for="correo" class="form_label">Correo Electrónico <span class="campos_requeridos"> * </span></label>
			</div>
			 <div class="password_grupo <?= $editando ? 'oculto' : '' ?>">
				   <div class="formulario_grupo">
				   <input type="<?= $editando ? 'hidden' : 'password' ?>" id="pass" name="contrasenia" placeholder="" required > </input>
				   <label for="pass">Contraseña <span class="campos_requeridos"> * </span></label>	
				   </div>			
				   <button style="background:none; border:none" type="button" id="boton_visibilidad" onclick="alternarVisibilidad()"><i class='fa-solid fa-eye-slash'></i></button>
			</div>			
			<div class="password_grupo <?= $editando ? 'oculto' : '' ?>">
				   <div class="formulario_grupo">
				   <input type="<?= $editando ? 'hidden' : 'password' ?>" id="rep_pass" name="repetir_contrasenia" placeholder="" required>				   <label for="rep_pass">Repetir contraseña <span class="campos_requeridos"> * </span></label>
				   </div>			
				   <button style="background:none; border:none" type="button" id="boton_visibilidad2" onclick="alternarVisibilidad2()"><i class='fa-solid fa-eye-slash'></i></button>
			</div>		
			<div class="formulario_grupo">
				<!-- TODO estilos de select -->
				<select id="tipo" name="tipo_id" class="form_input" required <?= $editando ? "disabled" : "" ?>>
					<!-- TOOD hacer dinámico? / obtener de la base de datos -->
					<option value="" <?=(!$editando)?'selected':'' ?> disabled>Elija tipo de usuario <span class="campos_requeridos"> * </span> </option>
					<option value="1" <?= ($editando && $usuario['tipo_id']==1) ? "selected" : "" ?>>Estudiante</option>
					<option value="2" <?= ($editando && $usuario['tipo_id']==2) ? "selected" : "" ?>>Profesor</option>
					<option value="3" <?= ($editando && $usuario['tipo_id']==3) ? "selected" : "" ?>>Administración</option>
				</select>
				
			</div>

			<input
				type="submit"
				value="<?= $editando ? "Guardar Cambios" : "Guardar" ?>"
				name=<?= $editando ? "edit" : "create" ?>
				class="form_submit"
				required
			>
			<!-- TODO volver a la búsqueda de donde se vino. Conservar search y offset -->
			<p class="form_parrafo"><a href="usuarios.php" class="form_link">Regresar al listado</a></p>
<?php
	if(isset($_GET['errores']) && !empty($_GET["errores"])){
		$errores=json_decode(urldecode($_GET['errores']),true);
		foreach ($errores as $error) {
			echo "<span class=formulario_error>$error</span>";
		}
	}
	if(isset($_GET["success"]) && !empty($_GET["success"])){
		$success = urldecode($_GET["success"]);
		echo "<span>$success</span>";
	}
?>
		</div>
	</form>
</div>

<script>
function alternarVisibilidad() {
    var input = document.getElementById("pass");
    var boton = document.getElementById("boton_visibilidad");
    if (input.type === "password") {
        input.type = "text";
        boton.innerHTML = "<i class='fa-solid fa-eye'></i>";
    } else {
        input.type = "password";
        boton.innerHTML = "<i class='fa-solid fa-eye-slash'></i>";
    }
}
function alternarVisibilidad2() {
    var input = document.getElementById("rep_pass");
    var boton = document.getElementById("boton_visibilidad2");
    if (input.type === "password") {
        input.type = "text";
        boton.innerHTML = "<i class='fa-solid fa-eye'></i>";
    } else {
        input.type = "password";
        boton.innerHTML = "<i class='fa-solid fa-eye-slash'></i>";
    }
}
</script>
<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>

<?php require_once 'template/footer.php'; ?>
</body>
</html>