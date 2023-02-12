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
	
	<link rel="stylesheet" type="text/css" href="css/ingreso.css"/>
	<link rel="stylesheet" type="text/css" href="css/form_consultas.css"/>

	<title>Document</title>	
</head>
<body>
<?php 

require_once 'template/header.php';
require_once 'template/navs/profesor.php';
require_once 'template/breadcrumbs.php'; 
generateBreadcrumbs([
	["link" => "profesor.php","text" => "Home"]
	,["link" => "consultas.php","text" => "Consultas"]
	,["link" => "#","text" => "Formulario Consultas"]
]);

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
<div class="formulario">
	<form action="controladores/consultas.php" class="form" method="post">
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
			<div class="formulario_grupo">
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
				<label for="modalidad">Modalidad</label>
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
					min="1"
				>
				<label for="cupo" class="form_label">Cupo</label>
			</div>
			<div class="formulario_grupo">
				<input type="text" id="motivo" name="motivo" class="form_input" placeholder="" value="<?= $instancia['motivo'] ?? '' ?>">
				<label for="motivo" class="form_label">Motivo del cambio (opcional)</label>
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