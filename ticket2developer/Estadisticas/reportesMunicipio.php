

 
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
    .toggler { width: 500px; height: 200px; position: relative; }
    #button { padding: .5em 1em; text-decoration: none; }
    #effect { width: 240px; height: 170px; padding: 0.4em; position: relative; }
    #effect h3 { margin: 0; padding: 0.4em; text-align: center; }
    .ui-effects-transfer { border: 2px dotted gray; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<?php
	include 'conexion.php';
	$sqlS= 'SELECT * FROM Usuario WHERE strPerfil = "Socio" and strEstadoU = "Activo" order by strNombreU ASC';
	$resS = mysql_query($sqlS) or die (mysql_error());
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div class = 'row'>
				<div class = 'col-md-5'>
					<div style = 'font-size:1.2vw;text-align:center;width:100%;padding-top:10px;padding-bottom:10px;background-color:#ED1568;color:#fff;'> 
						Lista de Empresarios
					</div>
					<br><br>
					<select class='form-control' style='width:auto !important;text-transform:capitalize;' id='cboEmpresarios'>
						<option value=''>Seleccione...</option>
						<?php 
							while($rowS = mysql_fetch_array($resS)){
						?>
								<option value='<?php echo $rowS['idUsuario'];?>'><?php echo $rowS['strNombreU'];?></option>
						<?php 
							}
						?>
					</select>
				</div>
				<div class = 'col-md-5'>
					<div style = 'font-size:1.2vw;text-align:center;width:100%;padding-top:10px;padding-bottom:10px;background-color:#ED1568;color:#fff;'> 
						Lista de Conciertos
					</div>
					<br><br>
					<select class='form-control' style='width:100% !important;text-transform:capitalize;' id='cboConciertos'>
						<option value=''>Seleccione...</option>
					</select>
				</div>
			</div>
			
			
			<div style="background-color:#00ADEF;position:relative;text-align:center; color:#fff; font-size:18px;width:100%;">
				
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
		$( "#cboEmpresarios" ).change(function() {
			var cboEmpresarios = $('#cboEmpresarios').val();
			$.post("spadmin/buscarEventoSocio.php",{ 
				cboEmpresarios : cboEmpresarios 
			}).done(function(data){
				// $( "#cboConciertos" ).effect('highlight')
				$( "#cboConciertos" ).html(data);
			});
		});
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