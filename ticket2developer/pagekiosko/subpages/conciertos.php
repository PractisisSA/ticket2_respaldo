<link rel="stylesheet" href="http://ticketfacil.ec/ticket2/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="http://ticketfacil.ec/ticket2/font-awesome-4.6.3/css/font-awesome.min.css">
<input type="hidden" id="data" value="3" />
<div class="divborderexterno">
	<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
		<strong>Pr&oacute;ximos Conciertos</strong>
	</div>
	<div style="background-color:#282B2D; margin-left:0px; margin-top:50px; position:relative;">
		<div class="row">
			<?php 
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
					$rutaCon = '../spadmin/';
					$rutaCon = $rutaCon.$imgCon;
				//	echo $rowConcierto['tiene_permisos']; 
					if($rowConcierto['tiene_permisos'] == 0){
						$boton = 'default';
					}elseif($rowConcierto['tiene_permisos'] != 0){
						$boton = 'default';
					}
			?>
			<div class="col-sm-6 col-md-4 col-md-4-h">
				<div class="thumbnail">
					<a href="?modulo=des_concierto&con=<?php echo $rowConcierto['idConcierto'];?>"><img src="<?php echo $rutaCon;?>" alt=""></a>
					<div class="caption">
						<h3><?php echo $rowConcierto['strEvento'];?></h3>
						<p><?php echo utf8_encode(ReemplazarTildes($rowConcierto['strDescripcion']));?></p>
						<p><a href="?modulo=des_concierto&con=<?php echo $rowConcierto['idConcierto'];?>" class="btn btn-<?php echo $boton;?>" role="button">Comprar&nbsp;&nbsp;&nbsp;<i class="fa fa-cart-plus" aria-hidden="true"></i></a></p>
					</div>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>