<?php

  require_once '../unirest/src/Unirest.php';


    $methodType = $_SERVER['REQUEST_METHOD'];
    $data = array("status" => "fail", "msg" => "On $methodType");

    if ($methodType === 'GET') {
        if(isset($_GET['category'])) { 
          $category = $_GET['category'];
          // get a random recipe using a GET request in the form of an array, passing in the keys to access spoonacular
           $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/random?number=6&tags=" . $category,
            array(
              "X-Mashape-Key" => "ByX279Alurmsh1xz0jp9KR4nvh9lp1g0a8UjsnKteukNKWsUlH",
              "X-Mashape-Host" => "spoonacular-recipe-food-nutrition-v1.p.mashape.com"
            )
          );

            $data = array("status" => "fail", "msg" => "On $methodType", "root" => $response);
         
            $data['status'] = 'success';
            $data['msg'] = 'Retrieving data as JSON';
				    $json = json_encode($data);
						echo $json;
        } else {
          $response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/random?number=6",
            array(
              "X-Mashape-Key" => "ByX279Alurmsh1xz0jp9KR4nvh9lp1g0a8UjsnKteukNKWsUlH",
              "X-Mashape-Host" => "spoonacular-recipe-food-nutrition-v1.p.mashape.com"
            )
          );

            $data = array("status" => "fail", "msg" => "On $methodType", "root" => $response);
         
            $data['status'] = 'success';
            $data['msg'] = 'Retrieving data as JSON';
		    $json = json_encode($data);
		    echo $json;
        }
          
    }
?>