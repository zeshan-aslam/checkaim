<?php
include('../../config.php');
if(isset($_POST['submit_post']))
{
	global $prefix,$con;
		$target = ROOT.'/img/';
		$target = $target . basename( $_FILES['logo_name']['name']) ;
		$filename = $_FILES['logo_name']['name'];
		$types = array('image/jpeg', 'image/gif', 'image/png');
		if(!empty($_FILES['logo_name']['name'])){
			if (in_array($_FILES['logo_name']['type'], $types)) {
				move_uploaded_file($_FILES['logo_name']['tmp_name'], $target);
				$_POST['config']['logo_name'] = $filename;
			} else {
				$_SESSION['faliureconfig'] = "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes.";
				redirect(ADMINURL.'configration.php');
				exit;
			} 
		}
		$inputs = $_POST['config'];
		foreach($inputs as $key => $val){
			$c_key = mysqli_real_escape_string($con,$key);
			$c_val = mysqli_real_escape_string($con,$val);
			$query = "select * from ".$prefix."config where config_name = '$c_key'";
			$result = query($con,$query,1);
			if($result){
				$success = mysqli_query($con,"update ".$prefix."config set config_value = '$c_val' where config_name = '$c_key' ");
			}else{
				 $success = mysqli_query($con,"INSERT INTO ".$prefix."config (config_name,config_value) VALUES ('$c_key','$c_val')");
			}
		}

		if($success){
			$_SESSION['successconfig'] = "Record Saved successfully";
			redirect(ADMINURL.'configration.php');
		}else{
			$_SESSION['faliureconfig'] = "Please try again";
			redirect(ADMINURL.'configration.php');
		}
}
?>