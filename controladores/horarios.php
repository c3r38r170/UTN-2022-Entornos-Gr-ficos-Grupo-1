<?php


if(!is_uploaded_file($_FILES['file']['tmp_name'])){
	header("Location: ../horarios.php?errores=".urlencode(json_encode(["No se ha seleccionado ningún archivo."])));
	die;
}

require_once '../libs/SimpleXLSX.php';
require_once('../utils/db.php');
define('DR',$_SERVER['DOCUMENT_ROOT']);

move_uploaded_file($_FILES['file']['tmp_name'],DR.'/docs/horarios_ultimo.xlsx');

if( $excel=Shuchkin\SimpleXLSX::parse(DR.'/docs/horarios_ultimo.xlsx',false) ){
	$rows=$excel->rows();
	
	define('LEGAJO',0); // * Equivalente en JS: const LEGAJO = 0;
	define('NOMBRE_COMPLETO_PROFESOR',1); // Esto debería ser UNIQUE en la base de datos
	define('MATERIA',2);
	define('COMISION',3);
	define('DIA',4);
	define('HORA_DESDE',5);
	define('HORA_HASTA',6);
	define('AULA',7);
	define('ENLACE',8);

	foreach ($rows as $i=>$row){
		if($i==0) // * Títulos
			continue;
	
		$legajo=trim($row[LEGAJO]);
		$profesorID=$db
			->prepared("SELECT `id`,`nombre_completo` FROM `usuarios` WHERE `legajo` = ?",[$legajo]);
			
		if($profesorID && $profesorID->num_rows){
			$profesor=$profesorID->fetch_assoc();

			$profesorID=$profesor['id'];
			
			if($profesor['nombre_completo']!=$row[NOMBRE_COMPLETO_PROFESOR]){
				
				$db->prepared("UPDATE `usuarios` SET `nombre_completo` = ? WHERE `id` = ?",[$row[NOMBRE_COMPLETO_PROFESOR],$profesorID]);
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
					,'".password_hash($legajo,PASSWORD_DEFAULT)."'
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
		if($comisionID && $comisionID->num_rows){
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
			|| !( $comisionMateriaID=$db->query("SELECT id FROM materia_x_comision WHERE materia_id=$materiaID AND comision_id=$comisionID") )->num_rows
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
				, enlace 
			)
				VALUES (
					$comisionMateriaID
					,$profesorID
					,?
					,?
					,?
					,?
					,now()
					,?
				)"
			,[
				$row[HORA_DESDE]
				,$row[AULA]
				,$row[HORA_HASTA]?:NULL
				,$row[DIA]				
				,$row[ENLACE]
			]
		);
	
		if(!$res){
			header("Location: ../horarios.php?errores=".urlencode(json_encode(["Ha ocurrido un problema. Intente nuevamente más tarde."])));
			die;
		}
	}
	
	header("Location: ../horarios.php?success=".urlencode("Horarios cargados exitosamente"));
}else header("Location: ../horarios.php?errores=".urlencode(json_encode(["Formato no compatible."])));	
