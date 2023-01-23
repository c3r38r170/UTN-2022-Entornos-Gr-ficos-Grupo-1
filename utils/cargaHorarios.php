
<?php
require_once '../utils/db.php';

define('LEGAJO',0); // const LEGAJO = 0;
// define('NOMBRE_COMPLETO_PROFESOR',1); // Esto debería ser UNIQUE en la base de datos
define('MATERIA',2);
define('COMISION',3);
define('DIA',4);
define('HORA_DESDE',5);
define('HORA_HASTA',6);
define('AULA',7);

function uploadFile($rows){
      
    $db=new MysqliWrapper(); 

	date_default_timezone_set('America/Argentina/Buenos_Aires');    
    $date=date('Y/m/d/');

	foreach ($rows as $i=>$row){
		if($i==0)
			continue;
	
		$profesorID=$db
			->prepared("SELECT id FROM usuarios WHERE legajo = ?",[$row[LEGAJO]])
			->fetch_assoc()['id'];
	
		$comisionID=$db
			->prepared("SELECT id FROM comision WHERE numero = ?",[$row[COMISION]])
			->fetch_assoc()['id'];			
		
		$materiaID=$db
			->prepared("SELECT id FROM materia WHERE nombre = ?",[$row[MATERIA]])
			->fetch_assoc()['id'];
			
		$comisionMateriaID=$db
			->query("SELECT id FROM materia_x_comision WHERE materia_id=$materiaID AND comision_id=$comisionID")
			->fetch_assoc()['id'];
			
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
	
		if(!$res)
			header("Location: ../horarios.php?error=".urlencode(json_encode("Ha ocurrido un problema")));
		else	
			header("Location: ../horarios.php?error=".urlencode(json_encode("Horarios cargados exitosamente")));
	
	}
}



?>