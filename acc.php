<?php

 if (!isset($_SESSION)) {
        session_start();
    }

    if(!isset($_SESSION['u_first'])) {
        header("location: index.php");
    }

?>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "./Content/getServingFactor.php",
            dataType: "json",
            type: "GET",
            data: {output: 'json'},
            success: function(data) {
                var content = "";
                if(data.length != 0) {
                    if(data.profiles.length == 0) {
                        content = "<p>No Profiles<p>";
                    } else {
                        content += "<div class=\"main-container\"><!-- Start Main Forms --><div class=\"main-forms\"><div class=\"signup-form-1\">";
                        for(var i = 0; i < data.profiles.length; i++) {
    
                            content += "<h4 class = 'profile_label'>"+data.profiles[i].name+"</h4>";
                            content += "<input type='hidden' name ='profiles["+i+"]' value='" + data.profiles[i].name + "'><br>";
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

    function showNew(val){
        document.getElementById("new12").innerHTML= val;
    }

</script>

<div id="profiles">
    <h2 class="btn-update">PROFILES</h2>
    <div class="signup-form-1">
        <h3>ADD PERSON</h3>
        <form id="add_profile" action="./Content/editPreference.php" method="POST">
            <input type='text' name ='new_profile_name' required>
            <input type='range' name = 'new_serving' min='0.5' max='1.5' value ='1' id='' step = '0.1' oninput= 'showNew(this.value)'>
            <p>Value: <span id='new12'>1</span></p> 
            <input class='btn btn-success pull-right btn-lg' type='submit' name ='create' value ='ADD'>
        </form>
    </div>
    <form id="profiles_list" action="./Content/editPreference.php" method="POST">
    </form>
</div>
<p id = 'p1'></p>