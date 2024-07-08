<?php
include('../../config.php');
$admin_id = $_SESSION["checklevel"];
if(isset($_POST['submit_admin'])){
	global $con;
		$pass	=	mysqli_real_escape_string($con,$_POST['password']);
		$typedb	= '1';
		$data = array(				
		'email' => mysqli_real_escape_string($con,$_POST['email']),
		'password' => md5($pass),
		'date' => date('Y-m-d h:i:s'),
		'status' => mysqli_real_escape_string($con,$_POST['status']),
		'type' => mysqli_real_escape_string($con,$typedb),
		'companyid' => mysqli_real_escape_string($con,$_POST['companyid']),
		'balance' => mysqli_real_escape_string($con,$_POST['balance']),
		'level' => mysqli_real_escape_string($con,$_POST['level']),
		'admin_id' => mysqli_real_escape_string($con,$admin_id),	
	);	
	$result = insert('users',$data);	
	if($result){
		$_SESSION['successadmin'] = "Admin Successfully added";
		redirect(ADMINURL.'masteradmin.php');
	}else{
		$_SESSION['faluireadmin'] = "Please try again";
		redirect(ADMINURL.'masteradmin.php');
	}
}
?>