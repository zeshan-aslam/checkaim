<?php
include('../../config.php');
if(isset($_POST['submit_setting'])){
	global $con;
	$data = array(
		'account_name' => $_POST['account_name'],
		'account_number' => $_POST['account_number'],
		'sort_code' => $_POST['sort_code'],
		'swift_code' => $_POST['swift_code'],
		'paypal_id' => $_POST['paypal_id'],
		'monthly_license_fee' => $_POST['monthly_license_fee'],
		'Compnay_name' => $_POST['Compnay_name'],		
		'Address_name' => $_POST['Address_name'],
		'Post_code' => $_POST['Post_code'],
		'company_name' => $_POST['company_name'],
		'vat_tax_number' => $_POST['vat_tax_number'],
	);
	
	foreach($data as $key => $val){
		$vals = mysqli_real_escape_string($con,$val);
		$result = update_option_meta($key, $vals);
	}
	
	if($result){
		$_SESSION['successsetting'] = "Payment information saved successfully";
		redirect(ADMINURL.'settings.php');
	}else{
		$_SESSION['faliuresetting'] = "Please try again";
		redirect(ADMINURL.'settings.php');
	}
}
?>