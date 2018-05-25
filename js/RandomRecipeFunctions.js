//Required variables to use when performing a random recipe click
var recipeData = null;
var recipeID = null;
var servingFact = 0;
var foodCategory = null;
//Performs AJAX call for a list of random recipes and display the results in a styled format
function getFoodCategory(category){
    $.ajax({
        url: "./Content/getRandomRecipe.php",
        dataType: "json",
        type: "GET",
        data: {category: category},
        success: function(data) {
            recipeData = data;
            foodCategory = category;
            var content = "";
            for (var y = 0; y < data.root.body.recipes.length; y++){
                if(y%2 == 0){
                    content += "<div class=\"row hidden-xs hidden-sm\"><div class=\"col-6\"><div id=\"breakfast\" class=\"container-fluid \">";  
                    content += "<a onclick=\"getRecipeStep("  + data.root.body.recipes[y].id + ")\"><img class=\"img-responsive border-outset\" src=\"" + data.root.body.recipes[y].image + "\"/>";
                    content += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + data.root.body.recipes[y].title + "</h2>";
                    content += "</div>";
                    content += "</a></div></div>";
                } else {
                    content += "<div class=\"col-6\"><div id=\"breakfast\" class=\"container-fluid\">";  
                    content += "<a onclick=\"getRecipeStep("  + data.root.body.recipes[y].id + ")\"><img class=\"img-responsive border-outset\" src=\"" + data.root.body.recipes[y].image + "\"/>";
                    content += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + data.root.body.recipes[y].title + "</h2>";
                    content += "</div>";
                    content += "</a></div></div></div>";
                }
                if(y == (data.root.body.recipes.length - 1)){
                    if(y%2 ==0){
                      content += "</div>";
                    }
                }
    
            }
            for (var i=0; i < data.root.body.recipes.length; i++){
                content += "<div id=\"favourite\" class=\"container-fluid hidden-md hidden-lg\">";  
                content += "<a onclick=\"getRecipeStep(" + data.root.body.recipes[i].id + ")\"><img class=\"img-responsive border-outset-mini\" src=\"" + data.root.body.recipes[i].image + "\"/>";
                content += "<div id=\"breakfastText\" class=\"container-fluid\"><h3>" + data.root.body.recipes[i].title + "</h3>";
                content += "</div></a></div>";
            }
            if(category === undefined){
                content += "<button  href=\"?Recipe.html\" class=\"btn-custom\" onclick='getFoodCategory(); return false;'>Show More</button>";
            } else {
                content += "<button  href=\"?Recipe.html\" class=\"btn-custom\" onclick='getFoodCategory(\"" + category + "\"); return false;'>Show More</button>";
            }
            $("#contentArea").html(content);
            createView("Recipe.html&" + recipeData.root.body.recipes[0].id + "&" + recipeData.root.body.recipes[1].id + "&" + recipeData.root.body.recipes[2].id + "&" + recipeData.root.body.recipes[3].id + "&" + recipeData.root.body.recipes[4].id, true);

        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#p1").text(textStatus + " " + errorThrown
                 + jqXHR.responseText);
        } 
	});
}
//Performs AJAX call for the recipe step of the recipe chosen by the user
function getRecipeStep(num){
	var recipeInfo = "";
	var recipeInfo2 ="";
    for (var x=0; x < recipeData.root.body.recipes.length; x++){
        if (num == recipeData.root.body.recipes[x].id){
            recipeID = x;
			recipeInfo += "<section id=\"recipe\"><div class=\"container\" id=\"recipePage\"><div class=\"row\"><!-- Title --><div class=\"col-12\"><h2>" + recipeData.root.body.recipes[x].title + "</h2></div></div><div class=\"row vertical-align\"><div class=\"col-12\"><!-- Picture --><div class=\"col-md-8 pull-left wow swing\"><img src=\"" + recipeData.root.body.recipes[x].image + "\"  class=\"recipe-picture\" /></div><!-- Info --><div class=\"col-md-4 pull-right wow lightSpeedIn\"><div class=\"recipe-info\"><h3>&ensp;Info<a data-toggle=\"collapse\" class=\"pull-right\" href=\"#collapseInfo\"><i class=\"fa fa-plus-square fa-pos\" aria-hidden=\"true\"></i></a></h3><!-- Time --><div id=\"collapseInfo\" class=\"collapse in\">";recipeInfo += "<div id=\"servings\">";
                                
            if(userID == -1){
                for (var i= 1; i < 4; i++){
                    recipeInfo += "<div class = \"slider\">";
                    recipeInfo += "<input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"1\" id=\"myRange" + i + "\" step = \"0.1\" oninput=\"showVal(this.value," + i + ")\">";
                    recipeInfo += "<p>Serving : <span class = \"default\" id=\"demo" + i + "\">1</span></p>";
                    recipeInfo += "</div>";
                    servingFact += 1;
                }
            } else { 
                $.ajax({
                    url: "getPreferences.php",
                    dataType: "json",
                    type: "POST",
                    data: {test: userID},
                    success: function(data) {
                        var servings2  = "";
                        for (var i= 0; i < data.profile.length; i++){
                            servings2 += "<div class = \"slider\">";
                            servings2 += "<input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"" + data.profile[i].serving + "\" id=\"myRange" + (i+1) + "\" step = \"0.1\" oninput=\"showVal(this.value," + (i+1) + ")\">";
                            servings2 += "<p>" + data.profile[i].name + ": <span class = \"default\" id=\"demo" + (i+1) + "\">"+ data.profile[i].serving +"</span></p>";
                            servings2 += "</div>";
                            var servingVal = parseFloat(data.profile[i].serving);
                            servingFact += servingVal;
                            changeServings(servingFact);
                        }
                      $("#servings").html(servings2);
                      },
                    error: function(jqXHR, textStatus, errorThrown) {
                            $("#p1").text(textStatus + " " + errorThrown
                                  + jqXHR.responseText);
                    } 
	            }); 
            }
            recipeInfo += "</div>";
            recipeInfo += "<button onclick=\"addNewServing()\">Add New Serving</button>";
            recipeInfo += "<button onclick=\"removeLastServing()\">Remove Last Serving</button>";
            recipeInfo += "<button onclick=\"saveRecipe(" + recipeData.root.body.recipes[x].id + ", \'" + recipeData.root.body.recipes[x].title + "\', \'" + recipeData.root.body.recipes[x].image + "\')\">Save Recipe</button>";
			recipeInfo += "<a href=\"https://twitter.com/share?ref_src=twsrc%5Etfw\" class=\"twitter-share-button\" data-text=\"Check out this recipe I made!\" data-via=\"preppyfun\" data-hashtags=\"preppy\" data-size =\"large\" data-show-count=\"false\">Tweet</a><script async src=\"https://platform.twitter.com/widgets.js\" charset=\"utf-8\"></script></a>";
            recipeInfo += "<div class=\"row\"><div class=\"col-2 text-center\"><i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i></div><div class=\"col-6\">Time</div><div class=\"col-4\">" + recipeData.root.body.recipes[x].readyInMinutes + " min</div></div></div></div></div></div></div>";
            recipeInfo += "<!-- Ingredients --><div class=\"row wow slideInUp\"><div class=\"col-12\"><div class=\"recipe-ingredients\"><h3>&ensp;Ingredients</h3><div id=\"collapse1\" class=\"collapse in\">";
            recipeInfo += "</div></div></div></div><!-- Directions --><div class=\"row wow slideInUp\"><div class=\"col-12\"><div class=\"recipe-directions\"><h3>&ensp;Directions<a data-toggle=\"collapse\" class=\"pull-right\" href=\"#collapse2\"><i class=\"fa fa-plus-square fa-pos\" aria-hidden=\"true\"></i></a></h3><div id=\"collapse2\" class=\"collapse\"><ol>";
            
            for(var n =0; n < recipeData.root.body.recipes[x].analyzedInstructions[0].steps.length; n++){
            	recipeInfo += "<li>" + recipeData.root.body.recipes[x].analyzedInstructions[0].steps[n].step + "</li>";
            }
            
            recipeInfo += "</ol></div></div></div></div><!-- Back to recipes --><div class=\"row wow rollIn\"><div class=\"col-12 text-center\"><a href=\"index.html\" onclick=\"goBack(); return false;\"><i class=\"fa fa-backward\" aria-hidden=\"true\"></i>Go to back to recipes.</a></div></div></div></section>";

			$("#contentArea").html(recipeInfo);
            changeServings(servingFact);

            createView("Steps.html&" + recipeData.root.body.recipes[x].id, true);
        }
    }
}
//Displays the correct amount of serving factor bars
function changeServings(servingFactor){
    var updateTable = "<dl  class=\"ingredients-list\">";
    for (var a =0; a < recipeData.root.body.recipes[recipeID].extendedIngredients.length; a++){
        updateTable += "<dt>" + Math.round(10*recipeData.root.body.recipes[recipeID].extendedIngredients[a].measures.metric.amount / recipeData.root.body.recipes[recipeID].servings * servingFactor)/10 + "</dt> <dd>" + recipeData.root.body.recipes[recipeID].extendedIngredients[a].measures.metric.unitLong + " " + recipeData.root.body.recipes[recipeID].extendedIngredients[a].name + "</dd>"; 
    }
    updateTable += "</dl>";
    $("#collapse1").html(updateTable);
}
//Dynamically updates the ingredients list to match the serving factor 
function updateServings (){
    var y = document.getElementsByClassName("default");
    var x = y.length;
    x++;
    var newServingFact = 0;
    
    for(var z=1; z<x; z++){
        var i = parseFloat(document.getElementById("myRange"+z).value);
        newServingFact += i;
    }
    
    servingFact = newServingFact;
    changeServings(servingFact);
}
//Displays the value represented by the serving factor bars     
function showVal(newVal, num){
    document.getElementById("demo"+num).innerHTML= newVal;
    updateServings();
}
//Adds a new serving factor bar to the recipe step page
function addNewServing(){
    var y = document.getElementsByClassName("default");
    var x = y.length;
    x++;
    $("#servings").append("<div class = \"slider\"><input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"1\" id=\"myRange" + x + "\" step = \"0.1\" oninput=\"showVal(this.value," + x + ")\"><p>Serving " + x + ": <span class = \"default\" id=\"demo" + x + "\"></span></p></div>");
    servingFact += 1;
    showVal(1, x);
}
//Removes the last serving factor bar from the recipe step page
function removeLastServing(){
    var x = document.getElementsByClassName("slider");
    servingFact -= $('#servings div:last input').value;
    $('#servings div:last').remove();
    updateServings();
}
//Allows signed in user to save recipes to their favourites page
function saveRecipe(recipeID, recipeTitle, recipeImage){
    $.ajax({
        url: "./Content/favorites.php",
        type: "POST",
        dataType: "text",
        data: {
                recipeID : recipeID,
                recipeName : recipeTitle,
                test : userID,
                recipeImage: recipeImage
            },
        success: function(data) {
            alert(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.statusText, textStatus);
            console.log("help");
        }

    });
}
//Function for the user to click to go back from the recipe steps page
function goBack(){
    window.history.back();
}

