<?php
    // $data = file_get_contents("php://input");
    // $decodedData=base64_decode($data);
    // $fic_name = 'snapshot'.rand(1000,9999).'.png';
    // $fp = fopen('fotosCanje/'.$fic_name, 'wb');
    // $ok = fwrite( $fp, $decodedData);
    // fclose( $fp );
    // if($ok)
        // echo $fic_name;
    // else
        // echo "ERROR";
		
    /* saveFile.php */
    //Obtener variable POST e desemcriptarla
    $img = $_POST['data'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $im = imagecreatefromstring($data);  //convertir text a imagen
    if ($im !== false) {
		$fotoGrardada = 'screen'.rand(1000,9999).'.jpg';
        imagejpeg($im, 'fotosCanje/'.$fotoGrardada.''); //guardar a server 
        imagedestroy($im); //liberar memoria  
        echo $fotoGrardada;
    }else {
        echo 0;    
    }
	?>