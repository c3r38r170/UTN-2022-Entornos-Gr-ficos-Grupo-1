<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/ingreso.css">
</head>
<body>
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/landing.php';
		require_once 'template/breadcrumbs.php'; 
    echo registerBreadcrumbs();
?>

<div class="formulario">
	<form action="controladores/registro.php" method="post">
		<h2 class="form_titulo">Registro</h2>
		<p class="form_parrafo"> Complete con sus datos para registrarse</p>
		<p class="form_campos_requeridos"> * Campos requeridos</p>

		<input type="hidden" name="tipo" value=1>

		<div class="formulario_contenedor">
			<div class="formulario_grupo">
				<input type="text" id="leg" name="legajo" placeholder="" required>
				<label for="leg">Legajo <span class="campos_requeridos"> * </span></label>
			</div>
			<div class="formulario_grupo">
				<input type="password" id="pass" name="contrasenia" placeholder="" required>
				<label for="pass">Contraseña <span class="campos_requeridos"> * </span></label>
			</div>
			<div class="formulario_grupo">
				<input type="text" name="nombre" placeholder="" required>
				<label for="pass">Nombre/s <span class="campos_requeridos"> * </span></label>
			</div>
			<div class="formulario_grupo">
				<input type="text" name="apellido" placeholder="" required>
				<label for="pass">Apellido/s<span class="campos_requeridos"> * </span> </label>
			</div>
			<div class="formulario_grupo">
				<input type="text" name="email" placeholder="" required>
				<label for="pass">E-mail <span class="campos_requeridos"> * </span></label>
			</div>
	
<?php

if(isset($_GET['errores'])){
	$errores=json_decode(urldecode($_GET['errores']),true);
	foreach ($errores as $error) {
		echo "<span class=formulario_error>$error</span>";
	}
}
if(isset($_GET["success"])){
	$success = $_GET['success'];
	echo "<span>$success</span>";
}

?>

			<input type="submit" value="Registro" name="btn_login">
			
		</div>
	</form>
</div>

<?php require_once 'template/footer.php'; ?>
</body>

</html>