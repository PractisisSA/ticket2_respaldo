<?php

include 'conexion.php';

$data = $_REQUEST['deposit'];
$id = $_REQUEST['id'];

$sql = 'UPDATE cierre SET num = "'.$data.'" WHERE id = "'.$id.'"';
$res = mysql_query($sql);

if ($res) {
	echo 1;
}else{
	echo 2;
}

?>