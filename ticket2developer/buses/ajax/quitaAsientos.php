<?php
	session_start();
	include '../enoc.php';
				$id_ocupadas = $_REQUEST['id_ocupadas'];
				$id = $_REQUEST['id_horario'];
				$id_bus = $_REQUEST['id_bus'];
				$asiento = $_REQUEST['asiento'];
	if(isset($_SESSION['carrito'])){
		
		$compras=$_SESSION['carrito'];
		for($i=0;$i<=count($compras)-1;$i++){
			//echo $compras[$i]['product_id']."<br/<";
			//echo $compras[$i]['product_id']."<-->".$id_ocupadas."<br/>";
			if($compras[$i]['product_id'] == $id_ocupadas){
				$compras[$i] = null;
				
				
				$sql = 'delete from ocupadas where id = "'.$id_ocupadas.'" ';
				$res = mysql_query($sql) or die (mysql_error());
				
				echo 'seeeeeeeeeeeeeeeeee';
			}else{
				echo'noooooou';
			}
		
		}
		$_SESSION['carrito']=array_values($compras);
	}
?>
	