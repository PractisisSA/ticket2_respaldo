<?php 
	include('../controlusuarios/seguridadbeBoletero.php');
	require_once('../classes/private.db.php');
	$gbd = new DBConn();
	$idcon = $_GET['id'];
	
	$card = 1;
	$dep = 2;
?>
<html>
	<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Forma', 'Pago'],
			["Tarjeta", <?php 
							$tarjeta = "SELECT pagopor FROM ocupadas WHERE concierto = ? AND pagopor = ?";
							$tar = $gbd -> prepare($tarjeta);
							$tar -> execute(array($idcon,$card));
							$numtar = $tar -> rowCount();
							echo $numtar;
						?>],
			["Deposito", <?php 
							$deposito = "SELECT pagopor FROM ocupadas WHERE concierto = ? AND pagopor = ?";
							$dpt = $gbd -> prepare($deposito);
							$dpt -> execute(array($idcon,$dep));
							$numdep = $dpt -> rowCount();
							echo $numdep;
						?>]
        ]);

        var options = {
			pieSliceText: 'label',
			title: 'Forma de pago de los boletos',
			titleTextStyle: { 	color: '#fff',
								fontName: 'Arial',
								fontSize: '14',
								bold: true,
								italic: false 
							},
			backgroundColor:'#282b2d',
			legend: {textStyle: {color: '#fff', fontSize: 12}},
			colors: ['#3279D3','#96A105'],
			is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('form_pay'));
        chart.draw(data, options);
    }
    </script>
	</head>
	<body>
		<div id="form_pay" style="width: 460px; height: 310px;"></div>
	</body>
</html>