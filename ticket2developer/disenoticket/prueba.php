<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="js/interact.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
	.parte{
		background-color:#EFEFEF;
		padding:10px;
		border:1px solid #CCC;
		border-radius:5px;
		font-size:11px;
		padding:0px;
	}
	.encabezado{
		min-height:100px;
	}
	.cuerpo{
		min-height:300px;
	}
	.datosenc{
		min-height:20px;
		height:20px;
		background-color:white;
		border-radius:3px;
		border:1px solid #CCC;
		padding:2px;
		/*width:110px;*/
		position:absolute;
		text-align:left;
		font-size:11px;
        z-index: 1;
	}
    .rotated {
        -webkit-transform: rotate(-90deg);  /* Chrome, Safari 3.1+ */
        -moz-transform: rotate(-90deg);  /* Firefox 3.5-15 */
        -ms-transform: rotate(-90deg);  /* IE 9 */
        -o-transform: rotate(-90deg);  /* Opera 10.50-12.00 */
        transform: rotate(-90deg);  /* Firefox 16+, IE 10+, Opera 12.10+ */
    }
</style>
<?php
require_once('ajax/private.db.php');
$gbd = new DBConn();
$id_diseno = isset($_REQUEST['iddiseno']) ? $_REQUEST['iddiseno'] : 0;

$sel = "select * from disenoticket WHERE id = $id_diseno";
$sql = $gbd -> prepare($sel);
$sql -> execute();
$rows = $sql -> fetch(PDO::FETCH_ASSOC);

$selcon = "select * from Concierto where strEstado = 'Activo'";
$sqlcon = $gbd -> prepare($selcon);
$sqlcon -> execute();

$selcond = "select * from disenoticket where activo = '1'";
$sqlcond = $gbd -> prepare($selcond);
$sqlcond -> execute();

$anchoboleto =(float) $rows['ancho_boleto'];
$altoboleto =(float) $rows['alto_boleto'];
$tambarra =(float) $rows['tam_barra'];

$anchoboleto = $anchoboleto/10;
$altoboleto = $altoboleto/10;
$tambarra = $tambarra/10;

?>
<div class='col-lg-12'>
<div class='row'>
	<div class='container-fluid'>
		<div class='panel panel-default'>
			<div class='panel-body'>
                <div class='row'>
                    <div class='col-md-2'>
                        <b>Diseños de Boletos</b><br>
                        <select id="disbol" name="disbol" class="form-control" onchange="verdisenob();" size="1">
                            <option value="0"></option>
                            <?php
                            foreach($sqlcond -> fetchAll(PDO::FETCH_ASSOC) as $keyricond => $valuericond){
                                if($id_diseno == $valuericond['id']){
                                    $selecbol = 'selected="selected"';
                                }else{
                                    $selecbol = '';
                                }
                            ?>
                                <option <?php echo $selecbol;?> value="<?php echo $valuericond['id'];?>"><?php echo '('.$valuericond['id'].') '.$valuericond['ticket'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class='col-md-3'>
                        <b>Nombre Diseño</b><br>
                        <input id="nombdise" name="nombdise" class="form-control" value="<?php echo $rows['ticket']; ?>" type="text">
                    </div>
                    <div class='col-md-3'>
                        <b>Eventos</b><br>
                        <select id="conciertos" name="conciertos" class="form-control" onchange="verlocalidad();" size="1">
                            <option value="0"></option>
                            <?php
                            foreach($sqlcon -> fetchAll(PDO::FETCH_ASSOC) as $keyricon => $valuericon){
                                //echo $valuericon['idConcierto'].'++'.$valuericon['strEvento'].'<br>';
                            ?>
                                <option value="<?php echo $valuericon['idConcierto'];?>"><?php echo '('.$valuericon['idConcierto'].') '.$valuericon['strEvento'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <b>Localidad</b><br>
                        <select id="localidades" name="localidades" class="form-control" onchange="verdescuento();" size="1">
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <b>Descuento</b><br>
                        <select id="descuentos" name="descuentos" class="form-control" onchange="verconcierto();" size="1">
                        </select>
                    </div>
                </div>
                <h3>Configuración</h3>
                <div class='col-md-3'>
					<div class='container-fluid'>
						<div class='row'>
							<b>Medida Boleto</b>
                            <div class='row'>
    							<div class='col-md-4'>
                                    <b>Ancho (cm)</b>
                                </div>
                                <div class='col-md-8'>
                                    <input id="ancho" name="ancho" type="text" class="form-control" onblur="cargaBoleto();" value="<?php echo $anchoboleto;?>">
                                </div>
    						</div>
                            <div class='row'>
    							<div class='col-md-4'>
                                    <b>Alto (cm)</b>
                                </div>
                                <div class='col-md-8'>
                                    <input id="alto" name="alto" type="text" class="form-control" onblur="cargaBoleto();" value="<?php echo $altoboleto;?>">
                                </div>
    						</div>
                            <div class='row'>
    							<div class='col-md-4'>
                                    <b>Tamaño de Barra (cm)</b>
                                </div>
                                <div class='col-md-8'>
                                    <input id="tambarra" name="tambarra" type="text" class="form-control" value="<?php echo $tambarra;?>">
                                </div>
    						</div>
						</div>
					</div>
				</div>
                <div class='col-md-1'>
				</div>
                <div class='col-md-8'>
					<div class='row'>
            			<div class='col-md-3'>
                            <b>Variables</b><br>
                            <select id="variables" name="variables" class="form-control" onchange="agregaeditor();" size="1">
                                <option value=""></option>
                                <option value="[puerta]">[puerta]</option>
                                <option value="[bloque]">[bloque]</option>
                                <option value="[asientos]">[asientos]</option>
                                <option value="[codigo]">[codigo]</option>
                                <option value="[boleto]">[boleto]</option>
                                <option value="[Valor]">[Valor]</option>
                                <option value="[localidad]">[localidad]</option>
                                <option value="[Imagen]">[Imagen]</option>
                                <option value="[ruc_cliente]">[ruc_cliente]</option>
                                <option value="[lleva_cota]">[lleva_cota]</option>
                                <option value="[Nombre]">[Nombre]</option>
                                <option value="[matriz_clie]">[matriz_clie]</option>
                                <option value="[suc_cliente]">[suc_cliente]</option>
                                <option value="[aut_sri_pro]">[aut_sri_pro]</option>
                                <option value="[aut_mun_pro]">[aut_mun_pro]</option>
                                <option value="[Ruc]">[Ruc]</option>
                                <option value="[TipoCont]">[TipoCont]</option>
                                <option value="[aut_mun_cli]">[aut_mun_cli]</option>
                                <option value="[aut_sri_cli]">[aut_sri_cli]</option>
                                <option value="[Desde]">[Desde]</option>
                                <option value="[fechaA]">[fechaA]</option>
                                <option value="[FechaC]">[FechaC]</option>
                                <option value="[docu]">[docu]</option>
                                <option value="[abr]">[abr]</option>
                                <option value="[Car]">[Car]</option>
                                <option value="[valor_normal]">[valor_normal]</option>
                                <option value="[valor_descuento]">[valor_descuento]</option>
                                <option value="[valor_nominal]">[valor_nominal]</option>
                                <option value="[impuesto]">[impuesto]</option>
                                <option value="[nom]">[nom]</option>
                                <option value="[total]">[total]</option>
                            </select>
                        </div>
                        <div class='col-md-9'>
                            <b>Editor</b><br>
                            <textarea id="editor" name="editor" class="form-control"></textarea>
                            <div style="height: 5px;"></div>
                            <p style="text-align: right">
                                <button class='btn btn-success' onclick='Agrega();'>Agregar</button>
                            </p>
                        </div>
            		</div>
				</div>
                <div class='col-lg-12'>
                <p style="text-align: right">
                    <button class='btn btn-info' onclick='verconcierto();'>Refrescar</button>
                </p>
                Diseño
					<div class='container-fluid'>
                    <br>
						<div class='row'>
							<div class='col-lg-12'>
								<div class='parte encabezado' id='divencabezadover' style="font-family: 'Courier New', Courier, 'Lucida Sans Typewriter', 'Lucida Typewriter', monospace;">

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-lg-12'>
                <br>
                Edición
					<div class='container-fluid'>
                    <br>
						<div class='row'>
							<div class='col-lg-12'>
								<div class='parte encabezado' id='divencabezado'>
                                <?php echo $rows['disenoweb']; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-lg-12'>
					<div class='container-fluid'>
						<div class='row'>
							<div class='col-lg-12 col-md-12' style='text-align:left; padding-top:15px;'>
								<button class='btn btn-primary' onclick='GuardarDiseno();'>Guardar</button>
							</div>
						</div>
					</div>
				</div>
                <div class='col-lg-4'>
                    <h3>Código Generado</h3>
                    <div class='col-lg-4 parte' id="codigogenerado" style="height: 300px;width: 600px;background-color: #F0F0F0;border: 1px solid #575757;">
				    </div>
				</div>

<!-- Modal -->
<div class="modal fade" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4>Configuración</h4>
     </div>
     <div class="modal-body">
        <div class="row">
          <input id="idquien" name="idquien" type="hidden">
          <div class="col-sm-4">Tamaño Letra</div>
          <div class="col-sm-4"><input id="sizeletra" name="sizeletra" class="form-input" type="text"></div>
        </div>
        <div class="row">
          <div class="col-sm-4">Rotar</div>
          <div class="col-sm-4"><input id="rotarcampo" name="rotarcampo" type="checkbox"></div>
        </div>
        <div class="row">
          <div class="col-sm-4">Opciones</div>
          <div class="col-sm-4">
            <button onclick="editarcampo();" class="btn btn-success btn-sm">Editar</button>
            <button onclick="copiarcampo();" class="btn btn-primary btn-sm">Copiar</button>
          </div>
        </div>
     </div>
     <div class="modal-footer">
        <button onclick="guardar();" class="btn btn-success">Guardar</button>
        <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
     </div>
      </div>
   </div>
</div>

			</div>
		</div>
	</div>
</div>
</div>
<script>
var convertir = 49;
var punto = 0.1818;
	$(document).ready(function(){

    //$(".resizable").resizable();
    //$('.datosenc').resizable();


    //var convertir = 118;
   //var convertir = 28;

// target elements with the "draggable" class
		interact('.datosenc').draggable({
			// enable inertial throwing
			inertia: true,
			// keep the element within the area of it's parent
			restrict: {
			  restriction: "parent",
			  endOnly: true,
			  elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
			},
			// enable autoScroll
			autoScroll: true,

			// call this function on every dragmove event
			onmove: dragMoveListener,
			// call this function on every dragend event
			onend: function (event) {
			  /*var textEl = event.target.querySelector('p');

			  textEl && (textEl.textContent =
				'moved a distance of '
				+ (Math.sqrt(event.dx * event.dx +
							 event.dy * event.dy)|0) + 'px');*/
			}
		  }).resizable({
            // resize from all edges and corners
            edges: { left: false, right: true, bottom: true, top: false },

            // keep the edges inside the parent
            restrictEdges: {
              outer: 'parent',
              endOnly: true,
            },

            // minimum size
            restrictSize: {
              min: { width: 100, height: 20 },
            },

            inertia: true,
          }).on('resizemove', function (event) {
            var target = event.target,
                x = (parseFloat(target.getAttribute('data-x')) || 0),
                y = (parseFloat(target.getAttribute('data-y')) || 0);

            // update the element's style
            target.style.width  = event.rect.width + 'px';
            target.style.height = event.rect.height + 'px';

            // translate when resizing from top or left edges
            x += event.deltaRect.left;
            y += event.deltaRect.top;

            target.style.webkitTransform = target.style.transform =
                'translate(' + x + 'px,' + y + 'px)';

            target.setAttribute('data-x', x);
            target.setAttribute('data-y', y);
            /*target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height);*/
          });

		  function dragMoveListener (event) {
			var target = event.target,
				// keep the dragged position in the data-x/data-y attributes
				x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
				y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

            // translate the element
            var quien = target.id.substr(0,6);
            var tieneclaserotar = $( "#"+target.id ).hasClass( "rotated" );
            //console.log(tieneclaserotar+'rv');
            if(tieneclaserotar == true){
    			target.style.webkitTransform =
    			target.style.transform =
    			  'translate(' + x + 'px, ' + y + 'px)'+'rotate(-90deg)';
            }else{
    			target.style.webkitTransform =
    			target.style.transform =
    			  'translate(' + x + 'px, ' + y + 'px)';
            }

			// update the posiion attributes
			target.setAttribute('data-x', x);
			target.setAttribute('data-y', y);
		  }

		  // this is used later in the resizing and gesture demos
		  window.dragMoveListener = dragMoveListener;

		//VerDiseno();

        cargaBoleto();

	});

    function cargaBoleto(){

          $('#sizeenc').html(Math.round($('#ancho').val()) + '×' + Math.round($('#alto').val()) + ' cm');
    		interact('#divencabezado,#divcuerpo').draggable({
    			//onmove: window.dragMoveListener
    		}).resizable({
    			preserveAspectRatio: false,
    			edges: { left: false, right: true, bottom: true, top: false }
    		}).on('resizemove', function (event) {
    			var target = event.target,
    			x = (parseFloat(target.getAttribute('data-x')) || 0),
    			y = (parseFloat(target.getAttribute('data-y')) || 0);

    			// update the element's style
    			target.style.width  = event.rect.width + 'px';
    			target.style.height = event.rect.height + 'px';

    			// translate when resizing from top or left edges
    			x += event.deltaRect.left;
    			y += event.deltaRect.top;

    			target.style.webkitTransform = target.style.transform =
    				'translate(' + x + 'px,' + y + 'px)';

    			target.setAttribute('data-x', x);
    			target.setAttribute('data-y', y);
    			//target.textContent = Math.round(event.rect.width) + '×' + Math.round(event.rect.height);
    			if(target.getAttribute('id')=='divencabezado')
    				document.getElementById('sizeenc').innerHTML= Math.round(target.offsetWidth) + '×' + Math.round(target.offsetHeight);
		  });

        var anchocm = parseFloat($('#ancho').val());
        var altocm = parseFloat($('#alto').val());
        var anchoreal = anchocm*convertir;
        var altoreal = altocm*convertir;

        $('#divencabezado').css('width',anchoreal+'px');
        $('#divencabezado').css('height',altoreal+'px');

        $('#divencabezadover').css('width',anchoreal+'px');
        $('#divencabezadover').css('height',altoreal+'px');

    }

	function GuardarDiseno(){

        $('#divencabezadover').html('');

		var cadenadatos='';
		var count=0;
		var heightenc=parseFloat($('#divencabezado').css('height'));
		var widthenc=parseFloat($('#divencabezado').css('width'));

        var anchoboletoa = parseFloat($('#ancho').val());
        var altoboletoa = parseFloat($('#alto').val());
        var tambarra = parseFloat($('#tambarra').val());

        anchoboletoa = anchoboletoa * 10;
        altoboletoa = altoboletoa * 10;
        tambarra = tambarra * 10;

		$('.datosenc').each(function(){

            var idaux = $(this).attr('id');
            var idreal = idaux.substr(5);
            console.log(idreal);

			var top=parseFloat($(this).css('top'));
			var left=parseFloat($(this).css('left'));
            var width=parseFloat($(this).css('width'));
            var height=parseFloat($(this).css('height'));
            var fontsize=parseFloat($(this).css('font-size'));
			var seimprime=1;
			if($(this).css('display')=='none'){
				seimprime=0;
			}

            if(seimprime == 1){

                var esrotatedaux = $(this).hasClass('rotated');
                var esrotated = 0;

                var datoq = 'FONT';

                /*var yreal = (top/convertir)*punto;
                var xreal = (left/convertir)*punto;
                var wreal = (width/convertir)*punto;
                var hreal = (height/convertir)*punto;*/
                var yreal = (top)*punto;
                var xreal = (left)*punto;
                //var fonts = fontsize*2;
                var fonts = fontsize;
                if(esrotatedaux){
                    esrotated = 180;
                    var wreal = (height)*punto;
                    var hreal = (width)*punto;
                }else{
                    esrotated = 90;
                    var wreal = (width)*punto;
                    var hreal = (height)*punto;
                }

                var contenido = $('#camp'+idreal).html();

                if(idreal == 5){
                    cadenadatos+='CODE\\'+yreal+'\\'+xreal+'\\'+wreal+'\\'+hreal+'\\'+fonts+'\\'+esrotated+'\\0\\0\\Courier New\\'+contenido+'<br>';
                }else if(idreal == 8){
                    cadenadatos+='PCX\\'+yreal+'\\'+xreal+'\\'+wreal+'\\'+hreal+'\\'+fonts+'\\'+esrotated+'\\0\\0\\Courier New\\'+contenido+'<br>';
                }else{
                    cadenadatos+=datoq+'\\'+yreal+'\\'+xreal+'\\'+wreal+'\\'+hreal+'\\'+fonts+'\\'+esrotated+'\\0\\0\\Courier New\\'+contenido+'<br>';
                }

                }

			count++;
		});
		//cadenadatos+="@header_height||0||0||"+heightenc+'||0';
		//cadenadatos+="@header_width||0||0||"+widthenc+'||0';

		console.log(cadenadatos);
        var sizes = 'SIZE '+altoboletoa+' mm,'+anchoboletoa+' mm';
        var blines = 'BLINE '+tambarra+' mm,'+tambarra+' mm';
        var directions = 'DIRECTION 1,0';
        var refereces = 'REFERENCE 0,0';
        var anchoboleto = 'ancho$'+widthenc;
        var altoboleto = 'alto$'+heightenc;
        //var imagenpcx = 'PCX\\C:\Users\JeanPaul\Documents\ticketfacilnuevoformato\ImpresionTickets\bin\Debug\pcx\13_DE.PCX\\100\\100';
        $('#codigogenerado').html(sizes+'<br>'+blines+'<br>'+directions+'<br>'+refereces+'<br>'+anchoboleto+'<br>'+altoboleto+'<br>'+cadenadatos);
        var disenoimp = $('#codigogenerado').html();
        var disenoweb = $('#divencabezado').html();
        var id = $('#disbol').val();
        var nombdis = $('#nombdise').val();
		$.ajax({
		    type: "POST",
			url:'ajax/guardar.php',
			data:{disenoimp:disenoimp,disenoweb:disenoweb,id:id,nombdis:nombdis,altoboletoa:altoboletoa,anchoboletoa:anchoboletoa,tambarra:tambarra},
			success: function(response){
				//alert(response);
					$('.alert-info').html("Datos Grabados con éxito");
					$("#content" ).scrollTop(0);
					$('.alert-info').slideDown();
					setTimeout(function(){
						$('.alert-info').slideUp();
					},5000);
                location.href='?iddiseno='+response;
			}
		});
	}

	function VerDiseno(){
	    var anchocm = parseFloat($('#ancho').val());
        var altocm = parseFloat($('#alto').val());
        var anchoreal = anchocm*28;
        var altoreal = altocm*convertir;

        $('#divencabezado').css('width',anchoreal+'px');
        $('#divencabezado').css('height',altoreal+'px');
	}

	function VerQuitar(c){
		$('#icoquitar_'+c).fadeIn('fast');
	}

	function QuitarEquis(c){
		$('#icoquitar_'+c).fadeOut('fast');
	}

	function Quitar(que){
		$('#'+que).css('display','none');
		var html="<button id='add"+que+"' onclick='OtraVez("+'"'+que+'"'+");' type='button' class='btn btn-default btn-sm'>"+que+"</button>";
		$(html).appendTo('#elementscontainer');
	}

	function OtraVez(que){
		$('#'+que).css('display','');
		$('#add'+que).remove();
	}

    function verModal(quien){
        $('#idquien').val(quien.id);
        var fontsize = parseFloat($('#'+quien.id).css('font-size'));
        $('#sizeletra').val(fontsize);
        var rota = $('#'+quien.id).hasClass('rotated');
        if(rota){
            $('#rotarcampo').prop('checked',true);
        }else{
            $('#rotarcampo').prop('checked',false);
        }
        $('#modalConfig').modal('show');
    }

    function guardar(){
        var quien = $('#idquien').val();
        var fontsize = $('#sizeletra').val();
        var rotarcampo = $('#rotarcampo').prop('checked');
        $('#'+quien).css('font-size',fontsize+'px');
        if(rotarcampo){
            $('#'+quien).addClass("rotated");
        }else{
            $('#'+quien).removeClass("rotated");
        }
        $('#modalConfig').modal('hide');
    }

    function agregaeditor(){
        var variable = $('#variables').val();
        if($('#editor').val() == ''){
            $('#editor').val($('#editor').val()+variable+'|@|');
        }else{
            $('#editor').val($('#editor').val()+'|@|'+variable+'|@|');
        }
        $('#variables').val('');
    }

    function Agrega(){
        var ultimo = 0;
        var campos = [];
        $("#divencabezado div").each(function(){
            var res = $(this).attr('id').substring(5);
            campos.push(res);
   		});
        ultimo = Math.max.apply(null, campos);
        if(ultimo > 0){
            ultimo += 1;
        }else{
            ultimo = 1;
        }

        var nuevocampo = $('#editor').val();
        if(nuevocampo != ''){
            var valor = '"campo'+ultimo+'"';
            var campo = "<div id='campo"+ultimo+"' onmouseover='VerQuitar("+ultimo+");' onmouseleave='QuitarEquis("+ultimo+");' ondblclick='verModal(this);' data-key='Valores' class='datosenc' style='top:100px; left:250px;width: 150px;height: 30px;font-size: 10px;'><label  onclick='Quitar("+valor+");' class='glyphicon glyphicon-remove' id='icoquitar_"+ultimo+"'  style='color:red; display:none;'></label>&nbsp;<span id='camp"+ultimo+"'>"+nuevocampo+"</span></div>";
            $('#divencabezado').append(campo);
            $('#editor').val('');
        }
    }
function verconcierto(){
    var disenoweb = $('#divencabezado').html();
    var idCon = $('#conciertos').val();
    var idLoc = $('#localidades').val();
    var idDes = $('#descuentos').val();
		$.ajax({
		    type: "POST",
			url:'ajax/verdiseno.php',
			data:{disenoweb:disenoweb,idCon:idCon,idLoc:idLoc,idDes:idDes},
			success: function(response){
				//alert(response);
                $('#divencabezadover').html(response);

                var anchototal = parseFloat($('#ancho').val());
                var ancholineas = parseFloat($('#divencabezadover').css('width'));
                var separadorhorireal = (ancholineas / (anchototal * 2));
                var altolineas = parseFloat($('#divencabezadover').css('height'));
                var lineash = '';
                var separadorhori = 0;
                for(var k=0;k < ((anchototal*2)-1);k++){
                  separadorhori += separadorhorireal;
                  if(k == 0){
                    separadorhori += 13;
                  }
                  lineash += '<div style="width:1px;height:'+altolineas+';border-left:1px solid #E1E1E1;position:absolute;left:'+separadorhori+'px;z-index:0;"></div>';
                  //console.log(separadorhori);
                }
                $('#divencabezadover').append(lineash);

                var lineasv = '';
                var separadorver = 0;
                for(var j=0;j < ((anchototal*2)-1);j++){
                  separadorver += separadorhorireal;
                  lineasv += '<div style="width:'+ancholineas+';height:1px;border-bottom:1px solid #E1E1E1;position:absolute;top:'+separadorver+'px;z-index:0;"></div>';
                  //console.log(separadorver);
                }
                $('#divencabezadover').append(lineasv);

			}
		});
}
function verdisenob(){
    var idDis = $('#disbol').val();
    location.href='?iddiseno='+idDis;
}
function verlocalidad(){
    var idCon = $('#conciertos').val();
		$.ajax({
		    type: "POST",
			url:'ajax/verlocalidades.php',
			data:{idCon:idCon},
			success: function(response){
                $('#localidades').html(response);
			}
		});
}
function verdescuento(){
    var idCon = $('#conciertos').val();
    var idLoc = $('#localidades').val();
		$.ajax({
		    type: "POST",
			url:'ajax/verdescuentos.php',
			data:{idCon:idCon,idLoc:idLoc},
			success: function(response){
                $('#descuentos').html(response);
			}
		});
}
function editarcampo(){
    var quien = $('#idquien').val();
    var res = quien.substring(5);
    var contenido = $('#camp'+res).html();
    $('#editor').html(contenido);
    Quitar("campo4");
    $('#modalConfig').modal('hide');
    $("#editor").focus();
}
function copiarcampo(){
    var quien = $('#idquien').val();
    var res = quien.substring(5);
    var contenido = $('#camp'+res).html();
    $('#editor').html(contenido);
    Agrega();
    $('#modalConfig').modal('hide');
}
</script>
<!--<div id='campo1' onmouseover='VerQuitar(1);' onmouseleave='QuitarEquis(1);' ondblclick="verModal(this);" class='datosenc resizable' style='top:120px; left:130px;width: 130px;height: 20px;font-size: 10px;'><label  onclick='Quitar("campo1");' class='glyphicon glyphicon-remove' id='icoquitar_1'  style='color:red; display:none;'></label>&nbsp;<span id='camp1'>$|@|[Valor]|@| |@|[localidad]|@|</span></div>
								<div id='campo2' onmouseover='VerQuitar(2);' onmouseleave='QuitarEquis(2);' ondblclick="verModal(this);" class='datosenc'  style='top:20px; left:20px;width: 80px;height: 20px;font-size: 8px;'><label class='glyphicon glyphicon-remove' id='icoquitar_2'  style='color:red; display:none;' onclick='Quitar("campo2");'></label>&nbsp;<span id='camp2'>Cliente |@|[abr]|@|</span></div>
                                <div id='campo3' onmouseover='VerQuitar(3);' onmouseleave='QuitarEquis(3);' ondblclick="verModal(this);" class='datosenc'  style='top:140px; left:130px;width: 200px;height: 20px;font-size: 10px;'><label class='glyphicon glyphicon-remove' id='icoquitar_3'  style='color:red; display:none;' onclick='Quitar("campo3");'></label>&nbsp;<span id='camp3'>ACCESO |@|[puerta]|@| Blo: |@|[bloque]|@|     |@|[asientos]|@|</span></div>
                                <div id='campo4' onmouseover='VerQuitar(4);' onmouseleave='QuitarEquis(4);' ondblclick="verModal(this);" class='datosenc' style='top:160px; left:130px;width: 250px;height: 50px;font-size: 6px;'>
                                <label class='glyphicon glyphicon-remove' id='icoquitar_4' ondblclick="verModal(this);" style='color:red; display:none;' onclick='Quitar("campo4");'></label>&nbsp;
                                    <span id='camp4'>RUC: |@|[ruc_cliente]|@| |@|[lleva_cota]|@| |@|[Nombre]|@| Matriz: |@|[matriz_clie]|@| Suc: |@|[suc_cliente]|@| AUT-SRI: |@|[aut_sri_pro]|@| AUT-MUN: |@|[aut_mun_pro]|@|/|@|[Nombre]|@| |@|[Ruc]|@| |@|[TipoCont]|@| MUN: |@|[aut_mun_cli]|@| SRI: |@|[aut_sri_cli]|@| Emitidos: |@|[Desde]|@| VALIDEZ |@|[fechaA]|@| Al |@|[FechaC]|@| Documento Categorizado: |@|[docu]|@|</span>
                                </div>
                                <div id='campo5' onmouseover='VerQuitar(5);' onmouseleave='QuitarEquis(5);' ondblclick="verModal(this);" class='datosenc rotated'  style='top:110px; left:0px;font-size: 10px;width: 120px;height: 20px;'><label class='glyphicon glyphicon-remove' id='icoquitar_5'  style='color:red; display:none;' onclick='Quitar("campo5");'></label>&nbsp;<span id='camp5'>[codigo]|@|</span></div>
                                <div id='campo6' onmouseover='VerQuitar(6);' onmouseleave='QuitarEquis(6);' ondblclick="verModal(this);" class='datosenc rotated'  style='top:105px; left:25px;font-size: 10px;width: 110px;height: 20px;'><label class='glyphicon glyphicon-remove' id='icoquitar_6'  style='color:red; display:none;' onclick='Quitar("campo6");'></label>&nbsp;<span id='camp6'>Boleto: |@|[boleto]|@|</span></div>
                                <div id='campo7' onmouseover='VerQuitar(7);' onmouseleave='QuitarEquis(7);' ondblclick="verModal(this);" class='datosenc rotated'  style='top:90px; left:450px;width: 120px;height: 50px;font-size: 7px;text-align: left;'>
                                    <label class='glyphicon glyphicon-remove' id='icoquitar_7'  style='color:red; display:none;' onclick='Quitar("campo7");'></label>
                                    &nbsp;<span id='camp7'>Adm: |@|$|@|[valor_normal]|@|<br>
                                    Des: $|@|[valor_descuento]|@|<br>
                                    Imp: $|@|[impuesto]|@|<br>
                                    Tot: $|@|[valor_nominal]|@|</span>
                                </div>
                                <div id='campo8' onmouseover='VerQuitar(8);' onmouseleave='QuitarEquis(8);' ondblclick="verModal(this);" class='datosenc demo' style='top:20px; left:130px;width: 250px;height: 50px;font-size: 6px;'>
                                <label class='glyphicon glyphicon-remove' id='icoquitar_8'  style='color:red; display:none;' onclick='Quitar("campo8");'></label>&nbsp;
                                    <span id='camp8'>[Imagen]|@|</span>
                                </div>
                                <div id='campo9' onmouseover='VerQuitar(9);' onmouseleave='QuitarEquis(9);' ondblclick="verModal(this);" class='datosenc'  style='top:20px; left:550px;width: 80px;height: 20px;font-size: 8px;'><label class='glyphicon glyphicon-remove' id='icoquitar_9'  style='color:red; display:none;' onclick='Quitar("campo9");'></label>&nbsp;<span id='camp9'>Anfora |@|[abr]|@|</span></div>
                                <div id='campo10' onmouseover='VerQuitar(10);' onmouseleave='QuitarEquis(10);' ondblclick="verModal(this);" class='datosenc'  style='top:20px; left:700px;width: 100px;height: 20px;font-size: 8px;'><label class='glyphicon glyphicon-remove' id='icoquitar_10'  style='color:red; display:none;' onclick='Quitar("campo10");'></label>&nbsp;<span id='camp10'>Promotor |@|[abr]|@|</span></div>-->