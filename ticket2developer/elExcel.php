 <?php   
include 'cone.php';
$fila = 0;
if(($gestor = fopen("clientesNuevos.csv", "r")) !== FALSE){
    while(($datos = fgetcsv($gestor, 1000, ";")) !== FALSE){
		if($fila != 0){
			$query = "	INSERT INTO `usuarios` (
												`nom1_usu`, 
												`ape1_usu`, 
												`ced_usu`, 
												`lin_usu`, 
												`cod_usu`
												)
						VALUES ('{$datos[0]}','{$datos[1]}','{$datos[2]}','{$datos[3]}','{$datos[4]}')";
			mysql_query($query) or die(mysql_error());
			
			
			
			echo'cliente '.$fila.' Ingresado en la base Correctamente <br/>';
			
			
			}
		$fila++;
		}
    fclose($gestor);
	//echo '</br>datos guardados correctamente';
	}
  ?>