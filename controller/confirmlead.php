<?php
include('../config.php');
if(isset($_POST['save_lead'])){
	$success = false;
	$hiddenid = $_POST['hiddenid'];
	$is_confirmed = $_POST['is_confirmed'];
	$campid = $_POST['campid'];
	$cid = $_GET['cid'];
	$sql = select("joinavaz", "id = '$hiddenid'");
	$row = fetch($sql);
		$curdate = date('Y-m-d');
		$postid = $row['id'];
		$date =  date('Y-m-d', strtotime($row['date']. ' + 14 days'));
			if(get_avaz_info($row['id'],'is_confirmed',true) != 1 && get_avaz_info($row['id'],'is_confirmed',true) != 2){
				
				$success = update_joinavaz_meta($postid,'is_confirmed',$is_confirmed);
			}
	if($success){
		if($is_confirmed == 1){
			$myuserid = leaduserinfo('id');
			$companydatas = unserialize(base64_decode(get_config_meta('company_data', $campid, true)));
			$companydata  = unserialize($companydatas['config']);
			$qlval = $companydata['qualified_lead_amt'];
			$tableaff = $prefix."affilates_charges";
			$sqls = select('users',"id='$myuserid'");
			$rowsd = fetch($sqls);
			$balance = $rowsd['balance'];
				if($balance > 0){
					mysqli_query($con, "insert into $tableaff (user_id, lead_type, date, campagin_id,affilate_charges) values ('$myuserid', 'confirm_leads', Now(), '$campid','$qlval')");
					$balace = $balance - $qlval;
					mysqli_query($con, "update av_users set balance = '$balace' where id='$myuserid'");
				}	
		}
		if($is_confirmed == 1){ $msg = "Lead confirmed successfully"; }else{ $msg = "Lead cancelled successfully"; }
		$_SESSION['successlead'] = $msg;
		redirect(LEADURL.'?Act=submission_view&cid='.$cid);
	}else{
		$_SESSION['faluirelead'] = "Please try again.";
	}
}
?>