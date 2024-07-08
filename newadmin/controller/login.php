<?php
include('../../config.php');
session_start();
if(isset($_POST['username']))
{

	$username = $_POST['username'];
	$pass = $_POST['password'];
	$type = "admin";
	
	 $result = login($con,$username, $pass, $type); 
	 $getemailbaseid = select("users where email='$username'");
	 while($rowda = fetch($getemailbaseid)){  
		
			$level =  $rowda['level'];
			$_SESSION["checklevel"] = $level;
	 }

	if(!$result){
		$_SESSION['failure'] = 'Please check your Username or Password';	
		redirect(ADMINURL.'dashboard.php');
	}
	else
	{
		
		redirect(ADMINURL.'dashboard.php');
	}	
}
?>