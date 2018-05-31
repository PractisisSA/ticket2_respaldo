<?php
	header("Access-Control-Allow-Origin: *");
	session_start();
	$datos = $_REQUEST['valores'];
	// echo $datos;
	
	$exp1 = explode("@",$datos);
	// print_r($exp1);
	for($i=0;$i<count($exp1);$i++){
		// echo $exp1[$i]."<br>";
		$exp2 = explode('|',$exp1[$i]);
		//print_r($exp2);
		for($j=0;$j<count($exp2);$j++){
			
			echo $exp2[$j]."<br>";
			
			$idlocal=$exp2[0];
			$precio = $exp2[1];
			$roww = $exp2[0];
			$coll = $exp2[3];
			$chair = $exp2[4];
			$des = $exp2[6]."--".$exp2[5];
			$cantidad = $exp2[2];
			$concierto = $exp2[8];
			$total = ($precio * $cantidad);
			

			
		}
		$compras[]=array(
			"local"=>$idlocal,
			"precio"=>$precio,
			"cantidad"=>$cantidad,
			"roww"=>$roww,
			"coll"=>$coll,
			"chair"=>$chair,
			"des"=>$des,
			"concierto"=>$concierto,
			"total"=>$total
		);
	}
	$_SESSION['carrito']=$compras;
	// echo json_encode($_SESSION['carrito']);
?>