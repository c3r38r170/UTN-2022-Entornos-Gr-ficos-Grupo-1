<?php
	session_start(['read_and_close'=>true]);
	
	require_once 'utils/usuario-tipos.php';
	if(!sessionEsAdministracion()){
		header('Location: index.php');
		die;
	}
    
require_once 'controladores/periodos.php';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/periodos.css">
	
	<title>Períodos de Actividad</title>

	<script>
		function confirmAlert(){
			return confirm("Desea eliminar el registro?");
		}

		function nuevoPeriodo(){
			let df=document.createElement('TR');
			document.querySelector('tbody').prepend(df);
			df.innerHTML=`
						<td>
							<input type=date name="inicio" form=nuevo required oninput="document.getElementById('fin').min=this.value">
							<span class=campos_requeridos></span>
						</td>
						<td>
							<input type=date name="fin" id="fin" form=nuevo required>
							<span class=campos_requeridos></span>
						</td>
						<td>
							<form action="controladores/periodos.php" id=nuevo method="post">
								<input class="button_actions" type=submit value="Añadir" name=crear>
							</form>
						</td>
			`;

			document.getElementById('nuevoPeriodo').disabled = true;
		}
	</script>
</head>
<body>
	<?php
			require_once 'template/header.php';
			require_once 'template/navs/administracion.php';
			require_once 'template/breadcrumbs.php';

			echo generateBreadcrumbs(
				[array("link" => "administrador.php","text" => "Home"), array("link" => "#","text" => "Períodos de Actividad")]
			);
	?>

	<h1 class="title_list">Listado de Períodos</h1>     

	<button data-title="Agregar" class="fas fa-plus button_actions" onclick="nuevoPeriodo()" id=nuevoPeriodo></button>
			
	<div class="container_table">    
		<table class="table" id=tabla>    
				<thead>
						<tr>
								<th id="column_id"><b>Inicio</b></th>
								<th><b>Fin</b></th>
								<th id="delete"></th>
						</tr>
				</thead>    
				<tbody>
		<?php

			$offset=$_GET["offset"]??0;

			$periodos=PeriodoControlador::obtenerTodos();

			$hayMas=false;

					foreach ($periodos as $i=>$row) {
							if($i==10){ // * Índice 10 = item 11
									$hayMas=true;
									continue;
							}
		?> 
							<tr>
									<td data-label="Inicio"><?php echo ($row['inicio']); ?></td>
									<td data-label="Fin"><?php echo ($row['fin']); ?></td>
									<td data-label="">
											<form action="controladores/periodos.php" method="post">
												<input type="hidden" name="inicio" value="<?=$row['inicio']?>">
												<input type="hidden" name="fin" value="<?=$row['fin']?>">
												<input type="submit" value="Eliminar" onclick='return confirmAlert()' name="delete" class="button_actions">
											</form>
									</td>    
							</tr>
		<?php } ?>
				</tbody>
				<tfoot><tr><td colspan="4"><div class="botones-navegacion">
					<a class="fas fa-angle-left" data-title="Pagina Anterior"<?=$offset?"href=\"?search=$search&offset=".($offset-10)."\"":""?> ></a>
					<a class="fas fa-angle-right" data-title="Pagina Siguiente"<?=$hayMas?"href=\"?search=$search&offset=".($offset+10)."\"":""?> ></a>
				</div></td></tr></tfoot>
		</table>
	</div>
	<script src="https://kit.fontawesome.com/f452b46f6c.js" crossorigin="anonymous"></script>
	<?php  require_once 'template/footer.php'; ?>
</body>
</html>