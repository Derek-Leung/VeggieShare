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
  <link rel="stylesheet" type="text/css" href="css/recipebootstrap.min.css" />
  <link href='https://fonts.googleapis.com/css?family=Pacifico:400' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/Style.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"  />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">
  <link rel="stylesheet" type="text/css" href="css/recipeStyle.css" />
  <script charset="utf-8" src="js/recipebootstrap.min.js"></script> 
  <script charset="utf-8" src="js/wow.min.js"></script>
  <script charset="utf-8" src="js/scripts.js"></script>
  <script src="js/RandomRecipeFunctions.js"></script>
  <script src="js/SearchRecipeFunctions.js"></script>

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
					<a class="navbar-brand logo" href="SearchPage.html"  onclick='createView("SearchPage.html", true); return false;'><span class= "fa fa-search"></span></a>
          <a class="navbar-brand logo" href="index.php">Preppy</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
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
                echo '<li><a href="?myFavourite.html"  onclick=\'getFavourites(); return false;\'>My favourites</a></li>';
            }
              
            ?>  
          </ul>
            <?php
            if (isset($_SESSION['u_first'])) {
            echo "<form action ='logout.php' method = 'POST'>
                <button type = 'submit' name = 'submit'>Logout</button>
              </form>";
            }
            ?>
                
        </div>
      </div>
    </nav>
    <div id="contentArea">
    </div>
	<script>
// 			var getJS = "./js/RandomRecipeFunctions.js";
// 			$.getScript(getJS);
        var userID = <?php 
            if(isset($_SESSION['u_first'])) {
                echo $_SESSION['u_first'];
              }  else {
                echo -1;
              }
                ?>;
        console.log(userID);
		var amp = "&";
    	var url = window.location.href;
    	if (url.indexOf("Steps.html" + amp) != -1){
    		var recipeIdEntered = url.split(amp);
    		getSearchStep(recipeIdEntered[1]);
    		console.log(recipeIdEntered[1]);
    	} else{
    		$("#contentArea").load("main.html");
    		history.pushState("main.html", "Main", '?page=main.html');
    	}
		  function createView(link, pushHistory) {
            get(link);
            if (pushHistory)  { 
              history.pushState(link, link, '?page='+link);
             }
        }
    
        window.onpopstate = function(event) {
          console.log(event.state);
          if(event.state.includes("Recipe.html&")){
							var content = "";

							for (var i=0; i < recipeData.root.body.recipes.length; i++){
								content += "<div id=\"breakfast\" class=\"container-fluid\">";  
								content += "<a onclick=\"getRecipeStep(" + recipeData.root.body.recipes[i].id + ")\"><img class=\"img-responsive\" src=\"" + recipeData.root.body.recipes[i].image + "\"/></a></td></tr>";
								content += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + recipeData.root.body.recipes[i].title + "</h2>";
								content += "</div></a></div>";
							}

							$("#contentArea").html(content);
							createView("Recipe.html&" + recipeData.root.body.recipes[0].id + "&" + recipeData.root.body.recipes[1].id + "&" + recipeData.root.body.recipes[2].id + "&" + recipeData.root.body.recipes[3].id + "&" + recipeData.root.body.recipes[4].id, true);

							
          } else if(event.state.includes("Search.html&")){
              var searchcontent = "";
              for (var i=0; i < searchData.root.body.results.length; i++){
                      searchcontent += "<div id=\"breakfast\" class=\"container-fluid\">";  
                      searchcontent += "<a onclick=\"getSearchStep(" + searchData.root.body.results[i].id + ")\"><img class=\"img-responsive\" src=\"" + searchData.root.body.baseUri + searchData.root.body.results[i].image + "\"/></a></td></tr>";
                      searchcontent += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + searchData.root.body.results[i].title + "</h2>";
                      searchcontent += "</div></a></div>";
                    }
						
						$("#contentArea").html(searchcontent);
						searchString = "Search.html&";
						for (q = 0; q < searchData.root.body.results.length - 1;q++){
						    searchString += searchData.root.body.results[q].id + "&";
						}
						searchString += searchData.root.body.results[searchData.root.body.results.length-1].id;
                        createView(searchString, true);
          } else {
           		createView(event.state, false);

		}
        };
      function getFavourites(){
          console.log("called");
                $.ajax({
                    url: "getFavorites.php",
                    data: {test:userID},
                    dataType: "json",
                    type: "POST",
                    success: function(data) {
                        
                        var fav = "";
                        fav += "<div id=\"breakfast fav-container\" class=\"container-fluid\">";  
                        fav += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>Favourites</h2>";
                        fav += "</div>";
                        fav += "<table><tr><th>Favourites</th></tr>";
                        for (var y = 0; y < data.person.length; y++){
                            console.log(data.person[y].recipe_image);
                          fav += '<tr><td>' + data.person[y].recipe_name;
                          fav += "</td><td><a href=\"http://preppy.fun/?page=Steps.html&"  + data.person[y].recipe_id + "\"><img src=" + data.person[y].recipe_image + "></a>";
                          fav += "</td></tr>";
                        }
                        fav += "</table>";
                        $("#contentArea").html(fav);
                    }
                });
         }

      function get(url){
        $("#contentArea").load(url);
      }
      $('.navbar-collapse a').click(function(){
        $(".navbar-collapse").collapse('hide');
      });
	</script>
	
	
	<!--<script charset="utf-8" src="js/jquery-3.3.1.min.js"></script>-->
  </body>
</html>