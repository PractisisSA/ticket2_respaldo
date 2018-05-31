<?php 
	include('../controlusuarios/seguridadbeBoletero.php');
	require_once('../classes/private.db.php');
	$gbd = new DBConn();
	$idcon = $_GET['id'];
	$desnormal = 2;
	$despreventa = 1;
	$desreserva = 3;
?>
<html>
	<head>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	</head>
	<body>
		<div id="bar-example"></div>
	</body>
</html>
<script>
Morris.Bar({
  element: 'bar-example',
  data: [
	{y: 'Normal', <?php 
						$normal = "SELECT sum(doublePrecioL) FROM ocupadas JOIN Localidad ON ocupadas.local = Localidad.idLocalidad 
									JOIN Concierto ON ocupadas.concierto = Concierto.idConcierto WHERE idConcierto = ? AND descompra = ?";
						$nor = $gbd -> prepare($normal);
						$nor -> execute(array($idcon,$desnormal));
						$rownor = $nor -> fetch(PDO::FETCH_ASSOC);
						echo 'a:'.$rownor['sum(doublePrecioL)'].'';
					?>},
	{y: 'Preventa', <?php 
						$preventa = "SELECT sum(doublePrecioPreventa) FROM ocupadas JOIN Localidad ON ocupadas.local = Localidad.idLocalidad 
									JOIN Concierto ON ocupadas.concierto = Concierto.idConcierto WHERE idConcierto = ? AND descompra = ?";
						$pre = $gbd -> prepare($preventa);
						$pre -> execute(array($idcon,$despreventa));
						$rowpre = $pre -> fetch(PDO::FETCH_ASSOC);
						echo 'a:'.$rowpre['sum(doublePrecioPreventa)'].'';
					?>},
	{y: 'Reserva', <?php 
						$reserva = "SELECT sum(doublePrecioReserva) FROM ocupadas JOIN Localidad ON ocupadas.local = Localidad.idLocalidad 
									JOIN Concierto ON ocupadas.concierto = Concierto.idConcierto WHERE idConcierto = ? AND descompra = ?";
						$res = $gbd -> prepare($reserva);
						$res -> execute(array($idcon,$desreserva));
						$rowres = $res -> fetch(PDO::FETCH_ASSOC);
						echo 'a:'.$rowres['sum(doublePrecioReserva)'].'';
					?>}
  ],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['$'],
  barColors: ['#00aeef', '#00aeef'],
  hideHover: 'auto'
});
</script>