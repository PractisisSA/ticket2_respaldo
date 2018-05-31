<?php 
$timeRightNow = time();
$url = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode=123456789123456789';
$img = 'barcode/'.$timeRightNow.'.png';
file_put_contents($img, file_get_contents($url));
?>