<?php 

    session_start();
    include('../../../conexion.php');
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    $concert = $_REQUEST['concert'];
    $sql = "SELECT strDescripcionL, idLocalidad FROM Localidad WHERE idConc = ".$concert."";
    $res = mysql_query($sql);
?>
<input id="inputConcert" value="<?php echo $concert; ?>" type="hidden" name="">
<div style="background-color: white; color:black;" class="input_fields_wrap">
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Localidad</th>
            <th id="thDescuento" style="display: none;">Descuento</th>
            <th id="thCantidad" style="display: none;">Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
                <div class="row">
                    <div class="col-md-5">
                        <div class="ui-widget">
                            <label for="localidad">localidad: </label>
                            <input id="localidad">
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div id="hola" class="col-md-7"></div>
                        </div>
                    </div>
                    <div class="col-md-5 discounts">
                        <div id="div" class="ui-widget">
                            <label for="discounts">discounts: </label>
                            <input id="discounts">
                        </div>
                    </div>
                </div>
            </td>
            <td id="tdResults"></td>
            <td id="tdQuantity">
                <div class="row">
                    <div class="col-md-10">
                    </div>
                </div>
            </td>
          </tr>
        </tbody>
      </table>
</div>

<script type="text/javascript">
    $(function() {
        $('#localidad').on('keypress', function () {
            var concert = $('#inputConcert').val();
            var term = $('#localidad').val();
            $.ajax({
                method:'POST',
                url:'subpages/Facturas/includes/localidad_descuentos.php',
                data:{concert:concert, term:term},
                success: function (response) {
                    $('#hola').html(response);
                }
            })
        })
        /*
        var concert = $('#inputConcert').val();
        var div = $('#div');
        div.css('display','none');
        $( "#localidad").autocomplete({
            source: 'subpages/Facturas/includes/localidad_descuentos.php?id='+concert+''
        });
        $('#localidad').on('autocompletechange', function(event,ui) {
           alert($(this).val());
        });*/
    });
</script>