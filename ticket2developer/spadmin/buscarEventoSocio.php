<?php
	include '../conexion.php';
	$cboEmpresarios = $_REQUEST['cboEmpresarios'];
	$sqlC = '	SELECT c.* 
				FROM Concierto as c , desgl_docu as dd
				WHERE c.dateFecha > "2017-10-10" 
				and c.idUser = "'.$cboEmpresarios.'" 
				and c.costoenvioC > 0 
				and c.tiene_permisos > 0 
				and dd.id_con = c.idConcierto
				and dd.municipio = 1
				order by c.idConcierto DESC';
	echo $sqlC;
	$resC = mysql_query($sqlC) or die (mysql_error());
?>
		<option value = ''>Seleccione Evento...</option>
<?php
	while($rowC = mysql_fetch_array($resC)){
		$sql1 = 'select count(id) as cuantos from desgl_docu where id_con = "'.$rowC['idConcierto'].'" and municipio = 1';
		echo $sql1;
		$res1 = mysql_query($sql1) or die (mysql_error());
		$row1 = mysql_fetch_array($res1);
		if($row1['cuantos'] == 0){
			$display = '';
		}else{
			$display = '';
		}
?>
		<option style = "<?php echo $display;?>" value = '<?php echo $rowC['idConcierto'];?>'><?php echo $rowC['strEvento'];?>  [<?php echo $rowC['idConcierto'];?>]</option>
<?php
	}
		
?>