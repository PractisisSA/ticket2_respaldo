<?php
	session_start();
	$datos = $_REQUEST['datos'];
	//echo $datos;
	$exp1 = explode("@",$datos);
	for($i=0;$i<count($exp1)-1;$i++){
		//echo $exp1[$i]."<br>";
		$exp2 = explode('|',$exp1[$i]);
		for($j=0;$j<count($exp2);$j++){
			
			//echo $exp2[$j]."<br>";
			
			$idlocal=$exp2[0];
			$precio = $exp2[1];
			$roww = $exp2[0];
			$coll = $exp2[3];
			$chair = "Asientos no Numerados";
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
	$_SESSION['$cuantoscarrito']=$cuantoscarrito;//asigna contador
	$carro = count($_SESSION['carrito']);
	//echo $carro;
	// unset($_SESSION['carrito']);
	print_r($_SESSION['carrito']);
?>