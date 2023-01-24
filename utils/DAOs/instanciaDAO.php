<?php

function getInstance($id){
	$db=new MysqliWrapper();

	$vSql = "SELECT 
                 i.id, 
                 i.fecha, 
                 i.motivo, 
                 i.hora_nueva, 
                 i.cupo, i.enlace,
                 ie.descripcion 
            FROM instancias i  
            INNER JOIN instancias_estados ie 
            ON i.estado_id=ie.id 
            WHERE i.consulta_id=? AND ie.descripcion 
             NOT LIKE 
             'Finalizada'";
	$rs_result = $db->prepared($vSql,[$id]); 
	$cons = $rs_result->fetch_array();
	 
	$rs_result->free();
		 
	return $cons;
}

function createInstance($id){
    $db=new MysqliWrapper();
    $vSql = "INSERT INTO instancias (fecha, cupo, estado_id,consulta_id) VALUES (?,?,?,?)";
    
    date_default_timezone_set('America/Argentina/Buenos_Aires');    
    $date=date('Y/m/d/');
    
    $db->prepared($vSql,[$date,0,1,$id]);
    return $db->insert_id();
}


function deleteInstance($idInstance){
    $db=new MysqliWrapper();
    $vSql = "DELETE FROM instancias WHERE id=?";
    $db->prepared($vSql,[$idInstance]);
}


?>