<?php
	session_start(['read_and_close'=>true]);
	
	require_once 'utils/usuario-tipos.php';
	if(!sessionEsAdministracion()){
		header('Location: index.php');
		die;
	}

    require_once 'controladores/panel-control.php';

?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
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
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
