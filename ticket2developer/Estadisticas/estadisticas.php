<?php
	include('controlusuarios/seguridadbeBoletero.php');
	echo '<input type="hidden" id="data" value="1" />';
	
	$gbd = new DBConn();
	
	$idcon = $_GET['id'];
	$nombreevento = "SELECT strEvento FROM Concierto WHERE idConcierto = ?";
	$nom = $gbd -> prepare($nombreevento);
	$nom -> execute(array($idcon));
	$rownom = $nom -> fetch(PDO::FETCH_ASSOC);
	$nombre = $rownom['strEvento'];
?>
<div style="margin: 10px -10px">
	<div style="margin:10px;">
		<div style="background-color:#00aeef; color:#fff; margin:20px 600px 0px 0px; padding:10px 0; font-size:22px; text-align:center;">
			<?php echo $nombre;?>
		</div>
	</div>
</div>
<center>
	<div>
	<div style="display:inline-block;"><iframe src="Estadisticas/boletoXlocalidad.php?id=<?php echo $idcon;?>" width="480px" height="330px" scrolling="auto" frameborder="0"></iframe></div>
	<div style="display:inline-block;"><iframe src="Estadisticas/desboletos.php?id=<?php echo $idcon;?>" width="480px" height="330px" scrolling="auto" frameborder="0"></iframe></div>
	</div>
</center>
<center>
	<div>
	<div style="display:inline-block;"><iframe src="Estadisticas/formpay.php?id=<?php echo $idcon;?>" width="480px" height="330px" scrolling="auto" frameborder="0"></iframe></div>
	<div style="display:inline-block;"><iframe src="Estadisticas/dineroXconcierto.php?id=<?php echo $idcon;?>" width="520px" height="370px" scrolling="auto" frameborder="0"></iframe></div>
	</div>
</center>
<center>
	<div>
	<div style="display:inline-block;"><iframe src="Estadisticas/dineroXlocalidad.php?id=<?php echo $idcon;?>" width="520px" height="370px" scrolling="auto" frameborder="0"></iframe></div>
	<div style="display:inline-block;"><iframe src="Estadisticas/totalXconcierto.php?id=<?php echo $idcon;?>" width="480px" height="330px" scrolling="auto" frameborder="0"></iframe></div>
	</div>
</center>