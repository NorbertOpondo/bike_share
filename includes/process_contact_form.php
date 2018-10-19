<?php
	//include db connection file
	require(__DIR__.'/db_parameters.php');

	//define empty variables for form data
	$id_number = $name = $email = $message ="";
	$id_numberError = $nameError = $emailError = $messageError ="";

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

	//only process POST requests
	$response = array();
	if ('POST' == $_SERVER['REQUEST_METHOD']){
		if(!preg_match("/^[a-zA-Z]{3}-[0-9]{3}-[0-9]{3}\\/[0-9]{4}$/", $_POST['id_number'])){
			$response['id_numberError']='Please enter a valid ID number';
		}
		else{
			$id_number = test_input($_POST['id_number']);
		}
		
		if (strlen($_POST['name']) == 0){
			$response['nameError'] = "This field cannot be left blank";
		}
		else{
			$name = test_input($_POST['name']);
		}
		if (strlen($_POST['email']) == 0){
			$response['emailError'] = "This field cannot be left blank";
		}
		else{
			$email = test_input($_POST['email']);
		}
		if (strlen($_POST['message']) == 0){
			$response['messageError'] = "This field cannot be left blank";
		}
		else{
			$message = test_input($_POST['message']);
		}

		if(empty($response)){
			//initiate database connection
			try{
				$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "INSERT INTO feedback(student_id,Name,Email,Message)VALUES(?,?,?,?)";
                $stmt = $conn->prepare($query);
                $conn-> beginTransaction();
                $stmt->execute(array($id_number,$name,$email,$message));
                $response['status'] = 'success';
                $response['message'] = 'Form submitted successfully';
                $conn->commit();	
			}
			catch(PDOException $e){
				//echo "Error: ". $e->getMessage();
				$response['status'] = 'error';
				$response['message'] = 'An error occured';
				$conn->rollBack();
			}
			$conn = null;
		}else{
			$response = $response;
		}
		header('Content-type: application/json');
		echo json_encode($response);
	}
?>