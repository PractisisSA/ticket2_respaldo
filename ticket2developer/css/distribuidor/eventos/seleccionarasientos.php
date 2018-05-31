<?php 
	require('../../Conexion/conexion.php');
	$id_localidad = $_POST['local'];
	$id_concierto = $_POST['concierto'];
	$rows = $_POST['row'];
	$col = $_POST['col'];
	
	$selectPreventa = "SELECT doublePrecioPreventa FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto 
			WHERE dateFechaPreventa >= CURRENT_DATE AND idLocalidad = '$id_localidad' AND idConc = '$id_concierto' ORDER BY dateFecha ASC" or die(mysqli_error($mysqli));
	$resPreventa = $mysqli->query($selectPreventa);
	$rowPreventa = mysqli_fetch_array($resPreventa);
	$resultadoPreventa = mysqli_num_rows($resPreventa);
	
	$selectAsiento = "SELECT idLocalidad, strDescripcionL, doublePrecioL, strSecuencial FROM Localidad JOIN Butaca ON Localidad.idLocalidad = Butaca.intLocalB WHERE idLocalidad = '$id_localidad' AND idConc = '$id_concierto'" or die(mysqli_error($mysqli));
	$resultSelectAsiento = $mysqli->query($selectAsiento);
	$row = mysqli_fetch_array($resultSelectAsiento);
	echo '<tr id="new_selection_'.$rows.'_'.$col.'_'.$id_localidad.'" class="file_checked-'.$id_localidad.' asientosok">
		<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="codigo[]" class="added" value="'.$row['idLocalidad'].'" readonly="readonly" size="5" /></font></center><input type="hidden" name="row[]" class="added" value="'.$rows.'" /><input type="hidden" name="col[]" class="added" value="'.$col.'" /></td>';
		if($row['strSecuencial'] == 0){
			echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-'.$rows.'_Silla-'.$col.'" readonly="readonly" size="15" /></font></center></td>';
		}else if($row['strSecuencial'] == 1){
			if($rows == 1){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-A_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 2){
				echo '<td style="text_align:center;border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-B_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 3){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-C_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 4){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-D_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 5){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-E_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 6){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-F_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 7){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-G_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 8){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-H_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 9){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-I_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 10){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-J_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 11){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-K_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 12){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-L_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 13){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-M_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 14){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-N_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 15){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-O_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 16){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-P_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 17){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-Q_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 18){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-R_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 19){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-S_Silla-'.$col.'" readonly="readonly" size="10" /><</font></center>/td>';
			}
			if($rows == 20){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-T_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 21){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-U_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 22){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-V_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 23){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-W_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 24){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-X_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 25){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-Y_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
		}
		
	echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="des[]" class="added" value="'.$row['strDescripcionL'].'" readonly="readonly" size="10" /></font></center></td>
		<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="num[]" class="added" value="1" readonly="readonly" size="10" /></font></center></td>';
		if($resultadoPreventa > 0){
			echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="pre[]" class="added" value="'.$rowPreventa['doublePrecioPreventa'].'" readonly="readonly" size="10" /></font></center></td>
				<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="tot[]" class="added" value="'.$rowPreventa['doublePrecioPreventa'].'" readonly="readonly" size="10" /></font></center></td>';
		}else{
			echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="pre[]" class="added" value="'.$row['doublePrecioL'].'" readonly="readonly" size="10" /></font></center></td>
				<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="tot[]" class="added" value="'.$row['doublePrecioL'].'" readonly="readonly" size="10" /></font></center></td>';
		}
	echo '<td style="text-align:center; border:none;"><center><font color="#000"><button type="button" class="btn_eliminar" id="delete'.$id_localidad.'" onclick="elimanarsillas('.$id_localidad.','.$id_concierto.','.$rows.','.$col.')"><strong>-</strong></button></font></center></td>
	</tr>';
?>