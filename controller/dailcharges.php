<?php
include('httpdocs/config.php');
$sql = select("users","type='3'");
while($row = fetch($sql)){
	$curdate = date('Y-m-d');
	$userid = $row['id'];	
	$balance = $row['balance'];
	$tableaff = $prefix."affilates_charges";
	$monthly_license_fee = number_format(get_user_info($userid,'monthly_license_fee',true),2);
	 $no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('y'));
	 $charges = $monthly_license_fee / $no_of_days_in_month;
	 $tcharges = number_format($charges,2);
	 if($balance > 0){
		 mysqli_query($con, "insert into $tableaff (affilate_charges, user_id, lead_type, date) values ('$tcharges', '$userid', 'daily_charges', Now())");
		$balace = $balance - $tcharges;
		mysqli_query($con, "update av_users set balance = '$balace' where id='$userid'");
	 }
}
?>