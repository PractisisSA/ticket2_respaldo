<?php
	echo '<input type="hidden" id="data" value="54" />';
		date_default_timezone_set('America/Guayaquil');
		require_once 'classes/private.db.php';
		include 'conexion.php';
		$gbd = new DBConn();
		
		$select = "	SELECT rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, facnegociablesA, 
					tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA 
					FROM autorizaciones";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "select * from Concierto where costoenvioC > 0";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
			?>
			<center>
				<button type="button" class="btn btn-default" onclick="tableToExcel('desglose', 'REPORTE SRI ')">EXCEL</button>
			</center>
			
			<?php
				// echo "<h2 style = 'padding:0px;margin:0px;'>".$_SESSION['iduser']."  <<>>  ".$_SESSION['perfil']."</h2>";
			echo '<div class="table-responsive" id = "desglose">';
				echo '<table class = "table" style = "color:#000;background-color:#fff;"> 
						<tr style="color:#00ADEF;font-size:12px;">
							<td>
								<strong>N°</strong>
							</td>
							<td style = "font-size:12px;">
								<strong>R.U.C.</strong><br>
								<strong>Tipo Doc.</strong>
							</td>
							<td style = "font-size:10px;">
								<strong>Nombre Comercial</strong>
							</td>
							<td style = "font-size:12px;">
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td style = "font-size:12px;">
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							
							<td style = "font-size:12px;">
								<strong>Secuencial<br>Inicial - Final1</strong>
							</td>
							<!--<td>
								<strong>Secuencial<br>Inicial - Impresa</strong>
							</td>-->
							<td style = "font-size:12px;">
								<strong>Ultima Factura Impresa</strong>
							</td>
							<td style = "font-size:12px;">
								<strong>#Ingresados</strong>
							</td>
							
							<td style = "font-size:10px;">
								<strong>Nombre / N° / Fecha Evento</strong>
							</td>
							
							<td style = "font-size:12px;">
								<strong>Estado</strong>
							</td>
							<td style = "font-size:12px;">
								<strong>N° Vendidas</strong>
							</td>
							<td style = "font-size:12px;">
								<strong>Foto</strong>
							</td>
						</tr>';
				$i = 1;
				
				while($row2 = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					$sql2 = 'SELECT * FROM autorizaciones where autorizaciones.idAutorizacion = "'.$row2['tiene_permisos'].'"';
					$res2 = mysql_query($sql2) or die (mysql_error());
					$row = mysql_fetch_array($res2);
					
					$sql1 = 'select * from Concierto where idConcierto = "'.$row2['idConcierto'].'" ';
					$res1 = mysql_query($sql1) or die (mysql_error());
					$row1 = mysql_fetch_array($res1);
					
					
					$sql2 = 'select serie as ultima from Boleto where idCon = "'.$row1['idConcierto'].'"  order by idBoleto DESC limit 1';
					$res2 = mysql_query($sql2) or die (mysql_error());
					$row2 = mysql_fetch_array($res2);
					
					
					$sql3 = 'select count(idBoleto) as cuantos from Boleto where idCon = "'.$row1['idConcierto'].'"  and strEstado = "I"';
					$res3 = mysql_query($sql3) or die (mysql_error());
					$row3 = mysql_fetch_array($res3);
					
					
					
					$sqlCe = 'SELECT count(id) as cuantos_ve , cuantos , count(foto) as foto , foto as img FROM `vendidos_x_evento` where idcon = "'.$row1['idConcierto'].'"';
					$resCe = mysql_query($sqlCe) or die (mysql_error());
					$rowCe = mysql_fetch_array($resCe);
					
					if($rowCe['cuantos_ve'] == 0){
						$cantidad = 0;
						$estadoVe = 0;
					}else{
						$cantidad = $rowCe['cuantos'];
						$estadoVe = 1;
					}
					
					if($rowCe['foto'] == 0){
						$color = "color:red;";
						$color2 = "primary";
						$onclick = "onclick = \"subirImg(".$row1['idConcierto'].")\" "; 
						$onclick2 = "onclick = \"grabarLinea(".$row1['idConcierto']." , 1)\" "; 
						$texto2 = 'Grabar';
						$foto = '';
					}else{
						$color = "color:#1fa67a;";
						$foto = $rowCe['img'];
						$onclick = "onclick = \"verImg(".$row1['idConcierto'].")\" "; 
						$onclick2 = "onclick = \"grabarLinea(".$row1['idConcierto']." , 2)\" "; 
						$color2 = "warning";
						$texto2 = 'Actualizar';
					}
					
					if(($row['tipodocumentoA'] == 'Factura') && ($row['facnegociablesA'] == 'si')){
						$nego = 'Negociable';
					}else{
						$nego = '';
					}
					if($row['estadoimpresionA'] == 'impreso' ){
						$clase='btndisabled';
						$texto = 'Impreso';
					}else{
						$clase='btnlink';
						$texto = 'Por Imprimir';
					}
					
					
					
					$onclickRep = "onclick = \"verReporteMuni(".$row1['idConcierto'].")\" "; 
					$onclickRep2 = "onclick = \"verReporteMuni_2(".$row1['idConcierto'].")\" "; 
					
					$autori = $row['nroautorizacionA'];
					$var = '';
					if($autori == ''){
						$var = 'Sin autorizacion';
					}else{
						$var = $row['nroautorizacionA'];
					}

					
					echo '<tr>
							<td style = "border:1px solid #000;font-size:10px;text-align:center;width:100px;">
								['.$i.' -- '.htmlspecialchars($row['idAutorizacion']).']
							</td>
							<td style="text-align:center;border:1px solid #000;font-size:10px;">
								'.htmlspecialchars($row['rucAHIS']).'<br>
								'.htmlspecialchars($row['tipodocumentoA']).' '.$nego.'
							</td>
							<td style = "border:1px solid #000;font-size:8px;">
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td style = "border:1px solid #000;font-size:10px;">
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td style = "border:1px solid #000;font-size:10px;">
								'.$var.'
							</td>
							
							<td style = "border:1px solid #000;font-size:10px;">
								'.$row['secuencialinicialA'].' [-] '.$row['secuencialfinalA'].'
							</td>
							<!--<td></td>-->
							<td style = "border:1px solid #000;font-size:10px;">
								'.$row2['ultima'].'
							</td>
							<td style = "border:1px solid #000;font-size:10px;">
								'.$row3['cuantos'].'
							</td>
							
							<td style = "border:1px solid #000;font-size:10px;">
								<center>'.$row1['strEvento'].'<br>
								['.$row1['idConcierto'].'] / '.$row1['dateFecha'].'</center>
							</td>
							
							<td style = "border:1px solid #000;font-size:10px;">
								'.$texto.'
							</td>
							<td style = "border:1px solid #000;font-size:10px;">
								<input value = "'.$cantidad.'" type = "text" class = "form-control" id = "cuantos_vendidos_'.$row1['idConcierto'].'"/>
								<br><center><i '.$onclickRep.' style = "cursor:pointer;" class="fa fa-folder-open-o fa-2x" title ="ver reporte municipio para : '.$row1['strEvento'].'" aria-hidden="true"></i></center>
								<br><center><i '.$onclickRep2.' style = "cursor:pointer;" class="fa fa-folder-open fa-2x" title ="ver reporte municipio RESUMIDO para : '.$row1['strEvento'].'" aria-hidden="true"></i></center>
							</td>
							<td style = "border:1px solid #000;cursor:pointer;text-align:center;">
								<i class="fa fa-file-image-o fa-2x" style = "'.$color.'" '.$onclick.' aria-hidden="true" id = "upload'.$row1['idConcierto'].'" ></i><br>
								<button type="button" class="btn btn-'.$color2.' btn-xs" '.$onclick2.'>'.$texto2.'</button>
								<input type = "hidden" id = "fotoSubida_'.$row1['idConcierto'].'" value = "'.$foto.'">
								<div style = "font-size:7px;" id = "fotoSubida2_'.$row1['idConcierto'].'" ></div>
							</td>
						</tr>';
					$i++;
				}
				echo '</table>
					</div>';
			}
?>

		<div class="modal fade" id="verFoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<img src="imagenes/ticketfacilnegro.png" width='100px' />
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body" style='text-align:center;' id = 'recibeRespuesta'>
						
					</div>
					<div class="modal-footer">
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade bs-example-modal-lg" id="verRporteMuni" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<img src="imagenes/ticketfacilnegro.png" width='100px' />
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick = "location.reload()" ><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body" style='text-align:center;' id = 'respu'>
						
					</div>
					<div class="modal-footer">
						
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="modal fade bs-example-modal-lg" id="verRporteMuni2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static" style = 'padding-right:0px !important;'>
			<div class="modal-dialog modal-lg" role="document" style = 'width:100%;padding:0px !important;'>
				<div class="modal-content">
					<div class="modal-header">
						<img src="imagenes/ticketfacilnegro.png" width='100px' />
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick = "location.reload()"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body" style='text-align:center;' id = 'respu2'>
						
					</div>
					<div class="modal-footer">
						
					</div>
				</div>
			</div>
		</div>
<script src="js/upload.js"></script>
<script>
	function verReporteMuni(id){
		$('#verRporteMuni').modal('show');
		$('#respu').html('<img src="imagenes/loading.gif" alt="" id="imgif" name="imgif" style="width: 60px;">');
		setTimeout(function(){
			$.post("spadmin/verReporteBordero.php",{ 
					id : id 
			}).done(function(data){
				// alert(data)
				$('#respu').html(data);
				// $('#verFoto').modal('show');
			});
		}, 2000);
	}
	
	function verReporteMuni_2(id){
		$('#verRporteMuni2').modal('show');
		$('#respu2').html('<img src="imagenes/loading.gif" alt="" id="imgif" name="imgif" style="width: 60px;">');
		setTimeout(function(){
			$.post("spadmin/verReporteBorderoMunicipio.php",{ 
					id : id 
			}).done(function(data){
				// alert(data)
				$('#respu2').html(data);
				// $('#verFoto').modal('show');
			});
		}, 2000);
	}
	function verImg(id){
		$.post("spadmin/verImg.php",{ 
				id : id 
		}).done(function(data){
			// alert(data)
			$('#recibeRespuesta').html(data);
			$('#verFoto').modal('show');
		});
	}
	function grabarLinea(id , ident){
		var cuantos_vendidos_ = $('#cuantos_vendidos_'+id).val();
		var fotoSubida_ = $('#fotoSubida_'+id).val();
		if(cuantos_vendidos_ == '' || cuantos_vendidos_ == 0){
			alert('Debe ingresar una cantidad de tickets vendidos mayor a 0')
		}
		
		if(fotoSubida_ == ''){
			alert('Debe subir una foto de respaldo')
		}
		
		if(cuantos_vendidos_ == '' || fotoSubida_ == '' || cuantos_vendidos_ == 0){
			
		}else{
			$.post("spadmin/grabarLinea.php",{ 
				cuantos_vendidos_ : cuantos_vendidos_ , fotoSubida_ : fotoSubida_ , id : id , ident : ident
			}).done(function(data){
				alert(data);
				location.reload();		
			});
		}
	}
	function subirImg(id){
		// alert(id)
		var btnUpload=$('#upload'+id);
		new AjaxUpload(btnUpload, {
			action: 'spadmin/procesa3.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|gif|bmp)$/.test(ext))){
					alert('Solo imagenes JPG,GIF,PNG,BMP.');
					return false;
				}
			},
			onComplete: function(file, response){
				var mirsp = response;
				//reload ();
				document.getElementById('fotoSubida_'+id).value='spadmin/'+mirsp;
				$('#fotoSubida2_'+id).html('spadmin/'+mirsp);
				// document.getElementById('imgSubida'+id).src='spadmin/'+mirsp;
				// $('#btnborrarimg').fadeIn();
			}
		});
	}
	
	function cambiarImg(id){
		// alert(id)
		var btnUpload=$('#upload_img_'+id);
		new AjaxUpload(btnUpload, {
			action: 'spadmin/procesaImg.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|gif|bmp)$/.test(ext))){
					alert('Solo imagenes JPG,GIF,PNG,BMP.');
					return false;
				}
			},
			onComplete: function(file, response){
				var mirsp = response;
				//reload ();
				// document.getElementById('fotoSubida_'+id).value='spadmin/'+mirsp;
				// $('#fotoSubida2_'+id).html('spadmin/'+mirsp);
				document.getElementById('foto_subida_'+id).src='spadmin/'+mirsp;
				// $('#btnborrarimg').fadeIn();
				$('#mensaje').html('Foto actualizada con exito');
				setTimeout(function(){
					console.log('he he he he ');
					verImg(id);
				}, 2000);
				setTimeout(function(){
					console.log('he he he he ');
					location.reload();
				}, 2500);
				
			}
		});
	}
	var tableToExcel = (function() {
		var uri = 'data:application/vnd.ms-excel;base64,'
		, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8" ><link href="css/style.css" media="screen" rel="StyleSheet" type="text/css"/><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
		, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
		, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		}
	})()
</script>