<?php
require_once('../../config.php');

$loggedinuser = user();


if(isset($_REQUEST['clientlogin']))
{
	global $con;

	$status = false;
	$data = array();
	$uid = $_REQUEST["uid"];
	
//	if($loggedinuser!='')
//	{
		if($uid > 0)
		{
			$query = " Select * from av_users where id='$uid' ";
			$userlogin = mysqli_query($con,$query);
			if(mysqli_num_rows($userlogin) > 0)
			{
				$fetchuser = fetch($userlogin);
				$userid = $fetchuser['id'];

				$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$string = '';
				$length = 10;
				for ($p = 0; $p < $length; $p++) {
					$string .= $characters[mt_rand(0, strlen($characters))];
				}

				$user = $fetchuser['email'];
				$random = $string;
				$_SESSION['my_front_token'] = $random;
				$_SESSION[$random] = $user;
				$_SESSION['successlogin'] = 'front Login Successfully';
				$_SESSION['successloginid'] = $userid;

				redirect(SITEURL.'dashboard/index.php?Act=home');
			}
		}
		else
		{
			$response["status"] = false;
			$response["message"] = "Invalid Client Information";		
		}
//	}
//	else
	//{
//		$response["status"] = false;
	//	$response["message"] = "Unauthorized Access";
//	}

	echo json_encode($response);

	die();
		
}


if(isset($_REQUEST['clientdelete']))
{
	global $con;

	$status = false;
	$data = array();
	$uid = $_REQUEST["uid"];
	
	if($loggedinuser != '')
	{
		if($uid > 0)
		{
			$query = " Select * from av_users where id='$uid' ";
			$userlogin = mysqli_query($con,$query);
			if(mysqli_num_rows($userlogin) > 0)
			{
				$query = " Update av_users set deleted = 1 where id='$uid' ";
				$queryResult = mysqli_query($con,$query);

				$response["status"] = mysqli_affected_rows($con) > 0;
				$response["message"] = "Client deleted";		
			}
		}
		else
		{
			$response["status"] = false;
			$response["message"] = "Client not found";		
		}
	}
	else
	{
		$response["status"] = false;
		$response["message"] = "Unauthorized Access";
	}

	echo json_encode($response);

	die();
		
}



?>