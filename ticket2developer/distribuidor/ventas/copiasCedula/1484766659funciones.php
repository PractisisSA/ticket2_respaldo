<?php
ini_set('memory_limit','50M');
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$ftp_server="65.60.22.72";
$ftp_user_name="sigarinconacadem";
$ftp_user_pass="A(Q@Gz2H^G0e";
$file = "ftp://Mongrel_Prod:TINlMJgqW0TE@188.95.6.39/out/MNG_OrderConfirmation_138987535_20161212.txt";//tobe uploaded
$remote_file = "public_html/envios/copia_claves.txt";

// set up basic connection
$conn_id = ftp_connect($ftp_server,21);

// login with username and password
if($login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)){
	echo'conectado<br>';
}else{
	echo'no conectado';
}
ftp_pasv ($conn_id, true);
$archivo = fopen ("".$file."", "r");
if (!$archivo) {
echo "<p>No puedo abrir el archivo para lectura</p>";
exit;
}
$texto="";
while ($linea = fgets($archivo,1024)) {
   if ($linea) $texto .= $linea;
}
echo $texto;
fclose ($archivo);

// upload a file
// if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
    // echo "successfully uploaded $file\n";
    // exit;
// } else {
    // echo "There was a problem while uploading $file\n";
    // exit;
    // }
// // close the connection
ftp_close($conn_id);
?>