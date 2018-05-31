<?php 
	echo $_SESSION['iduser'];
	echo $_SESSION['perfil'];
	//include("controlusuarios/seguridadSP.php");
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="38" />';
	$current_time = date ("Y-m-d");
?>
<style>
	.label.label-warning.label-tag::before {
		border-color: transparent #f4b04f transparent transparent;
	}
	.label.label-tag::before {
		border-color: transparent #b0b0b0 transparent transparent;
	}
	.label.label-tag::before {
		border-style: solid;
		border-width: 10px 12px 10px 0;
		content: "";
		display: block;
		height: 0;
		margin-left: -17px;
		position: absolute;
		top: -1px;
		transform: rotate(360deg);
		width: 0;
	}
	*, *::after, *::before {
		box-sizing: border-box;
	}
	.label.label-tag::after {
		background: #fff none repeat scroll 0 0;
		border-radius: 99px;
		content: "";
		display: block;
		height: 6px;
		margin: -12px 0 0 -10px;
		position: absolute;
		width: 6px;
	}
	*, *::after, *::before {
		box-sizing: border-box;
	}
	.label.label-warning.label-tag {
		border: 1px solid #f4b04f;
	}
	.panel-heading-controls .badge, .panel-heading-controls > .label {
		margin-bottom: -10px;
		margin-top: 1px;
	}
	.label.label-warning {
		background: #f4b04f none repeat scroll 0 0;
	}
	.label.label-tag {
		border: 1px solid #b0b0b0;
	}
	.label.label-tag {
		border-bottom-left-radius: 0;
		border-top-left-radius: 0;
		display: inline-block;
		font-size: 16px;
		line-height: 18px;
		margin-left: 12px;
		padding: 0 5px;
		position: relative;
	}
	.colores{
		color:#fff;
	}
</style>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
<script src="js/jquery.datetimepicker.js"></script>

<link rel="stylesheet" href="https://ticketfacil.ec/ticket2/font-awesome-4.6.3/css/font-awesome.min.css">
<body onload = '$("#boletoCanje").focus();'>
	<div style="margin: 10px -10px">
		<div style="background-color:#171A1B; padding:2px;">
			<div style="border: 2px solid #00AEEF; margin:2px;">
				<table class="table table-bordered" style = 'background-color:#fff;'>
					<tr>
						<th>Distribuidor</th>
						<th># tickets vendidos</th>
						<th>valor recaudado</th>
					</tr>
				<?php
					session_start();
					$idconciertotrans = $_REQUEST['evento_distri'];
					include '../../conexion.php';
					
					if($_SESSION['perfil'] == 'Distribuidor' ){
						$filtro = 'and iddistribuidortrans = "'.$_SESSION['idDis'].'" ';
						
					}else{
						
						$filtro = 'and iddistribuidortrans != 0';
					}
					
					
					$sql = 'SELECT * FROM transaccion_distribuidor WHERE idconciertotrans = "'.$idconciertotrans.'" '.$filtro.' GROUP BY iddistribuidortrans;';
					
					// echo $sql;
					$res = mysql_query($sql) or die (mysql_error());
					$locales = '';
					$locales2 = '';
					
					
						
					while ($row = mysql_fetch_array($res)) {
						
						$sumaPvpD = 0;
						$sumaPvp = 0;
						$pre1=0;
						
						$sqlD1 = 'SELECT * FROM distribuidor WHERE idDistribuidor = "'.$row['iddistribuidortrans'].'"';
						$resD1 = mysql_query($sqlD1) or die (mysql_error());
						$rowD1 = mysql_fetch_array($resD1);
						
						
						$sqlU = 'select idUsuario from Usuario where strObsCreacion = "'.$row['iddistribuidortrans'].'" ';
						$resU = mysql_query($sqlU) or die (mysql_error());
						$rowU = mysql_fetch_array($resU);
						
						$sqlB = 'select count(idBoleto) as cuantos from Boleto where idCon = "'.$idconciertotrans.'" and id_usu_venta = "'.$rowU['idUsuario'].'" ';
						$resB = mysql_query($sqlB) or die (mysql_error());
						$rowB = mysql_fetch_array($resB);
						
						
						
						$sqlB1 = '	select 
									count(b.idBoleto) as cuantos ,  b.idLocB , vl.valor as pre ,b.valor as val , l.strDescripcionL , l.idLocalidad , b.id_desc as descu
									from Boleto as b , Localidad as l , valor_localidad_ventas as vl
									where idCon = "'.$idconciertotrans.'" 
									and tercera = 1 
									and id_usu_venta = "'.$rowU['idUsuario'].'"
									and b.idLocB = l.idLocalidad
									and b.idLocB = vl.id_loc
									and l.idLocalidad = vl.id_loc
									and b.id_desc = vl.id_desc
									and b.colB  > 1
									group by idLocB , b.id_desc
									order by l.strDescripcionL 
								';
						// echo $sqlB1."<br><br>";
						$resB1 = mysql_query($sqlB1) or die (mysql_error());
						
						$pvpD = 0;
						$locales='';
						while($rowB1 = mysql_fetch_array($resB1)){
							if($rowB1['pre'] == 0){
								$pre1 = $rowB1['val'];
							}else{
								$pre1 = $rowB1['pre'];
							}
							$locales .= "<label style = 'color:red;'>".$rowB1['cuantos']."</label>; precio ".$pre1.";<label style = 'color:blue;'>".($rowB1['cuantos'] * $pre1)."</label>;<br><br>";
							// $locales .= ($rowB1['cuantos'] * $pre1);
							$pvpD = ($rowB1['cuantos'] * $pre1);
							$sumaPvpD += $pvpD;
						}
						
						
						$sqlB2 = 'select count(idBoleto) as cuantos , idLocB , valor from Boleto where idCon = "'.$idconciertotrans.'" and colB > 1 and tercera = 0 and id_usu_venta = "'.$rowU['idUsuario'].'" group by idLocB';
						$resB2 = mysql_query($sqlB2) or die (mysql_error());
						
						
						$pvp = 0;
					
						$locales2 = '';
						while($rowB2 = mysql_fetch_array($resB2)){
							$locales2 .= "<label style = 'color:red;'>".$rowB2['cuantos']."</label> $ : ".$rowB2['valor']." total : ".($rowB2['cuantos'] * $rowB2['valor'])." <br><br>";
							$pvp = ($rowB2['cuantos'] * $rowB2['valor']);
							$sumaPvp += $pvp;
						}
						
				?>
					<tr>
						<td>
							<?php echo $rowD1['mailDis'];?> [<?php echo $rowU['idUsuario'];?>]
						</td>
						<td>
							<?php
								echo $rowB['cuantos']."<br>";
								echo $locales."<br><hr>";
								echo $locales2."<br>";
								echo ($sumaPvpD." + ".$sumaPvp);
							?>
						</td>
						<td>
							<?php echo ($sumaPvpD + $sumaPvp);?>
						</td>
					</tr>
				<?php
					}
				?>
				</table>
			</div>
		</div>
	</div>
</body>