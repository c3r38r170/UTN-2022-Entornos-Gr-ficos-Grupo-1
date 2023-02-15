<?php
	session_start(['read_and_close'=>true]);
	
	require_once 'utils/usuario-tipos.php';
	if(!haIngresado()){
		header('Location: ingreso.php');
		die;
	}
?><!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mi Cuenta</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/ingreso.css"/>
	<script>
		addEventListener('DOMContentLoaded',e=>{
			document.forms[0].onsubmit=function (params) {
				if(this['contrasenia'].value!=this['repetir_contrasenia'].value) {
					e.preventDefault();
					alert('Las contraseñas no coinciden.');
					return false;
				}
			}
		});
	</script>
</head>
<body>
<?php 
    require_once 'template/header.php';
    if(sessionEsAdministracion())
        require_once 'template/navs/administracion.php';
    else if (sessionEsEstudiante())
        require_once 'template/navs/estudiante.php';
    else if (sessionEsProfesor())
        require_once 'template/navs/profesor.php';
    else require_once 'template/navs/landing.php';
    require_once 'template/breadcrumbs.php'; 
		echo miCuentaBreadcrumbs();
?>

<div class="formulario">
	<form action="controladores/mi_cuenta.php" method="post">
		<h2 class="form_titulo">Mi cuenta</h2>
		<p class="form_parrafo"> Los datos de su cuenta. Puede cambiar los campos disponibles si lo desea.</p>

		<div class="formulario_contenedor">
			<div class="formulario_grupo">
				<input type="text" id="leg" name="legajo" placeholder="" disabled value=<?=$_SESSION['legajo']?>>
				<label for="leg">Legajo</label>
			</div>
			<div class="formulario_grupo">
				<input type="password" id="pass" name="contrasenia" placeholder="">
				<label for="pass">Cambiar contraseña</label>
			</div>
			<div class="formulario_grupo">
				<input type="password" id="rep_pass" name="repetir_contrasenia" placeholder="">
				<label for="rep_pass">Repetir contraseña</label>
			</div>
			<div class="formulario_grupo">
				<input type="text" name="nombre_completo" id="nombre_completo" placeholder="" value="<?=$_SESSION['nombre_completo']?>" required>
				<label for="nombre_completo">Nombre/s y Apellido/s</label>
			</div>
			<div class="formulario_grupo">
				<input type="text" name="correo" id="correo" placeholder="" value="<?=$_SESSION['correo']?>" required>
				<label for="correo">E-mail</label>
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

			<input type="submit" value="Actualizar Datos" name="btn_login">
			
		</div>
	</form>
</div>

<?php require_once 'template/footer.php'; ?>
</body>

</html>