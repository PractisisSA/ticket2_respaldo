<?php 
	// include("controlusuarios/seguridadSA.php");
	require('Conexion/conexion.php');
	echo '<input type="hidden" id="data" value="1" />';
?>
<?php 
	$selectConcert = "SELECT idConcierto, strEvento FROM Concierto" or die('Error');
	$resultSelectConcert = $mysqli->query($selectConcert);
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 400px 0px 0px; padding-left:30px; font-size:22px;">
				Listado de Clientes con Dep&oacute;sito
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:22px;">
				<strong>Dep&oacute;sitos por Concierto: &nbsp;&nbsp;</strong>
				<select id="searchbyconcert" name="searchbyconcert" class="inputlogin">
					<option value="0">Seleccione...</option>
					<?php while($rowConcert = mysqli_fetch_array($resultSelectConcert)){?>
					<option value="<?php echo $rowConcert['idConcierto'];?>"><?php echo $rowConcert['strEvento']; ?> (<?php echo $rowConcert['idConcierto'];?>)</option>
					<?php }?>
				</select>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
				<table class="tdeposito" id="add_files" style="width:100%; color:#fff; font-size:18px;">
					<tr style="text-align:center">
						
						<td>
							<p><strong>Nombre</strong></p>
						</td>
						<td>
							<p><strong>Documento</strong></p>
						</td>
						<td>
							<p><strong># de Dep&oacute;sito</strong></p>
						</td>
						<td>
							<p><strong>Fecha</strong></p>
						</td>
						<td>
							<p><strong># de Boletos</strong></p>
						</td>
						<td>
							<p><strong>Precio Total</strong></p>
						</td>
						<td>
							<p><strong>Acci&oacute;n</strong></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	verDepositos();
	function verDepositos(){
		
		$.post('spadmin/buscarDepositoXconcierto.php',{
			
		}).done(function(json){
			var obj = jQuery.parseJSON(json);
			var busqueda = obj.Search;
			for(i=0; i <= (obj.Concierto.length -1); i++){
				//alert(obj.Concierto[i].num_dep)
				var id = obj.Concierto[i].id;
				var nombre = obj.Concierto[i].nombre;
				var documento = obj.Concierto[i].documento;
				var num_dep = "'"+obj.Concierto[i].num_dep+"'";
				var fecha = obj.Concierto[i].fecha;
				var num_bol = obj.Concierto[i].num_bol;
				var precio = obj.Concierto[i].precio;
				$('#add_files').append('<tr class="resultado"'+id+'><td style="text-align:center">'+nombre+'</td>\
										<td style="text-align:center">'+documento+'</td>\
										<td style="text-align:center">'+num_dep+'</td>\
										<td style="text-align:center">'+fecha+'</td>\
										<td style="text-align:center">'+num_bol+'</td>\
										<td style="text-align:center">'+precio+'</td>\
										<td align="center">\
											<a  href="javascript:void(0);" class="btnlink" id="acpetar'+id+'" onclick="enviar('+num_dep+' , '+id+')" style="display:block"><strong>!OK</strong>\
											<center><img src="imagenes/ajax-loader.gif" id="img_gif'+id+'" style="display:none"/></center></a>\
											<a href="spadmin/depositoerror.php?ndep='+id+'" class="btnlink" id="error'+id+'" onclick="error('+id+')" style="display:block"><strong>!Cancelar</strong>\
											<center><img src="imagenes/ajax-loader.gif" id="img_gif_error'+id+'" style="display:none"/></center></a>\
										</td>\
										</tr>');
			}
			if(jQuery.isEmptyObject(obj.Concierto)){
				$('#searchbyconcert').val(0);
				alert('No hay DEPOSITOS de este Concierto');
			}
		});
	}
	$('#searchbyconcert').on('change',function(){
		$('.resultado').remove();
		var id_concierto = $('#searchbyconcert').val();
		$.post('spadmin/buscarDepositoXconcierto.php',{
			id_concierto : id_concierto
		}).done(function(json){
			var obj = jQuery.parseJSON(json);
			var busqueda = obj.Search;
			for(i=0; i <= (obj.Concierto.length -1); i++){
				//alert(obj.Concierto[i].num_dep)
				var id = obj.Concierto[i].id;
				var nombre = obj.Concierto[i].nombre;
				var documento = obj.Concierto[i].documento;
				var num_dep = "'"+obj.Concierto[i].num_dep+"'";
				var fecha = obj.Concierto[i].fecha;
				var num_bol = obj.Concierto[i].num_bol;
				var precio = obj.Concierto[i].precio;
				$('#add_files').append('<tr class="resultado"'+id+'><td style="text-align:center">'+nombre+'</td>\
										<td style="text-align:center">'+documento+'</td>\
										<td style="text-align:center">'+num_dep+'</td>\
										<td style="text-align:center">'+fecha+'</td>\
										<td style="text-align:center">'+num_bol+'</td>\
										<td style="text-align:center">'+precio+'</td>\
										<td align="center">\
											<a  href="javascript:void(0);" class="btnlink" id="acpetar'+id+'" onclick="enviar('+num_dep+' , '+id+')" style="display:block"><strong>!OK</strong>\
											<center><img src="imagenes/ajax-loader.gif" id="img_gif'+id+'" style="display:none"/></center></a>\
											<a href="spadmin/depositoerror.php?ndep='+id+'" class="btnlink" id="error'+id+'" onclick="error('+id+')" style="display:block"><strong>!Cancelar</strong>\
											<center><img src="imagenes/ajax-loader.gif" id="img_gif_error'+id+'" style="display:none"/></center></a>\
										</td>\
										</tr>');
			}
			if(jQuery.isEmptyObject(obj.Concierto)){
				$('#searchbyconcert').val(0);
				alert('No hay DEPOSITOS de este Concierto');
			}
		});
	});
	
	function enviar(num_dep , id){
		//alert(num_dep);
		$('#aceptar'+id).css('display','none');
		$('#img_gif'+id).css('display','block');
		$('.resultado'+id).remove();
		$.post('spadmin/depositook.php',{
			num_dep : num_dep ,  id : id 
		}).done(function(data){
			alert(data);
			window.location='';
		});
	}
	
	function error(id){
		$('#error'+id).css('display','none');
		$('#img_gif_error'+id).css('display','block');
	}
</script>