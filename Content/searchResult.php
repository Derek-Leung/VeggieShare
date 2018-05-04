<?php

    $keyword = strval($_POST['query']);
	  $search_param = "{$keyword}%";
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

								$sql = "SELECT * FROM customer WHERE first_name LIKE ?";
							  $sql2 = "SELECT * FROM address WHERE first_name LIKE ?";

								$statement1 = $conn->prepare($sql);
								$statement1->execute();
							  
							  $statement2 = $conn->prepare($sql2);
								$statement2->execute();
              
           			$result = $sql->get_result();

//							  $data = array("status" => "fail", "msg" => "On $methodType", "customer" => $statement1->fetchAll(PDO::FETCH_ASSOC), "address" => $statement2->fetchAll(PDO::FETCH_ASSOC));
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    $firstNameResult[] = $row["first_name"];
                    }
                    echo json_encode($firstNameResult);
                  }
                  $conn->close();


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

<!--
<?php		
	$keyword = strval($_POST['query']);
	$search_param = "{$keyword}%";
	$conn =new mysqli('localhost', 'root', '' , 'blog_samples');

	$sql = $conn->prepare("SELECT * FROM tbl_country WHERE country_name LIKE ?");
	$sql->bind_param("s",$search_param);			
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$countryResult[] = $row["country_name"];
		}
		echo json_encode($countryResult);
	}
	$conn->close();
?>

-->
