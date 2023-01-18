<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" type="text/css" href="css/ingreso.css"/>
	<title>Document</title>	
</head>
<body>
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/landing.php';
		require_once 'utils/breadcrumbs.php'; 
    echo formComBreadcrumbs();
?>

<div class="formulario">
        <form action="controladores/comisiones.php" class="form" method="post">
            <h2 class="form_titulo">Comisiones</h2>            
			<p class="form_parrafo"> Ingrese datos de la comision</p>
            <div class="formulario_contenedor">
                <div class="formulario_grupo">
                    <input type="text" id="leg" name="name"  class="form_input" placeholder="" value="<?= isset($_GET['id']) ? $_GET['number'] : "" ?>" required>
                    <label for="" class="form_label">Nombre</label>
                    <span class="form_linea"></span>
                </div>                
                <input type="submit" value="Guardar" name=<?= !isset($_GET['id']) ? "btn_save" : "btn_edit"?> 
				class="form_submit" required>				
				<input type="hidden" value="<?=isset($_GET['id']) ? $_GET['id'] : ""?>" name="id">
				<p class="form_parrafo"><a href="comisiones.php" class="form_link">Regresar al listado</a></p>
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

<?php //require_once 'template/footer.php'; ?>
</body>
</html>