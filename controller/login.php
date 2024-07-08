<?php
include('../config.php');
if(isset($_POST['action']) && $_POST['action'] == 'sign_in'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$type = 3;
	$ok = login($con,$username, $password, $type);
	
     $useriddb = $_SESSION['successloginid'];
			 
	if($ok){
		
		 $sts = get_user_info($useriddb,'av_campaign_status',true); 
		 if($sts == 'approve')
		 {
			 
			 echo json_encode(array('success' => true, 'url' => LEADURL.'index.php?Act=home', 'message' => 'Login successfully.'));
		 }
		 else if ($sts == 'waiting')
			{
				echo json_encode(array('success' => false, 'message' => 'Your account is pending approval please wait.'));
				
			}
			else if ($sts == 'suspend')
			{
				 echo json_encode(array('success' => false, 'message' => 'Your Account has been SUSPENDED please contact us.'));
			}
	 
		
		//echo json_encode(array('success' => true, 'url' => LEADURL.'index.php?Act=home', 'message' => 'Login successfully.'));
		
		//echo json_encode(array('success' => true, 'url' => LEADURL.'index.php?Act=home', 'message' => 'Login successfully.'));
	}else{
		echo json_encode(array('success' => false, 'message' => 'Your detail not match form database'));
	}
	die;
}
?>