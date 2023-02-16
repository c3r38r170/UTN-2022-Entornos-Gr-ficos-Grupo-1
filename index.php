<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<title>Ingreso</title>	
	<link rel="stylesheet" type="text/css" href="css/ingreso.css"/>
</head>
<body>
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/landing.php';
		require_once 'template/breadcrumbs.php'; 
	  echo loginBreadcrumbs();
?>

<div class="formulario">
	<form action="controladores/index.php" method="post">
		<h2 class="form_titulo">Ingreso</h2>
		<p class="form_parrafo"> ¿No tienes cuenta? <a href="registro.php">¡Registrate!</a></p>
		<p class="form_campos_requeridos"> * Campos requeridos</p>

		<div class="formulario_contenedor">
			<div class="formulario_grupo">
				<input type="text" id="leg" name="legajo" placeholder="" required>
				<label for="leg">Legajo <span class="campos_requeridos"> * </span></label>
			</div>
			<div class="formulario_grupo">
				<input type="password" id="pass" name="contrasenia" placeholder="" required>
				<label for="pass">Contraseña <span class="campos_requeridos"> * </span></label>
			</div>
	
<?php

if(isset($_GET['errores'])){
	$errores=json_decode(urldecode($_GET['errores']),true);
	foreach ($errores as $error) {
		echo "<span class=formulario_error>$error</span>";
	}
}

?>

			<input type="submit" value="Entrar" name="btn_login">
			
		</div>
	</form>
</div>

<?php require_once 'template/footer.php'; ?>
</body>
</html>