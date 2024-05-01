<?php
session_start(['read_and_close'=>true]);
require_once 'utils/usuario-tipos.php';
if(!sessionEsAdministracion()){
    header('Location: index.php');
    die;
}
require_once 'template/header.php';
if(sessionEsAdministracion())
    require_once 'template/navs/administracion.php';
else if (sessionEsEstudiante())
    require_once 'template/navs/estudiante.php';
else if (sessionEsProfesor())
    require_once 'template/navs/profesor.php';
else require_once 'template/navs/landing.php';
require_once 'template/breadcrumbs.php'; 
echo panelBreadcrumbs();

require_once 'controladores/panel-control.php';
require_once 'controladores/materias.php';

include_once 'graficos/chart1.php'; 
include_once 'graficos/chart2.php'; 
include_once 'graficos/chart3.php'; 
include_once 'graficos/chart4.php'; 

$selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
$totalConsultas = null;
if ($selectedYear !== null) {
    $totalConsultas = countConsultasPorAnio($selectedYear);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/panel.css">
    <link rel="stylesheet" type="text/css" href="css/contacto.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Panel de control</title>
</head>
<body>
<?php

$cardInfo = [
    ['count' => countAlumnos(), 'title' => 'Alumnos activos', 'icon' => 'fa-users'],
    ['count' => countDocentes(), 'title' => 'Docentes activos', 'icon' => 'fa-users'],
    ['count' => $totalConsultas, 'title' => 'Consultas solicitadas', 'icon' => 'fas fa-question-circle'],
];
?>
<div class="cards">
    <?php foreach ($cardInfo as $card): ?>
        <div class="card">
            <div class="card-content">
                <div class="number"><?php echo $card['count']; ?></div>
                <div class="card-name"><?php echo $card['title']; ?></div>
                <?php if ($card['title'] === 'Consultas solicitadas'): ?>
                    <div>
                        <form method="GET" class="label-combo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <label for="year-select" class="label-c">Seleccione un año:</label>
                            <select class="combo-select" name="year">
                                <option value="2024" <?php if ($selectedYear == '2024') echo 'selected'; ?>>2024</option>
                                <option value="2023" <?php if ($selectedYear == '2023') echo 'selected'; ?>>2023</option>
                            </select>
                            <input type="submit" class="btn-total-c" value="Consultar">
                        </form>
                    </div>
                <?php endif; ?>
            </div>  
            <div class="icon-box">
                <i class="fa-solid <?php echo $card['icon']; ?>"></i>
            </div>  
        </div>
    <?php endforeach; ?>
</div>

<div class="max-container">
<div class="container-metricas">
        <div class="row-container">
            <div class="text-container">Estadísticas de Bloqueos de Consultas por Docentes</div>
            <button class="download-button">Descargar PDF</button>
        </div>
        <div class="row-container">
            <div class="text-container">Estadísticas de Motivos de Consultas por Alumnos</div>
            <button class="download-button">Descargar PDF</button>
        </div>
        <div class="row-container">
            <div class="text-container">Texto 3</div>
            <button class="download-button">Descargar PDF</button>
        </div>
</div>
</div>

<div class="container-g">
    <div class="container">
        <div class="graph-container">
            <div id="piechart" class="graps"></div>
            <button class="download-button-pdf"> Descargar</button>
        </div>
        <div class="graph-container">
        <div id="barchart" class="graps">
        </div>
        <button class="download-button-pdf"> Descargar</button>
    </div>
        <!-- 
        <div class="search-container">
            <form method="GET" class="label-combo-m" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="materia-select" class="label-c">Seleccione materia/s:</label>
                <select class="combo-select-m" name="materia[]" multiple> 
                    <?php
                    $materias = getAllMat();
                    foreach ($materias as $materia) {
                        ?>
                        <option value="<?php echo $materia['nombre']; ?>"><?php echo $materia['nombre']; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="submit" class="btn-total-m" value="Consultar">
            </form>
        </div>
                -->
    </div>
    <div class="container">
    <div class="graph-container">
        <div id="donutchart" class="graps"></div>
        <button class="download-button-pdf"> Descargar</button>
    </div>
    <div class="graph-container">
        <div id="linechart" class="graps"></div>
        <button class="download-button-pdf"> Descargar</button>
    </div>
</div>
<!--
<div class="container">
    <div class="graph-container">
        <div id="barchart" class="graps"></div>
    </div>
</div>
                -->
</div>

<?php require_once 'template/footer.php'; ?>
</body>
</html>
