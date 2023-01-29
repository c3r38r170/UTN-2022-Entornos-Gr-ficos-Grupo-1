<?php

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

    $vSql = "DELETE FROM suscripciones WHERE estudiante_id=? AND instancia_id=?";
    $db->prepared($vSql,[$idUser,$idInstance]);
  
}

function getSubscribers($idInstance){

    $db=new MysqliWrapper();

    $vSql = "SELECT COUNT(*) FROM suscripciones WHERE instancia_id=?";
    $rs_result =  $db->prepared($vSql,[$idInstance]);
    $arrows = $rs_result->fetch_array();     	 
	$rs_result->free();
		 
	return $arrows;    
}

function selectSubscriber($idInstance,$offset=0, $limit=10){
    $db=new MysqliWrapper();

    $vSql = "SELECT u.nombre_completo, u.legajo, u.correo FROM suscripciones s
             INNER JOIN usuarios u ON u.id=s.estudiante_id                 
             WHERE instancia_id=?
             LIMIT $limit OFFSET $offset";
    $rs_result =  $db->prepared($vSql,[$idInstance]);
    $arrows = $rs_result->fetch_all(MYSQLI_ASSOC);
	$rs_result->free();
		 
	return $arrows;    
}


?>