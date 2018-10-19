<?php
	// include database connection strings
	include __DIR__.'/db_parameters.php';

	//declare empty input variables
	$student_id = $current_password = $new_password = $conf_new_password = "";
	$studentId_error = $current_passwordError = $new_passwordError = $conf_new_passwordError = "";


	$response = array();

	if ("POST" == $_SERVER['REQUEST_METHOD']) {
		if(strlen($_POST['student_id']) == 0){
			$response['studentId_error'] = "You must provide your current username";
		}else{
			$student_id = $_POST['student_id'];
		}
		if(strlen($_POST['new_password']) < 5 ) {
			$response['new_passwordError'] = "Password must be at least 6 characters";
		}

		if(strlen($_POST['conf_new_password']) == 0){
			$response['conf_new_passwordError'] = "You must Enter the password twice";
		}

		if (strcmp($_POST['new_password'], $_POST['conf_new_password']) == 0) {
			$new_password = md5($_POST['new_password']);
		}else{
			$response['conf_new_passwordError'] = "The passwords do not match";
		}

		if (empty($response)) {
			try{
				$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);

				//setting PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$query = "UPDATE registration SET password = ? WHERE student_id = ? ";
				$conn->beginTransaction();
				$stmt = $conn->prepare($query);
				$stmt->execute(array($new_password,$student_id));
				$response['status'] = 'success';
				$response['message'] = 'Password changed successfully';
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