<?php
//session_start(['read_and_close'=>true]);
require_once 'utils/usuario-tipos.php';
if(!sessionEsAdministracion()){
    header('Location: index.php');
    die;
}
require_once 'controladores/panel-control.php';
require_once 'controladores/comisiones.php';

$comisiones = [];
$selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
if ($selectedYear !== null) {
    $comisiones = getConsultasComisiones($selectedYear);
}
else{
    $comisiones = getConsultasComisiones($selectedYear = null);
}
?>
<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        <?php if (empty($comisiones)) { ?>
            document.getElementById('donutchart').innerHTML = '<p>No hay consultas.</p>';
        <?php } else { ?>
        var data = google.visualization.arrayToDataTable([
            ['Comisiones', 'Consultas'],
          <?php
      foreach ($comisiones as $comision) {
          echo "['" . $comision['numero'] . "', " . $comision['cantidad'] . "],";
      }
      ?>
        ]);

        var options = {
          title: 'Cantidad de alumnos que han solicitado consulta por comisión',pieHole: 0.4,
        };


        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
        <?php } ?>
      }
      
    </script>

