<?php

require('./fpdf.php');
require_once '../../utils/usuario-tipos.php';
if(!sessionEsAdministracion()){
    header('Location: index.php');
    die;
}
require_once '../../controladores/panel-control.php';

$suscripciones = [];
$ultimasSuscripciones = [];
$selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
if (isset($_GET['alumno']) && !empty($_GET['alumno'])) {
    $alumnoSeleccionado = $_GET['alumno'];
    $suscripciones = getAlumnosSuscripcioness($alumnoSeleccionado, $selectedYear);
    $ultimasSuscripciones = getAlumnosUltimasSuscripcioness($alumnoSeleccionado, $selectedYear);
} else {
    $suscripciones = getAlumnosSuscripciones($selectedYear);
    $ultimasSuscripciones = getAlumnosUltimasSuscripciones($selectedYear);

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
   // Cabecera de página
   function Header()
   {
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

$pdf = new FPDF();
$pdf->AddPage(); /* aquí entran dos para parámetros (orientación, tamaño)V->portrait H->landscape tamaño (A3, A4, A5, letter, legal) */
$pdf->AliasNbPages(); // muestra la página / y total de páginas

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); // colorBorde

$pdf->SetTextColor(37, 150, 226);
$pdf->Cell(50); // mover a la derecha
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, utf8_decode("Reporte de Inscripciones a Consulta por Alumno en {$selectedYear}"), 0, 1, 'C', 0);
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0); 

$pdf->MultiCell(180, 4, utf8_decode('El Reporte de Inscripciones a Consulta por Alumno en el año es esencial para comprender y abordar las necesidades individuales de los estudiantes.'), 0, 'L');
$pdf->Ln(1);
$pdf->MultiCell(180, 4, utf8_decode('Proporciona una instantánea detallada de las solicitudes de consulta, lo que permite identificar tendencias y patrones de comportamiento. Esta información ayuda a los docentes y administradores a ofrecer apoyo a los alumnos, promoviendo así su bienestar académico y tener conocimiento de cuales son las materias que más consulta necesita el alumno.'), 0, 'L');
$pdf->Ln(7);

if (empty($suscripciones)) {
   $pdf->Cell(0, 10, 'No hay datos disponibles', 0, 1, 'C');
} else {

$pdf->SetFillColor(37, 150, 226); // colorFondo
$pdf->SetTextColor(255, 255, 255); // colorTexto
$pdf->SetDrawColor(0, 0, 0); // colorBorde
$pdf->SetFont('Arial', 'B', 9);

$pdf->Cell(40, 10, utf8_decode('Alumno'), 1, 0, 'C', 1);
$pdf->Cell(35, 10, utf8_decode('Fecha Inscripcion'), 1, 0, 'C', 1);
$pdf->Cell(50, 10, utf8_decode('Materia'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('Comisión'), 1, 0, 'C', 1);
$pdf->Cell(40, 10, utf8_decode('Profesor'), 1, 1, 'C', 1);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);


foreach ($suscripciones as $suscripcion) {
    
    $pdf->Cell(40, 5, utf8_decode($suscripcion['alumno']), 1, 0, 'C');
    $pdf->Cell(35, 5, utf8_decode($suscripcion['fecha inscripcion']), 1, 0, 'C');
    $pdf->Cell(50, 5, utf8_decode($suscripcion['materia']), 1, 0, 'C');
    $pdf->Cell(20, 5, utf8_decode($suscripcion['comision']), 1, 0, 'C');
    $pdf->Cell(40, 5, utf8_decode($suscripcion['profesor']), 1, 1, 'C');
}
}


$pdf->AddPage();
$pdf->AliasNbPages(); // muestra la página / y total de páginas

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); // colorBorde

$pdf->SetTextColor(37, 150, 226);
$pdf->Cell(50); // move to the right
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, utf8_decode(" Reporte de Ultimas Inscripciones a Consulta por Alumno en {$selectedYear}"), 0, 1, 'C', 0);
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0); 
$pdf->MultiCell(180, 4, utf8_decode('El informe sobre las inscripciones más recientes a consultas por alumno ofrece un análisis actualizado de las solicitudes de consulta registradas por cada estudiante'), 0, 'L');
$pdf->Ln(1);
$pdf->MultiCell(180, 4, utf8_decode('Conocer las últimas fechas de consulta de los alumnos es esencial para realizar un seguimiento efectivo del progreso individual, identificar tendencias emergentes en las necesidades de los estudiantes y planificar adecuadamente los recursos de asesoramiento. '), 0, 'L');
$pdf->Ln(7);

if (empty($ultimasSuscripciones)) {
   $pdf->Cell(0, 10, 'No hay datos disponibles', 0, 1, 'C');
} else {

$pdf->SetFillColor(37, 150, 226); // colorFondo
$pdf->SetTextColor(255, 255, 255); // colorTexto
$pdf->SetDrawColor(0, 0, 0); // colorBorde
$pdf->SetFont('Arial', 'B', 9);

$pdf->Cell(40, 10, utf8_decode('Alumno'), 1, 0, 'C', 1);
$pdf->Cell(45, 10, utf8_decode('Última Fecha Inscripcion'), 1, 0, 'C', 1);
$pdf->Cell(50, 10, utf8_decode('Materia'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('Comisión'), 1, 0, 'C', 1);
$pdf->Cell(40, 10, utf8_decode('Profesor'), 1, 1, 'C', 1);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);


foreach ($ultimasSuscripciones as $ultimaSuscripcion) {

    $pdf->Cell(40, 5, utf8_decode($ultimaSuscripcion['alumno']), 1, 0, 'C');
    $pdf->Cell(45, 5, utf8_decode($ultimaSuscripcion['ultima fecha inscripcion']), 1, 0, 'C');
    $pdf->Cell(50, 5, utf8_decode($ultimaSuscripcion['materia']), 1, 0, 'C');
    $pdf->Cell(20, 5, utf8_decode($ultimaSuscripcion['comision']), 1, 0, 'C');
    $pdf->Cell(40, 5, utf8_decode($ultimaSuscripcion['profesor']), 1, 1, 'C');
}
}


$pdf->Output('reporteAlumno.pdf', 'I'); // nombreDescarga, Visor(I->visualizar - D->descargar)







