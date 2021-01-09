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
    $skillStr = '';	
    foreach($userSkillsArr as $skill)  
    {  
       $skillStr .= $skill."/";  
    }  

    if ($_FILES["user_resume"]["size"] > 500000) {

        die("Sorry, your file is too large.");
      
    }
    $target_dir = "/";
    $target_file = $target_dir . basename($_FILES["user_resume"]["name"]);
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($fileType != "pdf" && $fileType != "doc " && $fileType != "docx") {
        die("Sorry, only Doc, Docx, pdf, and text files are allowed.");
    }
    

    if (!move_uploaded_file($_FILES["user_resume"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
     }
	$mysqli = new mysqli($mysql_host,$mysql_username,$mysql_password,$mysql_database);
	
	if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}	
	
	$statement = $mysqli->prepare("INSERT INTO users_data (uname, mobileno, email, age, experience, skills, uresume) VALUES(?,?,?,?,?,?,?)"); 
	$statement->bind_param($userName, $userMobileNo, $userEmail, $userAge, $userExperience, $skillStr, $target_file); 
	
	if($statement->execute()){
		print "Employee Details save successfully";
	}else{
		print $mysqli->error;
	}
}
?>
