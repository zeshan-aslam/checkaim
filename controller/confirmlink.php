<?php
include('../config.php');
global $con;
$tablename = $prefix."users";

$uid = $_POST['uid'];


$uids = unserialize(base64_decode($uid)); 
$tokenid = base64_encode(serialize($uid)); 


$sqldb = select("users","id =$uids");
								
			while($rowdb = fetch($sqldb)){
				
				$customeremail = $rowdb['email'];
				
			
			}

	    $newpassword = mysqli_real_escape_string($con,$_POST['new_password']);
		$confirmpassword = mysqli_real_escape_string($con,$_POST['con_password']);

		if(isset($_POST['passwordreset'])){
			
			if($newpassword == $confirmpassword){
					$md5 = md5($newpassword);
					$res = mysqli_query($con,"update $tablename set password = '$md5' where id = '$uids'");
					if($res){				
					
					}					
					 ////// ////EMAIL FUNCTION/////
					$sent_email = avaz_email($uids,'12',$tokenid,"");
				
						
						
				$_SESSION['successr'] = "Your password Changed successfully";
				redirect(SITEURL.'confirmlink.php'.$slug);
					 
					 
					
					 
				}else{
					
					 $_SESSION['failurer']	= "New password and Confirm Password Should be Same !!";	
					 redirect(SITEURL.'confirmlink.php?token='.$tokenid);
				}
}



?>