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
	<title>Ayuda</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/preguntas_frecuentes.css"/>
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
echo ayudaBreadcrumbs();
?>

<div id="faq">
<?php 
//TODO cargar todos las preguntas para cada tipo de usuario, las siguientes son a modo de tener datos para mostrar
if(sessionEsAdministracion()){ 
?>  
	<details>
    <summary>¿Cómo cargo los Horarios de Consulta?</summary>
      <p>Seleccioná la opción Gestionar en el menú principal y luego la opcion Horarios de Consulta.<br> 
        Descargá la Plantilla con los horarios mediante el link proporcionado en dicha página.<br> 
        Una vez realizado el paso anterior, procedé a presionar el boton Seleccionar archivo para elegirlo de su computadora.<br>
        Hace click en Subir achivo para poder subir los horarios de la consulta .<br>
        ¡Listo! Los horarios de las consultas han sido cargados.
      </p>
  </details>
  <details>
    <summary>¿Cómo cargo / edito / elimino Materias?</summary>
    <p>Seleccioná la opción Gestionar en el menú principal y luego la opcion Materias.<br> 
        En este apartado, prodrá acceder al listado de materias cargadas en el sistema.<br> 
        Seleccioná el botón deseado (cargar / editar / eliminar) del listado.<br> 
        Luego, completá el formulario con los datos requeridos según lo seleccionado y presioná el botón Guardar.<br> 
        Tener en cuenta que deberá respetar la forma en la que se le solicitan los datos proporcionados por el formulario.<br>
        En caso que desee eliminar, no debera completar ningun formulario, solo aceptar la alerta de confirmacion de eliminacion.<br>
        ¡Listo! La/s materias han sido actualizadas.
      </p>
  </details>
  <details>
    <summary>¿Cómo cargo / edito / elimino Comisiones?</summary>
    <p>Seleccioná la opción Gestionar en el menú principal y luego la opcion Comisiones.<br> 
        En este apartado, prodrá acceder al listado de comisiones cargadas en el sistema.<br> 
        Seleccioná el botón deseado (cargar / editar / eliminar) del listado.<br> 
        Luego, completá el formulario con los datos requeridos según lo seleccionado y presioná el botón Guardar.<br> 
        Tener en cuenta que deberá respetar la forma en la que se le solicitan los datos proporcionados por el formulario.<br>
        En caso que desee eliminar, no debera completar ningun formulario, solo aceptar la alerta de confirmacion de eliminacion.<br>
        ¡Listo! La/s comisiones han sido actualizadas.
      </p>
  </details>
<?php 
}
else if (sessionEsEstudiante()){
?>
	<details>
    <summary>¿Es Estudiante?</summary>
      <p>Seleccioná la opción Registrarse en el menú principal.<br> 
        Completá el formulario con tus datos personales y presioná el botón Registo.<br> 
        Tener en cuenta que deberá respetar la forma en la que se le solicitan los datos proporcionados por el formulario.<br>
        ¡Listo! Ya podés ingresar y hacer uso del sistema de consulta.
      </p>
  </details>
  <details>
    <summary>¿Es Estudiante?</summary>
      <p>Seleccioná la opción Registrarse en el menú principal.<br> 
        Completá el formulario con tus datos personales y presioná el botón Registo.<br> 
        Tener en cuenta que deberá respetar la forma en la que se le solicitan los datos proporcionados por el formulario.<br>
        ¡Listo! Ya podés ingresar y hacer uso del sistema de consulta.
      </p>
  </details>
<?php 
}
else if (sessionEsProfesor()){
?>
	<details>
    <summary>¿Es Profesor?</summary>
      <p>Seleccioná la opción Registrarse en el menú principal.<br> 
        Completá el formulario con tus datos personales y presioná el botón Registo.<br> 
        Tener en cuenta que deberá respetar la forma en la que se le solicitan los datos proporcionados por el formulario.<br>
        ¡Listo! Ya podés ingresar y hacer uso del sistema de consulta.
      </p>
  </details>
  <details>
    <summary>¿Es Profesor?</summary>
      <p>Seleccioná la opción Registrarse en el menú principal.<br> 
        Completá el formulario con tus datos personales y presioná el botón Registo.<br> 
        Tener en cuenta que deberá respetar la forma en la que se le solicitan los datos proporcionados por el formulario.<br>
        ¡Listo! Ya podés ingresar y hacer uso del sistema de consulta.
      </p>
  </details>
<?php 
}
?>
</div>

<?php require_once 'template/footer.php'; ?>
</body>
</html>