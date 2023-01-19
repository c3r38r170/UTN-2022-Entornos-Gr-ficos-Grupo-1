<?php

require_once 'controladores/consultas.php';
require_once 'utils/getDate.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
    <link rel="stylesheet" type="text/css" href="css/materias.css"/>
	<title>Document</title>	   
</head>
<body>
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/landing.php';
    require_once 'template/breadcrumbs.php'; 
    echo consultasBreadcrumbs();
?>

<h1 class="title_list">Buscar Consultas</h1>     

<div class="container_search">  
    <div class="search_box">
        <form action="consultas.php" method="GET">
            <div class="search">
                <input type="text" class="searchTerm" placeholder="Buscar por Profesor, Materia o Comision" name="search">
                <button type="submit" class="btn_search">
                    <i class="fas fa-search" data-title="Buscar" ></i>
                </button>     
            </div>
        </form>
    </div> 
</div>    
 
<!-- TODO hacer un card para mostrar esta información -->
<?php if (isset($_GET["search"]) && ($search=trim($_GET["search"]))!=""){
    $offset=isset($_GET['offset'])?0:(int)$_GET['offset'];
    $cons = searchCon($search,$offset,11);
    $hayMas=false;
    foreach ($cons as $i=> $row) { 
        if($i==10){ // * índice 10 es elemento 11
            $hayMas=true;
            break;
        }
?> 
      <p>Docente: <?php echo ($row['nombre_completo']); ?> 
         Materia: <?php echo ($row['nombre']); ?> 
         Comision: <?php echo ($row['numero']); ?> 
         Fecha: <?php echo getWeekDate($row['dia_de_la_semana']); ?> 
         Horario: <?php echo ($row['hora_desde']). ' hs'; ?> 
         Aula: <?php echo ($row['aula']); ?> 
      </p>            
<?php }
?>
<!-- TODO URIencode search -->
    <a class="fas fa-angle-left" <?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
    <a class="fas fa-angle-right" <?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
<?php
}
?>

<?php // require_once 'template/footer.php'; ?>
</body>
</html>