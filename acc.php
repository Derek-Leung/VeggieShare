<?php

 if (!isset($_SESSION)) {
        session_start();
    }

    if(!isset($_SESSION['u_first'])) {
        header("location: index.php");
    }

?>

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
                        for(var i = 0; i < data.profiles.length; i++) {

                            content += "<input type='text' name ='profiles["+i+"]' value='" + data.profiles[i].p_id + "'><br>";
                            content += "<p>Value: <span class = \"default\" id=\"demo" + i + "\">"+ data.profiles[i].serving +"</span></p>";
                            content += "<input type=\"range\" name = 'servings["+i+"]'min=\"0.5\" max=\"3\" value ='"+data.profiles[i].serving +"' id=\"myRange" + i + "\" step = \"0.1\" oninput=\"showVal(this.value," + i + ")\">";
                            content += "<button name='delete' value='"+data.profiles[i].p_id+"'>X</button><br>"; 

                        }  
                        content += "<input type ='submit' name = 'update' value = 'Update'>";
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

function showVal(newVal, num){
            document.getElementById("demo"+num).innerHTML= newVal;
        }
        function addNewServing(){
            var y = document.getElementsByClassName("default");
            var x = y.length;
            $("#sliderArea").append("<div class = \"slider\"><input type=\"range\" min=\"0.5\" max=\"1.5\" value=\"1\" id=\"myRange" + x + "\" step = \"0.1\" oninput=\"showVal(this.value," + x + ")\"><p>Value: <span class = \"default\" id=\"demo" + x + "\"></span></p></div>");
            $("#sliderArea").append("<div><button>Delete this preference</button></div>");  
            showVal(1,x);
        }



</script>


<div id="profiles">
    <h2>PROFILES</h2>
    <form id="profiles_list" action="editPreference.php" method="POST">

    </form>

    <form id="add_profile" action="editPreference.php" method="POST">
        <input type='text' name ='new_profile_name'>
        <input type='number' name ='new_serving' min='0.5' max='2' step='0.05' value ='1'>
        <input type='submit' name ='create' value ='Create'>
    </form>

</div>

    <p id = 'p1'></p>