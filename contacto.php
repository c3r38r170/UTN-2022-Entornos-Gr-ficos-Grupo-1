<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	
	<link rel="stylesheet" type="text/css" href="css/contacto.css"/>
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

<?php require_once 'utils/breadcrumbs.php'; 
     echo contactBreadcrumbs();
?>

<div class="container_form">
	<form action="./controladores/contacto.php" method="post">
		<h2 class="tittle">Sobre Nosotros</h2>
		<p class="subtittle">Complete el siguiente formulario para contactarse con nosotros</p>

		<input type="text" name="mail" placeholder="Email" class="campo" required>
		<input type="text" name="name" placeholder="Nombre" class="campo" required>
		<textarea name="description" placeholder="Descripcion" required></textarea>

		<input type="submit" value="Enviar" name="btn_contact"  class="btn_enviar">
		
	</form> 
	<div class="info_form">
		<p class="texts_university">
				La Universidad Tecnologica Nacional (UTN) es una universidad publica nacional de Argentina,
				como una continuacion de la Universidad Obrera Nacional. Es la unica universidad del pais
				con una organizacion federal y cuya estructura academica tiene a las ingenierias como objetivo prioritario
		</p>
		<label class="texts_phone">Telefono:</label>
		<p class="texts_number">
			+1 (877) 747-9986
		</p>
		<label class="texts_phone">Horario:</label>
		<p class="texts_time">
			Lunes - Viernes:   <span> 9:00 am - 12:00 pm, 5:00 pm - 8:00 pm </span>
		</p>
	</div>
</div>

<?php require_once 'template/footer.php'; ?>
</body>
</html>