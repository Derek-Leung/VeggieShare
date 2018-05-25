//Required variables to use when performing a search
var searchData = null;
var searchID = null;
var searchString = null;
var searchStep = null;
var searchCategory = null;

//Checks for easter egg and various search parameters and then calls external API (spoonacular) for a list of search results
function startSearch(){
	var str = document.getElementById("searchTest").value;
	if (str === "lamb sauce"){
		var video = "<iframe class=\"embed-responsive-item\" width=\"100%\"  src=\"https://www.youtube.com/embed/9SNNbcG-ma0?autoplay=1\"></iframe>";
		$("#content").html(video);
	} else {
		var cuisineVal = document.getElementById("searchCuisine").value;
		if(cuisineVal !== ''){
			str +=  "&cuisine=" + cuisineVal;
		} 
		
		var typeVal = document.getElementById("searchType").value;
		if(typeVal !== ''){
			str +=  "&type=" + typeVal;
		} 
			
		var dietVal = document.getElementById("searchDiet").value;
		if(dietVal !== ''){
			str +=  "&diet=" + dietVal;
		}
		
		getSearch(str);
	}
}
//Performs AJAX call for a list of search results and display the results in a styled format
function getSearch(search){
	$.ajax({
		url: "./Content/getSearchResult.php",
		dataType: "json",
		type: "GET",
		data: {output: search},
		success: function(data) {
		    searchCategory = search;
		    searchData = data;
			console.log("searchData = " + data);
			if(searchData.root.body.results.length === 0){
			    alert("No results found!");
			    ;
			}
			else{
                var searchContent = "";
  
                for (var i=0; i < searchData.root.body.results.length; i++){
                  searchContent += "<div id=\"breakfast\" class=\"container-fluid hidden-sm hidden-xs\">";  
                  searchContent += "<a onclick=\"getSearchStep(" + searchData.root.body.results[i].id + ")\"><img class=\"img-responsive\" src=\"" + searchData.root.body.baseUri + searchData.root.body.results[i].image + "\"/></a></td></tr>";
                  searchContent += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + searchData.root.body.results[i].title + "</h2>";
                  searchContent += "</div></a></div>";
                }
            
                for (var i=0; i < searchData.root.body.results.length; i++){
                    searchContent += "<div id=\"favourite\" class=\"container-fluid hidden-md hidden-lg\">";  
                    searchContent += "<a onclick=\"getSearchStep(" + searchData.root.body.results[i].id + ")\"><img class=\"img-responsive\" src=\"" + searchData.root.body.baseUri + searchData.root.body.results[i].image + "\"/>";
                    searchContent += "<div id=\"breakfastText\" class=\"container-fluid\"><h3>" + searchData.root.body.results[i].title + "</h3>";
                    searchContent += "</div></a></div>";
                }
                
                searchContent += "<button  href=\"?Recipe.html\" class=\"btn-custom\" onclick='getFoodCategory(\"" + searchCategory + "\"); return false;'>Show More</button>";
                $("#contentArea").html(searchContent);
        		searchString = "Search.html&"
        		for (q = 0; q < searchData.root.body.results.length - 1;q++){
        			searchString += searchData.root.body.results[q].id + "&";
        		}
        	    searchString += searchData.root.body.results[searchData.root.body.results.length-1].id
                createView(searchString, true);
            }
    	},
		error: function(jqXHR, textStatus, errorThrown) {
			$("#content").text(textStatus + " " + errorThrown
					+ jqXHR.responseText);
		} 
    });
};
//Performs AJAX call for the recipe step of the recipe chosen by the user
function getSearchStep(num){
	$.ajax({
        url: "./Content/getSearchSteps.php",
        dataType: "json",
        type: "GET",
        data: {output: num},
        success: function(data) {
            searchStep = data;
	        var recipeInfo = "";
	        var recipeInfo2 ="";
			recipeInfo += "<section id=\"recipe\"><div class=\"container\" id=\"recipePage\"><div class=\"row\"><!-- Title --><div class=\"col-12\"><h2>" + data.root.body.title + "</h2></div></div><div class=\"row vertical-align\"><div class=\"col-12\"><!-- Picture --><div class=\"col-md-8 pull-left wow swing\"><img src=\"" + data.root.body.image + "\"  class=\"recipe-picture\" /></div><!-- Info --><div class=\"col-md-4 pull-right wow lightSpeedIn\"><div class=\"recipe-info\"><h3>&ensp;Info<a data-toggle=\"collapse\" class=\"pull-right\" href=\"#collapseInfo\"><i class=\"fa fa-plus-square fa-pos\" aria-hidden=\"true\"></i></a></h3><!-- Time --><div id=\"collapseInfo\" class=\"collapse in\">";recipeInfo += "<div id=\"servings\">";
            
            if(userID == -1){
                for (var i= 1; i < 4; i++){
                    recipeInfo += "<div class = \"slider\">";
                    recipeInfo += "<input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"1\" id=\"myRange" + i + "\" step = \"0.1\" oninput=\"showSearchVal(this.value," + i + ")\">";
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
                            servings2 += "<input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"" + data.profile[i].serving + "\" id=\"myRange" + (i+1) + "\" step = \"0.1\" oninput=\"showSearchVal(this.value," + (i+1) + ")\">";
                            servings2 += "<p>" + data.profile[i].name + ": <span class = \"default\" id=\"demo" + (i+1) + "\">"+ data.profile[i].serving +"</span></p>";
                            servings2 += "</div>";
                            var servingVal = parseFloat(data.profile[i].serving);
                            servingFact += servingVal;
                            changeSearchServings(servingFact);
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
            recipeInfo += "<button onclick=\"addNewSearchServing()\">Add New Serving</button>";
            recipeInfo += "<button onclick=\"removeLastSearchServing()\">Remove Last Serving</button>";
            recipeInfo += "<button onclick=\"saveRecipe(" + data.root.body.id + ", \'" + data.root.body.title + "\', \'" + data.root.body.image + "\')\">Save Recipe</button>";
			recipeInfo += "<a href=\"https://twitter.com/share?ref_src=twsrc%5Etfw\" class=\"twitter-share-button\" data-text=\"Check out this recipe I made!\" data-via=\"preppyfun\" data-hashtags=\"preppy\" data-size =\"large\" data-show-count=\"false\">Tweet</a><script async src=\"https://platform.twitter.com/widgets.js\" charset=\"utf-8\"></script></a>";
            recipeInfo += "<div class=\"row\"><div class=\"col-2 text-center\"><i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i></div><div class=\"col-6\">Time</div><div class=\"col-4\">" + data.root.body.readyInMinutes + " min</div></div></div></div></div></div></div>";
            recipeInfo += "<!-- Ingredients --><div class=\"row wow slideInUp\"><div class=\"col-12\"><div class=\"recipe-ingredients\"><h3>&ensp;Ingredients</h3><div id=\"collapse1\" class=\"collapse in\">";
            recipeInfo += "</div></div></div></div><!-- Directions --><div class=\"row wow slideInUp\"><div class=\"col-12\"><div class=\"recipe-directions\"><h3>&ensp;Directions<a data-toggle=\"collapse\" class=\"pull-right\" href=\"#collapse2\"><i class=\"fa fa-plus-square fa-pos\" aria-hidden=\"true\"></i></a></h3><div id=\"collapse2\" class=\"collapse\"><ol>";
            
            for(var n =0; n < data.root.body.analyzedInstructions[0].steps.length; n++){
                recipeInfo += "<li>" + data.root.body.analyzedInstructions[0].steps[n].step + "</li>";
            }
           
            recipeInfo += "</ol></div></div></div></div><!-- Back to recipes --><div class=\"row wow rollIn\"><div class=\"col-12 text-center\"><a href=\"index.html\" onclick=\"goBack(); return false;\"><i class=\"fa fa-backward\" aria-hidden=\"true\"></i>Go to back to recipes.</a></div></div></div></section>";
			$("#contentArea").html(recipeInfo);
            changeSearchServings(servingFact);
            createView("Steps.html&" + data.root.body.id, true);

										}
	})
}
//Displays the correct amount of serving factor bars
function changeSearchServings(SearchServingFactor){
    var updateSearchTable = "<dl  class=\"ingredients-list\">";
    for (var a =0; a < searchStep.root.body.extendedIngredients.length; a++){
        updateSearchTable += "<dt>" + Math.round(10*searchStep.root.body.extendedIngredients[a].measures.metric.amount / searchStep.root.body.servings * servingFact)/10 + "</dt> <dd>" + searchStep.root.body.extendedIngredients[a].measures.metric.unitLong + " " + searchStep.root.body.extendedIngredients[a].name + "</dd>"; 
    }
    updateSearchTable += "</dl>";
    $("#collapse1").html(updateSearchTable);
}
//Dynamically updates the ingredients list to match the serving factor 
function updateSearchServings (){
    var y = document.getElementsByClassName("default");
    var x = y.length;
    x++;
    var newServingFact = 0;
    for(var z=1; z<x; z++){
        var i = parseFloat(document.getElementById("myRange"+z).value);
        newServingFact += i;
    }
    servingFact = newServingFact;
    changeSearchServings(servingFact);
}
//Displays the value represented by the serving factor bars     
function showSearchVal(newVal, num){
    document.getElementById("demo"+num).innerHTML= newVal;
    updateSearchServings();
}
//Adds a new serving factor bar to the recipe step page
function addNewSearchServing(){
    var y = document.getElementsByClassName("default");
    var x = y.length;
    x++;
    $("#servings").append("<div class = \"slider\"><input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"1\" id=\"myRange" + x + "\" step = \"0.1\" oninput=\"showSearchVal(this.value," + x + ")\"><p>Serving " + x + ": <span class = \"default\" id=\"demo" + x + "\"></span></p></div>");
    servingFact += 1;
    showSearchVal(1, x);
}
//Removes the last serving factor bar from the recipe step page
function removeLastSearchServing(){
    var x = document.getElementsByClassName("slider");
    servingFact -= $('#servings div:last input').value;
    $('#servings div:last').remove();
    updateSearchServings();
}
