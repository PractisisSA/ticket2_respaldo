<?php 
	include("controlusuarios/seguridadbeBoletero.php");
	require('Conexion/conexion.php');
	$id = $_SESSION['iduser'];
	$selectConcierto = "SELECT * FROM Concierto WHERE idUser = '$id' ORDER BY dateFecha ASC" or die(mysqli_error());
	$resultSelectCon = $mysqli->query($selectConcierto);
	echo '<input type="hidden" id="data" value="1" />';
	$hoy = date("Y-m-d");
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Lista de Conciertos
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;">
				<table id="select_conciertos" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 5px;">
					<tr style="text-align:center;">
						<td>
							<strong>Imagen</strong>
						</td>
						<td>
							<strong>Evento</strong>
						</td>
						<td>
							<strong>Fecha</strong>
						</td>
						<td>
							<strong>Hora</strong>
						</td>
						<td>
							<strong>Lugar</strong>
						</td>
						<td>
							<strong>Estado</strong>
						</td>
						<td>
							<strong>Estad&iacute;sticas</strong>
						</td>
					</tr>
					<?php while($rowCon = mysqli_fetch_array($resultSelectCon)){?>
					<tr>
						<tr style="text-align:center;">
							<td>
								<img src="spadmin/<?php echo $rowCon['strImagen'];?>" style="max-width:150px;"/>
							</td>
							<td>
								<?php echo $rowCon['strEvento'];?>
							</td>
							<td>
								<?php echo $rowCon['dateFecha'];?>
							</td>
							<td>
								<?php echo $rowCon['timeHora'];?>
							</td>
							<td>
								<?php echo $rowCon['strLugar'];?>
							</td>
							<td>
								<?php 
									if($rowCon['dateFecha'] < $hoy){
										echo 'Inactivo';
									}else{
										echo 'Activo';
									}
								?>
							</td>
							<td>
								<a href="?modulo=estadisticas&id=<?php echo $rowCon['idConcierto'];?>" class="btnlink">Abrir</a>
							</td>
						</tr>
					</tr>
					<?php }?>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
	</div>
</div>