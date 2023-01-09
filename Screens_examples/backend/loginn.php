<?php

include 'conection.inc';

session_start();

extract($_REQUEST);
$psw = md5($psw);

$vSql = "SELECT * FROM usuarios WHERE legajo='$legajo' AND password='$psw'";
$vResultado = mysqli_query($link, $vSql);
$total_registros=mysqli_num_rows($vResultado);
  
if ($total_registros == 1) { 
    $fila = mysqli_fetch_array($vResultado);       
    $_SESSION['id'] = $fila['id'];
    $_SESSION['rol'] = $fila['rol'];
    header('Location: /TP_Entornos/frontend/index.php');
  } else {    
    echo "Nombre de usuario o contraseña incorrectos";
  }
mysqli_free_result($vResultado);
mysqli_close($link);
?>
