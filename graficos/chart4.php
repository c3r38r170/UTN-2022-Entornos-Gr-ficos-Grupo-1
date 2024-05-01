<?php
//session_start(['read_and_close'=>true]);
require_once 'utils/usuario-tipos.php';
if(!sessionEsAdministracion()){
    header('Location: index.php');
    die;
}
require_once 'controladores/panel-control.php';

$consultas = [];
$selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
if ($selectedYear !== null) {
    $consultas = getConsultasPorMess($selectedYear);
}
else{
    $consultas = getConsultasPorMes();
}
?>
<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);

function drawChart() {
        <?php if (empty($consultas)) { ?>
            document.getElementById('linechart').innerHTML = '<p>No hay consultas.</p>';
        <?php } else { ?>
    var data = google.visualization.arrayToDataTable([
      ['Estados', 'Consultas'],
      <?php
      foreach ($consultas as $estado) {
        echo "['" . $estado['mes'] . "', " . $estado['cantidad'] . "],";
      }
      ?>
    ]);

    var options = {
      title: 'Cantidad de consultas solicitadas a lo largo de los meses',
      curveType: 'function', 
      legend: { position: 'bottom' },
      hAxis: {format: '0'}, 
      vAxis: {format: '0'}  
    };

    var chart = new google.visualization.LineChart(document.getElementById('linechart'));
    chart.draw(data, options);
    <?php } ?>
      }
</script>
