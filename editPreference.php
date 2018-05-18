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

   if(isset($_POST['create'])) {
//     $newname = $_POST['new_profile_name'];

// $sql = $conn->prepare("SELECT COUNT(*) AS `total` FROM profiles WHERE p_id = ?");
//                 $sql->execute(array($newname));
//                 $result = $sql->fetchObject();

//                 if ($result->total > 0) {
//                     echo "alrdy exist";}
//                 // } else {
                  
        
    $sql = "INSERT INTO profiles (user_uid, p_id, serving) VALUES (:user, :prof, :serv)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':prof', $prof);
    $stmt->bindParam(':serv', $serv);

    $user = $userfirst;
    $prof = $_POST['new_profile_name'];
    $serv = $_POST['new_serving'];
    $stmt->execute();
    
    } else if(isset($_POST['update'])) {
    $sql = "UPDATE profiles SET serving = :serv WHERE p_id = :prof";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':prof', $prof);
    $stmt->bindParam(':serv', $serv);

    $profs = $_POST['profiles'];
    $servs = $_POST['servings'];

    for ($i = 0; $i < sizeof($profs); $i++) {

        $prof = $profs[$i];
        $serv = $servs[$i];
        $stmt->execute();
    }

}

if(isset($_POST['delete'])) {

    $sql = "DELETE FROM profiles WHERE p_id = :prof AND user_uid = :user";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':prof', $prof);

    $user = $userfirst;
    $prof = $_POST['delete'];

    $stmt->execute();
}
} catch (PDOException $ex) {
    die($ex->getMessage());
}

header("Location: acc.php");
?>
