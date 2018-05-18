<?php

 if (!isset($_SESSION)) {
        session_start();
    }

    if(!isset($_SESSION['u_first'])) {
        header("location: index.php");
    }

?>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>

    $(document).ready(function() {
            $.ajax({
                url: "getFav.php",
                dataType: "json",
                type: "GET",
                data: {output: 'json'},
                success: function(data) {
                    console.log(data);
                    
                    var content = "";
                    if(data.length != 0) {
                        
                    if(data.profiles.length == 0) {
                        content = "<p>No Profiles<p>";
                    } else {
                        content += "<div class=\"main-container\"><!-- Start Main Forms --><div class=\"main-forms\"><div class=\"signup-form-1\">";
                        for(var i = 0; i < data.profiles.length; i++) {

                            content += "<input type='text' name ='profiles["+i+"]' value='" + data.profiles[i].name + "'><br>";
                            content += "<input type=\"range\" name = 'servings["+i+"]'min=\"0.5\" max=\"1.5\" value ='"+data.profiles[i].serving +"' id=\"myRange" + i + "\" step = \"0.1\" oninput=\"showFavVal(this.value," + i + ")\">";
                            content += "<p>Value: <span class = \"default\" id=\"demo" + i + "\">"+ data.profiles[i].serving +"</span></p>";
                            content += "<button class=\"pull-right close-bttn\" name='delete' value='"+data.profiles[i].name+"'><i class=\"fa fa-close\"></i></button><br>"; 

                        }  
                        content += "<p class=\"btn-update\"><input class='btn btn-info btn-lg' type ='submit' name = 'update' value = 'Update'></p>";
                        content += "</div></div></div>";
                    }

                    $("#profiles_list").html(content);
                    }
                    },

                error: function(jqXHR, textStatus, errorThrown) {
                      $("#p1").text(textStatus + " " + errorThrown
                               + jqXHR.responseText);
                    } 
			});
    }); 

function showFavVal(newVal, num){
            document.getElementById("demo"+num).innerHTML= newVal;
        }
        function addNewServing(){
            var y = document.getElementsByClassName("default");
            var x = y.length;
            $("#sliderArea").append("<div class = \"slider\"><input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"1\" id=\"myRange" + x + "\" step = \"0.1\" oninput=\"showFavVal(this.value," + x + ")\"><p>Value: <span class = \"default\" id=\"demo" + x + "\"></span></p></div>");
            $("#sliderArea").append("<div><button>Delete this preference</button></div>");  
            showFavVal(1,x);
        }


function showNew(val){
            document.getElementById("new").innerHTML= val;
        }

</script>

<div id="profiles">
    <h2 class="btn-update">PROFILES</h2>
    <div class="signup-form-1">
        <h3>ADD PERSON</h3>
    <form id="add_profile" action="editPreference.php" method="POST">
        <input type='text' name ='new_profile_name'>
        <!-- <input type='range' name = 'new_serving' min='0.5' max='1.5' value ='1' id='' step = '0.1' oninput= 'showFavVal(this.value)'>
        <p>Value: <span id='new'>1</span></p> -->
        <input type='number' name ='new_serving' min='0.5' max='1.5' step='0.05' value ='1'>
        <input class='btn btn-success pull-right btn-lg' type='submit' name ='create' value ='ADD'>
    </form>
    
    </div>
    <form id="profiles_list" action="editPreference.php" method="POST">

    </form>

    

</div>

    <p id = 'p1'></p>