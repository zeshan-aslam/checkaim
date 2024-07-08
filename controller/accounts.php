<?php
include('../config.php');
if(isset($_POST['action']) && $_POST['action'] == 'uploadimage'){
	 $dir=ROOT."/upload/leadgen/";

	$imge = $_FILES['ajax_file'];
	$leadgenid 	= $_POST['leadgenid'];
	$filename = $leadgenid.'-leadgen-'.$imge['name'];
	$types = array('image/jpeg', 'image/gif', 'image/png');
	if (in_array($imge['type'], $types)) {
	if($imge['size']<=10000000){ $destination=$dir.$filename; 
		$isuploaded=move_uploaded_file($imge['tmp_name'],$destination); 
	if($isuploaded){ 
	  $result = update_user_meta($leadgenid, 'av_profile_image', $filename);
	if($result){
		echo json_encode(array("status"=>"success","message"=>"Image has been uploaded successfully"));
	}else{
		echo json_encode(array("status"=>"fail","message"=>"Some error to upload this Image"));
	}
	}else{
		echo json_encode(array("status"=>"fail","message"=>"Some error to upload this Image"));
	}
	}else{
	echo json_encode(array("status"=>"fail","message"=>"Sorry your Image was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes."));	
	}
	}else{
	echo json_encode(array("status"=>"fail","message"=>"Image size can't more than 1 MB"));
	}
}

if(isset($_POST['edit_contact_info'])){
	global $con;
	$leadgenid = leaduserinfo('id');
	foreach($_POST as $key => $val){
		$vals = mysqli_real_escape_string($con,$val);
		 $result = update_user_meta($leadgenid, $key, $vals);
	}
	
	if($result){
		$_SESSION['successprofile'] = "Contact Info Updated Successfully..";
		redirect(LEADURL.'index.php?Act=accounts');
	}else{
		$_SESSION['faluireprofile'] = "Contact Info Updated Successfully..";
		redirect(LEADURL.'index.php?Act=accounts');
	}
}

if(isset($_POST['save_login'])){
	global $con;
	$tablename = $prefix."users";
	$leadgenid = leaduserinfo('id');
	$emailid = mysqli_real_escape_string($con,$_POST['login_email']);
	$newpassword = mysqli_real_escape_string($con,$_POST['new_password']);
	$confirmpassword = mysqli_real_escape_string($con,$_POST['con_password']);
	if($emailid == ""){
		$_SESSION['faluireprofile']	= "Don't Leave Email Id Blank";
		redirect(LEADURL.'index.php?Act=accounts');
		exit;
	}
	
	$sql = select("users","id = '$leadgenid'");
	$row = fetch($sql);
	
	if($row['email'] != $emailid){
		if(email_exist($emailid)){
			$_SESSION['faluireprofile']	= "Email is already exist";
			redirect(LEADURL.'index.php?Act=accounts');
			exit;
		}
	}
	
	
	if($newpassword == '' && $confirmpassword == ''){
		$res = mysqli_query($con,"update $tablename set email = '$emailid' where id = '$leadgenid'");
		if($res){
			update_user_meta($leadgenid, 'av_email', $emailid);
			$token = $_SESSION['my_front_token'];
			$_SESSION[$token] = $emailid;
		}
		
		
		$_SESSION['successprofile'] = "Email Saved successfully";
		redirect(LEADURL.'index.php?Act=accounts');
	}else{
		if($newpassword == '' || $confirmpassword == ''){
			$_SESSION['faluireprofile']	= "Don't Leave Password or Confirm Password Id Blank";
			redirect(LEADURL.'index.php?Act=accounts');
			exit;
		}
		if($newpassword == $confirmpassword){
			$md5 = md5($newpassword);
			$res = mysqli_query($con,"update $tablename set email = '$emailid',password = '$md5' where id = '$leadgenid'");
			if($res){
				update_user_meta($leadgenid, 'av_email', $emailid);
				$token = $_SESSION['my_front_token'];
			$_SESSION[$token] = $emailid;
			}
			
			////// ////EMAIL FUNCTION/////
		   $sent_email = avaz_email($leadgenid,'12',$tokenid);
			
			
			$_SESSION['successprofile'] = "Login Info Saved successfully";
			redirect(LEADURL.'index.php?Act=accounts');
		}else{
			$_SESSION['faluireprofile']	= "New password and Confirm Password Should be Same !!";
			redirect(LEADURL.'index.php?Act=accounts');

		}
	}
	
}
?>