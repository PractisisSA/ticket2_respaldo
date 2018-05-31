<?php
	date_default_timezone_set('America/Guayaquil');
	include 'conexion.php';
	$distribuidor = $_REQUEST['distribuidor'];
	$sql = 'SELECT conciertoDet FROM detalle_distribuidor WHERE idDis_Det = '.$distribuidor.'';
	$res = mysql_query($sql);
	
	while ($row = mysql_fetch_array($res)) {
		$sql1con = 'SELECT idConcierto, strEvento FROM Concierto WHERE idConcierto = '.$row["conciertoDet"].'';
		$res1con = mysql_query($sql1con);
		while ($rowcon1 = mysql_fetch_array($res1con)) {
?>
			<option value="<?php echo $rowcon1['idConcierto']; ?>"><?php echo $rowcon1["strEvento"]; ?> </option>
<?php
		}
	}
?>
	
