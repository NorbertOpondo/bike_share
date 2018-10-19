<?php
	// include database connection strings
	include __DIR__.'/db_parameters.php';

	//declare empty input variables
	$student_id = $new_uname = "";
	$studentId_error = $new_uname_error = "";

	function test_data($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;	
	}

	$response = array();

	if ("POST" == $_SERVER['REQUEST_METHOD']) {
		if(strlen($_POST['student_id']) == 0){
			$response['studentId_error'] = "You must provide your current username";
		}else{
			$student_id = test_data($_POST['student_id']);
		}

		if (strlen($_POST['new_username']) == 0) {
			$response['new_uname_error'] = "You must provide your new username";
		}else{
			$new_uname = test_data($_POST['new_username']);
		}

		if (empty($response)) {
			try{
				$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);

				//setting PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$query = "UPDATE registration SET username = ? WHERE student_id = ? ";
				$conn->beginTransaction();
				$stmt = $conn->prepare($query);
				$stmt->execute(array($new_uname,$student_id));
				$response['status'] = 'success';
				$response['message'] = 'Username changes successfully';
				$conn->commit();
				$stmt = null;
				$conn = null;

			}catch(PDOException $e){
				$response['status'] = "error";
				$response['message'] = "an error occured";
			}
		}else{
			$response = $response;
		}
		header("Content-type : application/json");
		echo json_encode($response);
		
	}


?>