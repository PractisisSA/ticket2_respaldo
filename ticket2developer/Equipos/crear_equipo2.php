<input type="hidden" id="data" value="21" />
<div style="margin:10px -10px;">
<script type="text/javascript" src="js/jquery.numeric.js"></script>

	<body>
		
		<div style="background-color:#171A1B;"  >
			
			<div class = 'row'>
				<div class = 'col-md-12'>
					<h3 style = 'padding-top: 10px;padding-bottom: 10px;padding-left: 10px;padding-right: 10px;background-color: #ED1568;color: #fff'>
						CREAR EQUIPOS
					</h3>
				</div>
			</div>

			<div class = 'row'>
				<div class = 'col-xs-3'></div>
				<div class = 'col-xs-5' style = 'color:#fff;'>
					<div class="content">
						<input type = 'text' id = 'nombre' class = 'form-control entero' placeholder = 'Nombre del Equipo' />
						<br>
						<input type = 'text' id = 'ruc' class = 'form-control entero' placeholder = 'R.U.C' />
						<br>
						<input type = 'text' id = 'telefono' class = 'form-control entero' placeholder = 'Télefono' />
						<br>
						<input type = 'mail' id = 'nombre_equipo' class = 'form-control entero' placeholder = 'Mail' />
						<br>
						<input type = 'text' id = 'direccion' class = 'form-control entero' placeholder = 'Dirección' />
						<br>
						<br>
						<center><button type="button" class="btn btn-primary" onClick="muestra_oculta('contenido')" title="">Continuar</button></center>
					</div>
				</div>
				<div class = 'col-xs-3'></div>
			</div>

			<!--CREAR USUARIO-->
			<div id="contenido">
			<div class = 'row'>
				<div class = 'col-md-12'>
					<h3 style = 'padding-top: 10px;padding-bottom: 10px;padding-left: 10px;padding-right: 10px;background-color: #ED1568;color: #fff'>
						CREAR USUARIO
					</h3>
				</div>
			</div>

			<div class = 'row' >
				<div class = 'col-xs-3'></div>
				<div class = 'col-xs-5' style = 'color:#fff;'>
					<div class="content">
						<input type = 'password' id = 'clave' class = 'form-control entero' placeholder = 'Clave de acceso' />
						<br>
						<br>
						<center><button type="button" class="btn btn-primary" onclick ='guardarDatos()'>Guardar</button></center>
					</div>
				</div>
				<div class = 'col-xs-3'></div>
			</div>
		</div>
			<!-- FIN DE CREAR USUARIO-->

		</div>

	</body>
</div>

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
		$.post("Equipos/cargar_equipo.php", {
			nombre : nombre , ruc : ruc , telefono : telefono , mail : mail , direccion : direccion 
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
