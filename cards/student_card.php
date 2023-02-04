<?php
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
                    <span><!-- Horario --> Horario: </span> <?php echo ((isset($instance['hora_nueva'])) ? $instance['hora_nueva'] : $row['hora_desde']). ' hs'; ?>
                    </br> 
                    <span><!-- Aula --> Aula: </span> <?php echo ((isset($instance['aula_nueva'])) ? $instance['aula_nueva'] : $row['aula']); ?> 
                    <div class="more-info" id="more-info">
                      <span><!-- Estado --> Estado: </span> <?php echo isset($instance['descripcion']) ? $instance['descripcion'] : 'Pendiente'; ?>  
                      </br>
                      <span><!-- Modalidad --> Modalidad: </span> <?php echo isset($row['enlace']) ? 'Virtual' : 'Presencial'; ?>  
                      </br>
                      <?php if(isset($row['enlace'])){?>
                      <span><!-- Enlace --> Enlace: </span> <a href="<?= $row['enlace']?>"> <?php echo $row['enlace'] ?> </a>   
                      </br>
                      <?php } ?>
                      <?php if(isset($instance['motivo'])){?>
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