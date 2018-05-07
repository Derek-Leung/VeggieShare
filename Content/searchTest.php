<?php
  $methodType = $_SERVER['REQUEST_METHOD'];
  $data = array("status" => "fail", "msg" => "On $methodType");

    if ($methodType === 'GET') {
        if(isset($_GET['output'])) {  
          $output = $_GET['output'];
        

            $data = array("status" => "fail", "msg" => "On $methodType", "user" => $output);
         
            $data['status'] = 'success';
            $data['msg'] = 'Retrieving data as JSON';
				    $json = json_encode($data);
						echo $json;
        }
    }
?>