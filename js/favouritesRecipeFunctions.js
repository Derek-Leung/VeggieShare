//Variable required for displaying the signed in user's favourite recipe page
var favouritesData = null;
//Performs AJAX call to the PHP to grab the user's favourite recipe list and display it in a styled format   
function getFavourites(){
    $.ajax({
        url: "./Content/getFavorites.php",
        data: {test:userID},
        dataType: "json",
        type: "POST",
        success: function(data) {
            favouritesData = data;
            var fav = "";
            fav += "<div id=\"fav\" class=\"container-fluid\">";  
            fav += "<a href=\"#\"><img class=\"img-responsive\" src=\"img/fav-page.png\"/></a></td></tr>";
            fav += "</div></a></div>";
            for (var y = 0; y < favouritesData.person.length; y++){
                if(y%2 == 0){
                    fav += "<div class=\"row hidden-xs hidden-sm\"><div class=\"col-6\"><div id=\"breakfast\" class=\"container-fluid \">";  
                    fav += "<a onclick=\"getSearchStep("  + favouritesData.person[y].recipe_id + ")\"><img class=\"img-responsive border-outset\" src=\"" + favouritesData.person[y].recipe_image + "\"/>";
                    fav += "<div id=\"breakfastText\" class=\"container-fluid\"><h3>" + favouritesData.person[y].recipe_name + "</h3>";
                    fav += "</div><button class='remove' onclick=\"removeFavourites(" + favouritesData.person[y].recipe_id + ")\"><i class=\"fa fa-close\"></i></button>";
                    fav += "</a></div></div>";
                } else {
                    fav += "<div class=\"col-6\"><div id=\"breakfast\" class=\"container-fluid\">";  
                    fav += "<a onclick=\"getSearchStep("  + favouritesData.person[y].recipe_id + ")\"><img class=\"img-responsive border-outset\" src=\"" + favouritesData.person[y].recipe_image + "\"/>";
                    fav += "<div id=\"breakfastText\" class=\"container-fluid\"><h3>" + favouritesData.person[y].recipe_name + "</h3>";
                    fav += "</div><button class='remove' onclick=\"removeFavourites(" + favouritesData.person[y].recipe_id + ")\"><i class=\"fa fa-close\"></i></button>";
                    fav += "</a></div></div></div>";
                }
                if(y == (favouritesData.person.length - 1)){
                    if(y%2 ==0){
                        fav += "</div>";
                    }
                }

            }
            for (var y = 0; y < favouritesData.person.length; y++){
                fav += "<div id=\"favourite\" class=\"container-fluid hidden-md hidden-lg\">";  
                fav += "<a onclick=\"getSearchStep("  + favouritesData.person[y].recipe_id + ")\"><img class=\"img-responsive border-outset-mini\" src=\"" + favouritesData.person[y].recipe_image + "\"/>";
                fav += "<div id=\"breakfastText\" class=\"container-fluid\"><h3>" + favouritesData.person[y].recipe_name + "</h3>";
                fav += "</div></a><button class='remove' onclick=\"removeFavourites(" + favouritesData.person[y].recipe_id + ")\"><i class=\"fa fa-close\"></i></button>";
                fav += "</div>";
            }
            fav += "</table>";
            $("#contentArea").html(fav);
            var buttons = document.getElementsByClassName('remove');
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].addEventListener('click', function () {
                this.parentNode.remove();
                });
            }


            createView("Favourites.html", true);
        }
    });
}
//Function for the user to remove a recipe from their favourite recipe list
function removeFavourites(recipeID){
    $.ajax({
        url: "./Content/removeFavorite.php",
        data: {test:userID, removeID: recipeID},
        dataType: "text",
        type: "POST",
        success: function(data) {
            alert(data);
        }
    })
}