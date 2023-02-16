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
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">	
	<link rel="stylesheet" type="text/css" href="css/ingreso.css"/>
	<title>Comision</title>	
</head>
<body>
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/administracion.php';
		require_once 'template/breadcrumbs.php'; 
    echo formComBreadcrumbs();
?>

<div class="formulario">
        <form action="controladores/comisiones.php" class="form" method="post">
            <h2 class="form_titulo">Comisiones</h2>            
			<p class="form_parrafo"> Ingrese datos de la comision</p>
			<p class="form_campos_requeridos"> * Campo requerido</p>
            <div class="formulario_contenedor">
                <div class="formulario_grupo">
                    <input type="text" id="leg" name="name"  class="form_input" placeholder="" value="<?= isset($_GET['id']) ? $_GET['number'] : "" ?>" required>
                    <label for="" class="form_label">Nombre <span class="campos_requeridos"> * </span></label>
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
					$success = $_GET['success'];
					echo "<span>$success</span>";
				}
			  	  ?>      			
            </div>
        </form>
    </div>

<?php require_once 'template/footer.php'; ?>
</body>
</html>