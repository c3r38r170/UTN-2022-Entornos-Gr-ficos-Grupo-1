<?php

require_once(dirname(__DIR__,1) . '\db.php');

function search($cons){    

    $db=new MysqliWrapper();

    $sql = "SELECT u.nombre_completo, mat.nombre, com.numero, c.hora_desde, c.hora_hasta, c.dia_de_la_semana, c.aula FROM consultas c INNER JOIN materia_x_comision mc ON mc.id=c.materia_x_comision_id INNER JOIN comision com ON com.id=mc.comision_id INNER JOIN materia mat ON mat.id=mc.materia_id INNER JOIN usuarios u ON u.id=c.profesor_id WHERE u.nombre_completo LIKE ? OR mat.nombre LIKE ? OR com.numero LIKE ?";      

    $rs_result = $db->prepared($sql,['%'.$cons.'%','%'.$cons.'%','%'.$cons.'%']);
    $consult = $rs_result->fetch_all(MYSQLI_ASSOC);
    
    mysqli_free_result($rs_result);
        
    return $consult;
}




?>