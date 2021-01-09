<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$mysql_host = "localhost";
	$mysql_username = "root";
	$mysql_password = "";
	$mysql_database = "emp_details";
    
    $userName = $_POST["user_name"];
    $userMobileNo = $_POST["user_mobile_no"];
    $userEmail = $_POST["user_email"];
    $userAge = $_POST["user_age"];
    $userExperience = $_POST["user_experience"];
    $userSkillsArr = $_POST["skills"];

	if (empty($userName)){
		die("Please enter your name");
	}
	if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
		die("Please enter valid email address");
	}
		
	if (empty($userMobileNo)){
		die("Please Enter Mobile No");
    }	
    if (empty($userAge)){
		die("Please Enter Your Age");
    }	
    if (empty($userExperience)){
		die("Please Enter Your Experience");
    }	
    if (empty($userSkillsArr)){
		die("Please Select One or Move Skills");
	}	
    foreach($userSkillsArr as $skill)  
    {  
       $skillStr .= $skill.",";  
    }  

	$mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
	
	if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}	
	
	$statement = $mysqli->prepare("INSERT INTO users_data (uname, mobileno, email, age, experience, skills) VALUES(?, ?, ?)"); 
	$statement->bind_param($userName, $userMobileNo, $userEmail, $userAge, $userExperience, $skillStr); 
	
	if($statement->execute()){
		print "Employee Details save successfully";
	}else{
		print $mysqli->error;
	}
}
?>