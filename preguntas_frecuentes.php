<?php

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Preguntas Frecuentes</title>
	
	<link rel="stylesheet" type="text/css" href="css/preguntas_frecuentes.css"/>
</head>
<body>
<?php 
    require_once 'template/header.php';
	require_once 'template/navs/landing.php';
	require_once 'template/breadcrumbs.php'; 
    echo preguntasFrecuentesBreadcrumbs();
?>

<div>
	<details>
        <summary>¿Cómo me registro?</summary>
        <p>Seleccioná la opción Registrarse en el menú principal.<br> 
            Completá el formulario con tus datos personales y presioná el botón Registo.<br> 
            ¡Listo! Ya podés ingresar y hacer uso del sistema de consulta.</p>
      </details>
	  <!-- TODO hacer las preguntas frecuentes que se nos ocurran -->
	  <details>
        <summary>¿Cómo me registro?</summary>
        <p>Seleccioná la opción Registrarse en el menú principal.<br> 
            Completá el formulario con tus datos personales y presioná el botón Registo.<br> 
            ¡Listo! Ya podés ingresar y hacer uso del sistema de consulta.</p>
      </details>
</div>

<?php require_once 'template/footer.php'; ?>
</body>
</html>