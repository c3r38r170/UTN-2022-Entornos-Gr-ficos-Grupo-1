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

function getEstadosConsultass($year){
   return PanelDAO::getEstadosConsultass($year);
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

function getBloqueosPorDocentes($year){
   return PanelDAO::getBloqueosPorDocentes($year);
}

function getBloqueosPorDocentess($docenteSeleccionado, $year){
   return PanelDAO::getBloqueosPorDocentess($docenteSeleccionado, $year);
}
function getAllDocentes(){
   return PanelDAO::getAllDocentes();
}

function getAllAlumnos(){
   return PanelDAO::getAllAlumnos();
}

function getBloquedasVsConfirmadas($year){
   return PanelDAO::getBloquedasVsConfirmadas($year);
}

function getBloquedasVsConfirmadass($docenteSeleccionado, $year){
   return PanelDAO::getBloquedasVsConfirmadass($docenteSeleccionado, $year);
}

function getVirtualesVsPresenciales($year){
   return PanelDAO::getVirtualesVsPresenciales($year);
}

function getVirtualesVsPresencialess($docenteSeleccionado, $year){
   return PanelDAO::getVirtualesVsPresencialess($docenteSeleccionado, $year);
}

function getCambiosConsultas($year){
   return PanelDAO::getCambiosConsultas($year);
}

function getCambiosConsultass($docenteSeleccionado, $year){
   return PanelDAO::getCambiosConsultass($docenteSeleccionado, $year);
}

function getAlumnosSuscripcioness($alumnoSeleccionado, $year){
   return PanelDAO::getAlumnosSuscripcioness($alumnoSeleccionado, $year);
}

function getAlumnosSuscripciones($year){
   return PanelDAO::getAlumnosSuscripciones($year);
}

function getAlumnosUltimasSuscripcioness($alumnoSeleccionado, $year){
   return PanelDAO::getAlumnosUltimasSuscripcioness($alumnoSeleccionado, $year);
}

function getAlumnosUltimasSuscripciones($year){
   return PanelDAO::getAlumnosUltimasSuscripciones($year);
}

?>