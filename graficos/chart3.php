<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Estados', 'Consultas'],
      <?php
      $estados = getEstadosConsultas();
      foreach ($estados as $estado) {
        echo "['" . $estado['descripcion'] . "', " . $estado['cantidad'] . "],";
      }
      ?>
    ]);

    var options = {
      title: 'Cantidad de consultas de acuerdo a su estado',
      bars: 'vertical'
    };

    var chart = new google.visualization.BarChart(document.getElementById('barchart'));
    chart.draw(data, options);
  }
</script>
