<?php
	//include("controlusuarios/seguridadSA.php");
	include 'conexion.php';
	
	echo '<input disabled type="hidden" id="data" value="2" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				DESCUENTOS
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;">
				<strong>
						<button type="button" class="btn btn-warning" onclick = "$('#modalLimiteCortesias').modal('show');"  >Ver Cortesias</button></strong>
				</strong>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
        <div id="borradesc" class='row' style='color:#fff;display: none;'>
            <div class = 'col-md-12'>
                Borrar Descuentos
            </div>
            <div class = 'col-md-12'>
    			<table class='table'>
    					<tr>
    						<td width = '200px'>
    							Descuentos<br>
                                <select class="form-control" id="descuentosdelete">
    							    <option value="">Seleccione un Descuento</option>
                                    <?php
                                    $sqldes = "SELECT * FROM descuentos WHERE idcon=".$_REQUEST['id']." group by nom";
                					$resdes = mysql_query($sqldes) or die (mysql_error());
                					while($rowdes = mysql_fetch_array($resdes)){
                                    ?>
                                    <option value="<?php echo $rowdes['nom'];?>"><?php echo $rowdes['nom'];?></option>
                                    <?php
                					}
                                    ?>
    							</select>
    						</td>
                        </tr>
                        <tr>
    						<td></td>
                            <td></td>
                        </tr>
                </table>
            </div>
        </div>
		<div class = 'row'>
			<div class = 'col-md-1'></div>
			<div class = 'col-md-12'>
				<table class = 'table' style = 'color:#fff;'>
					<tr>
						<td width = '200px'>
							EVENTO
						</td>
						<td width = '150px'>
							LOCALIDAD
						</td>
						<td>
							DESCRIPCION
						</td>
						<td>
							VALOR NORMAL
						</td>
						<td width = '70px'>
							VALOR DESCUENTO
						</td>
						
					</tr>
				<?php
					$sql = 'select l.strDescripcionL , d.* , l.doublePrecioL , l.idLocalidad
							from Localidad as l , descuentos as d 
							where l.idConc = "'.$_REQUEST['id'].'" 
							and d.idloc = l.idLocalidad
							and d.idcon = "'.$_REQUEST['id'].'" 
							order by d.nom , l.strDescripcionL ASC
							';
					$res = mysql_query($sql) or die (mysql_error());
					
					$sql1 = 'select idConcierto , strEvento from Concierto where idConcierto = "'.$_REQUEST['id'].'" ';
					$res1 = mysql_query($sql1) or die (mysql_error());
					$row1 = mysql_fetch_array($res1);

					while($row = mysql_fetch_array($res)){
						// $sql2 = 'select * from descuentos where idcon = "'.$row1['idConcierto'].'" and idloc = "'.$row['idLocalidad'].'" ';
						// $res2 = mysql_query($sql2) or die (mysql_error());
						//while($row2 = mysql_fetch_array($res2)){
							//if($row['idLocalidad'] == $row2['idloc']){
								$btn = 'warning';
								$txt = 'ACTUALIZAR';
								$param = $row['id'];
								if($row['est'] == 1){
									$che = 'checked';
								}else{
									$che = '';
								}
								
								if($row['web'] == 1){
									$check = 'checked';
								}else{
									$check = '';
								}
							//}
				?>
							<tr class = 'descuentos_global' numero_descuento = '<?php echo $param;?>' >
								<td>
									<?php echo $row1['strEvento'];?>
								</td>
								<td>
									<?php echo $row['strDescripcionL'];?>
								</td>
								<td>
									<input disabled onkeyup = "saberEspecial(<?php echo $param;?>)" type = 'text' value = '<?php echo $row['nom'];?>' class = 'form-control' id = 'nombDesc_<?php echo $param;?>' style = 'color:#000;' placeholder = 'Nombre Desc.'/>
								</td>
								<td>
									<?php echo $row['doublePrecioL'];?>
								</td>
								<td>
									<input disabled type = 'text' value = '<?php echo $row['val'];?>' class = 'form-control entero' id = 'valorDesc_<?php echo $param;?>' style = 'color:#000;' placeholder = 'Valor Dec.'/>
								</td>
							</tr>
				<?php
						
					} 
				?>
				</table>
			</div> 
			<div class = 'col-md-1'></div>
		</div>
	</div>
	<style>
		.pociciones{
			text-align:center;
		}
	</style>
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="modalLimiteCortesias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;PARA PODER CONTINUAR DEBE INGRESAR LA CANTIDAD <b style = 'color:#000;'><i>LIMITE</i></b> DE CORTESIAS  PARA CADA LOCALIDAD !!!&nbsp;
					</div>
				</div>
				<div class="modal-body">
					<div class = 'row' >
						<div class = 'col-md-1'></div>
						<div class = 'col-md-10' id = 'recibeBoletos'>
							<table class = 'table' >
								<tr>
									<th>#</th>
									<th>Localidad</th>
									<th class = 'pociciones' >Capacidad<br><span style = 'font-size:9px;'>(macro A)</span></th>
									<th class = 'pociciones'>Bloqueados<br><span style = 'font-size:9px;'>(negros B)</span></th>
									<th class = 'pociciones'>Capacidad Diponible<br><span style = 'font-size:9px;'>(A-B)</span></th>
									<th class = 'pociciones'>Cantidad de Cortesias C</th>
									<th class = 'pociciones'>Cantidad Disp. sin Cortesias ((A-B) - C)</th>
								</tr>
							<?php
								$sql2 = '	select l.idLocalidad , strDescripcionL , lc.cant as cantidad , lc.id as id_cantidades , d.id as id_desc , l.strCapacidadL as capacidad_macro
											from Localidad as l
											left join localidad_cortesias as lc
											on lc.id_loc = l.idLocalidad
											left join descuentos as d
											on d.idloc = l.idLocalidad
											where idConc = "'.$_REQUEST['id'].'" 
											and d.nom LIKE "%cortes%"
											order by l.idLocalidad
										';
								$res2 = mysql_query($sql2) or die (mysql_error());
								
								while($row2 = mysql_fetch_array($res2)){
									if($row2['id_cantidades'] != null){
										$id_cantidades = $row2['id_cantidades'];
									}else{
										$id_cantidades = 0;
									}
									
									$sqlOc = '	SELECT 1 as posicion, `row` , `col` , (`status`) , (`local`) , (`concierto`) 
												FROM `ocupadas`
												WHERE `local` = "'.$row2['idLocalidad'].'" 
												and status = "3"
												group by `row` , `col` , `status` , `local` , `concierto` 
												ORDER BY `col` ASC
											';
									$resOc = mysql_query($sqlOc) or die (mysql_error());
									$sumaBloqueos = 0;
									while($rowOc = mysql_fetch_array($resOc)){
										$sumaBloqueos += $rowOc['posicion'];
									}
									
							?>
								<tr class = 'cantidades_cortesias' localidad = "<?php echo $row2['idLocalidad'];?>" >
									<td><?php echo $row2['idLocalidad'];?></td>
									<td><?php echo $row2['strDescripcionL'];?></td>
									<td class = 'pociciones'><?php echo ($row2['capacidad_macro']);?></td>
									<td class = 'pociciones'><?php echo ($sumaBloqueos);?></td>
									<td class = 'pociciones'>
										<?php echo "<div id = 'cantidad_aut_".$row2['idLocalidad']."' >".($row2['capacidad_macro'] - $sumaBloqueos)."</div>";?>
									</td>
									<td>
										
										<input disabled onblur = 'controlaCantidad(<?php echo $row2['idLocalidad'];?>)' id = 'cantidad_<?php echo $row2['idLocalidad'];?>' type = "number" class = 'form-control' value = '<?php echo $row2['cantidad'];?>' />
										<input disabled id = 'id_canti_<?php echo $row2['idLocalidad'];?>' type = "hidden" class = 'form-control' value = '<?php echo $id_cantidades;?>' />
										<input disabled id = 'id_canti_desc_<?php echo $row2['idLocalidad'];?>' type = "hidden" class = 'form-control' value = '<?php echo $row2['id_desc'];?>' />
										
									</td>
									<td class = 'pociciones'><?php echo ($row2['capacidad_macro'] - $sumaBloqueos - $row2['cantidad']);?></td>
								</tr>
							<?php
								}
							?>
							</table>
						</div>
						<div class = 'col-md-1'></div>
					</div>
				</div>
				<div class="modal-footer"  >
					<img src='http://ticketfacil.ec/imagenes/loading.gif' width='100px' style='display:none;' id='loadBoleto1'/>
					<div id = 'recibePruebas'></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script>
	function controlaCantidad(id){
		var cantidad_aut_ = $('#cantidad_aut_'+id).text();
		var cantidad_ = $('#cantidad_'+id).val();
		if(parseInt(cantidad_) > parseInt(cantidad_aut_)){
			$('#cantidad_'+id).val(0);
			alert('atencion, no puede configurar : ' + cantidad_ + ' tickets para cortesias !!!  \n porque solo tiene :' +  cantidad_aut_ + ' tickets autorizados, por favor ingrese una cantidad menor' );
		}else{
			
		}
		// alert(cantidad_aut_ +' <<>> '+ cantidad_);
	}
	
	
	function grabarCantidades(){
		var servi = '';
		var continua = 1;
		$( ".cantidades_cortesias" ).each(function( index ) {
			var localidad = $(this).attr('localidad');
			var cantidad_ = $(this).find('#cantidad_'+localidad).val();
			var id_canti_ = $(this).find('#id_canti_'+localidad).val();
			var id_canti_desc_ = $(this).find('#id_canti_desc_'+localidad).val();
			if(cantidad_ == ''){
				$('#cantidad_'+localidad).attr('placeholder','no puede dejar la cantidad en blanco');
				continua = 0;
			}else{
				servi += localidad +'@'+ cantidad_ +'@'+ id_canti_ + '@' + id_canti_desc_ + '|'
				continua = 1;
			}
			
		});
		var serviform = servi.substring(0,servi.length - 1);
		if(continua == 0){
			
		}else{
			// alert(serviform)
			$.post("spadmin/grabaCantidadCortesias.php",{ 
				serviform : serviform 
			}).done(function(data){
				alert(data)			
			});
		}
		
	}
	function saberEspecial(id){
		var nombDesc = $('#nombDesc_'+id).val();
		alert(nombDesc);
	}
	function grabarTodos(){
		$( ".descuentos_global" ).each(function( index ) {
			var ident = 1;
			var id = $(this).attr('numero_descuento');
			var nombDesc = $('#nombDesc_'+id).val();
			var valorDesc = $('#valorDesc_'+id).val();
			var estDesc = 0;
			
			if($('#estDesc_'+id).is(':checked') ) {
				estDesc = 1;
			}else{
				estDesc = 0;
			}
			
			if($('#estDescWeb_'+id).is(':checked') ) {
				estDescWeb = 1;
			}else{
				estDescWeb = 0;
			}
			
			if(nombDesc == ''){
				alert('ingrese nombre de descuento');
			}
			
			if(valorDesc == ''){
				alert('ingrese valor de descuento');
			}
			
			// alert(nombDesc + ' << >> ' + valorDesc + '<< >> ' + id);
			if(nombDesc == '' || valorDesc == ''){
				
			}else{
				$.post("spadmin/grabarDescuento.php",{ 
					id : id , nombDesc : nombDesc , valorDesc : valorDesc , ident : ident , estDesc : estDesc , estDescWeb : estDescWeb
				}).done(function(data){
					alert(data);
					//window.location = '';
				});
			}
		});
	}
	$( document ).ready(function() {
		$('.entero').numeric();
	});
	function editaDescuento(ident , idLoc , id ){
		var nombDesc = $('#nombDesc_'+id).val();
		var valorDesc = $('#valorDesc_'+id).val();
		var estDesc = 0;
		
		if($('#estDesc_'+id).is(':checked') ) {
			estDesc = 1;
		}else{
			estDesc = 0;
		}
		
		if($('#estDescWeb_'+id).is(':checked') ) {
			estDescWeb = 1;
		}else{
			estDescWeb = 0;
		}
		
		// alert(estDesc);
		if(nombDesc == ''){
			alert('ingrese nombre de descuento');
		}
		
		if(valorDesc == ''){
			alert('ingrese valor de descuento');
		}
		
		alert(nombDesc + ' << >> ' + valorDesc + '<< >> ' + id);
		if(nombDesc == '' || valorDesc == ''){
			
		}else{
			$.post("spadmin/grabarDescuento.php",{
				id : id , nombDesc : nombDesc , valorDesc : valorDesc , ident : ident , estDesc : estDesc , estDescWeb : estDescWeb
			}).done(function(data){
				alert(data);
				location.reload();
			});
		}

	}
function verborrardescuentos(){
    $('#borradesc').fadeIn();
}
function borradescuento(idevento){
    var nomdes = $('#descuentosdelete').val();
    if(nomdes == ''){
        alert('Debe escoger un descuento para poder borrar.');
    }else{
        console.log(nomdes+'**'+idevento);
        $.post("spadmin/borrarDescuento.php",{
            id : idevento , nombDesc : nomdes
        }).done(function(data){
            alert(data);
            window.location = '';
        });
    }
}
</script>