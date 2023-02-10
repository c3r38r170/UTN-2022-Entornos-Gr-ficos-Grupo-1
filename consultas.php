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
 
  if(isset($_GET["error"])){
    echo "<span id='error'>".$_GET["error"]."</span>"; 
 } 

 $offset=$_GET['offset']??0;

 if(isset($_GET["search"]) && ($search=trim($_GET["search"]))!=""){
    $cons = searchCon($search,$offset,11);
 }else{
    $search='';
    $cons = /* sessionEsProfesor()?
        teacherConAssigned($offset)
        : */getAll($offset);
 }       
       
    $hayMas=false;
    foreach ($cons as $i=> $row) {
        if($i==10){ // * índice 10 es elemento 11
            $hayMas=true;
            break;
        }       
       $instance = getInst($row['id']); 
?> 
       <div class="container">
        <div class="card">
		    <div class="left-column">
                <h2 class="card_title">Materia</h2>            
                <h4> <!-- Materia --> <?=($row['nombre'])?> </h4>
                <h3 class="card_title"> <!-- Comision --> Comisión: <?=($row['numero'])?> </h3> 
			    <img src="img/consulta_icono_1.png" alt="Logo Consulta"></img>
		    </div>
		    <div class="right-column">
			    <h2> <!-- Docente --> Docente <?=($row['nombre_completo'])?> </h2>
                <h3>Información básica</h3>
			    <p>                    
                    <span><!-- Fecha --> Fecha: </span> <?=$instance['fecha']??getWeekDate($row['dia_de_la_semana'])?>
                    </br> 
                    <span><!-- Horario --> Horario: </span> <?=substr($instance['hora_nueva']??$row['hora_desde'],0,5) . ' hs'?>
                    </br> 
                    <span><!-- Aula --> Aula: </span> <?=$instance['aula_nueva']??$row['aula']?> 
                    <div class="more-info" id="more-info">
                      <span><!-- Estado --> Estado: </span> <?=$instance['descripcion']??'Pendiente' ?>  
                      </br>
                      <span><!-- Modalidad --> Modalidad: </span> <?=$row['enlace']??'Presencial' ?>  
                      </br>
                      <?php if(isset($row['enlace'])){?>
                      <span><!-- Enlace --> Enlace: </span> <a href="<?= $row['enlace']?>"> <?=$row['enlace'] ?> </a>   
                      </br>
                      <?php } ?>
                      <?php if(isset($instance['motivo'])){?>
                      <span><!-- Motivo --> Motivo: </span> <?=$instance['motivo'] ?>   
                      </br>
                      <?php } ?>
                      <?php if(isset($instance) && $_SESSION['tipo'] == UsuarioTipos::PROFESOR){?>
                        <a id="subs" href=<?="subscribers.php?id=".$instance['id']?>>Ver estudiantes suscritos</a>                                                    
                      <?php }?>
                    </div>                   
                </p> 
                <div id="btns_form">
                    <!-- TODO está bueno pero ¿vale la pena? -->
                    <button class="button_info" id="btn_info" name="btn_info" >Más información</button>
                    <?php
                    // TODO administrador: editar?
                        if(haIngresado()){
                            switch ($_SESSION['tipo']) {
                            case UsuarioTipos::ESTUDIANTE:
                                $subscribed = (isSubscribed($row['id']));
                            ?>
                            <form action="controladores/consultas.php" method="post">                                                             
                                <input type="hidden" value="<?=$row['id']?>" name="id">  
                                <button class="button_ins" name=<?=$subscribed ? 'cancel' : 'ins'?> ><?=$subscribed ? 'Cancelar Inscripcion' : 'Inscribirse'?></button>                            			    
                            </form>
                            <?php
                                break;
                            case UsuarioTipos::PROFESOR:
                                // if($instance){
                            ?>                                                                
                            <form action="controladores/consultas.php" method="post">                                                             
                                <input type="hidden" value="<?=$row['id']?>" name="id">     
                                <!-- TODO usar constantes como en UsuarioTipos, InstanciaEstados o algo así -->
                                <button
                                    class="button_ins"
                                    name="confirm"
                                    value=<?=$instance['id']??0?>
                                    <?=(isset($instance['estado']) && $instance['estado']=="Confirmada") ? 'disabled' : ''?>
                                >
                                    <?=(isset($instance['estado']) && $instance['estado']=="Confirmada") ? 'Confirmada' : 'Confirmar Consulta' ?>
                                </button>                            			    
                            </form>
                            <?php 
                                // }
                                break;
                            }
                        }else{
                    ?>
                        <a href="ingreso.php"><button class=button_ins>Ingresá para inscribirte</button></a>
                    <?php
                        }
                    ?>
                </div>       
		    </div>            
	    </div>
    </div>
<?php } 
?>



<!-- TODO URIencode search -->
<div class="botones-navegacion">
    <a class="fas fa-angle-left" data-title="Pagina Anterior"<?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
    <a class="fas fa-angle-right" data-title="Pagina Siguiente"<?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
</div>    
<script>
    
    btn_info = document.getElementsByClassName('button_info');    
    div_info = document.querySelectorAll('.more-info');

    // TODO sacar script en linea, hacer una sola funcion
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
<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>
<?php //require_once 'template/footer.php'; ?>
</body>
</html>