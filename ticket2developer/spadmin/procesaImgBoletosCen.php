	<?php
		session_start();
		$conciertoID = $_SESSION['conciertoID'];
		$rv='';
		include 'conexion.php';
		$uploaddir = '../../img/pcx/';
		$uploadfile = $uploaddir.$rv;
		$uploadfile2 = $rv.basename($_FILES['uploadfile']['name']);
		$uploadfile = $uploaddir.$uploadfile2;
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
			$sql = 'UPDATE Concierto SET img_bol_cen = "img/pcx/'.$uploadfile2.'" where idConcierto = "'.$conciertoID.'" ';
			$res = mysql_query($sql) or die (mysql_error());
			if($res){
				echo 'img/pcx/'.$uploadfile2;
			}else{
				echo 'error';
			}
		}else{
			echo "no se pudo subir";
		}
	?>
