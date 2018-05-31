<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<input type="hidden" id="data" value="3" />
<div class="divborderexterno" style = 'margin:0 !important;'>
	<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
		<strong>Eventos</strong>
	</div>
	<div style="background-color:#282B2D; margin-left:0px; margin-top:50px; position:relative;">
		<div class="row">
			<?php 
				include 'conexion.php';
				function ReemplazarTildes($texto){
					$texto=str_replace("á","&aacute;",$texto);
					$texto=str_replace("é","&eacute;",$texto);
					$texto=str_replace("í","&iacute;",$texto);
					$texto=str_replace("ó","&oacute;",$texto);
					$texto=str_replace("ú","&uacute;",$texto);
					$texto=str_replace("ñ","&ntilde;",$texto);
					$texto=str_replace("Á","&Aacute;",$texto);
					$texto=str_replace("É","&Eacute;",$texto);
					$texto=str_replace("Í","&Iacute;",$texto);
					$texto=str_replace("Ó","&Oacute;",$texto);
					$texto=str_replace("Ú","&Uacute;",$texto);
					$texto=str_replace("Ñ","&Ntilde;",$texto);
					return $texto;
				}
				while($rowConcierto = $resultDatosConciertoStart -> fetch(PDO::FETCH_ASSOC)){
					$imgCon = $rowConcierto['strImagen'];
					$rutaCon = 'https://www.ticketfacil.ec/ticket2/spadmin/';
					$rutaCon = $rutaCon.$imgCon;
				//	echo $rowConcierto['tiene_permisos']; 
					if($rowConcierto['tiene_permisos'] == 0){
						$boton = 'default';
					}elseif($rowConcierto['tiene_permisos'] != 0){
						$boton = 'default';
					}
					if($rowConcierto['es_publi'] == 2){
						$iconoConc = 'fa fa-ticket';
						$txtIcono = 'Ver más';
						$linkConcPub = 'des_pub';
					}else{
						$iconoConc = 'fa fa-cart-plus';
						$txtIcono = 'Comprar';
						$linkConcPub = 'des_concierto';
					}
					$sqlBo = 'select count(idBoleto) as cuantos from Boleto where idCon = "'.$rowConcierto['idConcierto'].'" ';
					$resBo = mysql_query($sqlBo) or die(mysql_error());
					$rowBo = mysql_fetch_array($resBo);
					
			?>
				<div class="col-md-4 col-md-5 col-xs-6 col-xs-8 col-xs-12 nopromos" style = 'height: 320px;background-color: #eee'>
					<div id="producto" class="panel panel-default" style="margin:10px; font-family:Roboto; font-size:13px;font-family:helvetica;">
						<div class="panel-heading" style = 'text-align: center'> 
							<a href="?modulo=<?php echo $linkConcPub;?>&con=<?php echo $rowConcierto['idConcierto'];?>" style = 'text-decoration:none;' >
								<center>
									<img src="<?php echo $rutaCon;?>" alt="<?php echo $rowConcierto['strEvento'];?>" style = 'max-height:120px !important;' class = 'img-responsive' />
								</center>
							</a>
						</div>
						<div class="panel-body" style = 'height: 110px'>
							<table width = '100%' height = '100%'>
								<tr>
									<td style = 'vertical-align:middle;align:;left'>
										<label style = 'text-transform:uppercase;'><?php echo $rowConcierto['strEvento'];?></label><br>
										<label style = 'font-size:10px;color:#282B2D;'><i class="fa fa-calendar" aria-hidden="true"></i> : <?php echo $rowConcierto['dateFecha'];?></label>  /  
										<label style = 'font-size:10px;color:#282B2D;'><i class="fa fa-clock-o" aria-hidden="true"></i> : <?php echo $rowConcierto['timeHora'];?></label><br> 
										<label style = 'font-size:10px;color:#282B2D;text-transform:uppercase;'><i class="fa fa-building-o" aria-hidden="true"></i> : <?php echo $rowConcierto['strLugar'];?></label>
									</td>
								</tr>
							</table>
						</div>
						<div class="panel-footer" >
							
							<center><a href="?modulo=<?php echo $linkConcPub;?>&con=<?php echo $rowConcierto['idConcierto'];?>" class="btn btn-<?php echo $boton;?>" role="button"><?php echo $txtIcono;?>&nbsp;&nbsp;&nbsp;<i class="<?php echo $iconoConc;?>" aria-hidden="true"></i></a></center>
						</div>
					</div>
				</div>
			<?php }?>
		</div>
	</div>
</div>
<script>
	$('.contenidoDesc').each(function(){
		var ident = $(this).attr('ident');
		//alert(ident);
		var contenido = $("#cont_"+ident).text();
		$("#cont_"+ident).html(contenido.substring(0 , 180)+"...");
		$("#cont_"+ident).css("display","block");  
	});
</script>