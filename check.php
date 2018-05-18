<?php
    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

        try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $username = $_POST['username'];
                $sql = $conn->prepare("SELECT COUNT(*) AS `total` FROM users WHERE user_uid = ?");
                $sql->execute(array($username));
                $result = $sql->fetchObject();
                if ($result->total < 1) {
                    echo "0";       
                } else {
                    echo "1";
                }
            
        }
        catch(PDOException $e) {
        echo "<p style='color: red;'>From the SQL code: $sql</p>";
        $error = $e->getMessage();
        echo "<p style='color: red;'>$error</p>";
        }  
?>