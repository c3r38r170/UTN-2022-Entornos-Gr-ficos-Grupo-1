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
	<title>Consultas</title>	   
</head>
<body>
<?php 
require_once 'template/header.php';
require_once 'utils/usuario-tipos.php';
    if(sessionEsAdministracion())
        require_once 'template/navs/administracion.php';
    else if (sessionEsEstudiante())
        require_once 'template/navs/estudiante.php';
    else if (sessionEsProfesor())
        require_once 'template/navs/profesor.php';
    else require_once 'template/navs/landing.php';
    require_once 'template/breadcrumbs.php'; 
    echo consultasBreadcrumbs();
?> 
    

<h1 class="title_list">Mis Consultas</h1>     

<?php

 if(isset($_GET["success"])){
	$success = json_decode(urldecode($_GET['success']),true);
    echo "<span id='success'>$success</span>"; 
 }
    $offset=isset($_GET['offset'])?0:(int)$_GET['offset'];
    $cons = getStudentCon($offset,11);
    $hayMas=false;
    if(empty($cons))
     echo '<span id="success" style="color:red">Aún no estás inscripto en ninguna consulta</span>';
    foreach ($cons as $i=> $row) {
        if($i==10){ // * índice 10 es elemento 11
            $hayMas=true;
            break;
        }
       $subscribed = (isSubscribed($row['id'])); 
       $instance = getInst($row['id']); 
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
                    <span><!-- Horario --> Horario: </span> <?php echo (($instance['hora_nueva']) ? $instance['hora_nueva'] : $row['hora_desde']). ' hs'; ?>
                    </br> 
                    <span><!-- Aula --> Aula: </span> <?php echo (($instance['aula_nueva']) ? $instance['aula_nueva'] : $row['aula']); ?> 
                    <div class="more-info" id="more-info">
                      <span><!-- Estado --> Estado: </span> <?php echo $instance['descripcion']; ?>  
                      </br>
                      <span><!-- Modalidad --> Modalidad: </span> <?php echo $instance['enlace'] ? 'Virtual' : 'Presencial'; ?>  
                      </br>
                      <?php if($instance['enlace']){?>
                      <span><!-- Enlace --> Enlace: </span> <a href="<?= $instance['enlace']?>"> <?php echo $instance['enlace'] ?> </a>   
                      </br>
                      <?php } ?>
                      <?php if($instance['motivo']){?>
                      <span><!-- Motivo --> Motivo: </span> <?php echo $instance['motivo'] ?>   
                      </br>
                      <?php } ?>
                    </div>                   
                </p> 
                <div id="btns_form">
                    <button class="button_info" id="btn_info" name="btn_info" >Más información</button>                                     
                    <form action="controladores/consultas.php" method="post">                                                             
                        <input type="hidden" value="<?=$row['id']?>" name="id">  
                        <button class="button_ins" name=<?php echo $subscribed ? 'cancel' : 'ins'?>><?php echo $subscribed ? 'Cancelar Inscripcion' : 'Inscribirse'?></button>                            			    
                    </form> 
                </div>       
		    </div>            
	    </div>
    </div>        
<!-- TODO URIencode search -->
    <a class="fas fa-angle-left" <?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
    <a class="fas fa-angle-right" <?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
<?php
}
?>

<script>
    
    btn_info = document.getElementsByClassName('button_info');    
    div_info = document.querySelectorAll('.more-info');

    for(let  i=0; i<btn_info.length; i++){
        btn_info[i].addEventListener('click', () =>{
            if(div_info[i].classList.contains('more-info')){
                 div_info[i].classList.remove('more-info');
                 btn_info[i].innerHTML="Menos información";
            }else{
                 div_info[i].classList.add('more-info');
                 btn_info[i].innerHTML="Más información";
            }
        })
    }
</script>

<?php //require_once 'template/footer.php'; ?>
</body>
</html>