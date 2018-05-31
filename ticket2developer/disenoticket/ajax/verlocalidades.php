<?php
    require_once('private.db.php');
    $gbd = new DBConn();

	$idCon = $_REQUEST['idCon'];

    $selcon = "select * from Localidad where idConc = ".$idCon;
    $sqlcon = $gbd -> prepare($selcon);
    $sqlcon -> execute();

?>
    <option value="0"></option>
    <?php
    foreach($sqlcon -> fetchAll(PDO::FETCH_ASSOC) as $keyricon => $valuericon){
    ?>
        <option value="<?php echo $valuericon['idLocalidad'];?>"><?php echo '('.$valuericon['idLocalidad'].') '.$valuericon['strDescripcionL'];?></option>
    <?php
    }
    ?>