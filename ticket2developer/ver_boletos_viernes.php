<?php
	include 'conexion.php';
	$sql = 'select * from Boleto where idCon = "26"';
	$res = mysql_query($sql) or die (mysql_error());
	$con = 1; 
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<div style = 'height:500px;overflow-y:scroll;'>	
	<table class = 'table'>
		<tr>
			<td>
				<center>
					Centralaso 2016
				</center>
			</td>
		</tr>
		<tr>
			<td>
				Num Boleto
			</td>
			<td>
				Codigo de Barras
			</td>
		</tr>
	<?php

		while($row = mysql_fetch_array($res)){
			// $sql1 = 'INSERT INTO `detalle_boleto` (`idBoleto`, `localidad`, `asientos`, `precio`) VALUES ("'.$row['idBoleto'].'", "72", "", "4.00")';
			// echo $sql1."<br>";
			// $res1 = mysql_query($sql1) or die (mysql_error());
	?>
		<tr>
			<td>
				<?php
					echo $row['serie'];
				?>
			</td>
			<td>
				<?php
					echo $row['strBarcode'];
				?>
			</td>
		</tr>
	<?php
			$con++;
		}
	?>
	</table>
</div>