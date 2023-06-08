<?php
include_once('variables.php');
$conn = "";
$conn2 = "";

try {
    $servername = "localhost:3306";
    $dbname = "txsxekgr_intranet";
    $username = "txsxekgr_controlweb";
    $password = "WoZra-h#G+Q{Aq]Ijo";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

try {
    $servername = "localhost:3306";
    $dbname = "txsxekgr_esinec";
    $username = "txsxekgr_controlweb";
    $password = "WoZra-h#G+Q{Aq]Ijo";
   
    $conn2 = new PDO(
        "mysql:host=$servername; dbname=$dbname;charset=utf8",
        $username, $password
    );
      
    $conn2->setAttribute(PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION);
      
} catch(PDOException $e) {
    echo "Connection failed: " 
        . $e->getMessage();
}

?>