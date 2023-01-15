<?php
require_once 'controladores/comisiones.php';

if (isset($_GET["search"]) && $_GET["search"]!=""){
    $coms = searchCom($_GET["search"]);
}else{
    $coms = selectAll();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/formulario.css"/>
    <link rel="stylesheet" type="text/css" href="css/materias.css"/>
	<title>Document</title>	   
</head>

<script>
	function confirmAlert(){
		var rta = confirm("Desea eliminar el registro?");
		if(rta){
			return true;
		}else{
			return false;
		}
	}
</script>
<body>
<?php require_once 'template/header.php'; ?>
<?php
	require_once 'template/nav-function.php';
	nav([
		'Ingresar'=>'login.php'
		,'Registrarse'=>'registro.php'
		,'Consultas'=>'http://'
		,'Gestionar'=>[
			'Usuarios'=>'usuarios.php'
			,'Comisiones'=>'comisiones.php'
		]
		,'Sobre Nosotros'=>'contacto.php'
	]);
?>

<div class="container_search">  
    <div class="search_box">
        <form action="comisiones.php" method="GET">
            <div class="search">
                <input type="text" class="searchTerm" placeholder="Buscar por numero" name="search">
                <button type="submit" name="btn_search" class="btn_search">
                    <i class="fas fa-search" data-title="Buscar" ></i>
                </button>     
            </div>
        </form>
    </div> 
</div>    
    <h1 class="title_list">Listado de Comisiones</h1>     
<div class="container_table">    
<table class="table">    
    <thead>
        <tr>
            <td><b>Id</b></td>
            <td><b>Numero</b></td>
            <td></td>
            <td></td>
        </tr>
    </thead>    
    <tbody>
        <?php foreach ($coms as $row) { ?> 
            <tr>
                <td data-label="Id"><?php echo ($row['id']); ?></td>
                <td data-label="Nombre"><?php echo ($row['numero']); ?></td>
                <td data-label="Editar"> <div class="buttons">
                    <form action="form_comisiones.php" method="get">                        
                        <input type="submit" value="Editar" class="button_actions"></input>  
                        <input type="hidden" value="<?=$row['id']?>" name="id">
                        <input type="hidden" value="<?=$row['numero']?>" name="number">
                    </form>
                </td>        
                <td data-label="Eliminar">
                    <form action="controladores/comisiones.php" method="post">
                        <input type="submit" value="Eliminar" onclick='return confirmAlert()' name="delete" class="button_actions"></input>  
                        <input type="hidden" value="<?=$row['id']?>" name="id">                        
                    </form>
                </td>    
            </tr>
<?php } ?>
    </tbody>
</table>
<a href="form_comisiones.php" class="button_add">Cargar Comision</a>
</div>
</div>
<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>
<?php // require_once 'template/footer.php'; ?>
</body>
</html>