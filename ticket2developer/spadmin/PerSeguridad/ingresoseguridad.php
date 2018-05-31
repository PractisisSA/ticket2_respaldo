<?php 
	include("../../controlusuarios/seguridad.php");
	$nombre = $_SESSION['useractual'];
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>TODOTICKET</title>
		<link href="../../responsive/boilerplate.css" rel="stylesheet" type="text/css">
		<link href="../../css/responsive.css" rel="stylesheet" type="text/css">
		<script src="../../responsive/respond.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,700,400' rel='stylesheet' type='text/css'>
		<style>
			body{
				font-family: 'Roboto', sans-serif;
				background: url(http://subtlepatterns.com/patterns/otis_redding.png);
			}
			.logo{
				background: url(http://subtlepatterns.com/patterns/otis_redding.png);
			}
			.footer{
				background: url(http://subtlepatterns.com/patterns/otis_redding.png);
			}
		</style>
	</head>
	<body>
		<div id="header" class="logo">
			<table width="100%">
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<a href="../../index.php"><img src="../../imagenes/img_logotodoticket.png" width=100%" /></a>
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table width="100%">
							<tr>
								<td align="center">
									<br>
									<br>
									<br>
									<br>
									<?php if($_SESSION["autentica"] != "SIP"){?>
									<p><a href="../../login.php">Ingreso al Sistema</a></p>
									<?php }else{
										echo $_SESSION["useractual"]."<br>";
									?>
									<a href="../../controlusuarios/salir.php">Salir</a>
									<?php }?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="menu" class="menu">
			<?php include("../../includes/menuSeguridad.php");?>
		</div>
		<div id="contenido" class="contenido">
			<br>
			<br>
			<br>
			<br>
			<table width="100%">
				<tr align="center">
					<td colspan="2">
						<p><strong><h1>Bienvenid@ <?php echo $nombre;?></h1></strong></p>
					</td>
				</tr>
				<tr align="center">
					<td colspan="2">
						<p><strong><h2>Tu ingreso a sido correcto...!!</h2></strong></p>
					</td>
				</tr>
			</table>
        </div>
		<div id="footer" class="footer">
        	<p align="center"><img src="../../imagenes/img_facebook.png" width="30" height="30" HSPACE="15px" />
                            <img src="../../imagenes/icono-twitter-2.png" width="30" height="30" />
        	</p>
			<p><strong>TODO TICKET 1.0</strong>
        	</p>
        </div>
	</body>
</html>