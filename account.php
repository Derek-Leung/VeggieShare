<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// redirect to signin page
if (!isset($_SESSION['uid']) && (!isset($_SESSION['u_first']))) {
    header("Location: loginform.html");
}

$servername = "xray.gendns.com";
$dblogin = "preppyfu_admin";
$password = "adminadmin";
$dbname = "preppyfu_2910";

$conn = mysqli_connect($servername, $dblogin, $password, $dbname);

// retrieve user info from db and store in sessions
$sql = "SELECT * FROM users WHERE user_uid = '$uid' ";
$result = mysqli_query($conn, $sql);
    if (!empty($result)) {
        $row = mysqli_fetch_assoc($result);
        
        $firstName = $row['user_first']; 
        $lastName = $row['user_last']; 
        $email = $row['user_email']; 
        
    } else {
        header("Location: loginform.html");
    }

?>

<!DOCTYPE html>
<html>
<head>
    
</head>
<body>

    <div id='account_info'>
        <h1>WELCOME <?php echo $id; ?></h1>
    </div>

    <div id='profiles'>
        <h2>Profiles</h2>
        
    <?php 
    
//display profiles 
        $sql = "SELECT * FROM profiles WHERE user_uid = '".$uid."'";
        $result = mysqli_query($conn, $sql);
        if(!empty($result)) {
            while(!empty($row = mysqli_fetch_assoc($result))) {
                echo "<p>".$row['p_id']."</p>
                <form action='' method='post'>
                <input type = 'number' name = '".$row['p_id']."'  min='0.5' max='3' step='0.05' value = '".$row['serving']."'>";
            }
            echo "<input type = 'submit' name = 'update' value = 'update'>
            </form>";

        } else {
            echo "no profiles";
        }
        header("Location: account.php");

//update profiles
        if(isset($_POST['update'])) {
            $sql = "SELECT * FROM profiles WHERE user_uid = '$uid'";
            $result = mysqli_query($conn, $sql);
            if(!empty($result)) {
                while(!empty($row = mysqli_fetch_assoc($result))) {
                    $change = $row['p_id'];
                    $newServing = $_POST[$change];

                    $sql = "UPDATE profiles SET serving = '".$newServing."' 
                    WHERE user_uid = '".$uid."' AND p_id = '". $change ."'";
                    mysqli_query($conn, $sql);
                }
                header("Location: account.php");
            } else {
                echo "error";
            }
        }
        
//delete profiles 
        if(isset($_POST['delete'])) {
            $sql = "SELECT * FROM profiles WHERE user_uid = '$uid'";
            $result = mysqli_query($conn, $sql);
            if(!empty($result)) {
                while(!empty($row = mysqli_fetch_assoc($result))) {
                    $change = $row['p_id'];
                    $newServing = mysqli_real_escape_string($conn, $_POST[$change]);

                    $sql = "DELETE FROM profiles  
                    WHERE user_uid = '".$uid."' AND p_id = '". $change ."'";
                    mysqli_query($conn, $sql);
                }
                header("Location: account.php");
            } else {
                echo "error";
            }
        }
    ?>
    

    </div>

<!-- create new profile -->
    <div id="new_profile">
        <form action="" method="post">
            <input type="text" name="name">
            <input type="number" name="servingSize" min='0.5' max='3' step='0.05' value ='1.0'>
            <input type="submit" name="create" value="create">
        </form>
    </div>

    <?php if(isset($_POST["create"])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $servingSize = mysqli_real_escape_string($conn, $_POST['servingSize']);
        $sql = "INSERT INTO profiles (user_uid, p_id, serving) 
        VALUES ('$uid','$name', '$servingSize')";
        mysqli_query($conn, $sql);
        header("Location: account.php");
        }
    ?>

<!-- display favourites -->
    <div id='favourite'>
<h2>My Favourites</h2>
<?php 

$sql = "SELECT * FROM favourites WHERE user_uid = '$uid' ";
    $result = mysqli_query($conn, $sql);
    if (!empty($result)) {
        while($row = mysqli_fetch_assoc($result)) {

            echo $row['recipeID'];      //write code to display images from api
        
        }
    } else {
        echo "0 favourites";
    }

?>
    </div>
</body>
</html>