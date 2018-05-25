<?php
    // connection to server and database
    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

        try {
                //create a PDO object
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $username = $_POST['test'];
                $recipeID = $_POST['removeID'];
                $sql = $conn->prepare("DELETE FROM favourites WHERE user_id = $username AND recipe_id = $recipeID");
                $sql->execute();
                echo "recipe successfully removed";
        }
        catch(PDOException $e) {
        echo "<p style='color: red;'>From the SQL code: $sql</p>";
        $error = $e->getMessage();
        echo "<p style='color: red;'>$error</p>";
    }  

?>