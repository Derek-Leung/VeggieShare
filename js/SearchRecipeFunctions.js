        var searchData = null;
	    var searchID = null;
	    var searchString = null;
	    var searchStep = null;
        function startSearch(){
			var str = document.getElementById("searchTest").value;
			if (str === "lamb sauce"){
				var video = "<iframe width=\"420\" height=\"315\" src=\"https://www.youtube.com/embed/9SNNbcG-ma0\"></iframe>";
					$("#content").html(video);
			}else {
				var cuisineVal = document.getElementById("searchCuisine").value;
				if(cuisineVal !== null){
						str +=  "&cuisine=" + cuisineVal;
				} 
				var typeVal = document.getElementById("searchType").value;
				if(typeVal !== null){
						str +=  "&type=" + typeVal;
				} 
				var dietVal = document.getElementById("searchDiet").value;
				if(dietVal !== null){
						str +=  "&diet=" + dietVal;
				}

				$.ajax({
					url: "./Content/getSearchResult.php",
					dataType: "json",
					type: "GET",
					data: {output: str},
					success: function(data) {
					    searchData = data;
    					console.log("searchData = " + data);
    					if(searchData.root.body.results.length === 0){
    					    var searchcontent = "<h1>No results found</h1>";
						}
						else{
    				var searchcontent = "";
              
                    for (var i=0; i < searchData.root.body.results.length; i++){
                      searchcontent += "<div id=\"breakfast\" class=\"container-fluid\">";  
                      searchcontent += "<a onclick=\"getSearchStep(" + searchData.root.body.results[i].id + ")\"><img class=\"img-responsive\" src=\"" + searchData.root.body.baseUri + searchData.root.body.results[i].image + "\"/></a></td></tr>";
                      searchcontent += "<div id=\"breakfastText\" class=\"container-fluid\"><h2>" + searchData.root.body.results[i].title + "</h2>";
                      searchcontent += "</div></a></div>";
                    }
						}
						$("#content").html(searchcontent);
						searchString = "Search.html&"
						for (q = 0; q < searchData.root.body.results.length - 1;q++){
						    searchString += searchData.root.body.results[q].id + "&";
						}
						searchString += searchData.root.body.results[searchData.root.body.results.length-1].id
                        createView(searchString, true);

					},
						error: function(jqXHR, textStatus, errorThrown) {
							$("#content").text(textStatus + " " + errorThrown
											 + jqXHR.responseText);
						} 
          });
        };
      };

function getSearchStep(num){
    console.log("its called");
	$.ajax({
      url: "./Content/getSearchSteps.php",
      dataType: "json",
      type: "GET",
      data: {output: num},
      success: function(data) {
			console.log(data);
			searchStep = data;
			var recipeInfo = "<section id=\"recipe\"><div class=\"container\" id=\"recipePage\">";
                    recipeInfo += "<div class=\"row\"><div class=\"col-12\">";
                    recipeInfo += "<h2>" + searchStep.root.body.title + "</h2></div></div>";
                    
                    recipeInfo += "<div class=\"row vertical-align\"><div class=\"col-12\">";
                    recipeInfo += "<div class=\"col-md-8 pull-left wow swing\">";
                    recipeInfo += "<img src=\"" + searchStep.root.body.image + "\" class=\"recipe-picture\"/></div>";
                    
                    recipeInfo += "<div class=\"col-md-4 pull-right wow lightSpeedIn\"><div class=\"recipe-info\">";
                    recipeInfo += "<h3>Info<a data-toggle=\"collapse\" class=\"pull-right\" href=\"#collapseInfo\">&#43;</a></h3>";
                    
                    recipeInfo += "<div id=\"servings\">";
                                        
                    for (var i= 1; i < 4; i++){
                        
                    recipeInfo += "<div class = \"slider\">";
                    recipeInfo += "<input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"1\" id=\"myRange" + i + "\" step = \"0.1\" oninput=\"showVal(this.value," + i + ")\">";
                    recipeInfo += "<p>Value " + i + ": <span class = \"default\" id=\"demo" + i + "\">1</span></p>";
                    recipeInfo += "</div>";
                    servingFact += 1;
                    
                    }
                    
                    recipeInfo += "</div>";
                    
                    changeSearchServings(servingFact);
                    
                    recipeInfo += "<a href=\"https://twitter.com/share?ref_src=twsrc%5Etfw\" class=\"twitter-share-button\" data-text=\"Check out this recipe I made!\" data-via=\"preppyfun\" data-hashtags=\"preppy\" data-show-count=\"false\">Tweet</a><script async src=\"https://platform.twitter.com/widgets.js\" charset=\"utf-8\"></script></a>";
                    recipeInfo += "<button onclick=\"addNewServing()\">Add New Serving</button>";
                    recipeInfo += "<button onclick=\"removeLastServing()\">Remove Last Serving</button>";
                    recipeInfo += "<button onclick=\"saveRecipe(" + searchStep.root.body.id + ", \'" + searchStep.root.body.title + "\')\">Save Recipe</button>";
                    
                    recipeInfo += "<div id=\"collapseInfo\" class=\"collapse in\"><div class=\"row\">";
                    recipeInfo += "<div class=\"col-2 text-center\"><i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i></div>";
                    recipeInfo += "<div class=\"col-6\">Time</div>";
                    recipeInfo += "<div class=\"col-4\">" + searchStep.root.body.readyInMinutes + " min</div></div>";
        
                    recipeInfo += "<div class=\"col-2 text-center\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i></div>";
                    recipeInfo += "<div class=\"col-6\">Rating</div>";
                    recipeInfo += "<div class=\"col-4\">" + searchStep.root.body.spoonacularScore + "</div></div>";
                    
                    //recipeInfo += "<div class=\"col-2 text-center\"><i class=\"fa fa-users\" aria-hidden=\"true\"></i></div></div></div></div></div></div></div>";

                    
                    recipeInfo += "<div class=\"row wow slideInUp\"><div class=\"col-12\"><div class=\"recipe-ingredients\">";
                    recipeInfo += "<h3>Ingredients<a data-toggle=\"collapse\" class=\"pull-right\" href=\"#collapse1\">&#43;</a></h3>";
                    recipeInfo += "<div id=\"collapse1\" class=\"collapse\"><dl id = \"inglist\" class=\"ingredients-list\">";
                    
                    for (var y =0; y < searchStep.root.body.extendedIngredients.length; y++){
                    	recipeInfo += "<dt>" + Math.round(10*searchStep.root.body.extendedIngredients[y].measures.metric.amount / searchStep.root.body.servings)/10 + "</dt> <dd>" + searchStep.root.body.extendedIngredients[y].measures.metric.unitLong + " " + searchStep.root.body.extendedIngredients[y].name + "</dd>";               
                    }
                    recipeInfo += "</dl></div></div></div></div>";
                    
                    recipeInfo += "<div class=\"row wow slideInUp\"><div class=\"col-12\"><div class=\"recipe-directions\">";
                    recipeInfo += "<h3>Directions<a data-toggle=\"collapse\" class=\"pull-right\" href=\"#collapse2\">&#43;</a></h3><div id=\"collapse2\" class=\"collapse\">";
                    recipeInfo += "<ol>";
                    
                    for(var n =0; n < searchStep.root.body.analyzedInstructions[0].steps.length; n++){
                    	recipeInfo += "<li>" + searchStep.root.body.analyzedInstructions[0].steps[n].step + "</li>";
                    // 	recipeInfo += "<a class=\"twitter-share-button\"href=\"https://twitter.com/intent/tweet?text=Hello%20world\">Tweet</a>";
                    }
                    recipeInfo += "</ol></div></div></div></div>";

					$("#contentArea").html(recipeInfo);
                       createView("Steps.html&" + searchStep.root.body.id, true);


			}
	})
							
}
          	
      function changeSearchServings(SearchServingFactor){
        var updateSearchTable = "<table>";
        for (var a =0; a < searchStep.root.body.extendedIngredients.length; a++){
            updateSearchTable += "<tr><td>" + (searchStep.root.body.extendedIngredients[a].measures.metric.amount / searchStep.root.body.servings * SearchServingFactor) + " " + searchStep.root.body.extendedIngredients[a].measures.metric.unitLong + " " + searchStep.root.body.extendedIngredients[a].name + "</td></tr>";
        }
        updateSearchTable += "</table>";
        $("#ingredientsTable").html(updateSearchTable);
      }
