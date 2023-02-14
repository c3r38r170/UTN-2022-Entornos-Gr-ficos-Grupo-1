<?php
require_once 'controladores/consultas.php';
require_once 'utils/getDate.php';

session_start(['read_and_close'=>true]);
	
require_once 'utils/usuario-tipos.php';
if(!sessionEsAdministracion() && !sessionEsProfesor()){
	header('Location: ingreso.php');
	die;
}

extract($_REQUEST);
$con = getCon($id);
$instance = getInst($id); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/form_consultas.css"/>
	<title>Consulta</title>	
</head>
<body>
<?php 
    require_once 'template/header.php';
    require_once 'template/navs/administracion.php';
		require_once 'template/breadcrumbs.php'; 
    echo formConBreadcrumbs();    
?>

<div class="formulario">
        <form action="controladores/consultas.php" class="form" method="post" name="formCon" onsubmit="return validate()">
            <h2 class="form_titulo">Editar Consulta</h2>
            <p>En caso de bloquear o modificar la fecha/horario de la consulta, deberá indicar el motivo del cambio</p>            			
            <div class="formulario_contenedor">
                <div class="formulario_grupo">                     
                    <input type="number" id="cupo" name="cupo"  min=0 class="form_input" placeholder="" value="<?= $instance['cupo'] ?>">
                    <label for="" class="form_label">Cupo</label>
                    <span class="form_linea"></span>
                    <small>En caso de no ingresar un numero se asume que la consulta tiene cupo ilimitado</small>
                </div>
                <div class="formulario_grupo">                    
                    <input type="text" id="aula" name="aula"  class="form_input" placeholder="" value="<?= $con['aula'] ?>" >
                    <label for="" class="form_label">Aula</label>
                    <span class="form_linea"></span>
                </div>
                <div class="formulario_grupo">                    
                    <input type="text" id="enlace" name="enlace"  class="form_input" placeholder="" value="<?= $con['enlace'] ?>">
                    <label for="" class="form_label">Enlace</label>
                    <span class="form_linea"></span>
                    <small>En caso de no colocar un enlace se asume que la consulta es presencial</small>
                </div>
                <div class="formulario_grupo">                                        
                    <input type="datetime-local" id="datetime" name="datetime"  class="form_input" placeholder="" 
                    value="<?= $instance['fecha_consulta']."T".(isset($instance["hora_nueva"]) ? $instance["hora_nueva"] : $con['hora_desde']) ?>" 
                    min="<?=getWeekDate($con['dia_de_la_semana'])."T00:00"?>" 
                    max="<?=getSaturday(getWeekDate($con['dia_de_la_semana']))."T23:00"?>">
                    <label for="" class="form_label">Feha y Hora</label>
                    <span class="form_linea"></span>                     
                </div>                
                <label for="" class="form_label">Motivo</label>
                <div class="formulario_grupo">                                                        
                    <textarea name="motivo" id="motivo" rows="10" cols="50" value=""><?= isset($instance['motivo'])? $instance['motivo'] : ""?></textarea>                    
                    <span class="form_linea"></span>
                </div>                 
                <div>                                        
                  <input data-title="Una consulta bloqueada impide a los estudiantes inscribirse a la misma" type="checkbox" name="blocking" id="blocking" <?= $instance['descripcion']=='Bloqueada' ? 'checked' : ""?>>    
                  <label for="" class="form_label">Bloquear Consulta</label><br/>                  
                </div>                
                <input type="submit" value="Guardar" name="edit_con" class="form_submit" required>				                
				<input type="hidden" value="<?=$id?>" name="id">
                <input type="hidden" value="<?=$instance['id']?>" name="idInstance">                
				<p class="form_parrafo"><a href="consultas.php" class="form_link">Regresar al listado</a></p>
				  <?php
				  if(isset($_GET['error'])){
					$error=json_decode(urldecode($_GET['error']),true);
					echo "<span class=formulario_error>$error</span>";					  
				 }
				  if(isset($_GET["success"])){
					$success = $_GET['success'];
					echo "<span>$success</span>";
				}
			  	  ?>      			
            </div>
        </form>
    </div>   
<script>
function validate(){    
    let newDate = {date: (document.getElementById('datetime').value).split('T')[0],
                   hour: (document.getElementById('datetime').value).split('T')[1],
                   reason : (document.getElementById('motivo').value),
                   blocking: (document.getElementById('blocking').checked)
                };
               
    let oldDate = { date: "<?=$instance['fecha_consulta']?>",
                    hour: "<?=isset($instance) ? $instance['hora_nueva'] : $con['hora_desde']?>".substr(0, 5),
                    reason: "<?=$instance['motivo']?>"};
                    
    if((newDate.date != oldDate.date || newDate.hour != oldDate.hour) && newDate.reason.split(' ').join('') == ""){
        alert('Por favor ingrese el motivo del cambio');        
        return false;
    }
    
    if(newDate.reason != oldDate.reason && newDate.date == oldDate.date && newDate.hour == oldDate.hour && !newDate.blocking){
        alert('El ingreso de un motivo debe responder a un cambio de fecha/hora o bien a un bloqueo de la consulta');        
        return false;
    }

    if(newDate.blocking && newDate.reason.split(' ').join('') == ""){
        alert('Por favor ingrese el motivo del bloqueo de la consulta');        
        return false;
    }

    return true;       
}
</script>
<?php require_once 'template/footer.php'; ?>
</body>
</html>