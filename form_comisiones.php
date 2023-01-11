<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/form.css"/>
	<title>Document</title>	
</head>
<body>
<?php require_once 'template/header.php'; ?>
<?php
	require_once 'template/nav-function.php';
	nav([
		'Ingresar'=>'login.php'
		,'Registrarse'=>'registro.php'
		,'Consultas'=>'http://'
		,'Gestionar'=>[
			'Usuarios'=>'usuarios.php'
			,'Comisiones'=>'comisiones.php'
		]
		,'Sobre Nosotros'=>'contacto.php'
	]);
?>

<div class="contenedor_form">
        <form action="controladores/comisiones.php" class="form" method="post">
            <h2 class="form_titulo">Comisiones</h2>            
            <div class="form_contenedor">
                <div class="form_grupo">
                    <input type="text" id="leg" name="name"  class="form_input" placeholder="" value="<?= isset($_GET['id']) ? $_GET['number'] : "" ?>" required>
                    <label for="" class="form_label">Nombre</label>
                    <span class="form_linea"></span>
                </div>                
                <input type="submit" value="Guardar" name=<?= !isset($_GET['id']) ? "btn_save" : "btn_edit"?> 
				class="form_submit" required>				
				<input type="hidden" value="<?=isset($_GET['id']) ? $_GET['id'] : ""?>" name="id">
				  <?php
				  if(isset($_SESSION["error"])){
					  $error = $_SESSION["error"];
					  echo "<span>$error</span>";
				  }
				  if(isset($_SESSION["success"])){
					$success = $_SESSION["success"];
					echo "<span>$success</span>";
				}
			  	  ?>      			
            </div>
        </form>
    </div>

	<?php
    	unset($_SESSION["error"]);
		unset($_SESSION["success"]);
	?>
<?php //require_once 'template/footer.php'; ?>
</body>
</html>