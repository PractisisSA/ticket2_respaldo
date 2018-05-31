<input type="hidden" id="data" value="24" />
<?php
	include '../conexion.php';
	
?>
<div style="margin:10px -10px;">
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<body onload = '$("#recibe_code_barras").focus()'>
		<div style="background-color:#171A1B;"  ><br/><br/>
			<div class = 'row'>
				<div class = 'col-xs-3'></div>
				<div class = 'col-xs-5' style = 'color:#fff;'>
					<div class="content" style = 'text-align:center;'>
						<h2 style = 'padding:10px;background-color:#ED1568;color:#fff;font-size:16px'>ENTREGA DE BOLETOS A PUNTO DE VENTA</h2>
						<br/>
						
						<!-- <input type = 'text' id = 'num_entradas' class = 'form-control entero' placeholder = 'Ingrese el N° de boletos entregados para : <?php echo $_SESSION['useractual'];?>'/> -->
						<br/>
						<!-- <button type="button" class="btn btn-primary" id = 'graba_boletos' onclick = 'graba_boletos()'>Grabar</button> -->
					</div>
				</div>
				<div class = 'col-xs-3'></div>
			</div>
			
			<?php
				$sql = 'select count(idBoleto) as vendidos from Boleto where id_usu_venta = "'.$_SESSION['iduser'].'"';
				$res = mysql_query($sql) or die (mysql_error());
				$row = mysql_fetch_array($res);
				
				$sqlE = 'select sum(cantidad) as entregados from entrega_boletos where id_usu = "'.$_SESSION['iduser'].'"';
				$resE = mysql_query($sqlE) or die (mysql_error());
				$rowE = mysql_fetch_array($resE);
				
				
				$vendidos = $row['vendidos'];
				echo '<input type = "hidden" class = "vendidos" value = "'.$vendidos.'" />';
				
				$sql1 = 'select count(id) as impresos from reimpresio_boleto where iduser = "'.$_SESSION['iduser'].'" ';
				$res1 = mysql_query($sql1) or die (mysql_error());
				$row1 = mysql_fetch_array($res1);
				
				$impresos = $row1['impresos'];
				
				echo '<input type = "hidden" class = "impresos" value = "'.$impresos.'" />';
				
			?>
			<div class = 'row'>
				<div class = 'col-xs-3'></div>
				<div class = 'col-xs-5' style = 'color:#fff;'>
					<table class = 'table'>
						<tr>
							<td colspan = '2'>
								Detalle boletos
							</td>
						</tr>
						<tr>
							<td>
								Entregados : 
							</td>
							<td>
								<div id = 'entregados'><?php echo $rowE['entregados'];?></div>
							</td>
						</tr>
						<tr>
							<td>
								Vendidos : 
							</td>
							<td>
								<div id = 'vendidos'><?php echo $vendidos;?></div>
							</td>
						</tr>
						<tr>
							<td>
								Reimpresos : 
							</td>
							<td>
								<div id = 'vendidos'><?php echo $impresos;?></div>
							</td>
						</tr>
						<tr>
							<td>
								TOTAL : 
							</td>
							<td>
								<?php
									echo ($rowE['entregados'] - ($vendidos));
								?>
							</td>
						</tr>
					</table>
				</div>
				<div class = 'col-xs-3'></div>
			</div>
		</div>
	</body>
</div>
<?php
	echo "<input type = 'hidden' value = '".$_SESSION['idDis']."' id = 'idDistri' />";
?>
<script type="text/javascript">
	function graba_boletos(){
		var cboEvento = $('#cboEvento').val();
		var num_entradas = $('#num_entradas').val();
		var idDistri = $('#idDistri').val();
		if(cboEvento == ''){
			alert('Seleccione un evento');
		}
		if(num_entradas == ''){
			alert('ingrese el numero de boletos entregados');
		}
		
		if(cboEvento == '' || num_entradas == '' ){
			
		}else{
			$.post("distribuidor/asigna_boletos.php",{ 
				cboEvento : cboEvento , idDistri : idDistri , num_entradas : num_entradas
			}).done(function(data){
				alert(data);	
				window.location = '';
			});
		}
	}
$( document ).ready(function() {
	var vendidos = $('.vendidos').val();
	var impresos = $('.impresos').val();
	
	var total = (parseInt(vendidos) + parseInt(impresos));
	//alert(total);
	$('#total').html(total);
	
    console.log( "ready!" );
	$("#cboEvento").change(function(e){
		var cboEvento = $('#cboEvento').val();
		var idDistri = $('#idDistri').val();
		//alert(cboEvento);		
		$.post("distribuidor/saber_boletos_entregados_distribuidor.php",{ 
			cboEvento : cboEvento , idDistri : idDistri
		}).done(function(data){
			if(data == 0){
				$('#graba_boletos').fadeIn('slow');
				$('#num_entradas').val('');
				$('#entregados').html('');
			}else{
				$('#num_entradas').val('Se entrego : ' + data + '  boletos' );
				$('#entregados').html(data);
				$('#graba_boletos').fadeOut('fast');
				
				var vendidos = $('.vendidos').val();
				var impresos = $('.impresos').val();
				
				
				var total = (parseInt(data) - (parseInt(vendidos) + parseInt(impresos)) );
				//alert(total);
				$('#total').html(total);
			}	
		});
	});
});
	// $("#recibe_code_barras").keyup(function(e){
        // $("#recibe_code_barras").css("background-color", "pink");
			// var boleto = $("#recibe_code_barras").val();
			// //alert(boleto);
			// var ident = 1;
			// if(e.keyCode == 13){
				// $.post("distribuidor/recibeBoletoBaja.php",{ 
					// boleto : boleto , ident : ident
				// }).done(function(data){
					// alert(data);
					// window.location ='';
				// });
			// }
    // });
	$("#recibe_code_barras").blur(function(){
        $("#recibe_code_barras").css("background-color", "white");
    });
	$('.entero').numeric();
	/*
 *
	 * Copyright (c) 2006-2010 Sam Collett (http://www.texotela.co.uk)
	 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
	 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
	 * 
	 * Version 1.2
	 * Demo: http://www.texotela.co.uk/code/jquery/numeric/
	 *
	 */
	(function($) {
	/*
	 * Allows only valid characters to be entered into input boxes.
	 * Note: does not validate that the final text is a valid number
	 * (that could be done by another script, or server-side)
	 *
	 * @name     numeric
	 * @param    decimal      Decimal separator (e.g. '.' or ',' - default is '.'). Pass false for integers
	 * @param    callback     A function that runs if the number is not valid (fires onblur)
	 * @author   Sam Collett (http://www.texotela.co.uk)
	 * @example  $(".numeric").numeric();
	 * @example  $(".numeric").numeric(",");
	 * @example  $(".numeric").numeric(null, callback);
	 *
	 */
	$.fn.numeric = function(decimal, callback)
	{
		decimal = (decimal === false) ? "" : decimal || ".";
		callback = typeof callback == "function" ? callback : function(){};
		return this.data("numeric.decimal", decimal).data("numeric.callback", callback).keypress($.fn.numeric.keypress).blur($.fn.numeric.blur);
	}

	$.fn.numeric.keypress = function(e)
	{
		var decimal = $.data(this, "numeric.decimal");
		var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
		// allow enter/return key (only when in an input box)
		if(key == 13 && this.nodeName.toLowerCase() == "input")
		{
			return true;
		}
		else if(key == 13)
		{
			return false;
		}
		var allow = false;
		// allow Ctrl+A
		if((e.ctrlKey && key == 97 /* firefox */) || (e.ctrlKey && key == 65) /* opera */) return true;
		// allow Ctrl+X (cut)
		if((e.ctrlKey && key == 120 /* firefox */) || (e.ctrlKey && key == 88) /* opera */) return true;
		// allow Ctrl+C (copy)
		if((e.ctrlKey && key == 99 /* firefox */) || (e.ctrlKey && key == 67) /* opera */) return true;
		// allow Ctrl+Z (undo)
		if((e.ctrlKey && key == 122 /* firefox */) || (e.ctrlKey && key == 90) /* opera */) return true;
		// allow or deny Ctrl+V (paste), Shift+Ins
		if((e.ctrlKey && key == 118 /* firefox */) || (e.ctrlKey && key == 86) /* opera */
		|| (e.shiftKey && key == 45)) return true;
		// if a number was not pressed
		if(key < 48 || key > 57)
		{
			/* '-' only allowed at start */
			if(key == 45 && this.value.length == 0) return true;
			/* only one decimal separator allowed */
			if(decimal && key == decimal.charCodeAt(0) && this.value.indexOf(decimal) != -1)
			{
				allow = false;
			}
			// check for other keys that have special purposes
			if(
				key != 8 /* backspace */ &&
				key != 9 /* tab */ &&
				key != 13 /* enter */ &&
				key != 35 /* end */ &&
				key != 36 /* home */ &&
				key != 37 /* left */ &&
				key != 39 /* right */ &&
				key != 46 /* del */
			)
			{
				allow = false;
			}
			else
			{
				// for detecting special keys (listed above)
				// IE does not support 'charCode' and ignores them in keypress anyway
				if(typeof e.charCode != "undefined")
				{
					// special keys have 'keyCode' and 'which' the same (e.g. backspace)
					if(e.keyCode == e.which && e.which != 0)
					{
						allow = true;
						// . and delete share the same code, don't allow . (will be set to true later if it is the decimal point)
						if(e.which == 46) allow = false;
					}
					// or keyCode != 0 and 'charCode'/'which' = 0
					else if(e.keyCode != 0 && e.charCode == 0 && e.which == 0)
					{
						allow = true;
					}
				}
			}
			// if key pressed is the decimal and it is not already in the field
			if(decimal && key == decimal.charCodeAt(0))
			{
				if(this.value.indexOf(decimal) == -1)
				{
					allow = true;
				}
				else
				{
					allow = false;
				}
			}
		}
		else
		{
			allow = true;
		}
		return allow;
	}

	$.fn.numeric.blur = function()
	{
		var decimal = $.data(this, "numeric.decimal");
		var callback = $.data(this, "numeric.callback");
		var val = $(this).val();
		if(val != "")
		{
			var re = new RegExp("^\\d+$|\\d*" + decimal + "\\d+");
			if(!re.exec(val))
			{
				callback.apply(this);
			}
		}
	}

	$.fn.removeNumeric = function()
	{
		return this.data("numeric.decimal", null).data("numeric.callback", null).unbind("keypress", $.fn.numeric.keypress).unbind("blur", $.fn.numeric.blur);
	}

	})(jQuery);
</script>
