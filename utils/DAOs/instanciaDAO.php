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
            WHERE i.id=? AND ie.descripcion 
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

function addSubscriptor($idUser,$idInstance){
    $db=new MysqliWrapper();
    
    $vSql = "INSERT INTO suscripciones (estudiante_id,instancia_id) VALUES (?,?)";
    if(!$db->prepared($vSql,[$idUser,$idInstance])){
        throw new Exception("error");
    }    
}

function getSubscription($idUser,$idInstance){
    $db=new MysqliWrapper();
    
    $vSql = "SELECT * FROM suscripciones WHERE estudiante_id=? AND instancia_id=?";
	$rs_result = $db->prepared($vSql,[$idUser,$idInstance]); 
	$cons = $rs_result->fetch_array();
	 
	$rs_result->free();
		 
	return $cons;
} 

function deleteSubscription($idUser,$idInstance){
    $db=new MysqliWrapper();

    $subscribers = getSubscribers($idInstance);    

    $vSql = "DELETE FROM suscripciones WHERE estudiante_id=? AND instancia_id=?";
    $db->prepared($vSql,[$idUser,$idInstance]);

    if($subscribers > 1){
        deleteInstance($idInstance);                    
        ///TO DO: enviar mail al docente
    } 
        
}

function getSubscribers($idInstance){

    $db=new MysqliWrapper();

    $vSql = "SELECT COUNT(*) FROM suscripciones WHERE instancia_id=?";
    $rs_result =  $db->prepared($vSql,[$idInstance]);
    $arrows = $rs_result->fetch_array();     	 
	$rs_result->free();
		 
	return $arrows;    
}

function deleteInstance($idInstance){
    $db=new MysqliWrapper();
    $vSql = "DELETE FROM instancias WHERE id=?";
    $db->prepared($vSql,[$idInstance]);
}


?>