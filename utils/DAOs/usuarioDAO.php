<?php

function getUser($leg){

    $db=new MysqliWrapper();
    $sql = "SELECT * FROM usuarios where legajo= ?";
	$result = $db->prepared($sql,[$leg]);
    $user = $result->fetch_array();
    $result->free();
    
	return $user;
}


?>