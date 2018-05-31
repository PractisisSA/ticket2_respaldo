<?php
	session_start();
	$_SESSION['id_evento'] = $_REQUEST['id'];
	include '../conexion.php';
	$sql = 'select * from vendidos_x_evento where idcon = "'.$_REQUEST['id'].'" ';
	// echo $sql;
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
?>
	<center><button type="button" class="btn btn-success" id = 'upload_img_<?php echo $_REQUEST['id'];?>' onclick = 'cambiarImg(<?php echo $_REQUEST['id'];?>)'>Cambiar Img</button></center><br>
	<span id = 'mensaje'></span>
<?php
	echo '<img id = "foto_subida_'.$_REQUEST['id'].'" src = "http://ticketfacil.ec/ticket2developer/'.$row['foto'].'" class="img-thumbnail" width = "100%" />';
?>