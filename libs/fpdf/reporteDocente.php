<?php

require('./fpdf.php');
require_once '../../utils/usuario-tipos.php';
if(!sessionEsAdministracion()){
    header('Location: index.php');
    die;
}
require_once '../../controladores/panel-control.php';

$bloqueos = [];
$consultas = [];
$consultasVirPres = [];
$consultasCambios = [];
$selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
if (isset($_GET['docente']) && !empty($_GET['docente'])) {
    $docenteSeleccionado = $_GET['docente'];
    $bloqueos = getBloqueosPorDocentes($selectedYear, $docenteSeleccionado);
    $consultas = getBloquedasVsConfirmadas($selectedYear, $docenteSeleccionado);
    $consultasVirPres = getVirtualesVsPresenciales($selectedYear, $docenteSeleccionado);
    $consultasCambios = getCambiosConsultas($selectedYear, $docenteSeleccionado);

} else {
    $bloqueos = getBloqueosPorDocentes($selectedYear, $docenteSeleccionado = null);
    $consultas = getBloquedasVsConfirmadas($selectedYear, $docenteSeleccionado = null);
    $consultasVirPres = getVirtualesVsPresenciales($selectedYear, $docenteSeleccionado = null);
    $consultasCambios = getCambiosConsultas($selectedYear, $docenteSeleccionado = null);

}
class PDF extends FPDF
{
   private $selectedYear;
       // Constructor
       function __construct()
       {
           parent::__construct();
           $this->selectedYear = isset($_GET['year']) ? $_GET['year'] : null; // Asigna el valor del año
       }
   
}

//Pag1
$pdf = new FPDF();
$pdf->AddPage();
$pdf->AliasNbPages(); 

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); // colorBorde

$pdf->SetTextColor(37, 150, 226);
$pdf->Cell(50); // mover a la derecha
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, utf8_decode("Reporte de Bloqueos de Consultas por Profesor en {$selectedYear}"), 0, 1, 'C', 0);
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0); 

$pdf->MultiCell(180, 4, utf8_decode('En este informe, se analizan las estadísticas de bloqueos de consultas por profesor durante el año. Los bloqueos de consultas son momentos en los que los profesores no están disponibles para atender consultas de los estudiantes, ya sea por compromisos previos, descanso programado u otras razones.'), 0, 'L');
$pdf->Ln(1);
$pdf->MultiCell(180, 4, utf8_decode('Esta herramienta mide el comportamiento y las tendencias de los docentes en relación con sus disponibilidades y compromisos. Al analizar los motivos detrás de los bloqueos, así como la anticipación o retraso con la que se realizan, se puede obtener una visión clara de cómo se gestiona el tiempo y se priorizan las actividades académicas. Sin embargo, cabe mencionar que en algunos casos, pueden surgir imprevistos que generan retrasos en estas acciones.'), 0, 'L');
$pdf->Ln(7);

if (empty($bloqueos)) {
   $pdf->Cell(0, 10, 'No hay datos disponibles', 0, 1, 'C');
} else {

$pdf->SetFillColor(37, 150, 226); // colorFondo
$pdf->SetTextColor(255, 255, 255); // colorTexto
$pdf->SetDrawColor(0, 0, 0); // colorBorde
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(60, 10, utf8_decode('Motivo Bloqueo'), 1, 0, 'C', 1);
$pdf->Cell(35, 10, utf8_decode('Docente'), 1, 0, 'C', 1);
$pdf->Cell(30, 10, utf8_decode('Fecha Consulta'), 1, 0, 'C', 1);
$pdf->Cell(30, 10, utf8_decode('Fecha Bloqueo '), 1, 0, 'C', 1);
$pdf->Cell(35, 10, utf8_decode('Días Transcurridos'), 1, 1, 'C', 1);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);


foreach ($bloqueos as $bloqueo) {
    
    // Guardar la posición actual
    $xPos = $pdf->GetX();
    $yPos = $pdf->GetY();
    
    // Calcular el número de líneas necesarias para el motivo de bloqueo
    $motivoBloqueoLines = ceil($pdf->GetStringWidth($bloqueo['motivo bloqueo']) / 60);
    
    // Calcular la altura necesaria para el motivo de bloqueo
    $motivoBloqueoHeight = $motivoBloqueoLines * 5; // 10 es la altura de cada línea
    
    // MultiCell para el motivo de bloqueo
    $pdf->MultiCell(60, 5, utf8_decode($bloqueo['motivo bloqueo']), 1, 'L');
    
    // Restaurar la posición y establecer la altura de la siguiente celda
    $pdf->SetXY($xPos + 60, $yPos);
    $pdf->Cell(35, $motivoBloqueoHeight, utf8_decode($bloqueo['profesor']), 1, 0, 'C');
    $pdf->Cell(30, $motivoBloqueoHeight, utf8_decode($bloqueo['fecha consulta']), 1, 0, 'C');
    $pdf->Cell(30, $motivoBloqueoHeight, utf8_decode($bloqueo['fecha bloqueo consulta']), 1, 0, 'C');
    $pdf->Cell(35, $motivoBloqueoHeight, utf8_decode($bloqueo['dias transcurridos entre fechas']), 1, 1, 'C');
}
}


//Pag 2
$pdf->AddPage();
$pdf->AliasNbPages(); 

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); // colorBorde

$pdf->SetTextColor(37, 150, 226);
$pdf->Cell(50); // move to the right
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, utf8_decode("Reporte de Comparación de Consultas Bloqueadas y Confirmadas por Profesor en {$selectedYear}"), 0, 1, 'C', 0);
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0); 
$pdf->MultiCell(180, 4, utf8_decode('Este informe analiza las estadísticas de consultas bloqueadas y confirmadas por profesores durante el año. El objetivo es proporcionar una visión general de la eficacia de las consultas programadas y de las barreras encontradas por los estudiantes para acceder a la asistencia docente.'), 0, 'L');
$pdf->Ln(1);
$pdf->MultiCell(180, 4, utf8_decode('Este reporte proporciona una visión clara y precisa de la cantidad de consultas que han sido bloqueadas en relación con las que han sido confirmadas por cada docente en el período seleccionado. Esta información es importante para comprender el comportamiento de los docentes en el proceso de reserva de consultas y para tomar decisiones informadas sobre la gestión de las mismas.'), 0, 'L');
$pdf->Ln(7);

if (empty($consultas)) {
   $pdf->Cell(0, 10, 'No hay datos disponibles', 0, 1, 'C');
} else {

$pdf->SetFillColor(37, 150, 226); // colorFondo
$pdf->SetTextColor(255, 255, 255); // colorTexto
$pdf->SetDrawColor(0, 0, 0); // colorBorde
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(40, 10, utf8_decode('Docente'), 1, 0, 'C', 1);
$pdf->Cell(45, 10, utf8_decode('Consultas Confirmadas'), 1, 0, 'C', 1);
$pdf->Cell(45, 10, utf8_decode('Consultas Bloquedas'), 1, 0, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('Porcentaje'), 1, 1, 'C', 1);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);


foreach ($consultas as $consulta) {

   $pdf->Cell(40, 5, utf8_decode($consulta['profesor']), 1, 0, 'C');
   $pdf->Cell(45, 5, utf8_decode($consulta['cantidad consultas confirmadas']), 1, 0, 'C');
   $pdf->Cell(45, 5, utf8_decode($consulta['cantidad consultas bloqueadas']), 1, 0, 'C');
   $pdf->Cell(25, 5, utf8_decode($consulta['porcentaje bloquedas sobre confirmadas']), 1, 1, 'C');
}
}


//Pag 3
$pdf->AddPage();
$pdf->AliasNbPages(); 

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); // colorBorde

$pdf->SetTextColor(37, 150, 226);
$pdf->Cell(50); // mover a la derecha
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, utf8_decode("Reporte de Comparación de Consultas Confirmadas Virtuales y Presenciales por Profesor en {$selectedYear}"), 0, 1, 'C', 0);
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0); 
$pdf->MultiCell(180, 4, utf8_decode('El presente informe tiene como objetivo proporcionar una visión exhaustiva de las consultas confirmadas realizadas por profesores durante el año, discriminando entre aquellas llevadas a cabo de forma virtual y las presenciales. '), 0, 'L');
$pdf->Ln(1);
$pdf->MultiCell(180, 4, utf8_decode('Permite identificar la preferencia de los profesores por el tipo de consulta, brindando así información valiosa para comprender la dinámica de interacción docente-alumno en el entorno virtual versus el presencial.'), 0, 'L');
$pdf->Ln(7);

if (empty($consultasVirPres)) {
   $pdf->Cell(0, 10, 'No hay datos disponibles', 0, 1, 'C');
} else {

$pdf->SetFillColor(37, 150, 226); // colorFondo
$pdf->SetTextColor(255, 255, 255); // colorTexto
$pdf->SetDrawColor(0, 0, 0); // colorBorde
$pdf->SetFont('Arial', 'B', 10);


$pdf->Cell(35, 10, utf8_decode('Docente'), 1, 0, 'C', 1);
$pdf->Cell(70, 10, utf8_decode('Consultas Confirmadas Virtuales'), 1, 0, 'C', 1);
$pdf->Cell(70, 10, utf8_decode('Consultas Confirmadas Presenciales'), 1, 0, 'C', 1);


$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Ln();

foreach ($consultasVirPres as $consultaVirPres) {
   
    $pdf->Cell(35, 5, utf8_decode($consultaVirPres['profesor']), 1, 0, 'C');
    $pdf->Cell(70, 5, utf8_decode($consultaVirPres['cantidad virtuales']), 1, 0, 'C');
    $pdf->Cell(70, 5, utf8_decode($consultaVirPres['cantidad presenciales']), 1, 0, 'C');
    $pdf->Ln();
}
}

//Pag 4
$pdf->AddPage('L');
$pdf->AliasNbPages(); 

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); // colorBorde

$pdf->SetTextColor(37, 150, 226);
$pdf->Cell(50); // move to the right
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, utf8_decode("Reporte estadísticas de cambios de consultas por profesor en {$selectedYear}"), 0, 1, 'C', 0);
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0); 
$pdf->MultiCell(260, 4, utf8_decode('Este informe proporciona información sobre las modificaciones realizadas en las consultas agendadas por cada profesor dentro de un período de tiempo específico. Esta estadística revela patrones de cambios en las consultas, como los motivos más frecuentes de modificación, los días de la semana en los que se realizan más cambios, las horas de inicio más comunes de las consultas modificadas, entre otros aspectos. Ayuda a identificar tendencias y áreas de mejora en la gestión de las consultas.'), 0, 'L');
$pdf->Ln(7);

if (empty($consultasCambios)) {
   $pdf->Cell(0, 10, 'No hay datos disponibles', 0, 1, 'C');
} else {
    $pdf->SetFillColor(37, 150, 226); // colorFondo
    $pdf->SetTextColor(255, 255, 255); // colorTexto
    $pdf->SetDrawColor(0, 0, 0); // colorBorde
    $pdf->SetFont('Arial', 'B', 9);

    $pdf->Cell(40, 10, utf8_decode('Docente'), 1, 0, 'C', 1);
    $pdf->Cell(70, 10, utf8_decode('Motivo cambio'), 1, 0, 'C', 1);
    $pdf->Cell(20, 10, utf8_decode('Dia Semana'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, utf8_decode('Nuevo Dia Semana'), 1, 0, 'C', 1);
    $pdf->Cell(20, 10, utf8_decode('Hora Inicio'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, utf8_decode('Nueva Hora Inicio'), 1, 0, 'C', 1);
    $pdf->Cell(20, 10, utf8_decode('Aula'), 1, 0, 'C', 1);
    $pdf->Cell(20, 10, utf8_decode('Nueva Aula'), 1, 0, 'C', 1);
    $pdf->Cell(20, 10, utf8_decode('Estado'), 1, 1, 'C', 1);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 9);

    foreach ($consultasCambios as $cambios) {
        $pdf->Cell(40, 5, utf8_decode($cambios['profesor']), 1, 0, 'C');
        $pdf->Cell(70, 5, utf8_decode($cambios['motivo cambio consulta']), 1, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode($cambios['dia consulta']), 1, 0, 'C');
        $pdf->Cell(30, 5, utf8_decode($cambios['nuevo dia de consulta']), 1, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode($cambios['fecha inicio consulta']), 1, 0, 'C');
        $pdf->Cell(30, 5, utf8_decode($cambios['nueva fecha de inicio de consulta']), 1, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode($cambios['aula consulta']), 1, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode($cambios['aula nueva']), 1, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode($cambios['estado consulta']), 1, 1, 'C');
    }
}



$pdf->Output('reporteDocente.pdf', 'I'); // nombreDescarga, Visor(I->visualizar - D->descargar)







