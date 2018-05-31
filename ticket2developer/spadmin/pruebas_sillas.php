
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">-->
<?php
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	include '../conexion.php';
	$id_loc = $_REQUEST['id_loc'];
	$idcon = $_REQUEST['idcon'];
	$sqlL = 'SELECT * FROM `Butaca` WHERE `intLocalB` = "'.$id_loc.'" ORDER BY `idButaca` DESC ';
	$resL = mysql_query($sqlL) or die (mysql_error());
	$rowL = mysql_fetch_array($resL);
	
	
	$filas = $rowL['intAsientosB'];
	$columnas = $rowL['intFilasB'];
	
	
	// function _data_last_month_day() { 
		// $month = date('m');
		// $year = date('Y');
		// $day = date("d", mktime(0,0,0, $month+1, 0, $year));

		// return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
	// }
	
	// echo _data_last_month_day();
	
	// exit;
	// $asientos = array($filas,$columnas);
	echo'<center><img src = "../imagenes/load22.gif" id = "load_img" /></center>';
	?>
		<table style = 'width:800px;'>
			<tr>
				<td style = 'text-align:center;'> 
					Total Asientos
				</td>
				<td style = 'text-align:center;'> 
					Asientos Reservados
				</td>
				<td style = 'text-align:center;'> 
					Asientos Pagados
				</td>
				<td style = 'text-align:center;'> 
					Asientos Bloqueados
				</td>
				<td style = 'text-align:center;'> 
					Asientos Libres
				</td>
			</tr>
			<tr>
				<td> 
					<div id = 'todos' style ="margin:0 auto;color:#fff;background-color:#00709B;font-size:12px;padding-top:7px !important;border:1px solid #ccc;vertical-align:middle;width:30px;height:35px;text-align: center">
						<?php echo ($filas * $columnas)?>
					</div>
				</td>
				
				<td> 
					<div id = 'amarillas' style ="margin:0 auto;color:#000;background-color:#fbed2c;font-size:12px;padding-top:7px !important;border:1px solid #ccc;vertical-align:middle;width:30px;height:35px;text-align: center">
						
					</div>
				</td>
				<td> 
					<div id = 'rojas' style ="margin:0 auto;color:#000;background-color:red;font-size:12px;padding-top:7px !important;border:1px solid #ccc;vertical-align:middle;width:30px;height:35px;text-align: center">
						
					</div>
				</td>
				<td> 
					<div id = 'negras' style ="margin:0 auto;color:#fff;background-color:#000;font-size:12px;padding-top:7px !important;border:1px solid #ccc;vertical-align:middle;width:30px;height:35px;text-align: center">
						
					</div>
				</td>
				<td> 
					<div id = 'blancas' style ="margin:0 auto;color:#000;background-color:#fff;font-size:12px;padding-top:7px !important;border:1px solid #ccc;vertical-align:middle;width:30px;height:35px;text-align: center">
						
					</div>
				</td>
			</tr>
		</table>
	<?php
	echo '<div class="table-responsivessss"><table style = "display:none;" id = "tabla_sillas" class="table table-striped">';
	$cont=1;
	$kk=0;
	
	for($i=1;$i<=$columnas;$i++){
		$ll=1;
		for($j=1;$j<=$filas;$j++){
			// echo $i."<br>";
			$sqlO = 'select * from ocupadas where row = "'.$i.'" and col = "'.$j.'" and local = "'.$id_loc.'" ';
			$resO = mysql_query($sqlO) or die (mysql_error());
			$rowO = mysql_fetch_array($resO);
			if($j==1){
				$sillas_ = $i;
			}
			if($rowO['status'] == 3){
				$color = 'background-color:#000;color:#fff;cursor:pointer;';
				$clase = 'sillas_negras_ filas_negras_'.$sillas_.' bloqueadas';
				$parametro = 1;
				$id_ocu = $rowO['id'];
				$contenedor='contenedor_numero_asiento_'.$i.'_'.$j.'';
				$funcion ='onclick = "saberEstado('.$i.','.$j.','.$parametro.','.$id_ocu.','.$id_loc.','.$idcon.')"';
			}elseif($rowO['status'] == 2){
				$color = 'background-color:#fbed2c;color:#000;';
				$clase = 'reservadas';
				$parametro = 2;
				$id_ocu = '';
				$contenedor='';
			}elseif($rowO['status'] == 1){
				$color = 'background-color:red;color:#fff;';
				$clase = 'pagadas';
				$parametro = 2;
				$id_ocu = '';
				$contenedor='';
			}else{
				$color = 'cursor:pointer;';
				$contenedor = 'contenedor_numero_asiento_'.$i.'_'.$j.'';
				$clase = 'sillas_blancas_'.$sillas_.' libres';
				$parametro = 0;
				$id_ocu = 0;
				$funcion ='onclick = "saberEstado('.$i.','.$j.','.$parametro.','.$id_ocu.','.$id_loc.','.$idcon.')"';
			}
			if($cont==1){
				echo '<tr style="'.$display.'">';
			}
			$$sillas_=0;
			if($j==1){
				$letra = chr($ll);  
			if($rowL['strSecuencial'] == 0){
				$ff=$i;
			}else{
					if($i == 1){
				$ff = 'A';
					
				}
				if($i == 2){
					$ff = 'B';
					
				}
				if($i == 3){
					$ff = 'C';
					
				}
				if($i == 4){
					$ff = 'D';
					
				}
				if($i == 5){
					$ff = 'E';
					
				}
				if($i == 6){
					$ff = 'F';
					
				}
				if($i == 7){
					$ff = 'G';
					
				}
				if($i == 8){
					$ff = 'H';
					
				}
				if($i == 9){
					$ff = 'I';
					
				}
				if($i == 10){
					$ff = 'J';
					
				}
				if($i == 11){
					$ff = 'K';
					
				}
				if($i == 12){
					$ff = 'L';
					
				}
				if($i == 13){
					$ff = 'M';
					
				}
				if($i == 14){
					$ff = 'N';
					
				}
				if($i == 15){
					$ff = 'O';
					
				}
				if($i == 16){
					$ff = 'P';
					
				}
				if($i == 17){
					$ff = 'Q';
					
				}
				if($i == 18){
					$ff = 'R';
					
				}
				if($i == 19){
					$ff = 'S';
				
				}
				if($i == 20){
					$ff = 'T';
					
				}
				if($i == 21){
					$ff = 'U';
					
				}
				if($i == 22){
					$ff = 'V';
					
				}
				if($i == 23){
					$ff = 'W';
					
				}
				if($i == 24){
					$ff = 'X';
					
				}
				if($i == 25){
					$ff = 'Y';
					
				}
				
				if($i == 26){
					$ff = 'Z';
					
				}
				
				if($i == 27){
					$ff = 'AA';
					
				}
				
				if($i == 28){
					$ff = 'AB';
					
				}
				
				if($i == 29){
					$ff = 'AC';
					
				}
				
				if($i == 30){
					$ff = 'AD';
					
				}
				
				
				
				if($i == 31){
					$ff = 'AE';
					
				}
				if($i == 32){
					$ff = 'AF';
					
				}
				if($i == 33){
					$ff = 'AG';
					
				}
				if($i == 34){
					$ff = 'AH';
					
				}
				if($i == 35){
					$ff = 'AI';
					
				}
				
				if($i == 36){
					$ff = 'AJ';
					
				}
				
				if($i == 37){
					$ff = 'AK';
					
				}
				
				if($i == 38){
					$ff = 'AL';
					
				}
				
				if($i == 39){
					$ff = 'AM';
					
				}
				
				if($i == 40){
					$ff = 'AN';
					
				}
				
				
				if($i == 41){
					$ff = 'AO';
					
				}
				if($i == 42){
					$ff = 'AP';
					
				}
				if($i == 43){
					$ff = 'AQ';
					
				}
				if($i == 44){
					$ff = 'AR';
					
				}
				if($i == 45){
					$ff = 'AS';
					
				}
				
				if($i == 46){
					$ff = 'AT';
					
				}
				
				if($i == 47){
					$ff = 'AU';
					
				}
				
				if($i == 48){
					$ff = 'AV';
					
				}
				
				if($i == 49){
					$ff = 'AW';
					
				}
				
				if($i == 50){
					$ff = 'AX';
					
				}

				if($i == 51){
					$ff = 'AY';
					
				}
				if($i == 52){
					$ff = 'AZ';
					
				}
				if($i == 53){
					$ff = 'BA';
					
				}
				if($i == 54){
					$ff = 'BB';
					
				}
				if($i == 55){
					$ff = 'BC';
					
				}
				
				if($i == 56){
					$ff = 'BD';
					
				}
				
				if($i == 57){
					$ff = 'BE';
					
				}
				
				if($i == 58){
					$ff = 'BF';
					
				}
				
				if($i == 59){
					$ff = 'BG';
					
				}
				
				if($i == 60){
					$ff = 'BH';
					
				}
				
				if($i == 61){
					$ff = 'BI';
					
				}
				if($i == 62){
					$ff = 'BJ';
					
				}
				if($i == 63){
					$ff = 'BK';
					
				}
				if($i == 64){
					$ff = 'BL';
					
				}
				if($i == 65){
					$ff = 'BM';
					
				}
				
				if($i == 66){
					$ff = 'BN';
					
				}
				
				if($i == 67){
					$ff = 'BO';
					
				}
				
				if($i == 68){
					$ff = 'BP';
					
				}
				
				if($i == 69){
					$ff = 'BQ';
					
				}
				
				if($i == 70){
					$ff = 'BR';
					
				}
				
				
				if($i == 71){
					$ff = 'BS';
					
				}
				if($i == 72){
					$ff = 'BT';
					
				}
				if($i == 73){
					$ff = 'BU';
					
				}
				if($i == 74){
					$ff = 'BV';
					
				}
				if($i == 75){
					$ff = 'BW';
					
				}
				
				if($i == 76){
					$ff = 'BX';
					
				}
				
				if($i == 77){
					$ff = 'BY';
					
				}
				
				if($i == 78){
					$ff = 'BZ';
					
				}
				
				if($i == 79){
					$ff = 'CA';
					
				}
				
				if($i == 80){
					$ff = 'CB';
					
				}
			}
				echo '	<td  style ="padding:6px !important;border:1px solid #ccc;"> 
							<table style ="width:180px;font-size: 12px" >
								<tr>
									<td style ="padding:6px;cursor: pointer;">
										<i onclick = "bloquea_Fila('.$i.')" id = "bloqueo_'.$i.'" class="fa fa-ban" aria-hidden="true" style ="color:red;" title="bloquear toda la fila : '.$i.'"></i>
										<input type = "hidden" class = "valor_fila_bloqueada_'.$i.'" value ="0"/>
									</td>
									<td style ="text-align:left"> FILA - '.$ff.'  </td>
									<td style ="text-align:right;padding-left: 15px">
										<input onkeyup="this.value = this.value.replace (/[^0-9]/, \'\'); " onblur ="bloquea_rango('.$i.','.$filas.')" type = "text" id = "bloquea_rango_'.$i.'"  style ="width:80px;height:25px;font-size: 12px" class = "form-control entero" />
									</td>
								</tr>
							</table>
							
						</td>';
				
			}
			$ll++;
			echo '	<td id = "contenedor_asiento_'.$i.'_'.$j.'" style ="padding:0px;" > 
						<div id = "'.$contenedor.'" parametro = "'.$parametro.'" id_ocu = "'.$id_ocu.'"  fila = "'.$i.'" columna = "'.$j.'"  id_loc = "'.$id_loc.'"  idcon = "'.$idcon.'" '.$funcion.' class = "'.$clase.' " style ="'.$color.'font-size:12px;padding-top:7px !important;border:1px solid #ccc;vertical-align:middle;width:30px;height:35px;text-align: center">'.$j.'</div>
					</td>';
			
			if($cont >= $filas){
				echo '</tr>';
				$cont=1;
			}else{
				$cont++;
			}
		}
		
	}
		
	echo '</table>';
?>
</div>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script>
	
	function bloquea_rango(id,fin){
		var limite = $('#bloquea_rango_'+id).val();
		if(limite == ''){
			
		}else{
			if(limite <= fin){
				var filas_negras_ = $('.filas_negras_'+id).length;
				var contador = 1;
				var puede_pasar = false;
				// alert(puede_pasar)
				
				// alert(filas_negras_);
				if(filas_negras_ != 0){
					$('.filas_negras_'+id).each(function(){
				
						var param = $(this).attr('parametro');
						var id_ocu = $(this).attr('id_ocu');
						var fila = $(this).attr('fila');
						var columna = $(this).attr('columna');
						var id_loc = $(this).attr('id_loc');
						var idcon = $(this).attr('idcon');
						
						$.post("spadmin/controlaBloqueados.php",{ 
							fila : fila , columna : columna , param : param , id_ocu : id_ocu , id_loc : id_loc , idcon : idcon
						}).done(function(data){
							$('#contenedor_asiento_'+fila+'_'+columna).html(data)
							contar_filas();
						});
						
						if(contador == filas_negras_){
							// alert ('termino hay  ' + filas_negras_  + 'bloquedos ' + ' con limite de : ' + contador);
							puede_pasar = true;
						}else{
							puede_pasar = false;
						}
						contador++;
					});
				}else{
					var puede_pasar = true;
				}
				
				setTimeout(function(){
					alert(puede_pasar);
					if(puede_pasar == true){
						for(var i=fin;i>limite;i--){
							// alert(fin +'<<>>'+ limite);
							$('#contenedor_numero_asiento_'+id+'_'+i).css('background-color','red');
							var param = $('#contenedor_numero_asiento_'+id+'_'+i).attr('parametro');
							var id_ocu = $('#contenedor_numero_asiento_'+id+'_'+i).attr('id_ocu');
							var fila = $('#contenedor_numero_asiento_'+id+'_'+i).attr('fila');
							var columna = $('#contenedor_numero_asiento_'+id+'_'+i).attr('columna');
							var id_loc = $('#contenedor_numero_asiento_'+id+'_'+i).attr('id_loc');
							var idcon = $('#contenedor_numero_asiento_'+id+'_'+i).attr('idcon');
							// alert(param +' -- '+ id_ocu +' -- '+ fila +' -- '+ columna +' -- '+ id_loc +' -- '+ idcon);
							saberEstado_blur(fila,columna,param,id_ocu,id_loc,idcon);
						}
					}
				}, 2000);
				$('#bloquea_rango_'+id).val('');
				

			}else{
				alert('solo puede bloquear maximo : ' + fin + 'asientos \n debe ingresar un numero menor');
				$('#bloquea_rango_'+id).val('');
			}
		}
	}
	function saberEstado_blur(fila,columna,param,id_ocu,id_loc,idcon){
		// alert(fila + ' <<>> ' + columna +' >><< ' + param  + ' |@@| ' + id_ocu);
		$.post("spadmin/controlaBloqueados_blur.php",{ 
			fila : fila , columna : columna , param : param , id_ocu : id_ocu , id_loc : id_loc , idcon : idcon
		}).done(function(data){
			
			if(data==1){
				
			}else{
				$('#contenedor_asiento_'+fila+'_'+columna).html(data);
			}
			
			contar_filas();
		});
	}
	function saberEstado(fila,columna,param,id_ocu,id_loc,idcon){
		// alert(fila + ' <<>> ' + columna +' >><< ' + param  + ' |@@| ' + id_ocu);
		$.post("spadmin/controlaBloqueados.php",{ 
			fila : fila , columna : columna , param : param , id_ocu : id_ocu , id_loc : id_loc , idcon : idcon
		}).done(function(data){
			$('#contenedor_asiento_'+fila+'_'+columna).html(data)
			contar_filas();
		});
		
	}
	function bloquea_Fila(fila){
		var valor_fila_bloqueada_ = $('.valor_fila_bloqueada_'+fila).val();
		if(valor_fila_bloqueada_ == 0){
			$('#bloqueo_'+fila).css('color','#1EA076');
			$('.valor_fila_bloqueada_'+fila).val(1);
			$('.sillas_blancas_'+fila).each(function(){
				var param = $(this).attr('parametro');
				var id_ocu = $(this).attr('id_ocu');
				var fila = $(this).attr('fila');
				var columna = $(this).attr('columna');
				var id_loc = $(this).attr('id_loc');
				var idcon = $(this).attr('idcon');
				
				$.post("spadmin/controlaBloqueados.php",{ 
					fila : fila , columna : columna , param : param , id_ocu : id_ocu , id_loc : id_loc , idcon : idcon
				}).done(function(data){
					$('#contenedor_asiento_'+fila+'_'+columna).html(data)
					contar_filas();
				});
			});

		}else{
			$('#bloqueo_'+fila).css('color','red');
			$('.valor_fila_bloqueada_'+fila).val(0);
			$('.filas_negras_'+fila).each(function(){
				var param = $(this).attr('parametro');
				var id_ocu = $(this).attr('id_ocu');
				var fila = $(this).attr('fila');
				var columna = $(this).attr('columna');
				var id_loc = $(this).attr('id_loc');
				var idcon = $(this).attr('idcon');
				
				$.post("spadmin/controlaBloqueados.php",{ 
					fila : fila , columna : columna , param : param , id_ocu : id_ocu , id_loc : id_loc , idcon : idcon
				}).done(function(data){
					$('#contenedor_asiento_'+fila+'_'+columna).html(data)
					contar_filas();
				});
			});
		}
		// if(confirm('esta seguro que desea bloquear toda la fila : ' + fila))
		
	}
	
	
	function contar_filas(){
		var bloqueadas = $('.bloqueadas').length;
		$('#negras').html(bloqueadas);
		
		var reservadas = $('.reservadas').length;
		$('#amarillas').html(reservadas);
		
		var pagadas = $('.pagadas').length;
		$('#rojas').html(pagadas);
		
		var libres = $('.libres').length;
		$('#blancas').html(libres);
	}
	
	
	
	$( document ).ready(function() {
		contar_filas();
		$('#tabla_sillas').fadeIn('slow');
		$('#load_img').css('display','none')
		$('.entero').numeric();
	});
</script>