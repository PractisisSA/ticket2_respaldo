<?php
	session_start();
	include('../../../conexion.php');
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);
	$localidad = $_POST['localidad'];
	$concert = $_POST['concert'];
	$sql = 'SELECT * FROM Localidad WHERE strDescripcionL LIKE "%'.$localidad.'%" AND idConc = '.$concert.' LIMIT 25';
	$res = mysql_query($sql);
	$rows = mysql_num_rows($res);
	if ($rows ==0 || $rows == '') {
		echo 1;
	}else{
	?>
	<option value="0">Seleccione una localidad</option>
	<?php
		while($row = mysql_fetch_array($res)){
	?>
		<option value="<?php echo $row['idLocalidad'];?>"><a style="font-size: 11px;" onclick="getDescuentos(<?php echo $row['idLocalidad'];?>, <?php echo $concert; ?>)"><?php echo $row['strDescripcionL']; ?></a></option>
		
	<?php
		}
	}
	?>
	
	<script type="text/javascript">
		function getDescuentos(idLocalidad, concert) {
			var idLocalidad = idLocalidad;
			var concert = concert;
			$.ajax({
				method:'POST',
				url:'subpages/Facturas/includes/cortesias.php',
				data:{idLocalidad:idLocalidad, concert:concert},
				success: function (response) {
					$('#thDescuento').fadeIn('slow');
					$('#tdResults').html(response);
					$('#tdResults').fadeIn('slow');
				}
			})
		}
	</script>