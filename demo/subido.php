<?php

if(!(isset($_FILES['archivo'])))
	header('Location: index.html?errores=["No subiste archivo, mondongo."]');


require_once 'SimpleXLSX.php';
if($excel=Shuchkin\SimpleXLSX::parse($_FILES['archivo']['tmp_name'],false) )
	$rows=$excel->rows();
else header('Location: index.html?errores=["No era un Excel, o algo así."]');


echo(json_encode($rows));
die;


require_once '../utils/db.php';


define('LEGAJO',0); // const LEGAJO = 0;
// define('NOMBRE_COMPLETO_PROFESOR',1); // Esto debería ser UNIQUE en la base de datos
define('MATERIA',2);
define('COMISION',3);
define('DIA',3);
define('HORA_DESDE',4);
define('HORA_HASTA',5);
define('AULA',6);

// $query='INSERT INTO consultas '

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
		)
			VALUES (
				$comisionMateriaID
				,$profesorID
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
		]
	);

	if(!$res){
		header('Location: index.html?errores=["Ha ocurrido un problema."]');
	}

}