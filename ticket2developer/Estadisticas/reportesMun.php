<?php 
	//include("controlusuarios/seguridadbeBoletero.php");
	require('Conexion/conexion.php');
	$id = $_SESSION['iduser'];
	$hoy = date("Y-m-d");
	$selectConcierto = 'SELECT * FROM Concierto where idConcierto = "37" ORDER BY strEvento ASC' or die(mysqli_error());
	$resultSelectCon = $mysqli->query($selectConcierto);
	echo '<input type="hidden" id="data" value="1" />';
	
	//echo $_SESSION['iduser'];
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Lista de Conciertos
			</div>
			<div style="background-color:#00ADEF;position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;width:100%;">
				<select class='form-control' style='width:auto !important;text-transform:capitalize;' id='cboConciertos'>
					<option value=''>Seleccione...</option>
					<?php 
						while($rowCon = mysqli_fetch_array($resultSelectCon)){
					?>
							<option value='<?php echo $rowCon['idConcierto'];?>'><?php echo $rowCon['strEvento'];?></option>
					<?php 
						}
					?>
				</select>
				<!--<div class="tra_azul"></div>
				<div class="par_azul"></div>-->
				<div id='recibeLocalidades'>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$( document ).ready(function() {
		console.log( "ready!" );
		$( "#cboConciertos" ).change(function() {
			var idConcierto = $( "#cboConciertos" ).val();
			//alert(idConcierto);
			$.post("Estadisticas/ajax/localidadConcierto.php",{ 
				idConcierto : idConcierto
			}).done(function(data){
				$('#recibeLocalidades').html(data);
			});
		});
	    
	});
	
	
	
</script>