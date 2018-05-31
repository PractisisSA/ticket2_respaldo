<?php
	require_once 'PHPM/PHPM/class.phpmailer.php';
	require_once 'PHPM/PHPM/class.smtp.php';
	session_start();
	
	$gbd = new DBConn();
	
	$con = $_GET['con'];
	$nombrenuevo = '';
	if(isset($_POST['documento'])){
		$nombre = $_POST['nombre'];
		$doc = $_POST['documento'];
			$anio = 2000;
			$mes = 01;
			$dia = 01;
		$fecha = $anio.'-'.$mes.'-'.$dia;
		$ciudad = 'Agregar Ciudad';
		$prov = 'Agregar Provincia';
		$telf = 'Agregar Numero';
		$telm = $_POST['tmov'];
		$dir = $_POST['dir'];
		$fpago = $_POST['pago'];
		$email = $_POST['mail'];
		$passw = $_POST['password'];
		$passw = md5($passw);
		$genero = 'Agregar Genero';
		$envio = $_POST['obtener_boleto'];
		$s = "SELECT strDocumentoC, strMailC FROM Cliente WHERE strDocumentoC = ? AND strMailC = ?";
		$r = $gbd -> prepare($s);
		$r -> execute(array($doc,$email));
		$cli_ok = $r -> rowCount();
		if($cli_ok == 0){
			$ins = "INSERT INTO Cliente VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$result = $gbd -> prepare($ins);
			$result -> execute(array('NULL',$nombre,$email,$passw,$doc,$dir,$fecha,$genero,$ciudad,$prov,$telf,$telm,$fpago,$envio,'no','NULL'));
			$ult_cliente = $gbd -> lastInsertId(); 
			$select = "SELECT * FROM Cliente WHERE idCliente = ?";
			$res = $gbd -> prepare($select);
			$res -> execute(array($ult_cliente));
			$row = $res -> fetch(PDO::FETCH_ASSOC);
			$id = $row['idCliente'];
			$nom = $row['strNombresC'];
			$doc = $row['strDocumentoC'];
			$ciudad = $row['strCiudadC'];
			$pro = $row['strProvinciaC'];
			$fijo = $row['strTelefonoC'];
			$tel = $row['intTelefonoMovC'];
			$email = $row['strMailC'];
			$dir = $row['strDireccionC'];
			$formP = $row['strFormPagoC'];
			$formEnvio = $row['strEnvioC'];
			$contrasena = $row['strContrasenaC'];
			$fecha_nac = $row['strFechaNanC'];
			$genero_cli = $row['strGeneroC'];
			$_SESSION['autentica'] = 'uzx153';
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $nom;
			$_SESSION['userdoc'] = $doc;
			$_SESSION['userciudad'] = $ciudad;
			$_SESSION['userprov'] = $pro;
			$_SESSION['usertel'] = $tel;
			$_SESSION['usertelf'] = $fijo;
			$_SESSION['usermail'] = $email;
			$_SESSION['userdir'] = $dir;
			$_SESSION['formapago'] = $formP;
			$_SESSION['formenvio'] = $formEnvio;
			$_SESSION['fech_nac'] = $fecha_nac;
			$_SESSION['genero'] = $genero_cli;
			$nombrenuevo = $nom;
			$content = '
			<page>
				<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;">
					<tr>
						<td style="text-align:center;">
							<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							Estimad@ <strong>'.$nom.'</strong> le proporcionamos la siguiente información:
						</td>
					</tr>
					<tr>
						<td>
							<br>
							<br>
							<br>
							* Le informamos que su cuenta ha sido activada satisfactoriamente.
						</td>
					</tr>
					<tr>
						<td>
							<br>
							* Desde este momento puede hacer uso de todos los beneficios que ofrece TICKETFACIL
						</tr>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<strong>Gracias por Preferirnos</strong>
							<br>
							<strong>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></strong>
						</td>
					</tr>
				</table>
			</page>';
			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Bienvenid@ a TICKETFACIL';
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			$mail->Username = "jonathan@practisis.com";
			$mail->Password = "nathan42015";
			$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
			$mail->SetFrom($ownerEmail,'TICKETFACIL');
			$mail->From = $ownerEmail;
			$mail->AddAddress($email,$nom);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);
			//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				// echo 'ok';
			}
			echo "<script>alert('Bienvenid@ a TICKETFACIL');</script>";
		}else if($cli_ok > 0){
			echo "<script>
					alert('Tu E-mail ya existe, revisa tus datos');
					window.location.href = '?modulo=des_concierto&con=".$con."';
				</script>";
		}
	}
	if($_SESSION['autentica'] != 'uzx153'){
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$pass = md5($pass);
		$sql = "SELECT * FROM Cliente WHERE strMailC = ? AND strContrasenaC = ?";
		$resultLogin = $gbd -> prepare($sql);
		$resultLogin -> execute(array($user,$pass));
		$num_registro = $resultLogin -> rowCount();
		if($num_registro > 0){
			$row = $resultLogin -> fetch(PDO::FETCH_ASSOC);
			$id = $row['idCliente'];
			$nom = $row['strNombresC'];
			$doc = $row['strDocumentoC'];
			$ciudad = $row['strCiudadC'];
			$pro = $row['strProvinciaC'];
			$fijo = $row['strTelefonoC'];
			$tel = $row['intTelefonoMovC'];
			$mail = $row['strMailC'];
			$dir = $row['strDireccionC'];
			$formP = $row['strFormPagoC'];
			$formEnvio = $row['strEnvioC'];
			$contrasena = $row['strContrasenaC'];
			$fecha_nac = $row['strFechaNanC'];
			$genero_cli = $row['strGeneroC'];
			
			$_SESSION['autentica'] = 'uzx153';
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $nom;
			$_SESSION['userdoc'] = $doc;
			$_SESSION['userciudad'] = $ciudad;
			$_SESSION['userprov'] = $pro;
			$_SESSION['usertel'] = $tel;
			$_SESSION['usertelf'] = $fijo;
			$_SESSION['usermail'] = $mail;
			$_SESSION['userdir'] = $dir;
			$_SESSION['formapago'] = $formP;
			$_SESSION['formenvio'] = $formEnvio;
			$_SESSION['fech_nac'] = $fecha_nac;
			$_SESSION['genero'] = $genero_cli;
			echo "<script>alert('Bienvenid@ a TICKETFACIL');</script>";
		}else if($num_registro == 0){
			echo "<script>
					alert('Los datos ingresados no son correctos');
					window.location.href = '?modulo=des_concierto&con=".$con."';
				</script>";
		}
	}
	if(isset($_POST['mail_cli'])){
		$id_cliente = $_SESSION['id'];
		$name_cliente = $_POST['nombre_cli'];
		$doc_cliente = $_POST['doc_cli'];
		$mail_cliente = $_POST['mail_cli'];
		$fecha_cliente = $_POST['fecha_cli'];
		$genero_cliente = $_POST['genero_cli'];
		$fijo_cliente = $_POST['fijo'];
		$movil_cliente = $_POST['movil'];
		$forma_pago = $_POST['form_pago'];
		$forma_envio = $_POST['envio'];
		$direccion_cliente = $_POST['dir_cli'];
		$ciudad_cliente = $_POST['ciudad_cli'];
		$prov_cliente = $_POST['prov_cli'];
		$updateCliente = "UPDATE Cliente SET strNombresC = ?, strMailC = ?, strDocumentoC = ?, strDireccionC = ?, strFechaNanC = ?, strGeneroC = ?, strCiudadC = ?, strProvinciaC = ?, strTelefonoC = ?, intTelefonoMovC = ?, strFormPagoC = ?, strEnvioC = ? WHERE idCliente = ?";
		$resultUpdateCliente = $gbd -> prepare($updateCliente);
		$resultUpdateCliente -> execute(array($name_cliente,$mail_cliente,$doc_cliente,$direccion_cliente,$fecha_cliente,$genero_cliente,$ciudad_cliente,$prov_cliente,$fijo_cliente,$movil_cliente,$forma_pago,$forma_envio,$id_cliente));
		
		$_SESSION['username'] = $name_cliente;
		$_SESSION['userdoc'] = $doc_cliente;
		$_SESSION['userciudad'] = $ciudad_cliente;
		$_SESSION['userprov'] = $prov_cliente;
		$_SESSION['usertel'] = $movil_cliente;
		$_SESSION['usertelf'] = $fijo_cliente;
		$_SESSION['usermail'] = $mail_cliente;
		$_SESSION['userdir'] = $direccion_cliente;
		$_SESSION['formapago'] = $forma_pago;
		$_SESSION['formenvio'] = $forma_envio;
		$_SESSION['fech_nac'] = $fecha_cliente;
		$_SESSION['genero'] = $genero_cliente;
	}
	include("controlusuarios/seguridadusuario.php");
	
	$query = "SELECT * FROM Concierto WHERE idConcierto = ?";
	$result = $gbd -> prepare($query);
	$result -> execute(array($con));
	echo '<input type="hidden" value="'.$con.'" id="idConcierto"/>';
	
	echo '<input type="hidden" id="data" value="3" />';
?>
<div style="background-color:#282B2D; margin:10px 20px 0px 20px; text-align:center;">
	<div class="breadcrumb">
		<a id="chooseseat" href="?modulo=des_concierto&con=<?php echo $idcon;?>" onclick="chooseasientos()">Escoge tu asiento</a>
		<a id="identification" href="#" onclick="identity()">Identificate</a>
		<a class="active" id="buy" href="#" onclick="security()">Resumen de Compra</a>
		<a id="pay" href="#" onclick="security()">Pagar</a>
		<a id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>
</div>
<div style="margin:-10px;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div class="row">
				<?php if($nombrenuevo != ''){?>
				<h4 style="color:#fff; text-align:center; font-size:22px;">!HOLA <?php echo $nombrenuevo;?></h4>
				<?php }?>
			</div>
			<form id="datos" method="post" action="">
				<div style="font-size:30px; color:#00ADEF; margin:15px;">
					<strong>Confirma tu compra</strong>
				</div>
				<div style="margin:20px;">
					<table style="width:100%; color:#fff;">
						<tr>
							<td>
								<strong>LUGAR DE ENTREGA:</strong>
							</td>
							<td style="color:#FFF100">
								<?php if($_SESSION['formenvio'] == 'correo'){
										echo '<srtong>Correo Electrónico</strong>';
									}else{
										if($_SESSION['formenvio'] == 'Domicilio'){
											echo 'Tu <strong>Dirección de Domicilio</strong>';
										}else{
											if($_SESSION['formenvio'] == 'p_venta'){
												echo 'Un <strong>Punto de Venta</strong> cercano';
											}
										}
									}
								?>
							</td>
							<td>
								<strong>FORMA DE PAGO:</strong>
							</td>
							<td style="color:#FFF100">
								<?php if($_SESSION['formapago'] == 1){
										echo 'Tarjeta de Crédito';
									}else{
										if($_SESSION['formapago'] == 2){
											echo 'Depósito';
										}else{
											if($_SESSION['formapago'] == 3){
												echo 'Punto de Venta';
											}
										}
									}
								?>
							</td>
							<td style="color:#FFF100; text-align:right;">
								<a href="?modulo=des_concierto&con=<?php echo $con;?>">Cancelar Reserva</a>
							</td>
						</tr>
					</table>
				</div>
				<div style="background-color:#00ADEF; margin-left:40px; margin-top:20px; margin-right:-42px; position:relative;">
					<table class="table_resumen_compra">
						<tr>
							<td style="text-align:left; border-right:2px solid #004C6C; width:50%;">
								<strong>Cliente:</strong>
								<?php echo $_SESSION['username'];?>
							</td>
							<td>
								<strong>Documento de Identidad:</strong>
								<?php echo $_SESSION['userdoc'];?>
							</td>
						</tr>
						<tr>
							<td style="border-right:2px solid #004C6C;">
								<strong>E-mail:</strong>
								<?php echo $_SESSION['usermail'];?>
							</td>
							<td>
								<strong>Celular:</strong>
								<?php echo $_SESSION['usertel'];?>
							</td>
						</tr>
						<tr>
							<td style="text-align:left; border-right:2px solid #004C6C; border-bottom:2px solid #004C6C;">
								<strong>Tu Boleto lo obtendras a</strong>
								<?php if($_SESSION['formenvio'] == 'correo'){
									echo '<srtong>tu: E-mail</strong>';
								}else{
									if($_SESSION['formenvio'] == 'Domicilio'){
										echo '<strong>tu: Domicilio</strong>';
									}else{
										if($_SESSION['formenvio'] == 'p_venta'){
											echo '<strong>un: Punto de Venta</strong> cercano';
										}
									}
								}?>
							</td>
							<td style="border-bottom:2px solid #004C6C;">
								<strong>Tel&eacute;fono Fijo:</strong>
								<?php echo $_SESSION['usertelf'];?>
							</td>
						</tr>
						<?php if($_SESSION['formenvio'] == 'Domicilio'){
						echo '<tr>
							<td colspan="2" style="text-align:left; border-right:2px solid #004C6C;">
								<strong>Direcci&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;</strong>
								'.$_SESSION['userdir'].'
							</td>
						</tr>
						<tr>
							<td style="text-align:left; border-right:2px solid #004C6C;">
								<strong>Ciudad:&nbsp;&nbsp;&nbsp;&nbsp;</strong>
								'.$_SESSION['userciudad'].'
							</td>
							<td style="text-align:left">
								<strong>Provincia:&nbsp;&nbsp;&nbsp;&nbsp;</strong>
								'.$_SESSION['userprov'].'
							</td>
						</tr>';
						}?>
						<tr>
							<td>
								<strong>Tu pedido sera enviado al destino antes mencionado</strong>
							</td>
							<td align="right" style="padding-right:45px;">
								<!--<div class="modificar_datos">-->
								<a id="modificar" class="btnlink" style="padding:15px; cursor:pointer;"><img src="imagenes/mano_comprar.png" alt="" style="margin-left:-10px;"/><strong>MODIFICAR</strong></a>
								<!--</div>-->
							</td>
						</tr>
					</table>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="margin:50px 20px 20px 20px;">
					<table style="border: 2px solid #00ADEF; width:100%; color:#fff; font-size:20px; border-collapse:separate; border-spacing:0 20px;">
						<tr style="border-bottom:2px solid #00ADEF;">
								<td style="text-align:center">
									<strong>Asientos #</strong>
								</td>
								<td style="text-align:center">
									<strong>Descripci&oacute;n</strong>
								</td>
								<td style="text-align:center">
									<strong># de Boletos</strong>
								</td>
								<td style="text-align:center">
									<strong>Precio Unitario</strong>
								</td>
								<td style="text-align:center">
									<strong>Precio Total</strong>
								</td>
							</tr>
							<?php
							$suma = 0;
							$cant_bol = 0;
							if(isset($_POST['codigo'])){
								foreach($_POST['codigo'] as $key=>$cod_loc){
									echo'<tr>
										<td style="text-align:center"><input type="hidden" id="codigo" name="codigo[]" value="'.$cod_loc.'" class="added resumen" readonly="readonly" size="2" /><input type="hidden" name="row[]" class="added" value="'.$_POST['row'][$key].'" /><input type="hidden" name="col[]" class="added" value="'.$_POST['col'][$key].'" />
										<input type="text" id="chair" name="chair[]" value="'.$_POST['chair'][$key].'" class="added resumen" readonly="readonly" size="15" /></td>
										<td style="text-align:center"><input type="text" id="des" name="des[]" value="'.$_POST['des'][$key].'" class="added resumen" readonly="readonly" size="15" /></td>
										<td style="text-align:center"><input type="text" id="num" name="num[]" value="'.$_POST['num'][$key].'" class="added resumen" readonly="readonly" size="2" /></td>';
										$selectReserva = "SELECT doublePrecioReserva FROM Localidad WHERE idLocalidad = ?";
										$resultPrecioReserva = $gbd -> prepare($selectReserva);
										$resultPrecioReserva -> execute(array($cod_loc));
										$rowPrecioReserva = $resultPrecioReserva -> fetch(PDO::FETCH_ASSOC);
									echo'<td style="text-align:center"><input type="text" id="pre" name="pre[]" value="'.$rowPrecioReserva['doublePrecioReserva'].'" class="added resumen" readonly="readonly" size="5" /></td>
										<td style="text-align:center" id="filas"><input type="text" id="tot" name="tot[]" value="'.$rowPrecioReserva['doublePrecioReserva'].'" class="added resumen" readonly="readonly" size="5" /></td>
									</tr>';
									$suma += $rowPrecioReserva['doublePrecioReserva'];
									$totalpagar = number_format($suma, 2,'.','');
									$cant_bol +=  $_POST['num'][$key];
								}
							}
							?>
					</table>
				</div>
				<div style="margin:10px 20px;">
					<table style="width:100%; color:#fff; font-size:20px;">
						<tr> 
							<td rowspan="4" style="width:50%; vertical-align:middle;">
								<div class="tiempo_compra">
									<div class="reloj">
										<img src="imagenes/manecillas.png" style="width:100%; max-width:50px; margin-left:20px; margin-top:20px;">
									</div>
									<div style="text-align:center; padding-bottom:15px; padding-left:30px; font-size:18px; margin-top:-90px;">
										Tiempo para realizar la reserva<br>
										<div id="CuentaAtras" style="text-align:center; font-size:25px;"></div>
										<div style="text-align:center;">hour min seg</div>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td style="text-align:right; width:20%;">
								<p><strong>SUBTOTAL</strong></p>
							</td>
							<td style="text-align:right; padding-right:40px;" id="total">
								<?php echo $totalpagar;?>
							</td>
						</tr>
						<tr>
							<td style="text-align:right;">
								<p><strong>Costo de Envio</strong></p>
							</td>
							<td style="text-align:right; padding-right:40px;">
								<?php 
									if($_SESSION['formenvio'] == 'Domicilio'){
										$costoenvio = $rowc['costoenvioC'];
										$costoenvio = number_format($costoenvio,2);
									}else if($_SESSION['formenvio'] != 'Domicilio'){
										$costoenvio = '0.00';
									}
									echo $costoenvio;
									$totalpagar = $totalpagar + $costoenvio;
									$totalpagar = number_format($totalpagar,2);
								?>
							</td>
						</tr>
						<tr>
							<td style="text-align:right; font-size:20px;">
								<p><strong>TOTAL</strong></p>
							</td>
							<td style="text-align:right; font-size:25px; padding-right:40px;">
								<strong><?php echo $totalpagar;?><input type="hidden" id="total_pagar" name="total_pagar" value="<?php echo $totalpagar;?>" class="added resumen" readonly="readonly" size="10"/></strong>
								<input type="hidden" id="num_boletos" name="num_boletos" value="<?php echo $cant_bol;?>" class="added" readonly="readonly" />
							</td>
						</tr>
					</table>
				</div>
				<div style="background-color:#00ADEF; margin-right:40px; margin-top:20px; margin-left:-42px; position:relative;">
					<div class="row">
						<?php $rowc = $result -> fetch(PDO::FETCH_ASSOC);
							$img = $rowc['strImagen'];
							$ruta = 'spadmin/';
							$r = $ruta.$img;
						?>
						<div class="col-lg-5" style="color:#fff;">
							<p>
								<div style="margin:0px 60px 20px 80px; border:1px solid #fff; font-size:30px; padding: 20px">
									<strong><?php echo $rowc['strEvento'];?></strong>
								</div>
							</p>
							<p>
								<div style="margin: 20px 80px; font-size:20px">
									<strong>Fecha: </strong><?php echo $rowc['dateFecha'];?><br>
									<strong>Hora: </strong><?php echo $rowc['timeHora'];?><br>
									<strong>Lugar: </strong><?php echo $rowc['strLugar'];?>
								</div>
							</p>
						</div>
						<div class="col-lg-6">
							<img src="<?php echo $r;?>" id="image" style="width:100%; overflow:hidden;"/>
						</div>
					</div>
					<div class="tra_video_concierto"></div>
					<div class="par_video_concierto"></div>
				</div>
				<div style="margin:20px; border: 2px solid #00ADEF;">
					<table style="width:100%; color:#fff; margin-top:20px; border-collapse:separate; border-spacing:25px; font-size:25px;">
						<tr>
							<td style="text-align:center" colspan="2">
							<strong style="font-size:20px;">Forma de pago:&nbsp;<strong>
								<select name="cmbpago" id="cmbpago" class="inputlogin">
									<option value="<?php echo $_SESSION['formapago'];?>"><?php if($_SESSION['formapago'] == 1){
										echo 'Tarjeta de Crédito';
									}else{
										if($_SESSION['formapago'] == 2){
											echo 'Depósito Bancario';
										}else{
											if($_SESSION['formapago'] == 3){
												echo 'Punto de Venta';
											}
										}
									}
									?></option>
									<?php if($_SESSION['formapago'] == 1){
										echo '<option value="2">Depósito Bancario</option>
											<option value="3">Punto de Venta</option>';
									}else if($_SESSION['formapago'] == 2){
										echo '<option value="1">Tarjeta de Crédito</option>
											<option value="3">Punto de Venta</option>';
									}else if($_SESSION['formapago'] == 3){
										echo '<option value="1">Tarjeta de Crédito</option>
											<option value="2">Depósito Bancario</option>';
									}?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="font-size:15px;">
								<center><p><I>Al hacer click en el bot&oacute;n comprar acepta los T&eacute;rminos, Condiciones y Declaraci&oacute;n de
								Privacidad emitidos por TICKETFACIL.</I></p></center>
							</td>
						</tr>
						<tr>
							<td style="text-align:center; font-size:18px;" colspan="2">
								<label for="check"><input type="checkbox" name="check" id="check"/>
								<I><strong>Acepto los <a href="javascript:op();" style="text-decoration:none;">T&eacute;rminos y Condiciones</a></strong></I></label>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<img src="imagenes/tarjetas.png" style="max-width:270px;"/>&nbsp;
								<img src="imagenes/dinners.png" style="max-width:70px; margin-left:-15px; margin-top:-7px" />&nbsp;
								<img src="imagenes/Pacificard.gif" style="max-width:180px; margin-left:-13px; margin-top:-1px;" />
							</td> 
						</tr>
					</table>
				</div>
				<!--<div class="divbtncompra">-->
					<center><a class="btndegradate" id="aceptar" name="aceptar" style="cursor:pointer;" ><img src="imagenes/mano_comprar.png" alt="" style="margin:0 10px 0 -20px;"/><strong>PAGAR</strong></a></center>
				<!--</div>-->
			</form>
		</div>
		<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<h4 id="alerta1" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert">
								<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Los asientos seleccionados se han perdido, seleccionalos nuevamente.
							</div>
						</h4>
						<h4 id="alerta2" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;El tiempo de la transacción ha terminado.
							</div>
						</h4>
						<h4 id="alerta3" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Debes volver a seleccionar tus asientos.
							</div>
						</h4>
						<h4 id="alerta4" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Para modificar tus datos dale click en "MODIFICAR".
							</div>
						</h4>
						<h4 id="alerta5" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Acepta los terminos de uso y dale click en "PAGAR".
							</div>
						</h4>
						<h4 id="alerta6" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Se abrira su perfil para modificar sus datos.
							</div>
						</h4>
						<h4 id="alerta7" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Te recordamos que tienes 24 horas para registrar tu Deposito.
							</div>
						</h4>
						<h4 id="alerta8" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Tu pago lo puedes efectuar en cualquier:
							</div>
							<div class="row" style="text-align:center;">
								<img src="imagenes/logo_Fybeca.gif" />
							</div>
						</h4>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="terminosdeuso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Terminos de Uso</h4>
					</div>
					<div class="modal-body" style="text-align:center;">
						<h3>TERMINOS DE USO DE TICKETFACIL</h3>
						<p style="text-align:justify;">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus velit nulla, rutrum sit amet aliquet et, blandit ac odio. 
							Maecenas vitae nibh non nisl mollis vestibulum at a dui. Nullam congue ultrices arcu eget convallis. Morbi erat ipsum, fringilla 
							in ultricies mollis, commodo sed neque. Maecenas semper nibh vitae risus suscipit convallis. Etiam non felis imperdiet lorem 
							consectetur feugiat ut ut quam. Praesent et nibh eleifend diam tincidunt eleifend. Quisque euismod, erat et vestibulum blandit, 
							risus diam rhoncus augue, a finibus erat ex a enim. Phasellus convallis est libero, vel blandit dui iaculis eu. Sed eu nisi arcu.
						</p>
						<p style="text-align:justify;">
							Curabitur id orci nec metus facilisis placerat. Sed ornare, lacus malesuada rhoncus malesuada, diam tellus tristique justo, et 
							gravida nisi elit vel mauris. Cras convallis dignissim eros, vitae pellentesque orci aliquam vel. Aenean condimentum mi in 
							lectus dignissim tristique a et orci. In eget aliquet diam, nec mattis sem. Proin eget nibh semper, aliquet felis ut, tempus nibh. 
							Aenean viverra aliquam tellus, at dapibus dui. Suspendisse et enim efficitur, placerat sapien vitae, hendrerit nulla. Donec 
							sed ex ligula. Pellentesque consequat mattis euismod. Integer accumsan sapien massa, ut ullamcorper lorem imperdiet vitae. 
							Integer ut porttitor justo.
						</p>
						<p style="text-align:justify;">
							Curabitur urna velit, gravida sed sapien mollis, elementum porttitor enim. In lobortis dignissim sem laoreet pulvinar. Quisque 
							mi nisi, semper eu varius vel, aliquet a sapien. In aliquet nunc ac tortor dictum varius. Fusce tempus dui nisi, non luctus 
							augue sollicitudin ut. Duis ornare massa quis mauris hendrerit, eu volutpat libero placerat. Praesent tristique nisl vulputate 
							viverra imperdiet.
						</p>
						<p style="text-align:justify;">
							Aenean facilisis tincidunt lacus, molestie lacinia nisl eleifend vel. Pellentesque urna est, interdum sit amet velit sit amet,
							maximus viverra enim. Praesent tempus lacus quis semper malesuada. Fusce finibus et quam vitae vehicula. Vivamus eu 
							felis purus. Suspendisse elit dui, imperdiet sed nibh vel, tincidunt sodales lacus. Sed pharetra ante magna, ut pulvinar nibh 
							finibus ut. Sed gravida dolor condimentum purus faucibus, eget rhoncus leo tristique. Nam blandit auctor diam quis porta. Ut
							malesuada nisl eros, quis elementum elit placerat nec. Proin varius, metus in semper ullamcorper, risus urna posuere felis, 
							vel scelerisque mi urna vel velit. Phasellus leo felis, venenatis in lacus a, vestibulum vulputate elit. Morbi nec felis enim.
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var evento = $('#idConcierto').val();
$( document ).ready(function(){
	$('#aceptar').on('click',function(){
		if($('#check').is(':checked')){
			var pago = $('#cmbpago').val();
			if(pago == 1){
				accion = '?modulo=pagoreserva&evento='+evento;
				$('#datos').attr('action',accion);
			}else if(pago == 2){
				$('#alerta7').fadeIn();
				$('#aviso').modal('show');
				accion = 'subpages/Compras/predepositoreserva.php?evento='+evento;
				$('#datos').attr('action', accion);
			}else if(pago == 3){
				$('#alerta8').fadeIn();
				$('#aviso').modal('show');
				accion = 'subpages/Compras/puntodeventareserva.php?evento='+evento;
				$('#datos').attr('action', accion);
			}
		}else{
			$('#alerta5').fadeIn();
			$('#aviso').modal('show');
		}
	});
	
	if(!document.getElementById('codigo')){
		$('#alerta1').fadeIn();
		$('#aviso').modal('show');
	}
	
	$('#modificar').on('click',function(){
		$('#alerta6').fadeIn();
		$('#aviso').modal('show');
	});
});

$('#cmbpago').on('change',function(){
	var cmb_pago = $('#cmbpago').val();
	if(cmb_pago == 1){
		// accioncmb = '?modulo=pagoreserva&evento='+evento;
		// $('#datos').attr('action',accioncmb);
	}else if(cmb_pago == 2){
		$('#alerta7').fadeIn();
		$('#aviso').modal('show');
		// accioncmb = 'subpages/Compras/predepositoreserva.php?evento='+evento;
		// $('#datos').attr('action',accioncmb);
	}else if(cmb_pago == 3){
		$('#alerta8').fadeIn();
		$('#aviso').modal('show');
		// accioncmb = 'subpages/Compras/puntodeventareserva.php?evento='+evento;
		// $('#datos').attr('action',accioncmb);
	}
});

function chooseasientos(){
	$('#alerta3').fadeIn();
	$('#aviso').modal('show');
}

function identity(){
	$('#alerta4').fadeIn();
	$('#aviso').modal('show');
}

function security(){
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
}

function aceptarModal(){
	if(!$('#alerta1').is(':hidden')){
		window.location = '?modulo=des_concierto&con='+evento;
	}else if(!$('#alerta2').is(':hidden')){
		window.location = '?modulo=des_concierto&con='+evento;
	}else if(!$('#alerta3').is(':hidden')){
		window. location = '?modulo=des_concierto&con='+evento;
	}else if(!$('#alerta6').is(':hidden')){
		$('#datos').attr('action','');
		accionmod = '?modulo=updclientecliente&con='+evento;
		$('#datos').attr('action',accionmod);
		$('#datos').submit();
	}
	$('.alertas').fadeOut();
	$('#aviso').modal('hide');
}

function hablitarboton(){
	if($('#check').is(':checked')){
		$('#aceptar').attr('disabled',false);
	}else{
		$('#aceptar').attr('disabled',true);
	}
}

function op(){
	$('#terminosdeuso').modal('show');
}
	
var totalTiempo=300+300;
var timestampStart = new Date().getTime();
var endTime=timestampStart+(totalTiempo*1000);
var timestampEnd=endTime-new Date().getTime();
var tiempRestante=totalTiempo;

updateReloj();

function updateReloj() {
	var Seconds=tiempRestante;
	
	var Days = Math.floor(Seconds / 86400);
	Seconds -= Days * 86400;

	var Hours = Math.floor(Seconds / 3600);
	Seconds -= Hours * (3600);

	var Minutes = Math.floor(Seconds / 60);
	Seconds -= Minutes * (60);

	var TimeStr = ((Days > 0) ? Days + " dias " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
	
	document.getElementById('CuentaAtras').innerHTML = TimeStr;
	if(endTime<=new Date().getTime())
	{
		document.getElementById('CuentaAtras').innerHTML = "00:00:00";
	}else{
		tiempRestante-=1;
		setTimeout("updateReloj()",1000);
	}
}

function LeadingZero(Time) {
	return (Time < 10) ? "0" + Time : + Time;
}
setTimeout("$('#alerta2').fadeIn(); $('#aviso').modal('show');",600000);
</script>