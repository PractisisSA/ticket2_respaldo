<?php 
	require_once('../../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$distribuidor = $_POST['distribuidor'];
	
	$query = "SELECT idConcierto, strEvento FROM detalle_distribuidor JOIN Concierto ON detalle_distribuidor.conciertoDet = Concierto.idConcierto WHERE idDis_Det = ?";
	$stmt = $gbd -> prepare($query);
	$stmt -> execute(array($distribuidor));
	
	$content = '';
	
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
		$content .= '<option value="'.$row['idConcierto'].'">'.$row['strEvento'].'</option>';
	}
	
	echo $content;
?>