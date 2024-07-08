<?php
include('../../config.php');
if(isset($_POST['submit_email']))
{
	global $prefix,$con;
	$postid = isset($_GET['pid']) ? $_GET['pid'] : -1;
	$adminmail_from = mysqli_real_escape_string($con,$_POST['adminmail_from']);
	$adminmail_subject = mysqli_real_escape_string($con,$_POST['adminmail_subject']);
	$adminmail_message = mysqli_real_escape_string($con,$_POST['adminmail_message']);
	$adminmail_header = mysqli_real_escape_string($con,$_POST['adminmail_header']);
	$adminmail_footer = mysqli_real_escape_string($con,$_POST['adminmail_footer']);
	$success = mysqli_query($con,"update ".$prefix."adminmail set adminmail_from = '$adminmail_from', adminmail_subject = '$adminmail_subject', adminmail_message = '$adminmail_message', adminmail_header = '$adminmail_header', adminmail_footer = '$adminmail_footer'  where adminmail_id = '$postid' ");
	if($success){
			$_SESSION['successemail'] = "Record Saved successfully";
			redirect(ADMINURL.'edit_email'.'.php?id='.$postid);
		}else{
			$_SESSION['faliureemail'] = "Please try again";
			redirect(ADMINURL.'edit_email'.'.php?id='.$postid);
		}
}
?>