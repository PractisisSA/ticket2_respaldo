<?php 
	include("controlusuarios/seguridadbeBoletero.php");
	require('Conexion/conexion.php');
	$id = $_SESSION['iduser'];
	//echo "SELECT * FROM Concierto WHERE idUser = '$id' ORDER BY strEvento ASC";
	$selectConcierto = "SELECT * FROM Concierto WHERE idUser = '$id' ORDER BY idConcierto DESC" or die(mysqli_error());
	$resultSelectCon = $mysqli->query($selectConcierto);
	echo '<input type="hidden" id="data" value="1" />';
	$hoy = date("Y-m-d");
	//echo $_SESSION['iduser'];
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Lista de Conciertos
			</div>
			<div style="background-color:#00ADEF;position:relative;text-align:center; color:#fff; font-size:18px;width:100%;">
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
				<center>
					<img src = 'imagenes/load22.gif' id = 'loaderGif' style = 'display:none;'/>
				</center>
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
			$('#recibeLocalidades').html('');
			$('#loaderGif').css('display','block');
			var idConcierto = $( "#cboConciertos" ).val();
			//alert(idConcierto);
			if(idConcierto == 37){
				$.post("Estadisticas/ajax/localidadConcierto.php",{ 
					idConcierto : idConcierto
				}).done(function(data){
					$('#recibeLocalidades').html(data);
				});
			}else{
				
				$.post("Estadisticas/ajax/localidadConciertoResp.php",{ 
					idConcierto : idConcierto
				}).done(function(data){
					$('#recibeLocalidades').html(data);
				});
			}
		});
	    
	});
</script>