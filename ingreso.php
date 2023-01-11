<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	
	<link rel="stylesheet" type="text/css" href="css/ingreso.css"/>
</head>
<body>
<?php require_once 'template/header.php'; ?>
<?php
	require_once 'template/nav-function.php';
	nav([
		'Ingresar'=>'ingreso.php'
		,'Registrarse'=>'registro.php'
		,'Consultas'=>'http://'
		,'Gestionar'=>[
			'Usuarios'=>'usuarios.php'
			,'Carreras'=>'carreras.php'
		]
		,'Sobre Nosotros'=>'contacto.php'
	]);

?>

<div class="formulario">
	<form action="controladores/ingreso.php" method="post">
		<h2 class="form_titulo">Login</h2>
		<p class="form_parrafo"> ¿No tienes cuenta? <a href="sign_in.php">¡Registrate!</a></p>

		<div class="formulario_contenedor">
			<div class="formulario_grupo">
				<input type="text" id="leg" name="legajo" placeholder="" required>
				<label for="leg">Legajo</label>
			</div>
			<div class="formulario_grupo">
				<input type="password" id="pass" name="password" placeholder="" required>
				<label for="pass">Contraseña</label>
			</div>
	
			<input type="submit" value="Entrar" name="btn_login">
			
		</div>
	</form>
</div>

<?php require_once 'template/footer.php'; ?>
</body>

</html>