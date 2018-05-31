	<?php
		session_start();
		include '../../enoc.php';
		
		$limite = $_REQUEST['limite'];
		
		$_SESSION['iduser'];
		
		$sql = 'select * from cooperativa where id_usu = "'.$_SESSION['iduser'].'" order by id asc limit 1';
		//echo $sql;
		$res = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($res);
		
		$sqlBu = 'select * from bus where id_coop = "'.$row['id'].'" ORDER BY `id_coop` DESC limit 1';
		$resBu = mysql_query($sqlBu) or die (mysql_error());
		$rowBu = mysql_fetch_array($resBu);
		
		$ultimo = $rowBu['id'];
		$siguiente = ($ultimo + 1);
		
		$codigo = $row['inicial']."-00".$siguiente;
		
		if(isset($_SESSION['limite'])){
			$sqlB = 'update bus set asientos = "'.$limite.'" where id = "'.$_SESSION['id_bus'].'" ';
			$resB = mysql_query($sqlB) or die (mysql_error());
			
		}else{
			
			$sqlB = 'insert into bus (id_coop , asientos , codigo) values ("'.$row['id'].'" , "'.$limite.'" , "'.$codigo.'" ) ';
			$resB = mysql_query($sqlB) or die (mysql_error());
			$_SESSION['id_bus'] = mysql_insert_id();
		}
		
		echo $sqlB;
		$_SESSION['limite'] = $limite;
	?>
	