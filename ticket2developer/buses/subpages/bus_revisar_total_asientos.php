<?php
	session_start();
	$compras=$_SESSION['carrito'];
	$compras_regreso=$_SESSION['carrito_regreso'];
	include 'enoc.php';
	echo $_SESSION['especiales'];
	function RestarHoras($horaini,$horafin){
		$horai=substr($horaini,0,2);
		$mini=substr($horaini,3,2);
		$segi=substr($horaini,6,2);
		$horaf=substr($horafin,0,2);
		$minf=substr($horafin,3,2);
		$segf=substr($horafin,6,2);
		$ini=((($horai*60)*60)+($mini*60)+$segi);
		$fin=((($horaf*60)*60)+($minf*60)+$segf);
		$dif=$fin-$ini;
		$difh=floor($dif/3600);
		$difm=floor(($dif-($difh*3600))/60);
		$difs=$dif-($difm*60)-($difh*3600);
		return date("H-i",mktime($difh,$difm));

	}
?>
	<style>
		.contieneAsientosSeleccionados{
			width:95%;
			height:90%;
			background-color:#fff;
			color:#5E5F5E;
			padding-top:2px;
			padding-bottom:2px;
			text-align:left;
			padding-left:10px
		}
	</style>

	<div class='row' style = 'background-image:url(http://ticketfacil.ec/ticket2/buses/images/busFondo.jpg);background-size:100% 100%;background-repeat: no-repeat;'>
		
		<div class = 'col-md-8'>
			<br/><br/>
			<div class="titulo">
				<div class="row">
					<div class="col-xs-1" style = 'height: 45px'>
						<table width='100%' height='100%' >
							<tr>
								<td valign='middle' align = 'center' class = 'flechas_direccion'>
									<
								</td> 
							</tr>
						</table>
					</div>
					<div class="col-xs-9" >
						RESUMEN DE LA COMPRA
					</div>
					
					<div class="col-xs-1" style = 'height: 45px'>
						<table width='100%' height='100%' >
							<tr>
								<td valign='middle' align = 'center' class = 'flechas_direccion'>
									&gt;
								</td> 
							</tr>
						</table>
						
					</div>
				</div>
			</div><br/><br/>
			<div class='row'>
				
				<div class = 'col-xs-12'>
				
					
					<script type="text/javascript" src="js/jquery.numeric.js"></script>
					<script>
						$( document ).ready(function() {
							$('.entero').numeric();
						});
						function login(){
							var usu_bus = $('#usu_bus').val();
							var pass_bus = $('#pass_bus').val();
							if(usu_bus == ''){
								alert('Ingrese su usuario');
							}
							if(pass_bus == ''){
								alert('Ingrese su contraseña');
							}
							
							if(usu_bus == '' || pass_bus == '' ){
								
							}else{
								$.post("ajax/ajaxLogin.php",{ 
									usu_bus : usu_bus , pass_bus : pass_bus
								}).done(function(data){
									if($.trim(data)!='error'){
										$('#myModal').modal('hide');
										window.location = 'http://ticketfacil.ec/ticket2/buses/index.php?page=bus_paso_3&tyrueiwoqp='+data;
									}
									else if($.trim(data)=='error'){
										alert('Datos ingresados Incorrectos');
									}
								});
							}
						}
						$(function() {
							$("#cedulaCli").focus(function(e){
								$("#cedulaCli").css("background-color", "pink");
								$('#cedulaCli').val('');
							});
							
							$("#cedulaCli").blur(function(e){
								if($("#cedulaCli").val() == ''){
									$("#cedulaCli").val('9999999999');
								}
								$("#cedulaCli").css("background-color", "#fff");
							});
							
							
							
							$(".camposCli6").focus(function(e){
								$(".camposCli6").css("background-color", "pink");
								//$('.camposCli6').val('');
							});
							
							$(".camposCli6").blur(function(e){
								$(".camposCli6").css("background-color", "#fff");
							});
							
							/* */
							$(".camposCli1").focus(function(e){
								$(".camposCli1").css("background-color", "pink");
								//$('.camposCli1').val('');
							});
							
							$(".camposCli1").blur(function(e){
								$(".camposCli1").css("background-color", "#fff");
							});
							
							/* */
							$(".camposCli2").focus(function(e){
								$(".camposCli2").css("background-color", "pink");
								//$('.camposCli2').val('');
							});
							
							$(".camposCli2").blur(function(e){
								$(".camposCli2").css("background-color", "#fff");
							});
							
							/* */
							$(".camposCli3").focus(function(e){
								$(".camposCli3").css("background-color", "pink");
								//$('.camposCli3').val('');
							});
							
							$(".camposCli3").blur(function(e){
								$(".camposCli3").css("background-color", "#fff");
							});
							
							/* */
							$(".camposCli4").focus(function(e){
								$(".camposCli4").css("background-color", "pink");
								//$('.camposCli4').val('');
							});
							
							$(".camposCli4").blur(function(e){
								$(".camposCli4").css("background-color", "#fff");
							});
							
							/* */
							$(".camposCli5").focus(function(e){
								$(".camposCli5").css("background-color", "pink");
								//$('.camposCli5').val('');
							});
							
							$(".camposCli5").blur(function(e){
								$(".camposCli5").css("background-color", "#fff");
							});
						});
					//	buscaCliente();
						function buscaCliente(){
							var cedulaCli = $('#cedulaCli').val();
							//alert(cedulaCli);
							if(cedulaCli == '9999999999' ){
								$('#nomCli').val('consumidor final');
								$('#cedCli').val(cedulaCli);
								$('#corCli').val('n/a');
								$('#dirCli').val('n/a');
								$('#mobCli').val('n/a');
								$('#conCli').val('n/a');
								$('#idUsuario').val(59);
							}else{
								$('.limpiar').val('');
								$.post("subpages/buscarCliente.php",{ 
									cedulaCli : cedulaCli
								}).done(function(json){
								var obj=jQuery.parseJSON(json);
								var busqueda= obj.Search;
								for(i=0; i<= (obj.cliente.length -1); i++){
									var idCliente= obj.cliente[i].idCliente;
									var strNombresC= obj.cliente[i].strNombresC;
									var strDocumentoC= obj.cliente[i].strDocumentoC;
									var strMailC= obj.cliente[i].strMailC;
									var strDireccionC= obj.cliente[i].strDireccionC;
									var intTelefonoMovC= obj.cliente[i].intTelefonoMovC;
									var strTelefonoC= obj.cliente[i].strTelefonoC;
									
									
									$('#idUsuario').val(idCliente);
									$('#nomCli').val(strNombresC);
									$('#cedCli').val(strDocumentoC);
									$('#corCli').val(strMailC);
									$('#dirCli').val(strDireccionC);
									$('#mobCli').val(intTelefonoMovC);
									$('#conCli').val(strTelefonoC);
								}
									
							});
							// window.scroll(0,200);
							}
						}
					</script>
					<?php
						$ciudad_salida_regreso = $_SESSION['ciudad_salida_regreso'];
						$ciudad_llegada_regreso = $_SESSION['ciudad_llegada_regreso'];
						$ciudad_salida = $_SESSION['ciudad_salida'];
						$ciudad_llegada = $_SESSION['ciudad_llegada'];
						
					//	echo $ciudad_salida_regreso."".$ciudad_llegada_regreso."".$ciudad_salida."".$ciudad_llegada;
						
						if((isset($_SESSION['perfil'])) && ($_SESSION['perfil'] == 'cliente')){
					?>
					
					<table width = '100%' style = 'color:#58595B;font-size:12px;background-color: rgba(244 , 245 , 245 , 0.9);border-bottom:1px solid #0386A4;'>
						<tr>
							<td >
								<div style ='padding:10px;'>NOMBRES Y APELLIDOS </div>
								<div class = 'contieneAsientosSeleccionados'><?php echo utf8_decode($_SESSION['username']);?></div>
							</td>
							<td>
								<div style ='padding:10px;'>N° CEDULA  /  PASAPORTE </div>
								<div class = 'contieneAsientosSeleccionados'><?php echo $_SESSION['userdoc'];?></div>
							</td>
						</tr>
						<tr>
							<td>
								<div style ='padding:10px;'>CORREO </div>
								<div class = 'contieneAsientosSeleccionados'><?php echo $_SESSION['usermail'];?></div>
							</td>
							<td>
								<div style ='padding:10px;'>DIRECCIÓN </div>
								<div class = 'contieneAsientosSeleccionados'><?php echo nl2br($_SESSION['userdir']);?></div>
							</td>
						</tr>
						<tr>
							<td>
								<div style ='padding:10px;'>MOBIL </div>
								<div class = 'contieneAsientosSeleccionados'><?php echo $_SESSION['usertel'];?></div>
							</td>
							<td>
								<div style ='padding:10px;'>CONVENCIONAL </div>
								<div class = 'contieneAsientosSeleccionados'><?php echo $_SESSION['usertelf'];?></div>
							</td>
						</tr>
						
					</table>
					<?php
						}
						echo $_SESSION['perfil']." hola";
						if((isset($_SESSION['perfil'])) && ($_SESSION['perfil'] != 'cliente')){
					?>
					
						<div class = 'row' >
							
							<div class="col-lg-11">
								<span style="color:#0386A4;text-transform:capitalize;padding:15px;background-color: #fff">INGRESE C.I. DEl CLIENTE </span><br>
								<br><div class="input-group">
								<input id = 'cedulaCli' type="text" class="form-control entero" placeholder = 'INGRESE C.I. DEl CLIENTE' maxlength = '10' value = '9999999999' />
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" onclick = 'buscaCliente()'>Buscar</button>
								</span>
								</div><br>
								<?php
									$cont4 = "<table width = '100%' style = 'color:#58595B;font-size:12px;background-color: rgba(244 , 245 , 245 , 0.9);border-bottom:1px solid #0386A4;'>";
										$cont4.="<tr>";
											$cont4.="<td >";
												$cont4.="<div style ='padding:10px;'>NOMBRES Y APELLIDOS </div>";
												$cont4.="<div class = 'contieneAsientosSeleccionados'>";
													$cont4.="<input id = 'nomCli' type = 'text' class = 'form-control camposCli1 limpiar' placeholder = 'Nombres y Apellidos' />";
												$cont4.="</div>";
											$cont4.="</td>";
											$cont4.="<td>";
												$cont4.="<div style ='padding:10px;'>N° CEDULA  /  PASAPORTE </div>";
												$cont4.="<div class = 'contieneAsientosSeleccionados'>";
													$cont4.="<input id = 'cedCli' type = 'text' class = 'form-control camposCli2 limpiar' placeholder = 'C.I.' />";
												$cont4.="</div>";
											$cont4.="</td>";
										$cont4.="</tr>";
										$cont4.="<tr>";
											$cont4.="<td>";
												$cont4.="<div style ='padding:10px;'>CORREO </div>";
												$cont4.="<div class = 'contieneAsientosSeleccionados'>";
													$cont4.="<input id = 'corCli' type = 'text' class = 'form-control camposCli3 limpiar' placeholder = 'correo@mail.com'/>";
												$cont4.="</div>";
											$cont4.="</td>";
											$cont4.="<td>";
												$cont4.="<div style ='padding:10px;'>DIRECCIÓN </div>";
												$cont4.="<div class = 'contieneAsientosSeleccionados'>";
													$cont4.="<input id = 'dirCli' type = 'text' class = 'form-control camposCli4 limpiar' placeholder = 'direccion'/>";
												$cont4.="</div>";
											$cont4.="</td>";
										$cont4.="</tr>";
										$cont4.="<tr>";
											$cont4.="<td>";
												$cont4.="<div style ='padding:10px;'>MOBIL </div>";
												$cont4.="<div class = 'contieneAsientosSeleccionados'>";
													$cont4.="<input id = 'mobCli' type = 'text' class = 'form-control camposCli5 limpiar' placeholder = '0999999999'/>";
												$cont4.="</div>";
											$cont4.="</td>";
											$cont4.="<td>";
												$cont4.="<div style ='padding:10px;'>CONVENCIONAL </div>";
												$cont4.="<div class = 'contieneAsientosSeleccionados'>";
													$cont4.="<input id = 'conCli' type = 'text' class = 'form-control camposCli6 limpiar' placeholder = '022222222'/>";
												$cont4.="</div>";
											$cont4.="</td>";
										$cont4.="</tr>";
									$cont4.="</table>";
									echo $cont4;
								?>
							</div>
							
						</div>
					<?php
						}
						$cont = "<table  style = 'background-color: rgba(244 , 245 , 245 , 0.9)' width = '100%' >";
							$cont .= "<tr>";
								$cont .= "<td valign = 'middle' align = 'center'width = '25%'>";
									$cont .= "<span style = 'color:#0D72B9;font-size:4rem'>";
										$cont .= "".count($_SESSION['carrito'])."";
									$cont .= "<span style = 'font-size:1rem;font-weight:bold;'>ASIENTO(S)</span></span>";
								$cont .= "</td>";
							$cont .= "<td valign = 'middle' align = 'left' width = '48%'>";
									$cont .= "<div class = 'contieneAsientosSeleccionados' style = 'width:95%;height:90%;background-color:#fff;color:#5E5F5E;padding-top:2px;padding-bottom:2px;text-align:left;padding-left:10px'>";
										
										$j=0;
										$numerodefilas = (count($compras));
										for($i=0;$i<=count($compras)-1;$i++){
											$j++;
											if ($j<$numerodefilas){
												$txt = " / ";
											}else{
												$txt = "";
											}
											$cont .= "".$compras[$i]['nombre'].$txt."";
										}
										$sql = 'select * from ruta where id = "'.$_SESSION['id_ruta'].'" ';
										$res = mysql_query($sql) or die (mysql_error());
										$row = mysql_fetch_array($res);
										
										$sqlCo = 'select * from cooperativa where id  = "'.$row['coop'].'" ';
										$resCo = mysql_query($sqlCo) or die (mysql_error());
										$rowCo = mysql_fetch_array($resCo);
										
									$cont .= "</div>";
								$cont .= "</td>";
								$cont .= "<td valign = 'middle' align = 'center'>";
									$cont .= "<table>";
										
									$cont .= "</table>";
								$cont .= "</td>";
							$cont .= "</tr>";
							$cont .= "<tr>";
								$cont .= "<td valign = 'middle' align = 'center'>";
									$cont .= "<img src = 'http://ticketfacil.ec/ticket2/buses/images/busIdaResumen.png' style = 'position:relative;left:-10%'/><br/>";
									$cont .= "<span style = 'color:#0386A4;text-transform:capitalize;'>";
										$cont .= "".$rowCo['nom']."";
									$cont .= "</span>";
								$cont .= "</td>";
								$cont .= "<td>";
									
								$sql2 = 'select * from ciudades where id = "'.$row['origen'].'" ';
								$res2 = mysql_query($sql2) or die (mysql_error());
								$row2 = mysql_fetch_array($res2);
								
								
								$sql3 = 'select * from ciudades where id = "'.$row['destino'].'" ';
								$res3 = mysql_query($sql3) or die (mysql_error());
								$row3 = mysql_fetch_array($res3);
								
								$cont .= "<table width = '100%'>";
										$cont .= "<tr>";
											$cont .= "<td valign = 'top' align = 'left'>";
												$cont .= "<span style = 'color:#0386A4;text-transform:uppercase;'>";
													$cont .= "".$row2['nom']."";
												$cont .= "</span><br/>";
												$cont .= "<span style = 'color:#58595B;font-size:12px;'>";
													$cont .= "".$row['fecha']."<br/>";
													$cont .= "".$row['hora']."";
												$cont .= "</span>";
											$cont .= "</td>";
											$cont .= "<td valign = 'top' align = 'left'>";
												
												$sqlEs = 'select * from escalas where id_ruta = "'.$row['id'].'"';
												$resEs = mysql_query($sqlEs) or die (mysql_error());
												$numero_filas = mysql_num_rows($resEs);
												$escalas = '';
												if($numero_filas == 0){
													$cont .= "Sin Escalas";
												}else{
													$nomCiuEsc = '';
													while($rowEs = mysql_fetch_array($resEs)){
														$sqlCiuEsc = 'select nom from ciudades where id = "'.$rowEs['id_ciu_sal'].'" ';
														$resCiuEsc = mysql_query($sqlCiuEsc) or die (mysql_error());
														$rowCiuEsc = mysql_fetch_array($resCiuEsc);
														$nomCiuEsc .= "<span style='font-size:10px;color:#58595B;'>".$rowCiuEsc['nom']."  ".$rowEs['hora']."</span><br/>";
													}
													$escalas = "<span style = 'color:#0386A4;font-size:12px;'>-".$numero_filas." Parada(s)-</span>";
													$cont .= "".$escalas."<br/>".$nomCiuEsc."";
												}
												
											$cont .= "</td>";
											$cont .= "<td valign = 'top' align = 'left'>";
												$cont .= "<span style = 'color:#0386A4;text-transform:uppercase;'>";
													$cont .= "".$row3['nom']."";
												$cont .= "</span><br/>";
												$cont .= "<span style = 'color:#58595B;font-size:12px;'>";
													$cont .= "".$row['fecha']."<br/>";
													$cont .= "".$row['hora_llega']."";
												$cont .= "</span>";
											$cont .= "</td>";
											
											$cont .= "<td valign = 'top' align = 'left'>";
												$cont .= "<span style = 'color:#58595B;font-size:12px;'>";
													$cont .= "Duración : <br/>";
														$horafin = $row['hora_llega'];
														$horaini = $row['hora'];
														$cont .= "".RestarHoras($horaini,$horafin)." hrs"; 
												$cont .= "</span>";
											$cont .= "</td>";
										$cont .= "</tr>";
									$cont .= "</table>";
									$cont .= "</td>";
								$cont .= "<td>";
									
									$precioEspeciales = 0;
									$sumaPrecioEspeciales = 0;
									$precioNormales=0;
									$sumaPrecioNormales=0;
									$normalesPorPrecio=0;
									$especialesPorPrecio=0;
									
									
									for($esp=1;$esp<=$_SESSION['especiales'];$esp++){
										$precioEspeciales = ($compras[$esp]['precio']*0.5);
										$sumaPrecioEspeciales +=($compras[$esp]['precio']*0.5);
										
									}
									
									$asiNormales = (count($compras) - $_SESSION['especiales']);
									$delimitador = ($_SESSION['especiales']+1);
									
									for($i=0;$i<=count($compras)-$delimitador;$i++){
										$precioNormales = $compras[$i]['precio'];
										$sumaPrecioNormales += $compras[$i]['precio'];
									}
								
									$cont .= "<table width = '100%' style = 'color:rgb(110,111,113);font-size:13px;border-left:1px solid rgb(184,184,185);border-bottom:1px solid rgb(184,184,185);'>";
										$cont .= "<tr>";
											$cont .= "<td style = 'border-right:1px solid rgb(184,184,185);'></td>";
											$cont .= "<td style = 'border-right:1px solid rgb(184,184,185);'></td>";
											$cont .= "<td style = 'border-right:1px solid rgb(184,184,185);' align='center'>V. unit</td>";
											$cont .= "<td align='center'>V. Total</td>";
										$cont .= "</tr>";
										$cont .= "<tr>";
											$cont .= "<td align = 'center' style = 'border-right:1px solid rgb(184,184,185);padding-left:5px;'>Nor</td>";
											$cont .= "<td style = 'border-right:1px solid rgb(184,184,185);padding-left:5px;padding-right:5px;' align='center'>";
												$cont .= "".$asiNormales."";
											$cont .= "</td>";
											$cont .= "<td style = 'border-right:1px solid rgb(184,184,185);' align='center'>";
												$cont .= "".number_format(($precioNormales),2)."";
											$cont .= "</td>";
											$cont .= "<td align='center'>";
												$normalesPorPrecio =  number_format(($asiNormales*$precioNormales),2);
												$cont .= "".$normalesPorPrecio."";
											$cont .= "</td>";
										$cont .= "</tr>";
										$cont .= "<tr>";
											$cont .= "<td align = 'center' style = 'border-right:1px solid rgb(184,184,185);padding-left:5px;border-bottom:1px solid rgb(184,184,185);'>Esp</td>";
											$cont .= "<td style = 'border-right:1px solid rgb(184,184,185);padding-left:5px;padding-right:5px;border-bottom:1px solid rgb(184,184,185)' align='center'>";
												$cont .= "".$_SESSION['especiales']."";
											$cont .= "</td>";
											$cont .= "<td style = 'border-right:1px solid rgb(184,184,185);border-bottom:1px solid rgb(184,184,185)' align='center'>";
												$cont .= "".number_format(($precioEspeciales),2)."";
											$cont .= "</td>";
											$cont .= "<td align='center' style = 'border-bottom:1px solid rgb(184,184,185)'>";
												$especialesPorPrecio =  number_format(($_SESSION['especiales']*$precioEspeciales),2);
												$cont .= "".$especialesPorPrecio."";
											$cont .= "</td>";
										$cont .= "</tr>";
										$cont .= "<tr>";
											$cont .= "<td align = 'center' style = 'border:1px solid rgb(235,237,239);padding-top:10px;'>V. IDA</td>";
											$cont .= "<td style = 'border:1px solid rgb(235,237,239);' align='center'></td>
											<td style = 'border:1px solid rgb(235,237,239);' align='center'></td>";
											$cont .= "<td align='center' style = 'color:rgb(3,134,164);border:1px solid rgb(235,237,239);padding-top:10px;' >";
												$cont .= "".number_format(($especialesPorPrecio + $normalesPorPrecio),2)."";
											$cont .= "</td>";
										$cont .= "</tr>";
									$cont .= "</table>";
								$cont .= "</td>";
							$cont .= "</tr>";
						$cont .= "</table>";
						echo $cont;
				if($_SESSION['saber_ida_vuelta']!=0){
							
					$cont2 = "<table  style = 'background-color: rgba(244 , 245 , 245 , 0.9);border-top:1px solid #0386A4;' width = '100%' >";
						$cont2 .= "<tr>";
							$cont2 .= "<td valign = 'middle' align = 'center'width = '25%'>";
								$cont2 .= "<span style = 'color:#0D72B9;font-size:4rem'>".count($_SESSION['carrito_regreso'])."<span style = 'font-size:1rem;font-weight:bold;'>ASIENTO(S)</span></span>";
							$cont2 .= "</td>";
							$cont2 .= "<td valign = 'middle' align = 'left' width = '48%'>";
								$cont2 .= "<div class = 'contieneAsientosSeleccionados' style = 'width:95%;height:90%;background-color:#fff;color:#5E5F5E;padding-top:2px;padding-bottom:2px;text-align:left;padding-left:10px'>";
								
									$m=0;
									$numerodefilas2 = (count($compras_regreso));
									for($l=0;$l<=count($compras_regreso)-1;$l++){
										$m++;
										if ($m<$numerodefilas2){
											$txt1 = " / ";
										}else{
											$txt1 = "";
										}
										$cont2 .= "".$compras_regreso[$l]['nombre'].$txt1."";
									}
									$sqlA = 'select * from ruta where id = "'.$_SESSION['id_ruta_regreso'].'" ';
									$resA = mysql_query($sqlA) or die (mysql_error());
									$rowA = mysql_fetch_array($resA);
									
									$sqlCoA = 'select * from cooperativa where id  = "'.$rowA['coop'].'" ';
									$resCoA = mysql_query($sqlCoA) or die (mysql_error());
									$rowCoA = mysql_fetch_array($resCoA);
									
								$cont2 .= "</div>";
							$cont2 .= "</td>
							<td valign = 'middle' align = 'center'>
								<table>
									
								</table>
							</td> 
						</tr>";
						$cont2 .= "<tr>";
							$cont2 .= "<td valign = 'middle' align = 'center'>";
								$cont2 .= "<img src = 'http://ticketfacil.ec/ticket2/buses/images/busVueltaResumen.png' style = 'position:relative;left:-10%'/><br/>";
								$cont2 .= "<span style = 'color:#0386A4;text-transform:capitalize;'>";
									$cont2 .= "".$rowCoA['nom']."";
								$cont2 .= "</span>";
							$cont2 .= "</td>";
							$cont2 .= "<td>";
								
								$sql2A = 'select * from ciudades where id = "'.$rowA['origen'].'" ';
								$res2A = mysql_query($sql2A) or die (mysql_error());
								$row2A = mysql_fetch_array($res2A);
								
								
								$sql3A = 'select * from ciudades where id = "'.$rowA['destino'].'" ';
								$res3A = mysql_query($sql3A) or die (mysql_error());
								$row3A = mysql_fetch_array($res3A);

								$cont2 .= "<table width = '100%'>";
									$cont2 .= "<tr>";
										$cont2 .= "<td valign = 'top' align = 'left'>";
											$cont2 .= "<span style = 'color:#0386A4;text-transform:uppercase;'>";
												$cont2 .= "".$row2A['nom']."";
											$cont2 .= "</span><br/>";
											$cont2 .= "<span style = 'color:#58595B;font-size:12px;'>";
												$cont2 .= "".$rowA['fecha']."<br/>";
												$cont2 .= "".$rowA['hora']."";
											$cont2 .= "</span>";
										$cont2 .= "</td>";
										$cont2 .= "<td valign = 'top' align = 'left'>";
											
											$sqlEsA = 'select * from escalas where id_ruta = "'.$rowA['id'].'"';
											$resEsA = mysql_query($sqlEsA) or die (mysql_error());
											$numero_filasA = mysql_num_rows($resEsA);
											$escalasA = '';
											if($numero_filasA == 0){
												$cont2 .= "Sin Escalas";
											}else{
												$nomCiuEscA = '';
												while($rowEsA = mysql_fetch_array($resEs)){
													$sqlCiuEscA = 'select nom from ciudades where id = "'.$rowEsA['id_ciu_sal'].'" ';
													//echo $sqlCiuEsc."<br/>";
													$resCiuEscA = mysql_query($sqlCiuEscA) or die (mysql_error());
													$rowCiuEscA = mysql_fetch_array($resCiuEscA);
													$nomCiuEscA .= "<span style='font-size:10px;color:#58595B;'>".$rowCiuEscA['nom']."  ".$rowEsA['hora']."</span><br/>";
												}
												$escalasA = "<span style = 'color:#0386A4;font-size:12px;'>-".$numero_filasA." Parada(s)-</span>";
												$cont2 .= "".$escalasA."<br/>".$nomCiuEscA."";
											}
											
										$cont2 .= "</td>";
										$cont2 .= "<td valign = 'top' align = 'left'>";
											$cont2 .= "<span style = 'color:#0386A4;text-transform:uppercase;'>";
												$cont2 .= "".$row3A['nom']."";
											$cont2 .= "</span><br/>";
											$cont2 .= "<span style = 'color:#58595B;font-size:12px;'>";
												$cont2 .= "".$rowA['fecha']."";
												$cont2 .= "<br/>";
												$cont2 .= "".$rowA['hora_llega']."";
											$cont2 .= "</span>";
										$cont2 .= "</td>";
										
										$cont2 .= "<td valign = 'top' align = 'left'>";
											$cont2 .= "<span style = 'color:#58595B;font-size:12px;'>";
												$cont2 .= "Duración : <br/>";
												$horafinA = $rowA['hora_llega'];
												$horainiA = $rowA['hora'];
												$cont2 .= "".RestarHoras($horainiA,$horafinA)." hrs"; 
											$cont2 .= "</span>";
										$cont2 .= "</td>";
									$cont2 .= "</tr>";
								$cont2 .= "</table>";
							$cont2 .= "</td>";
							$cont2 .= "<td>";
								
								$precioEspecialesRegreso = 0;
								$sumaPrecioEspecialesRegreso = 0;
								$precioNormalesRegreso=0;
								$sumaPrecioNormalesRegreso=0;
								$normalesPorPrecioRegreso=0;
								$especialesPorPrecioRegreso=0;
								
								
								for($esp=1;$esp<=$_SESSION['especiales'];$esp++){
									$precioEspecialesRegreso = ($compras_regreso[$esp]['precio']*0.5);
									$sumaPrecioEspecialesRegreso +=($compras_regreso[$esp]['precio']*0.5);
									
								}
								
								$asiNormalesRegreso = (count($compras_regreso) - $_SESSION['especiales']);
								$delimitadorRegreso = ($_SESSION['especiales']+1);
								
								for($i=0;$i<=count($compras_regreso)-$delimitadorRegreso;$i++){
									$precioNormalesRegreso = $compras_regreso[$i]['precio'];
									$sumaPrecioNormalesRegreso += $compras_regreso[$i]['precio'];
								}

								
							$cont2 .= "
								<table width = '100%' style = 'color:rgb(110,111,113);font-size:13px;border-left:1px solid rgb(184,184,185);border-bottom:1px solid rgb(184,184,185);'>
									<tr>
										<td style = 'border-right:1px solid rgb(184,184,185);'>
											
										</td>
										<td style = 'border-right:1px solid rgb(184,184,185);'>
											
										</td>
										<td style = 'border-right:1px solid rgb(184,184,185);' align='center'>
											V. unit
										</td>
										<td align='center'>
											V. Total
										</td>
									</tr>
									<tr>
										<td align = 'center' style = 'border-right:1px solid rgb(184,184,185);padding-left:5px;'>
											Nor
										</td>
										<td style = 'border-right:1px solid rgb(184,184,185);padding-left:5px;padding-right:5px;' align='center'>
									";
											$cont2 .= "".$asiNormalesRegreso."";
										$cont2 .= "</td>
										<td style = 'border-right:1px solid rgb(184,184,185);' align='center'>";
											$cont2 .= "".number_format(($precioNormalesRegreso),2)."";
										$cont2 .= "</td>
										<td align='center'>";
											$normalesPorPrecioRegreso =  number_format(($asiNormalesRegreso * $precioNormalesRegreso),2);
											$cont2 .= "".$normalesPorPrecioRegreso."";
										$cont2 .= "
										</td>
									</tr>
									
									
									<tr>
										<td align = 'center' style = 'border-right:1px solid rgb(184,184,185);padding-left:5px;border-bottom:1px solid rgb(184,184,185);'>
											Esp
										</td>
										<td style = 'border-right:1px solid rgb(184,184,185);padding-left:5px;padding-right:5px;border-bottom:1px solid rgb(184,184,185)' align='center'>
									";
										$cont2 .= "".$_SESSION['especiales']."";
										$cont2 .= "</td>
										<td style = 'border-right:1px solid rgb(184,184,185);border-bottom:1px solid rgb(184,184,185)' align='center'>";
											$cont2 .= "".number_format(($precioEspecialesRegreso),2)."";
										$cont2 .= "</td>
										<td align='center' style = 'border-bottom:1px solid rgb(184,184,185)'>";
											$especialesPorPrecioRegreso =  number_format(($_SESSION['especiales'] * $precioEspecialesRegreso),2);
											$cont2 .= "".$especialesPorPrecioRegreso."";
										$cont2 .= "
										</td>
									</tr>
									<tr>
										<td align = 'center' style = 'border:1px solid rgb(235,237,239);padding-top:10px;'>
											V. REG
										</td>
										<td style = 'border:1px solid rgb(235,237,239);' align='center'>
											
										</td>
										<td style = 'border:1px solid rgb(235,237,239);' align='center'>
											
										</td>
										<td align='center' style = 'color:rgb(3,134,164);border:1px solid rgb(235,237,239);padding-top:10px;' >
										";
											$cont2 .= "".number_format(($especialesPorPrecioRegreso + $normalesPorPrecioRegreso),2)."";
										$cont2 .= "
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>";
					echo $cont2;
				}
			
					$cont3 ="<table  style = 'background-color: rgba(244 , 245 , 245 , 0.9);' width = '100%' >";
						$cont3 .="<tr>";
							$cont3 .="<td width = '33.33%'>
								
							</td>
							<td width = '33.33%'>
								
							</td>
							<td width = '33.33%' style = 'padding:10px;text-align:center;background-color:rgb(3,134,164);color:#fff;'>
								TOTAL VENTA : ";
							
								$total_venta =  number_format((($especialesPorPrecio + $normalesPorPrecio) + ($especialesPorPrecioRegreso + $normalesPorPrecioRegreso)),2);
								$cont3 .="".$total_venta."";
								$_SESSION['total_venta'] = $total_venta;
													
							$cont3 .="</td>
						</tr>
					</table>";
					echo $cont3;
					$_SESSION['cont'] = $cont;
					$_SESSION['cont2'] = $cont2;
					$_SESSION['cont3'] = $cont3;
					// $_SESSION['cont4'] = $cont4;
					$contenido = $_SESSION['cont4']."<br>".$_SESSION['cont']."<br>".$_SESSION['cont2']."<br>".$_SESSION['cont3'];
					
					//echo $contenido;
				?>
				</div>
				
			</div>
			
			
			<div class='row'>
				<div class = 'col-xs-1'></div>
				<div class = 'col-xs-10' style = 'text-align:center;'>
					
					<div id = 'recibeRuta'></div>
				</div>
				<div class = 'col-xs-1'></div>
			</div>
		<?php
			if((isset($_SESSION['perfil'])) && ($_SESSION['perfil'] == 'cliente')){
		?>
			<table style=" background-color: rgba(35, 31, 32, 0.7);color: #fff;font-size: 18px;font-weight: 300;width:70%;" width = '70%' align = 'center'>
				<tr>
					<td valign = 'middle' align = 'center'>
						Forma de Pago
					</td>
					<td>
						<select class = 'form-control' id = 'cbo_Pago' style = 'text-transform:uppercase;'>
							<option value = ''>Seleccione</option>
							<option value = '1' ruta = 'web'>Punto de Venta</option>
							<option value = '2' ruta = 'web'>Tarjeta de Credito</option>
							<option value = '3' ruta = 'web'>Deposito</option>
						</select>
					</td>
				</tr>
			</table>
		<?php
			}elseif((isset($_SESSION['perfil'])) && ($_SESSION['perfil'] != 'cliente')){
		?>
			<table style=" background-color: rgba(35, 31, 32, 0.7);color: #fff;font-size: 18px;font-weight: 300;width:70%;" width = '70%' align = 'center'>
				<tr>
					<td valign = 'middle' align = 'center'>
						Forma de Pago
					</td>
					<td>
						<select class = 'form-control' id = 'cbo_Pago' style = 'text-transform:uppercase;'>
							<option value="">Seleccione</option>
							<option value="5" ruta = 'pventa'>Tarjeta de Crédito(POS)</option>
							<option value="6" ruta = 'pventa'>Efectivo</option>
						</select>
					</td>
				</tr>
			</table>
		<?php
			}
		?>
		</div>
		<div class = 'col-md-3' style='margin:0;padding:0;'>
			<div class = 'titulo2'>
				<p style = 'color:#26A9E0;font-family:Helvetica;font-size:23pt;font-weight:300;'>
					SOLO EN 3 PASOS LLEGARÁS A TU DESTINO
				</p>
				<hr/>
				<p style = 'color:#fff;font-family:Helvetica;font-size:13pt;font-weight:300;'>
					AGILITA TU COMPRA
					CON LA TARIFA
					MÁS ECONÓMICA
					DEL MERCADO
				</p>
				<br/>
			<!--
			<table width = '100%'>
					<tr>
						<td style = 'color:#fff;font-size:15pt;font-family:Helvetica;font-weight:bold;' colspan = '3' >
							SELECCIONA
						</td>
					</tr>
					<tr>
						<td><img src = 'http://ticketfacil.ec/ticket2/buses/images/triangulo.png' /></td>
						<td><img src = 'http://ticketfacil.ec/ticket2/buses/images/btnIda.png' /></td>
						<td><img src = 'http://ticketfacil.ec/ticket2/buses/images/btnRegreso.png' /></td>
					</tr>
				</table>-->
			<?php
				if(!isset($_SESSION['perfil'])){
			?>
				<img src = 'http://ticketfacil.ec/ticket2/buses/images/siguiente.png' onclick = '$("#mostrar_login_compra").modal("show");' style = 'margin-left:-15px;cursor:pointer;' id = 'posSigui' data-toggle="modal" data-target="#myModal"/>
			<?php
				}else{
					$_SESSION['sesion_usuario'] = $_REQUEST['tyrueiwoqp'];
					echo "<input readonly disabled type = 'text' id = 'idUsuario' style = 'background-color: transparent;border: none;color: transparent;' />";
			?>				
				<img src = 'http://ticketfacil.ec/ticket2/buses/images/siguiente.png' style = 'margin-left:-15px;cursor:pointer;' id = 'posSigui' onclick = 'enviaPago()' />
				<center><img src = 'http://ticketfacil.ec/ticket2/buses/images/ajax-loader.gif' style = 'display:none;' id = 'loadImg'/></center>
			<?php
				}
			?>
			</div>
		</div>
		
		<div class="modal fade in" id="mostrar_login_compra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="false">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="background-color:#333333; color:#fff;">
					<div class="modal-header" style="border-bottom:none;">
						<button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					</div>
					<div class="modal-body">
					<div style="border:2px solid #00ADEF;">
						<div style="background-color:#00ADEF; color:#fff; margin:20px 70% 20px 0px; padding-left:30px; font-size:25px;">
							<strong>Login</strong>
						</div>
						<div style="background-color:#EC1867; margin:10px -18px 10px 50%; font-size:18px; position:relative;">
							<img src="imagenes/mano_comprar.png" alt=""><button type="button" id="btn_account" onclick="crearcuentacomprar()" class="btn_compra_online"><strong>+ CREAR CUENTA</strong></button>
							<div class="tra_comprar_concierto"></div>
							<div class="par_comprar_concierto"></div>
						</div>
						<div style="background-color:#00ADEF; margin:30px -18px 20px 40px; position:relative;">
							<table style="width:100%; color:#fff; font-size:20px;">
								<tbody><tr>
									<td colspan="2" style="padding-bottom:0px; padding-top:20px;">
										<center><i><p>Si ya tienes una cuenta en <strong>TICKETFACIL</strong> ingresa tu <strong>USUARIO</strong> y <strong>CONTRASEÑA</strong></p></i></center>
										<center><i><p>o si no <strong>CREA TU CUENTA</strong> y disfruta de una nueva experiencia en linea</p></i></center>
									</td>
								</tr>
								<!--<tr>
									<td style="text-align:center; padding-bottom:20px; padding-top:10px; padding-right:25px;">
										<p style="display:none" class="cuentaOk">Usuario(e-mail): </p>
									</td>
								</tr>-->
								<tr>
									<td style="text-align:left; padding:10px 30px;">
										<h4 class="cuentaOk_compra" style="display:none; color:#fff;">Usuario(E-mail):</h4>
										<input id="user_compra" class="cuentaOk_compra inputlogin form-control" placeholder="Usuario(E-mail)" style="display:none" autocomplete="off" type="text">
									</td>
								</tr>
								<!--<tr>
									<td style="text-align:center; padding-top:10px; padding-right:25px;">
										<p style="display:none" class="cuentaOk">Contrase&ntilde;a: </p>
									</td>
								</tr>-->
								<tr>
									<td style="text-align:left; padding:10px 30px;">
										<h4 class="cuentaOk_compra" style="display:none; color:#fff;">Contraseña:</h4>
										<input id="pass_compra" class="cuentaOk_compra inputlogin form-control" placeholder="Contraseña" style="display:none" autocomplete="off" type="password">
									</td>
								</tr>
								
								<tr class="ocultar_text_login_compra" align="center">
									<td>
										<br>
										<img src="../imagenes/faceNuevo.png" onclick="ingresar();" style="cursor:pointer;"><br>
										Ingresar con Facebook
										<div style="display:none;">
											<span id="nombreUsuFace">!!!</span>
											<span id="nombreUsuEmail">!!!</span>
											<span id="nombreUsuPass">!!!</span>
											<span id="fecha">!!!</span>
											<span id="sexo">!!!</span>
										</div>
									</td>
								</tr>
								
								
								<tr class="ocultar_text_login_compra" align="center">
									<td>
										<button type="" class="btn_login" onclick="crearcuentacomprar()">CREAR CUENTA</button>
									</td>
								</tr>
								<tr class="ocultar_text_login_compra" align="center">
									<td>
										<br>
										<button type="button" class="btn_login" onclick="mostrar_login_compra()">INGRESAR</button>
									</td>
								</tr>
								
								
								<tr>
									<td style="text-align:right; padding-right:15px;">
										<h4 class="cuentaOk_compra" style="display:none; cursor:pointer;" onclick="recuperarcontrasena()"><i>Olvido su contraseña?</i></h4>
										<h4 class="cuentaOk_compra" style="display:none; cursor:pointer;" onclick="recuperarnombre()"><i>Olvido su nombre de usuario?</i></h4>
									</td>
								</tr>
								<tr align="center">
									<td colspan="2" style="padding:30px;">
										<button type="button" class="btn_login cuentaOk_compra" style="display:none" onclick="validardatos_compra()"><strong>ACEPTAR</strong></button>
										<img src="imagenes/ajax-loader.gif" alt="" id="imgif" name="imgif" style="display:none">
									</td>
								</tr>
							</tbody></table>
							<div class="tra_azul"></div>
							<div class="par_azul"></div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="mostrar_login_reserva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="background-color:#333333; color:#fff;">
				<div class="modal-header" style="border-bottom:none;">
					<button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				</div>
				<div class="modal-body">
				<div style="border:2px solid #00ADEF;">
					<div style="background-color:#00ADEF; color:#fff; margin:20px 70% 20px 0px; padding-left:30px; font-size:25px;">
						<strong>Login</strong>
					</div>
					<div style="background-color:#EC1867; margin:10px -18px 10px 50%; font-size:18px; position:relative;">
						<img src="imagenes/mano_comprar.png" alt="" /><button type="button" id="btn_account" onclick="crearcuentareserva()" class="btn_compra_online"><strong>+ CREAR CUENTA</strong></button>
						<div class="tra_comprar_concierto"></div>
						<div class="par_comprar_concierto"></div>
					</div>
					<div style="background-color:#00ADEF; margin:30px -18px 20px 40px; position:relative;">
						<table style="width:100%; color:#fff; font-size:20px;">
							<tr>
								<td colspan="2" style="padding-bottom:50px; padding-top:40px;">
									<center><I><p>Si ya tienes una cuenta en <strong>TICKETFACIL</strong> ingresa tu <strong>USUARIO</strong> y <strong>CONTRASE&Ntilde;A</strong></p></I></center>
									<center><I><p>o si no <strong>CREA TU CUENTA</strong> y disfruta de una nueva experiencia en linea</p></I></center>
								</td>
							</tr>
							<!--<tr>
								<td style="text-align:center; padding-bottom:20px; padding-top:10px; padding-right:25px;">
									<p style="display:none" class="cuentaOk">Usuario(e-mail): </p>
								</td>
							</tr>-->
							<tr>
								<td style="text-align:left; padding:10px 30px;">
									<h4 class="cuentaOk_reserva" style="display:none; color:#fff;">Usuario(E-mail):</h4>
									<input type="text" id="user_reserva" class="cuentaOk_reserva inputlogin form-control" placeholder="Usuario(E-mail)" style="display:none" autocomplete="off" />
								</td>
							</tr>
							<!--<tr>
								<td style="text-align:center; padding-top:10px; padding-right:25px;">
									<p style="display:none" class="cuentaOk">Contrase&ntilde;a: </p>
								</td>
							</tr>-->
							<tr>
								<td style="text-align:left; padding:10px 30px;">
									<h4 class="cuentaOk_reserva" style="display:none; color:#fff;">Contraseña:</h4>
									<input type="password" id="pass_reserva" class="cuentaOk_reserva inputlogin form-control" placeholder="Contraseña" style="display:none" autocomplete="off" />
								</td>
							</tr>
							<tr class="ocultar_text_login_reserva" align="center">
								<td>
									<button type="" class="btn_login" onclick="crearcuentareserva()" >CREAR CUENTA</button>
								</td>
							</tr>
							<tr class="ocultar_text_login_reserva" align="center">
								<td>
									<br>
									<button type="button" class="btn_login" onclick="mostrar_login_reserva()">INGRESAR</button>
								</td>
							</tr>
							<tr>
								<td style="text-align:right; padding-right:15px;">
									<h4 class="cuentaOk_reserva" style="display:none; cursor:pointer;" onclick="recuperarcontrasena()"><I>Olvido su contraseña?</I></h4>
									<h4 class="cuentaOk_reserva" style="display:none; cursor:pointer;" onclick="recuperarnombre()"><I>Olvido su nombre de usuario?</I></h4>
								</td>
							</tr>
							<tr align="center">
								<td colspan="2" style="padding:30px;">
									<button type="button" class="btn_login cuentaOk_reserva" style="display:none" onclick="validardatos_reserva()"><strong>ACEPTAR</strong></button>
									<img src="imagenes/ajax-loader.gif" alt="" id="imgif" name="imgif" style="display:none" />
								</td>
							</tr>
						</table>
						<div class="tra_azul"></div>
						<div class="par_azul"></div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
				</div>
				<div class="modal-body">
					<h4 id="alerta1" class="alertas" style="display:none;">
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
							&nbsp;&nbsp;<strong>Error...!</strong>&nbsp;Debes seleccionar asientos primero.
						</div>
					</h4>
					<h4 id="alerta2" class="alertas" style="display:none;">
						<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
							&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Escoge tus asientos para continuar con los pasos.
						</div>
					</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="recuperarcontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Envio de email</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<h4>Ingrese su correo electrónico</h4>
							<input type="text" id="mailrecuperar" class="form-control" placeholder="Ingrese su correo electrónico" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="aceptarcontrasena()" id="enviarcambio">Enviar</button>
					<img src="imagenes/loading.gif" style="display:none; max-width:50px;" id="waitcambio">
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="nuevacontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Cambio de contraseña</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<h4>Ingrese su código</h4>
							<input type="text" id="codigorecuperar" class="form-control" placeholder="Ingrese el código enviado a su correo electrónico" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<h4>Nueva contraseña</h4>
							<input type="password" id="passrecuperar" class="form-control" placeholder="**********" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<h4>Repita la contraseña</h4>
							<input type="password" id="passrecuperar1" class="form-control" placeholder="**********" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="confirmarcambio()" id="btnokcambio">Guardar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="recuperarnombre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Recuperar Nombre de Usuario (E-mail)</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<h4>Ingrese su número de documento</h4>
							<input type="text" id="cedularecuperar" class="form-control" placeholder="Ingrese su número de identificación..." />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<h4>Ingrese su fecha de nacimiento</h4>
							<div class="row">
								<div class="col-lg-3">
									<strong>Año</strong>
									<select id="aniorecuperar" class="inputlogin form-control">
										<option value="1">Año</option>
										<?php for($i = $anio; $i > 1930; $i--){?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php }?>
									</select>
								</div>
								<div class="col-lg-3">
									<strong>Mes</strong>
									<select id="mesrecuperar" class="inputlogin form-control">
										<option value="0">Mes</option>
										<option value="01">Enero</option>
										<option value="02">Febrero</option>
										<option value="03">Marzo</option>
										<option value="04">Abril</option>
										<option value="05">Mayo</option>
										<option value="06">Junio</option>
										<option value="07">Julio</option>
										<option value="08">Agosto</option>
										<option value="09">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</div>
								<div class="col-lg-3">
									<strong>Día</strong>
									<select id="diarecuperar" class="inputlogin form-control">
										<option value="0">Día</option>
										<?php for($j = 1; $j <= 31; $j++){?>
										<option value="<?php echo $j;?>"><?php echo $j;?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<h4>Ingrese su número de celular</h4>
							<input type="text" id="celularrecuperar" class="form-control" placeholder="Ingrese el número de celular ingresado al crear la cuenta..." />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="aceptarnombre()" id="enviarnombre">Enviar</button>
					<img src="imagenes/loading.gif" style="display:none; max-width:50px;" id="waitnombre">
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="errorcontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>Error...!</strong>&nbsp;El correo electrónico ingresado es incorrecto.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="errorvalidacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>Error...!</strong>&nbsp;Los datos ingresados son incorrectos.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="nombreok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
						&nbsp;Se ha recuperado exitosamente tu nombre de usuario.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptaroknombre()">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="mensajeenviado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
						&nbsp;Se ha enviado un código a tu correo electrónico, revisalo y sigue los pasos.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarmensaje()">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="cambiook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
						&nbsp;Tu contraseña se ha modificado con éxito.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarcambiook()">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
		<script>
			function asignaSinNum(){
				$('#seleccion').html('');
				var sinNumeracion = $('#sinNumeracion').val();
				//alert(sinNumeracion);
				var precioLocalidadSinNum = $('#precioLocalidadSinNum').val();
				var localidadSinNum = $('#localidadSinNum').val();
				var nomLoc = $('#nomLoc').text();
				var l = 0;
				for(var m = 1; m <= sinNumeracion; m++){
					l++
					$('#seleccion').append('<tr class = "filaSinNumeracion_'+m+' asientosescogidos">\
												<td style="text_align:center; border:none;">\
													<center>\
														<font color="#000">\
															<input name="codigo[]" class="added" value="'+localidadSinNum+'" readonly="readonly" size="5" type="text">\
															<input class="added" name="row[]" value="0" type="hidden">\
															<input class="added" name="col[]" value="0" type="hidden">\
														</font>\
													</center>\
												</td>\
												<td>\
													<center><font color="#000"><input name="chair[]" class="added" value="'+m+'" readonly="readonly" size="15" type="text"></font></center>\
												</td>\
												<td>\
													<center><font color="#000"><input name="des[]" class="added" value="'+nomLoc+'" readonly="readonly" size="10" type="text"></font></center>\
												</td>\
												<td>\
													<center><font color="#000"><input name="num[]" class="added" value="1" readonly="readonly" size="10" type="text"></font></center>\
												</td>\
												<td>\
													<center><font color="#000"><input name="pre[]" class="added" value="'+precioLocalidadSinNum+'" readonly="readonly" size="10" type="text"></font></center>\
												</td>\
												<td>\
													<center><font color="#000"><input name="tot[]" class="added" value="'+precioLocalidadSinNum+'" readonly="readonly" size="10" type="text"></font></center>\
												</td>\
												<td>\
													<center><font color="#000"><button type="button" class="btn_eliminar" id="delete86" onclick="elimanarFila('+m+')">Eliminar</button></font></center>\
												</td>\
											</tr>');
				}
				
			}
			function elimanarFila(id){
				$('.filaSinNumeracion_'+id).remove();
			}
			function redimencionVideo(){
				var widthVideo = $('#contieneVideo').width();
				var heightVideo = $('#contieneVideo').height();
				$('#videoEvento').css('width',widthVideo);
				$('#videoEvento').css('height',heightVideo);
				//alert(heightVideo)
			}
			$( document ).ready(function() {
				console.log( "ready!" );
				redimencionVideo();
			});
			$(window).resize(function(){
				redimencionVideo();
			});
		  
						(function(d,s,id) {  
							var js, fjs = d.getElementsByTagName(s)[0];  
							if(d.getElementById(id)) return;  
							js = d.createElement(s); js.id = id;  
							js.src = "http://connect.facebook.net/en_US/sdk.js";  
							fjs.parentNode.insertBefore(js, fjs);  
						}(document, 'script', 'facebook-jssdk'));  
			  
						window.fbAsyncInit = function() {
							FB.init({
								appId      : '420099668326698',
								xfbml      : true,
								version    : 'v2.8'
							});
							FB.AppEvents.logPageView();
						};
			  
			function ingresar() {  
				FB.login(function(response){  
					validarUsuario();  
				}, {scope: 'email'});  
			}  
			function validarUsuario() {  
				FB.getLoginStatus(function(response) {  
					if(response.status == 'connected') {  
						FB.api(
							'/me',
							'GET',
							{"fields":"id,name,birthday,email,gender,permissions"},
							function(response) {
								//alert(JSON.stringify(response));
								var id_face = response.id;
								var email_face = response.email;
								var nombre = response.name;
								var birthday = response.birthday;
								var gender = response.gender;
								$('#nombreUsuFace').html('!!!  ' + nombre);
								$('#nombreUsuEmail').html('!!!  ' + email_face);
								$('#nombreUsuPass').html('!!!  ' + id_face);
								$('#fecha').html('!!!  ' + birthday);
								$('#sexo').html('!!!  ' + gender);
								$.post("../autenticaFb.php",{ 
									id_face : id_face , email_face : email_face , nombre : nombre , birthday : birthday , gender : gender
								}).done(function(data){
									window.location = '';
								});
							}
						);
					} else if(response.status == 'not_authorized') {  
						alert('Debes autorizar la app!');  
					} else {  
						alert('Debes ingresar a tu cuenta de Facebook!');  
					}  
				});  
		   }
			function enviaPago(){
				var idUsuario = $('#idUsuario').val();
				
				var cbo_Pago = $('#cbo_Pago').val();
				if(cbo_Pago == ''){
					alert('Seleccione una forma de pago');
				}
				
				if(idUsuario == ''){
					alert('Seleccione un cliente');
				}
				
				if(cbo_Pago == '' || idUsuario == ''){
					
				}else{
					alert(idUsuario)
					$('#loadImg').css('display','block');
					$.post("ajax/pagoPuntoVenta.php",{ 
						cbo_Pago : cbo_Pago , idUsuario : idUsuario 
					}).done(function(data){
						alert(data);
						$('#loadImg').css('display','none');
						window.location = '?page=gracias_tr';
					});
				}
				// else if(cbo_Pago == 1){
					
				// }else if(cbo_Pago == 2){
					// window.location = '?page=pago_tarjeta';
				// }
			}
			
			
			
			function verMapaAbajo(){
				var elemento = $("#posicionMapa");
				var posicion = elemento.position();
				//alert( "left: " + posicion.left + ", top: " + posicion.top );
				var aumento = '250';
				var animar = (parseInt(posicion.top)+parseInt(aumento));
				//alert(animar);
				$( "html, body " ).animate({
					scrollTop: animar,
				}, 2000, function() {
					
				});
			}
		var dias = $('#dias').val();
		var horas = $('#horas').val();
		var minutos = $('#minutos').val();
		var segundos = $('#segundos').val();
		var diasventa = $('#diasventa').val();
		var horasventa = $('#horasventa').val();
		var minutosventa = $('#minutosventa').val();
		var segundosventa = $('#segundosventa').val();
		var valor_session = $('#session').val();
		var con = $('#concierto').val();
		var variables = '';
		var dir_map = 'spadmin/'; 
		var mapa_opaco = $('#mapa_opacity').val();
		var ruta = dir_map+mapa_opaco;
		var num_preventa = $('#num_rows_preventa').val();
		var num_reserva = $('#num_rows_reserva').val();

		window.onload = function (){
			if(num_reserva > 0){
				r = new clockCountdown('clock',{'days':dias,'hours':horas,'minutes':minutos,'seconds':segundos});
			}
			if(num_preventa > 0){
				s = new clockCountdown('clock2',{'days':diasventa,'hours':horasventa,'minutes':minutosventa,'seconds':segundosventa});
			}
		}
		var timer2 = 0;
		function animaciontitle(){
			var tiempo = 0;
			timer2 = setInterval(function(){
				tiempo = parseInt(tiempo) + parseInt(1);
				if(tiempo <= 1){
					$('#titulo1').css('color','#f8e316');
				}else{
					$('#titulo1').css('color','#fff');
					tiempo = 0;
				}
			},400);
		}

		$(document).ready(function(){
			clearInterval(timer2);
			animaciontitle();
			
			$(window).resize(function(){
				var width = $(window).width();
				if(width < 1024){
					$('.responsivedesign').fadeOut();
					$('#right1').removeClass('pull-right');
					$('#right2').removeClass('pull-right');
				}else{
					$('.responsivedesign').fadeIn();
					$('#right1').addClass('pull-right');
					$('#right2').addClass('pull-right');
				}
			});
			var width = $(window).width();
			if(width < 1024){
				$('.responsivedesign').fadeOut();
				$('#right1').removeClass('pull-right');
				$('#right2').removeClass('pull-right');
			}else{
				$('.responsivedesign').fadeIn();
				$('#right1').addClass('pull-right');
				$('#right2').addClass('pull-right');
			}
			
			$('#localmapa').mapster({
				singleSelect: true,
				render_highlight: {altImage: ruta},
				render_select: false,
				mapkey: 'data-state',
				fill: true,
				// fillColor: '282B2D',
				//fillOpacity: 1,
			});
			
			// if(num_preventa > 0){
				// $('#reserva').css('display','none');
				// $('.div_reserva').css('display','none');
			// }else{
			if(num_reserva < 1){
				$('#reserva').fadeOut();
			}else{
				$('#reserva').fadeIn();
			}
			// }
		});

		function comprarselect(){
			if(valor_session == 'ok'){
				if($('.asientosescogidos').length){
					$('#form').attr('action','');
					accion ='?modulo=comprar&con='+con;
					$('#form').attr('action',accion);
					$('#identification').addClass('active');
					$('#chooseseat').removeClass('active');
					$('#form').submit();
				}else{
					$('#alerta1').fadeIn();
					$('#aviso').modal('show');
				}
			}else{
				if($('.asientosescogidos').length){
					$('#form').prop('action','');
					$('#mostrar_login_compra').modal('show');
					
					$('#identification').addClass('active');
					$('#chooseseat').removeClass('active');
					
					$('#close').on('click',function(){
						$('#mostrar_login_compra').modal('hide');
						$('.cuentaOk_compra').css('display','none');
						$('.ocultar_text_login_compra').fadeIn();
						$('#form').prop('action','');
						$('#identification').removeClass('active');
						$('#chooseseat').addClass('active');
					});
					
				}else{
					$('#alerta1').fadeIn();
					$('#aviso').modal('show');
				}
			}
		}

		function mostrar_login_compra(){
			$('.cuentaOk_compra').fadeIn();
			$('.ocultar_text_login_compra').css('display','none');
		}

		function reservarselect(){
			if(valor_session == 'ok'){
				if($('.asientosescogidos').length){
					$('#form').attr('action','');
					accion ='?modulo=reservar&con='+con;
					$('#form').attr('action',accion);
					$('#identification').addClass('active');
					$('#chooseseat').removeClass('active');
					$('#form').submit();
				}else{
					$('#alerta1').fadeIn();
					$('#aviso').modal('show');
				}
			}else{
				if($('.asientosescogidos').length){
					$('#form').prop('action','');
					$('#mostrar_login_reserva').modal('show');
					
					$('#identification').addClass('active');
					$('#chooseseat').removeClass('active');
					
					$('#close').on('click',function(){
						$('#mostrar_login_reserva').modal('hide');
						$('.cuentaOk_reserva').css('display','none');
						$('.ocultar_text_login_reserva').fadeIn();
						$('#form').prop('action','');
						$('#identification').removeClass('active');
						$('#chooseseat').addClass('active');
					});
					
				}else{
					$('#alerta1').fadeIn();
					$('#aviso').modal('show');
				}
			}
		}

		function mostrar_login_reserva(){
			$('.cuentaOk_reserva').css('display','block');
			$('.ocultar_text_login_reserva').css('display','none');
		}

		function recuperarcontrasena(){
			$('#recuperarcontrasena').modal('show');
		}

		function recuperarnombre(){
			$('#recuperarnombre').modal('show');
		}

		function aceptarcontrasena(){
			var mail = $('#mailrecuperar').val();
			$('#enviarcambio').fadeOut('slow');
			$('#waitcambio').delay(600).fadeIn('slow');
			$.post('../subpages/Conciertos/recuperarcontrasena.php',{
				mail : mail
			}).done(function(response){
				if($.trim(response) == 'ok'){
					$('#recuperarcontrasena').modal('hide');
					$('#waitcambio').fadeOut('fast');
					$('#enviarcambio').fadeIn('slow');
					$('#mensajeenviado').modal('show');
					$('#mailrecuperar').val('');
				}else if($.trim(response) == 'error'){
					$('#mailrecuperar').val('');
					$('#waitcambio').fadeOut('fast');
					$('#enviarcambio').delay(600).fadeIn('slow');
					$('#errorvalidacion').modal('show');
				}
			});
		}

		function aceptarmensaje(){
			$('#nuevacontrasena').modal('show');
		}

		function aceptarnombre(){
			var cedula = $('#cedularecuperar').val();
			var anio = $('#aniorecuperar').val();
			var mes = $('#mesrecuperar').val();
			var dia = $('#diarecuperar').val();
			var celular = $('#celularrecuperar').val();
			$.post('../subpages/Conciertos/cambiarnombre.php',{
				cedula : cedula, anio : anio, mes : mes, dia : dia, celular : celular
			}).done(function(response){
				if($.trim(response) != 'error'){
					$('#nombreok').modal('show');
					if($('#mostrar_login_compra').is(':visible')){
						$('#user_compra').val(response);
					}else if($('#mostrar_login_reserva').is(':visible')){
						$('#user_reserva').val(response);
					}
					$('#recuperarnombre').modal('hide');
				}else{
					$('#errorvalidacion').modal('show');
				}
			});
		}

		function aceptaroknombre(){
			$('#nombreok').modal('hide');
		}

		function validardatos_compra(){
			var login = $('#user_compra').val();
			var pass = $('#pass_compra').val();
			$.post('../subpages/Conciertos/validardatos.php',{
				login : login, pass : pass
			}).done(function(response){
				if($.trim(response) == 'ok'){
					window.location = '';
				}else{
					$('#user_compra').val('');
					$('#pass_compra').val('');
					$('#errorvalidacion').modal('show');
				}
			});
			
		}

		function validardatos_reserva(){
			var login = $('#user_reserva').val();
			var pass = $('#pass_reserva').val();
			$.post('../subpages/Conciertos/validardatos.php',{
				login : login, pass : pass
			}).done(function(response){
				if($.trim(response) == 'ok'){
					accion = '?modulo=reservar&con='+con;
					$('#form').attr('action',accion);
					$('#form').submit();
				}else{
					$('#user_reserva').val('');
					$('#pass_reserva').val('');
					$('#errorvalidacion').modal('show');
				}
			});
			
		}

		function confirmarcambio(){
			var codigo = $('#codigorecuperar').val();
			var pass = $('#passrecuperar').val();
			$.post('../subpages/Conciertos/cambiarcontrasena.php',{
				codigo : codigo, pass : pass
			}).done(function(response){
				$('#nuevacontrasena').modal('hide');
				if($.trim(response) == 'ok'){
					$('#btnokcambio').fadeOut('slow');
					$('#cambiook').modal('show');
				}else{
					$('#errorvalidacion').modal('show');
				}
			});
		}

		function aceptarcambiook(){
			$('#cambiook').modal('hide');
		}

		function crearcuentacomprar(){
			window.location = '?page=newacount';
		}

		function crearcuentareserva(){
			if($('.asientosescogidos').length){
				accion = '?modulo=registrousuarioreserva&con='+con;
				$('#form').attr('action',accion);
				$('#form').submit();
			}else{
				$('#alerta1').fadeIn();
				$('#aviso').modal('show');
			}
		}

		function security(){
			$('#alerta2').fadeIn();
			$('#aviso').modal('show');
		}

		function aceptarModal(){
			$('.alertas').fadeOut();
			$('#aviso').modal('hide');
		}

		var timer = 0;

		// function animaringreso(){
			// var right = -150;
			// timer = setInterval(function(){
				// right = parseInt(right) + parseInt(50);
				// if(right <= 50){
					// right = right+'px';
					// $('#arrow1').animate({
						// 'right':right
					// });
				// }else{
					// right = -150;
				// }
			// },200);
		// }

		function animaringreso(){
			var mostrar = 0;
			timer = setInterval(function(){
				mostrar = parseInt(mostrar) + parseInt(1);
				if(mostrar <= 4){
					$('#arrow'+mostrar).fadeIn();
				}else{
					$('.arrow').fadeOut();
					mostrar = 0;
				}
			},400);
		}

		function asientos_mapa(local, concierto){
			
			$.post("../subpages/Conciertos/saber_asientos_numerados.php",{ 
				local : local , concierto : concierto
			}).done(function(data){
				var respuesta = data.split('|');
				var valorAsientos = respuesta[0];
				var precio = respuesta[1];
				var local = respuesta[2];
				$('#precioLocalidadSinNum').val(precio);
				$('#localidadSinNum').val(local);
				if(valorAsientos == 0){
					//alert('es asientos no numerados');
					animaringreso();
					var nombrelocal = $('#local'+local).val();
					$('#nombrelocaldiadNoNumerados').html('Estas en <strong id = "nomLoc">'+nombrelocal+'<strong>');
					$('#ocultar').fadeOut('slow');
					$('#contieneNoNumerados').fadeIn('slow');
					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}else{
					animaringreso();
					var nombrelocal = $('#local'+local).val();
					$('#nombrelocaldiad').html('Estas en <strong>'+nombrelocal+'<strong>');
					var numcolumnas = $('#limite_columnas'+local).val();
					var divisiones = parseInt(numcolumnas) / parseInt(30);
					divisiones = Math.ceil(divisiones); 
					var totdivisiones = parseInt(500) / parseInt(divisiones);
					for(var i = 1; i <= divisiones; i++){
						// if(i == 1){
							// $('#divisiones_mapa'+local).append('<div onclick="open_rest_map('+i+','+local+','+concierto+')" id="img_hover'+local+'_'+i+'" class="img_over'+local+'" style="background-color:#67cdf5; color:#000; font-size:20px; display:inline-block; height:100px; width:'+totdivisiones+'px; opacity:0.9; border:1px solid #000; cursor:pointer;">'+i+'</div>');
						// }else{
							$('#divisiones_mapa'+local).append('<div onclick="open_rest_map('+i+','+local+','+concierto+')" id="img_hover'+local+'_'+i+'" style="width:'+totdivisiones+'px;" class="img_over'+local+' secciones">'+i+'</div>');
						// }
					}
					
					if($('#mostrar'+local).length){
						$('#ocultar').fadeOut('slow');
						$('#mostrar_mapa').delay(600).fadeIn();
						$('#img_localidad'+local).fadeIn();
						$('.ocultar'+local).fadeOut();
						$('#detallesillas'+local).fadeIn();
						$('#botones'+local).fadeIn();
						// $('#mostrar'+local).fadeIn();
						// $('#nombreseccion').html('Estas en la sección <strong>1</strong>');
						$('html, body').animate({ scrollTop: 0 }, 'slow');
					}else{
						$('#detallesillas'+local).fadeIn();
						$('#botones'+local).fadeIn();
						// $('#nombreseccion').html('Estas en la sección <strong>1</strong>');
						$('#ocultar').fadeOut('slow');
						$('#mostrar_mapa').delay(600).fadeIn();
						$('#wait').fadeIn();
						$('#img_localidad'+local).fadeIn();
						
						$.ajax({
							type : 'POST',
							url : '../subpages/Conciertos/construir_mapa.php',
							data : 'local='+local +'&concierto='+concierto,
							success : function(response){
								$('#localidad_butaca').append(response);
								$('#wait').fadeOut();
							}
						});
					}
					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}	
			});
		}

		// function celeste(i,local){
			// $('#img_hover'+local+'_'+i).css('background-color','#67cdf5');
		// }

		// function amarillo(i,local){
			// $('#img_hover'+local+'_'+i).css('background-color','#f8e316');
		// }

		function open_rest_map(id, local, concierto){
			$('html, body').animate({ scrollTop: 800 }, 'slow');
			var nombrelocal = $('#local'+local).val();
			$('#nombrelocaldiad').html('Estas en <strong>'+nombrelocal+'<strong>');
			$('#nombreseccion').html('Estas en la sección <strong>'+id+'</strong>');
			$('.img_over'+local).css('background-color','#f8e316');
			$('#img_hover'+local+'_'+id).css('background-color','#67cdf5');
			$('#segundopaso').fadeIn();
			clearInterval(timer);
			$('.arrow').fadeOut();
			if(id == 1){
				$.post("../subpages/Conciertos/creaSessionSeccion.php",{ 
					id_area_mapa : id 
				}).done(function(data){
					//alert(data)			
				});
				$('#mostrar'+local).fadeIn();
				//$('#mostrar_mapa').fadeOut();
				$('#segundopaso').fadeIn();
				$('#nombreseccion').html('Estas en la sección <strong>1</strong>');
				$('.ocultar'+local).fadeOut();
			}else{
				//$('#mostrar_mapa').fadeOut();
				$('#segundopaso').fadeIn();
				$('#mostrar'+local).fadeOut();
				$('.mostrartable'+id).css('display','none');
				$('.ocultar'+local).css('display','none');
				if($('#asientos_local-'+local+'_'+id).length){
					$('#contar_boletos'+local+'_'+id).fadeIn();
				}else{
					$('#wait').fadeIn();
					$.ajax({
						type : 'POST',
						url : '../subpages/Conciertos/continuacion_asientos.php',
						data : 'id='+id +'&local='+local +'&concierto='+concierto,
						success : function(response){
							$('#localidad_butaca').append(response);
							$('#wait').fadeOut();
						}
					});
				}
			}
		}

		function add_asientos(local, concierto, row, col){
			var numboletos = $('#numboletos'+local).html();
			var color = $('#A-'+local+'-'+row+'-'+col).css('background-color');
			if(color == 'rgb(255, 255, 255)'){
				$('#A-'+local+'-'+row+'-'+col).css('background-color','#67cdf5');
				numboletos = parseInt(numboletos) + parseInt(1);
				$('#numboletos'+local).html(numboletos);
			}else{
				$('#A-'+local+'-'+row+'-'+col).css('background-color','#fff');
				$('#new_selection_'+row+'_'+col+'_'+local).remove();
				numboletos = parseInt(numboletos) - parseInt(1);
				$('#numboletos'+local).html(numboletos);
				$('#descripcionsilla'+local).html('');
				return false;
			}
			
			var secuencial = $('#secuencial'+local).val();
			if($('#new_selection_'+row+'_'+col+'_'+local).length){
				$('#descripcionsilla'+local).html('');
			}else{
				if(secuencial == 0){
					$('#descripcionsilla'+local).html('<p align="center">FILA-'+row+'_SILLA-'+col+'</p>');
				}else if(secuencial == 1){
					if(row == 1){
						$('#descripcionsilla'+local).html('<p align="center">FILA-A_SILLA-'+col+'</p>');
					}
					if(row == 2){
						$('#descripcionsilla'+local).html('<p align="center">FILA-B_SILLA-'+col+'</p>');
					}
					if(row == 3){
						$('#descripcionsilla'+local).html('<p align="center">FILA-C_SILLA-'+col+'</p>');
					}
					if(row == 4){
						$('#descripcionsilla'+local).html('<p align="center">FILA-D_SILLA-'+col+'</p>');
					}
					if(row == 5){
						$('#descripcionsilla'+local).html('<p align="center">FILA-E_SILLA-'+col+'</p>');
					}
					if(row == 6){
						$('#descripcionsilla'+local).html('<p align="center">FILA-F_SILLA-'+col+'</p>');
					}
					if(row == 7){
						$('#descripcionsilla'+local).html('<p align="center">FILA-G_SILLA-'+col+'</p>');
					}
					if(row == 8){
						$('#descripcionsilla'+local).html('<p align="center">FILA-H_SILLA-'+col+'</p>');
					}
					if(row == 9){
						$('#descripcionsilla'+local).html('<p align="center">FILA-I_SILLA-'+col+'</p>');
					}
					if(row == 10){
						$('#descripcionsilla'+local).html('<p align="center">FILA-J_SILLA-'+col+'</p>');
					}
					if(row == 11){
						$('#descripcionsilla'+local).html('<p align="center">FILA-K_SILLA-'+col+'</p>');
					}
					if(row == 12){
						$('#descripcionsilla'+local).html('<p align="center">FILA-L_SILLA-'+col+'</p>');
					}
					if(row == 13){
						$('#descripcionsilla'+local).html('<p align="center">FILA-M_SILLA-'+col+'</p>');
					}
					if(row == 14){
						$('#descripcionsilla'+local).html('<p align="center">FILA-N_SILLA-'+col+'</p>');
					}
					if(row == 15){
						$('#descripcionsilla'+local).html('<p align="center">FILA-O_SILLA-'+col+'</p>');
					}
					if(row == 16){
						$('#descripcionsilla'+local).html('<p align="center">FILA-P_SILLA-'+col+'</p>');
					}
					if(row == 17){
						$('#descripcionsilla'+local).html('<p align="center">FILA-Q_SILLA-'+col+'</p>');
					}
					if(row == 18){
						$('#descripcionsilla'+local).html('<p align="center">FILA-R_SILLA-'+col+'</p>');
					}
					if(row == 19){
						$('#descripcionsilla'+local).html('<p align="center">FILA-S_SILLA-'+col+'</p>');
					}
					if(row == 20){
						$('#descripcionsilla'+local).html('<p align="center">FILA-T_SILLA-'+col+'</p>');
					}
					if(row == 21){
						$('#descripcionsilla'+local).html('<p align="center">FILA-U_SILLA-'+col+'</p>');
					}
					if(row == 22){
						$('#descripcionsilla'+local).html('<p align="center">FILA-V_SILLA-'+col+'</p>');
					}
					if(row == 23){
						$('#descripcionsilla'+local).html('<p align="center">FILA-W_SILLA-'+col+'</p>');
					}
					if(row == 24){
						$('#descripcionsilla'+local).html('<p align="center">FILA-X_SILLA-'+col+'</p>');
					}
					if(row == 25){
						$('#descripcionsilla'+local).html('<p align="center">FILA-Y_SILLA-'+col+'</p>');
					}
				}
				$.ajax({
					type : 'POST',
					url : '../subpages/Conciertos/seleccionarasientos.php',
					data : 'local='+local +'&concierto='+concierto +'&row='+row +'&col='+col,
					success : function(response){
						$('#seleccion').append(response);
					}
				});
			}
		}

		function elimanarsillas(local, concierto, row, col){
			$('#A-'+local+'-'+row+'-'+col).css('background-color','#fff');
			$('#new_selection_'+row+'_'+col+'_'+local).remove();
		}

		function save_local(local, concierto){
			$('#img_localidad'+local).css('display','none');
			$('#descripcionsilla'+local).html('');
			$('.img_over'+local).remove();
			$('#detallesillas'+local).fadeOut();
			$('#botones'+local).fadeOut();
			$('.contar_boletos'+local).css('display','none');
			$('#mostrar_mapa').fadeOut('slow');
			$('#segundopaso').fadeOut();
			$('#nombreseccion').html('');
			clearInterval(timer);
			$('#ocultar').delay(600).fadeIn('slow');
			$('html, body').animate({ scrollTop: 75 }, 'slow');
		}

		function cancel_local(local, concierto){
			$('.file_checked-'+local).remove();
			$('.inputchk'+local).css('background-color','#fff');
			$('#img_localidad'+local).css('display','none');
			$('.contar_boletos'+local).css('display','none');
			$('.img_over'+local).remove();
			$('#numboletos'+local).html(0);
			$('#descripcionsilla'+local).html('');
			$('#detallesillas'+local).fadeOut();
			$('#botones'+local).fadeOut();
			$('#mostrar_mapa').fadeOut('slow');
			$('#segundopaso').fadeOut();
			$('#nombreseccion').html('');
			clearInterval(timer);
			$('#ocultar').delay(600).fadeIn('slow');
		}
		</script>
	</div>