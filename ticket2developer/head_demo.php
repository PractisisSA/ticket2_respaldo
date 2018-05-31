	<nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img onclick="window.location.href='http://ticketfacil.ec/ticket2developer/demo.php'" src="imagenes/ticketfacilnegro.png" width="150px" height="50px">
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="demo.php">Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Eventos<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#port">Eventos</a></li>
                <li><a href="#about">Proximos eventos</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nosotros<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="aboutus.php">Quienes somos</a></li>
                <li><a href="services.php">Servicios/Cotizaciones</a></li>
                <li><a href="contact.php">Contáctenos</a></li>
                <li><a href="#">Preguntas frecuentes</a></li>
                <li><a href="demo.php?modulo=terminos_condiciones">Términos y condiciones</a></li>
              </ul>
            </li>
            <li class="active"><a href="#">Hinchas</a></li>
            <li class="active"><a href="#">Puntos de venta</a></li>
            <li class="active"><a href="contact.php">Contacto</a></li>
            <li class="active">
            	<a href="#">
					<input id="busca" class="form-control" type="text" placeholder="Buscar evento...">
				</a>
			</li>
			<?php 
			if ($_SESSION['autentica'] == 'uzx153' || $_SESSION['autentica'] == 'SA456' || $_SESSION['autentica'] == 'sec789' || $_SESSION['autentica'] == 'jag123' || $_SESSION['autentica'] == 'TfAdT545' || $_SESSION['autentica'] == 'tFSp777' || $_SESSION['autentica'] == 'tFDiS759' || $_SESSION['autentica'] == 'tFADMIN_SOCIO' || $_SESSION['autentica'] == 'dist_domi' || $_SESSION['autentica'] == 'Municipio') {
				$show = '';
			}else{
				$show = 'display:none !important;';
			} 
			?>
			<li id="yeah" style="<?php echo $show; ?>">
            	<button class="sign-out" onclick="signOut()">Log Out</button>
			</li>
          </ul>
        </div>
        <div class="row">
        	<?php if ($_SESSION['autentica'] == 'uzx153' || $_SESSION['autentica'] == 'SA456' || $_SESSION['autentica'] == 'sec789' || $_SESSION['autentica'] == 'jag123' || $_SESSION['autentica'] == 'TfAdT545' || $_SESSION['autentica'] == 'tFSp777' || $_SESSION['autentica'] == 'tFDiS759' || $_SESSION['autentica'] == 'tFADMIN_SOCIO' || $_SESSION['autentica'] == 'dist_domi' || $_SESSION['autentica'] == 'Municipio') {
        	?>
        		<div id="logNav" class="col-md-12">
					<div class="navbar-collapse collapse" id="ftheme">
						<ul id="ul-nav" class="nav navbar-nav navbar-right">
							<li class="liGeneral">
								<p id="xx" href='#'>
								<?php
									if ($_SESSION['autentica'] != 'uzx153') {
										echo $_SESSION['useractual']; 
									}else{
										echo $_SESSION['username'];
									} 
								?>
								</p>
							</li>
							<li class="liGeneral">
								<p id="yy" href='#'>
								<?php 
									if ($_SESSION['autentica'] != 'uzx153') {
										echo $_SESSION['mailuser']; 
									}else{
										echo $_SESSION['usermail'];
									} 
								?>
								</p>
							</li>
						</ul>
						<div class="separate"></div>
					</div>
				</div>
        	<?php

        	}else{

        	?>
        		<div id="logNav" class="col-md-12">
					<div class="navbar-collapse collapse" id="ftheme">
						<ul id="ul-nav" class="nav navbar-nav navbar-right">
							<li class="liGeneral"><p id="xx" onclick="$('#myModal').modal('show');" href='#'>Login</p></li>
							<li class="liGeneral"><p id="yy" href='#'>Registro</p></li>
						</ul>
						<div class="separate"></div>
					</div>
				</div>

			<?php

        	}
        	
        	?> 
			
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
			<div class="row"></div>
		</div>
</nav>
<br>
<br>
<br>
<br>
<br>
<br>	
