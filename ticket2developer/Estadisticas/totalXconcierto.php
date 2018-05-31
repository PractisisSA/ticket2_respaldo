<?php 
	include('../controlusuarios/seguridadbeBoletero.php');
	require_once('../classes/private.db.php');
	$gbd = new DBConn();
	$idcon = $_GET['id'];
?>
<html>
	<head>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
		['Boletos', 'Localidad'],
		['Ganancias',  <?php 
							$selectlocal = "SELECT idLocalidad, strDescripcionL FROM Localidad WHERE idConc = ?";
							$sloc = $gbd -> prepare($selectlocal);
							$sloc -> execute(array($idcon));
							$numresult = $sloc -> rowCount();
							$suma = 0;
							$count = 1;
							while($rowloc = $sloc -> fetch(PDO::FETCH_ASSOC)){
								$preventa = 1;
								$normal = 2;
								$reserva = 3;
								
								$sn1 = "SELECT sum(doublePrecioL) FROM ocupadas JOIN Localidad ON ocupadas.local = Localidad.idLocalidad 
											JOIN Concierto ON ocupadas.concierto = Concierto.idConcierto WHERE idConcierto = ? AND descompra = ? AND local = ? group by strDescripcionL";
								$s1 = $gbd -> prepare($sn1);
								$s1 -> execute(array($idcon,$normal,$rowloc['idLocalidad']));
								$rowpnormal = $s1 -> fetch(PDO::FETCH_ASSOC);
								$p1 = $rowpnormal['sum(doublePrecioL)'];
								
								$sn2 = "SELECT sum(doublePrecioPreventa) FROM ocupadas JOIN Localidad ON ocupadas.local = Localidad.idLocalidad 
											JOIN Concierto ON ocupadas.concierto = Concierto.idConcierto WHERE idConcierto = ? AND descompra = ? AND local = ? group by strDescripcionL";
								$s2 = $gbd -> prepare($sn2);
								$s2 -> execute(array($idcon,$preventa,$rowloc['idLocalidad']));
								$rowppreventa = $s2 -> fetch(PDO::FETCH_ASSOC);
								$p2 = $rowppreventa['sum(doublePrecioPreventa)'];
								
								$sn3 = "SELECT sum(doublePrecioReserva) FROM ocupadas JOIN Localidad ON ocupadas.local = Localidad.idLocalidad 
											JOIN Concierto ON ocupadas.concierto = Concierto.idConcierto WHERE idConcierto = ? AND descompra = ? AND local = ? group by strDescripcionL";
								$s3 = $gbd -> prepare($sn3);
								$s3 -> execute(array($idcon,$reserva,$rowloc['idLocalidad']));
								$rowpreserva = $s3 -> fetch(PDO::FETCH_ASSOC);
								$p3 = $rowpreserva['sum(doublePrecioReserva)'];
								
								$total = $p1 + $p2 + $p3;
								$count++;
								$suma += $total;
							}
							echo $suma;
						?>]
	]);

	var options = {
		pieSliceText: 'label',
		title: 'GANANCIAS: $<?php echo $suma;?>',
		titleTextStyle: { 	color: '#fff',
							fontName: 'Arial',
							fontSize: '24',
							bold: true,
							italic: false 
						},
		backgroundColor:'#282b2d',
		legend: 'none',
		colors:['orange'],
		is3D: true,
	};

	var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
	chart.draw(data, options);
}
</script>
	</head>
	<body>
		<div id="donut_single" style="width: 460px; height: 310px;"></div>
	</body>
</html>