<?php 
include('httpdocs/config.php'); 
$sql = select("joinavaz");
while($row = fetch($sql)){
	$curdate = date('Y-m-d');
	$postid = $row['id'];
	$campid = $row['companyid'];
	$datae =  date('Y-m-d', strtotime($row['date']));
	$date =  date('Y-m-d', strtotime($row['date']. ' + 14 days'));
	$tableaff = $prefix."affilates_charges";
	if(strtotime($curdate) > strtotime($date)){
		if(get_avaz_info($row['id'],'is_confirmed',true) != 1 && get_avaz_info($row['id'],'is_confirmed',true) != 2){
			
			$success = update_joinavaz_meta($postid,'is_confirmed',1);
			
			$myuserid = $row['user_id'];
			$companydatas = unserialize(base64_decode(get_config_meta('company_data', $campid, true)));
			$companydata  = unserialize($companydatas['config']);
			$qlval = $companydata['qualified_lead_amt'];
			
			$sqls = select('users',"id='$myuserid'");
			$rowsd = fetch($sqls);
			$balance = $rowsd['balance'];
				if($balance > 0){
					mysqli_query($con, "insert into $tableaff (user_id, lead_type, date, campagin_id,affilate_charges) values ('$myuserid', 'confirm_leads', Now(), '$campid','$qlval')");
					$balace = $balance - $qlval;
					check_transaction($balace);
					mysqli_query($con, "update av_users set balance = '$balace' where id='$myuserid'");
					
				}
				else
				{
					 ////EMAIL FUNCTION/////
					$sent_email = avaz_email($myuserid,'15',$tokenid);
					
				}
			echo $datae.'-------'.$date.'<br>';
		}
	}
	
}
//mail("churchcard1@gmail.com",'test','teeee');
?>