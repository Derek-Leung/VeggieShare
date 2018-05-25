<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['submit'])) {
    // connection to server and database
    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

        try {
        // creating a PDO object
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);
        $uid = $_POST['uid'];
        $pwd = $_POST['pwd'];
        $sql = $conn->prepare("SELECT COUNT(*) AS `total` FROM users WHERE user_uid = ?");
        $sql->execute(array($uid));
        $result = $sql->fetchObject();
        if ($result->total < 1) {
            header("Location:http://preppy.fun/?page=loginfailed.html");
        }   else 
            $sql = $conn->prepare("SELECT * FROM users WHERE user_uid = ?");
            $sql->execute(array($uid));
            $row = $sql->fetch();
            // verify that the password is correct by comparing it to the hashed password
            $hashedPwd = password_verify($pwd, $row['user_pwd']);
            if ($hashedPwd == false) {
            header("Location:http://preppy.fun/?page=loginfailed.html");
            } else if ($hashedPwd == true) {
                // log in success, set session variables for usage
                $_SESSION['u_first'] = $row['user_id'];
                    echo "<script>
                    alert('Sign in success!');
                    window.location.href='../index.php';
                    </script>";
            }
        }
    
     catch(PDOException $e) {
        echo "<p style='color: red;'>From the SQL code: $sql</p>";
        $error = $e->getMessage();
        echo "<p style='color: red;'>$error</p>";
    } 
    
}