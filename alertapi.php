<?php
include_once 'config.php';

header("Cache-control: private"); 

	$response = array();

	$secretkey = $_GET["key"];
	$from = $_GET["from"];
	$to = $_GET["to"];

	if(!empty($secretkey))
	{
		$hasError = false;

		if(!empty($from))
		{
			$fromData = date_parse_from_format("Y-m-d", $from);

			if($fromData["error_count"] > 0 || $fromData["warning_count"] > 0)
			{
				$hasError = true;
				$response["message"] = "Invalid 'from' date";
			}
			else
			{
				$response["from"] = $from;
			}

		}
		
		if(!empty($to))
		{
			$toData = date_parse_from_format("Y-m-d", $to);

			if($toData["error_count"] > 0 || $toData["warning_count"] > 0)
			{
				$hasError = true;
				$response["message"] = "Invalid 'to' date";
			}
			else
			{
				$response["to"] = $to;
			}

		}
		
		if(!$hasError)
		{
			
			

			$sql = "Select * from av_users where secretkey = '$secretkey' ";
			$result = mysqli_query($con, $sql);

			if(mysqli_num_rows($result) > 0)
			{
				 $affiliate = mysqli_fetch_assoc($result) ;

				 $userid = $affiliate["id"];


				 $sql = " Select a.createdate as alertdate,a.alertid, a.alerttype, a.orderid, a.status, ips.ipaddress from partners_alerts a left join partners_ipstats ips on a.ipid = ips.id  ";
				 $sql.= " left join partners_auid pauid on pauid.id = a.auidid ";
				 $sql.= "  where mid = '".$userid."' ";

				 if(!empty($from) && !empty($to))
				 {
				 	$sql.= " and ( a.createdate between '$from' and '$to' )";
				 }
				 else if (!empty($from))
				 {
				 	$sql.= " and a.createdate >= '$from' ";
				 }
				 else if (!empty($to))
				 {
				 	$sql.= " and a.createdate <= '$from' ";
				 }


				 $sql.= "  order by alertid desc ";

				 //echo $sql;

				 $result  = mysqli_query($con,$sql);

				 if(mysqli_num_rows($result) > 0)
				 {
				 	$alertsData = array();

				 	while($row = mysqli_fetch_assoc($result))
					{
						$alertStatus = "";
						$alertType = $row["alerttype"] == 2 ? "Excess Use Alert" : "Fraud Reported";

						if($row["status"] == 1)
						{
							$alertStatus = "Pending";
						}
						else if($row["status"] == 2)
						{
							$alertStatus = "Denied";
						}
						else if($row["status"] == 3)
						{
							$alertStatus = "Fraud";
						}

						$row["alerttypename"] = $row["alerttype"] == 2 ? "Excess Use Alert" : "Fraud Reported";
						$row["alertstatusname"] = $alertStatus;

						$transaction_ip = $row["ipaddress"];
						$details = json_decode(file_get_contents("http://ipinfo.io/{$transaction_ip}/json"));
						$location_trans_region = $details->region;
						$location_trans_city = $details->city;
						$location_trans_country = $details->country;

						$row["city"] =  $location_trans_city;
						$row["region"] =  $location_trans_region;
						$row["country"] =  $location_trans_country;

						$alertsData[] = $row;
					}

					$response["alerts"] = $alertsData;
				 }
			}

		}
		
	}
	else
	{
		$response["message"] = "Invalid secret key";
	}


	echo json_encode($response);

?>