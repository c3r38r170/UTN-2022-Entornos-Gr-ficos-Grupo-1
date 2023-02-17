<?php

require_once 'utils/usuario-tipos.php';
if (!sessionEsEstudiante()){
    header('Location: index.php');
}
require_once 'controladores/consultas.php';
require_once 'controladores/periodos.php';
require_once 'utils/getDate.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	    
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/_consultas.css">    
	<title>Consultas</title>	   
</head>
<body>
<?php 

require_once 'template/header.php';

require_once 'template/navs/estudiante.php';
require_once 'template/breadcrumbs.php'; 

echo misConsultasBreadcrumbs();

?> 
    <h1 class="title_list">Mis Consultas</h1>
<?php

$periodoActual=PeriodoControlador::periodoActual();
if(!$periodoActual){
    echo '<p id=success>Actualmente no se están dando clases de consulta.</p>';
}else{

 if(isset($_GET["success"]) && !empty($_GET["success"])){
	$success = urldecode($_GET['success']);
    echo "<span id='success'>$success</span>"; 
 }

 if(isset($_GET["error"]) && !empty($_GET["success"])){
    echo "<span id='error'>".urldecode($_GET["error"])."</span>"; 
 } 
 
    $offset=$_GET['offset']??0;

    $cons = getStudentCon($offset,11);
    if(empty($cons))
     echo '<span id="success" style="color:red">Aún no estás inscripto en ninguna consulta</span>';

    $hayMas=false;
    foreach ($cons as $i=> $consulta) {
        if($i==10){ // * índice 10 es elemento 11
            $hayMas=true;
            break;
        }
       $instance = getInst($consulta['id']);
       
        $fecha=$instance['fecha_consulta']??getWeekDate($consulta['dia_de_la_semana']);
        $dateFecha=date($fecha);
        if(
            $dateFecha < date($periodoActual['inicio'])
            || date($periodoActual['fin']) < $dateFecha
        ){
            continue;
        }
?> 

<div class="container">
    <div class="card">
        <div class="left-column">
            <h2 class="card_title">Materia</h2>
            <h4> <!-- Materia --> <?=$consulta['nombre_materia']?> </h4>
            <h3 class="card_title"> <!-- Comision --> Comisión: <?= ($consulta['numero_comision'])?> </h3> 
            <img src="img/consulta_icono_1.png" alt="Logo Consulta"></img>
        </div>
        <div class="right-column">
            <h2> <!-- Docente --> Docente <?= ($consulta['nombre_completo'])?> </h2>
            <h3>Información básica</h3>
            <p>
                <span><!-- Fecha --> Fecha: </span> <?= $fecha?>
                <br> 
                <span><!-- Horario --> Horario: </span> <?= (($instance['hora_nueva'])?? $consulta['hora_desde']). ' hs'?>
                <br> 
                <span><!-- Aula --> Aula: </span> <?= ($instance['aula_nueva'] ?? $consulta['aula'])?> 
                <div class="more-info" id="more-info">
                    <span><!-- Estado --> Estado: </span> <?=$instance['descripcion'] ?>  
                    <br>
                    <?php
                        $enlace=$instance['enlace']??$consulta['enlace'];
                        $virtual=!empty($enlace);
                    ?>
                    <span><!-- Modalidad --> Modalidad: </span> <?= $virtual ? 'Virtual' : 'Presencial'?>  
                    <br>
                    <?php if($virtual){?>
                    <span><!-- Enlace --> Enlace: </span> <a href="<?= $enlace?>"> <?= $enlace ?> </a>   
                    <br>
                    <?php } ?>
                </div>                   
            </p> 
            <div id="btns_form">
                <button class="button_info" id="btn_info" name="btn_info" >Más información</button>                                     
                <form action="controladores/consultas.php" method="post">                                                             
                    <input type="hidden" value="<?=$consulta['id']?>" name="id">  
                    <button class="button_ins" name=cancel>Cancelar Inscripcion</button>                            			    
                </form> 
            </div>       
        </div>            
    </div>
</div> 

<?php

}

if(!empty($cons)){

?>
<!-- TODO URIencode search -->
    <div class="botones-navegacion">
        <a class="fas fa-angle-left" <?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
        <a class="fas fa-angle-right" <?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
    </div> 
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
<?php
}
?>
<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>
<?php require_once 'template/footer.php'; ?>
</body>
</html>