<?php


    $servername = "localhost";
    $dblogin = "root";
    $password = "";
    $dbname = "recipetest";

	  $methodType = $_SERVER['REQUEST_METHOD'];
    $data = array("status" => "fail", "msg" => "On $methodType");

    //echo $methodType;
    //var_dump($transaction);

    // to see you will need to type this in the URL bar of your browser:
    // http://localhost/lab_7/lab_07_GetTable.php?output=json
    // Note: you may also need to include a port (check XAMPP/WAMP/LAMP/MAMP for the port)
    if ($methodType === 'GET') {
        if(isset($_GET['output'])) {
            $output = $_GET['output'];


						try {
								$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dblogin, $password);

								// set the PDO error mode to exception
								$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

								$sql = "SELECT * FROM customer";
							  $sql2 = "SELECT * FROM address";

								$statement1 = $conn->prepare($sql);
								$statement1->execute();
							  
							  $statement2 = $conn->prepare($sql2);
								$statement2->execute();
           			
							  $data = array("status" => "fail", "msg" => "On $methodType", "customer" => $statement1->fetchAll(PDO::FETCH_ASSOC), "address" => $statement2->fetchAll(PDO::FETCH_ASSOC));


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

