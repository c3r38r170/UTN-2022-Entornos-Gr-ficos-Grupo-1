<?php
//session_start(['read_and_close'=>true]);
require_once 'utils/usuario-tipos.php';
if(!sessionEsAdministracion()){
    header('Location: index.php');
    die;
}
require_once 'controladores/panel-control.php';
require_once 'controladores/materias.php';

$consultasMaterias = [];
$selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
$totalConsultas = null;
if ($selectedYear !== null) {
    $totalConsultas = countConsultasPorAnio($selectedYear);
    $consultasMaterias = getConsultasMateriass($selectedYear);
}
else{
    $consultasMaterias = getConsultasMaterias();
}

/*
$consultasMaterias = [];

if (isset($_GET['materia']) && !empty($_GET['materia'])) {
    $materiasSeleccionadas = $_GET['materia'];
    foreach ($materiasSeleccionadas as $materiaSeleccionada) {
        $consultasMaterias = array_merge($consultasMaterias, getConsultasMaterias($materiaSeleccionada, $selectedYear));
    }
} else {
    $consultasMaterias = getConsultasMateriass($selectedYear);
}
*/
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        <?php if (empty($consultasMaterias)) { ?>
            document.getElementById('piechart').innerHTML = '<p>No hay consultas.</p>';
        <?php } else { ?>
            var data = google.visualization.arrayToDataTable([
                ['Materia', 'Consultas'],
                <?php
                foreach ($consultasMaterias as $materia) {
                    echo "['" . $materia['nombre'] . "', " . $materia['cantidad'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Cantidad de alumnos que han solicitado consulta por materia'
            };
            
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        <?php } ?>
    }
</script>



