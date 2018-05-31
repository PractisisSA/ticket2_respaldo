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
			<?php 
				$Slocals = "SELECT idLocalidad, strDescripcionL FROM Localidad WHERE idConc = ?";
				$sltloc = $gbd -> prepare($Slocals);
				$sltloc -> execute(array($idcon));
				$numresult = $sltloc -> rowCount();
				
				$count = 1;
				while($rowloc = $sltloc -> fetch(PDO::FETCH_ASSOC)){
					$Svendidas = "SELECT * FROM ocupadas WHERE local = ? AND concierto = ?";
					$sven = $gbd -> prepare($Svendidas);
					$sven -> execute(array($rowloc['idLocalidad'],$idcon));
					$numven = $sven -> rowCount();
					if($numven < 10){
						$numven = $numven * 10;
					}
					if($count < $numresult){
						echo "['".$rowloc['strDescripcionL']."', ".$numven."],\n";
					}else{
						echo "['".$rowloc['strDescripcionL']."', ".$numven."]\n";
					}
					$count++;
				}
			?>
        ]);

        var options = {
			pieSliceText: 'label',
			title: 'Nro. de Boletos vendidos por Localidad',
			titleTextStyle: { 	color: '#fff',
								fontName: 'Arial',
								fontSize: '14',
								bold: true,
								italic: false 
							},
			backgroundColor:'#282b2d',
			legend: {textStyle: {color: '#fff', fontSize: 12}},
			color:['white','#fff'],
			is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
    </script>
</head>
	<body>
		<div id="piechart_3d" style="width: 430px; height: 280px;"></div>
	</body>
</html>