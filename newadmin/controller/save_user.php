<?php
include('../../config.php');
if(isset($_POST['is_campaign'])){
	global $con;
	$userid = $_POST['userid'];
	$customeremail = $_POST['email'];
	
	$approvests = $_POST['av_campaign_status'];
	$av_campaignarray = unserialize(get_user_info($userid,'av_campaign',true));
	if(isset($_POST['av_campaign']) && $_POST['av_campaign'] != ''){
		$av_campaign = $_POST['av_campaign'];
	
	if(!in_array($av_campaign, $av_campaignarray)){
		$av_campaignarray[] = $av_campaign;
	}else{
		$_SESSION['failuireuser'] = "Campaigns already assigned to users.";
		redirect(ADMINURL.'user-view.php?action=view&uid='.$userid);
		exit;
	}
	}
	$avcamp = serialize($av_campaignarray);
	$data = array(
		'av_campaign_status' => $_POST['av_campaign_status'],
		'monthly_license_fee' => $_POST['monthly_license_fee'],
		'av_Currency' => $_POST['av_Currency'],
		'av_campaign' => $avcamp,
	);
	foreach($data as $key => $val){
		$vals = mysqli_real_escape_string($con,$val);
		$keys = mysqli_real_escape_string($con,$key);
		$success = update_user_meta($userid,$keys,$vals);	
	}
	
	if($success){
		$_SESSION['successuser'] = "Your Record is successfully saved";
		redirect(ADMINURL.'user-view.php?action=view&uid='.$userid);
		if($approvests == 'approve')
		{
			
			////// ////EMAIL FUNCTION/////
		      $sent_email = avaz_email($userid,'1',$tokenid);			
			    
		}
		else if($approvests == 'suspend')
		{		
			////// ////EMAIL FUNCTION/////
			
			 $sent_email = avaz_email($userid,'7',$tokenid);			
		}
		else
		{
			
			
		}
	}else{
		$_SESSION['failuireuser'] = "Please try again.";
		redirect(ADMINURL.'user-view.php?action=view&uid='.$userid);
	}
}
?>