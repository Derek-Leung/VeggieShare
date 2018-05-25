<?php
    // connection to server and database
    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";
    
    
        try {
                // create a PDO object
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $username = $_POST['test'];
                // select all favorited recipes corresponding to the user
                $sql = $conn->prepare("SELECT * FROM favourites WHERE user_id = ?");
                $sql->execute(array($username));
                $data = array("person" => $sql->fetchAll(PDO::FETCH_ASSOC));
                $json = json_encode($data);
                echo $json;
        }

        catch(PDOException $e) {
        echo "<p style='color: red;'>From the SQL code: $sql</p>";
        $error = $e->getMessage();
        echo "<p style='color: red;'>$error</p>";
    }  
    

?>