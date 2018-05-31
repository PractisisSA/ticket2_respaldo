<?php
    require_once('private.db.php');
    $gbd = new DBConn();

    $disenoimp = $_REQUEST['disenoimp'];
	$disenoweb = $_REQUEST['disenoweb'];
	$id = $_REQUEST['id'];
    $nombdis = $_REQUEST['nombdis'];
    $altoboletoa =(float) $_REQUEST['altoboletoa'];
    $anchoboletoa =(float) $_REQUEST['anchoboletoa'];
    $tambarra =(float) $_REQUEST['tambarra'];

	try{
	    if($id == 0){
            $update = "insert into disenoticket (ticket,disenoweb,disenoimp,ancho_boleto,alto_boleto,tam_barra) values(?,?,?,?,?,?)";
    		$sql = $gbd -> prepare($update);
    		$sql -> execute(array($nombdis,$disenoweb,$disenoimp,$anchoboletoa,$altoboletoa,$tambarra));
            $rows = $sql -> fetch(PDO::FETCH_ASSOC);

            $sel1 = "select id from disenoticket order by id desc limit 1";
            $sql1 = $gbd -> prepare($sel1);
            $sql1 -> execute();
            $rows = $sql1 -> fetch(PDO::FETCH_ASSOC);
            echo $rows['id'];
	    }else{
    		$update = "UPDATE disenoticket SET ticket = ?, disenoweb = ?, disenoimp = ?, ancho_boleto = ?, alto_boleto = ?,tam_barra = ? WHERE id = ?";
    		$sql = $gbd -> prepare($update);
    		$sql -> execute(array($nombdis,$disenoweb,$disenoimp,$anchoboletoa,$altoboletoa,$tambarra,$id));
            echo $id;
        }
	}catch(PDOException $e){
		print_r($e);
	}
?>