<?php
	session_start(['read_and_close'=>true]);
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<title>Contacto</title>
	
	<link rel="stylesheet" type="text/css" href="css/contacto.css">
</head>
<body>
<?php 
    require_once 'template/header.php';
	require_once 'utils/usuario-tipos.php';
		if(sessionEsAdministracion())
			require_once 'template/navs/administracion.php';
		else if (sessionEsEstudiante())
			require_once 'template/navs/estudiante.php';
		else if (sessionEsProfesor())
			require_once 'template/navs/profesor.php';
		else require_once 'template/navs/landing.php';
		require_once 'template/breadcrumbs.php'; 
    echo contactBreadcrumbs();
?>

<div class="container_form">
	<form action="controladores/mails.php" method="post">
		<h2 class="tittle">Sobre Nosotros</h2>
		<p class="subtittle">Complete el siguiente formulario para contactarse con nosotros</p>
		<p class="form_campos_requeridos"> * Campos requeridos</p>

		<input type="email" name="mail" placeholder="Email * " class="campo" required >
		<input type="text" name="name" placeholder="Nombre * " class="campo" required>
		<textarea name="description" placeholder="Descripcion * " required></textarea>

		<input type="submit" value="Enviar" name="btn_contact"  class="btn_enviar">
		
		<?php
			if(isset($_GET['errores']) && !empty($_GET["errores"])){
				$errores=json_decode(urldecode($_GET['errores']),true);
				foreach ($errores as $error) {
					echo "<span class=formulario_error>$error</span><br>";
				}
			}
		?>	
	</form> 
	<div class="info_form">
		<p class="texts_university">
				La Universidad Tecnologica Nacional (UTN) es una universidad publica nacional de Argentina,
				como una continuacion de la Universidad Obrera Nacional. Es la unica universidad del pais
				con una organizacion federal y cuya estructura academica tiene a las ingenierias como objetivo prioritario
		</p>
		<!-- TODO teléfono y horarios reales -->
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