<input type="hidden" id="data" value="9" />
<div style="margin:10px -10px;">
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div style = 'text-align:left;padding-top:10px;padding-bottom:10px;padding-left:20px;background-color:#ed1568;width:50%;' >
			<h3 style = 'margin:0px;padding:0px;color:#fff;'>Listado de Cooperativas</h3>
		</div>
		<div class ='row'>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-9'>
				<table class="table table-border" style="color: white">
					<tr>
						<td colspan ='3' align = 'right'>
							<button type="button" class="btn btn-default" onclick = "window.location = '?page=coop_det'" >Nueva Cooperativa</button>
						</td>
					</tr>
					
					<tr>
						<td>ID</td>
						<td>NOMBRE</td>
						<td align = 'center'>OPCIONES</td>
					</tr>
				<?php
					$sqlC = 'select * from cooperativa order by nom asc';
					$resC = mysql_query ($sqlC) or die (mysql_error());
					while($rowC = mysql_fetch_array($resC)){
				?>	
					<tr>
						<td><?php echo $rowC['id'];?></td>
						<td style = 'text-transform:uppercase;'><?php echo $rowC['nom'];?></td>
						<td>
							<table width = '100%' style = 'color:#fff;'  >
								<tr>
									<td align ='center' style = 'cursor:pointer;' onclick = 'editarCoop(<?php echo $rowC['id'];?> , 1)'>
										<i class="fa fa-pencil-square-o" style = 'color:#fff;' aria-hidden="true"></i>  Editar
									</td>
								<?php
									if($rowC['est'] == 1){
								?>
									<td align ='center' style = 'cursor:pointer;' onclick = 'editarCoop(<?php echo $rowC['id'];?> , 2)'>
										<i class="fa fa-trash-o" style = 'color:#fff;' aria-hidden="true"></i>  Desactivar
									</td>
								<?php
									}else{
								?>
									<td align ='center' style = 'cursor:pointer;' onclick = 'editarCoop(<?php echo $rowC['id'];?> , 3)'>
										<i class="fa fa-trash-o" style = 'color:#fff;' aria-hidden="true"></i>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Activar
									</td>
								<?php
									}
								?>
								</tr>
							</table>
						</td>
					</tr>
				<?php
					}	
				?>
					</table>
			</div>
			<div class = 'col-md-1' ></div>
		</div>
	</div>
	<script>
		function editarCoop(id , ident){
			if(ident == 1){
				window.location = '?page=coop_det&id='+id;
			}else if(ident > 1 ){
				//window.location = '?page=coop_det';
				$.post('subpages/admin/eliminaCoop.php',{
					id : id , ident : ident
				}).done(function(data){
					alert(data);
					window.location ='';
				});
			}
		}
	</script>
	