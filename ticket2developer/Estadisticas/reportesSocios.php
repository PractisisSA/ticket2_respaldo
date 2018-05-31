

 
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>





<?php 
	require('Conexion/conexion.php');
	$id = $_SESSION['iduser'];
	$selectConcierto = "SELECT * FROM Concierto WHERE idUser = '$id' ORDER BY idConcierto DESC" or die(mysqli_error());
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
			<div style="background-color:#00ADEF;position:relative;text-align:center; color:#fff; font-size:18px;width:100%;">
				<select class='form-control' style='width:auto !important;text-transform:capitalize;' id='cboConciertos'>
					<option value=''>Seleccione...</option>
					<?php 
						while($rowCon = mysqli_fetch_array($resultSelectCon)){
					?>
							<option value='<?php echo $rowCon['idConcierto'];?>'><?php echo $rowCon['strEvento']."  [".$rowCon['idConcierto']."]";?></option>
					<?php 
						}
					?>
				</select>
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
		var width = $(window).width();
		var height = $(window).height();
		$('#contenedorDescuentos').css('width',width);
		$('#contenedorDescuentos').css('height','auto');
		$('body , html').css('background-color','#171A1B');
		$( "#cboConciertos" ).change(function() {
			$('#recibeLocalidades').html('');
			$('#loaderGif').css('display','block');
			var idConcierto = $( "#cboConciertos" ).val();
			if(idConcierto == 37){
				$.post("Estadisticas/ajax/localidadConcierto.php",{ 
					idConcierto : idConcierto
				}).done(function(data){
					$('#recibeLocalidades').html(data);
				});
			}else if(idConcierto >= 73){
				$.post("Estadisticas/ajax/localidadConcierto2.php",{ 
					idConcierto : idConcierto
				}).done(function(data){
					$('#recibeLocalidades').html(data);
					$('#loaderGif').css('display','none');
					$('body , html').css('background-color','#171A1B');
				});
			}
			else{
				$.post("Estadisticas/ajax/localidadConciertoResp.php",{ 
					idConcierto : idConcierto
				}).done(function(data){
					$('#recibeLocalidades').html(data);
				});
			}
		});
	    
	});
</script>