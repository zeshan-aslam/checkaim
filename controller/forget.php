<?php
include('../config.php');
$emailid = $_POST['av_email'];

if(isset($_POST['sign_in'])){
	global $con;		
	$query = "select * from av_users where email = '$emailid'";
	$result = query($con,$query,1);	

	if($result){

		$sqldb = select("users","email = '$emailid'");
							
		while($rowdb = fetch($sqldb)){

			$userid = $rowdb['id'];
			$tokenid = base64_encode(serialize($userid));
		
		}

		try 
		{

			avaz_email($userid,'17',$tokenid,"");	

		} catch (Exception $e) {
		    var_dump($e);
		}

		           ////EMAIL FUNCTION/////
		
		
		$_SESSION['successr'] = "Reset password sent link on your email";
		redirect(SITEURL.'forgotpassword.php'.$slug);
		
		
	}else{
		
	
		$_SESSION['failurer'] = "Email Is Not Exists";
		redirect(SITEURL.'forgotpassword.php'.$slug);
	}
	
	
}

?>