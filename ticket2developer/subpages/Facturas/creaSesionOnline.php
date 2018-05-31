<?php
	header("Access-Control-Allow-Origin: *");
	session_start();
	
	include 'enoc.php';
	// echo $_SESSION['mydiscount']."<br>";
//manejamos en sesion el nombre del usuario que se ha logeado
	echo substr($_REQUEST['local'], 1);
	$s = 'SELECT valor FROM Boleto WHERE idCon = '.$_REQUEST['concierto'].' AND idLocB = '.$_REQUEST['local'].'';
	// echo $s;
	if (isset($_SESSION['$cuantoscarrito'])) {
	}
	else{
		$_SESSION['$cuantoscarrito']=0;	
	}
	
	if ( isset($_SESSION['carrito']) || isset($_POST['concierto'])){
		if(isset ($_SESSION['carrito'])){
			if($_POST['col'] == 1){
				if($_SESSION['mydiscount'] == 0){
					$compras=$_SESSION['carrito'];
					if(isset($_POST['concierto'])){
						$nombre=$_POST['concierto'];
						$precio=0;
						$cantidad=$_POST['local'];
						$product_id=$_POST['row'];
						$espromo=$_POST['col'];
						$id_asiento = $_POST['local']."-".$_POST['row']."-".$_POST['col'];
						$posicion_mapa_inicio=$_POST['posicion_mapa_inicio'];
						$estadoAsiento=$_POST['estadoAsiento'];
						$cuantos = 1;
						$duplicado=-1;
						for($i=0;$i<=count($compras)-1;$i++){
							if($nombre==$compras[$i]['concierto']){
								$duplicado=$i;
							}
						}

						if($duplicado != -1){
							$cantidad_nueva = $compras[$duplicado]['cantidad'] + $cantidad;
								$compras[$duplicado]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad_nueva,"product_id"=>$product_id,"espromo"=>$espromo,"posicion_mapa_inicio"=>$posicion_mapa_inicio,"estadoAsiento"=>$estadoAsiento,"id_asiento"=>$id_asiento,"cuantos"=>$cuantos);
						}else {
								$compras[]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad,"product_id"=>$product_id,"espromo"=>$espromo,"posicion_mapa_inicio"=>$posicion_mapa_inicio,"estadoAsiento"=>$estadoAsiento,"id_asiento"=>$id_asiento,"cuantos"=>$cuantos);
						}
					}

				}else{
					echo 'no puede cargar promo doble xq ya tiene una promo de descuento cargada al carrito';
				}
			}else{
				$compras=$_SESSION['carrito'];
				if(isset($_POST['concierto'])){
					$nombre=$_POST['concierto'];
					$precio=0;
					$cantidad=$_POST['local'];
					$product_id=$_POST['row'];
					$espromo=$_POST['col'];
					$id_asiento = $_POST['local']."-".$_POST['row']."-".$_POST['col'];
					$posicion_mapa_inicio=$_POST['posicion_mapa_inicio'];
					$estadoAsiento=$_POST['estadoAsiento'];
					$duplicado=-1;
					$cuantos = 1;
					for($i=0;$i<=count($compras)-1;$i++){
						if($nombre==$compras[$i]['concierto']){
							$duplicado=$i;
						}
					}

					if($duplicado != -1){
						$cantidad_nueva = $compras[$duplicado]['cantidad'] + $cantidad;
							$compras[$duplicado]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad_nueva,"product_id"=>$product_id,"espromo"=>$espromo,"posicion_mapa_inicio"=>$posicion_mapa_inicio,"estadoAsiento"=>$estadoAsiento,"id_asiento"=>$id_asiento,"cuantos"=>$cuantos);
					}else {
							$compras[]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad,"product_id"=>$product_id,"espromo"=>$espromo,"posicion_mapa_inicio"=>$posicion_mapa_inicio,"estadoAsiento"=>$estadoAsiento,"id_asiento"=>$id_asiento,"cuantos"=>$cuantos);
					}
				}

			}
			
		}else{
			if($_POST['col'] == 1){
				if($_SESSION['mydiscount'] == 0){
					$nombre=$_POST['concierto'];
					$precio=0;
					$cantidad=$_POST['local'];
					$product_id=$_POST['row'];
					$espromo=$_POST['col'];
					$id_asiento = $_POST['local']."-".$_POST['row']."-".$_POST['col'];
					$posicion_mapa_inicio=$_POST['posicion_mapa_inicio'];
					$estadoAsiento=$_POST['estadoAsiento'];
					$cuantos = 1;
					$compras[]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad ,"product_id"=>$product_id,"espromo"=>$espromo,"posicion_mapa_inicio"=>$posicion_mapa_inicio,"estadoAsiento"=>$estadoAsiento,"id_asiento"=>$id_asiento,"cuantos"=>$cuantos);
				}else{
					echo 'no puede cargar promo doble xq ya tiene una promo de descuento cargada al carrito';
				}
			}else{
				$nombre=$_POST['concierto'];
				$precio=0;
				$cantidad=$_POST['local'];
				$product_id=$_POST['row'];
				$espromo=$_POST['col'];
				$id_asiento = $_POST['local']."-".$_POST['row']."-".$_POST['col'];
				$posicion_mapa_inicio=$_POST['posicion_mapa_inicio'];
				$estadoAsiento=$_POST['estadoAsiento'];
				$cuantos = 1;
				$compras[]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad ,"product_id"=>$product_id,"espromo"=>$espromo,"posicion_mapa_inicio"=>$posicion_mapa_inicio,"estadoAsiento"=>$estadoAsiento,"id_asiento"=>$id_asiento,"cuantos"=>$cuantos);
			}
			

		}
		$cuantoscarrito=$_SESSION['$cuantoscarrito']+$_POST['local'];//contador
		if(isset($_POST['cantidadactualizada'])){
			$id=$_POST['id'];
			$contador_cant=$_POST['cantidadactualizada'];
			if($contador_cant<1){
				$compras[$id]=NULL;
			}else{
				$compras[$id]['cantidad']=$contador_cant;
				}
		}
		
		
		if(isset($_POST['id2'])){
			$id=$_POST['id2'];
			$compras[$id]=NULL;
		}
		
		
		
	$_SESSION['carrito']=$compras;
	$_SESSION['$cuantoscarrito']=$cuantoscarrito;//asigna contador
	$carro = count($_SESSION['carrito']);
	//echo count($carro);

	
	}
	
	// if($_POST['estadoAsiento'] == 0){
		// unset($compras['id_asiento']);
	// }
	
	
	// print_r (json_encode($compras));
	// echo '<br><br>';
	// echo '<table>';
	
	
	
	for($i=0;$i<=count($compras)-1;$i++){
		
		// echo'<tr>';
			// echo '<td>';
				// echo 'Concierto : '.$compras[$i]['nombre'].'';
			// echo '</td>';
			// echo '<td>';
				// echo 'Localidad : '.$compras[$i]['cantidad'].'';
			// echo '</td>';
			// echo '<td>';
				// echo 'Posicion : '.$compras[$i]['posicion_mapa_inicio'].'';
			// echo '</td>';
			// echo '<td>';
				// echo 'Fila : '.$compras[$i]['product_id'].'';
			// echo '</td>';
			// echo '<td>';
				// echo 'Asiento : '.$compras[$i]['espromo'].'';
			// echo '</td>';
			// echo '<td>';
				// echo 'Estado : '.$compras[$i]['estadoAsiento'].'';
			// echo '</td>';
			// echo '<td>';
				// echo 'id asiento : '.$compras[$i]['id_asiento'].'';
			// echo '</td>';
		// echo'</tr>';
	}
	// echo '</table>';
	
	$keys = array_keys($compras);
	$lastKey = $keys[count($keys)-1];
	echo $lastKey;
?>