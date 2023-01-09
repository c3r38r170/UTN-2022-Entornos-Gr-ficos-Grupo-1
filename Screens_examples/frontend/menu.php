<?php
$menu = '<div class="menu">
            <img class="logo" src="../img/utn_icono 1.png" alt="">
            <h2 class="title_logo">UTN Frro</h2>    
            <nav id="menu">
            <input type="checkbox" id="responsive-menu" onclick="updatemenu()"><label></label>
            <ul>';

if(isset($_SESSION['rol'])){                
    $menu .= '<li><a class="dropdown-arrow" href="http://">Mi cuenta</a>
    <ul class="sub-menus">
        <li><a href="registro.php">Editar Perfil</li>        
        <li><a href="../backend/logout.php">Cerrar sesion</a></li>        
    </ul>
            </li>';
    if($_SESSION['rol']==0){       
    }
}else{
    $menu .= '<li><a href="login.php">Ingresar</a></li>';
} 
$menu .= '  
        
        <li><a href="registro.php">Registrarse</a></li>
        <li><a href="http://">Consultas</a></li>
        <li><a class="dropdown-arrow" href="http://">Gestionar</a>
    <ul class="sub-menus">
        <li><a href="usuarios.php">Usuarios</a></li>
        <li><a href="carreras.php">Carreras</a></li>
        <li><a href="http://">Products 3</a></li>
        <li><a href="http://">Products 4</a></li>
    </ul>
        </li>
        <li><a href="http://">Sobre Nosotros</a></li>    
    </ul>
</nav>
</div>';

echo $menu;
?>