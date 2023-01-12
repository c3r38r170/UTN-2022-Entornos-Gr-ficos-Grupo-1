<?php

$user = $_POST["legajo"];
$password = $_POST["contrasenia"];
$errores = [];

if(empty($user)){
		$errores[]= "El campo Legajo esta vacio";
}else{
// TODO revisar que el legajo sea único
if(!ctype_digit($user)){
		$errores[]= "El campo Legajo debe ser numerico";
}
}
if(empty($password)){
		$errores[]= "El campo Contraseña esta vacio";
}

if(!$errores){

	// TODO use MysqliWrapper

	// TODO use password_hash

	$query="SELECT*FROM usuario where legajo='$user' and contrasenia='$password'";
	//ejecuto consulta
	$result=mysqli_query($conn,$query);
	//tomo las cantidad de filas que devolvio la consulta
	$rows=mysqli_num_rows($result);

// TODO $_SESSION

	//validamos si devolvio una fila
	if($rows > 0){
		//hacemos un redirect a la vista correspondiente del usuario logueado
		header("location: ../index.php");
		die;
	}else{
		$errores[]= "Error autentificacion";
	}
	mysqli_free_result($result);
	mysqli_close($conn);
}

header("Location: ../ingreso.php?errores=".urlencode(json_encode($errores)));

?>