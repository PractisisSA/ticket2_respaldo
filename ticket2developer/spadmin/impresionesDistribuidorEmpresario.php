<?php
		date_default_timezone_set('America/Guayaquil');
		
		include 'conexion.php';
		echo '<input type="hidden" id="data" value="36" />';
		$cont = 'SELECT * FROM Concierto WHERE idUser = '.$_SESSION['iduser'].'';
		$contRes = mysql_query($cont);
?>	
	<div class="message" style="display: none;">
		<h4 style="color:white;">Cargando...</h4>
	</div>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-12">
			<button type="button" class="btn btn-default" onclick="tableToExcel('table', 'VENTAS DISTRIBUIDOR')">EXCEL</button>
			<center>
				<h3 style="color: white !important;">Seleccione evento:</h3>
			<select id='concert-sel' class='form-control center' style='width:350px;'>
				<option value='0'>Seleccione un evento...</option>
<?php		
		while ($contDone = mysql_fetch_array($contRes)) {
			echo "<option value='".$contDone['idConcierto']."'>".$contDone['strEvento']." ".$contDone['idConcierto']."</option>";
		}

?>			</select>
		</center>
		<center>
			<select style="display: none; width: 150px;" class="form-control" id="comboEventosDos">
			</select>
		</center>
		</div>
	</div>
	<center><img src="http://ticketfacil.ec/imagenes/loading.gif" id="loadBoleto" style = 'display:none;width:50px;'></center>
	<div id="res">
	</div>
<script type="text/javascript">
	$( "#concert-sel" ).change(function() {
		var idconciertotrans = $( "#concert-sel" ).val();
		if(idconciertotrans == ''){
			alert('Debe seleccionar un evento');
		}else{
			$('#res').html('');
			$.post("spadmin/impresiones_distribuidor_combo1.php",{ 
				idconciertotrans : idconciertotrans
			}).done(function(dataCombo){
				$('#loadBoleto').css('display','block');
				$('#comboEventosDos').css('display', 'inline');
				$('#comboEventosDos').html(dataCombo);
				$.post("spadmin/impresiones_distribuidor_combo.php",{ 
					idconciertotrans: idconciertotrans 
				}).done(function(data){
					console.log(data);
					$('#loadBoleto').css('display','none');
					$('#res').html(data);
				});
				if (dataCombo == 1) {
					$('#comboEventosDos').css('display', 'none');
					alert('Este evento no tiene distribuidores registrados');
				}else{
					console.log(dataCombo);
					$('#comboEventosDos').html(dataCombo);
					$('#comboEventosDos').css('display','inline');
				}
			});
		}
	});
	$( "#comboEventosDos" ).change(function() {
			var idDistribuidor = $( "#comboEventosDos" ).val();
			var idconciertotrans = $( "#concert-sel" ).val();
			if(idDistribuidor == 0){
				$('#res').html('');
				$('#loadBoleto').css('display','block');
				$.post("spadmin/impresiones_distribuidor_combo.php",{ 
					idconciertotrans: idconciertotrans 
				}).done(function(data){
					console.log(data);
					$('#loadBoleto').css('display','none');
					$('#res').html(data);
				});
			}else{
				$('#res').html('');
				$('#loadBoleto').css('display','inline');
				$.post("spadmin/impresiones_distribuidor_combo2.php",{ 
					idDistribuidor : idDistribuidor, idconciertotrans: idconciertotrans 
				}).done(function(data){
					console.log(data);
					$('#loadBoleto').css('display','none');
					$('#res').html(data);
				});
			}
		});
</script>
