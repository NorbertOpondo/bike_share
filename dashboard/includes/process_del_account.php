<?php
	//include database connection file
	include __DIR__.'/dbstrings.php';

	//define and initialize empty input varibales
	$student_id = "";
	$student_id_error = "";

	$response = array();

	//process only POST requests
	if ('POST' == $_SERVER['REQUEST_METHOD']) {
		if(!preg_match("/^[a-zA-Z]{3}-[0-9]{3}-[0-9]{3}\\/[0-9]{4}$/", $_POST['student_id'])){
			$response['student_id_error'] = 'Please enter a valid ID number';
		}
		else{
			$student_id = $_POST['student_id'];
		}
		if(empty($response)){
			try{
				$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "DELETE FROM REGISTRATION WHERE student_id = ?";
                $stmt = $conn->prepare($query);
                $conn->beginTransaction();
                $stmt->execute(array($student_id));
                $response['status'] = "success";
                $response['message'] = "Account deleted successfuly";
                $conn->commit();
			}catch(PDOException $e){
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