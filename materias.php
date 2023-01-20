<?php
	session_start(['read_and_close'=>true]);
	
	require_once 'utils/usuario-tipos.php';
	if(!sessionEsAdministracion()){
		header('Location: ingreso.php');
		die;
	}

require_once 'controladores/materias.php';

if(isset($_POST['btn_search'])){
	$nameMateria = $_POST['search_materia'];
	$materias = searchMaterias($nameMateria);
}
else{
	$materias = getAllMaterias();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/materias.css"/>
    <title>Listado Materias</title>
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
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/adminitracion.php';
		require_once 'template/breadcrumbs.php'; 
    echo matBreadcrumbs();	
?>

<h1 class="title_list">Listado de Materias</h1>

<div class="container_search">
    <div class="search_box">
        <form action="materias.php"  method="post">
            <input type="text" name="search_materia" placeholder="Ingresar nombre de la materia...">
			<button type="submit" name="btn_search" class="btn_search" ><i class="fas fa-search" data-title="Buscar" ></i></button>
        </form>
    </div>
</div>


   
<div class="container_table">
	<table class="table">
     	<thead>
     		<tr>
     	 		<th id="column_id">ID</th>
     	 		<th>Nombre</th>
     	 		<th id="edit"></th>           
     	 		<th id="delete"></th>
     		</tr>
     	</thead>
        <tbody>
            <?php foreach ($materias as $fila) { ?>
     	        <tr>
     	  	        <td data-label="ID"><?php echo ($fila["id"])?></td>
     	  	        <td data-label="Nombre"><?php echo ($fila["nombre"])?></td>
     	  	        <td data-label="Editar">
					   <form action="form_materias.php" method="get">
							<input type="hidden" value="<?php echo ($fila["id"])?>" name="id">
                        	<input type="hidden" value="<?php echo ($fila["nombre"])?>" name="name">
							<input type="submit" name="btn_update" value="Editar" class="button_actions"/>
						</form>
					</td>
     	  	        <td data-label="Eliminar">
						<form action="controladores/materias.php" method="post">
							<input type="hidden" value="<?php echo ($fila["id"])?>" name="id">
							<input type="submit" name="btn_delete" value="Eliminar" class="button_actions" onclick='return confirmAlert()' />
						</form>
					</td>
     	        </tr>
			<?php } ?>
        </tbody>
   </table>

   <a href="form_materias.php" class="button_add">Cargar Materia</a>

</div>

<?php require_once './template/footer.php'; ?>
</body>
</html>


