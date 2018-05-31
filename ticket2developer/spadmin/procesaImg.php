<?php
session_start();
include '../conexion.php';

$id_evento = $_SESSION['id_evento'];
$rv=time();

$uploaddir = 'img_conciertos/';
$uploadfile = $uploaddir.$rv;
$uploadfile2 = $rv.basename($_FILES['uploadfile']['name']);
$uploadfile = $uploaddir.$uploadfile2;
//$uploadfilesolo = basename($_FILES['uploadfile']['name']);
// Lo mueve a la carpeta elegida
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
  echo 'img_conciertos/'.$uploadfile2;
  
  $sql = 'update vendidos_x_evento set foto = "spadmin/img_conciertos/'.$uploadfile2.'" where idcon = "'.$id_evento.'" ';
  $res = mysql_query($sql) or die (mysql_error());
  
} else {
  echo "no se pudo subir";
}
?>
