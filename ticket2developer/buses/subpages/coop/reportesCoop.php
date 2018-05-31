	<?php
		session_start();
		$limite = $_SESSION['limite'];
		echo $_SESSION['iduser'];
		include 'enoc.php';
		$sql = 'select * from cooperativa where id_usu = "'.$_SESSION['iduser'].'" ';
		$res = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($res);
		
		$sqlB = 'select * from bus where id_coop = "'.$row['id'].'" ';
		$resB = mysql_query($sqlB) or die (mysql_error());
		
		
	?>
	
	<style>
		.asientosBus{
			webkit-transform: rotate(-90deg); 	
			-moz-transform: rotate(-90deg); 	
			rotation: -90deg; 	
			filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=-1);
			-webkit-perspective;
			position: relative; 
			top:-150px;
			background-color: #F2F2F2;
			border-radius: 20px
		}
		
		@media only screen and (orientation:portrait){
            .asientosBus {  
                  -webkit-transform: rotate(-90deg);
                  -moz-transform: rotate(-90deg);
                  -o-transform: rotate(-90deg);
                  -ms-transform: rotate(-90deg);
                  transform: rotate(-90deg);
				  
                 }
 
         }
         @media only screen and (orientation:landscape){
            .asientosBus {  
                   -webkit-transform: rotate(-90deg);
                  -moz-transform: rotate(-90deg);
                  -o-transform: rotate(-90deg);
                  -ms-transform: rotate(-90deg);
                  transform: rotate(-90deg);
				  
                 }
         }
	</style>
	<input type="hidden" id="data" value="16" />
<div style="margin:10px -10px;"> 
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div style = 'text-align:left;padding-top:10px;padding-bottom:10px;padding-left:20px;background-color:#ed1568;width:90%;' >
			<h3 style = 'margin:0px;padding:0px;color:#fff;'>Crear Rutas de Buses Coop. : <?php echo $row['nom'];?> </h3>
		</div>
		<div class ='row'>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-12'>
				<h1>hola</h1>
			</div>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-12' id = 'recibeRutas'></div>
		</div>
	</div>
</div>
	<script>
		
	</script>