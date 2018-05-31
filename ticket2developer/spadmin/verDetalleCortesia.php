<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
-->
<?php
	include '../conexion.php';
	$concierto = $_REQUEST['concierto'];
	$local = $_REQUEST['local'];
	$sqlLo = 'select * from Localidad where idLocalidad = "'.$local.'" ';
	// echo $sqlLo;
	$resLo = mysql_query($sqlLo) or die (mysql_error());
	$rowLo = mysql_fetch_array($resLo);
	
?>
<table class = 'table' width = '85%' align = 'center'>
	<tr>
		<td colspan = '3'>
			<h3 style = 'color:blue;padding-top:0px;'>Detalle de boletos entregados al empresario por fecha</h3>
		</td>
	</tr>
	<tr>
		<td>
			Localidad
		</td>
		<td>
			N° Boletos Entregados
		</td>
		<td>
			Fecha
		</td>
	</tr>
<?php 
	$tipos_boleto_entregado = $_REQUEST['tipos_boleto_entregado'];
	
	$sqlCor = 'select * from cortesias where id_con = "'.$concierto.'" and id_loc = "'.$local.'" and tipo = "2" and estado = "'.$tipos_boleto_entregado.'" ';
	//echo $sqlCor;
	$resCor = mysql_query($sqlCor) or die (mysql_error());
	while($rowCor = mysql_fetch_array($resCor)){
		$sumBol += $rowCor['num_bol'];
?>
	<tr>
		<td>
			<?php echo $rowLo['strDescripcionL'];?>
		</td>
		<td>
			<?php echo $rowCor['num_bol'];?>
		</td>
		<td>
			<?php echo $rowCor['fecha'];?>
		</td>
	</tr>
<?php
	}
?>
	<tr>
		<td>
			Total
		</td>
		<td>
			<h1 style = 'padding-top:0px;color:red;'><?php echo $sumBol;?></h1>
		</td>
		<td>
			
		</td>
	</tr>
</table>