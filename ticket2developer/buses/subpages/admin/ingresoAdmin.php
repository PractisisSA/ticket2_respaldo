<input type="hidden" id="data" value="9" />
<div style="margin:10px -10px;">
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div style = 'text-align:left;padding-top:10px;padding-bottom:10px;padding-left:20px;background-color:#ed1568;width:50%;' >
			<h3 style = 'margin:0px;padding:0px;color:#fff;'>Formulario para empresa de transporte</h3>
		</div>
		<?php
			// ini_set('display_startup_errors',1);
			// ini_set('display_errors',1);
			// error_reporting(-1);
			include 'enoc.php';
			if(isset($_REQUEST['id'])){
				$id_coop = $_REQUEST['id'];
				$sql = 'select * from cooperativa where id = "'.$_REQUEST['id'].'" ';
				$res = mysql_query($sql) or die (mysql_error());
				$row = mysql_fetch_array($res);
				$nom = $row['nom'];
				$ruc = $row['ruc'];
				$tel = $row['tel'];
				$email = $row['email'];
				$pag = $row['pag'];
				$cont = $row['cont'];
				$cel_cont = $row['cel_cont'];
				$dcto_tra = $row['dcto_tra'];
				$dcto_e = $row['dcto_e'];
				$inicial = $row['inicial'];
				$id_usu = $row['id_usu'];
				
				$txt = 'Actualizar';
				
				include '../conexion.php';
				
				$sqlU = 'select * from Usuario where idUsuario = "'.$id_usu.'"  ';
				$resU = mysql_query($sqlU) or die (mysql_error());
				$rowU = mysql_fetch_array($resU);
				
				$usu = $rowU['strMailU'];
				$pass = $rowU['strContrasenaU'];
				
			}else{
				$id_coop = 0;
				$nom = '';
				$ruc = '';
				$tel = '';
				$email = '';
				$pag = '';
				$cont = '';
				$cel_cont = '';
				$dcto_tra = '';
				$dcto_e = '';
				$inicial = '';
				$id_usu = 0;
				$usu = '';
				$pass = '';
				$txt = 'Grabar';
			}
		?>
		<div class = 'row'>
			<div class = 'col-md-2'></div>
			<div class = 'col-md-7' style = 'color:#fff;'>
				<div class="form-group row">
					<label for="nombre_emp" class="col-2 col-form-label">Nombre de la Empresa</label>
					<div class="col-10">
						<input placeholder = 'nombre' class="form-control campos" type="text" id="nombre_emp" value = '<?php echo $nom;?>' />
					</div>
				</div>
				<div class="form-group row">
					<label for="ruc" class="col-2 col-form-label">Ruc de la Empresa</label>
					<div class="col-10">
						<input placeholder = 'ruc' class="form-control campos" type="text" id="ruc" value = '<?php echo $ruc;?>'/>
					</div>
				</div>
				<div class="form-group row">
					<label for="telefono" class="col-2 col-form-label">Telefono de la Empresa</label>
					<div class="col-10">
						<input placeholder = 'telefono' class="form-control campos" type="text"  id="telefono" value = '<?php echo $tel;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="email" class="col-2 col-form-label">Email de la Empresa</label>
					<div class="col-10">
						<input placeholder = 'email' class="form-control campos" type="text" id="email" value = '<?php echo $email;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="web" class="col-2 col-form-label">Página Web de la Empresa</label>
					<div class="col-10">
						<input placeholder = 'www.web.com' class="form-control campos" type="text" id="web" value = '<?php echo $pag;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="nom_cont" class="col-2 col-form-label">Nombre de Contacto</label>
					<div class="col-10">
						<input placeholder = 'contacto' class="form-control campos" type="text" id="nom_cont" value = '<?php echo $cont;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="cel_cont" class="col-2 col-form-label">Celular de Contacto</label>
					<div class="col-10">
						<input placeholder = 'celular' class="form-control campos" type="text" id="cel_cont" value = '<?php echo $cel_cont;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="usuario" class="col-2 col-form-label">Usuario</label>
					<div class="col-10">
						<input placeholder = 'usuario' class="form-control campos" type="text" id="usuario" value = '<?php echo $usu;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="pass" class="col-2 col-form-label">Contraseña</label>
					<div class="col-10">
						<input placeholder = 'contraseña' class="form-control campos" type="password" id="pass" value = '<?php echo $pass;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="desT" class="col-2 col-form-label">% Dscto 3ra Edad</label>
					<div class="col-10">
						<input placeholder = 'descuento 3ra ' class="form-control campos" type="text" id="desT" value = '<?php echo $dcto_tra;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="desE" class="col-2 col-form-label">% Dscto (Estudiante , Discapacitados)</label>
					<div class="col-10">
						<input placeholder = 'descuento est/disc' class="form-control campos" type="text" id="desE" value = '<?php echo $dcto_e;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="desE" class="col-2 col-form-label">Inicial</label>
					<div class="col-10">
						<input placeholder = 'inicial' class="form-control campos" type="text" id="inicial" value = '<?php echo $inicial;?>'/>
					</div>
				</div>
				
				<div class="form-group row">
					
					<div class="col-10"><br><br>
						<center>
							<button type="button" class="btn btn-default" onclick = 'grabarCoop(<?php echo $id_coop;?> , <?php echo $id_usu;?>)'><?php echo $txt;?>   <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
						</center>
					</div>
				</div>
			</div>
			<div class = 'col-md-2'></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function grabarCoop(id_coop , id_usu){
		var nombre_emp = $('#nombre_emp').val();
		var ruc = $('#ruc').val();
		var telefono = $('#telefono').val();
		var email = $('#email').val();
		var web = $('#web').val();
		var nom_cont = $('#nom_cont').val();
		var cel_cont = $('#cel_cont').val();
		var usuario = $('#usuario').val();
		var pass = $('#pass').val();
		var desT = $('#desT').val();
		var desE = $('#desE').val();
		var inicial = $('#inicial').val();
		
		if($('.campos').val() == ''){
			alert('Hay campos vacios , revise!!!');
		}else{
			$.post("ajax/acctuCoop.php",{ 
				id_coop : id_coop , id_usu : id_usu , nombre_emp : nombre_emp , ruc : ruc , telefono , telefono , 
				email : email , web : web , nom_cont : nom_cont , cel_cont : cel_cont , usuario : usuario , 
				pass : pass , desT : desT , desE : desE , inicial : inicial
			}).done(function(data){
				alert(data);
				window.location = '';
			});
		}
	}
</script>
