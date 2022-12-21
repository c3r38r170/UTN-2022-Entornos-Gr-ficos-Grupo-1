<?php
echo '<div class="menu">
        <img class="logo" src="../img/utn_icono 1.png" alt="">
        <h2 class="title_logo">UTN Frro</h2>    
        <nav id="menu">
            <input type="checkbox" id="responsive-menu" onclick="updatemenu()"><label></label>
            <ul>
                <li><a href="http://">Ingresar</a></li>
                <li><a href="http://">Registrarse</a></li>
                <li><a href="http://">Consultas</a></li>
                <li><a class="dropdown-arrow" href="http://">Products</a>
            <ul class="sub-menus">
                <li><a href="http://">Products 1</a></li>
                <li><a href="http://">Products 2</a></li>
                <li><a href="http://">Products 3</a></li>
                <li><a href="http://">Products 4</a></li>
            </ul>
                </li>
                <li><a href="http://">Sobre Nosotros</a></li>    
            </ul>
        </nav>
    </div>'
?>