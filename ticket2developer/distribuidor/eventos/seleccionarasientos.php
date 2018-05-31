<?php 
	session_start();
	require('../../Conexion/conexion.php');
	$id_localidad = $_REQUEST['local'];
	$id_concierto = $_REQUEST['concierto'];
	$rows = $_REQUEST['row'];
	$col = $_REQUEST['col'];
	
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
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-A_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 2){
				echo '<td style="text_align:center;border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-B_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 3){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-C_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 4){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-D_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 5){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-E_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 6){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-F_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 7){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-G_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 8){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-H_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 9){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-I_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 10){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-J_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 11){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-K_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 12){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-L_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 13){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-M_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 14){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-N_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 15){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-O_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 16){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-P_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 17){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-Q_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 18){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-R_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 19){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-S_Silla-'.$col.'" readonly="readonly" size="10" /><</font></center>/td>';
			}
			if($rows == 20){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-T_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 21){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-U_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 22){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-V_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 23){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-W_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 24){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-X_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($rows == 25){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-Y_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
		
			if($rows == 26){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-Z_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 27){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AA_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 28){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AB_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 29){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AC_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 30){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AD_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			
			if($rows == 31){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AE_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 32){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AF_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 33){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AG_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 34){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AH_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 35){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AI_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 36){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AJ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 37){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AK_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 38){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AL_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 39){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AM_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 40){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AN_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 41){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AO_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 42){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AP_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 43){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AQ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 44){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AR_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 45){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AS_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 46){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AT_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 47){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AU_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 48){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AV_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 49){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AW_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 50){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AX_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 51){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AY_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 52){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-AZ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 53){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BA_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 54){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BB_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 55){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BC_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 56){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BD_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			
			if($rows == 57){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BE_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 58){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BF_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 59){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BG_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 60){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BH_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 61){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BI_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 62){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BJ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 63){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BK_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 64){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BL_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 65){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BM_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 66){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BN_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 67){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BO_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 68){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BP_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 69){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BQ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 70){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BR_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 71){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BS_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 72){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BT_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 73){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BU_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 74){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BV_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 75){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BW_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 76){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BX_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 77){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BY_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 78){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-BZ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 79){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-CA_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($rows == 80){ 
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Silla-CB_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
		}
		
	echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="des[]" class="added" value="'.$row['strDescripcionL'].'" readonly="readonly" size="10" /></font></center></td>
		<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="num[]" class="added" value="1" readonly="readonly" size="10" /></font></center></td>';
		if($resultadoPreventa > 0){
			$pre = $rowPreventa['doublePrecioPreventa'];
			$tot = $rowPreventa['doublePrecioPreventa'];
			echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="pre[]" class="added" value="'.$rowPreventa['doublePrecioPreventa'].'" readonly="readonly" size="10" /></font></center></td>
				<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="tot[]" class="added" value="'.$rowPreventa['doublePrecioPreventa'].'" readonly="readonly" size="10" /></font></center></td>';
		}else{
			$pre = $row['doublePrecioL'];
			$tot = $row['doublePrecioL'];
			echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="pre[]" class="added" value="'.$row['doublePrecioL'].'" readonly="readonly" size="10" /></font></center></td>
				<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="tot[]" class="added" value="'.$row['doublePrecioL'].'" readonly="readonly" size="10" /></font></center></td>';
		}
	echo '<td style="text-align:center; border:none;"><center><font color="#000"><button type="button" class="btn_eliminar" id="delete'.$id_localidad.'" onclick="elimanarsillas('.$id_localidad.','.$id_concierto.','.$rows.','.$col.')"><strong>-</strong></button></font></center></td>
	</tr>';
	
	$codigo = $id_localidad;
	$roww = $rows;
	$coll = $col;
	$chair = 'Fila-'.$rows.'_Silla-'.$col.'';
	$des = $row['strDescripcionL'];
	$cantidad = 1;
				
	if ( isset($_SESSION['carrito']) || isset($_REQUEST['local'])){
		if(isset ($_SESSION['carrito'])){
			
				
					$compras=$_SESSION['carrito'];
					if(isset($_REQUEST['local'])){
						$compras[]=array(
										"local"=>$codigo,
										"precio"=>$pre,
										"cantidad"=>$cantidad,
										"roww"=>$roww,
										"coll"=>$coll,
										"chair"=>$chair,
										"des"=>$des,
										"concierto"=>$id_concierto,
										"total"=>$tot
									);
					}

				
			
			
		}else{
				
				$compras[]=array(
									"local"=>$codigo,
									"precio"=>$pre,
									"cantidad"=>$cantidad,
									"roww"=>$roww,
									"coll"=>$coll,
									"chair"=>$chair,
									"des"=>$des,
									"concierto"=>$id_concierto,
									"total"=>$tot
								);
			// }
			

		}
		
		
		$_SESSION['carrito']=$compras;
		$_SESSION['$cuantoscarrito']=$cuantoscarrito;//asigna contador
		$carro = count($_SESSION['carrito']);
		//echo count($carro);

		//print_r($_SESSION['carrito']);
	}
	
	echo json_encode($_SESSION['carrito']);
?>