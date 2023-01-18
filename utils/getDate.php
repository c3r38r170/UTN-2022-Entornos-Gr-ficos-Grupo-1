<?php

//Esta funcion te devuelve la fecha más proxima a partir de un día de la semana dado
//El día se representa mediante un entero, siendo el Lunes el día 1 de la semana

$days = array('Lunes' => 1, 'Martes' => 2, 'Miercoles' => 3, 'Jueves' => 4, 'Viernes' => 5, 'Sabado' => 6, 'Domingo' => 7);


function getWeekDate($day){
    
    global $days;
    $day = $days[$day];     
    $dayofweek = date('w', strtotime(date('Y-m-d H:i:s')));
    if($day < $dayofweek)
        $result = date('Y-m-d', strtotime((($day+7) - $dayofweek).' day', strtotime(date('Y-m-d H:i:s'))));
    else
        $result = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime(date('Y-m-d H:i:s'))));
     
    return $result; 
}


?>