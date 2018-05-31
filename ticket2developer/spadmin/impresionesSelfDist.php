<?php
	session_start();
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include 'conexion.php';
	$id = $_SESSION['iduser'];
	$hoy = date('Y-m-d');
	
	
	echo '<input type="hidden" id="data" value="25" />';
	$hoy = date("Y-m-d");
	//echo $_SESSION['iduser'];
	echo $_SESSION['perfil'];
	echo '<input type="hidden" id="hid" value="'.$_SESSION['useractual'].'" />';
	if($_SESSION['perfil'] == 'SP'){
		$cont = 'SELECT * FROM Concierto order by idConcierto desc';
	}else{
		$cont = 'SELECT * FROM Concierto WHERE idUser = '.$_SESSION['iduser'].' order by idConcierto desc';
	}
	// echo $cont.'<br>';
	
	
	// echo $_SESSION['autentica']."<br>";
	// echo $_SESSION['username']."<br>";
	// echo $_SESSION['userid']."<br>";
	// echo $_SESSION['useractual']."<br>";
	// echo $_SESSION['mailuser']."<br>";
	// echo $_SESSION['iduser']."<br>";
	// echo $_SESSION['perfil']."<br>";
	
	
	$contRes = mysql_query($cont);
?>

	<body onload = '$("#menu25").addClass("allmenuactive");'>
		<input type="hidden" id="data" value="25" />
		<div style="margin:10px -10px;">
			<script type="text/javascript" src="js/jquery.numeric.js"></script>
			<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%">
				<div class = 'row'>
					<div class = 'col-md-12'>
						<h3 style = 'padding-top: 10px;padding-bottom: 10px;padding-left: 10px;padding-right: 10px;background-color: #ED1568;color: #000'>
							VENTAS DISTRIBUIDOR
						</h3>
					</div>
				</div>
				<!--<button type="button" class="btn btn-default" onclick="tableToExcel('table', 'VENTAS DISTRIBUIDOR')">EXCEL</button>-->
				<div class = 'row'>
					
					<div class = 'col-md-6' style = 'color:#000;'>
						<label style = 'color:#fff;'>Seleccion un Evento</label>
						<select class = 'form-control' id = 'evento_distri' >
							<option value = ''>Seleccion un Evento</option>
							<?php
								while ($contDone = mysql_fetch_array($contRes)) {
										echo "<option value='".$contDone['idConcierto']."'>".$contDone['strEvento']." ".$contDone['idConcierto']."</option>";
								}
							?>
						</select>
						
						
					</div>
					<div class = 'col-md-5'>
						<label style = 'color:#fff;'>Seleccion un Punto de Venta</label>
						<select id = 'pventas' class = 'form-control' >
							<option value=''>Todos los Puntos de Venta!...</option>
							<option value='0'>Venta Web!...</option>
						</select>
					</div>
				</div>
				
			</div>
			
		</div>
		<div id="recibeConsulta"></div>
		
		
		<?php
			echo "<input type = 'hidden' id = 'tipo_emp' value = '".$_SESSION['tipo_emp']."'  />";
		?>

	</body>
	<script>
		$( document ).ready(function() {
			$("#evento_distri").change(function(e){
				$('#recibeConsulta').html('');
				var evento_distri = $("#evento_distri").val();
				if(evento_distri == ''){
					alert('Seleccione un evento')
					$('#pventas').html("<option value=''>Todos los Puntos de Venta!...</option><option value='0'>Venta Web!...</option>");
				}else{
					$.post("spadmin/saberPventaEvento.php",{ 
						evento_distri : evento_distri
					}).done(function(data){
						var idConcierto = $("#evento_distri").val();
						var pventa = $("#pventas").val();
						$.post("Estadisticas/ajax/ventasPventa.php",{ 
							idConcierto : idConcierto , pventa : pventa
						}).done(function(data){
							$('#recibeConsulta').html(data);
						});
						$('#pventas').html(data);
					});
				}
			});
			$('#pventas').change(function () {
				$('#recibeConsulta').html('<center><h1 style = "color:#fff;">ESPERE CARGANDO INFORMACION</h1></center>');
				var idConcierto = $("#evento_distri").val();
				var pventa = $("#pventas").val();
				
				
				$.post("Estadisticas/ajax/ventasPventa.php",{ 
					idConcierto : idConcierto , pventa : pventa
				}).done(function(data){
					$('#recibeConsulta').html(data);
				});
			});
		});
		var tableToExcel = (function() {
          var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
          return function(table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
          }
        })()
</script>