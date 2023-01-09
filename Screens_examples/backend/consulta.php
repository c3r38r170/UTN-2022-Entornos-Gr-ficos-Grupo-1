<?php

function consultarUsuario($id){
    include 'conection.inc';
    
    $vSql = "SELECT * FROM usuarios WHERE id='$id'";
    $vResultado = mysqli_query($link, $vSql);
    $user = mysqli_fetch_array($vResultado);
    mysqli_free_result($vResultado);
    mysqli_close($link);
    return $user;
}

function deleteUser($id){
    include 'conection.inc';  
    $vSql = "DELETE FROM usuarios WHERE id='$id'";
    mysqli_query($link, $vSql) or die (mysqli_error($link));;
    mysqli_close($link);
}


if(isset($_POST['delete'])){
    deleteUser($_POST['id']);
    header('Location: /TP_Entornos/frontend/usuarios.php');
}
    


?>