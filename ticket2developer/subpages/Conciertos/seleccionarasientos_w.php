<?php 
	require_once('../../classes/private.db.php');
	 
	$gbd = new DBConn();
	
	$id_localidad = $_POST['local'];
	$id_concierto = $_POST['concierto'];
	$rows = $_POST['row'];
	$col = $_POST['col'];
	$hoy = date("Y-m-d");
	
	
	if(is_numeric($rows)) {
        //echo "'{$rows}' es numérico", PHP_EOL;
		$columns = $rows;
    } else {
        //echo "'{$rows}' NO es numérico", PHP_EOL;
		if($rows == 'A'){
			$columns = 1;
		}
		if($rows == 'B'){
			$columns = 2;
		}
		if($rows == 'C'){
			$columns = 3;
		}
		if($rows == 'D'){
			$columns = 4;
		}
		if($rows == 'E'){
			$columns = 5;
		}
		if($rows == 'F'){
			$columns = 6;
		}
		if($rows == 'G'){
			$columns = 7;
		}
		if($rows == 'H'){
			$columns = 8;
		}
		if($rows == 'I'){
			$columns = 9;
		}
		if($rows == 'J'){
			$columns = 10;
		}
		if($rows == 'K'){
			$columns = 11;
		}
		if($rows == 'L'){
			$columns = 12;
		}
		if($rows == 'M'){
			$columns = 13;
		}
		if($rows == 'N'){
			$columns = 14;
		}
		if($rows == 'O'){
			$columns = 15;
		}
		if($rows == 'P'){
			$columns = 16;
		}
		if($rows == 'Q'){
			$columns = 17;
		}
		if($rows == 'R'){
			$columns = 18;
		}
		if($rows == 'S'){
			$columns = 19;
		}
		if($rows == 'T'){
			$columns = 20;
		}
		if($rows == 'U'){
			$columns = 21;
		}
		if($rows == 'V'){
			$columns = 22;
		}
		if($rows == 'W'){
			$columns = 23;
		}
		if($rows == 'X'){
			$columns = 24;
		}
		if($rows == 'Y'){
			$columns = 25;
		}
		if($rows == 'Z'){
			$columns = 26;
		}
		
		
		if($rows == 'AA'){
			$columns = 27;
		}
		if($rows == 'AB'){
			$columns = 28;
		}
		if($rows == 'AC'){
			$columns = 29;
		}
		if($rows == 'AD'){
			$columns = 30;
		}
		if($rows == 'AE'){
			$columns = 31;
		}
		if($rows == 'AF'){
			$columns = 32;
		}
		if($rows == 'AG'){
			$columns = 33;
		}
		if($rows == 'AH'){
			$columns = 34;
		}
		if($rows == 'AI'){
			$columns = 35;
		}
		if($rows == 'AJ'){
			$columns = 36;
		}
		if($rows == 'AK'){
			$columns = 37;
		}
		if($rows == 'AL'){
			$columns = 38;
		}
		if($rows == 'AM'){
			$columns = 39;
		}
		if($rows == 'AN'){
			$columns = 40;
		}
		if($rows == 'AO'){
			$columns = 41;
		}
		if($rows == 'AP'){
			$columns = 42;
		}
		if($rows == 'AQ'){
			$columns = 43;
		}
		if($rows == 'AR'){
			$columns = 44;
		}
		if($rows == 'AS'){
			$columns = 45;
		}
		if($rows == 'AT'){
			$columns = 46;
		}
		if($rows == 'AU'){
			$columns = 47;
		}
		if($rows == 'AV'){
			$columns = 48;
		}
		if($rows == 'AW'){
			$columns = 49;
		}
		if($rows == 'AX'){
			$columns = 50;
		}
		if($rows == 'AY'){
			$columns = 51;
		}
		if($rows == 'AZ'){
			$columns = 52;
		}
		
		
		
		
		if($rows == 'BA'){
			$columns = 53;
		}
		if($rows == 'BB'){
			$columns = 54;
		}
		if($rows == 'BC'){
			$columns = 55;
		}
		if($rows == 'BD'){
			$columns = 56;
		}
		if($rows == 'BE'){
			$columns = 57;
		}
		if($rows == 'BF'){
			$columns = 58;
		}
		if($rows == 'BG'){
			$columns = 59;
		}
		if($rows == 'BH'){
			$columns = 60;
		}
		if($rows == 'BI'){
			$columns = 61;
		}
		if($rows == 'BJ'){
			$columns = 62;
		}
		if($rows == 'BK'){
			$columns = 63;
		}
		if($rows == 'BL'){
			$columns = 64;
		}
		if($rows == 'BM'){
			$columns = 65;
		}
		if($rows == 'BN'){
			$columns = 66;
		}
		if($rows == 'BO'){
			$columns = 67;
		}
		if($rows == 'BP'){
			$columns = 68;
		}
		if($rows == 'BQ'){
			$columns = 69;
		}
		if($rows == 'BR'){
			$columns = 70;
		}
		if($rows == 'BS'){
			$columns = 71;
		}
		if($rows == 'BT'){
			$columns = 72;
		}
		if($rows == 'BU'){
			$columns = 73;
		}
		if($rows == 'BV'){
			$columns = 74;
		}
		if($rows == 'BW'){
			$columns = 75;
		}
		if($rows == 'BX'){
			$columns = 76;
		}
		if($rows == 'BY'){
			$columns = 77;
		}
		if($rows == 'BZ'){
			$columns = 78;
		}
		
		
		if($rows == 'CA'){
			$columns = 79;
		}
		
		if($rows == 'CB'){
			$columns = 80;
		}
		
    }
	
	
	$selectPreventa = "SELECT doublePrecioPreventa FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto 
			WHERE dateFechaPreventa >= ? AND idLocalidad = ? AND idConc = ?";
	$resPreventa = $gbd -> prepare($selectPreventa);
	$resPreventa -> execute(array($hoy,$id_localidad,$id_concierto));
	$rowPreventa = $resPreventa -> fetch(PDO::FETCH_ASSOC);
	$resultadoPreventa = $resPreventa -> rowCount();
	
	$selectAsiento = "SELECT idLocalidad, strDescripcionL, doublePrecioL, strSecuencial FROM Localidad JOIN Butaca ON Localidad.idLocalidad = Butaca.intLocalB WHERE idLocalidad = ? AND idConc = ?";
	$resultSelectAsiento = $gbd -> prepare($selectAsiento);
	$resultSelectAsiento -> execute(array($id_localidad,$id_concierto));
	$row = $resultSelectAsiento -> fetch(PDO::FETCH_ASSOC);
	
	echo '<tr id="new_selection_'.$rows.'_'.$col.'_'.$id_localidad.'" class="file_checked-'.$id_localidad.' asientosescogidos">
		<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="codigo[]" class="added" value="'.$row['idLocalidad'].'" readonly="readonly" size="5" /></font></center><input type="hidden" name="row[]" class="added" value="'.$rows.'" /><input type="hidden" name="col[]" class="added" value="'.$col.'" /></td>';
		if($row['strSecuencial'] == 0){
			echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-'.$rows.'_Silla-'.$col.'" readonly="readonly" size="15" /></font></center></td>';
		}else if($row['strSecuencial'] == 1){
			
			
			if($columns == 1){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-A_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 2){
				echo '<td style="text_align:center;border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-B_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 3){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-C_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 4){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-D_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 5){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-E_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 6){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-F_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 7){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-G_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 8){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-H_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 9){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-I_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 10){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-J_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 11){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-K_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 12){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-L_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 13){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-M_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 14){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-N_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 15){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-O_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 16){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-P_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 17){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-Q_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 18){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-R_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 19){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-S_Silla-'.$col.'" readonly="readonly" size="10" /><</font></center>/td>';
			}
			if($columns == 20){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-T_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 21){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-U_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 22){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-V_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 23){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-W_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 24){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-X_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			if($columns == 25){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-Y_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
		
			if($columns == 26){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-Z_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 27){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AA_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 28){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AB_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 29){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AC_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 30){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AD_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			
			if($columns == 31){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AE_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 32){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AF_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 33){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AG_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 34){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AH_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 35){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AI_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 36){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AJ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 37){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AK_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 38){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AL_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 39){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AM_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 40){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AN_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 41){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AO_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 42){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AP_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 43){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AQ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 44){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AR_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 45){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AS_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 46){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AT_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 47){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AU_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 48){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AV_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 49){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AW_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 50){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AX_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 51){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AY_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 52){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-AZ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 53){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BA_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 54){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BB_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 55){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BC_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 56){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BD_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			
			if($columns == 57){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BE_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 58){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BF_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 59){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BG_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 60){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BH_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 61){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BI_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 62){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BJ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 63){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BK_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 64){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BL_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 65){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BM_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 66){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BN_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 67){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BO_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 68){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BP_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 69){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BQ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 70){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BR_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 71){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BS_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 72){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BT_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 73){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BU_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 74){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BV_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 75){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BW_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 76){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BX_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 77){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BY_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 78){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-BZ_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 79){
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-CA_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
			
			if($columns == 80){ 
				echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="chair[]" class="added" value="Fila-CB_Silla-'.$col.'" readonly="readonly" size="10" /></font></center></td>';
			}
		}
		
	echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="des[]" class="added" value="'.$row['strDescripcionL'].'" readonly="readonly" size="10" /></font></center></td>
			<td style="text_align:center; border:none;">
				<center><font color="#000"><input type="text" name="num[]" class="added" value="1" readonly="readonly" size="10" /></font></center>
				<input type="hidden" name="id_desc[]" value="0" readonly="readonly" style = "color:#000;" />
				<input type="hidden" name="val_desc[]" value="'.$row['doublePrecioL'].'" readonly="readonly" style = "color:#000;"/>
			</td>';
		if($resultadoPreventa > 0){
			echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="pre[]" class="added" value="'.$rowPreventa['doublePrecioPreventa'].'" readonly="readonly" size="10" /></font></center></td>
				<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="tot[]" class="added" value="'.$rowPreventa['doublePrecioPreventa'].'" readonly="readonly" size="10" /></font></center></td>';
		}else{
			echo '<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="pre[]" class="added" value="'.$row['doublePrecioL'].'" readonly="readonly" size="10" /></font></center></td>
				<td style="text_align:center; border:none;"><center><font color="#000"><input type="text" name="tot[]" class="added" value="'.$row['doublePrecioL'].'" readonly="readonly" size="10" /></font></center></td>';
		}
	echo '<td style="text-align:center; border:none;"><center><font color="#000"><button type="button" class="btn_eliminar" id="delete'.$id_localidad.'" onclick="elimanarsillas('.$id_localidad.','.$id_concierto.','.$rows.','.$col.')">Eliminar</button></font></center></td>
	</tr>';
?>