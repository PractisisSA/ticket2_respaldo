<?php 

	session_start();
    //database configuration
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = 'zuleta99';
    $dbName = 'ticket';
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	$localidad = $_GET['id'];
    $db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
    
    $searchTerm = $_GET['term'];
    
    $query = $db->query("SELECT * FROM Localidad WHERE strDescripcionL LIKE '%".$searchTerm."%' AND idConc = ".$concert."");
    $rowCount = $query->num_rows;
  
    while ($row = $query->fetch_assoc()) {
        $data = $row['strDescripcionL'];
    }
    echo $data;
?>
	