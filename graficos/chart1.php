<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Materia', 'Consultas'],
          <?php
      $materias = getConsultasMaterias();
      foreach ($materias as $materia) {
          echo "['" . $materia['nombre'] . "', " . $materia['cantidad'] . "],";
      }
      ?>
        ]);

        var options = {
          title: 'Cantidad de alumnos que han solicitado consulta por materia'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>