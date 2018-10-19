<?php
    require('../dashboard/includes/dbstrings.php');
    session_start();
    if('GET' == $_SERVER['REQUEST_METHOD']){
        try{
            //initiate connection to database
            $conn = new PDO("mysql:host=$servername;dbname=bike_sharing",$usname,$pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT firstName,lastName,student_id,email,username FROM registration ORDER BY firstName ASC" ;
            $results = $conn->query($query);
            header('Content-type:application/json');
            echo json_encode($results->fetchAll(PDO::FETCH_ASSOC));
            $conn = null;
        } catch(PDOException $e){

        }
    }
?>
