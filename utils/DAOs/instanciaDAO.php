<?php

require_once(dirname(__DIR__,1) . '\getDate.php');

//Traemos solo aquellas instancias que correspondan a consultas vigentes
function getInstance($id){
	$db=new MysqliWrapper();
    
	$vSql = "SELECT 
                 i.id, 
                 i.fecha, 
                 i.motivo, 
                 i.hora_nueva, 
                 i.aula_nueva, 
                 i.cupo, 
                 i.enlace,
                 i.fecha_consulta,
                 ie.descripcion 
            FROM instancias i  
            INNER JOIN instancias_estados ie 
            ON i.estado_id=ie.id 
            WHERE i.consulta_id=? AND
            i.fecha_consulta>=CURDATE()";

	$rs_result = $db->prepared($vSql,[$id]); 
	$cons = $rs_result->fetch_array();
	 
	$rs_result->free();
		 
	return $cons;
}

//Al momento de crear la instancia, guardamos la fecha en la que se va a llevar a cabo la consulta
function createInstance($id){
    $db=new MysqliWrapper();

    $query = "SELECT dia_de_la_semana FROM consultas WHERE id=?";
    $rs_result = $db->prepared($query,[$id]);
    $day = mysqli_fetch_array($rs_result);
	$rs_result->free();

    $vSql = "INSERT INTO instancias (fecha, cupo, estado_id,consulta_id, fecha_consulta) VALUES (?,?,?,?,?)";
    
    date_default_timezone_set('America/Argentina/Buenos_Aires');    
    $date=date('Y/m/d/');
    
    $db->prepared($vSql,[$date,0,1,$id,getWeekDate($day['dia_de_la_semana'])]);
    return $db->insert_id();
}


function deleteInstance($idInstance){
    $db=new MysqliWrapper();
    $vSql = "DELETE FROM instancias WHERE id=?";
    $db->prepared($vSql,[$idInstance]);
}

function studentCon($id,$offset=0, $limit=10){
    $db=new MysqliWrapper();

    $sql =
    "SELECT
        c.id  
        , u.nombre_completo
        , mat.nombre
        , com.numero
        , c.hora_desde
        , c.hora_hasta
        , c.dia_de_la_semana
        , c.aula
    FROM consultas c
        INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
        INNER JOIN comision com ON com.id=mc.comision_id
        INNER JOIN materia mat ON mat.id=mc.materia_id
        INNER JOIN usuarios u ON u.id=c.profesor_id
        INNER JOIN instancias i ON i.consulta_id=c.id
        INNER JOIN suscripciones s ON s.estudiante_id=? AND s.instancia_id=i.id        
    WHERE i.fecha_consulta>=CURDATE()
    LIMIT $limit OFFSET $offset";

    $rs_result = $db->prepared($sql,[$id]);
    $consult = $rs_result->fetch_all(MYSQLI_ASSOC);
	
	$rs_result->free();
		
	return $consult;
}

function pendingTeacherCon($id,$offset=0, $limit=10){
    $db=new MysqliWrapper();

    $sql =
    "SELECT
        c.id  
        , u.nombre_completo
        , mat.nombre
        , com.numero
        , c.hora_desde
        , c.hora_hasta
        , c.dia_de_la_semana
        , c.aula
    FROM consultas c
        INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id
        INNER JOIN comision com ON com.id=mc.comision_id
        INNER JOIN materia mat ON mat.id=mc.materia_id
        INNER JOIN usuarios u ON u.id=c.profesor_id
        INNER JOIN instancias i ON i.consulta_id=c.id  
    WHERE i.fecha_consulta>=CURDATE() AND c.profesor_id=?
    LIMIT $limit OFFSET $offset";

    $rs_result = $db->prepared($sql,[$id]);
    $consult = $rs_result->fetch_all(MYSQLI_ASSOC);
	
	$rs_result->free();
		
	return $consult;

}

?>