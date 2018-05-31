<?php
error_reporting(0);
  $conexion = mysql_connect("localhost", "root", "zuleta99")or die(mysql_error());
  mysql_set_charset('UTF8',$conexion);
  mysql_select_db("ticket", $conexion)or die(mysql_error());
?>

