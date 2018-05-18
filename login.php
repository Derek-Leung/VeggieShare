<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['submit'])) {
    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);
        $uid = $_POST['uid'];
        $pwd = $_POST['pwd'];
        $sql = $conn->prepare("SELECT COUNT(*) AS `total` FROM users WHERE user_uid = ?");
        $sql->execute(array($uid));
        $result = $sql->fetchObject();
        if ($result->total < 1) {
             echo "<script>
                    alert('Username/Password incorrect!');
                    window.location.href='loginform.html';
                    </script>";
        }   else 
            $sql = $conn->prepare("SELECT * FROM users WHERE user_uid = ?");
            $sql->execute(array($uid));
            $row = $sql->fetch();
            $hashedPwd = password_verify($pwd, $row['user_pwd']);
            if ($hashedPwd == false) {
                 echo "<script>
                    alert('Username/Password incorrect!');
                    window.location.href='loginform.html';
                    </script>";
            } else if ($hashedPwd == true) {
                $_SESSION['u_first'] = $row['user_id'];
                    echo "<script>
                    alert('Sign in success!');
                    window.location.href='index.php';
                    </script>";
            }
        }
    
     catch(PDOException $e) {
        echo "<p style='color: red;'>From the SQL code: $sql</p>";
        $error = $e->getMessage();
        echo "<p style='color: red;'>$error</p>";
    } 
    
}