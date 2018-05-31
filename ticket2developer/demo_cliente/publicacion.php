<?php  
	$concert = $_GET['con'];
?>
<div class="row">
	<div class="container">
		<div class="col-md-6">
			<?php
				$sqlT1 = 'SELECT idConcierto, strImagen , es_publi , strDescripcion , strEvento , dateFecha , timeHora , strLugar 
						  FROM Concierto 
						  WHERE costoenvioC = 1
						  AND idConcierto = '.$concert.' 
						  ORDER BY RAND()
						  DESC';
				$resT1 = mysql_query($sqlT1) or die (mysql_error());
				$nameConcert = '';
				$dateConcert = '';
				$timeConcert = '';
				$placeConcert = '';
				$videoConcert = '';
				$descriptionConcert = '';
				while($rowT1 = mysql_fetch_array($resT1)){
					$nameConcert = $rowT1['strEvento'];
					$dateConcert = $rowT1['dateFecha'];
					$timeConcert = $rowT1['timeHora'];
					$placeConcert = $rowT1['strLugar'];
					$videoConcert = $rowT1['strVideoC'];
					$descriptionConcert = $rowT1['strDescripcion'];
					$es_publi1 = $rowT1['es_publi'];
					if($es_publi1 == 2){
						$envioRuta1 = 'publicacion';
					}else{
						$envioRuta1 = 'evento';
					}
					$imgtriple1 = $rowT1['strImagen'];
					$rutatriple1 = 'spadmin/';
					$rutatriple1 = $rutatriple1.$imgtriple1;
			?>
					<div class="item">
						<img src="http://ticketfacil.ec/ticket2/<?php echo $rutatriple1;?>" alt="<?php echo $rowT1['strEvento'];?>"/>
					</div>
			<?php
				}
			?>
		</div>
		<div class="col-md-6">
		    <div class="thumbnail">
		      <div class="caption">
		        <h3><?php echo $nameConcert; ?></h3>
		        <p>Fecha: <?php echo $dateConcert; ?></p>
		        <p>Hora: <?php echo $timeConcert; ?></p>
		        <p>Lugar: <?php echo $placeConcert; ?></p>
		        <hr />
		        <p>Descripción:</p> 
		        <p><?php echo $descriptionConcert; ?></p>
		      </div>
		    </div>
		</div>
	</div>	
</div>
<hr />
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-8">
		<!--<iframe width="560" height="315" src="https://www.youtube.com/embed/NooW_RbfdWI" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->
	</div>
</div>	
<br>
<br>
<br>
<br>
<br>
<br>