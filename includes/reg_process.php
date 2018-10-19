<?php
	// include database connection file
	include __DIR__."/db_parameters.php";

	// define function to clean input from user
	function test_input($data){
		$data = trim($data);
    	$data = stripslashes($data);
    	$data = htmlspecialchars($data);

    return $data;
	} 
	
	//defining variables and setting to empty
	$first_nameError = $last_nameError = $studIdError = $emailError = $passwordError = $confPasswordError = $usernameError=$sameId="";
	$first_name = $last_name = $studId = $email = $password = $confpassword = $username ="";

	//only process POST requests
	$response = array();
	if ("POST" == $_SERVER["REQUEST_METHOD"]){
		if (strlen($_POST['name']) == 0){
			$response['first_nameError'] = "First name is required";
		} else{
			$first_name = test_input($_POST['name']);
		}
		if (strlen($_POST['last_name']) == 0){
			$response['last_nameError'] = "Last name is required";
		} else {
			$last_name = test_input($_POST['last_name']);
		}
		if (!preg_match("/^[a-zA-Z]{3}-[0-9]{3}-[0-9]{3}\\/[0-9]{4}$/", $_POST['stud_id'])){
			$response['studIdError'] ="Invalid student number";
		} else{
			$studId = test_input($_POST['stud_id']);
		}
		if (strlen($_POST['email']) == 0){
			$response['emailError'] ="Your email is required";
		} else {
			$email = test_input($_POST['email']);
		}
		if (strlen($_POST['password']) < 5){
			$response['passwordError'] = "Password must be at least 6 characters";
		}
		if (strlen($_POST['confirm_password']) == 0){
			$response['confPasswordError'] = "You must enter the password twice";
		}
		if(strcmp($_POST['password'], $_POST['confirm_password']) == 0){
			$password = test_input($_POST['password']);
		}else{
			$response['passwordError'] = "the passwords do not match";
		}
		/*if (strlen($_POST['password']) > 0 && strlen($_POST['confirm_password']) > 0){
			if (strcmp($_POST['password'], $_POST['confirm_password'] != 0 )){
				$confPasswordError = "The 2 passwords need to match";
			} else{
				$password = test_input($_POST['password']);
			}
		}*/
		if (strlen($_POST['username']) == 0){
			$response['usernameError']  = "you must set a username";
		} else {
			$username = test_input($_POST['username']);
		}
	
		// check if there are no errors duirng form submission
		if(empty($response)){
			try{
					//initiate connection to database
					$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);

					//setting PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$check_existing_id = "SELECT * FROM registration where student_id = ? ";
					//start of transcation
					$conn->beginTransaction();
					$stmt=$conn->prepare($check_existing_id);
					$stmt->execute(array($studId));
					if(count($stmt->fetchAll())){
						$response['sameId']="THIS STUDENT ID HAS ALREADY BEEN USED";
						$stmt = null;
						$conn->rollback();
					}
					else{
						$query = "INSERT INTO registration(firstName,lastName,student_id,email,password,username)VALUES(?,?,?,?,?,?)";
						$stmt = $conn->prepare($query);
						// insert form values into database
						$stmt->execute(array(ucfirst($first_name),ucfirst($last_name),strtoupper($studId),$email,MD5($password),$username));
						$response['status'] = 'success';
						$response['message'] = 'form submission was succesful';
						//save the changes made in the database
						$conn->commit();
						$stmt = null;
						$conn = null;
					}
				}
				catch(PDOException $e){
					$response['status'] = 'error';
					$response['message'] = 'an error occured';
					//rollbask changes in the databse if an error is encountered
					$conn->rollback();
				}
				//close the connection to the database
				
		}else{
			$response = $response;
		}
		header('Content-type: application/json');
		echo json_encode($response);
		
	}


?>