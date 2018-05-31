<?php
$rv=time();
?>
<?php
$uploaddir = 'mapas/';
$uploadfile = $uploaddir.$rv;
$uploadfile2 = $rv.basename($_FILES['uploadfile']['name']);
$uploadfile = $uploaddir.$uploadfile2;
//$uploadfilesolo = basename($_FILES['uploadfile']['name']);
// Lo mueve a la carpeta elegida
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {
  echo $uploadfile2;
} else {
  echo "no se pudo subir";
}
?>