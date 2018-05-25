var amp = "&";
var url = window.location.href;
//Function to create artificial history stacks for users to navigate through
function createView(link, pushHistory) {
    get(link);
    if (pushHistory)  { 
      history.pushState(link, link, '?page='+link);
     }
}
//Function that helps display the correct pages when users click "back" or "forward" by utilizing the history stacks
window.onpopstate = function(event) {
    if(event.state.includes("Recipe.html&")){
        var content = "";
        for (var i=0; i < recipeData.root.body.recipes.length; i++){
          content += "<div id=\"favourite\" class=\"container-fluid hidden-md hidden-lg\">";  
          content += "<a onclick=\"getRecipeStep(" + recipeData.root.body.recipes[i].id + ")\"><img class=\"img-responsive border-outset-mini\" src=\"" + recipeData.root.body.recipes[i].image + "\"/>";
          content += "<div id=\"breakfastText\" class=\"container-fluid\"><h3>" + recipeData.root.body.recipes[i].title + "</h3>";
          content += "</div></a></div>";
        }
        if(foodCategory === undefined){
            content += "<button  href=\"?Recipe.html\" class=\"btn-custom\" onclick='getFoodCategory(); return false;'>Show More</button>";
        } else {
            content += "<button  href=\"?Recipe.html\" class=\"btn-custom\" onclick='getFoodCategory(\"" + foodCategory + "\"); return false;'>Show More</button>";
        }
        $("#contentArea").html(content);
        createView("Recipe.html&" + recipeData.root.body.recipes[0].id + "&" + recipeData.root.body.recipes[1].id + "&" + recipeData.root.body.recipes[2].id + "&" + recipeData.root.body.recipes[3].id + "&" + recipeData.root.body.recipes[4].id, true);
    } else if(event.state.includes("Search.html&")){
        var searchContent = "";
      
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
    } else if(event.state.includes("Favourites.html")){
        getFavourites();
    }else {
   		createView(event.state, false);

    }
};
//Function to display the page desired by the user
function get(url){
    $("#contentArea").load(url);
}
//Collapses the menu bar after clicking a link
$('.navbar-collapse a').click(function(){
    $(".navbar-collapse").collapse('hide');
});