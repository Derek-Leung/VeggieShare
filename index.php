<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Preppy</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/signLogStyle.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/recipebootstrap.min.css" />
    <link href='https://fonts.googleapis.com/css?family=Pacifico:400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/Style.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"  />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/recipeStyle.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script charset="utf-8" src="js/recipebootstrap.min.js"></script> 
    <script charset="utf-8" src="js/wow.min.js"></script>
    <script charset="utf-8" src="js/scripts.js"></script>
    <script src="js/RandomRecipeFunctions.js"></script>
    <script src="js/SearchRecipeFunctions.js"></script>
    <script src="js/basicWebsiteFunctions.js"></script>
    <script src="js/favouritesRecipeFunctions.js"></script>

</head>
<body>
	<!-- Nav bar-->
	<nav class="navbar navbar-inverse" class="navbar static top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                     
                </button>
                
                <?php  
                    if (isset($_SESSION['u_first'])) {
                        echo '<a class = "navbar-brand logo" href="acc.php"  onclick="createView(\'acc.php\', true); return false;"><i class = "material-icons">settings</i></a>';
                    } 
                ?> 
                
				<a class="navbar-brand logo" href="SearchPage.html"  onclick='createView("SearchPage.html", true); return false;'><span class= "fa fa-search"></span></a>
                <a class="navbar-brand logo" href="index.php">Preppy</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="FAQ.html"  onclick='createView("FAQ.html", true); return false;'>FAQ</a></li>
                    <li><a href="?Recipe.html"  onclick='getFoodCategory(); return false;'>Recipe</a></li>
                    <li><a href="About.html" onclick='createView("About.html", true); return false;'>About Us</a></li>
                    
                    <?php 
                     if (!isset($_SESSION['u_first'])) {
                         echo '<li><a href="signupform.html" onclick="createView(\'signupform.html\', true); return false;">Sign up</a></li>';
                     }
                     if (!isset($_SESSION['u_first'])) {
                         echo '<li><a href="loginform.html" onclick="createView(\'loginform.html\', true); return false;">Log in</a></li>';
                     }
                    ?>
                    
                    <?php  
                    if (isset($_SESSION['u_first'])) {
                        echo '<li><a href="?myFavourite.html"  onclick=\'getFavourites(); return false;\'>My Favourites</a></li>';
                    } 
                    ?>  
                    
                    <?php
                    if (isset($_SESSION['u_first'])) {
                    echo "<li><form style = 'margin-top: 3px' action ='./Content/logout.php' method = 'POST'>
                        <button style='font-size:10px' class = 'btn' type = 'submit' name = 'submit'><i class = 'fa fa-sign-out'></i></button>
                      </form></li>";
                    }
                    ?>
                </ul>     
            </div>
        </div>
    </nav>
    <div id="contentArea">
    </div>
    <script>
    
        //Sets the user ID if a user is logged in
        var userID = <?php if(isset($_SESSION['u_first'])) {echo $_SESSION['u_first'];} else {echo -1;}?>;
        
        //Checks for what url is entered and sets the page accordingly
        if (url.indexOf("Steps.html" + amp) != -1){
    	    var recipeIdEntered = url.split(amp);
    	    getSearchStep(recipeIdEntered[1]);
        } else if (url.indexOf("?page=acc.php") != -1){
    	    $("#contentArea").load("acc.php");
        } else if (url.indexOf("loginfailed.html") != -1){
            createView("loginform.html", true);
            alert("Username/Password incorrect!");
        }else {
    	    $("#contentArea").load("main.html");
    	    history.pushState("main.html", "Main", '?page=main.html');
        }
    </script>
	
</body>
</html>