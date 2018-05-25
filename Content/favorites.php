<?php
//connection to database
    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";
    
        try {
                //create PDO object
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);

                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $recipeID = $_POST['recipeID'];
                $userID =  $_POST['test'];
                    // check is user is logged in
                    if ($_POST['test'] == -1) {
                    echo "Please log in to save a recipe";
                    exit();
                }
                $recipeName = $_POST['recipeName'];
                $recipeImage = $_POST['recipeImage'];
                //check if recipe has been saved already
                $sql = $conn->prepare("SELECT COUNT(*) AS `total` FROM favourites WHERE recipe_id = ?");
                $sql->execute(array($recipeID));
                $result = $sql->fetchObject();
                
                if ($result->total < 1) {
                
                $sql = $conn->prepare("INSERT into favourites (user_id, recipe_id, recipe_name, recipe_image) VALUES ('$userID','$recipeID','$recipeName','$recipeImage')");
                $sql->execute(); 
                    echo 'Recipe has been saved!';
                    
                } else {
                    echo 'Recipe has been saved previously!';
                }
        }   
        catch(PDOException $e) {
        echo "<p style='color: red;'>From the SQL code: $sql</p>";
        $error = $e->getMessage();
        echo "<p style='color: red;'>$error</p>";
    }  
    


?>