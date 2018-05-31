<?php 
	
	include 'conexion.php';
	
	echo '<input type="hidden" id="data" value="26" />';
	
?>
<style>
	.fecha{
		color:#000;
	}
	.artistas{
		border:1px solid #fff; 
		margin:0;
		text-align:center;
	}
	.detalleart{
		border:1px solid #fff; 
		margin:0;
	}
input[type="text"] , select , textarea {
		width:100%;
	}
	
	
	input[type="radio"]{ display: none; }

label{
  color:#fff;
  font-family: Arial;
  font-size: 14px;
}



input[type="radio"] + label span{
  display: inline-block;
  width: 19px;
  height: 19px;
  background: url(http://ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -38px top no-repeat;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor:pointer;
}

input[type="radio"]:checked + label span{
  background: url(http://ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -57px top no-repeat;
}
</style>
	<script src="spadmin/ajaxupload.js"></script>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
	<script src="js/jquery.datetimepicker.js"></script>
	<script language="javascript" src="spadmin/jquery.canvasAreaDraw.js"></script>
	<div style="margin: 10px -10px">
		<div style="background-color:#171A1B; padding:20px;">
			<div style="border: 2px solid #00AEEF; margin:20px;">
				<div style="background-color:#EC1867; color:#fff; margin:20px 500px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
					<strong>ACTUALIZA CLAVES USUARIOS</strong>
				</div>
				<div class = 'row'>
					
					<div class = 'col-md-12'>
						<table class = 'table' style = 'color:#fff !important;'>
							<tr>
								
								<th>
									EMAIL
								</th>
								<th>
									PERFIL
								</th>
								<th>
									CONTRASE&Ntilde;A
								</th>
								<th>
									Actualizar
								</th>
							</tr>
						<?php
							$sql = 'select * from Usuario order by  strMailU ASC';
							$res = mysql_query($sql) or die (mysql_error());
							while($row = mysql_fetch_array($res)){
						?>
							<tr>
								
								<td>
									<?php echo $row['strMailU'];?>
								</td>
								<td>
									<?php echo $row['strPerfil'];?>
								</td>
								<td>
									<input class = 'form-control' id = 'clave_<?php echo $row['idUsuario'];?>' type = 'password' value = '<?php echo $row['strContrasenaU'];?>' style = 'color:#000;width:300px;'/>
								</td>
								<td>
									<button type="button" class="btn btn-primary" onclick = 'cambiaClave(<?php echo $row['idUsuario'];?>)'>Actualizar  <img src="imagenes/loading.gif" alt="load" id="imgClaves_<?php echo $row['idUsuario'];?>" style="width:20px;display:none;" /></button>
								</td>
							</tr>
						<?php
							}
						?>
						</table>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
<script>
	function cambiaClave(id){
		var nuevaC = $('#clave_'+id).val();
		if(nuevaC == ''){
			alert('NO PUEDE DEJAR ESTE CAMPO VACIO');
			$('#clave_'+id).effect('shake');
		}else{
			alert(nuevaC);
			$('#imgClaves_'+id).fadeIn('fast');
			$.post("spadmin/cambiaClave.php",{ 
				nuevaC : nuevaC , id : id
			}).done(function(data){
				$('#imgClaves_'+id).fadeOut('fast');
				alert(data);
				window.location = '';
			});
		}
	}
</script>