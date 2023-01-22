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
    <link rel="stylesheet" type="text/css" href="css/_consultas.css"/>
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

<?php

 if(isset($_GET["success"])){
	$success = json_decode(urldecode($_GET['success']),true);
    echo "<span id='success'>$success</span>"; 
 }

 
 if(isset($_GET["search"]) && ($search=trim($_GET["search"]))!=""){
    $offset=isset($_GET['offset'])?0:(int)$_GET['offset'];
    $cons = searchCon($search,$offset,11);
    $hayMas=false;
    foreach ($cons as $i=> $row) {
        if($i==10){ // * índice 10 es elemento 11
            $hayMas=true;
            break;
        }
       $subscribed = (isSubscribed($row['id'])); 
?> 
    <div class="container">
        <div class="card">
		    <div class="left-column">
                <h2 class="card_title">Materia</h2>            
                <h4> <!-- Materia --> <?php echo ($row['nombre']); ?> </h4>
                <h3 class="card_title"> <!-- Comision --> Comisión: <?php echo ($row['numero']); ?> </h3> 
			    <img src="img/consulta_icono_1.png" alt="Logo Consulta"></img>
		    </div>
		    <div class="right-column">
			    <h2> <!-- Docente --> Docente <?php echo ($row['nombre_completo']); ?> </h2>
                <h3>Información básica</h3>
			    <p>
                    <span><!-- Fecha --> Fecha: </span> <?php echo getWeekDate($row['dia_de_la_semana']); ?>
                    </br> 
                    <span><!-- Horario --> Horario: </span> <?php echo ($row['hora_desde']). ' hs'; ?>
                    </br> 
                    <span><!-- Aula --> Aula: </span> <?php echo ($row['aula']); ?>
                </p>                                
                <form action="controladores/consultas.php" method="post" id="btns_form">
                    <button class="button_info">Más información</button>                                
                    <input type="hidden" value="<?=$row['id']?>" name="id">  
                    <button class="button_ins" name=<?php echo $subscribed ? 'cancel' : 'ins'?>><?php echo $subscribed ? 'Cancelar Inscripcion' : 'Inscribirse'?></button>                            			    
                </form>        
		    </div>            
	    </div>
    </div>           
<?php } 
?>
<!-- TODO URIencode search -->
    <a class="fas fa-angle-left" <?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
    <a class="fas fa-angle-right" <?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
<?php
}
?>



<?php //require_once 'template/footer.php'; ?>
</body>
</html>