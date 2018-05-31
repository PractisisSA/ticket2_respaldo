			



<?php

	if(basename(__FILE__) == 'carrello.php') $displayRojo='display:none;';
	if(basename(__FILE__) == 'carrello.php') $displayRojo2='display:none;';
 ?>
<?php
	session_start();
	//echo $_SESSION['promociones_dobles'];
	//ini_set('session.cache_expire','300000'); 
	// if(!isset($_SESSION['usuario'])){
		// header("Location:login.php");
	// }
	include 'enoc.php';
	
	echo "<input type='hidden' id='promociones_dobles' value='".$_SESSION['promociones_dobles']."' />";
	
//manejamos en sesion el nombre del usuario que se ha logeado

	if (isset($_POST['descuectoAsignar1'])){
		$queTipoEsSTR=$_POST['queTipoEsSTR'];
		if($queTipoEsSTR) $_SESSION['queTipoEsSTR']= $queTipoEsSTR;
		if ($_POST['descuectoAsignar1']=="0.20"){
			//$_SESSION['mydiscount']=0.20;
			$tipoDescuento=$_POST['tipoDescuento'];
			if(!$_SESSION['tipoDescuento']){
				if($tipoDescuento){
					$_SESSION['tipoDescuento']=$tipoDescuento;
				}
			}else{
				if($tipoDescuento){
					$_SESSION['tipoDescuento']=$tipoDescuento;
				}
			}
			
		}
		else{
			/**/
			$precio=$_POST['precio'];
			$tipoDescuento=$_POST['tipoDescuento'];
			if(!$_SESSION['tipoDescuento']){
				if($tipoDescuento){
					$_SESSION['tipoDescuento']=$tipoDescuento;
				}
			}else{
				if($tipoDescuento){
					$_SESSION['tipoDescuento']=$tipoDescuento;
				}
			}
			$_SESSION['mydiscount']='0';//$_POST['descuectoAsignar1'];//0;
		}
	}
	else{
		if (isset($_SESSION['mydiscount'])){
			//nada
		}
		else
		{
			$_SESSION['mydiscount']=0;
		}
	}
	
	//echo "d:".$_SESSION['mydiscount'];
	
	if ( isset($_SESSION['carrito']) || isset($_POST['nombre'])){
		if(isset ($_SESSION['carrito'])){	
			$compras=$_SESSION['carrito'];
			if(isset($_POST['nombre'])){
				$nombre=$_POST['nombre'];
				$precio=$_POST['precio'];
				$cantidad=$_POST['cantidad'];
				$product_id=$_POST['product_id'];
				$duplicado=-1;
				for($i=0;$i<=count($compras)-1;$i++){
					if($nombre==$compras[$i]['nombre']){
						$duplicado=$i;
					}
				}

				if($duplicado != -1){
					$cantidad_nueva = $compras[$duplicado]['cantidad'] + $cantidad;
						$compras[$duplicado]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad_nueva,"product_id"=>$product_id);
				}else {
						$compras[]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad,"product_id"=>$product_id);
				}
			}
		}else{
			$nombre=$_POST['nombre'];
			$precio=$_POST['precio'];
			$cantidad=$_POST['cantidad'];
			$product_id=$_POST['product_id'];
			$compras[]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad ,"product_id"=>$product_id);

		}
		if(isset($_POST['cantidadactualizada'])){
			$id=$_POST['id'];
			$contador_cant=$_POST['cantidadactualizada'];
			$diferencia=$_POST['cantidadactualizada']-$compras[$id]['cantidad'];
			if($contador_cant<1){
				$compras[$id]=NULL;
			}else{
				$compras[$id]['cantidad']=$contador_cant;
				}
			$cuantoscarrito=$_SESSION['$cuantoscarrito']+$diferencia;//contador
			$_SESSION['$cuantoscarrito']=$cuantoscarrito;//asigna contador
		}
		if(isset($_POST['id2'])){
			$id=$_POST['id2'];
			$diferencia=$compras[$id]['cantidad'];
			$compras[$id] = null;
			$cuantoscarrito=$_SESSION['$cuantoscarrito']-$diferencia;//contador
			$_SESSION['$cuantoscarrito']=$cuantoscarrito;//asigna contador
			
		
			unset($_SESSION['queTipoEsSTR']);
			unset($_SESSION['mydiscount']);
			
		}
	$_SESSION['carrito']=$compras;
	$carro = count($_SESSION['carrito']);
	// echo $carro;

	// print_r($_SESSION['carrito']);
	}
	$identificadorCarrito = $_REQUEST['id'];
	//echo $identificadorCarrito;
	if($identificadorCarrito == ''){
		$identificadorCarrito == 0;
	}

?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="description" content="MongrelPet, cani e gatti." >
			<meta name="MongrelPet.com" content="">
			<link rel="icon" href="../opencart/image/logoCentro.png">
			<title>MongrelPet.com - Carrello</title>
			<link href="css/bootstrap.min.css" rel="stylesheet">
			<link href="css/modern-business.css" rel="stylesheet">
			<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
			<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100,900' rel='stylesheet' type='text/css'>
			<link href='https://fonts.googleapis.com/css?family=Teko:300,400,500,600,700' rel='stylesheet' type='text/css'>
			<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
			<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
			<script>
				
			</script>
			 <script src="https://api.cartstack.com/js/cs.js" type="text/javascript"></script>
    <script type="text/javascript">
      var _cartstack = _cartstack || [];
          _cartstack.push(['setSiteID', 'k49WYlVK']); /* required */
          _cartstack.push(['setAPI', 'tracking']); /* required */
          _cartstack.push(['setCartTotal', '']); /* optional */
    </script>	
			<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63826819-1', 'auto');
  ga('send', 'pageview');

</script>
			<style>
				#botonCompra:hover{
					-webkit-box-shadow: 4px 4px 5px 0px rgba(50, 50, 50, 0.75);
					-moz-box-shadow:    4px 4px 5px 0px rgba(50, 50, 50, 0.75);
					box-shadow:         4px 4px 5px 0px rgba(50, 50, 50, 0.75);
					cursor:pointer;
				}
				#verLoading{
					background-color: rgba(255,255,255, 0.8);
					display: none;
					height: 100%;
					left: 0;
					position: absolute;
					top: 0;
					width: 100%;
					z-index: 2001;
				}
				#titulo2{
					color:#30282a;
					font-family:Teko;
					font-weight:400;
					font-size:40px;
					line-height:33px;
				}
				#precioC2{
					color:#30282a;
					font-family:Teko;
					font-weight:400;
					font-size:20px;
				}
				.fondoFotos2{
					-webkit-box-shadow: 0px 0px 6px 0px rgba(217, 217, 217, 0.75);
					-moz-box-shadow:    0px 0px 6px 0px rgba(217, 217, 217, 0.75);
					box-shadow:         0px 0px 6px 0px rgba(217, 217, 217, 0.75);
					background-color: #fff;
					height: 150px;
					padding-top: 2%;
					padding-left:2%;
					padding-bottom:2%;
					padding-right:2%;
					width: 150px;
				}
				.cantidad{
					width:30px;
					border:1px solid #000;
					text-align:center;
				}
				.eliminar2{
					float:right;
					margin-top:5px;
					margin-right:15px;
					font-family:Roboto;
					font-weight:300;
					font-size:12px;
					padding-bottom:2px;
					cursor:pointer;
				}
				.contCarrello{
					width:100%;
					height:80px;
					padding-top:20px;
					padding-bottom:20px;
					padding-left:10px;
					padding-right:10px;
					background-color:#f2f2f2;
					color:#352d2f;
					font-family:Teko;
					font-weight:400;
					font-size:32px;
				}
				.contCarrello2{
					width:100%;
					height:auto;
					padding-top:20px;
					padding-bottom:20px;
					padding-left:10px;
					padding-right:10px;
					background-color:#f2f2f2;
					color:#352d2f;
					font-family:Teko;
					font-weight:400;
					font-size:22px;
				}
				#botonEnviar2{
					border-top:5px solid #fff; 
					border-bottom:5px solid #fff;
					cursor:pointer;
					width:100%;
					height:80px;
					background-color:#fff;
					color:#0B7B4F;
					font-family:Teko;
					font-weight:300;
					font-size:30px;
					text-align:center;
					padding-top:15px;
				}
				
				.botonEnviar{
					border-top:5px solid #049A5E; 
					border-bottom:5px solid #049A5E;
					cursor:pointer;
					width:100%;
					height:80px;
					background-color:#049A5E;
					color:#fff;
					font-family:Teko;
					font-weight:300;
					font-size:30px;
					text-align:center;
					padding-top:15px;
				}
				.botonEnviar:hover{
					-webkit-box-shadow: 7px 7px 5px 0px rgba(50, 50, 50, 0.75);
					-moz-box-shadow:    7px 7px 5px 0px rgba(50, 50, 50, 0.75);
					box-shadow:         7px 7px 5px 0px rgba(50, 50, 50, 0.75);
				}
			</style>
		</head>
		<body style="padding:0px; font-family: 'Teko', sans-serif; font-size: 20px;">
			
			<?php include "head.php" ?>
			
				<div class="row" style="background-color: #f6f6f6; height:90px; margin-right: 0px; margin-left: 0px;" >	
					<div class="col-md-1">
					</div>
					<div class="col-md-8" style="font-size:40px; padding-top:20px;" id='titulos'>
						Prodotti nel carrello<?php //echo $_SESSION['promociones_dobles']; //echo $_SESSION['queTipoEsSTR']." ".$_SESSION['mydiscount'];?>
					</div>
					<div class="col-md-3">
					</div>
				</div>
			<div class="container">
				<div class="row">
				
				<div class="row" >	
					
					<div class="col-md-8" >
						<?php
							//print_r($_SESSION['carrito'])."<br/>";
							if(isset($_SESSION['carrito'])){
								$total=0;
								for($i=0;$i<=count($compras)-1;$i++){
									if($compras[$i]!=NULL){
										$prod1 	= $_SESSION['idA'];
										$prod2 	= $_SESSION['idB'];
										if($compras[$i]['product_id'] == $prod1 or $compras[$i]['product_id']== $prod2){
											//echo'<span style="color:#fff;">en la posicion '.$i.' hay promo doble</span>';
											$class='elimiraraLaFila';
											$borrara = ''.$i.'';
											$click = '<input type="image" onclick="elimiraraLaFila()" class ="limpiar" name="imageField" id="imageField" src="images/elimina.png" title="Premere per rimuovere il prodotto dal vostro ordine" width="35px"/>';
											$productoActual = $compras[$i]['product_id'];
											$displayCantidad = 'display:none;';
										}else{
											//echo'<span style="color:#fff;">en la posicion '.$i.' no hay promo doble</span>';
											$class='';
											$click='
												<form method="post" action="">
													<span style="display:none;">('.$compras[$i]['cantidad'] * $compras[$i]['precio'].')</span>
													<span id="toolTipBox" width="200"></span>
													<input name="id2" type="hidden" id="id2" value="'.$i.'"/> 
													<input type="image" class ="limpiar" name="imageField" id="imageField" src="images/elimina.png" title="Premere per rimuovere il prodotto dal vostro ordine" width="35px"/>
												</form>
											';
											$borrara = '';
											$productoActual = '';
											$displayCantidad = 'display:block;';
										}
										?>
											<div class='row' style='background-color:#f2f2f2;padding-top:10px;padding-bottom:10px;height:auto;padding-left:10px;border-bottom:5px solid #fff;'>
												<table width='100%' class='<?php echo $class;?>' borrara = '<?php echo $borrara;?>' producto = '<?php echo $productoActual;?>' >	
													<tr>
														<td width='200px' align='center'>
															<div class="fondoFotos2" >
																<?php
																	$sql = 'select foto from product_description where product_id ="'.$compras[$i]['product_id'].'" and language_id ="1"';
																	//echo $sql;
																	$res = mysql_query($sql) or die (mysql_error());
																	while($row = mysql_fetch_array($res)){
																		$foto = $row['foto'];
																		if($foto == ''){
																			echo'<img src="../images/vacio.jpg" border="0" style="width:90px;"/>';
																		}else{
																			echo'	<table width="100%" height="100%">
																						<tr>
																							<td valign="middle" align="center" style="padding:5px;">
																								<img src="../nuevasFotos/'.$foto.'" border="0" style="width:70px;"/>
																							</td>
																						</tr>
																					</table>';
																		}
																	}
																?>
															</div>
														</td>
														<td>
															<div class="col-md-12">
																<div style='line-height:20px;'>
																	<br/>
																	<div id='titulo2'>
																		<?php echo $compras[$i]['nombre'];?>
																	</div><br/>
																	<div id='precioC2'>
																	<?php 
																	
																	if ($compras[$i]['product_id'] == 152 || $compras[$i]['product_id'] == 151){
																		echo 'Quantità massima ordinabile = 2 pezzi';
																	}
																	else
																	{
																		$resultPromo1= validateIfISPromo( 1 , $compras[$i]['product_id'] , $compras);
																		if(!$resultPromo1){
																			$porcent=0;
																			$resultPromo2=validateIfISPromo( 2 , $compras[$i]['product_id'] , $compras );
																			$expPromo2=explode("|" , $resultPromo2);
																			$porcent=$expPromo2[0];
																			echo $expPromo2[1];		
																		}else{
																			echo $resultPromo1;
																		}
																	}
																	
																	
																	echo"	
																	</div><br/>
																	<span style='color:#f6303e;font-family:Teko;font-weight:400;font-size:29px;'>
																		";
																			
																			if($resultPromo1!=''){
																				$compras[$i]['precio']='0';
																				echo "0.00"; 
																			}else{
																				if($porcent){
																					$precioMasDescuento=$compras[$i]['precio'] * ($porcent /100);
																					$valorMenosDescuento = $_SESSION['descuentoAplicar'];//=($compras[$i]['precio'] - $precioMasDescuento);
																					echo "<label style='color:black;text-decoration: line-through;'> ".$_SESSION['precio']." </label><br/>";
																					echo $valorMenosDescuento ;
																					$compras[$i]['precio']=$valorMenosDescuento ;
																				}else{
																					echo $compras[$i]['precio'];	
																				}
																				
																			}  

																		?> &#8364;
																	</span><br/>
																	<table cellspacing='5' cellpadding='5' style='<?php echo $displayCantidad;?>'>
																		<tr>
																			<td valign='middle' align='left'>
																				<span style='color:#30282a;font-size:23px;'> Quantita</span>
																			</td>
																			<td width='10px'></td>
																			
																			<td width='10px'></td>
																			<td valign='middle' align='center'>
																				<form name="form1" method="post" action="">
																					<input type="hidden" name="id" id="id" value="<?php echo $i;?>" />
																					<input type='hidden' value='<?php echo $_SESSION['tipoDescuento']; ?>' class='tipoDescuento' name='tipoDescuento'/>
																					<input type="hidden" CLASS="queTipoEsSTR" value="<?php echo $_SESSION['queTipoEsSTR']; ?>" NAME="queTipoEsSTR" />
																					<span id="toolTipBox" width="200"></span>
																					<table>
																						<tr>
																							<td>
																								<input type="text" id='cantidad<?php echo $compras[$i]['product_id']; ?>'name="cantidadactualizada" value="<?php echo $compras[$i]['cantidad'];?>"  class='cantidadCarrello'  >
																							</td>
																							<td>
																								<table>
																									<tr>
																										<td valign='middle' align='center'>
																											<input type="image" class ='limpiar' name="actualizar" id="actualizar" src="../images/mas.png" onclick='agregar("<?php echo $compras[$i]['product_id'];?>")' title='Presione para actualizar su pedido'>
																										</td>
																									</tr>
																									<tr>
																										<td valign='middle' align='center'>
																											<input type="image" class ='limpiar' name="actualizar" id="actualizar" src="../images/menos.png" onclick='quitar("<?php echo $compras[$i]['product_id'];?>")' title='Presione para actualizar su pedido'>
																										</td>
																									</tr>
																								</table>
																							</td>
																						</tr>
																					</table>
																				</form>
																			</td>
																		</tr>
																	</table>
																</div>
															</div>
														</td>
														<td valign='top' align='right'>
															<div class='eliminar2'>
																<?php
																	echo $click;
																?>
															</div>
														</td>
													</tr>
												</table>
											</div>
										<?php
									$total= $total+($compras[$i]['cantidad'] * $compras[$i]['precio']);
										
									}?>
						<?php
								}
							}
						else{
							echo "";
							}
						?>
					</div>
				<?php 
				if(isset($_SESSION['carrito']))
				{?>
				
					<div class="col-md-4">
						<p style="color:red;font-size:21px;font-weight:bold;margin-top:25px;"> INSERISCI QUI IL TUO CODICE PROMOZIONALE</p> 
						<div class='contCarrello'>
							<input type='text' id="sconto"  placeholder='CODICE PROMOZIONALE' onkeyup="descuentoonlus()" onchange="descuentoonlus()" style='color:#797373;padding-left:10px;width:100%;' /><br/>
						</div>
						<div id='botonEnviar2' >
							TOTALE CARRELLO
						</div>
						<?php
						for($i=0;$i<=count($compras)-1;$i++){
							if($compras[$i]!=NULL){
								if($compras[$i]['product_id'] == 152 || $compras[$i]['product_id'] == 151 || $compras[$i]['product_id'] == 150){
									$consegna = 0;
									$valorT =  "<div style='float:right;'>".$consegna."</div>";
									//echo '<script>document.getElementById("precioC2").innerHTML="Ti stai assicurando sconti e consegne gratuite per 12 mesi.";</script>';
									//echo '<script>document.getElementById("precioC2").innerHTML="";</script>';
								}else{
									if($total > 29){
										$consegna = 0;
										$valorT =  "<div style='float:right;' id='hola'>".$consegna."</div>";
									}else{
										$consegna = 4.9;
										$valorT =  "<div style='float:right;' id='hola2'>".$consegna."</div>";
									}
								}
								
								
							
							}
							//echo '<script>console.log('.$consegna.');</script>';
						}
							
							echo "	<input type='hidden' value='".$consegna."' id='consegna1' />
									<input type='hidden' value='".$total."' id='total1' />
									";
						?>
						<form method="post" action="" id="onlus" name="onlus">
						<?php 
					//	ECHO "<H1>Descuento Tipo $_SESSION[tipoDescuento] $total</H1>";
							// if($_SESSION['tipoDescuento']=="25"){
								
								// $totalTemp=$total;
								// $porciento= (25 * 100/ $totalTemp) /100 ;
								// if($totalTemp>25){
									// $_SESSION['mydiscount']=$porciento;
									// //echo "<h1>Test " . $porciento * $totalTemp."</h1>";
								// }else{
									// $_SESSION['mydiscount']="0";
								// }
								
							// }
							// else{
								// if( $_SESSION['tipoDescuento'] == 20  ){
									
									// $totalTemp=$total;
									// $porciento= (20 * 100/ $totalTemp) /100 ;
									
								// }else{
									// $totalTemp=$total; //0.1341564 
									// $porciento= $_SESSION[tipoDescuento]  ;
										// if($_SESSION[queTipoEsSTR]=='BC001' || $_SESSION[queTipoEsSTR]=='cane1s' || $_SESSION['queTipoEsSTR'] == 'MONGREL15' ){
											// $descuentoEnEuros=10;
											// $porciento = $descuentoEnEuros / $totalTemp;
											// if($_SESSION[queTipoEsSTR]=='BC001'){
												// $mod=intval($total / 29);
												// $descuentoMultiplicado29= $mod * $descuentoEnEuros;
												// $porciento = $descuentoMultiplicado29 / $totalTemp;
												
											// }
										// }
										//mongrelbio
									// if($totalTemp>29){
										
										// $_SESSION['mydiscount']=$porciento;
									// }else{
										
										// $_SESSION['mydiscount']="0";
									// }



									// if( $_SESSION[queTipoEsSTR]=='mongrelbio'  ){
												// $isDiscount=false;
													// for($i=0;$i<=count($compras)-1;$i++){
														// if($compras[$i]!=NULL){
															// $currentID=$compras[$i]['product_id'];
															// $sql = 'select manufacturer_id from product where product_id ="'.$currentID.'" ';
															// $res = mysql_query($sql) or die (mysql_error());
															// $fetch=mysql_fetch_array($res);
															// $currentManu=$fetch['manufacturer_id'];
															
															// if($currentManu == 13 || $currentManu == 16){
																	// $isDiscount=true;
																	
																// //$compras[$i]['precio']=0;
																// //echo $currentManu;		
															// }
														// }
													// }
													// if($isDiscount){
														// $descuentoEnEuros=8;
														// $porciento = $descuentoEnEuros / $total;
														// if($total < 40 ) $porciento=0;
														// $totalTemp=$total;
														// $_SESSION['mydiscount']=$porciento;

													// }else{
														// $porciento=0;
														// $_SESSION['mydiscount']="0";
													// }
											// }



											// if( $_SESSION[queTipoEsSTR]=='mongrelsc'  ){
												
												// $isDiscount=false;
													// for($i=0;$i<=count($compras)-1;$i++){
														// if($compras[$i]!=NULL){
															// $currentID=$compras[$i]['product_id'];
															// $sql = 'select manufacturer_id from product where product_id ="'.$currentID.'" ';
															// $res = mysql_query($sql) or die (mysql_error());
															// $fetch=mysql_fetch_array($res);
															// $currentManu=$fetch['manufacturer_id'];
															// if($currentManu==11 or $currentManu==14)$isDiscount=true;
															// //echo "$currentManu";
														// }
													// }
													// if($isDiscount){

														// $descuentoEnEuros=7;
														// $porciento = $descuentoEnEuros / $total;
														// if($total < 39 ) $porciento=0;
														// $totalTemp=$total;
														// $_SESSION['mydiscount']=$porciento;

													// }else{
														// $porciento=0;
														// $_SESSION['mydiscount']="0";
													// }
											// }
											
											
											
											
										if($_SESSION['promociones_dobles'] == 0){
											
										
											if( $_SESSION[queTipoEsSTR]=='coupon1'){
												
												$isDiscount=false;
													$isDiscount=false;
													for($i=0;$i<=count($compras)-1;$i++){
														if($compras[$i]!=NULL){
															$currentID=$compras[$i]['product_id'];
															$sql = 'select manufacturer_id from product where product_id ="'.$currentID.'" ';
															$res = mysql_query($sql) or die (mysql_error());
															$fetch=mysql_fetch_array($res);
															$currentManu=$fetch['manufacturer_id'];
															// echo $currentManu."<br/>";
															// echo $_SESSION['queTipoEsSTR'];
															if($currentManu > 10 or $currentManu < 17){
																$isDiscount=true;
																
															}
															
															
														}
													}
													if($isDiscount){

														$descuentoEnEuros=11;
														$porciento = $descuentoEnEuros / $total;
														if($total < 40 ) {$porciento=0;}
														$totalTemp=$total;
														$_SESSION['mydiscount']=$porciento;

													}else{
														$porciento=0;
														$_SESSION['mydiscount']="0";
													}
											}
											if( $_SESSION[queTipoEsSTR]=='onlusdiscount20'){
														$porciento = 0.20;
														$_SESSION['mydiscount']=$porciento;
											}
											
											if( $_SESSION[queTipoEsSTR]=='onlusdiscount25'){
														$porciento = 0.25;
														$_SESSION['mydiscount']=$porciento;
											}
											if( $_SESSION[queTipoEsSTR]=='mongrel15'){
														$descuentoEnEuros=10;
														$porciento = $descuentoEnEuros / $total;
														if($total < 40 ) {$porciento=0;}
														$_SESSION['mydiscount']=$porciento;
											}
											if( $_SESSION[queTipoEsSTR]=='top20'){
														$porciento = 0.20;
														if($total < 39 ) {$porciento=0;}
														$_SESSION['mydiscount']=$porciento;
											}
											
											if( $_SESSION[queTipoEsSTR]=='cane1s'){
														$descuentoEnEuros=10;
														$porciento = $descuentoEnEuros / $total;
														if($total < 30 ) {$porciento=0;}
														$_SESSION['mydiscount']=$porciento;
											}
											
											// if( $_SESSION[queTipoEsSTR]=='mongrelbio'  ){
												// $isDiscount=false;
													// for($i=0;$i<=count($compras)-1;$i++){
														// if($compras[$i]!=NULL){
															// $currentID=$compras[$i]['product_id'];
															// $sql = 'select manufacturer_id from product where product_id ="'.$currentID.'" ';
															// $res = mysql_query($sql) or die (mysql_error());
															// $fetch=mysql_fetch_array($res);
															// $currentManu=$fetch['manufacturer_id'];														
															// if($currentManu == 13 || $currentManu == 16){
																	// $isDiscount=true;
															// }
														// }
													// }
													// if($isDiscount){
														// $descuentoEnEuros=8;
														// $porciento = $descuentoEnEuros / $total;
														// if($total < 40 ) $porciento=0;
														// $totalTemp=$total;
														// $_SESSION['mydiscount']=$porciento;

													// }else{
														// $porciento=0;
														// $_SESSION['mydiscount']="0";
													// }
											// }
											
											// if( $_SESSION[queTipoEsSTR]=='mongrelsc'  ){
												// $isDiscount=false;
													// for($i=0;$i<=count($compras)-1;$i++){
														// if($compras[$i]!=NULL){
															// $currentID=$compras[$i]['product_id'];
															// $sql = 'select manufacturer_id from product where product_id ="'.$currentID.'" ';
															// $res = mysql_query($sql) or die (mysql_error());
															// $fetch=mysql_fetch_array($res);
															// $currentManu=$fetch['manufacturer_id'];
															// if($currentManu==11 or $currentManu==14)$isDiscount=true;
														// }
													// }
													// if($isDiscount){

														// $descuentoEnEuros=9;
														// $porciento = $descuentoEnEuros / $total;
														// if($total < 40 ) $porciento=0;
														// $totalTemp=$total;
														// $_SESSION['mydiscount']=$porciento;

													// }else{
														// $porciento=0;
														// $_SESSION['mydiscount']="0";
													// }
											// }
											
											// if( $_SESSION[queTipoEsSTR]=='mongrelbio'  ){
												// $isDiscount=false;
													// for($i=0;$i<=count($compras)-1;$i++){
														// if($compras[$i]!=NULL){
															// $currentID=$compras[$i]['product_id'];
															// $sql = 'select manufacturer_id from product where product_id ="'.$currentID.'" ';
															// $res = mysql_query($sql) or die (mysql_error());
															// $fetch=mysql_fetch_array($res);
															// $currentManu=$fetch['manufacturer_id'];
															
															// if($currentManu == 13 || $currentManu == 16){
																	// $isDiscount=true;
																	
																// //$compras[$i]['precio']=0;
																// //echo $currentManu;		
															// }
														// }
													// }
													// if($isDiscount){
														// $descuentoEnEuros=10;
														// $porciento = $descuentoEnEuros / $total;
														// if($total < 40 ) $porciento=0;
														// $totalTemp=$total;
														// $_SESSION['mydiscount']=$porciento;

													// }else{
														// $porciento=0;
														// $_SESSION['mydiscount']="0";
													// }
											// }
											
											
											if( $_SESSION[queTipoEsSTR]=='mongrelum'){
												
												$isDiscount=false;
													for($i=0;$i<=count($compras)-1;$i++){
														if($compras[$i]!=NULL){
															$currentID=$compras[$i]['product_id'];
															$sql = 'select manufacturer_id from product where product_id ="'.$currentID.'" ';
															$res = mysql_query($sql) or die (mysql_error());
															$fetch=mysql_fetch_array($res);
															$currentManu=$fetch['manufacturer_id'];
															if($currentManu==12 or $currentManu==15)$isDiscount=true;
															//echo "$currentManu";
														}
													}
													if($isDiscount){

														$descuentoEnEuros=10;
														$porciento = $descuentoEnEuros / $total;
														if($total < 39 ) $porciento=0;
														$totalTemp=$total;
														$_SESSION['mydiscount']=$porciento;

													}else{
														$porciento=0;
														$_SESSION['mydiscount']="0";
													}
											}
											
											
											
										}else{
											echo 'no se cargara ningun descuento ';
										}





								// }
								
								
							//}
							//echo "<h1>$porciento --- hello</h1>";
						?>
							<input type='hidden' value='<?php echo $_SESSION['mydiscount']; ?>' id='descuectoAsignar1' name='descuectoAsignar1'/>
							<input type='hidden' value='<?php echo $_SESSION['tipoDescuento']; ?>' class='tipoDescuento' name='tipoDescuento'/>
							<input type="hidden" CLASS="queTipoEsSTR" NAME="queTipoEsSTR" value="<?php echo $_SESSION['queTipoEsSTR']; ?>" />
						</form>
						<div class='contCarrello2'>
							<div style='float:left;'>IMPORTO DELL' ORDINE  &#8364; &nbsp;&nbsp;&nbsp;</div>
							<div style='float:right;'>
								<?php if(isset($_SESSION['carrito'])){
								echo number_format($total,2);
								}?>
							</div>
							<br/>
							<div style='float:left;'>SCONTO &#8364; &nbsp;&nbsp;&nbsp;</div>
							<div style='float:right;' id='descuentoAsignado2'>0</div>
							<br/>
							<div style='float:left;' style='text-transform:uppercase;'>CONTRIBUTO SPESE SPEDIZIONE &#8364; &nbsp;&nbsp;&nbsp;</div>
							<?php echo $valorT; ?></br/><br/>
							<div style='background-color:#e1e1e1;width:100%;height:5px;'></div><br/>
							<div style='float:left;'>TOTALE &#8364; &nbsp;&nbsp;&nbsp;</div>
							<div style='float:right;' id='totalSumatoria2'></div>
							<br/><br/>
							<?php
								if (isset($_SESSION['usuario'])and $_SESSION['pass']){?>
									<div class='botonEnviar' onclick='pago()'>
										PROCEDI ALL' ACQUISTO
									</div>
							<?php
								}else{
							?>
									<div class='botonEnviar' onclick='loginPago()'>
										PROCEDI ALL' ACQUISTO
									</div>
							<?php
								}
							?> 
						</div>
						
					</div>
				<?php
				}else{?>
					<div class="row" >	  
						<div class="col-md-12" style='font-family:Teko;font-size:62px;font-weight:300;color:red;'>
							<center>Non ci sono articoli aggiunti al carrello</center>
						</div>
					</div>
				<?php
				}
				?>
					<div id='verLoading'>
						<table width='80%' height='80%' align='center'>
							<tr>
								<td valign='middle' align='center'>
									<h1 style='color:#991455;'> Stiamo prosesando la transazione</h1>
								</td>
							</tr>
							<tr>
								<td valign='middle' align='center'>
									<img src ='images/loading.gif' height='70%'/>
								</td>
							</tr>
						</table>
						
					</div>
				</div>
			</div>
			
			<?php include "footer.php" ?>
			<script src="js/jquery.js"></script>
			<script src="js/bootstrap.min.js"></script>
	
			<script>
			function elimiraraLaFila(){
				var contador = 1;
				var losProductos = '';
				$('.elimiraraLaFila').each(function(){
					//var n = $('.elimiraraLaFila').length;
					//alert('hay ' + n + 'filas a borrar');
					var productoActual = $(this).attr("borrara");
					//alert('se borrara la fila : ' + filasABorrar);
					
					if(contador<2){
						losProductos += productoActual+'|';
					}else{
						losProductos += productoActual;
					}
					contador++;
				});
				//alert(losProductos);
				$.post('eliminaPromos.php',{
					losProductos : losProductos
				}).done(function(data){
					// $('.Registro').html(data);
					window.location='';
				});
			}
				$(document).ready(function(){
					var consegna1 = $('#consegna1').val();
					var total1 = $('#total1').val();
					var desA1 = total1*$('#descuectoAsignar1').val();
					var sumatoria11 = (parseFloat(consegna1)+parseFloat(total1)-parseFloat(desA1)).toFixed(2);
					//alert("consegna : " + consegna1 +' total : '+ total1 +' descuento : '+ desA1 +' sumatoria : '+ sumatoria11 );
					var eldescuentoneto=(parseFloat(desA1)).toFixed(2);
					
					$('#descuentoAsignado2').html(eldescuentoneto);
					$('#totalSumatoria2').css('display','block');
					//$('#totalSumatoria2').html(total1);
					$('#totalSumatoria2').html(sumatoria11);
					$(".cantidadCarrello").css('border','2px solid #000');
					$(".cantidadCarrello").css('width','30px');
					$(".cantidadCarrello").css('text-align','center');
				});
				$(document).keypress(function(e) {
					
				});
				function loginPago(){
					//alert("Devi effettuare il login per continuare a pagare");
					window.location.href='checkout1.php';
				}
				function pago(){
						window.location.href='checkout2.php';					
				}
				function agregar(id){
					$('#cantidad'+id).val(parseInt($('#cantidad'+id).val()) + 1);
				}
				
				function quitar(id){
					 if ($('#cantidad'+id).val() != 0)
						//Decrementamos su valor
						$('#cantidad'+id).val(parseInt($('#cantidad'+id).val()) - 1);
						if ($('#cantidad'+id).val() == 0){
							$('#cantidad'+id).val(1);
						}
				}
				var anotherCode='';
	function descuentoonlus(){

				var CODIGO=$('#sconto').val();
					// if ($.trim($('#sconto').val())=="onlusdiscount25"){
						// $(".queTipoEsSTR").val('onlusdiscount25');
						// descuentoEnEuros=25;
						// totalProductos=<?php echo number_format($total,2); ?>;
						// porciento=((descuentoEnEuros * 100/ totalProductos).toFixed(2)) /100;
						// if(porciento >=1){
								// alert("Non è possibile utilizzare lo sconto per spese inferiori ad € 25,00");
						// }else{
							// $('#descuectoAsignar1').val(porciento);
							// //alert("Codigo Onlus Sconto Attivato" );
							// $(".tipoDescuento").val("25");
							// document.forms["onlus"].submit();
						// }
						
					// }
				
					// if (	CODIGO.toLowerCase()=="cane1s" || CODIGO.toLowerCase() =="gatto1s" ){
						// $(".queTipoEsSTR").val('cane1s');
						// descuentoEnEuros=10;
						// totalProductos=<?php echo number_format($total,2); ?>;
						// if(totalProductos > 29 ){
							// var porciento=descuentoEnEuros / totalProductos;
							// $("#hola2").html("0");
							// $("#hola").html("0");
							// $(".tipoDescuento").val(porciento);
							// $('#descuectoAsignar1').val(porciento);
							// document.forms["onlus"].submit();
							// console.log("Cane1s");
						// }
						
					// }	
					
					// if ($('#sconto').val()=="onlusdiscount20"){
						// $(".queTipoEsSTR").val('onlusdiscount20');
						// $('#descuectoAsignar1').val("0.20");
						// console.log("discount activated");
						// $(".tipoDescuento").val("20");
						// //alert("Codigo Onlus Sconto Attivato");
						// document.forms["onlus"].submit();
					// }
					// else if ($('#sconto').val()=="noonlusdiscount20"){
						// $('#descuectoAsignar1').val("0");
						// document.forms["onlus"].submit();
					// }
					// else{
						// $('#descuectoAsignar1').val("0");
					// }
					
					
					
					// if ( CODIGO == 'BC001'){
						// $(".queTipoEsSTR").val('BC001');
						// descuentoEnEuros=10;
						// totalProductos=<?php echo number_format($total,2); ?>;
						// if(totalProductos > 10 ){
							// var porciento=descuentoEnEuros / totalProductos;
							// ///alert(porciento);
							// $("#hola2").html("0");
							// $("#hola").html("0");
							// $(".tipoDescuento").val(porciento);
							// $('#descuectoAsignar1').val(porciento);
							// document.forms["onlus"].submit();
							// console.log("Cane1s");
						// }
					// }

					// if ( CODIGO.toLowerCase() == 'mongrelbio'){
						
						// $(".queTipoEsSTR").val('mongrelbio');
						// descuentoEnEuros=8;
						// totalProductos=<?php echo number_format($total,2); ?>;
						// //alert("here?");
						// if(totalProductos > 40 ){
							// var porciento=descuentoEnEuros / totalProductos;
							// ///alert(porciento);
							// $("#hola2").html("0");
							// $("#hola").html("0");
							// $(".tipoDescuento").val(porciento);
							// $('#descuectoAsignar1').val(porciento);
							// document.forms["onlus"].submit();
							
						// }
					// }

					// if ( CODIGO.toLowerCase() == 'mongrelsc'){
						
						// $(".queTipoEsSTR").val('mongrelsc');
						// descuentoEnEuros=7;
						// totalProductos=<?php echo number_format($total,2); ?>;
						// //alert("here?");
						// if(totalProductos > 39 ){
							// var porciento=descuentoEnEuros / totalProductos;
							// ///alert(porciento);
							// $("#hola2").html("0");
							// $("#hola").html("0");
							// $(".tipoDescuento").val(porciento);
							// $('#descuectoAsignar1').val(porciento);
							// document.forms["onlus"].submit();
							
						// }
					// }

					
					
					// if ( CODIGO.toLowerCase() == 'mongrelum'){
						
						// // $(".queTipoEsSTR").val('mongrelum');
						// // descuentoEnEuros=8;
						// // totalProductos=<?php echo number_format($total,2); ?>;
					
						// // if(totalProductos > 39 ){
							// // var porciento=descuentoEnEuros / totalProductos;
							
							// // $("#hola2").html("0");
							// // $("#hola").html("0");
							// // $(".tipoDescuento").val(porciento);
							// // $('#descuectoAsignar1').val(porciento);
							// // document.forms["onlus"].submit();
							
						// // }
					// }
					
		var promociones_dobles = $('#promociones_dobles').val();
		if(promociones_dobles != 0){
			console.log('ya tiene una promoción cargada a su compra no puede aplicar a otra mas');
		}else{
			if ( CODIGO.toLowerCase() == 'coupon1'){
						
					$(".queTipoEsSTR").val('coupon1');
					descuentoEnEuros=11;
					totalProductos=<?php echo number_format($total,2); ?>;
					//alert("here?");
					if(totalProductos >= 40 ){
						var porciento=descuentoEnEuros / totalProductos;
						console.log(porciento);
						$("#hola2").html("0");
						$("#hola").html("0");
						$(".tipoDescuento").val(porciento);
						$('#descuectoAsignar1').val(porciento);
						document.forms["onlus"].submit();
						
					}
				}
				
				if (CODIGO.toLowerCase() == "onlusdiscount20"){
						 $(".queTipoEsSTR").val('onlusdiscount20');
						 $('#descuectoAsignar1').val("0.20");
						 $(".tipoDescuento").val("20");					
						 document.forms["onlus"].submit();
				}
				
				if (CODIGO.toLowerCase() == "onlusdiscount25"){
						 $(".queTipoEsSTR").val('onlusdiscount25');
						 $('#descuectoAsignar1').val("0.25");
						 $(".tipoDescuento").val("25");					
						 document.forms["onlus"].submit();
				}
					
			

				if ( CODIGO.toLowerCase() == 'mongrel15'){
						 $(".queTipoEsSTR").val('mongrel15');
						  descuentoEnEuros=10;
						  totalProductos=<?php echo number_format($total,2); ?>;
						 //alert("here?");
						 if(totalProductos > 39 ){
							 var porciento=descuentoEnEuros / totalProductos;
							 ///alert(porciento);
							 $("#hola2").html("0");
							 $("#hola").html("0");
							 $(".tipoDescuento").val(porciento);
							 $('#descuectoAsignar1').val(porciento);
							 document.forms["onlus"].submit();
							 //console.log("Cane1s");
						 }
				}
				
				if ( CODIGO.toLowerCase() == 'top20'){
					$(".queTipoEsSTR").val('top20');
					totalProductos=<?php echo number_format($total,2); ?>;
					if(totalProductos > 39 ){
						var porciento = 0.20;
						///alert(porciento);
						$("#hola2").html("0");
						$("#hola").html("0");
						$(".tipoDescuento").val(porciento);
						$('#descuectoAsignar1').val(porciento);
						document.forms["onlus"].submit();
						//console.log("Cane1s");
					}
				}
				
				// if ( CODIGO.toLowerCase() == 'mongrelbio'){						
						 // $(".queTipoEsSTR").val('mongrelbio');
						 // descuentoEnEuros=10;
						 // totalProductos=<?php echo number_format($total,2); ?>;
						 // if(totalProductos > 39 ){
							 // var porciento=descuentoEnEuros / totalProductos;
							 // $("#hola2").html("0");
							 // $("#hola").html("0");
							 // $(".tipoDescuento").val(porciento);
							 // $('#descuectoAsignar1').val(porciento);
							 // document.forms["onlus"].submit();
							
						 // }
				// }
				
				
				if ( CODIGO.toLowerCase() == 'mongrelum'){
						
						$(".queTipoEsSTR").val('mongrelum');
						descuentoEnEuros=10;
						totalProductos=<?php echo number_format($total,2); ?>;
					
						if(totalProductos > 39 ){
							var porciento=descuentoEnEuros / totalProductos;
							
							$("#hola2").html("0");
							$("#hola").html("0");
							$(".tipoDescuento").val(porciento);
							$('#descuectoAsignar1').val(porciento);
							document.forms["onlus"].submit();
							
						}
				}
					
					
				if ( CODIGO.toLowerCase() == 'mongrelsc'){
						
						// console.log("discount");
						// $(".queTipoEsSTR").val('mongrelsc');
						// descuentoEnEuros=9;
						// totalProductos=<?php echo number_format($total,2); ?>;
						// if(totalProductos > 39 ){
							// var porciento=descuentoEnEuros / totalProductos;
							// $("#hola2").html("0");
							// $("#hola").html("0");
							// $(".tipoDescuento").val(porciento);
							// $('#descuectoAsignar1').val(porciento);
							// document.forms["onlus"].submit();
							
						// }
				}
				
				if (CODIGO.toLowerCase()=="cane1s" || CODIGO.toLowerCase() =="gatto1s" ){
						$(".queTipoEsSTR").val('cane1s');
						descuentoEnEuros=10;
						totalProductos=<?php echo number_format($total,2); ?>;
						if(totalProductos > 29 ){
							var porciento=descuentoEnEuros / totalProductos;
							$("#hola2").html("0");
							$("#hola").html("0");
							$(".tipoDescuento").val(porciento);
							$('#descuectoAsignar1').val(porciento);
							document.forms["onlus"].submit();
							//console.log("Cane1s");
						}
						
				}	
				

		}


					
	}
				
				
			</script>
				</body>
	</html>
<?php 

	function validateIfISPromo($idPromo,$idCompra,$comprasVector){
		include 'enoc.php';
		$str='';
		if($idPromo==1){
			$queryPromo1=mysql_query("SELECT * FROM promocion_a_free_b where id_b=$idCompra") or die( mysql_error() );
			$fetch1=mysql_fetch_array($queryPromo1);
			$idA=$fetch1['id_a'];
				if($idA){
					$isPromo=false;
					for($j=0;$j<=count($comprasVector)-1;$j++){
						if($comprasVector[$j]!=NULL){
							$currentProduct= $comprasVector[$j]['product_id'];
							if($idA==$currentProduct){
								$isPromo=true;
							}
						}
					}
					if($isPromo){
						
						$str= 'Prezzo Confezione 
				<div style="position:relative;float:left;">
					<img src="images/promo.png" width="100"/>
					<label style="position:absolute;left:25px;top:43px;font-size:28px;color:white;font-weight:bolder;">FREE</label>
				</div>';			
					}
					
			}else{
				//echo "No promo1";	
			}
			
		}else{
			if($idPromo==2){

			$queryPromo2=mysql_query("SELECT * FROM promocion_a_porcent_b where id_b=$idCompra") or die( mysql_error() );
			$fetch2=mysql_fetch_array($queryPromo2);
			$idA=$fetch2['id_a'];
			$porcent=$fetch2['porcent'];
				if($idA){

					$isPromo=false;
					for($j=0;$j<=count($comprasVector)-1;$j++){
						if($comprasVector[$j]!=NULL){
							$currentProduct= $comprasVector[$j]['product_id'];
							if($idA==$currentProduct){
								$isPromo=true;
							}
						}
					}

					if($isPromo){
						$str= $porcent.'|Prezzo Confezione 
				<div style="position:relative;float:left;">
					<img src="images/promo.png" width="100"/>
					<label style="position:absolute;left:25px;top:43px;font-size:28px;color:white;font-weight:bolder;">'.$porcent.'%</label>
				</div>';			
					}else{
						
					}
			}
			/*$str= 'Prezzo Confezione 
			<div style="position:relative;float:left;">
				<img src="images/promo.png" width="100"/>
				<label style="position:absolute;left:30px;top:43px;font-size:28px;color:white;font-weight:bolder;">'.$idCompra.'</label>
			</div>
			';		*/
		}
	}
	return $str;
	}

?>
<?php $_SESSION['carrito']=$compras; ?>