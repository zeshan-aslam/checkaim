<?php
include('../config.php');


if(isset($_POST['report_fraud']))
{
	global $con;
	$mid = leaduserinfo('id');
	
	if($mid > 0)
	{
		$today = date("Y-m-d H:i:s"); 
		$alertid = $_POST["alertid"];
		$auidid = $_POST["auidid"];
		$orderid = $_POST["orderid"];
		$responseid = $_POST["responseid"];
		$notes = mysqli_real_escape_string($con,$_POST["notes"]);
		

		$sql = " Select * FROM `partners_reports` where mid = '".$mid."' and orderid = '".$orderid."'  ";
		//die($sql);
		$result = mysqli_query($con,$sql);

		if(mysqli_num_rows($result) > 0)
		{
			$updateSql = " Update partners_reports set orderid = '".$orderid."', cannedresponseid = '".$responseid."', notes = '".$notes."' where mid = '".$mid."' and orderid = '".$orderid."' ";

			$result = mysqli_query($con,$updateSql);
		}
		else
		{
			$insertSql = " Insert into partners_reports ( mid, alertid, auidid, orderid, cannedresponseid, notes ) ";
			$insertSql.= " values ( '".$mid."', '".$alertid."', '".$auidid."','".$orderid."', '".$responseid."', '".$notes."' )   ";
			$result = mysqli_query($con,$insertSql);


			$presentDate        =   date("Y-m-d");

			  $sql = " Select * from partners_aidailystats where mid = '".$mid."' and date = '".$presentDate."' ";
			  $result = mysqli_query($con,$sql);

			  if(mysqli_num_rows($result) > 0)
			  {
			    $row = mysqli_fetch_assoc($result) ;
			     
			    $dailyReports = $row["reports"] + 1;


			    $sql = " Update partners_aidailystats set reports = '$dailyReports'  where mid = '".$mid ."' and date = '".$presentDate."' ";
			    //echo $sql;

			    mysqli_query($con,$sql);    

			  }
			  else
			  {
			     $sql = " insert into partners_aidailystats (mid, date, reports )  ";
			     $sql.= " values ($mid, '".$presentDate."', '$dailyReports' ) ";

			     //echo $sql; 

			     mysqli_query($con,$sql);
			  }


		}

		if($result){
			$_SESSION['successreportfraud'] = "Fraud Reported Successfully..";
			redirect(LEADURL.'index.php?Act=reportfraud&alertid='.$alertid);
		}else{
			$_SESSION['faluirealertsettings'] = "Fraud Reporting Failed..";
			redirect(LEADURL.'index.php?Act=reportfraud&alertid='.$alertid);
		}

	}
	else
	{
		die("Merchant not found");
	}

	
	
}


?>