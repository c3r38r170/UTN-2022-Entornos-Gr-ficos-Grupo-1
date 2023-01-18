<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=\, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/horarios.css">
	<title>Horarios</title>
</head>
<body>
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/landing.php';
		require_once 'utils/breadcrumbs.php'; 
    echo horariosBreadcrumbs();
?>

<div class="container">
	<div class="card">
	  <h3>Carga de Horarios de Consulta</h3>
	  <p> Este apartado se encuentra dedicado a la carga mediante un archivo Excel (cualquiera de sus respectivas versiones/formatos)
		de los horarios de consulta de los docentes del Departamento de ISI.
	  </p>
	  <p>
		Para facilitar el uso y carga del mismo, proporcionamos una planilla con el formato adecuado, la cual debe descargar,
		completar y subir, mediante el siguiente enlace:
	  </p>
	  <a href="./docs/horarios.xlsx" download="Plantilla Horarios de Consulta.xlsx"> Descargar Planilla Horarios de Consulta</a>
	  <div class="drop_box">
		  <h4>Selecciona un archivo aqui:</h4>
		    <p>Importante: solo se soportan archivos Excel en cualquiera de sus versiones.</p>
		    <form action="controladores/horarios.php" enctype="multipart/form-data" method="post">
			    <input type="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"  required>
			    <!-- lei en Stack Overflow que el string dentro del atributo accept permite todas las versiones de exel.
		         TODO: Hay que hacer casos de prueba, respecto a lo de arriba 
                 TODO: Limpiar horarios.xlsx para que sea una plantilla sin datos
                 TODO: Testear que el archivo se suba correctamente
                -->
			     <input type="submit" class="btn" value="Subir Archivo">
		    </form>
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
	</div>
  </div>

<?php require_once './template/footer.php'; ?>

</body>
</html>