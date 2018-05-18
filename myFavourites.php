<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>
<html>
<head>    
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>     
<script>
    $(document).ready(function(){                
             
              var test = '<?php echo $_SESSION['u_first'] ?>';
              console.log(test);
                
                $.ajax({
        
      
                    url: "getFavorites.php",
                    data: {test:test},
                                        dataType: "json",
                    type: "POST",
                    success: function(data) {
                        
                        console.log(data);
                        var content = "";
                        content += "<table><tr><th>Favourites</th></tr>";
                        for (var y = 0; y < data.person.length; y++){
                            console.log(data.person[y].recipe_image);
                          content += '<tr><td>' + data.person[y].recipe_name;
                          content += "</td><td><a href=\"http://preppy.fun/?page=Steps.html&"  + data.person[y].recipe_id + "\"><img src=" + data.person[y].recipe_image + "></a>";
                          content += "</td></tr>";
                        }
                        content += "</table>";
                        $("#jsonTable").html(content);
                    }
                });
    
                });
                 </script>        
</head>

<body>
    
<div id = "jsonTable">
</div>    
    
</body>
    

</html>