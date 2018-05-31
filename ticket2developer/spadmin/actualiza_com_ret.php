<?php
	include 'conexion.php';
	$id = $_REQUEST['id'];
	$valores_comi = $_REQUEST['valores_comi'];
	$conciertoID = $_REQUEST['conciertoID']; 
	if($id == 1){
		foreach(explode('|',$valores_comi) as $valores){
			if($valores!=''){
				$cadaValor = explode('@',$valores);
				$id_comi_tar = $cadaValor[0];
				$comi_tar = $cadaValor[1];
				$ret_iva = $cadaValor[2];
				$ret_renta = $cadaValor[3];
				$des_ter_edad = $cadaValor[4];
				$comi_venta = $cadaValor[5];
				$comi_cobro = $cadaValor[6];
				$sql = 'update comi_ret set comi_tar = "'.$comi_tar.'" ,
											ret_iva = "'.$ret_iva.'" , 
											ret_renta = "'.$ret_renta.'" , 
											des_ter_edad = "'.$des_ter_edad.'" , 
											comi_venta = "'.$comi_venta.'" , 
											comi_cobro = "'.$comi_cobro.'"
											where id = "'.$id_comi_tar.'" 
											';
				//echo $sql."<br/>";
				$res = mysql_query($sql) or die (mysql_error());
				
			}
			
		}
	}else{
		foreach(explode('|',$valores_comi) as $valores){
			if($valores!=''){
				$cadaValor = explode('@',$valores);
				$id_comi_tar = $cadaValor[0];
				if($id_comi_tar == 0){
					$txtComTar = 'cadena comercial';
				}
				if($id_comi_tar == 1){
					$txtComTar = 'PUNTOS TICKET FACIL';
				}
				if($id_comi_tar == 2){
					$txtComTar = 'PAGINA WEB';
				}
				$comi_tar = $cadaValor[1];
				$ret_iva = $cadaValor[2];
				$ret_renta = $cadaValor[3];
				$des_ter_edad = $cadaValor[4];
				$comi_venta = $cadaValor[5];
				$comi_cobro = $cadaValor[6];
				$sql = 'INSERT INTO `comi_ret` (`id`, `id_con`, `detalle`, `comi_tar`, `ret_iva`, `ret_renta`, `des_ter_edad`, `comi_venta`, `comi_cobro`) 
						VALUES (NULL, "'.$conciertoID.'", "'.$txtComTar.'", "'.$comi_tar.'", "'.$ret_iva.'", "'.$ret_renta.'", "'.$des_ter_edad.'", "'.$comi_venta.'", "'.$comi_cobro.'")';
				//echo $sql."<br/>";
				$res = mysql_query($sql) or die (mysql_error());
				
			}
			
		}
	}
?>