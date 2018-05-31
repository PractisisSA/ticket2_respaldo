<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
	date_default_timezone_set('America/Guayaquil');
	include 'conexion.php';
	echo '<input type="hidden" id="data" value="40" />';
?>

<div style="background-color:#171A1B; padding:20px;">
	<div style="border: 2px solid #00AEEF; margin:20px;">
		<div style="background-color:#EC1867; color:#fff; margin:20px 50px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
			<strong>ADMINITRAR BANNERS SECUNDARIOS</strong>
		</div>
		<h4 style="color:white !important;">Se muestran:</h4>
		<select id="concerts">
			<option value="0">Selecciona un evento</option>
			<?php

				$sql = 'SELECT * FROM Concierto WHERE strCaractristica <> "home" and costoenvioC > 0 order by 1 DESC';
				$res = mysql_query($sql);
				while ($row = mysql_fetch_array($res)) {
					echo "<option value='".$row['idConcierto']."'>".$row['idConcierto']."-".$row['strEvento']."</option>";
				}

			?>
		</select>
		<div class="row">
		<?php
			$sqlC = 'select * from Concierto where strCaractristica = "home" and costoenvioC > 0 order by 1 DESC';
			$resC = mysql_query($sqlC) or die (mysql_error());

			while ($rowC = mysql_fetch_array($resC)) {
				$show = $rowC['strCaractristica'];
		?>
			<div class="col-md-4 col-md-5 col-xs-6 col-xs-8 col-xs-12 nopromos" style="height: 320px;background-color: #eee;">
			    <div class="thumbnail">
			      <img src="https://www.ticketfacil.ec/ticket2/spadmin/<?php echo $rowC['strImagen']; ?>">
			      <div class="caption">
			        <h3><?php echo $rowC['strEvento']; ?></h3>
			        <?php  

			        	if ($show == 'home') {
			        ?>
			        		<p><a onclick="desactivar(<?php echo $rowC['idConcierto']; ?>)" class="btn btn-primary" role="button">Desactivar</a></p>
			        <?php
			        	
			        	}else{
			        ?>
			        		<p><a href="#" class="btn btn-primary" role="button">Activar</a></p>
			        <?php
			        	}

			        ?>
			      </div>
			    </div>
			</div>
		<?php
			}			
		?>
		</div>
	</div>	
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#concerts').change(function () {
			var idConcierto = $('#concerts').val();
			if (idConcierto == '' || idConcierto == 0) {
				alert('Debe seleccionar un concierto');
			}else{
				$.ajax({
					method:'POST',
					url:'spadmin/adminBanner2.php',
					data:{id_con:idConcierto, action:1},
					success:function (response) {
						alert('Evento activado!');
						location.reload();
					}
				})
			}
		})
	})
	function desactivar(concert) {
		var idConcierto = concert;
		$.ajax({
			method:'POST',
			url:'spadmin/adminBanner2.php',
			data:{id_con:idConcierto, action:2},
			success:function (response) {
				alert('Evento desactivado!');
				location.reload();
			}
		})
	}
</script>