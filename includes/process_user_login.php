<?php
	//include db connection file
	require(__DIR__.'/db_parameters.php');

	//Declare empty varibles
	$username = $password ="";
	$usernameError = $passwordError ="";

	//This function will clean the input
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;

	}
	//Only process POST requests
	if('POST' == $_SERVER['REQUEST_METHOD']){
		if(strlen($_POST['username']) == 0){
			$usernameError = 'This field is required';
		}
		else{
			$username = test_input($_POST['username']);
		}

		if(strlen($_POST['password']) == 0){
			$passwordError = "This field is required";
		}
		else{
			$password = test_input($_POST['password']);
		}

		if( $usernameError == "" && $passwordError == ""){

			//check for matching user in the database
			try{
				$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$query = "SELECT * FROM registration WHERE username = ? AND password = ? ";
				$stmt = $conn->prepare($query);
				$conn ->beginTransaction();
				$stmt->execute(array($username,md5($password)));
				if(count($stmt->fetchAll())){
					//If user exists, start a new session for the user
					session_start();
					//$_SESSION['stdId'];
					$_SESSION['user'] = $username;
					//redirect the user to the homepage
					header("Location: ../index.php");
					$query = "SELECT student_id FROM registration WHERE username = '".$username."' ";
					$stmt = $conn->query($query);
					$row = $stmt->fetch();
					$_SESSION['student_id']  = $row['student_id'];
					$stmt = null; 
				}
				else{
					$passwordError = "Your Username or Password is incorrect";
				}
			}
			catch(PDOException $e ){

			}
			//close the connection to the database.
			$conn = null;
		}
	}
?>