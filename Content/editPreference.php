<?php 

    if (!isset($_SESSION)) {
        session_start();
    }

// connection to website
$servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

$userID = $_SESSION['u_first'];
// create a PDO object
try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$dblogin,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

   if(isset($_POST['create'])) {
       
 if(!empty($_POST['new_profile_name'])) {
            
            $sql = "SELECT * FROM profiles WHERE name = :value";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':value', $value);
            $value = $_POST['new_profile_name'];
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(sizeof($result) < 1) {
                $sql = "INSERT INTO profiles (user_id, name, serving) VALUES (:user, :prof, :serv)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':prof', $prof);
    $stmt->bindParam(':serv', $serv);

    $user = $userID;
    $prof = $_POST['new_profile_name'];
    $serv = $_POST['new_serving'];
    $stmt->execute();
            } else {
            header("Location: http://preppy.fun/index.php?page=acc.php");
            
                echo "<script>alert(\"no\");</script>";
            }

        }
    } else if(isset($_POST['update'])) {
    $sql = "UPDATE profiles SET serving = :serv WHERE name = :prof";
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

    $sql = "DELETE FROM profiles WHERE name = :prof AND user_id = :user";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':prof', $prof);

    $user = $userID;
    $prof = $_POST['delete'];

    $stmt->execute();
}
} catch (PDOException $ex) {
    die($ex->getMessage());
}

header("Location: http://preppy.fun/index.php?page=acc.php");
?>
