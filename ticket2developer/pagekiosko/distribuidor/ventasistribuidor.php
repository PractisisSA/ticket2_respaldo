<?php 
	include("controlusuarios/seguridadDis.php");
	
	echo '<input type="hidden" id="data" value="1" />';
	$nombre = $_SESSION['useractual'];
	$idDis = $_SESSION['idDis'];
	
	$gbd = new DBConn();
	$fecha = date("Y-m-d");
	
	$select = "SELECT idConcierto, dateFecha, strEvento, strImagen, strDescripcion, strLugar, timeHora, dateFecha FROM detalle_distribuidor JOIN Concierto ON detalle_distribuidor.conciertoDet = Concierto.idConcierto WHERE idDis_Det = ? AND dateFecha >= ? AND estadoDet = ? ORDER BY dateFecha ASC";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array($idDis,$fecha,'Activo'));
?>
<div class="divborderexterno">
	<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
		<strong>Eventos</strong>
	</div>
	<div style="background-color:#282B2D; margin: 30px 5px; position:relative;">
		<div class="row">
			<?php 
			while($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				echo '<div class="col-sm-6 col-md-3" style="margin:0px -15px 0px 5px; position:relative;">
						<div class="thumbnail" style="margin:10px 10px; height:310px;">
							<a href="?modulo=conciertoDis&evento='.$row['idConcierto'].'"><img src="spadmin/'.$row['strImagen'].'" alt=""></a>
							<div class="caption" style="font-size:12px;">
								<h4>'.$row['strEvento'].'</h4>
								<p><strong>Lugar: </strong>'.$row['strLugar'].'</p>
								<p><strong>Fecha: </strong>'.$row['dateFecha'].'</p>
								<p><strong>Hora: </strong>'.$row['timeHora'].'</p>
							</div>
						</div>
						<div style="position:absolute; bottom:12px; right:12px;">
							<a href="?modulo=conciertoDis&evento='.$row['idConcierto'].'" class="btn btn-primary pull-right" role="button">Vender</a>
						</div>
					</div>';
			}
			?>
		</div>
	</div>
</div>
<script>
</script>