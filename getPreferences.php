<?php

    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

        try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $username = $_POST['test'];
                $sql = $conn->prepare("SELECT * FROM profiles WHERE user_id = ?");
                $sql->execute(array($username));
                $data = array("profile" => $sql->fetchAll(PDO::FETCH_ASSOC));
                $json = json_encode($data);
                echo $json;          

        }
        catch(PDOException $e) {
        echo "<p style='color: red;'>From the SQL code: $sql</p>";
        $error = $e->getMessage();
        echo "<p style='color: red;'>$error</p>";
    }  

?>