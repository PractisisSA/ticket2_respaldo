<?php
	session_start();
	include '../conexion.php';
	$evento_baja = $_REQUEST['evento_baja'];
	$profile = $_SESSION['perfil'];
	$sessionNumber = $_SESSION['iduser'];
	$filtro = '';
	if ($profile == 'Distribuidor') {
		$filtro = 'AND b.id_usu_venta ='.$sessionNumber.'';
	}
	
	$sql = '
				SELECT count(b.serie_localidad) as cuantos, l.strDescripcionL
				FROM `Boleto` as b , Localidad as l
				WHERE b.idCon = "'.$evento_baja.'0000"
				and b.`idLocB` = l.idLocalidad '.$filtro.'
				 GROUP by l.idLocalidad
			';
	$res = mysql_query($sql) or die (mysql_error());
	$res1 = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	if($row['cuantos']>0){
?>
	<table class = 'table' style = 'width:60%;align:center;' align="center">
		<tr>
			<th style = '-moz-animation:middle;text-align:right;width:50%;padding-right:5%;border-right: 1px solid #ccc'>
				Localidad
			</th>
			<th style = 'vertical-align:middle; text-align: center'>
				N° Boletos
			</th>
		</tr>
<?php
		while($row1 = mysql_fetch_array($res1)){
			$sum += $row1['cuantos'];
?>
		<tr>
			<td style = '-moz-animation:middle;text-align:right;width:50%;padding-right:5%;border-right: 1px solid #ccc'>
				<?php echo $row1['strDescripcionL'];?>
			</td>
			<td style = 'text-align: center;'>
				<?php echo $row1['cuantos'];?>
			</td>
		</tr>
<?php
		}
?>
		<tr>
			<td style = 'text-align:right;color:red;font-size:24px;-moz-animation:middle;text-align:right;width:50%;padding-right:5%;border-right: 1px solid #ccc'>
				Total
			</td>
			<td style = 'text-align:center;background-color:#000;color:#449D44;font-size:30px'>
				<?php echo $sum;?>
			</td>
		</tr>
	</table>
	<div id="resu"></div>
<?php
	}else{
		echo 'no hay datos';
	}
		
?>
