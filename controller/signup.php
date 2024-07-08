<?php
include('../config.php');

$userip = $_SERVER['REMOTE_ADDR'];



//$width = " <script>document.write(screen.width); </script>";
//$height = " <script>document.write(screen.height); </script>";

if(isset($_POST['join_avaz'])){
	$os_platform = $_POST['os_platform'];
$browser_name = $_POST['browser_name'];
$widthscreen =  $_POST["getsizepost"];

	unset($_POST['join_avaz']);
	$slug = $_POST['companyid'];
	$sql = select("company","company_slug='$slug'");
$fetchpost = fetch($sql);
$comid = $fetchpost['id'];
$leadgenid = leaduserinfo('id');


/* Check exist */
if($slug != ''){
	 if(mysqli_num_rows($sql) == 0){
		redirect(SITEURL);
		exit;
	}  
}

$av_campaign_status = get_user_info($leadgenid, 'av_campaign_status', true);
if($slug != '' && $av_campaign_status != 'approve'  && $leadgenid != '' && leaduserinfo('type') == 3){
	$av_campaign = unserialize(get_user_info($leadgenid, 'av_campaign', true));
		redirect(SITEURL);
		exit;

}else if($slug != '' && $av_campaign_status == 'approve' && $av_campaign_status != '' && $leadgenid != '' && leaduserinfo('type') == 3){
	$av_campaign = unserialize(get_user_info($leadgenid, 'av_campaign', true));
	if(!in_array($comid,$av_campaign)){
		redirect(SITEURL);
		exit;
	}
}else{} 

/* End Here*/

	$fields = array(
		'email' => mysqli_real_escape_string($con,$_POST['av_email']),
		'date' => date('Y-m-d h:i:s'),
		'status' => 1,
		'type' => 2,
		'companyid' => $comid,
		'user_id' => $leadgenid,
		
	);
	$_POST['av_question1res'] = serialize($_POST['av_question1']);
		$_POST['av_question2res'] = serialize($_POST['av_question2']);
	$lastinsert_id = insert('joinavaz', $fields);
	unset($_POST['av_question1']);
	unset($_POST['av_question2']);
	unset($_POST['companyid']);
	if($lastinsert_id){
		foreach($_POST as $key => $val){
			$vals = mysqli_real_escape_string($con,$val);
			$ok = update_joinavaz_meta($lastinsert_id,$key,$vals);
		}
		if(leaduserinfo('type') == 3){
			$tableaff = $prefix."affilates_charges";
			$data_analytic = $prefix."data_analytic";
			$companydatas = unserialize(base64_decode(get_config_meta('company_data', $comid, true)));
			$companydata  = unserialize($companydatas['config']);
			$balance = leaduserinfo('balance');
			if($balance > 0){
				
				
				$submissionsval = $companydata['submission_amt'];
				mysqli_query($con, "insert into $tableaff (user_id, lead_type, date, campagin_id,affilate_charges) values ('$leadgenid', 'submissions', Now(), '$comid', '$submissionsval')");
				$balace = $balance - $submissionsval;
				check_transaction($balace);
				mysqli_query($con, "update av_users set balance = '$balace' where id='$leadgenid'");
				
				//$width = " <script>document.write(screen.width); </script>";
				//$height = " <script>document.write(screen.height); </script>";
	
				// $Getsizescreen = $width.'X'.$height;
				 
				mysqli_query($con, "insert into $data_analytic (user_id,campaign_id,ip_address, browser_name,operating_system,time_and_date,screen_size,type) values ('$leadgenid', '$comid', Now(),'$browser_name','$os_platform',Now(),'$widthscreen','submission')");
				$lastid =$con->insert_id;				
				$lastidurl = base64_encode(serialize($lastid));
				$comiddb = base64_encode(serialize($comid));
			}else{
				redirect(SITEURL);
			}
		}
		//$hello = 'hello';
		$_SESSION['successf'] = "Many thanks for your time we will be in touch shortly!";
		redirect(SITEURL.$slug.'&cmid='.$comiddb.'&subid='.$lastidurl);
	}else{
		$_SESSION['failuref'] = mysqli_error($con);
		redirect(SITEURL.$slug);
	}
}

if(isset($_POST['sign_in'])){
	global $con;
	unset($_POST['termsCondn']);
	unset($_POST['terms']);
	unset($_POST['sign_in']);
	$email = $_POST['av_email'];
	$sql    = select('users',"email = '$email'");
	$result = mysqli_query($con,$sql);
	if(mysqli_num_rows($result)>0)
	{
	   $_SESSION['failurer'] = "Email Already Exists";
		redirect(SITEURL.'signup.php'.$slug);
		exit;
	}
	 if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
			$secretKey = '6Ledla0UAAAAAKz1JkM06VA2e2kOg3ZViBddnrM9';
			 $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 	
			$responseData = json_decode($verifyResponse); 	
			 if(!$responseData->success){

				  $_SESSION['failurer'] = "Robot verification failed, please try again.";
					redirect(SITEURL.'signup.php'.$slug);
					exit;
			 }
		}else{
			 $_SESSION['failurer'] = 'Please check on the reCAPTCHA box.';
			 redirect(SITEURL.'signup.php'.$slug);
					exit;
			  
		}
	$today 			    = date("Y-m-d");
	$rand	=	rand(0,10000);
	$pass	=	mysqli_real_escape_string($con,$_POST['first_name'].$rand);
	$data = array(
		'email' => mysqli_real_escape_string($con,$_POST['av_email']),
		'password' => md5($pass),
		'date' => date('Y-m-d h:i:s'),
		'status' => 1,
		'type' => 3,
	);
	unset($_POST['g-recaptcha-response']);
	unset($_POST['edit_contact_info']);
	unset($_POST['countrylst']);
	$lastinsert_id = insert('users', $data);
	if($lastinsert_id){
		$_POST['av_campaign_status'] = 'waiting';
		foreach($_POST as $key => $val){
			$vals = mysqli_real_escape_string($con,$val);
			$keys = mysqli_real_escape_string($con,$key);
			$ok = update_user_meta($lastinsert_id,$keys,$vals);	
		}
			
					////// ////EMAIL FUNCTION/////
					
					$sent_email = avaz_email($lastinsert_id,'14',$tokenid,$pass);
				
			$_SESSION['successr'] = "You have registered successfully. Your password will be sent through email";
			redirect(SITEURL.'signup.php'.$slug);
		
	}else{
		$_SESSION['failurer'] = mysqli_error($con);
		redirect(SITEURL.'signup.php'.$slug);
	}
}

if(isset($_POST['av_email'])){
	global $prefix, $con;

	$emailid = $_POST['av_email'];
	 $query = "select * from ".$prefix."joinavaz where email = '$emailid'";
	$result = query($con,$query,1);
	if($result){
		echo 'false';
	}else{
		echo 'true';
	}
	die();
}
?>
<script>
var txt = "";
txt += screen.width + "*" + screen.height;
document.getElementById("getsize").innerHTML = txt;
</script>