<?php
	session_start(['read_and_close'=>true]);
	
	require_once 'utils/usuario-tipos.php';
	if(!sessionEsAdministracion()){
		header('Location: ingreso.php');
		die;
	}
    
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/usuarios.css"/>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<title>Administración de Usuarios</title>	   
</head>

<script>
	function confirmAlert(){
		return confirm("Desea eliminar el usuario?");
	}
</script>
<body>
<?php
    require_once 'template/header.php';
    require_once 'template/navs/administracion.php';
    require_once 'template/breadcrumbs.php';
    echo userBreadcrumbs();
?>

<h1 class="title_list">Listado de Usuarios</h1>     

<div class="container_search">  
    <div class="search_box">
        <form action="" method="GET">
            <div class="search">
                <input type="text" class="searchTerm" placeholder="Buscar por nombre o legajo" name="search">
                <button type="submit" class="btn_search">
                    <i class="fas fa-search" data-title="Buscar" ></i>  
                </button>     
            </div>
        </form>
    </div> 
</div>    
    
<div class="container_table">    
<table class="table">    
    <thead>
        <tr>
            <th><b>Legajo</b></th>
            <th><b>Nombre Completo</b></th>
            <th><b>Nivel de Acceso</b></th>
            <th><b>Correo Electrónico</b></th>
            <th></th>
            <th></th>
        </tr>
    </thead>    
    <tbody>
        <?php

require_once 'utils/DAOs/usuarioDAO.php';
require_once 'utils/usuario-tipos.php';
        
$offset=$_GET["offset"]??0;

if (isset($_GET["search"]) && ($search=trim($_GET["search"]))!=""){
    $usuarios = UsuarioDAO::search($search,$offset);
}else{
    $search=''; // * Para que más abajo no genere un error al incrustarlo en las URL de navegación.
    $usuarios = UsuarioDAO::selectAll($offset);
}

$hayMas=false;

        foreach ($usuarios as $i=> $usuario) {
            if($i==10){ // * Índice 10 = item 11
                $hayMas=true;
                continue;
            }
            ?> 
            <tr>
                <td data-label="Legajo"><?= ($usuario['legajo']); ?></td>
                <td data-label="Nombre Completo"><?= ($usuario['nombre_completo']) ?></td>
                <td data-label="Nivel de Acceso"><?= numeroANombreUsuarioTipo($usuario['tipo_id']) ?></td>
                <td data-label="Correo Electrónico"><?= ($usuario['correo']) ?></td>
                <td data-label="Editar"> <div class="buttons">
                    <form action="form_usuarios.php" method="get">                        
                        <input type="submit" value="Editar" class="button_actions"></input>  
                        <input type="hidden" value="<?=$usuario['id']?>" name="id">
                    </form>
                </td>        
                <td data-label="Eliminar">
                    <form action="controladores/usuarios.php" method="post">
                        <input type="submit" value="Eliminar" onclick='return confirmAlert()' name="delete" class="button_actions"></input>  
                        <input type="hidden" value="<?=$usuario['id']?>" name="id">
                    </form>
                </td>    
            </tr>
<?php } ?>
    </tbody>
    <tfoot><tr><td colspan="6"><div class="botones-navegacion">
    <a class="fas fa-angle-left" data-title="Pagina Anterior"<?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
    <a class="fas fa-angle-right" data-title="Pagina Siguiente"<?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
    </div></td></tr></tfoot>
</table>
<!-- TODO crear usuarios de 0?? -->
<a href="form_usuarios.php" class="button_add">Cargar Usuario</a>
</div>
</div>
<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>
<?php require_once 'template/footer.php'; ?>
</body>
</html>