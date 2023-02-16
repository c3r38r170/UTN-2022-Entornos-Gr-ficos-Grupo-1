<?php
	session_start(['read_and_close'=>true]);
	
	require_once 'utils/usuario-tipos.php';
	if(!sessionEsAdministracion()){
		header('Location: index.php');
		die;
	}
    
require_once 'controladores/comisiones.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/comisiones.css">
	<title>Comisiones</title>	   
</head>

<script>
	function confirmAlert(){
		return confirm("Desea eliminar el registro?");

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
    require_once 'template/navs/administracion.php';
    require_once 'template/breadcrumbs.php'; 
    echo comBreadcrumbs();
?>

<h1 class="title_list">Listado de Comisiones</h1>     

<div class="container_search">  
    <div class="search_box">
        <form action="comisiones.php" method="GET">            
                <input type="text" class="searchTerm" placeholder="Buscar por numero" name="search">
                <button type="submit" name="btn_search" class="btn_search">
                    <i class="fas fa-search" data-title="Buscar" ></i>
                </button>                 
        </form>
    </div> 
</div>    
    
<div class="container_table">    
<table class="table">    
    <thead>
        <tr>
            <th id="column_id"><b>Id</b></th>
            <th><b>Numero</b></th>
            <th id="edit"></th>
            <th id="delete"></th>
        </tr>
    </thead>    
    <tbody>
        <?php
        
$offset=$_GET["offset"]??0;
// $limit=$_GET["offset"]??10;

if (isset($_GET["search"]) && ($search=trim($_GET["search"]))!=""){
    $coms = searchCom($search,$offset);
}else{
    $search=''; // * Para que más abajo no genere un error al incrustarlo en las URL de navegación.
    $coms = selectComs($offset);
}

$hayMas=false;

        foreach ($coms as $i=> $row) {
            if($i==10){ // * Índice 10 = item 11
                $hayMas=true;
                continue;
            }
            ?> 
            <tr>
                <td data-label="Id"><?php echo ($row['id']); ?></td>
                <td data-label="Numero"><?php echo ($row['numero']); ?></td>
                <td data-label="Editar"> 
                    <form action="form_comisiones.php" method="get">                        
                        <input type="submit" value="Editar" class="button_actions"> 
                        <input type="hidden" value="<?=$row['id']?>" name="id">
                        <input type="hidden" value="<?=$row['numero']?>" name="number">
                    </form>
                </td>        
                <td data-label="Eliminar">
                    <form action="controladores/comisiones.php" method="post">
                        <input type="submit" value="Eliminar" onclick='return confirmAlert()' name="delete" class="button_actions">  
                        <input type="hidden" value="<?=$row['id']?>" name="id">                        
                    </form>
                </td>    
            </tr>
<?php } ?>
    </tbody>
    <tfoot><tr><td colspan="4"><div class="botones-navegacion">
    <a class="fas fa-angle-left" data-title="Pagina Anterior"<?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
    <a class="fas fa-angle-right" data-title="Pagina Siguiente"<?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
    </div></td></tr></tfoot>
</table>
<a href="form_comisiones.php" class="button_add">Cargar Comision</a>
</div>
</div>
<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>
<?php  require_once 'template/footer.php'; ?>
</body>
</html>