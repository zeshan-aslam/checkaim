<?php
include('../config.php');
if(isset($_POST['add_money'])){
	$leadgenid = leaduserinfo('id');
	$data = array(
		'account_name' => $_POST['account_name'],
		'account_no' => $_POST['account_no'],
		'sort_code' => $_POST['sort_code'],
		'swift_code' => $_POST['swift_code'],
		'pay_mode' => isset($_POST['pay_via_paypal']) ? 'Paypal' : 'Bank',
		'payment_ref' => $_POST['payment_ref'],
		'amount' => $_POST['amount'],
		'date' => date('Y-m-d h:i:s'),
		'status' => 'waiting',
		'leadgen_id' => $leadgenid,
	);
	$result = insert('addmoney',$data);
	if($result){
		$_SESSION['successmoney'] = "Money Successfully added";
		redirect(LEADURL.'index.php?Act=add_money');
	}else{
		$_SESSION['faluiremoney'] = "Please try again";
		redirect(LEADURL.'index.php?Act=add_money');
	}
}
?>