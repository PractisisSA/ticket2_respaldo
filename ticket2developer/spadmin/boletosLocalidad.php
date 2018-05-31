<?php 
	//include("controlusuarios/seguridadSA.php");
	
	session_start();
	//include("controlusuarios/seguridadSA.php");
	include 'conexion.php';
	//echo $_SESSION['iduser'];
	
	$sqlM = 'select socio from modulo_admin where id_usuario = "'.$_SESSION['iduser'].'" ';
	//echo $sqlM;
	$resM = mysql_query($sqlM) or die (mysql_error());
	$rowM = mysql_fetch_array($resM);
	echo $_SESSION['autentica'];
	
	if($_SESSION['autentica'] == 'tFADMIN_SOCIO'){
?>
		<script>
			window.location = 'http://ticketfacil.ec/ticket2/?modulo=listaEventos';
		</script>
<?php
		$filtro = 'and idUsuario = "'.$rowM['socio'].'" ';
	}else{
		$filtro = '';
	}
	include 'conexion.php';
	$sqlC = 'select strEvento from Concierto where idConcierto = "'.$_REQUEST['id'].'" ';
	$resC = mysql_query($sqlC) or die (mysql_error());
	$rowC = mysql_fetch_array($resC);
	
	echo '<input type="hidden" id="data" value="2" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;width:85%;">
				BOLETOS DEL EVENTO : <span style = 'text-transform:uppercase;'><?php echo $rowC['strEvento'];?></span>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;">
				
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
				<table class = 'table' style = 'color:#fff;'>
					<tr>
						<td>Localidad</td>
						<td>N° Boletos</td>
						<td>Opciones</td>
					</tr>
			<?php
				$sqlL = '	SELECT count(b.idBoleto) as cuantos , l.strDescripcionL as nombre , l.idLocalidad
							FROM `Boleto` as b , Localidad as l 
							WHERE `idCon` = "'.$_REQUEST['id'].'" 
							and b.idLocB = l.idLocalidad
							group by `idLocB` 
							ORDER BY `idBoleto` DESC ';
				$resL = mysql_query($sqlL) or die (mysql_error());
				while($rowL = mysql_fetch_array($resL)){
					$suma += $rowL['cuantos'];
			?>
					<tr>
						<td><?php echo $rowL['nombre'];?></td>
						<td><?php echo $rowL['cuantos'];?></td>
						<td><button type="button" class="btn btn-danger" onclick = 'borrarBoletosLocalidad(<?php echo $_REQUEST['id']?> , <?php echo $rowL['idLocalidad'];?>)' >Borrar Boletos</button></td>
					</tr>
			<?php
				}
			?>
					<tr>
						<th style = 'text-align: center'>Total</th>
						<th style = 'text-align: center'><?php echo $suma;?></th>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	function borrarBoletosLocalidad(idCon ,idLoc ){
		alert(idCon + ' << >> ' + idLoc );
		$.post("spadmin/borrarBoletosLocalidad.php",{ 
			idCon : idCon , idLoc : idLoc
		}).done(function(data){
			alert(data);
			window.location = '';
		});
	}
</script>