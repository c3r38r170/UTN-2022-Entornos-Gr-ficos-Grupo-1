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
    echo misConsultasBreadcrumbs();
?> 
    

<h1 class="title_list">Mis Consultas</h1>     

<?php

 if(isset($_GET["success"])){
	$success = json_decode(urldecode($_GET['success']),true);
    echo "<span id='success'>$success</span>"; 
 }

    $offset=isset($_GET['offset'])?0:(int)$_GET['offset'];
 
    if (sessionEsEstudiante())
        $cons = getStudentCon($offset,11);
    elseif(sessionEsProfesor())
        $cons = getTeacherCon($offset,11);

    $hayMas=false;
    if(sessionEsEstudiante() && empty($cons))
     echo '<span id="success" style="color:red">Aún no estás inscripto en ninguna consulta</span>';
    foreach ($cons as $i=> $row) {
        if($i==10){ // * índice 10 es elemento 11
            $hayMas=true;
            break;
        }
       $instance = getInst($row['id']); 
?> 

         <?php 
          if(sessionEsEstudiante()) 
            require 'student_card.php'; 
          elseif(sessionEsProfesor())  
            require 'teacher_card.php'; 
          ?>       
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