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
    <?php include_once 'graficos/chart1.php'; ?> 
    <?php include_once 'graficos/chart2.php'; ?> 
    <?php include_once 'graficos/chart3.php'; ?>
    <?php include_once 'graficos/chart4.php'; ?>  
    <style>
        .container {
            display: flex; 
            flex-wrap: wrap; 
            justify-content: center;
        }

        .graps {
            width: 600px;
            height: 400px;
        }

        @media screen and (max-width: 768px) {
            .graps {
                width: 100%; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="piechart" class="graps"></div>
        <div id="donutchart" class="graps"></div>
    </div>
    <div class="container">
        <div id="barchart" class="graps"></div>
        <div id="linechart" class="graps"></div>
    </div>
</body>
</html>