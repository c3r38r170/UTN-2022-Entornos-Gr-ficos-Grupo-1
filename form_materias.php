<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Materia</title>
	
	<link rel="stylesheet" type="text/css" href="css/form_materias.css"/>
</head>
<body>
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/landing.php';
		require_once 'utils/breadcrumbs.php'; 
    echo formMatBreadcrumbs();
?>

<div class="formulario">
	<form action="controladores/materias.php" method="post">
		<h2 class="form_titulo">Materias</h2>
		<p class="form_parrafo"> Ingrese datos de la materia</p>
		<div class="formulario_contenedor">
			<div class="formulario_grupo">
			<input type="text" id="np" name="name"  class="form_input" placeholder="" value="<?= isset($_GET['id']) ? $_GET['name'] : "" ?>" required>
				<label for="nm">Nombre</label>
			</div>	
			<input type="submit" value="Guardar" name=<?= !isset($_GET['id']) ? "btn_add" : "btn_up"?> required>
			<input type="hidden" value="<?=isset($_GET['id']) ? $_GET['id'] : ""?>" name="id">
			<p class="form_parrafo"><a href="materias.php" class="form_link">Regresar al listado</a></p>
			<?php
				  if(isset($_GET['error'])){
					$error=json_decode(urldecode($_GET['error']),true);
					echo "<span class=formulario_error>$error</span>";					  
				 }
				  if(isset($_GET["success"])){
					$success = json_decode(urldecode($_GET['success']),true);
					echo "<span>$success</span>";
				}
			  	  ?>  
		</div>
	</form>
</div>

<?php require_once 'template/footer.php'; ?>
</body>

</html>
