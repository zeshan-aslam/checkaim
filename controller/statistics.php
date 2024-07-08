<?php
include('../config.php');



if(isset($_REQUEST['locationstats']))
{
	global $con;

	$status = false;
	$mid = leaduserinfo('id');
	$data = array();
	
	if($mid > 0)
	{

		$from = isset($_POST["from"]) ? $_POST["from"] : date('Y-m-d', strtotime('-60 days'));
		$to = isset($_POST["to"]) ? $_POST["to"] : date('Y-m-d', strtotime('+1 day'));
		
		$osSql = "SELECT location, city, region, country, count(orderid) as ordercount FROM `partners_aianalytics` where mid='$mid' and location <> ''  "; 

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
		$response["sql"] = $osSql;

		echo json_encode($response);

		die();
	}
	else
	{
		die("Merchant not found");
	}	
}


if(isset($_REQUEST['transactionstats']))
{
	global $con;

	$status = false;
	$mid = leaduserinfo('id');
	$saleData = array();
	
	if($mid > 0)
	{
		$from = isset($_POST["from"]) ? $_POST["from"] : date('Y-m-d', strtotime('-60 days'));
		$to = isset($_POST["to"]) ? $_POST["to"] : date('Y-m-d', strtotime('+1 day'));

		
		$saleSql = "select date, sales, alerts, transactions, reports from partners_aidailystats where mid='$mid'  "; 

		if($from != "" && $to != "")
		{
			$saleSql.= " and date between '$from' and '$to' ";
		}

		$saleSqlResult 	=	mysqli_query($con, $saleSql);	

		while($saleItem = mysqli_fetch_assoc($saleSqlResult))
		{
			$saleData[] = $saleItem;
		}


		$response["status"] = $status;
		$response["data"] = $saleData;
		$response["sql"] = $saleSql;

		echo json_encode($response);

		die();
	}
	else
	{
		die("Merchant not found");
	}	
}



if(isset($_REQUEST['osstats']))
{
	global $con;

	$status = false;
	$mid = leaduserinfo('id');
	$data = array();
	
	if($mid > 0)
	{

		$from = isset($_POST["from"]) ? $_POST["from"] : date('Y-m-d', strtotime('-60 days'));
		$to = isset($_POST["to"]) ? $_POST["to"] : date('Y-m-d', strtotime('+1 day'));
		
		$osSql = "SELECT os, count(*) as oscount FROM `partners_aianalytics` where mid = '$mid' "; 

		if($from != "" && $to != "")
		{
			$osSql.= " and createdate between '$from' and '$to' ";
		}

		$osSql.= " GROUP by os ";

		$osSqlResult 	=	mysqli_query($con, $osSql);	

		$windowsCount = 0;

		$handheldCount = 0;
		$pcCount = 0;

		while($osItem = mysqli_fetch_assoc($osSqlResult))
		{
			if(stripos($osItem["os"], "ipad") !== false || stripos($osItem["os"], "iphone") !== false || stripos($osItem["os"], "android") !== false)
			{
				$handheldCount+=$osItem["oscount"];
			}
			else
			{
				$pcCount+=$osItem["oscount"];
			}


			if(stripos($osItem["os"], "windows") !== false)
			{
				$windowsCount+=$osItem["oscount"];
			}
			else
			{
				$data[] = array ("key" => $osItem["os"], "value" => $osItem["oscount"]);
			}
		}

		$data[] = array ("key" => "Windows", "value" => $windowsCount);


		$response["status"] = $status;
		$response["data"] = $data;
		$response["data2"] = array(array("key" => "Handheld", "value" => $handheldCount),array( "key" =>  "Desktop" , "value" => $pcCount));
		$response["sql"] = $osSql;

		echo json_encode($response);

		die();
	}
	else
	{
		die("Merchant not found");
	}	
}


if(isset($_REQUEST['browserstats']))
{
	global $con;

	$status = false;
	$mid = leaduserinfo('id');
	$data = array();
	
	if($mid > 0)
	{
		$from = isset($_POST["from"]) ? $_POST["from"] : date('Y-m-d', strtotime('-60 days'));
		$to = isset($_POST["to"]) ? $_POST["to"] : date('Y-m-d', strtotime('+1 day'));

		$osSql = "SELECT browser, count(*) as browsercount FROM `partners_aianalytics` where mid = '$mid' "; 

		if($from != "" && $to != "")
		{
			$osSql.= " and createdate between '$from' and '$to' ";
		}

		$osSql.= " GROUP by browser ";

		$osSqlResult 	=	mysqli_query($con, $osSql);	

		while($osItem = mysqli_fetch_assoc($osSqlResult))
		{
			$data[] = array ("key" => $osItem["browser"], "value" => $osItem["browsercount"]);
		}


		$response["status"] = $status;
		$response["data"] = $data;

		echo json_encode($response);

		die();
	}
	else
	{
		die("Merchant not found");
	}	
}


?>