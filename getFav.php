<?php
    
    if (!isset($_SESSION)) {
        session_start();
    }

$servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

$userfirst = $_SESSION['u_first'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$dblogin,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
} catch (PDOException $ex) {
    die($ex->getMessage());
}

//QUERY
$sql1 = "SELECT * FROM profiles WHERE user_uid = "."$userfirst";

$result = $conn->prepare($sql1);
$result->execute();
$fetch = array();
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $fetch ["profiles"][] = $row;
}

echo json_encode($fetch);


?>
