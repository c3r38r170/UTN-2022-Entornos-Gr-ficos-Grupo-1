<?php
session_start(['read_and_close'=>true]);
	
require_once 'utils/usuario-tipos.php';
if(!sessionEsProfesor()){
	header('Location: ingreso.php');
	die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/form_consultas.css"/>
	
<?php 

require_once 'template/header.php';
require_once 'template/navs/profesor.php';
require_once 'template/breadcrumbs.php'; 
echo formConsBreadcrumbs();

$consultaID=(int)$_GET['id'];

require_once 'utils/DAOs/consultaDAO.php';
require_once 'utils/DAOs/instanciaDAO.php';

$consulta=ConsultaDAO::getByID($consultaID);
$instancia=InstanciaDAO::getInstance($consultaID);

if($consulta['profesor_id'] != $_SESSION['id']){
	header('Location: profesor.php');
	die;
}

require_once 'utils/getDate.php';

?>

	<script>							
        function validate(){    			
				let newDate = {date: (document.getElementById('fecha-hora').value).split('T')[0],
											hour: (document.getElementById('fecha-hora').value).split('T')[1],
											reason : (document.getElementById('motivo').value),
											blocking: (document.getElementById('blocking').checked)
										};														
				let oldDate = { date: "<?= isset($instancia['id']) ? $instancia['fecha_consulta'] : getWeekDate($consulta['dia_de_la_semana']) ?>",
												hour: "<?= isset($instancia['id']) ? $instancia['hora_nueva'] : $consulta['hora_desde']?>".substr(0, 5),
												reason: "<?= isset($instancia['motivo']) ? $instancia['motivo'] : ''?>"};
	
				
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
	

	<title>Consulta</title>	
</head>
<body>
<div class="formulario">
	<form action="controladores/consultas.php" class="form" method="post" onsubmit="return validate()">
		<input type="hidden" value="<?=$instancia['id']??0?>" name="id">
		<input type="hidden" value="<?=$consulta['id']?>" name="consultaID">
		<h2 class="form_titulo">Consulta</h2>            
		<p class="form_parrafo"> <?=$consulta['nombre_materia']?> </p>
		<div class="formulario_contenedor">

			<!-- TODO qué hacemos con el hora_hasta? -->
			
			<div class="formulario_grupo">
				<input
					type="datetime-local"
					id="fecha-hora"
					name="fecha-hora"
					class="form_input"
					placeholder=""
					value="<?= ($instancia['fecha_consulta'] ?? getWeekDate($consulta['dia_de_la_semana'])).' '.($instancia['hora_nueva'] ?? $consulta['hora_desde'] ) ?>" 
					min="<?=getWeekDate($consulta['dia_de_la_semana'])."T00:00"?>" 
					max="<?=getSaturday(getWeekDate($consulta['dia_de_la_semana']))."T23:00"?>"
					required
				>
				<label for="fecha" class="form_label">Fecha</label>
			</div>

			<div class="formulario_grupo">
				<input type="text" id="aula" name="aula" class="form_input" placeholder="" value="<?= $instancia['aula_nueva'] ?? $consulta['aula'] ?>" required>
				<label for="aula" class="form_label">Aula</label>
			</div>
			<?php
				$virtual=(bool)($instancia['enlace']??$consulta['enlace']);
			?>
			<div class="formulario_grupo <?= ($virtual) ? 'mostrar-enlace' : '' ?>" id="mod" >
				<!-- TODO estilos de select -->
				<select id="modalidad" class="form_input" required>
					<option value="" disabled>Elija modalidad</option>
					<option value="0" <?= (!$virtual) ? "selected" : "" ?>>Presencial</option>
					<option value="1" <?= ($virtual) ? "selected" : "" ?>>Virtual</option>
				</select>
				<script>
					document.getElementById('modalidad').oninput=function(){
						this.parentNode.classList[(+this.value)?'add':'remove']('mostrar-enlace');
					};
				</script>
			</div>
			<div class="formulario_grupo" style="display:none;">
				<input type="text" id="enlace" name="enlace" class="form_input" placeholder="" value="<?= $instancia['enlace'] ?? $consulta['enlace']?:'' ?>">
				<label for="enlace" class="form_label">Enlace</label>
			</div>
			<div class="formulario_grupo">
				<!-- TODO DRY de esta configuración, tamaño predeterminado del cupo. Hoy aparece acá y en el DAO de instancias -->
				<input
					type="number"
					id="cupo"
					name="cupo"
					class="form_input"
					placeholder=""
					value="<?= $instancia['cupo'] ?? 5 ?>"
					required
					min="0"
				>
				<label for="cupo" class="form_label">Cupo</label>
					<small>En caso de no ingresar un numero se asume que la consulta tiene cupo ilimitado</small>
			</div>

			<label for="motivo" class="form_label">Motivo</label>
			<div class="formulario_grupo">
				<textarea name="motivo" id="motivo" rows="10" cols="50" value=""><?= $instancia['motivo'] ?? '' ?></textarea>
				<span class="form_linea"></span>
				<small>En caso de bloquear o modificar la fecha/horario de la consulta, deberá indicar el motivo del cambio</small>
			</div>
			
			<div>
				<input data-title="Una consulta bloqueada impide a los estudiantes inscribirse a la misma" type="checkbox" name="blocking" id="blocking" <?= $instancia['descripcion']=='Bloqueada' ? 'checked' : ""?>>    
				<label for="blocking" class="form_label">Bloquear Consulta</label><br/>
			</div>

			<input
				type="submit"
				value="Guardar Cambios"
				name="edit"
				class="form_submit"
				required
			>
			<!-- TODO volver a la búsqueda de donde se vino. Conservar search y offset -->
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
	
<?php require_once 'template/footer.php'; ?>
</body>
</html>