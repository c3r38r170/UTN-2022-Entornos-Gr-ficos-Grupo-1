<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/panel-controlDAO.php'));

function countAlumnos(){
   return PanelDAO::countAlumnos();
}

function countDocentes(){
    return PanelDAO::countDocentes();
 }

function getConsultasMaterias(){
    return PanelDAO::getConsultasMaterias();
}

function getConsultasMateriass($year){
   return PanelDAO::getConsultasMateriass($year);
}

function getConsultasComisiones(){
   return PanelDAO::getConsultasComisiones();
}

function getConsultasComisioness($year){
   return PanelDAO::getConsultasComisioness($year);
}

function getEstadosConsultas(){
   return PanelDAO::getEstadosConsultas();
}

function getConsultasPorMes(){
   return PanelDAO::getConsultasPorMes();
}

function getConsultasPorMess($year){
   return PanelDAO::getConsultasPorMess($year);
}


function countConsultasPorAnio($year){
   return PanelDAO::countConsultasPorAnio($year);
}

?>