<?php
	session_start();
	//echo $_SESSION['iduser'];
	// echo $_SESSION['tipocadena']."aqui";
	include("controlusuarios/seguridadDis.php");
	include("../conexion.php");
	echo '<input type="hidden" id="data" value="1" />';
	$nombre = $_SESSION['useractual'];
	$idDis = $_SESSION['idDis'];
	
	$gbd = new DBConn();
	$fecha = date("Y-m-d");	
	$estado = 'Activo';
	$hoy = date('Y-m-d');
	$sql = 'SELECT * FROM entrega_boletos';
	$result = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo $row[0];
	$select = '	SELECT idConcierto, dateFecha, strEvento, strImagen, strDescripcion, strLugar, timeHora, dateFecha 
				FROM detalle_distribuidor
				JOIN Concierto 
				ON detalle_distribuidor.conciertoDet = Concierto.idConcierto 
				WHERE idDis_Det = "'.$idDis.'"
				and strEstado= "Activo"
				AND estadoDet = "Activo"
				AND dateFecha >= "'.$fecha.'"
				ORDER BY idConcierto ASC';
	$slt = $gbd -> prepare($select);
	$slt -> execute();
?>
<div class="divborderexterno">
	<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
		<strong>Eventos</strong>
		<button class="btn btn-primary" onclick="verVentas()"><?php echo $row[3]; ?></button>
		<p><?php foreach ($rowDis as $dist => $key) {
			echo $dist[$key];
		} ?></p>
	</div>
	<div style="background-color:#282B2D; margin: 30px 5px; position:relative;">
		<div class="row">
			<?php 
			while($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				if($row['tipo_conc']==1){
					$tipoConsF = 'class="img-rounded"';
				}elseif($row['tipo_conc']==2){
					$tipoConsF = 'class="img-thumbnail"';
				}
			?>
			
				<div class="col-sm-6 col-md-3" style="margin:0px -15px 0px 5px; position:relative;">
						<div class="thumbnail" style="margin:10px 10px; height:310px;">
							<a href="?modulo=conciertoDis&evento=<?php echo $row['idConcierto']; ?>">
								<img src="spadmin/<?php echo $row['strImagen'];?>" alt="" <?php echo $tipoConsF;?>>
							</a>
							<div class="caption" style="font-size:12px;">
								<h4><?php echo $row['strEvento'];?></h4>
								<p><strong>Lugar: </strong><?php echo $row['strLugar'];?></p>
								<p><strong>Fecha: </strong><?php echo $row['dateFecha'];?></p>
								<p><strong>Hora: </strong><?php echo $row['timeHora'];?></p>
							</div>
						</div>
						<div style="position:absolute; bottom:12px; right:12px;">
							<a href="?modulo=conciertoDis&evento=<?php echo $row['idConcierto'];?>" class="btn btn-primary pull-right" role="button">Vender  [<?php echo $row['idConcierto'];?>]</a>
						</div>
					</div>
		<?php
			}
			?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		function verVentas() {
			
		}
	})
</script>