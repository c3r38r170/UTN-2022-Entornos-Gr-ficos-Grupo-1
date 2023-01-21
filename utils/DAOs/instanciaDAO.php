<?php

function getInstance($id){
	$db=new MysqliWrapper();

	$vSql = "SELECT * FROM instancias WHERE id=?";
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
?>