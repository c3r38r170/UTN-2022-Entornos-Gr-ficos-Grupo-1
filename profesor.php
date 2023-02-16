<?php
	require_once 'utils/usuario-tipos.php';
	if(!sessionEsProfesor()){
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
	<title>Ingreso</title>	
	<link rel="stylesheet" type="text/css" href="css/ingreso.css"/>
</head>
<body>
<?php 
	require_once 'consultas.php';
	 //TODO agregar mas funciones para el profesor
?>