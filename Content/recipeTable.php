<?php



    $servername = "xray.gendns.com";
    $dblogin = "preppyfu_admin";
    $password = "adminadmin";
    $dbname = "preppyfu_2910";

	  $methodType = $_SERVER['REQUEST_METHOD'];
    $data = array("status" => "fail", "msg" => "On $methodType");

    if ($methodType === 'GET') {
        if(isset($_GET['output'])) {
            $output = $_GET['output'];


						try {
								$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);

								// set the PDO error mode to exception
								$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

								$sql = "SELECT * FROM recipes";

								$statement1 = $conn->prepare($sql);
								$statement1->execute();
           			
							  $data = array("status" => "fail", "msg" => "On $methodType", "recipes" => $statement1->fetchAll(PDO::FETCH_ASSOC));


						} catch(PDOException $e) {
								echo "<p style='color: red;'>From the SQL code: $sql</p>";
								$error = $e->getMessage();
								echo "<p style='color: red;'>$error</p>";
						}

                    $data['status'] = 'success';
                    $data['msg'] = 'Retrieving data as JSON';
										$json = json_encode($data);
										echo $json;

      

        } else {
            echo "Need a type of output!";
        }

    } else {
        echo $data;
    }



?>

