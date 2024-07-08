<?php
include('../config.php');


if(isset($_POST['edit_alert_settings']))
{
	global $con;
	$mid = leaduserinfo('id');
	
	if($mid > 0)
	{
		$today = date("Y-m-d H:i:s"); 
		$interactcount = $_POST["interactCount"];
		$searchprevtransterm = $_POST["searchPrevTransactions"];

		$sql = " Select * FROM `partners_alertsettings` where mid = '".$mid."'  ";
		$result = mysqli_query($con,$sql);

		if(mysqli_num_rows($result) > 0)
		{
			$updateSql = " Update partners_alertsettings set interactcount = '".$interactcount."', searchprevtransterm = '".$searchprevtransterm."' where mid = '".$mid."' ";

			$result = mysqli_query($con,$updateSql);
		}
		else
		{
			$insertSql = " Insert into partners_alertsettings ( mid, interactcount, searchprevtransterm, updatedate ) ";
			$insertSql.= " values ( '".$mid."', '".$interactcount."', '".$searchprevtransterm."', '".$today."' )   ";

			

			$result = mysqli_query($con,$insertSql);
		}

	}
	else
	{
		die("Merchant not found");
	}

	
	if($result){
		$_SESSION['successalertsettings'] = "Alert Settings Successfully..";
		redirect(LEADURL.'index.php?Act=alertsettings');
	}else{
		$_SESSION['faluirealertsettings'] = "Alert Settings Save Failed..";
		redirect(LEADURL.'index.php?Act=alertsettings');
	}
}


?>