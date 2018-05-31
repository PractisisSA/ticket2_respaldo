<?php
	include 'conexion.php';
	$sql = 'select * from Boleto where idCon = "26"';
	$res = mysql_query($sql) or die (mysql_error());
	$con = 1; 
	
	$hoy = date("y");   
	echo $hoy;
	
	$ced = $_REQUEST['cedula'];
	
	
	// $pagina_inicio = file_get_contents('http://www.ecuadorlegalonline.com/modulo/datos/consultar-fecha-nac.php');
	
	// echo $pagina_inicio;
	
	
	 // $fp = fopen("http://www.ecuadorlegalonline.com/modulo/datos/consultar-fecha-nac.php?ci=1716620818", "w");
	 
	 // echo "q hace ".$fp." hola";
	
	
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="icon" href="https://livedemo00.template-help.com/landing_58100/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<title>Ticketfacil.ec|inicio</title>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script language="Javascript"  type="text/javascript" src="js/clockCountdown.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.imagemapster.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/ticketfacilStyles.css">
<script src="js/jquery.easing-1.3.js"></script>
<script src="js/jquery.mousewheel-3.1.12.js"></script>
<script src="js/jquery.jcarousellite.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<style>
	.oc{
		display:none;
	}
</style>

<body>
	<div class = 'container'>
		<input type = "text" value = "<?php echo $ced; ?>" id = "cedula_" />
		<button type="button" class="btn btn-default" onclick = 'verCedula()' >Default</button>
		<form method = 'post' action = 'http://www.ecuadorlegalonline.com/modulo/datos/consultar-fecha-nac.php?ci=<?php echo $ced;?>'  >
			  <input type="submit" value="Submit">
		</form>
		
		<iframe src = 'http://www.ecuadorlegalonline.com/modulo/datos/consultar-fecha-nac.php?ci=<?php echo $ced;?>' ></iframe>
	</div>
</body>
<script>
	
	
	function verCedula(){
		var ci = $('#cedula_').val();
		
		$.ajax({
            type: "GET",
            url: 'get_data.php',
            data:{ci:ci},
            async:true,
            crossDomain:true,
            success: function(data, status, xhr) {
                alert(xhr.getResponseHeader('Location'));
            }
        });

		  
		  
		// var ci = $('#cedula_').val();
		// alert(ci)
		// $.post("http://www.ecuadorlegalonline.com/modulo/datos/consultar-fecha-nac.php",{ 
			// ci : ci
		// }).done(function(data){
			// alert(data)			
		// });
		
	}
</script>