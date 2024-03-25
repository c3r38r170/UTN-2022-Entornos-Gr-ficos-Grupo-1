<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/panel-controlDAO.php'));

function countAlumnos(){
   return PanelDAO::countAlumnos();
}

function countDocentes(){
    return PanelDAO::countDocentes();
 }

function getConsultasMaterias($materiasSeleccionadas){
    return PanelDAO::getConsultasMaterias($materiasSeleccionadas);
}

function getConsultasMateriass(){
   return PanelDAO::getConsultasMateriass();
}

function getConsultasComisiones(){
   return PanelDAO::getConsultasComisiones();
}

function getEstadosConsultas(){
   return PanelDAO::getEstadosConsultas();
}

function getConsultasPorMes(){
   return PanelDAO::getConsultasPorMes();
}

function countConsultasPorAnio($year){
   return PanelDAO::countConsultasPorAnio($year);
}

?>