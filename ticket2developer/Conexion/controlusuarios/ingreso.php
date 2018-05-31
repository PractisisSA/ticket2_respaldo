<?php 
	include("../seguridad.php");
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
	</head>
	<body>
		<div id="header" class="logo">
			<table width="100%">
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<a href="../../index.php"><img src="../../imagenes/img_logotodoticket.jpg" width=100%" /></a>
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
									<a href="../salir.php">Salir</a>
									<?php }?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="menu" class="menu">
			<?php include("../../includes/menubeBoletero.php");?>
		</div>
		<div id="contenido" class="contenido">
			<table width="100%">
				<tr align="center">
					<td colspan="2">
						<p><strong>Bienvenido al Sistema</strong></p>
					</td>
				</tr>
				<tr align="center">
					<td colspan="2">
						<p><strong>Su ingreso a sido correcto...!!</strong></p>
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