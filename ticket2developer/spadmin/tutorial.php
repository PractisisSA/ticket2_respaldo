<?php
	include("../controlusuarios/seguridadSA.php");
?>
<!doctype html>
<html>
<head>
		<meta charset="iso-8859-1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>TODOTICKET</title>
		<link href="../responsive/boilerplate.css" rel="stylesheet" type="text/css">
		<link href="../css/responsive.css" rel="stylesheet" type="text/css">
		<script src="../responsive/respond.min.js"></script>
		<link rel="shortcut icon" href="../imagenes/3334img_logotodoticket.ico">
		<style>
			body{
				font-family: 'Roboto', sans-serif;
				background-image: url(http://subtlepatterns.com/patterns/debut_light.png);
			}
			.logo{
				background-image: url(http://subtlepatterns.com/patterns/debut_light.png);
			}
			.footer{
				background-image: url(http://subtlepatterns.com/patterns/debut_light.png);
			}
			.tuto{
				width: 100%;
				max:width: 800px;
				border: 2px solid #c0c0c0;
			}
			.tuto td{
				border: none;
				text-align: center;
			}
			.video{
				width: 100%;
				max-width: 800px;
				height: 400px;
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
									<img src="../imagenes/img_logotodoticket.png" width=100%" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="menu" class="menu">
		</div>
		<div id="contenido" class="contenido">
			<table class="tuto">
				<tr>
					<td>
						<iframe class="video" src="https://www.youtube.com/embed/k8khZHnCQhA">
						</iframe>
					</td>
				<tr>
			</table>
		</div>
		<div id="footer" class="footer">
        	<p align="center"><img src="../imagenes/img_facebook.png" width="30" height="30" HSPACE="15px" />
                            <img src="../imagenes/icono-twitter-2.png" width="30" height="30" />
        	</p>
			<p><strong>TODO TICKET 1.0</strong>
        	</p>
        </div>
	</body>
</html>