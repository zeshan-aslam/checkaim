<?php
include('../config.php');

$response["status"] = false;

if(isset($_POST['contactus']))
{
	global $con;		

	try 
	{
		$response["message"] = "Thank you for contacting us!";
		$response["status"] = true;
		$response["data"] = $_POST;

		$response["email"] = contact_email($_POST, 20);	
	} 
	catch (Exception $e) 
	{
	    var_dump($e);
	}
}
else
{
	$response["message"] = "Oops! something went wrong";
}


echo json_encode($response);

?>