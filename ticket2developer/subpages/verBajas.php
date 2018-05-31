<?php
	session_start();
	if($_SESSION['perfil']=='Distribuidor'){
		$filtro = ' and id_usu_venta = "'.$_SESSION['iduser'].'"';
	}else{
		$filtro = '';
	}
	include '../conexion.php';
	$local = $_REQUEST['local'];
	$des = $_REQUEST['des'];
	$sqlOk = 'SELECT * FROM Localidad where idLocalidad = "'.$local.'" ';
	$resOk = mysql_query($sqlOk) or die(mysql_error());
	$rowOk = mysql_fetch_array($resOk);
	echo $resOk['idLocalidad'];

	$sqlBol = 'SELECT * FROM Boleto where  idCon = "'.$des.'" and idLocB = "'.$local.'" '.$filtro.' order by serie_localidad ASC';
	echo $sqlBol;
?>
<table class = 'table' style = 'width:60%;align:center;' align="center">
		<tr>
			<th style = '-moz-animation:middle;text-align:right;width:50%;padding-right:5%;border-right: 1px solid #ccc'>
				Boleto
			</th>
			<th style = 'vertical-align:middle; text-align: center'>
				Accion
			</th>
		</tr>
<?php	
	while ($rowFor1 = mysql_fetch_array($resBoletosBaja)) {
?>
	<tr>
		<td style = '-moz-animation:middle;text-align:right;width:50%;padding-right:5%;border-right: 1px solid #ccc'>
			<?php echo $rowFor1['idBoleto'];?>
		</td>
		<?php  ?>
		<td style = 'text-align: center;'>
			<button onclick="buit(<?php echo $rowFor1['idBoleto']; ?>, <?php echo $rowFor1['idCon']; ?>)">Activar</button>
		</td>
	</tr>
<?php } ?>
<script type="text/javascript">
	
</script>