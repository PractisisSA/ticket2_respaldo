<?php
	include '../../conexion.php';
	$id_socio = $_REQUEST['id_socio'];
	$sqlS = 'select * from Socio order by nombresS ASC';
	$resS = mysql_query($sqlS) or die (mysql_error());
	// echo '<select>';
	while($rowS = mysql_fetch_array($resS)){
		if($rowS['idSocio'] == $id_socio){
			$selected = 'selected';
		}else{
			$selected = '';
		}
		echo "<option value = '".$rowS['idSocio']."' ".$selected .">".$rowS['nombresS']."</option>";
	}
	// echo '</select>';
?>