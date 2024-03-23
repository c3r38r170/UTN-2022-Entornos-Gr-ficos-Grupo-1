<script type="text/javascript">
google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Comisiones', 'Consultas'],
          <?php
      $comisiones = getConsultasComisiones();
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
      }
    </script>

