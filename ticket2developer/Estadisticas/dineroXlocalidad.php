<?php 
	include('../controlusuarios/seguridadbeBoletero.php');
	require_once('../classes/private.db.php');
	$gbd = new DBConn();
	$idcon = $_GET['id'];
?>
<html>
	<head>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	</head>
	<body>
		<div id="dXl"></div>
	</body>
</html>
<script>
Morris.Bar({
  element: 'dXl',
  data: [
	<?php
		$selectlocal = "SELECT idLocalidad, strDescripcionL FROM Localidad WHERE idConc = ?";
		$sloc = $gbd -> prepare($selectlocal);
		$sloc -> execute(array($idcon));
		$numresult = $sloc -> rowCount();
		
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
			if($count < $numresult){
				echo '{y: "'.$rowloc['strDescripcionL'].'", a: '.$total.'},';
			}else{
				echo '{y: "'.$rowloc['strDescripcionL'].'", a: '.$total.'}';
			}
			$count++;
		}
	?>
  ],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['$'],
  barColors: ['#00aeef', '#00aeef'],
  hideHover: 'auto'
});
</script>