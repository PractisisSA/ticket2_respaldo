<?php 
	include('../controlusuarios/seguridadbeBoletero.php');
	require_once('../classes/private.db.php');
	$gbd = new DBConn();
	$idcon = $_GET['id'];
	
	$comprados = 1;
	$reservados = 2;
	$nodisponibles = 3;
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
			["Comprados", <?php 
							$comprado = "SELECT status FROM ocupadas WHERE concierto = ? AND status = ?";
							$buy = $gbd -> prepare($comprado);
							$buy -> execute(array($idcon,$comprados));
							$numbuy = $buy -> rowCount();
							echo $numbuy;
						?>],
			["Reservados", <?php 
							$reserva = "SELECT status FROM ocupadas WHERE concierto = ? AND status = ?";
							$res = $gbd -> prepare($reserva);
							$res -> execute(array($idcon,$reservados));
							$numres = $res -> rowCount();
							echo $numres;
						?>],
			["No Disponibles", <?php 
								$nodispo = "SELECT status FROM ocupadas WHERE concierto = ? AND status = ?";
								$nod = $gbd -> prepare($nodispo);
								$nod -> execute(array($idcon,$nodisponibles));
								$numnod = $nod -> rowCount();
								echo $numnod;
								?>]
        ]);

        var options = {
			pieSliceText: 'label',
			title: 'Boletos por descripcion',
			titleTextStyle: { 	color: '#fff',
								fontName: 'Arial',
								fontSize: '14',
								bold: true,
								italic: false 
							},
			backgroundColor:'#282b2d',
			legend: {textStyle: {color: '#fff', fontSize: 12}},
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