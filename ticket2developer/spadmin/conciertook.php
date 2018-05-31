<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<?php
	include("../controlusuarios/seguridadSA.php");
	require('../Conexion/conexion.php');
	$id = $_GET['id'];
	$est = "Activo";
	$sql = "UPDATE Concierto SET strEstado = '$est' WHERE idConcierto = '$id'";
	$res = $mysqli->query($sql);
	if ($res > 0){
		echo "<script>alert('Concierto Aprobado');window.location='listaconciertos.php';</script>";
	}else{
		echo'Error en las consultas...';
	}
?>