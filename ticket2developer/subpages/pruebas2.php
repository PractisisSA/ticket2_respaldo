<?php

include '../conexion.php';
$evento_reimprime = $_REQUEST['e'];
$local = $_REQUEST['l'];
$desdeact = $_REQUEST['d'];
$hastaact  = $_REQUEST['h'];

$consult = 'SELECT idBoleto, serie_localidad, strEstado as estado from Boleto where idCon = "'.$evento_reimprime.'" and idLocB = "'.$local.'" AND `serie_localidad` >= "'.$desdeact.'" AND serie_localidad <= "'.$hastaact.'"';
$res1 = mysql_query($consult) or die (mysql_error());
$a;
$b;
$c;
$d;

while ($rowres = mysql_fetch_array($res1)) {
    $boletos = $rowres['idBoleto'];
    $consu = 'SELECT count(barcode) as cuantos FROM reimpresio_boleto WHERE barcode = '.$boletos.'';
    $consures = mysql_query($consu);
    $row1 = mysql_fetch_array($consures);


    $consu1 = 'SELECT serie_localidad, idBoleto FROM Boleto WHERE idBoleto = '.$boletos.' AND idLocB = '.$local.'';
    $consures1 = mysql_query($consu1);


    if ($row1['cuantos'] != 0) {
        while ($rowcon = mysql_fetch_array($consures1)) {
            $a = $a.",".$rowcon['serie_localidad'];
            $c = $c.",".$rowcon['idBoleto'];
        }
    }else{
        $b = $b.",".$rowres['serie_localidad'];
        $d = $d.",".$rowres['idBoleto'];
    }
    
}
if ($a == '') {
    echo 1;
}else{
    echo "<div id=''> Estos boletos se encuentran reimpresos:".$a." <span id='num-boletos-2' style='color:transparent'>".$c."</span></div>";
    echo "<div id='' style=''>Estos no: ".$b."<span id='no-reimpresos-2' style='color:transparent'>".$d."</span></div>";
}
?>