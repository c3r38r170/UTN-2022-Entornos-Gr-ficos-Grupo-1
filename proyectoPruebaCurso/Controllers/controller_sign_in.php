<?php
include ("./Config/connection.php");

if(isset($_POST["btn_sign_in"])){

    $user = $_POST["legajo"];
    $password = $_POST["password"];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $mail = $_POST['mail'];
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
    if(empty($name)){
        echo "El campo Nombre esta vacio";
        $error++;
    }else{
        if(!ctype_alpha($name)){
            echo "El campo Nombre debe contener solo letras";
            $error++;
        }
    }
    if(empty($surname)){
        echo "El campo Apellido esta vacio";
        $error++;
    }else{
        if(!ctype_alpha($surname)){
            echo "El campo Apellido debe contener solo letras";
            $error++;
        }
    }
    if(empty($mail)){
        echo "El campo Mail esta vacio";
        $error++;
    }else{
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            echo "El mail es invalido";
            $error++;
        }
    }

    if($error == 0){
        $query_validate_user = "SELECT * FROM usuario WHERE legajo='$user' or mail= '$mail'";

        $result_validate_user=mysqli_query($conn,$query_validate_user);

        if($result_validate_user->num_rows > 0){
            echo "Ya se encuentra registrado un usuario con las caracteristicas ingresadas";
        }else{

            //consulta para registrar el usuario ya verificado
            $query_insert_user = "INSERT INTO usuario(legajo, nombre, apellido, mail, contrasenia) VALUES ('$user','$name','$surname','$mail','$password')";
        
             $result_insert_user=mysqli_query($conn,$query_insert_user);
        
            if($result_insert_user){
                //notificamos mediante una alerta que se registro con exito y redireccionamos al home
                $sms = "Usuario registrado correctamente";
                echo "<script>";
                echo "alert('$sms');";  
                echo "window.location = 'index.php';";
                echo "</script>"; 
            }else{
                echo "Error al registrar usuario";
            }
        }
    }
}
























/*

//validamos si se presiono el boton de registrarse
if(!empty($_POST["btn_sign_in"])){
    //validamos si los inputs estan vacios
    if (empty($_POST["legajo"]) or empty($_POST["password"]) or empty($_POST["name"]) or empty($_POST["surname"]) or empty($_POST["mail"])) {
        echo "Los campos estan vacios";
    } else {
        //guardamos los datos ingresados por el usuario en el sign in
        $user = $_POST["legajo"];
        $password = $_POST["password"];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $mail = $_POST['mail'];

        //consulta para validar que el usuario no este registrado previamente con legajo y mail ingresado
        $query_validate_user = "SELECT * FROM usuario WHERE legajo='$user' or mail= '$mail'";

        $result_validate_user=mysqli_query($conn,$query_validate_user);

        if($result_validate_user->num_rows > 0){
            echo "Ya se encuentra registrado un usuario con las caracteristicas ingresadas";
        }else{

            //consulta para registrar el usuario ya verificado
            $query_insert_user = "INSERT INTO usuario(legajo, nombre, apellido, mail, contrasenia) VALUES ('$user','$name','$surname','$mail','$password')";
        
            $result_insert_user=mysqli_query($conn,$query_insert_user);
        
            if($result_insert_user){
                echo "Usuario registrado correctamente";
            }else{
                echo "Error al registrar usuario";
          }
        }
    }
}
?>

*/