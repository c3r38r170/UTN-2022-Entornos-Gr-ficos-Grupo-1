<?php
  session_start(['read_and_close'=>true]);
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Preguntas Frecuentes</title>
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/preguntas_frecuentes.css">
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
echo preguntasFrecuentesBreadcrumbs();
?>

<div id="faq">
	<details>
        <summary>¿Cómo me registro?</summary>
        <p>Seleccioná la opción Registrarse en el menú principal.<br> 
            Completá el formulario con tus datos personales y presioná el botón Registo.<br> 
            Tener en cuenta que deberá respetar la forma en la que se le solicitan los datos proporcionados por el formulario.<br>
            ¡Listo! Ya podés ingresar y hacer uso del sistema de consulta.
        </p>
      </details>
	  <!-- TODO hacer las preguntas frecuentes que se nos ocurran -->
	  <details>
        <summary>¿Cómo ingreso?</summary>
        <p>Seleccioná la opción Ingresar en el menú principal.<br>
            Una vez registrado, completá el formulario ingresando legajo y contraseña, luego presioná el botón Entrar.<br> 
            ¡Listo! Ya se encuentra apto para hacer uso del sistema de consulta.<br>
            Recuerde que el paso de registrase es fundamental para poder ingresar, de lo contrario no podrá hacerlo.
        </p>
      </details>
      <details>
        <summary>¿Cómo me contacto en caso de problemas/inquietudes?</summary>
        <p>Seleccioná la opción Sobre Nosotros en el menú principal.<br>
            En este apartado, completá el formulario con los datos propuestos:<br>
            - Su nombre, para poder identificarlo<br>
            - Su correo electrónico, debido a que es el medio por el cual le contestaremos lo solicitado<br>
            - Descripción, de la inquietud a modo de conocer su problemática  y brindarle una solución<br>
            Luego presioná el botón Enviar.<br> 
            ¡Listo! Su problemática/consulta ha sido enviada. En breve le responderemos.
        </p>
      </details>
      <details>
        <summary>¿Cómo busco las consultas?</summary>
        <p>Seleccioná la opción Consultas en el menú principal.<br>
            En la barra de búsqueda introducí  la información  de la consulta que le interesaría  obtener.<br>
            Usted podrá  buscar por nombre de profesor, nombre de materia o número  de comisión.<br>
            Luego apretá  el botón  de "lupa" para realizar la búsqueda y podrá  ver como se le despliega las consultas correspondientes.<br>
            Sin hacer uso del buscador, podra buscar manualmente haciendo clik en las flechas con orientacion izquierda y derecha (Pagina anterior y Pagina siguiente respectivamente)
            ubicadas al final del listado para navegar por las distintas paginas hasta encontrar la deseada.
        </p>
      </details>
      <details>
        <summary>¿Debo ingresar (iniciar sesión) para poder inscribirme a una consulta?</summary>
        <p>Sí, usted deberá  estar registrado e ingresar al sistema para poder inscribirse a una consulta.
        </p>
      </details>
</div>

<?php require_once 'template/footer.php'; ?>
</body>
</html>