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

?>