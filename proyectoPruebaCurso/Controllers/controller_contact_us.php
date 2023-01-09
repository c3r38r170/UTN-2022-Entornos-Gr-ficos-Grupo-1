<?php

    if(isset($_POST["btn_contact"])){

        $to = "frangiangiordano@gmail.com";
        $name = $_POST["name"];
        $description = $_POST["description"];
        $mail = $_POST["mail"];
        $subject = "Consulta UTN Frro";

        $sms = $description."\n Atentamente: ".$name."\n Correo Electronico: ".$mail;

        if(mail($to, $subject, $sms)){
            echo "<script>alert('Consulta enviada exitosamente')</script>";
        }
        else{
            echo "<script>alert('Error! La consulta no fue enviada')</script>";
        }
    }
?>


