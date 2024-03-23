<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/panel-controlDAO.php'));

function countAlumnos(){
   return PanelDAO::countAlumnos();
}

function countDocentes(){
    return PanelDAO::countDocentes();
 }

 function countConsultas2024(){
    return PanelDAO::countConsultas2024();
 }

 function getConsultasMaterias(){
   return PanelDAO::getConsultasMaterias();
}

 if (isset($_GET['year'])) {
    $year = $_GET['year'];
    $count = PanelDAO::countConsultasPorAnio($year);
 } 

?>