<input type="hidden" id="data" value="21" />
<script type="text/javascript" src="js/jquery.numeric.js"></script>

<body>

	<div style="margin: 10px -10px">
		<div style="background-color:#171A1B; padding:20px;">
			<div style="border: 2px solid #00AEEF; margin:20px;">
				<!--CREAR EQUIPO-->
				<div style="background-color:#EC1867; color:#fff; margin:20px 500px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
					<strong>CREAR EQUIPOS</strong>
				</div>

				<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
					
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Nombre del Equipo:</strong></h4>
							<input type = 'text' id = 'nombre' class = 'form-control inputlogin' />
						</div>

						<div class="col-lg-5">
							<h4><strong>R.U.C:</strong></h4>
							<input type = 'text' id = 'ruc' class = 'form-control inputlogin' />
						</div>
					</div>

					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Telefono:</strong></h4>
							<input type = 'text' id = 'telefono' class = 'form-control inputlogin' />
						</div>

						<div class="col-lg-5">
							<h4><strong>Email:</strong></h4>
							<input type = 'mail' id = 'mail' class = 'form-control inputlogin' />
						</div>
					</div>

					<div class="row">
						<div class="col-lg-10">
							<h4><strong>Direccion:</strong></h4>
							<input type = 'text' id = 'direccion' class = 'form-control inputlogin' />
						</div>
					</div>

					<div class="tra_azul"></div>
					<div class="par_azul"></div>

					<div style="text-align:center; margin:20px; padding:20px 0;">
						<button type="button" class="btn btn-primary" onClick="muestra_oculta('contenido')" title="">Continuar</button>
					</div>
				</div>
				<!--FIN DE CREAR EQUIPO-->

				<!--CREAR USUARIO-->
				<div id="contenido">
					<div style="background-color:#EC1867; color:#fff; margin:20px 500px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
						<strong>CREAR USUARIO</strong>
					</div>

					<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
						
						<div class="row">
							<div class="col-lg-5">
								<h4><strong>Clave de Acceso</strong></h4>
								<input type="password" id="clave" class="form-control inputlogin">
							</div>

							<div class="col-lg-5">
								<h4><strong>Confirmar Clave de Acceso</strong></h4>
								<input type="password" id="clave2" class="form-control inputlogin">
							</div>
						</div>

						<div class="tra_azul"></div>
						<div class="par_azul"></div>

						<div style="text-align:center; margin:20px; padding:20px 0;">
							<button type="button" class="btn btn-primary" onclick ='guardarDatos()' title="">Guardar</button>
						</div>

					</div>
				</div>
				<!--FIN DE CREAR USUARIO-->


			</div>
		</div>
	</div>
</body>


<!-- MODAL EQUIPO AGREGADO-->
		<div class="modal fade" id="equipook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-info" role="alert">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
							&nbsp;Se ha guardado exitosamente su Equipo.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptaroksocio()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
<!-- FIN DE MODAL EQUIPO AGREGADO-->


<script type="text/javascript">
	function guardarDatos(){
		var nombre = $("#nombre").val();
		var ruc = $("#ruc").val();
		var telefono = $("#telefono").val(); 
		var mail = $("#mail").val(); 
		var direccion = $("#direccion").val();
		var clave = $("#clave").val(); 
		var clave2 = $("#clave2").val();
		$.post("Equipos/cargar_equipo.php", {
			nombre : nombre , ruc : ruc , telefono : telefono , mail : mail , direccion : direccion , clave : clave , clave2 : clave2 
		}).done(function(data){
				if($.trim(data) == 'ok'){
					$('#equipook').modal('show');
				//alert('se inserto');
			}
		});
	}

	function aceptaroksocio(){
	$('#equipook').modal('hidden');
	}

	function muestra_oculta(id){
        if (document.getElementById){
        var el = document.getElementById(id); 
        el.style.display = (el.style.display == 'none') ? 'block' : 'none'; 
		}
	}
	window.onload = function(){
		muestra_oculta('contenido');
	}

</script>
