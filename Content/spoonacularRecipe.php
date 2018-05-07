<?php
    require 'C:\xampp\phpMyAdmin' . '\vendor\autoload.php';
    use RapidApi\RapidApiConnect;
    $rapid = new RapidApiConnect('preppytesting_5aee6a58e4b03dc750e69c15', '/connect/auth/preppytesting_5aee6a58e4b03dc750e69c15');
    $methodType = $_SERVER['REQUEST_METHOD'];
    $data = array("status" => "fail", "msg" => "On $methodType");

    if ($methodType === 'GET') {
        if(isset($_GET['output'])) {
            $output = $_GET['output'];
            

//            $data = array("status" => "fail", "msg" => "On $methodType", "rapid" => $rapid->call('NasaAPI', 'getPictureOfTheDay', []));
//          
            $data['status'] = 'success';
            $data['msg'] = 'Retrieving data as JSON';
				    $json = json_encode($data);
						echo $json;
        }
    }
//echo "hello";
?>