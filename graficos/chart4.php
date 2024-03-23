<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Estados', 'Consultas'],
      <?php
      $estados = getConsultasPorMes();
      foreach ($estados as $estado) {
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
  }
</script>
