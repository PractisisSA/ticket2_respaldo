<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart(){
	var data = google.visualization.arrayToDataTable([
		['Boletos', 'Localidad'],
		<?php 
			include('../controlusuarios/seguridadbeBoletero.php');
			require_once('../classes/private.db.php');
			
			$gbd = new DBConn();
			
			$idcon = $_REQUEST['idcon'];
			$search = $_REQUEST['search'];
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
		legend: 'none',
		pieSliceText: 'label',
		title: 'Boletos por Localidad',
		pieStartAngle: 100,
		titleTextStyle: { 	color: '#fff',
							fontName: 'Arial',
							fontSize: '22px',
							bold: true,
							italic: false 
						},
		backgroundColor:'#282b2d',
		color:['white','#fff'],
		is3D: true,
	};

	var chart = new google.visualization.PieChart(document.getElementById('boletoxlocalidad'));
	chart.draw(data, options);
}
</script>
<?php 
	echo '<div id="boletoxlocalidad" style="width: 900px; height: 500px;"></div>';
?>