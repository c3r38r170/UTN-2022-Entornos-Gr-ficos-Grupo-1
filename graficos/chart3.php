<?php
//session_start(['read_and_close'=>true]);
require_once 'utils/usuario-tipos.php';
if(!sessionEsAdministracion()){
    header('Location: index.php');
    die;
}
require_once 'controladores/panel-control.php';

$estados = [];
$selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
if ($selectedYear !== null) {
    $estados = getEstadosConsultas($selectedYear);
}
else{
    $estados = getEstadosConsultas($selectedYear = null);
}
?>
<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
        <?php if (empty($estados)) { ?>
            document.getElementById('barchart').innerHTML = '<p>No hay consultas.</p>';
        <?php } else { ?>
    var data = google.visualization.arrayToDataTable([
      ['Estados', 'Consultas'],
      <?php
      foreach ($estados as $estado) {
        echo "['" . $estado['descripcion'] . "', " . $estado['cantidad'] . "],";
      }
      ?>
    ]);

    var options = {
      title: 'Cantidad de consultas de acuerdo a su estado',
      bars: 'vertical',
      legend: 'none'
    };

    var chart = new google.visualization.BarChart(document.getElementById('barchart'));
    chart.draw(data, options);
    <?php } ?>
      }
</script>
