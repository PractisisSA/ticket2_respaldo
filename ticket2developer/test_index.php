<?php 
	require('Conexion/conexion.php');
	$select = "SELECT dateFechaReserva, timeHora FROM Concierto WHERE idConcierto = 2";
	$result = $mysqli->query($select);
	$row = mysqli_fetch_array($result);
	$fechareserva = $row['dateFechaReserva'];
	$hora = $row['timeHora'];
	
	$time = time();
	$fecha1 = new DateTime(date("Y-m-d H:i:s",$time));
	$fecha2 = new DateTime($fechareserva.' '.$hora);
	$fecha = $fecha1->diff($fecha2);
	
	echo '<input type="hidden" id="segundos" value="'.$fecha->s.'" />';
	echo '<input type="hidden" id="minutos" value="'.$fecha->i.'" />';
	echo '<input type="hidden" id="horas" value="'.$fecha->h.'" />';
	echo '<input type="hidden" id="dias" value="'.$fecha->d.'" />';
?>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script language="Javascript"  type="text/javascript" src="js/clockCountdown.js"></script>
		<style>
			/* agregamos una fuente de dafont, que simula unos leds */
			@font-face {
				font-family: ledbdrev;
				src: url(./Fleftex_M.ttf) format("truetype");
			}
			/* aqui va el estilo que tendra el clock */

			#clock, #clock-2, #clock-3{
				padding:0;
				height:70px;
				/*position: absolute;*/
				top: 0px;
				right: 0px;
				color: #2a2807;
				padding:4px;
				border:2px solid #2a2807;
				font-size:15px;
				width: 320px;
			}

			.clockCountdownNumber{
				float:left;
				background:URL('imagenes/numeros.png');
				display:block;
				width:34px;
				height:50px;
			}

			.clockCountdownSeparator_days,
			.clockCountdownSeparator_hours,
			.clockCountdownSeparator_minutes,
			.clockCountdownSeparator_seconds
			{
				float:left;
				display:block;
				width:10px;
				height:50px;
			}
			.clockCountdownFootItem{
				width:80px;
				float:left;
				text-align:center;
			}
		</style>
	</head>
	<body>
		<div id="clock"></div>
	</body>
</html>
<script>
	var dias = $('#dias').val();
	var horas = $('#horas').val();
	var minutos = $('#minutos').val();
	var segundos = $('#segundos').val();
	window.onload = function (){
        r = new clockCountdown('clock',{'days':dias,'hours':horas,'minutes':00,'seconds':3});
    }
</script>