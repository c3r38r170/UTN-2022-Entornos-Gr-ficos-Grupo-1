<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" type="text/css" href="./Styles/menuPrincipal.css"/>
    <link rel="stylesheet" type="text/css" href="./Styles/login.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="contenedor">
            <div class="img"></div>
        </div>

        <div class="contenedor_menu">
        <input type="checkbox" id="btn-menu">
        <label for="btn-menu">
            <i class="fas fa-bars"></i>
        </label>
        <nav class="menu">
            <a href="#" class="enlace">
                <img src="./Img/logo-utn.png" alt="" class="logo">
            </a>
            <ul>
                <li><a href="index.php" tabindex="1">Inicio</a></li>
                <li><a href="login.php" tabindex="2">Ingresar</a></li>
                <li><a href="sign_in.php" tabindex="3">Regístrate</a></li>
                <li><a href="consulta.php" tabindex="4">Consulta</a></li>
                <li><a href="contact_us.php" tabindex="5">Sobre Nosotros</a></li>
            </ul>
        </nav>
        </div>
    </header>