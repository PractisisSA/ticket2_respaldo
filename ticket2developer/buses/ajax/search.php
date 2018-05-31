<style>
	.terminales:hover{
		background-color:#00AAE7;
		color:#fff;
		cursor:pointer;
	}
</style>
<link rel="stylesheet" href="../font-awesome-4.6.3/css/font-awesome.min.css">
<?php
	include '../enoc.php';
	
    $searchTerm = $_REQUEST['term'];
    
    $query = "SELECT * FROM ciudades WHERE nom LIKE '%".$searchTerm."%' and estado = 1 ORDER BY nom ASC";
	
	$res = mysql_query($query) or die (mysql_error());
?>
	<table border = '0' style='border:1px solid #ccc;background-color:#fff;text-transform:capitalize;' width='83%' align='right'>
<?php
    while ($row = mysql_fetch_array($res)) {
?>
		<tr>
			<td style='border:1px solid #ccc;padding-left:10px;' class = 'terminales'>
				<span style = 'color:#5E5F5F;' class = 'terminales'><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Ciudad : </span><?php echo $row['nom']; ?>
			</td>
			<td style='border:1px solid #ccc;' valign='middle'>
<?php
		$sqlT = 'select * from terminales where id_ciu = "'.$row['id'].'" and estado = 1 ';
		//echo $sqlT;
		$resT = mysql_query($sqlT) or die (mysql_error());
?>
				<table width = '100%' >
<?php
		while($rowT = mysql_fetch_array($resT)){
		
?>		
					<tr>
						<td style='padding:10px;' class = 'terminales' onclick='poneNombreCiudadSalida(<?php echo $row['id'];?>, "<?php echo $row['nom'];?>" ,<?php echo $rowT['id'];?>,"<?php echo $rowT['nombre'];?>")'>
							<span style = 'color:#5E5F5F;' class = 'terminales'><i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Terminal : </span><?php echo $rowT['nombre'];?>
						</td>
					</tr>
<?php
		}
?>
				</table>
<?php
    }
?>
			</td>
		</tr>
<?php    
?>
	</table>