<link rel="stylesheet" href="http://ticketfacil.ec/ticket2/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="http://ticketfacil.ec/ticket2/font-awesome-4.6.3/css/font-awesome.min.css">


<div class="divborderexterno">
	<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
		<strong>Pr&oacute;ximos Conciertos</strong>
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
					$rutaCon = 'spadmin/';
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
				<div class="col-md-4 nopromos">
					<div id="producto" class="panel panel-default" style="margin:10px; font-family:Roboto; font-size:13px;font-family:helvetica;">
						<div class="panel-heading" > 
							<a href="?modulo=<?php echo $linkConcPub;?>&con=<?php echo $rowConcierto['idConcierto'];?>" style = 'text-decoration:none;' >
								<img src="<?php echo $rutaCon;?>" alt="<?php echo $rowConcierto['strEvento'];?>" width = '100%' class="img-thumbnail">
							</a>
						</div>
						<div class="panel-body">
							<div class="caption">
								<h3><?php echo $rowConcierto['strEvento'];?></h3>
								<p id = 'cont_<?php echo $rowConcierto['idConcierto']; ?>' style = 'display:none;' class = 'contenidoDesc' ident = '<?php echo $rowConcierto['idConcierto']; ?>' ><?php echo utf8_encode(ReemplazarTildes($rowConcierto['strDescripcion']));?></p>
							</div>
						</div>
						<div class="panel-footer" >
							
							<p><a href="?modulo=<?php echo $linkConcPub;?>&con=<?php echo $rowConcierto['idConcierto'];?>" class="btn btn-<?php echo $boton;?>" role="button"><?php echo $txtIcono;?>&nbsp;&nbsp;&nbsp;<i class="<?php echo $iconoConc;?>" aria-hidden="true"></i></a></p>
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
		$("#cont_"+ident).html(contenido.substring(0 , 80)+"...");
		$("#cont_"+ident).css("display","block");  
	});
</script>