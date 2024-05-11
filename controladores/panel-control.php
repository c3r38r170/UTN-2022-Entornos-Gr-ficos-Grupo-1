<?php

require_once(realpath(dirname(__FILE__) . '/../utils/DAOs/panel-controlDAO.php'));

function countAlumnos(){
   return PanelDAO::countAlumnos();
}

function countDocentes(){
    return PanelDAO::countDocentes();
 }

function countConsultasPorAnio($year){
   return PanelDAO::countConsultasPorAnio($year);
}

function getConsultasMaterias($year){
   return PanelDAO::getConsultasMaterias($year);
}

function getConsultasComisiones($year){
   return PanelDAO::getConsultasComisiones($year);
}

function getEstadosConsultas($year){
   return PanelDAO::getEstadosConsultas($year);
}

function getConsultasPorMes($year){
   return PanelDAO::getConsultasPorMes($year);
}

function getBloqueosPorDocentes($year, $docenteSeleccionado){
   return PanelDAO::getBloqueosPorDocentes($year, $docenteSeleccionado);
}

function getBloquedasVsConfirmadas($year, $docenteSeleccionado){
   return PanelDAO::getBloquedasVsConfirmadas($year, $docenteSeleccionado);
}

function getVirtualesVsPresenciales($year, $docenteSeleccionado){
   return PanelDAO::getVirtualesVsPresenciales($year, $docenteSeleccionado);
}

function getCambiosConsultas($year, $docenteSeleccionado){
   return PanelDAO::getCambiosConsultas($year, $docenteSeleccionado);
}

function getAlumnosSuscripciones($year, $alumnoSeleccionado){
   return PanelDAO::getAlumnosSuscripciones($year, $alumnoSeleccionado);
}

function getAlumnosUltimasSuscripciones($year, $alumnoSeleccionado){
   return PanelDAO::getAlumnosUltimasSuscripciones($year, $alumnoSeleccionado);
}

function getAllDocentes(){
   return PanelDAO::getAllDocentes();
}

function getAllAlumnos(){
   return PanelDAO::getAllAlumnos();
}

?>