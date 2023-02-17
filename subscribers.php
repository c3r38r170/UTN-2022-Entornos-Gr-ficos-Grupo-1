<?php
	session_start(['read_and_close'=>true]);
	
	require_once 'utils/usuario-tipos.php';
	if(!sessionEsProfesor()){
		header('Location: index.php');
		die;
	}
    
require_once 'controladores/consultas.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/comisiones.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<title>Suscripciones</title>	   
</head>
<body>
<?php
    require_once 'template/header.php';
    require_once 'template/navs/administracion.php';
    require_once 'template/breadcrumbs.php'; 
    echo subsBreadcrumbs();
?>

<h1 class="title_list">Listado de estudiantes suscritos a la consulta</h1>     
    
<div class="container_table">    
<table class="table">    
    <thead>
        <tr>
            <td><b>Nombre Completo</b></td>
            <td><b>Legajo</b></td>
            <td><b>Correo</b></td>            
        </tr>
    </thead>    
    <tbody>
        <?php
        
$offset=$_GET["offset"]??0;

$idInstance = $_GET['id'];

$subs = getSubs($idInstance,$offset);    



$hayMas=false;

        foreach ($subs as $i=> $row) {            
            if($i==10){ 
                $hayMas=true;
                continue;
            }
            ?> 
            <tr>
                <td data-label="Nombre Completo"><?php echo ($row['nombre_completo']); ?></td>
                <td data-label="Legajo"><?php echo ($row['legajo']); ?></td>
                <td data-label="Correo"><?php echo ($row['correo']); ?></td>                         
            </tr>
<?php } ?>
    </tbody>
    <tfoot><tr><td colspan="4"><div class="botones-navegacion">
    <a class="fas fa-angle-left" data-title="Pagina Anterior"<?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
    <a class="fas fa-angle-right" data-title="Pagina Siguiente"<?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
    </div></td></tr></tfoot>
</table>
</div>
</div>
<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>
<?php  require_once 'template/footer.php'; ?>
</body>
</html>