<?php

	session_start();
	$idCon = $_REQUEST['idCon'];
	$yes = json_encode($_SESSION['carrito'], true);

	// echo $_SESSION['carrito'].'CARRITO';

	print_r($_SESSION['carrito']);
	// echo $_SESSION['usermail'].'USER EMAIL'.$_SESSION['username'].'USER NAME';
?>

<div class="container">
	<div class="row">
		<div class="page-header">
		  	<h1>Confirma tu compra:</h1>
		  	<small>ticketfacil.ec</small>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<ul class="list-group">
			  <li class="list-group-item">Email: <?php echo $_SESSION['usermail']; ?></li>
			  <li class="list-group-item">Cliente: <?php echo $_SESSION['username']; ?></li>
			</ul>
		</div>
		<div class="col-md-6">
			<ul class="list-group">
			  <li class="list-group-item">Documento #: <?php echo $_SESSION['userdoc']; ?></li>
			  <li class="list-group-item">Teléfono: <?php echo $_SESSION['usertelf']; ?></li>
			</ul>
		</div>
	</div>
</div>
<?php

	$nombre = '';
	$precio = '';
	$cantidad = '';
	$product_id = '';
	$espromo = '';
	$posicion = '';
	$estadoAsiento = '';
	$id_asiento = '';
	$cuantos = '';
?>
	<div class="container">
		<table class="table table-bordered">
			<thead>
		    <tr>
		      <th scope="col">Asientos #</th>
		      <th scope="col">Descripción</th>
		      <th scope="col"># Boletos</th>
		      <th scope="col">Precio Unitario</th>
		      <th scope="col">Precio Total</th>
		    </tr>
		  </thead>
	  	  <tbody>
<?php

	foreach ($_SESSION['carrito'] as $valor) {
	    $nombre = $valor['nombre'];
	    $precio = $valor['precio'];
	    $cantidad = $valor['cantidad'];
	    $product_id = $valor['product_id'];
	    $espromo = $valor['espromo'];
	    $posicion = $valor['posicion_mapa_inicio'];
	    $estadoAsiento = $valor['estadoAsiento'];
	    $id_asiento = $valor['id_asiento'];
	    $cuantos = $valor['cuantos'];
?>
		<tr>
	      <td><?php echo $id_asiento; ?></td>
	      <td><?php echo $nombre; ?></td>
	      <td><?php echo $cuantos; ?></td>
	      <td><?php echo $precio; ?></td>
	      <td><?php echo $precio; ?></td>
	    </tr>
<?php
	}
?>		
	  	   </tbody>
		</table>
	</div>
