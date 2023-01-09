<?php

include 'conection.inc';

extract($_REQUEST);
$psw = md5($psw);

$vSql = "SELECT * FROM usuarios WHERE legajo='$legajo' AND password='$psw'";
$vResultado = mysqli_query($link, $vSql);
$total_registros=mysqli_num_rows($vResultado);

if ($total_registros == 1) { 
    echo "El usuario ya existe!";        
  }else{
    $vSql = "INSERT INTO usuarios (nombre,apellido,legajo,password, email, rol) values ('$nombre','$apellido','$legajo','$psw','$email', '$role')";    
    mysqli_query($link, $vSql) or die (mysqli_error($link));
    echo("El usuario fue registrado<br>");

  }
  mysqli_free_result($vResultado);
  mysqli_close($link);
  echo ("<A href='/TP_Entornos/frontend/index.php'>VOLVER AL INICIO</A>");





?>
