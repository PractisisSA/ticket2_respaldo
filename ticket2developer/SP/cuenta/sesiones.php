<?php
  // $conexion = mysql_connect("localhost", "root", "zuleta99")or die(mysql_error());
  // mysql_set_charset('UTF8',$conexion);
  // mysql_select_db("ticket", $conexion)or die(mysql_error());

	include '../../conexion.php';
	$usercuenta = $_REQUEST['usercuenta'];
	$passCuenta = $_REQUEST['passCuenta'];
	
	
	$sql = "SELECT * FROM cuenta";
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	if($usercuenta == 'paul' && $passCuenta == '123456' ){
?>
		<div class='row'>
			<div class='col-lg-1'></div>
			<div class='col-lg-10' style='border:3px solid #fff;padding:20px;'>
				<h1 style="color:#fff;">Bienvenido Paul</h1>
				<table class="table table-bordered" style='color:#fff;'>
					<tr style='font-size:11px;'>
						<td>
							BANCO
							<input id="bco" class="inputlogin form-control" type="text" autocomplete="off" placeholder="banco" value = '<?php echo $row['bco'];?>' >
						</td>
						<td>
							TIPO
							<input id="tipo" class="inputlogin form-control" type="text" autocomplete="off" placeholder="banco" value = '<?php echo $row['tipo'];?>'>
						</td>
						<td>
							N° DE CUENTA
							<input id="cta" class="inputlogin form-control" type="text" autocomplete="off" placeholder="banco" value = '<?php echo $row['num'];?>'>
						</td>
						<td>
							TITULAR DE CUENTA
							<input id="tit" class="inputlogin form-control" type="text" autocomplete="off" placeholder="banco" value = '<?php echo $row['nom'];?>'>
						</td>
						<td>
							CEDULA
							<input id="ced" class="inputlogin form-control" type="text" autocomplete="off" placeholder="banco" value = '<?php echo $row['ced'];?>'>
						</td>
						
					</tr>
					<tr>
						<td colspan='5'>
							<center>
								<button type="button" class="btn btn-default" onclick='cambiaCta()'>
									Cambiar
								</button>
							</center>
						</td>
					</tr>
				</table>
			</div>
			<div class='col-lg-1'></div>
		</div>
		<script>
			function cambiaCta(){
				var bco = $('#bco').val();
				var tipo = $('#tipo').val();
				var cta = $('#cta').val();
				var tit = $('#tit').val();
				var ced = $('#ced').val();
				
				if(bco == '' ){
					alert('Por favor ingrese el nombre del banco');
				}
				if(tipo == '' ){
					alert('Por favor ingrese el tipo de cuenta');
				}
				if(cta == '' ){
					alert('Por favor ingrese el numero de cuenta');
				}
				if(tit == ''){
					alert('Por favor ingrese el titular de cuenta');
				}
				if(ced == ''){
					alert('Por favor ingrese el numero de cedula');
				}
				if(bco == '' || tipo == '' || cta == '' || tit == '' || ced == '' ){
					
				}else{
					$.post('SP/cuenta/actCta.php',{
						bco : bco , tipo : tipo , cta : cta , tit : tit , ced : ced 
					}).done(function(data){
						alert(data);
					});
				}
			}
		</script>
<?php
	}else{
		echo '	<center>
					<h1 style="color:#fff;">Tus datos ingresados son incorrectos</h1>
				</center>';
	}
?>