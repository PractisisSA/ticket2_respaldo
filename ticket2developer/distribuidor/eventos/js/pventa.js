function guardarDatos_3(){
				
				var clienteok = $('#clienteok').val();
				var idcliente = $('#cliente').val();
				if(clienteok == 'no'){
					var nombres = $('#nombres').val();
					var documento = $('#documento').val();
				}else{
					var nombres = 'no';
					var documento = 'no';
				}
				var mail = $('#mail').val();
				var movil = $('#movil').val();
				var concierto = $('#idConcierto').val();
				var forma = 'correo';
				var dir = $('#dir').val();
				var tipopago = '';
				if($('#tarjeta').is(':checked')){
					tipopago = 'Tarjeta de Credito';
				}else if($('#efectivo').is(':checked')){
					tipopago = 'Efectivo';
				}
				
				if(forma == 3){
					mail = 'h';
				}
				
				var valores = '';
				
				$('.datos_boleto').each(function(){
					var localidad = $(this).find('.codigo').val();
					var descripcion = $(this).find('.des').val();
					var asiento = $(this).find('.asiento').val();
					var precio = $(this).find('.precio').val();
					var fila = $(this).find('.fila').val();
					var col = $(this).find('.col').val();
					var nombre = $(this).find('.nombres').val();
					var cedula = $(this).find('.documento').val();
					
					valores += localidad +'|'+ descripcion +'|'+ asiento +'|'+ precio +'|'+ fila +'|'+ col +'|'+ nombre +'|'+ cedula +'|'+'@';
				});
				var valores_form = valores.substring(0,valores.length -1);
				
				var valores_cliente = '';
				
				var descuentos = $('#descuentos').val();
				var nomDesc = $('#descuentos option:selected').attr('nombre');
				var id_desc = $('#descuentos option:selected').attr('id_desc');
				
				alert(descuentos +'>><<'+ nomDesc +'<<>>'+ id_desc);
				
				$('.datos_cliente_boleto').each(function(){
					var nombre = $(this).find('.nombres').val();
					var cedula = $(this).find('.documento').val();
					if((nombre == '') || (cedula == '')){
						valores_cliente = '';
						return false;
					}
					valores_cliente += nombre +'|'+ cedula +'|'+'@';
				});
				var valores_cliente_form = valores_cliente.substring(0,valores_cliente.length -1);
				
				if((tipopago == '') || (valores_cliente == '') || (mail == '') || (dir == '') || (forma == 0) || (nombres == '') || (documento == '')){
					$('#alerta4').fadeIn();
					$('#aviso').modal('show');
					return false;
				}else{
					if((clienteok == 'ok') && (idcliente != '')){
						
						
						$('#accionContinuar').fadeOut();
						$('#procesando').delay(600).fadeIn();
						$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor_3.php',{
							clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, 
							tipopago : tipopago, forma : forma, mail : mail, movil : movil, dir : dir,valores_cliente : valores_cliente_form , 
							descuentos : descuentos , nomDesc : nomDesc , id_desc : id_desc
						}).done(function(response){
							if($.trim(response) == 'error'){
								$('#alerta6').fadeIn();
								$('#aviso').modal('show');
							}else if($.trim(response) == 'ok'){
								window.location = '?modulo=pagoexitosoDis';
							}else{
								// var mywindow = window.open('', 'Receipt', 'height=800,width=1200');
								// mywindow.document.write('<html><head><title></title>');
								// mywindow.document.write('</head><body >');
								// mywindow.document.write(response);
								// mywindow.document.write('</body></html>');

								// mywindow.print();
								// mywindow.close();
								window.location = '?modulo=pagoexitosoDis';
							}
						});
					}else if((clienteok == 'ok') && (idcliente == '')){
						$('#alerta3').fadeIn();
						$('#aviso').modal('show');
						return false;
					}else if(clienteok == 'no'){
						
						$('#accionContinuar').fadeOut();
						$('#procesando').delay(600).fadeIn();
						$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor_3.php',{
							clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
							forma : forma, valores_cliente : valores_cliente_form, documento : documento, nombres : nombres , 
							descuentos : descuentos , nomDesc : nomDesc , id_desc : id_desc
						}).done(function(response){
							if($.trim(response) == 'error'){
								$('#alerta6').fadeIn();
								$('#aviso').modal('show');
							}else if($.trim(response) == 'ok'){
								window.location = '?modulo=pagoexitosoDis';
							}else{
								// var mywindow = window.open('', 'Receipt', 'height=400,width=600');
								// mywindow.document.write('<html><head><title></title>');
								// mywindow.document.write('</head><body >');
								// mywindow.document.write(response);
								// mywindow.document.write('</body></html>');

								// mywindow.print();
								// mywindow.close();
								window.location = '?modulo=pagoexitosoDis';
							}
						});
					}else if(clienteok == ''){
						$('#alerta3').fadeIn();
						$('#aviso').modal('show');
					}
				}
			}
			
			
			
			
			function guardarDatos_2(){
				alert('hola');
				var clienteok = $('#clienteok').val();
				var idcliente = $('#cliente').val();
				if(clienteok == 'no'){
					var nombres = $('#nombres').val();
					var documento = $('#documento').val();
				}else{
					var nombres = 'no';
					var documento = 'no';
				}
				var mail = $('#mail').val();
				var movil = $('#movil').val();
				var concierto = $('#idConcierto').val();
				var forma = 'correo';
				var dir = $('#dir').val();
				var tipopago = '';
				if($('#tarjeta').is(':checked')){
					tipopago = 'Tarjeta de Credito';
				}else if($('#efectivo').is(':checked')){
					tipopago = 'Efectivo';
				}
				
				if(forma == 3){
					mail = 'h';
				}
				
				var valores = '';
				
				$('.datos_boleto').each(function(){
					var localidad = $(this).find('.localidad').val();
					var descripcion = $(this).find('.des').val();
					var asiento = $(this).find('.asiento').val();
					var precio = $(this).find('.precio').val();
					var fila = $(this).find('.fila').val();
					var col = $(this).find('.col').val();
					var nombre = $(this).find('.nombres').val();
					var cedula = $(this).find('.documento').val();
					
					valores += localidad +'|'+ descripcion +'|'+ asiento +'|'+ precio +'|'+ fila +'|'+ col +'|'+ nombre +'|'+ cedula +'|'+'@';
				});
				var valores_form = valores.substring(0,valores.length -1);
				
				var valores_cliente = '';
				
				var descuentos = $('#descuentos').val();
				var nomDesc = $('#descuentos option:selected').attr('nombre');
				var id_desc = $('#descuentos option:selected').attr('id_desc');
				
				alert(descuentos +'>><<'+ nomDesc +'<<>>'+ id_desc);
				
				// $('.datos_cliente_boleto').each(function(){
					// var nombre = $(this).find('.nombres').val();
					// var cedula = $(this).find('.documento').val();
					// if((nombre == '') || (cedula == '')){
						// valores_cliente = '';
						// return false;
					// }
					// valores_cliente += nombre +'|'+ cedula +'|'+'@';
				// });
				// var valores_cliente_form = valores_cliente.substring(0,valores_cliente.length -1);
				// || (valores_cliente == '') 
				// valores_cliente : valores_cliente_form ,
				
					if((tipopago == '') || (mail == '') || (dir == '') || (forma == 0) || (nombres == '') || (documento == '')){
						$('#alerta4').fadeIn();
						$('#aviso').modal('show');
						return false;
					}else{
						if((clienteok == 'ok') && (idcliente != '')){
							
							
							$('#accionContinuar').fadeOut();
							$('#procesando').delay(600).fadeIn();
							$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor_2.php',{
								clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, 
								tipopago : tipopago, forma : forma, mail : mail, movil : movil, dir : dir, 
								descuentos : descuentos , nomDesc : nomDesc , id_desc : id_desc
							}).done(function(response){
								if($.trim(response) == 'error'){
									$('#alerta6').fadeIn();
									$('#aviso').modal('show');
								}else if($.trim(response) == 'ok'){
									window.location = '?modulo=pagoexitosoDis';
								}else{
									// var mywindow = window.open('', 'Receipt', 'height=800,width=1200');
									// mywindow.document.write('<html><head><title></title>');
									// mywindow.document.write('</head><body >');
									// mywindow.document.write(response);
									// mywindow.document.write('</body></html>');

									// mywindow.print();
									// mywindow.close();
									window.location = '?modulo=pagoexitosoDis';
								}
							});
						}else if((clienteok == 'ok') && (idcliente == '')){
							$('#alerta3').fadeIn();
							$('#aviso').modal('show');
							return false;
						}else if(clienteok == 'no'){
							
							$('#accionContinuar').fadeOut();
							$('#procesando').delay(600).fadeIn();
							$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor_2.php',{
								clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
								forma : forma, documento : documento, nombres : nombres , 
								descuentos : descuentos , nomDesc : nomDesc , id_desc : id_desc
							}).done(function(response){
								if($.trim(response) == 'error'){
									$('#alerta6').fadeIn();
									$('#aviso').modal('show');
								}else if($.trim(response) == 'ok'){
									window.location = '?modulo=pagoexitosoDis';
								}else{
									// var mywindow = window.open('', 'Receipt', 'height=400,width=600');
									// mywindow.document.write('<html><head><title></title>');
									// mywindow.document.write('</head><body >');
									// mywindow.document.write(response);
									// mywindow.document.write('</body></html>');

									// mywindow.print();
									// mywindow.close();
									window.location = '?modulo=pagoexitosoDis';
								}
							});
						}else if(clienteok == ''){
							$('#alerta3').fadeIn();
							$('#aviso').modal('show');
						}
					}
			}
			
			
			
			
			function verOpcionesPago(){
				var tipopagoKiosko = $('#pagoKioskoNew').val();
				var evento = $('#idConcierto').val();
				var clienteok = $('#clienteok').val();
				if(clienteok == ''){
					alert('debe buscar una cedula de cliente');
				}else{
					if(tipopagoKiosko == 0){
						alert('Debes seleccionar una forma de pago')
					}else{
						if(clienteok == 'no'){
							var documento = $('#documento').val();
							var nombres = $('#nombres').val();
							var mail = $('#mail').val();
							var movil = $('#movil').val();
							var dir = $('#dir').val();
							
							if(documento == ''){
								alert('ingrese cedula');
							}
							
							if(nombres == ''){
								alert('ingrese sus nombres');
							}
							
							if(mail == ''){
								alert('ingrese su correo');
							}
							
							if(movil == ''){
								alert('ingrese su # celular');
							}
							
							
							if(dir == ''){
								alert('ingrese su direccion');
							}
							if(documento == '' || nombres == '' || mail == '' || movil == '' || dir == ''){
								
							}else{
								$('#cliente_kiosko_ced').val(documento);
								$('#cliente_kiosko').val(nombres);
								$('#cliente_kiosko_id').val('no');
								
								$('#cliente_kiosko_mail').val(mail);
								$('#cliente_kiosko_dir').val(dir);
								$('#cliente_kiosko_movil').val(movil);
								
								var tipopago = '';
								if(tipopagoKiosko == 1){
									tipopago = 'Tarjeta de Credito';
								}else if(tipopagoKiosko == 4){
									tipopago = 'Paypal';
								}else if(tipopagoKiosko == 3){
									tipopago = 'Pago Punto de Venta';
								}else{
									tipopago = 'Deposito'
								}
								
								if(tipopagoKiosko == 1){
									accion = '?modulo=pagotarjetaCredito&evento='+evento;
									$('#datos').attr('action',accion);
									$('#datos').submit();
								}else if(tipopagoKiosko == 2){
									// $('#alerta7').fadeIn();
									// $('#aviso').modal('show');
									var cliente_kiosko_id = $('#cliente_kiosko_id').val();
									accion = 'subpages/Compras/preDepositoKiosko.php?evento='+evento+'&cliente_kiosko_id='+cliente_kiosko_id;
									$('#datos').attr('action', accion);
									$('#datos').submit();
								}else if(tipopagoKiosko == 3){
									// $('#alerta8').fadeIn();
									// $('#aviso').modal('show');
									var cliente_kiosko_id = 'no';
									accion = 'subpages/Compras/puntoVentaKiosko.php?evento='+evento+'&cliente_kiosko_id='+cliente_kiosko_id;
									
									$('#datos').attr('action', accion);
									$('#datos').submit();
								}
								else if(tipopagoKiosko == 4){
									// $('#alerta8').fadeIn();
									// $('#aviso').modal('show');
									accion = '?modulo=pago_Paypal&evento='+evento;
									$('#datos').attr('action', accion);
									$('#datos').submit();
								}
								else if(tipopagoKiosko == 5){
									guardarDatosKiosko_2(2);
								}else if(tipopagoKiosko == 6){
									guardarDatosKiosko_2(1);
								}
							}
							
							
						}else{
							var tipopago = '';
							if(tipopagoKiosko == 1){
								tipopago = 'Tarjeta de Credito';
							}else if(tipopagoKiosko == 4){
								tipopago = 'Paypal';
							}else if(tipopagoKiosko == 3){
								tipopago = 'Pago Punto de Venta';
							}else{
								tipopago = 'Deposito'
							}
							
							if(tipopagoKiosko == 1){
								accion = '?modulo=pagotarjetaCredito&evento='+evento;
								$('#datos').attr('action',accion);
								$('#datos').submit();
							}else if(tipopagoKiosko == 2){
								// $('#alerta7').fadeIn();
								// $('#aviso').modal('show');
								var cliente_kiosko_id = $('#cliente_kiosko_id').val();
								accion = 'subpages/Compras/preDepositoKiosko.php?evento='+evento+'&cliente_kiosko_id='+cliente_kiosko_id;
								$('#datos').attr('action', accion);
								$('#datos').submit();
							}else if(tipopagoKiosko == 3){
								// $('#alerta8').fadeIn();
								// $('#aviso').modal('show');
								var cliente_kiosko_id = $('#cliente_kiosko_id').val();
								accion = 'subpages/Compras/puntoVentaKiosko.php?evento='+evento+'&cliente_kiosko_id='+cliente_kiosko_id;
								$('#datos').attr('action', accion);
								$('#datos').submit();
							}
							else if(tipopagoKiosko == 4){
								// $('#alerta8').fadeIn();
								// $('#aviso').modal('show');
								accion = '?modulo=pago_Paypal&evento='+evento;
								$('#datos').attr('action', accion);
								$('#datos').submit();
							}
							
							else if(tipopagoKiosko == 5){
								guardarDatosKiosko_2(2);
							}else if(tipopagoKiosko == 6){
								guardarDatosKiosko_2(1);
							}
						}
					}
				}
			}
			
			
			function guardarDatosKiosko_2(forma_pago){
				var clienteok = $('#clienteok').val();
				var idcliente = $('#cliente').val();
				if(clienteok == 'no'){
					var nombres = $('.nombres').val();
					var documento = $('.documento').val();
				}else{
					var nombres = 'no';
					var documento = 'no';
				}
				var mail = $('#mail').val();
				var movil = $('#movil').val();
				var concierto = $('#idConcierto').val();
				var forma = 'correo';
				var dir = $('#dir').val();
				var tipopago = 2;
				// if($('#tarjeta').is(':checked')){
					// tipopago = 'Tarjeta de Credito';
				// }else if($('#efectivo').is(':checked')){
					// tipopago = 'Efectivo';
				// }
				
				if(forma == 3){
					mail = 'h';
				}
				
				var valores = '';
				
				$('.datos_boleto').each(function(){
					var localidad = $(this).find('.localidad').val();
					var descripcion = $(this).find('.des').val();
					var asiento = $(this).find('.asiento').val();
					var precio = $(this).find('.precio').val();
					var fila = $(this).find('.fila').val();
					var col = $(this).find('.col').val();
					var nombre = $(this).find('.nombres').val();
					var cedula = $(this).find('.documento').val();
					
					valores += localidad +'|'+ descripcion +'|'+ asiento +'|'+ precio +'|'+ fila +'|'+ col +'|'+ nombre +'|'+ cedula +'|'+'@';
				});
				var valores_form = valores.substring(0,valores.length -1);
				
				var valores_cliente = '';
				
				$('.datos_cliente_boleto').each(function(){
					var nombre = $(this).find('.nombres').val();
					var cedula = $(this).find('.documento').val();
					if((nombre == '') || (cedula == '')){
						valores_cliente = '';
						return false;
					}
					valores_cliente += nombre +'|'+ cedula +'|'+'@';
				});
				var valores_cliente_form = valores_cliente.substring(0,valores_cliente.length -1);
				
				if((tipopago == '') || (valores_cliente == '') || (mail == '') || (dir == '') || (forma == 0) || (nombres == '') || (documento == '')){
					$('#alerta4').fadeIn();
					$('#aviso').modal('show');
					return false;
				}else{
					if((clienteok == 'ok') && (idcliente != '')){
						if($("input[name='subirCedula']").is(':checked')){
							var recibeCedula = $('#recibeExcel2').val();
							
							if(recibeCedula == ''){
								alert('Debe subir la copia de cedula');
							}else{
								$('#accionContinuar').fadeOut();
								$('#procesando').delay(600).fadeIn();
								$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidorCadena.php',{
									clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, 
									tipopago : tipopago, forma : forma, mail : mail, movil : movil, dir : dir,valores_cliente : valores_cliente_form , 
									recibeCedula : recibeCedula , forma_pago : forma_pago
								}).done(function(response){
									if($.trim(response) == 'error'){
										$('#alerta6').fadeIn();
										$('#aviso').modal('show');
									}else if($.trim(response) == 'ok'){
										window.location = '?modulo=pagoexitosoDis';
									}else{
										// var mywindow = window.open('', 'Receipt', 'height=800,width=1200');
										// mywindow.document.write('<html><head><title></title>');
										// mywindow.document.write('</head><body >');
										// mywindow.document.write(response);
										// mywindow.document.write('</body></html>');

										// mywindow.print();
										// mywindow.close();
										window.location = '?modulo=pagoexitosoDis';
									}
								});
							}
						}else{
							var recibeCedula = '';
							$('#accionContinuar').fadeOut();
							$('#procesando').delay(600).fadeIn();
							$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidorCadena.php',{
								clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, tipopago : tipopago, 
								forma : forma, mail : mail, movil : movil, dir : dir,valores_cliente : valores_cliente_form , 
								recibeCedula : recibeCedula , forma_pago : forma_pago
							}).done(function(response){
								if($.trim(response) == 'error'){
									$('#alerta6').fadeIn();
									$('#aviso').modal('show');
								}else if($.trim(response) == 'ok'){
									window.location = '?modulo=pagoexitosoDis';
								}else{
									// var mywindow = window.open('', 'Receipt', 'height=800,width=1200');
									// mywindow.document.write('<html><head><title></title>');
									// mywindow.document.write('</head><body >');
									// mywindow.document.write(response);
									// mywindow.document.write('</body></html>');

									// mywindow.print();
									// mywindow.close();
									window.location = '?modulo=pagoexitosoDis';
								}
							});
						}
					}else if((clienteok == 'ok') && (idcliente == '')){
						$('#alerta3').fadeIn();
						$('#aviso').modal('show');
						return false;
					}else if(clienteok == 'no'){
						if($("input[name='subirCedula']").is(':checked')){
							var recibeCedula = $('#recibeExcel2').val();
							
							if(recibeCedula == ''){
								alert('Debe subir la copia de cedula');
							}else{
								$('#accionContinuar').fadeOut();
								$('#procesando').delay(600).fadeIn();
								$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidorCadena.php',{
									clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
									forma : forma, valores_cliente : valores_cliente_form, documento : documento, nombres : nombres , 
									recibeCedula : recibeCedula , forma_pago : forma_pago
								}).done(function(response){
									if($.trim(response) == 'error'){
										$('#alerta6').fadeIn();
										$('#aviso').modal('show');
									}else if($.trim(response) == 'ok'){
										window.location = '?modulo=pagoexitosoDis';
									}else{
										// var mywindow = window.open('', 'Receipt', 'height=400,width=600');
										// mywindow.document.write('<html><head><title></title>');
										// mywindow.document.write('</head><body >');
										// mywindow.document.write(response);
										// mywindow.document.write('</body></html>');

										// mywindow.print();
										// mywindow.close();
										window.location = '?modulo=pagoexitosoDis';
									}
								});
							}
						}else{
							var recibeCedula = '';
							$('#accionContinuar').fadeOut();
							$('#procesando').delay(600).fadeIn();
							$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidorCadena.php',{
								clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
								forma : forma, valores_cliente : valores_cliente_form, documento : documento, nombres : nombres , 
								recibeCedula : recibeCedula , forma_pago : forma_pago
							}).done(function(response){
								if($.trim(response) == 'error'){
									$('#alerta6').fadeIn();
									$('#aviso').modal('show');
								}else if($.trim(response) == 'ok'){
									window.location = '?modulo=pagoexitosoDis';
								}else{
									// var mywindow = window.open('', 'Receipt', 'height=400,width=600');
									// mywindow.document.write('<html><head><title></title>');
									// mywindow.document.write('</head><body >');
									// mywindow.document.write(response);
									// mywindow.document.write('</body></html>');

									// mywindow.print();
									// mywindow.close();
									window.location = '?modulo=pagoexitosoDis';
								}
							});
						}
					}else if(clienteok == ''){
						$('#alerta3').fadeIn();
						$('#aviso').modal('show');
					}
				}
			}
			
			
			
			function guardarDatosKiosko(){
				var clienteok = $('#clienteok').val();
				var idcliente = $('#cliente').val();
				if(clienteok == 'no'){
					var nombres = $('#nombres').val();
					var documento = $('#documento').val();
				}else{
					var nombres = 'no';
					var documento = 'no';
				}
				var mail = $('#mail').val();
				var movil = $('#movil').val();
				var concierto = $('#idConcierto').val();
				var forma = 'correo';
				var dir = $('#dir').val();
				var tipopago = '';
				if($('#tarjeta').is(':checked')){
					tipopago = 'Tarjeta de Credito';
				}else if($('#efectivo').is(':checked')){
					tipopago = 'Efectivo';
				}
				
				if(forma == 3){
					mail = 'h';
				}
				
				var valores = '';
				
				$('.datos_boleto').each(function(){
					var localidad = $(this).find('.localidad').val();
					var descripcion = $(this).find('.des').val();
					var asiento = $(this).find('.asiento').val();
					var precio = $(this).find('.precio').val();
					var fila = $(this).find('.fila').val();
					var col = $(this).find('.col').val();
					var nombre = $(this).find('.nombres').val();
					var cedula = $(this).find('.documento').val();
					
					valores += localidad +'|'+ descripcion +'|'+ asiento +'|'+ precio +'|'+ fila +'|'+ col +'|'+ nombre +'|'+ cedula +'|'+'@';
				});
				var valores_form = valores.substring(0,valores.length -1);
				
				var valores_cliente = '';
				
				$('.datos_cliente_boleto').each(function(){
					var nombre = $(this).find('.nombres').val();
					var cedula = $(this).find('.documento').val();
					if((nombre == '') || (cedula == '')){
						valores_cliente = '';
						return false;
					}
					valores_cliente += nombre +'|'+ cedula +'|'+'@';
				});
				var valores_cliente_form = valores_cliente.substring(0,valores_cliente.length -1);
				
				if((tipopago == '') || (valores_cliente == '') || (mail == '') || (dir == '') || (forma == 0) || (nombres == '') || (documento == '')){
					$('#alerta4').fadeIn();
					$('#aviso').modal('show');
					return false;
				}else{
					if((clienteok == 'ok') && (idcliente != '')){
						if($("input[name='subirCedula']").is(':checked')){
							var recibeCedula = $('#recibeExcel2').val();
							
							if(recibeCedula == ''){
								alert('Debe subir la copia de cedula');
							}else{
								$('#accionContinuar').fadeOut();
								$('#procesando').delay(600).fadeIn();
								$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor.php',{
									clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, tipopago : tipopago, 
									forma : forma, mail : mail, movil : movil, dir : dir,valores_cliente : valores_cliente_form , recibeCedula : recibeCedula
								}).done(function(response){
									if($.trim(response) == 'error'){
										$('#alerta6').fadeIn();
										$('#aviso').modal('show');
									}else if($.trim(response) == 'ok'){
										window.location = '?modulo=pagoexitosoDis';
									}else{
										// var mywindow = window.open('', 'Receipt', 'height=800,width=1200');
										// mywindow.document.write('<html><head><title></title>');
										// mywindow.document.write('</head><body >');
										// mywindow.document.write(response);
										// mywindow.document.write('</body></html>');

										// mywindow.print();
										// mywindow.close();
										window.location = '?modulo=pagoexitosoDis';
									}
								});
							}
						}else{
							var recibeCedula = '';
							$('#accionContinuar').fadeOut();
							$('#procesando').delay(600).fadeIn();
							$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor.php',{
								clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, tipopago : tipopago, 
								forma : forma, mail : mail, movil : movil, dir : dir,valores_cliente : valores_cliente_form , recibeCedula : recibeCedula
							}).done(function(response){
								if($.trim(response) == 'error'){
									$('#alerta6').fadeIn();
									$('#aviso').modal('show');
								}else if($.trim(response) == 'ok'){
									window.location = '?modulo=pagoexitosoDis';
								}else{
									// var mywindow = window.open('', 'Receipt', 'height=800,width=1200');
									// mywindow.document.write('<html><head><title></title>');
									// mywindow.document.write('</head><body >');
									// mywindow.document.write(response);
									// mywindow.document.write('</body></html>');

									// mywindow.print();
									// mywindow.close();
									window.location = '?modulo=pagoexitosoDis';
								}
							});
						}
					}else if((clienteok == 'ok') && (idcliente == '')){
						$('#alerta3').fadeIn();
						$('#aviso').modal('show');
						return false;
					}else if(clienteok == 'no'){
						if($("input[name='subirCedula']").is(':checked')){
							var recibeCedula = $('#recibeExcel2').val();
							
							if(recibeCedula == ''){
								alert('Debe subir la copia de cedula');
							}else{
								$('#accionContinuar').fadeOut();
								$('#procesando').delay(600).fadeIn();
								$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor.php',{
									clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
									forma : forma, valores_cliente : valores_cliente_form, documento : documento, nombres : nombres , recibeCedula : recibeCedula
								}).done(function(response){
									if($.trim(response) == 'error'){
										$('#alerta6').fadeIn();
										$('#aviso').modal('show');
									}else if($.trim(response) == 'ok'){
										window.location = '?modulo=pagoexitosoDis';
									}else{
										// var mywindow = window.open('', 'Receipt', 'height=400,width=600');
										// mywindow.document.write('<html><head><title></title>');
										// mywindow.document.write('</head><body >');
										// mywindow.document.write(response);
										// mywindow.document.write('</body></html>');

										// mywindow.print();
										// mywindow.close();
										window.location = '?modulo=pagoexitosoDis';
									}
								});
							}
						}else{
							var recibeCedula = '';
							$('#accionContinuar').fadeOut();
							$('#procesando').delay(600).fadeIn();
							$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor.php',{
								clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
								forma : forma, valores_cliente : valores_cliente_form, documento : documento, nombres : nombres , recibeCedula : recibeCedula
							}).done(function(response){
								if($.trim(response) == 'error'){
									$('#alerta6').fadeIn();
									$('#aviso').modal('show');
								}else if($.trim(response) == 'ok'){
									window.location = '?modulo=pagoexitosoDis';
								}else{
									// var mywindow = window.open('', 'Receipt', 'height=400,width=600');
									// mywindow.document.write('<html><head><title></title>');
									// mywindow.document.write('</head><body >');
									// mywindow.document.write(response);
									// mywindow.document.write('</body></html>');

									// mywindow.print();
									// mywindow.close();
									window.location = '?modulo=pagoexitosoDis';
								}
							});
						}
					}else if(clienteok == ''){
						$('#alerta3').fadeIn();
						$('#aviso').modal('show');
					}
				}
			}
			
			// $(function(){
		// var btnUpload=$('#file');
		// new AjaxUpload(btnUpload, {
			// action: 'distribuidor/ventas/procesa.php',
			// name: 'uploadfile',
			// onSubmit: function(file, ext){
				 // // if (! (ext && /^(doc|docx)$/.test(ext))){
					// // alert('Solo archivos de Word');
					// // return false;
				// // }
			// },
			// onComplete: function(file, response){
				// var mirsp = response;
				// //reload ();
				// if($.trim(mirsp)!='error'){
					// $('#subeExcel').show('explode');
					// $('#recibeExcel').html(mirsp);
					// $('#recibeExcel2').val(mirsp);
					// $('#sendFile').fadeIn('slow');
					
					// //envia();
				// }else{
					// $('#recibeExcel').html('no se pudo subir');
				// }
				
				// //$('#mapa_completo').append('<img src="spadmin/mapas/'+mirsp+'" alt="" class="mapa" />');
			// }
		// });
	// });
	function muestraSubir(){
		if($("input[name='subirCedula']").is(':checked')){
			//alert('esta activado');
			$('#contieneSubidaCedula').fadeIn('slow');
		}else{
			//alert('desactivado');
			$('#contieneSubidaCedula').fadeOut('slow');
		}
	}