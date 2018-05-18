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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                echo '<li><a href="?myFavourite.html"  onclick=\'getFavourites(); return false;\'>My Favourites</a></li>';
            } 
            
              
            ?>  
          
            <?php
            if (isset($_SESSION['u_first'])) {
            echo "<li><form style = 'margin-top: 3px' action ='logout.php' method = 'POST'>
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
    	} else if (url.indexOf("?page=acc.php") != -1){
    		$("#contentArea").load("acc.php");
    	} else {
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
              console.log(recipeData);
					var content = "";
              
                    for (var i=0; i < recipeData.root.body.recipes.length; i++){
                      content += "<div id=\"breakfast\" class=\"container-fluid\">";  
                      content += "<a onclick=\"getRecipeStep(" + recipeData.root.body.recipes[i].id + ")\"><img class=\"img-responsive\" src=\"" + recipeData.root.body.recipes[i].image + "\"/></a></td></tr>";
                      content += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + recipeData.root.body.recipes[i].title + "</h2>";
                      content += "</div></a></div>";
                    }
                    content += "<button  href=\"?Recipe.html\" class=\"btn-custom\" onclick='getFoodCategory(); return false;'>Show More</button>";
                    $("#contentArea").html(content);
                    createView("Recipe.html&" + recipeData.root.body.recipes[0].id + "&" + recipeData.root.body.recipes[1].id + "&" + recipeData.root.body.recipes[2].id + "&" + recipeData.root.body.recipes[3].id + "&" + recipeData.root.body.recipes[4].id, true);

							
          } else if(event.state.includes("Search.html&")){
                    var searchContent = "";
              
                    for (var i=0; i < searchData.root.body.results.length; i++){
                      searchContent += "<div id=\"breakfast\" class=\"container-fluid\">";  
                      searchContent += "<a onclick=\"getSearchStep(" + searchData.root.body.results[i].id + ")\"><img class=\"img-responsive\" src=\"" + searchData.root.body.baseUri + searchData.root.body.results[i].image + "\"/></a></td></tr>";
                      searchContent += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + searchData.root.body.results[i].title + "</h2>";
                      searchContent += "</div></a></div>";
                    }
                    searchContent += "<button  href=\"?Recipe.html\" class=\"btn-custom\" onclick='getFoodCategory(); return false;'>Show More</button>";
                    $("#contentArea").html(searchContent);
						searchString = "Search.html&"
						for (q = 0; q < searchData.root.body.results.length - 1;q++){
						    searchString += searchData.root.body.results[q].id + "&";
						}
						searchString += searchData.root.body.results[searchData.root.body.results.length-1].id
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
                        fav += "<div id=\"fav\" class=\"container-fluid\">";  
                          fav += "<a href=\"#\"><img class=\"img-responsive\" src=\"img/fav-page.png\"/></a></td></tr>";
                          fav += "</div></a></div>";
                        for (var y = 0; y < data.person.length; y++){
                            console.log(data.person[y].recipe_image);
                          
                          fav += "<div id=\"breakfast\" class=\"container-fluid\">";  
                          fav += "<a href=\"http://preppy.fun/?page=Steps.html&"  + data.person[y].recipe_id + "\"><img class=\"img-responsive\" src=\"" + data.person[y].recipe_image + "\"/></a></td></tr>";
                          fav += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + data.person[y].recipe_name + "</h2>";
                          fav += "</div></a></div>";

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
      
      
//       function getFav(){
//                 $.ajax({
//                 url: "getFav.php",
//                 dataType: "json",
//                 type: "GET",
//                 data: {output: 'json'},
//                 success: function(data) {
//                     console.log(data);
                    
//                     var content = "";
//                     if(data.length != 0) {
                        
//                     if(data.profiles.length == 0) {
//                         content = "<p>No Profiles<p>";
//                     } else {
//                         content += "<div class=\"main-container hidden-sm\"><!-- Start Main Forms --><div class=\"main-forms\"><div class=\"signup-form-1\">";
//                         for(var i = 0; i < data.profiles.length; i++) {

//                             content += "<input type='text' name ='profiles["+i+"]' value='" + data.profiles[i].p_id + "'><br>";
//                             content += "<p>Value: <span class = \"default\" id=\"demo" + i + "\">"+ data.profiles[i].serving +"</span></p>";
//                             content += "<input type=\"range\" name = 'servings["+i+"]'min=\"0.5\" max=\"1.5\" value ='"+data.profiles[i].serving +"' id=\"myRange" + i + "\" step = \"0.1\" oninput=\"showFavVal(this.value," + i + ")\">";
//                             content += "<button class=\"pull-right close-bttn\" name='delete' value='"+data.profiles[i].p_id+"'><i class=\"fa fa-close\"></i></button><br>"; 

//                         }  
//                         content += "<p class=\"btn-update\"><input class='btn btn-info btn-lg' type ='submit' name = 'update' value = 'Update'></p>";
//                         content += "</div></div></div>";
//                     }

//                     $("#profiles_list").html(content);
//                     }
//                     },

//                 error: function(jqXHR, textStatus, errorThrown) {
//                       $("#p1").text(textStatus + " " + errorThrown
//                               + jqXHR.responseText);
//                     } 
// 			});
//       }
      
//       function showFavVal(newVal, num){
//             document.getElementById("demo"+num).innerHTML= newVal;
//         }
//     function addNewFavServing(){
//             var y = document.getElementsByClassName("default");
//             var x = y.length;
//             $("#sliderArea").append("<div class = \"slider\"><input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"1\" id=\"myRange" + x + "\" step = \"0.1\" oninput=\"showFavVal(this.value," + x + ")\"><p>Value: <span class = \"default\" id=\"demo" + x + "\"></span></p></div>");
//             $("#sliderArea").append("<div><button>Delete this preference</button></div>");  
//             showFavVal(1,x);
//         }
	</script>
	
	
	<!--<script charset="utf-8" src="js/jquery-3.3.1.min.js"></script>-->
  </body>
</html>