<?php
	session_start();
	include '../../enoc.php';
	$sql = 'select * from cooperativa where id_usu = "'.$_SESSION['iduser'].'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$id_coop = $row['id'];
	$bus_cooperativa = $_REQUEST['bus_cooperativa'];
	
	$servicesFormatted = $_REQUEST['servicesFormatted'];
	//echo $servicesFormatted."<br><br>";
	$serv = explode("|",$servicesFormatted);
	//$servi = arsort($serv);
	
	//print_r($serv)."<br><br>";
	
	
	$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
	$rand = md5($s.time()).mt_rand(1,10);
	
	
	$id_ruta_aux = $_SESSION['iduser']."_".$bus_cooperativa."-".$rand;
	for($i=0;$i<=count($serv);$i++){
		$serv1 = explode("@",$serv[$i]);
		//print_r($serv1)."<br>";
		
			$verificador = $serv1[0];
			$ciudad_salida = $serv1[1];
			$ciudad_destino = $serv1[2];
			$terminal_salida = $serv1[3];
			$terminal_destino = $serv1[4];
			$hora_salida = $serv1[5];
			$hora_destino = $serv1[6];
			$fecha_salida = $serv1[7];
			$fecha_destino = $serv1[8];
			$precios = $serv1[9];
			if($verificador != ''){
			//	echo $verificador."<br>";
				if($verificador == 1){
					$sql = 'INSERT INTO `ruta` (`id`, `origen`, `destino`, `id_ter`, `coop`, `fecha`, `hora`, `hora_llega`, `precio`, `id_bus`) 
					VALUES (NULL, "'.$ciudad_salida.'", "'.$ciudad_destino.'", "'.$terminal_salida.'", "'.$id_coop.'", "'.$fecha_salida.'", "'.$hora_salida.'", "'.$hora_destino.'", "'.$precios.'", "'.$bus_cooperativa.'")';
					$res = mysql_query($sql) or die (mysql_error());
					$id_ruta = mysql_insert_id();
				}
				
				elseif($verificador == 0){
					$sql1 = 'INSERT INTO `escalas` (`id`, `id_ruta`, `id_ter`, `id_cop`, `id_ciu_sal`, `id_ciu_lleg`, `fecha`, `hora`, `precio`) 
							VALUES (NULL, "'.$id_ruta_aux.'", "'.$terminal_salida.'", "'.$id_coop.'", "'.$ciudad_salida.'", "'.$ciudad_destino.'", "'.$fecha_salida.'", "'.$hora_salida.'", "'.$precios.'")';
					$res1 = mysql_query($sql1) or die (mysql_error());
				}
				
				//echo $sql."<br>";
			}
	}
	$sqlU = 'update escalas set id_ruta = "'.$id_ruta.'" where id_ruta = "'.$id_ruta_aux.'" ';
	$resU = mysql_query($sqlU) or die (mysql_error());
	
	if($res && $res1){
		echo 'Ruta N° : '.$id_ruta.' creada con éxito';
	}else{
		echo 'error';
	}
?>