onDeviceReady();
function onDeviceReady(){
	var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
	db.transaction(iniciaDB, errorCB, successCB);
	console.log(db);
}

function iniciaDB(tx){
	var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
	//tx.executeSql('DROP TABLE IF EXISTS Boleto');
	tx.executeSql('CREATE TABLE IF NOT EXISTS Boleto (idabajo integer primary key AUTOINCREMENT,idBoleto integer, strQr text, strBarcode text, idCli interger, idCon integer,idLocB integer,nombreHISB text,documentoHISB text,strEstado text , identComprador integer)');
	// tx.executeSql('DROP TABLE IF EXISTS Ingreso');
	tx.executeSql('CREATE TABLE IF NOT EXISTS Ingreso (id integer primary key AUTOINCREMENT,idBoleto integer, strQr text, strBarcode text, idCli interger, idCon integer,idLocB integer,nombreHISB text,documentoHISB text,strEstado text)');
	// tx.executeSql('DROP TABLE IF EXISTS Usuario');
	tx.executeSql('CREATE TABLE IF NOT EXISTS Usuario (id integer primary key AUTOINCREMENT,idUsuario integer, strNombreU text, strMailU text, strContrasena text, strCedula text,strPerfil text,nombreHISB text,strEstadoU text)');
	tx.executeSql('CREATE TABLE IF NOT EXISTS auditoria (id integer primary key AUTOINCREMENT,idBoleto integer, estado text, fecha text)');
	
	
}

function errorCB(err){
	console.log("Error processing SQL: "+err.message);
}

function successCB() {
	console.log("success!");
}





function insertarDatos(idurl){
	var count = 1;
	$('.dataBoleto').each(function(){
		var id = $(this).find('td .id').val();
		var qr = $(this).find('td .qr').val();
		var barcode = $(this).find('td .barcode').val();
		var cliente = $(this).find('td .cliente').val();
		var concierto = $(this).find('td .concierto').val();
		var local = $(this).find('td .local').val();
		var nombre = $(this).find('td .nombre').val();
		var cedula = $(this).find('td .cedula').val();
		var estado = $(this).find('td .estado').val();
		var identComprador = $(this).find('td .identComprador').val();
		
		var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
		db.transaction(function(tx){
			tx.executeSql('SELECT * FROM Boleto WHERE idBoleto = ?;',[id],function(tx,results){
				var registros = results.rows.length;
				if(registros == 0){
					var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
					db.transaction(function(tx){
						tx.executeSql('INSERT INTO Boleto (idBoleto,strQr,strBarcode,idCli,idCon,idLocB,nombreHISB,documentoHISB,strEstado,identComprador) VALUES (?,?,?,?,?,?,?,?,?,?);',[id,qr,barcode,cliente,concierto,local,nombre,cedula,estado,identComprador],
						function(tx,res){
							// console.log("vamos:"+res.insertId)
						});                
					},errorCB,successCB);
				}else{
					var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
					db.transaction(function(tx){
						tx.executeSql('UPDATE Boleto SET identComprador = ? WHERE idBoleto = ?;',[identComprador,id],function(tx,results){
							
						},errorCB,successCB);
					});
				}
			},errorCB,successCB);
		});
		count++;
	});
	$('#waitbajar').fadeOut('slow');
	$('#btnbajar').delay(600).fadeIn('slow');
	// window.location = '';
	// if(idurl == 1){
		// setTimeout("window.location='subpages/ingreso.html';",1500);
	// }else{
		// setTimeout("window.location='';",1500);
	// }
}

function validarBoleto(e){
	if(e.which == 13){
		validarIngreso();
	}
}

function validarBoletocodigo(e){
	if(e.which == 13){
		validarIngresocodigo();
	}
}

var meses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f = new Date();;
var valor = f.getFullYear()+'-'+meses[f.getMonth()]+'-'+f.getDate();

var hora = f.getHours();
var minuto = f.getMinutes();
var segundo = f.getSeconds(); 

var horas = hora+':'+minuto+':'+segundo;

var timestamp = valor+' '+horas;
// alert(timestamp);

function validarIngresocodigo(){
	// alert('hola');
	var codigo = $('#onlycodigo').val();
	if(codigo == ''){
		$('#error1').modal('show');
	}else{
		$('#btnvalidar').fadeOut('slow');
		$('#waitvalidar').delay(600).fadeIn('slow');
		// alert(codigo+' - '+cedula);
		var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
		db.transaction(function(tx){
			tx.executeSql('SELECT * FROM Boleto WHERE strBarcode = ?;',[codigo],function(tx,results){
				var registros = results.rows.length;
				if(registros > 0){
					var row = results.rows.item(0);
					var nombre = row.nombreHISB;
					var estado = row.strEstado;
					var id = row.idBoleto;
					var identComprador = row.identComprador;
					if(identComprador == 1){
						$('.smsback').css('background-color','red');
						$('#titlemodal').html('Atención');
						$('#mensaje').html('El Boleto  ' +  codigo  + '  NO PUEDE INGRESAR AL CONCIERTO YA QUE NO ESTA CANJEADO POR EL REAL Y DEBE CANJEARLO');
						$('#nombre').html(row.nombreHISB);
						$('#sms').modal('show');
						//window.location = '';
					}else{
						if(estado == "A"){
							
							var idabajo = row.idabajo;
							var inactivo = "I";
							// alert(nombre);
							$('.smsback').css('background-color','#5cb85c');
							$('#titlemodal').html('Boleto Correcto!');
							$('#mensaje').html('Datos Correctos, INGRESE!');
							$('#nombre').html(row.nombreHISB);
							var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
							db.transaction(function(tx){
								tx.executeSql('UPDATE Boleto SET strEstado = ? WHERE idabajo = ? AND idBoleto = ?;',[inactivo,idabajo,id],function(tx,results){
									
								},errorCB,successCB);
							});
							var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
							db.transaction(function(tx){
								tx.executeSql('INSERT INTO auditoria (idBoleto,estado,fecha) VALUES (?,?,?);',[id,'Boleto Correcto',timestamp],function(tx,res){
									
								},errorCB,successCB);                
							});
							$('#sms').modal('show');
						}else{
							// alert('ya usado');
							var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
							db.transaction(function(tx){
								tx.executeSql('INSERT INTO auditoria (idBoleto,estado,fecha) VALUES (?,?,?);',[id,'Boleto Usado',timestamp],function(tx,res){
									
								},errorCB,successCB);                
							});
							$('.smsback').css('background-color','#C51D34');
							$('#titlemodal').html('Boleto Correcto!');
							$('#mensaje').html('BOLETO YA USADO!');
							$('#nombre').html(row.nombreHISB);
							$('#sms').modal('show');
						}
					}
				}else{
					$('.smsback').css('background-color','#f0ad4e');
					$('#titlemodal').html('Boleto Incorrecto!');
					$('#mensaje').html('Datos Incorrectos!');
					$('#sms').modal('show');
				}
				$('#waitvalidar').fadeOut('slow');
				$('#btnvalidar').delay(600).fadeIn('slow');
			},errorCB,successCB);
		});
		setTimeout("$('.smsback').css('background-color','#fff'); $('#titlemodal').html(''); $('#mensaje').html(''); $('#nombre').html(''); $('#sms').modal('hide'); $('#onlycodigo').val(''); $('#codigo').focus();",2500);
	}
}

function validarIngreso(){
	// alert('hola');
	var codigo = $('#codigo').val();
	var cedula = $('#cedula').val();
	if((codigo == '') || (cedula == '')){
		$('#error1').modal('show');
	}else{
		$('#btnvalidar').fadeOut('slow');
		$('#waitvalidar').delay(600).fadeIn('slow');
		// alert(codigo+' - '+cedula);
		var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
		db.transaction(function(tx){
			tx.executeSql('SELECT * FROM Boleto WHERE strBarcode = ? AND documentoHISB = ?;',[codigo,cedula],function(tx,results){
				var registros = results.rows.length;
				if(registros > 0){
					var row = results.rows.item(0);
					var nombre = row.nombreHISB;
					var estado = row.strEstado;
					var identComprador = row.identComprador;
					if(identComprador == 1){
						//alert('Atención!!! El Boleto  ' +  codigo  + '  NO PUEDE INGRESAR AL CONCIERTO YA QUE NO ESTA CANJEADO POR EL REAL Y DEBE CANJEARLO');
						$('.smsback').css('background-color','red');
						$('#titlemodal').html('Atención');
						$('#mensaje').html('El Boleto  ' +  codigo  + '  NO PUEDE INGRESAR AL CONCIERTO YA QUE NO ESTA CANJEADO POR EL REAL Y DEBE CANJEARLO');
						$('#nombre').html(row.nombreHISB);
						$('#sms').modal('show');
						//window.location = '';
					}else{
						if(estado == "A"){
							var id = row.idBoleto;
							var idabajo = row.idabajo;
							var inactivo = "I";
							// alert(nombre);
							$('.smsback').css('background-color','#5cb85c');
							$('#titlemodal').html('Boleto Correcto!');
							$('#mensaje').html('Datos Correctos, INGRESE!');
							$('#nombre').html(row.nombreHISB);
							var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
							db.transaction(function(tx){
								tx.executeSql('UPDATE Boleto SET strEstado = ? WHERE idabajo = ? AND idBoleto = ?;',[inactivo,idabajo,id],function(tx,results){
									
								},errorCB,successCB);
							});
							var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
							db.transaction(function(tx){
								tx.executeSql('INSERT INTO auditoria (idBoleto,estado,fecha) VALUES (?,?,?);',[id,'Boleto Correcto',timestamp],function(tx,res){
									
								},errorCB,successCB);                
							});
							$('#sms').modal('show');
						}else{
							var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
							db.transaction(function(tx){
								tx.executeSql('INSERT INTO auditoria (idBoleto,estado,fecha) VALUES (?,?,?);',[id,'Boleto Usado',timestamp],function(tx,res){
									
								},errorCB,successCB);                
							});
							// alert('ya usado');
							$('.smsback').css('background-color','#C51D34');
							$('#titlemodal').html('Boleto Correcto!');
							$('#mensaje').html('BOLETO YA USADO!');
							$('#nombre').html(row.nombreHISB);
							$('#sms').modal('show');
						}
					}
				}else{
					$('.smsback').css('background-color','#f0ad4e');
					$('#titlemodal').html('Boleto Incorrecto!');
					$('#mensaje').html('Datos Incorrectos!');
					$('#sms').modal('show');
				}
				$('#waitvalidar').fadeOut('slow');
				$('#btnvalidar').delay(600).fadeIn('slow');
			},errorCB,successCB);
		});
		setTimeout("$('.smsback').css('background-color','#fff'); $('#titlemodal').html(''); $('#mensaje').html(''); $('#nombre').html(''); $('#sms').modal('hide'); $('#codigo').val(''); $('#cedula').val(''); $('#codigo').focus();",4500);
	}
}

function bajardatos(){
	$('#btnbajar').fadeOut('slow');
	$('#waitbajar').delay(600).fadeIn('slow');
	$.get("http://www.lcodigo.com/ticket/apiMovil/bajarMovil.php").done(function(response){
		if(response != 'error'){
			
			var content = '<table>'
			
			var objDatos = jQuery.parseJSON(response);

			for(i=0; i <= (objDatos.Boletos.length -1); i++){
				var id = objDatos.Boletos[i].idBoleto; 
				var qr = objDatos.Boletos[i].qr;
				var barcode = objDatos.Boletos[i].barcode;
				var cliente = objDatos.Boletos[i].cliente;
				var concierto = objDatos.Boletos[i].concierto;
				var local = objDatos.Boletos[i].local;
				var nombre = objDatos.Boletos[i].nombre;
				var cedula = objDatos.Boletos[i].cedula;
				var estado = objDatos.Boletos[i].estado;
				var identComprador = objDatos.Boletos[i].identComprador;
				
				content += '<tr class="dataBoleto">\
								<td><input type="hidden" class="id" value="'+id+'" /></td>\
								<td><input type="hidden" class="qr" value="'+qr+'" /></td>\
								<td><input type="hidden" class="barcode" value="'+barcode+'" /></td>\
								<td><input type="hidden" class="cliente" value="'+cliente+'" /></td>\
								<td><input type="hidden" class="concierto" value="'+concierto+'" /></td>\
								<td><input type="hidden" class="local" value="'+local+'" /></td>\
								<td><input type="hidden" class="nombre" value="'+nombre+'" /></td>\
								<td><input type="hidden" class="cedula" value="'+cedula+'" /></td>\
								<td><input type="hidden" class="estado" value="'+estado+'" /></td>\
								<td><input type="hidden" class="identComprador" value="'+identComprador+'" /></td>\
							</tr>';
			}
			content += '</table>';
			
			var idurl = 2;
			$('#boletos').html(content);
			insertarDatos(idurl);
		}
	});
}

function subirdatos(){
	$('#btnsubir').fadeOut('slow');
	$('#waitsubir').delay(600).fadeIn('slow');
	var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
	db.transaction(function(tx){
		tx.executeSql('SELECT * FROM Boleto;',[],function(tx,results){
			var registros = results.rows.length;
			var datos = '';
			for(var i = 0; i < registros; i++){
				var row = results.rows.item(i);
				var id = row.idBoleto;
				var estado = row.strEstado;
				
				datos += id +'|'+ estado +'|'+'@';
			}
			console.log(datos);
			var valores = datos.substring(0,datos.length -1);
			$.get("http://www.lcodigo.com/ticket/apiMovil/subidaMovil.php?datos="+valores).done(function(response){
				console.log(response);
				$('#waitsubir').fadeOut('slow');
				$('#btnsubir').delay(600).fadeIn('slow');
			});
		},errorCB,successCB);
	});
}

function subirauditoria(){
	var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
	db.transaction(function(tx){
		tx.executeSql('SELECT * FROM auditoria;',[],function(tx,results){
			var registros = results.rows.length;
			var datos = '';
			for(var i = 0; i < registros; i++){
				var row = results.rows.item(i);
				var id = row.id;
				var estado = row.estado;
				var boleto = row.idBoleto;
				var fecha = row.fecha;
				
				datos += id +'|'+ estado +'|'+ boleto +'|'+ fecha +'|'+'@';
			}
			console.log(datos);
			var valores = datos.substring(0,datos.length -1);
			$.get("http://www.lcodigo.com/ticket/apiMovil/auditoriaMovil.php?datos="+valores).done(function(response){
				console.log(response);
				$('#waitsubir').fadeOut('slow');
				$('#btnsubir').delay(600).fadeIn('slow');
			});
		},errorCB,successCB);
	});
}

function cedulaManual(){
	var codigo = $('#codigo').val();
	var db = window.openDatabase("Database", "1.0", "TicketMobile", 200000);
	db.transaction(function(tx){
		tx.executeSql('SELECT documentoHISB FROM Boleto WHERE strBarcode = ?;',[codigo],function(tx,results){
			var registros = results.rows.length;
			if(registros > 0){
				var row = results.rows.item(0);
				var cedula = row.documentoHISB;
				$('#cedula').val(cedula);
			}else{
				$('#error2').modal('show');
				$('#codigo').val('');
				$('#cedula').val('');
				$('#codigo').focus();
			}
		},errorCB,successCB);
	});
}

setInterval(bajardatos, 60000);
setInterval(subirdatos, 90000);
setInterval(subirauditoria, 60000);