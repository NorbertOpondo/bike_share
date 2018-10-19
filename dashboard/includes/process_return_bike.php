<?php
	//include db connection file
	include __DIR__.'/dbstrings.php';

	//initialize empty input variables
	$student_id = "";
	$student_id_error = "";

	$response = array();

	//Process only POST requests
	if ("POST" == $_SERVER['REQUEST_METHOD']) {
		if(!preg_match("/^[a-zA-Z]{3}-[0-9]{3}-[0-9]{3}\\/[0-9]{4}$/", $_POST['student_id'])){
			$response['student_id_error'] = 'Please enter a valid ID number';
		}
		else{
			$student_id = $_POST['student_id'];
		}

		if (empty($response)) {
			try{
				$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT bikes_remaining from bikes_remaining";
                $conn->beginTransaction();
                $stmt = $conn->query($query);
                $row = $stmt->fetch();
                $bikes_left = $row['bikes_remaining'];
                $stmt = null;

                $query = "DELETE FROM hired_bikes WHERE student_id = ?";
                $stmt = $conn->prepare($query);
             	$stmt->execute(array($student_id));
                $conn->commit();
                $stmt = null;

                $bikes_left = $bikes_left+1;
                $query = "UPDATE bikes_remaining SET bikes_remaining = ? ";
                $conn->beginTransaction();
                $stmt = $conn->prepare($query);
                $stmt->execute(array($bikes_left));
                $conn->commit();
                $response['status'] = 'success';
                $stmt = null;

			}catch(PDOException $e){

				 $response['status'] = "error";
				 $response['message'] = "An error occured";
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