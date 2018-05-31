		<?php
			include 'enoc.php';
		?>
		<div class="header-structure">
				<img alt="logo" src="../gfx/logo.png"/>
			</div>
			<div class="header-structure">
				<div class="header-menu">
					<?php 
						if(isset($_SESSION['useractual'])){
							echo $_SESSION['useractual'];
						}else{
					?>
						<a class="loguearse" href="?page=login">
							LOG IN
						</a>
					<?php
						}
					?>
					
				</div>
				<div class="header-menu">
					<a class="logout" href="logOut.php">salir(logout)</a>
					
					<?php 
						if(isset($_SESSION['useractual'])){
						//	echo $_SESSION['useractual'];
						}else{
					?>
						<a class="loguearse" href="?page=newaccount">
						CREAR UNA CUENTA
					</a>
					<?php
						}
					?>
					
					
					
					
				</div>
				<div id="trapezoide"></div>
				<div id="paralelogramo"></div>
			</div>
			<nav class="navbar navbar-default" style='margin-right: 20px'>
				<div class="container-fluid">
		
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">onclick='window.location="?page=quienesSomos";'
						<ul class="nav navbar-nav">
							<li><a id="menu4" href="?page=start">HOME</a></li>
							<li><a id="menu6" href="?page=somos">QUIENES SOMOS</a></li>
							<li><a id="menu7" href="?page=transporte">BUSES</a></li>
							<li><a id="menu5" href="?page=transacciones">PUNTOS DE VENTA</a></li>
							<li><a id="menu5" href="?page=transacciones">CONTACTOS</a></li>
						</ul>
					</div>
				</div>
			</nav>