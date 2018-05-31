<?php
session_start();
include '../../dbconn.php';
$digits=time();
$uploaddir = 'docs/';
$uploadfile = $uploaddir.$digits;
$uploadfile2 = $digits.basename($_FILES['uploadfile']['name']);
$uploadfile = $uploaddir.$uploadfile2;
$arrayproductos=array();
$filas='';
//$uploadfilesolo = basename($_FILES['uploadfile']['name']);
// Lo mueve a la carpeta elegida
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
	/** Se agrega la libreria PHPExcel */
		require_once 'Classes/PHPExcel.php';
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load("docs/".$uploadfile2);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow(); 
		$highestColumn = $objWorksheet->getHighestColumn(); 
		//$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		$highestColumnIndex=2;
		//echo '<table>' . "\n";
		$totalerroneas='';
		//leyendo archivo excel
		for($row = 3; $row <= $highestRow; ++$row){
		  //echo '<tr>'."\n";
		  $lineaserroneas='';
		  $datospr=array();
		  $codigo=$objWorksheet->getCellByColumnAndRow(0,$row)->getValue();
		  if($codigo!=''){
				for($col = 0; $col <= $highestColumnIndex; ++$col){
					$valor=$objWorksheet->getCellByColumnAndRow($col,$row)->getValue();
					if($valor!=''){
						if($col==0)
							$datospr[$col]=$valor;
						else if($col>0&&(float)$valor>0){
								$valor=str_replace(",",".",$valor);
								$datospr[$col]=$valor;
						}
						else
						$lineaserroneas.=$row.',';
					}
					else if($valor=='')
						$lineaserroneas.=$row.',';
				}
				if($lineaserroneas==''){
					$arrayproductos[]=$datospr;
				}else $totalerroneas.=$lineaserroneas;
					
		  }
		  //echo '</tr>' . "\n";
		}
		//echo '</table>' . "\n";
		//sacando lineas erroneas
		$vectorerroneas=explode(',',$totalerroneas);
		$vectorerroneas=array_values(array_unique($vectorerroneas));
		$lineasmalas=implode(',',$vectorerroneas);
		
		
		//sacando datos de la base
		$iter=1;
		foreach($arrayproductos as $carac){
			$queryid=pg_query("select f.id as idf,c.empaque as emp,f.formulado as nombre,c.conversion as conv,c.id as idconv,f.ivacomprareal as iva from formulados as f, formulados_conversion as c where f.id=c.idformulado and c.codigo='$carac[0]'")or die(pg_last_error());
			if($datosobt=pg_fetch_array($queryid)){
				$clase='impar';
				if($iter%2==0)
					$clase='par';
			  $filas.="<tr id='".$iter."' class='$clase'>
			  <td align='center' width='135px'>
			  <span id='n".$iter."' style='display: none;'>1</span>
			  <input id='cod".$iter."t' name='cod".$iter."t' type='text' value='".$carac[0]."'
			  onclick='verbusquedacodigo(".'"'.$iter.'t"'.");' onkeyup='busquedadirecta(".'"'.$carac[0].'t"'.",event);'
			  style='width: 120px;height: 18px;outline: none;border: 0px;text-align: center;background-color: transparent;'>
			  </td>
			  <td width='445px'>
			  <input id='search-renderitem".$iter."t' name='search-renderitem".$iter."t' type='text' onclick='verbusqueda(".'"'.$iter.'t"'.");'
			  value='".$datosobt['nombre']."' style='width:440px;height:18px;outline:none;border:0px;background-color:transparent;'>
			  <input id='idp".$iter."t' name='idp".$iter."t' type='hidden' value='".$datosobt['idf']."'><br>
			  </td>
			  <td align='center' width='100'><span id='u".$iter."t'>".$datosobt['emp']."</span></td>
			  <td align='right' width='80'>
			  <input id='c".$iter."t' name='c".$iter."t' value='".number_format($carac[1],2,'.','')."' type='text' onkeyup='calculacosto2(".'"'.$iter.'t"'.");' onkeypress='return soloNumerost2(event,".'"c'.$iter.'t"'.")' style='width: 60px;height: 18px;outline: none;border: 0px;text-align: right; background-color:transparent;' maxlength='6'>
			  <div id='conv".$iter."t' style='display: none;'>".$datosobt['idconv'].'|'.$datosobt['conv']."</div>
			  </td>
			  <td align='right' width='80' style='overflow: hidden;'>
			  <div id='co".$iter."t' style='width: 66px;overflow: hidden;margin-top: 2px;'>".number_format(($carac[2]/$carac[1]),3,'.','')."</div>
			  <div id='cos".$iter."t' style='display: none;'>".number_format(($carac[2]/$carac[1]),3,'.','')."</div></td>
			  <td align='right' width='80'>
			  <input id='to".$iter."t' name='to".$iter."t' value='".number_format($carac[2],2,'.','')."' type='text' onkeyup='calculacosto2(".'"'.$iter.'t"'.");' onkeypress='return soloNumerost2(event,".'"to'.$iter.'t"'.")' style='width: 60px;height: 18px;outline: none;border: 0px;text-align: right;background-color:transparent;' maxlength='15'>
			  </td>
			  <td align='center' width='38'><span id='tiva".$iter."t' style='display: none;'>".$datosobt['iva']."</span></td>
			  </tr>";
				$iter++;
			}
		}
		echo '<table>'.$filas.'</table>└'.$lineasmalas;
}
else {echo "error";}
?>