$( document ).ready(function(){
		var pago = $('#cmbpago').val();
		var evento = $('#idConcierto').val();
		if(pago == 1){
			accion = 'pagotarjeta.php?evento='+evento;
			$('#datos').attr('action',accion);
		}else{
			if(pago == 2){
				alert('Tienes 24 horas para registrar tu depósito');
				accion = 'predeposito.php?evento='+evento;
				$('#datos').attr('action', accion);
			}else{
				alert('Escoje otra forma de pago');
			}
		}
		
		if(!document.getElementById('codigo')){
			alert('NO HA SELECCIONADO NINGUN BOLETO, POR FAVOR HAGALO');
			window.location = '../Conciertos/des_concierto.php?con='+evento;
		}
		
		$('#cmbpago').on('change',function(){
			var cmb_pago = $('#cmbpago').val();
			if(cmb_pago == 1){
				accioncmb = 'pagotarjeta.php?evento='+evento;
				$('#datos').attr('action',accioncmb);
			}else{
				if(cmb_pago == 2){
					alert('Tienes 24 horas para registrar tu depósito');
					accioncmb = 'predeposito.php?evento='+evento;
					$('#datos').attr('action',accioncmb);
				}
			}
		});
		
		$('#modificar').on('click',function(){
			$('#datos').attr('action','');
			$('#modificar').prop('type','submit');
			alert('Se mostrara su perfil para modificar sus datos');
			accionmod = '../perfilcliente.php?con='+evento;
			$('#datos').attr('action',accionmod);
		});
	});
	
	function op(){
		var o = window.open('terminosuso.php','ventana1','width=800px, height=600px');
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
		//var TimeStr = LeadingZero(Hours+(Days*24)) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
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
	setTimeout("document.location.href='../index.php';",600000);