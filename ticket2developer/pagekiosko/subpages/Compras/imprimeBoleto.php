<?php
	session_start();
	$idboleto = $_SESSION['boletoComprado'];
	//unset($_SESSION['boletoComprado']);
	
	include 'conexion.php';
	$sqlBol = 'SELECT * FROM Boleto WHERE identComprador = "'.$idboleto.'" ';
	$resBol = mysql_query($sqlBol) or die (mysql_error());
	
	$i = 1;

	while($rowBol = mysql_fetch_array($resBol)){
		$sqlConci = 'select * from Concierto where idConcierto = '.$rowBol['idCon'].'';
		$resConci = mysql_query($sqlConci) or die (mysql_error());
		$rowConci = mysql_fetch_array($resConci);
		
		$sqlLoc = 'select * from Localidad where idLocalidad = '.$rowBol['idLocB'].'';
		$resLoc = mysql_query($sqlLoc) or die (mysql_error());
		$rowLoc = mysql_fetch_array($resLoc);
		
	?>
		
			<div id = 'boleto<?php echo $idboleto?>' style="padding-left:6.8031496063px;width:100%;-ms-transform: rotate(-90deg);-webkit-transform: rotate(-90deg);transform: rotate(-90deg);" >
				<table width="100%" height="100%" cellpadding="0" cellspacing="0" border=3 >
					<tr>
						<td valign='middle' align='center' width='180px'>
							<div style="height:120px;width:200px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(-90deg);" align="left" >
								1-<?php echo $i;?>
								<label style='font-size:6px;MARGIN-LEFT:2PX;' id="parteDiminuta">
									AUTH MUN: 206-ESP-0043<BR>
									RUC 179297863001, OBLIGADO A LLEVAR CONTABILIDAD <BR>
									DEL CASTILLO GARRIDO PRODUCCIONES PROCASGAR CIA LTDA<BR>
									CALLE AV 6. DE DICIEMBRE Y QUITUMBE ESQ, AUTH 111848439<BR>
									SEC AUT. 11604, PIE 099254749001 TICKET SHOW S,A <BR>
									BOLETO: (001-002-3214 VALIDEZ: 26/02/2016-26/02/2017)<BR>
									<img src="http://www.codeproject.com/KB/HTML/Code-39-Barcode/htmlbarcode1.png" width="100"/>
								</label>
							</div>
						</td>
						<td valign='top' align='center' width='1000px'>
							<label style="color:blue;">
								<h3><?php echo $rowConci['strEvento']?></h3>
								<h4><?php echo $rowConci['strCaractristica']?></h4>
								<h4><?php echo $rowConci['strLugar']?></h4>
								<h4><?php echo $rowConci['dateFecha']."     ".$rowConci['timeHora']?></h4>
								<h4>Localidad : <?php echo $rowLoc['strDescripcionL']?></h4>
								<h4>Valor : $ <?php echo $rowLoc['doublePrecioL']?></h4>
								
								
							</label>
						</td>
						<td valign='middle' align='center' width='180px'>
							<div style="height:120px;width:200px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(-90deg);" align="left" >
								2-<?php echo $i;?>
								<label style='font-size:6px;MARGIN-LEFT:2PX;' id="parteDiminuta">
									AUTH MUN: 206-ESP-0043<BR>
									RUC 179297863001, OBLIGADO A LLEVAR CONTABILIDAD <BR>
									DEL CASTILLO GARRIDO PRODUCCIONES PROCASGAR CIA LTDA<BR>
									CALLE AV 6. DE DICIEMBRE Y QUITUMBE ESQ, AUTH 111848439<BR>
									SEC AUT. 11604, PIE 099254749001 TICKET SHOW S,A <BR>
									BOLETO: (001-002-3214 VALIDEZ: 26/02/2016-26/02/2017)<BR>
									<img src="http://www.codeproject.com/KB/HTML/Code-39-Barcode/htmlbarcode1.png" width="100"/>
								</label>
							</div>
							
						</td>
					</tr>
				</table>
				<br>
				<hr/>
			</div>
		
	<?php
	$i++;
	}
	
	?>
	