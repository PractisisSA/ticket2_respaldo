<?php
    require_once('private.db.php');
    $gbd = new DBConn();

	$idCon = $_REQUEST['idCon'];
    $idLoc = $_REQUEST['idLoc'];

    $selcon = "select * from descuentos where idcon = ".$idCon." and idloc = ".$idLoc." and est = 1";
    $sqlcon = $gbd -> prepare($selcon);
    $sqlcon -> execute();

?>
    <option value="0"></option>
    <?php
    foreach($sqlcon -> fetchAll(PDO::FETCH_ASSOC) as $keyricon => $valuericon){
    ?>
        <option value="<?php echo $valuericon['id'];?>"><?php echo '('.$valuericon['id'].') '.$valuericon['nom'];?></option>
    <?php
    }
    ?>