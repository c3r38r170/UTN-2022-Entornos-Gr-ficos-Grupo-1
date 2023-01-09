<?php
require 'Config/connection.php';
include ("Template/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./Styles/search_consulta.css"/>
    <title>Consulta</title>
</head>
<body>
    <div class="container_search">
        <div class="search_box">
            <form>
                <button type="submit"><i class="fas fa-search"></i></button>
                <input type="text" placeholder="Ingresar materia..."/>
                <button type="submit"><i class="fas fa-microphone"></i></button>
            </form>
        </div>
    </div>
</body>
</html>


<?php
include ("Template/footer.php");
?>