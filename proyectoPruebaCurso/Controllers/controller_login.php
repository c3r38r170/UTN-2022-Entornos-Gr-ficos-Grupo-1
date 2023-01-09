<?php
include ("./Config/connection.php");

//validamos si se presiono el boton de login
if(!empty($_POST["btn_login"])){

    $user = $_POST["legajo"];
    $password = $_POST["password"];
    $error = 0;
    
    if(empty($user)){
        echo "El campo Legajo esta vacio";
        $error++;
    }else{
    if(!ctype_digit($user)){
        echo "El campo Legajo debe ser numerico";
        $error++;
    }
    }
    if(empty($password)){
        echo "El campo Contraseña esta vacio";
        $error++;
    }

    if($error == 0){

        $query="SELECT*FROM usuario where legajo='$user' and contrasenia='$password'";
        //ejecuto consulta
        $result=mysqli_query($conn,$query);
        //tomo las cantidad de filas que devolvio la consulta
        $rows=mysqli_num_rows($result);

        //validamos si devolvio una fila
        if($rows > 0){
            //hacemos un redirect a la vista correspondiente del usuario logueado
            header("location:index.php");
        }else{
            echo "Error autentificacion";
        }
        mysqli_free_result($result);
        mysqli_close($conn);
    }
}
?>