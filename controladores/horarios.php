<?php


if(!is_uploaded_file($_FILES['file']['tmp_name'])){
	header("Location: ../horarios.php?errores=".urlencode(json_encode(["No se ha seleccionado ningún archivo."])));
	die;
}

require_once '../libs/SimpleXLSX.php';

if( $excel=Shuchkin\SimpleXLSX::parse($_FILES['file']['tmp_name'],false) ){
	$rows=$excel->rows();
	
	define('LEGAJO',0); // * Equivalente en JS: const LEGAJO = 0;
	define('NOMBRE_COMPLETO_PROFESOR',1); // Esto debería ser UNIQUE en la base de datos
	define('MATERIA',2);
	define('COMISION',3);
	define('DIA',4);
	define('HORA_DESDE',5);
	define('HORA_HASTA',6);
	define('AULA',7);

	date_default_timezone_set('America/Argentina/Buenos_Aires');	
	$date=date('Y/m/d/');

	foreach ($rows as $i=>$row){
		if($i==0) // * Títulos
			continue;
	
		$legajo=trim($row[LEGAJO]);
		$profesorID=$db
			->prepared("SELECT `id`,`nombre_completo` FROM `usuarios` WHERE `legajo` = ?",[$legajo]);
		if($profesorID){
			$profesor=$profesorID->fetch_assoc();

			$profesorID=$profesor['id'];

			if($profesor['nombre_completo']!=$row[NOMBRE_COMPLETO_PROFESOR]){
				$db->prepared("UPDATE `usuarios` SET `nombre_completo` = ? WHERE `id` = ?",[$profesor['nombre_completo'],$profesorID]);
			}
		}else{
			$db->prepared(
				"INSERT INTO usuarios (
					`nombre_completo`
					,`correo`
					,`legajo`
					,`contrasenia`
					,`tipo_id`
				) VALUES (
					?
					,''
					,?
					,".password_hash($legajo,PASSWORD_DEFAULT)."
					,2
				)"
				,[
					$row[NOMBRE_COMPLETO_PROFESOR]
					,$legajo
				]
			);
			$profesorID=$db->insert_id();
		}
	
		$comision=$row[COMISION];
		$nuevaComision=false;
		$comisionID=$db
			->prepared("SELECT id FROM comision WHERE numero = ?",[$comision]);
		if($comisionID){
			$comisionID=$comisionID->fetch_assoc()['id'];
		}else{
			$db->prepared(
				"INSERT INTO comision (
					`numero`
				) VALUES (
					?
				)"
				,[
					$comision
				]
			);
			$comisionID=$db->insert_id();
			$nuevaComision=true;
		}
		
		$materia=$row[MATERIA];
		$nuevaMateria=false;
		$materiaID=$db
			->prepared("SELECT id FROM materia WHERE nombre = ?",[$materia]);
		if($materiaID){
			$materiaID=$materiaID->fetch_assoc()['id'];
		}else{
			$db->prepared(
				"INSERT INTO materia (
					`nombre`
				) VALUES (
					?
				)"
				,[
					$materia
				]
			);
			$nuevaMateria=true;
			$materiaID=$db->insert_id();
		}
			
		if(
			$nuevaComision
			|| $nuevaMateria
			// ! Definición de $comisionMateriaID
			|| !( $comisionMateriaID=$db->query("SELECT id FROM materia_x_comision WHERE materia_id=$materiaID AND comision_id=$comisionID") )
		){
			$db->query("INSERT INTO `materia_x_comision` (`materia_id`,`comision_id`) VALUES ($materiaID,$comisionID)");
			$comisionMateriaID=$db->insert_id();
		}else{
			$comisionMateriaID=$comisionMateriaID->fetch_assoc()['id'];
		}
		
		$res=$db->prepared(
			"INSERT INTO `consultas` (
				materia_x_comision_id
				, profesor_id
				, hora_desde
				, aula
				, hora_hasta
				, dia_de_la_semana
				, fecha
			)
				VALUES (
					$comisionMateriaID
					,$profesorID
					,?
					,?
					,?
					,?
					,?
				)"
			,[
				$row[HORA_DESDE]
				,$row[AULA]
				,$row[HORA_HASTA]
				,$row[DIA]
				,$date
			]
		);
	
		if(!$res){
			header("Location: ../horarios.php?errores=".urlencode(json_encode(["Ha ocurrido un problema. Intente nuevamente más tarde."])));
		}
	}
	
	header("Location: ../horarios.php?success=".urlencode("Horarios cargados exitosamente"));
}else header("Location: ../horarios.php?errores=".urlencode(json_encode(["Formato no compatible."])));	
