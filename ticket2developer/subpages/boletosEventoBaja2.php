<?php
	include '../conexion.php';
	session_start();
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="31" />';
	echo $_SESSION['perfil'];

	$evento_baja = $_REQUEST['evento_baja'];
	$sqlFor1 = 'SELECT * FROM Boleto WHERE idCon = "'.$evento_baja.'0000"';
	$resFor1 = mysql_query($sqlFor1) or die (mysql_error());

	$hoy = date("Y-m-d"); 
	$idSocio = $_SESSION['iduser'];

	$sqlLocalidad = 'SELECT * FROM Localidad WHERE idConc ="'.$evento_baja.'"';
	
?>
<div class = 'col-md-2 sinclave'>
	Boleto Desde
	<input type = 'text' class = 'form-control'  placeholder = 'DESDE SOLO NUMERO' id = 'des' />
</div>
<div class = 'col-md-2 sinclave'>
	Boleto Hasta
	<input type = 'text' class = 'form-control'  placeholder = 'HASTA SOLO NUMERO' id = 'has' />
</div>
<div class = 'col-md-2 sinclave' style = 'display:inline;'>
	Seleccione Localidad
	<select class = 'form-control localidades' id = 'local'>
		<option value = ''>Seleccione</option>
		<?php
			$resLocalidad = mysql_query($sqlLocalidad) or die (mysql_error());
			while($row = mysql_fetch_array($resLocalidad)){
			$idLocalidad = $row['idLocalidad'];
		?>
		<option value = "<?php echo $idLocalidad ?>"><?php echo $row['strDescripcionL'];?></option>
		<?php
			}
		?>
	</select>
</div>
	
<div id="resultadobaja">
<script type="text/javascript">
	$('#local').change(function () {
		var evento = $('#local').val();
		var des = $('#des').val();
		var has = $('#has').val();
		console.log(local, des, has);

		$.post('subpages/verBajas.php',{ 
			local : local, des : des 
		}).done(function(data){
			$('#resultadobaja').html(data);
			console.log(data);
		});
	});
	function cambiaBoleto() {
		var local = $('#local').val();
		var desde = $('#desde').val();
		var hasta = $('#hasta').val();
		var evento_reimprime = $('#evento_reimprime').val();

		if(local == ''){
			alert('seleccione boleto inicio');
		}
		if(desde == ''){
			alert('ingrese localidad inicio');
		}
		if(hasta == ''){
			alert('ingrese boleto final');
		}
		if(local == '' || desde == '' || hasta == ''){
			alert('Debe ingresar los campos');
		}else{
			$.post("subpages/activarBaja.php",{ 
				local : local , desde : desde , hasta : hasta , evento_reimprime : evento_reimprime
			}).done(function(data){
				if (data == 1) {
					alert('Boletos activados con exito')
				}else{
					alert('Error activando boletos');
				}
			});
		}
	}
	function buit(id, idCon){
		var con = confirm('Seguro que desea activar este boleto con id: '+id);
		if (con == true) {
			var str = idCon.toString();
			var cleanId = str.replace(/0000/, "");
			$.post('subpages/activarBaja.php',{ 
				id : id, cleanId : cleanId 
			}).done(function(data){
				if (data == 1) {
					alert('Boleto Activado, este boleto ya no aparecera en el listado de baja');
					location.reload();
				}else{
					alert('Error activando');
				}
			});
		}else{
			alert('Transaccion cancelada');
		}
		
	}
</script>