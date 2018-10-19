<?php
	//include the db connection file...
	require(__DIR__.'/db_parameters.php');
	session_start();

	#Declare empty varibles...
	$bikes_left = "";
	$id_number = $from = $to = $gender = "";
	$id_numberError = $fromError = $toError = $genderError = "";

	function test_input($data){
		$data = stripslashes($data);
		$data = trim($data);
		$data = htmlspecialchars($data);

		return $data;
	}

	$response = array();

	#only process POST requests..
	if ('POST' == $_SERVER['REQUEST_METHOD']) {
		if(!preg_match("/^[a-zA-Z]{3}-[0-9]{3}-[0-9]{3}\\/[0-9]{4}$/", $_POST['id_number'])){
			$response['id_numberError']='Please enter a valid ID number';
		}
		else{
			$id_number = test_input($_POST['id_number']);
		}

		if(strlen($_POST['from']) == 0){
			$response['fromError'] = 'This field cannot be left blank';
		}else{
			$from = $_POST['from'];
		}

		if(strlen($_POST['return_date']) == 0){
			$response['toError'] = 'This field cannot be left blank';
		}else{
			$to = $_POST['return_date'];
		}
		if (isset($_POST['gender'])) {
			$gender = $_POST['gender'];
		}else{
			$response['genderError'] = 'Your gender is required for a suitable bike';
		}
		
		if (empty($response)) {
			# initiate database connection...
			$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
			try{
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT bikes_remaining from bikes_remaining";
                $conn->beginTransaction();
                $stmt = $conn->query($query);
                $row = $stmt->fetch();
                $bikes_left = $row['bikes_remaining'];
                $stmt = null;

                if ($bikes_left > 0 ) {

                	$check_existing_id = "SELECT * FROM hired_bikes where student_id = ? ";
                	
					$stmt=$conn->prepare($check_existing_id);
					$stmt->execute(array($id_number));
					if (count($stmt->fetchAll())) {
						$response['id_numberError']="***ONLY 1 BIKE PER USER IS ALLOWED, PLEASE RETURN YOUR BIKE TO GET ANOTHER ONE";
						$conn->rollback();
						$stmt = null;
						$conn = null;
					}else{
					$query = "INSERT INTO hired_bikes(student_id,date_aquired,return_date,gender) VALUES(?,?,?,?)";
                	$stmt = $conn->prepare($query);
                	$stmt->execute(array($_SESSION['student_id'],$from,$to,$gender));
                	$response['status'] = 'success';
                	$conn->commit();
                	$stmt = null;
      
					$bikes_left = $bikes_left-1;
                	$query = "UPDATE bikes_remaining SET bikes_remaining = ? ";
                	$conn->beginTransaction();
                	$stmt = $conn->prepare($query);
                	$stmt->execute(array($bikes_left));
                	$conn->commit();
                	$stmt = null;

					}


                }else{
                	$response['id_numberError'] = 'THERE ARE NO BIKES LEFT AT THE DOCKING STATION';
                }
                

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