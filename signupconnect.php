<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['submit'])) {
    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

    if(isset($_POST["first"]) && !empty($_POST["first"])
        && isset($_POST["last"]) && !empty($_POST["last"])
        && isset($_POST["email"]) && !empty($_POST["email"])
        && isset($_POST["uid"]) && !empty($_POST["uid"])
        && isset($_POST["pwd"]) && !empty($_POST["pwd"])) {
        
    
        
        try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);


                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $first = $_POST["first"];
                $last = $_POST["last"];
                $email = $_POST["email"];
                $uid = $_POST["uid"];
                $pwd = $_POST["pwd"];
                $sql = $conn->prepare("SELECT COUNT(*) AS `total` FROM users WHERE user_uid = ?");
                $sql->execute(array($uid));
                $result = $sql->fetchObject();

                if ($result->total < 1) {
                    $hashedPass = password_hash($pwd, PASSWORD_DEFAULT);
                    $sql = $conn->prepare("INSERT into users (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first','$last','$email','$uid','$hashedPass')");
                    $sql->execute();
                    $sql = $conn->prepare("SELECT * FROM users WHERE user_uid = ?");
                    $sql->execute(array($uid));
                    $row = $sql->fetch();
                    $_SESSION['u_first'] = $row['user_id'];
                     echo "<script>
                    alert('Sign up success!');
                    window.location.href='index.php';
                    </script>";
                    
                } else {
                    echo "<script>
                    alert('Username already exists. Please try again.');
                    window.location.href='signupform.html';  
                    </script>";
                }
        }
        catch(PDOException $e) {
        echo "<p style='color: red;'>From the SQL code: $sql</p>";
        $error = $e->getMessage();
        echo "<p style='color: red;'>$error</p>";
    }  
    }
}

?>