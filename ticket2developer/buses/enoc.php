<?php
  //$conexion = mysql_connect("localhost", "root", "zuleta99")or die(mysql_error());
$conexion = mysql_connect("localhost", "root", "zuleta99")or die(mysql_error());
  mysql_set_charset('UTF8',$conexion);
  mysql_select_db("bus_boleto", $conexion)or die(mysql_error());


?>

