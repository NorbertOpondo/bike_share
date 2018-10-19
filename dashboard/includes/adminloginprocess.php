<?php
	// include db connection file
	include __DIR__.'/dbstrings.php';
	//define empty variables
	$username = $password = "";
	$usernameError = $passwordError = "";

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

	if('POST' == $_SERVER['REQUEST_METHOD']){
		if(strlen($_POST['username']) == 0){
			$usernameError = "This field is required";
		}else{
			$username = test_input($_POST['username']);
		}
		if (strlen(trim($_POST['password'])) == 0){
			$passwordError = "You must enter a password in this field";
		}else{
			$password = $_POST['password'];
		}

		if($usernameError == "" && $passwordError ==""){
			//check for existance of user in the database
			try{
				$conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "connection succesful";
                $query = "SELECT * FROM administrators WHERE adminName = ? AND password = ? ";
                $stmt = $conn->prepare($query);
                $conn->beginTransaction();
               	$stmt->execute(array($username, md5($password)));
                if(count($stmt->fetchAll())){
                		session_start();
	                	$_SESSION['admin'] = $username;
	                	header("Location: /dashboard/admin_page.php");
	        
                }else{
                	$passwordError="*Your username or password is incorrect";
                }

            }catch(PDOException $e){
                
			}
			$conn=null;
			 /*try{
			 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			 	$query = "SELECT Id from administrators WHERE adminName = ? AND password = ?";
			 	$stmt = $conn->prepare($query);
			 	$conn->beginTransaction();
			 	$stmt->execute(array($username, hashPassword($password)));
			 	if(count($stmt->fetchAll())){
			 		//Start a session for the logged in admin
			 		session_start();
			 		header('location: ./adminPage.php');

			 		if (isset($_POST['rem'])){
			 			setcookie('username',$username, time()+60*60*7);
			 			setcookie('password',$password, time()+60*60*7);
			 		}
			 		
			 		
			 	}
			 }catch(PDOException $e){
			 	try{
                    $conn->rollback();
                    
                }catch(PDOException $e){

                }
			 }*/
		}
	}
?>