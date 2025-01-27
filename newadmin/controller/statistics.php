<?php
require_once('../../config.php');

$loggedinuser = user();

if(isset($_REQUEST['earningstats']))
{
	global $con;

	$status = false;
	$data = array();
	
	if($loggedinuser != '')
	{

		$from = isset($_POST["from"]) ? $_POST["from"] : date('Y-m-d', strtotime('-30 days'));
		$to = isset($_POST["to"]) ? $_POST["to"] : date('Y-m-d', strtotime('+1 day'));
		
		$statsSql = " SELECT DATE_FORMAT(ai.createdate, '%M %d %Y') as formatteddate, count(*) as transactions, (count(*) * 0.01) earningestimate FROM `partners_aianalytics` ai where 1 = 1 ";

		if($from != "" && $to != "")
		{
			$statsSql.= " and ai.createdate between '$from' and '$to' ";
		}

		$statsSql.= " group BY formatteddate DESC order by ai.createdate desc  "; 

		$response["sql"] = $statsSql; 

		$statsSqlResult =	mysqli_query($con, $statsSql);	

		while($resultItem = mysqli_fetch_assoc($statsSqlResult))
		{
			$data[] = $resultItem;
		}


		$response["status"] = $status;
		$response["data"] = $data;

		
	}
	else
	{
		$response["status"] = false;
		$response["message"] = "Unauthorized Access";
	}

	echo json_encode($response);

	die();
		
}

if(isset($_REQUEST['clientstats']))
{
	global $con;

	$status = false;
	$data = array();
	
	if($loggedinuser != '')
	{

		$from = isset($_POST["from"]) ? $_POST["from"] : date('Y-m-d', strtotime('-30 days'));
		$to = isset($_POST["to"]) ? $_POST["to"] : date('Y-m-d', strtotime('+1 day'));
		
		$statsSql = " SELECT mid, um.user_meta as client, round(sum(amount),2) amount, count(*) as transactions FROM `partners_aianalytics` ai ";
		$statsSql.= " left join av_usermeta um on ai.mid = um.user_id and um.user_key = 'av_company' where mid <> 0 ";

		

		if($from != "" && $to != "")
		{
			$statsSql.= " and ai.createdate between '$from' and '$to' ";
		}

		$statsSql.= " group by mid order by amount desc  "; 

		$statsSqlResult =	mysqli_query($con, $statsSql);	

		while($resultItem = mysqli_fetch_assoc($statsSqlResult))
		{
			$data[] = $resultItem;
		}


		$response["status"] = $status;
		$response["data"] = $data;

		
	}
	else
	{
		$response["status"] = false;
		$response["message"] = "Unauthorized Access";
	}

	echo json_encode($response);

	die();
		
}



if(isset($_REQUEST['locationstats']))
{
	global $con;

	$status = false;
	
	$data = array();
	
	if($loggedinuser != '')
	{

		$from = isset($_POST["from"]) ? $_POST["from"] : date('Y-m-d', strtotime('-30 days'));
		$to = isset($_POST["to"]) ? $_POST["to"] : date('Y-m-d', strtotime('+1 day'));
		
		$osSql = "SELECT location, city, region, country, count(orderid) as ordercount FROM `partners_aianalytics` where location <> ''  "; 

		if($from != "" && $to != "")
		{
			$osSql.= " and createdate between '$from' and '$to' ";
		}

		$osSql.= " group by location, city, region, country ORDER BY `createdate` desc ";

		$osSqlResult 	=	mysqli_query($con, $osSql);	

		while($locationItem = mysqli_fetch_assoc($osSqlResult))
		{
			$latlng = $locationItem["location"];

			$locationItem["latitude"] = "";
			$locationItem["longitude"] = "";

			if($latlng != "")
			{	
					$latlng = explode(",", $latlng);
					
					$locationItem["latitude"] = floatval($latlng[0]);
					$locationItem["longitude"] = floatval($latlng[1]);
					$locationItem["color"] =  "#".dechex(rand(0x000000, 0xFFFFFF));
			}

			$data[] = $locationItem;
		}


		$response["status"] = $status;
		$response["data"] = $data;

	}
	else
	{
		$response["status"] = false;
		$response["message"] = "Unauthorized Access";
	}	


	echo json_encode($response);

	die();

}

?>