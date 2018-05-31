<?php
	session_start();
	include('conexion.php');
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);

	$sql = 'SELECT c.idConcierto  , u.strObsCreacion , d.conciertoDet , c.strEvento
			FROM Usuario AS u , detalle_distribuidor AS d , Concierto AS c
			WHERE idUsuario = '.$_SESSION['iduser'].' 
			AND u.strObsCreacion = d.idDis_Det
			AND d.conciertoDet = c.idConcierto 
			AND idConcierto >= 73
			AND dateFecha > now()
			order by idConcierto ASC';
	$res = mysql_query($sql);
?>
	<div class="alert alert-success" role="alert" style="background-color: white !important; color: black !important;">
	  	<h4 class="alert-heading">Facturación</h4>
	  	<p>Modulo para impresion masiva de facturas.</p>
	  	<hr>
	  	<p class="left">Ticket Facil.</p>
	</div>
	<div class="row">
		<div class="col-md-5">
			<div class="row">
				<div class="col-md-12">
					<select id="selectForConcerts" class="form-control">
						<option id="firstOptionValue0" value="0">Seleccione un evento</option>
						<?php
							while ($row = mysql_fetch_array($res)) {
								$concertsIds = $row['idConcierto'];
								$concertsNames = $row['strEvento'];
								$concertsDates = $row['dateFecha'];
								$concertsTimes = $row['timeHora'];
								echo "<option value=".$concertsIds.">".$concertsIds."--".$concertsNames."</option>";
							}
						?>
					</select>
				</div>
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
			<div id="boxVentas"></div>
		</div>
	</div>
	<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#selectForConcerts').change(function () {
				var concert = $('#selectForConcerts').val()
				$.ajax({
					method:'POST',
					url:'subpages/Facturas/includes/probando.php',
					data:{concert:concert},
					success:function (response) {
						$('#boxVentas').html(response);
					}
				})
			})
		})
	</script>