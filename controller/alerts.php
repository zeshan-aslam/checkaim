<?php
include('../config.php');
require_once("../model/pager.php");


if(isset($_POST['alerts_list']))
{
	global $con;
	$mid = leaduserinfo('id');

	if($mid > 0)
	{
		$response = array(); 
		$pageno = isset($_POST["pageno"]) ? $_POST["pageno"] : 1;
		$pagesize = isset($_POST["pagesize"]) ? $_POST["pagesize"] : 10;

		 $sqlCount = " Select count(*) as totalrecords from `partners_alerts`  where mid = '".$mid."' ";
		 $sqlresult = mysqli_query($con, $sqlCount);

		 if(mysqli_num_rows($sqlresult) > 0)
		 {
			$totalRecords = mysqli_fetch_assoc($sqlresult);

			$response["totalrecords"] = $totalRecords["totalrecords"];
		 }

		 $start = ($pageno * $pagesize) - $pagesize;

		 $sql = " Select a.*, ips.ipaddress, pauid.auid from partners_alerts a left join partners_ipstats ips on a.ipid = ips.id  ";
		 $sql.= " left join partners_auid pauid on pauid.id = a.auidid ";
		 $sql.= "  where mid = '".$mid."' order by alertid desc limit ".$start.",".$pagesize;

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

			$pager = new Pager($response["totalrecords"], $pageno, $pagesize);
			$pager->setPager();

			$response["pager"] = $pager->getPager();

			$response["data"] = $alertsData;

			echo json_encode($response);

		 }

	}
	else
	{
		die("Merchant not found");
	}

}


if(isset($_POST['alert_details']))
{
	global $con;
	$mid = leaduserinfo('id');
	
	if($mid > 0)
	{
		$alertDetails = null; 
		$alertid 	  = $_POST["alertid"];



		
		$sql = " Select a.*, ips.ipaddress, pauid.auid, aia.browser, aia.os, aia.productids, aia.postage, aia.tax, aia.trafficsource, aia.amount, aia.referer, aia.keyword, aia.currency ";
		$sql.= " from partners_alerts a ";
		$sql.= " left join partners_ipstats ips on a.ipid = ips.id  ";
		$sql.= " left join partners_auid pauid on pauid.id = a.auidid ";
		$sql.= " left join partners_aianalytics aia on a.orderid = aia.orderid ";
		$sql.= " where a.mid = '".$mid."' and alertid = '".$alertid."' order by alertid desc ";

		
		
		

		$result = mysqli_query($con,$sql);

		if(mysqli_num_rows($result) > 0)
		{
			$alertDetails = mysqli_fetch_assoc($result);
			$alertDetails["alerttypename"] = $alertDetails["alerttype"] == 2 ? "Excess Use Alert" : "Fraud Reported";

			$transaction_ip = $alertDetails["ipaddress"]; 

			$ownerid = $alertDetails["ownerid"];

			$details = json_decode(file_get_contents("http://ipinfo.io/{$transaction_ip}/json"));
			
			$location_trans_region = $details->region;
			$location_trans_city = $details->city;
			$location_trans_country = $details->country;

			$alertDetails["city"] = $location_trans_city;
			$alertDetails["region"] = $location_trans_region;
			$alertDetails["country"] = $location_trans_country;

			$alertDetails["showactions"] = $alertDetails["status"] == "1";


			$alertSqlCount = " Select status, count(*) as total  from partners_alerts a where a.mid = '".$mid."' and alertid = '".$alertid."' group by status ";

			$result = mysqli_query($con,$alertSqlCount);

			if(mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					if($row["status"] == 1)
					{
						$row["statusname"] = "Pending";
					}
					else if($row["status"] == 2)
					{
						$row["statusname"] = "Denied";
					}
					else if($row["status"] == 3)
					{
						$row["statusname"] = "Fraud";
					}

					$alertDetails["userdetails"]["excessiveusealerts"][] = $row;

				}
			}

			$relatedOwnerIds = "";
			$relatedOwnerIdSql = " Select GROUP_CONCAT(distinct tb.ownerid) relatedownerids from partners_owner_auid_ip ta, partners_owner_auid_ip tb where ta.auidid = tb.auidid and ta.ownerid= ".$ownerid." and tb.ownerid <> ".$ownerid;

			//echo $relatedOwnerIdSql;

		    $relatedOwnerIdResultObj = mysqli_query($con, $relatedOwnerIdSql);

		    if(mysqli_num_rows($relatedOwnerIdResultObj) > 0)
		    {
		        $relatedOwnerIdResult = mysqli_fetch_assoc($relatedOwnerIdResultObj);
		        if($relatedOwnerIdResult["relatedownerids"] != NULL)
		        {
		          $relatedOwnerIds = $relatedOwnerIdResult["relatedownerids"];

		          if($relatedOwnerIds != "")
		          {
		            $relatedOwnerIds = getRelatedOwnerIds($ownerid, $relatedOwnerIds, $con);
		          }
		        }
		    }

		    	$totalUserDevices = 1;
		    	$totalUserTransactions = 0;
		    
			    $alertDetails["relatedownerids"] = $relatedOwnerIds;

			    $relatedTransactionsSql = " select ai.*, ip.id as deviceid from partners_aianalytics ai left join partners_ipstats ip on ai.ipaddress = ip.ipaddress  where ai.ipaddress in (select ips.ipaddress from partners_ipstats ips where ";

				$relatedTransactionsSql.= " ownerid = $ownerid "; 
				if($relatedOwnerIds != "")
				{
			     	$relatedTransactionsSql.= " or ownerid in ($relatedOwnerIds)   ";

			     	$relatedOwnerIdsArr = explode(",",$relatedOwnerIds);

			     	$totalUserDevices+= count($relatedOwnerIdsArr);
				}

				$relatedTransactionsSql.= " ) limit 5 ";

			    //echo $relatedTransactionsSql;

			    $relatedTransactionsSqlResultObj = mysqli_query($con, $relatedTransactionsSql);
			    if(mysqli_num_rows($relatedTransactionsSqlResultObj) > 0)
		    	{
		    		while($row = mysqli_fetch_assoc($relatedTransactionsSqlResultObj))
		    		{
		    			$transaction_ip =  $row["ipaddress"];

		    			$details = json_decode(file_get_contents("http://ipinfo.io/{$transaction_ip}/json"));
			
						$location_trans_region = $details->region;
						$location_trans_city = $details->city;
						$location_trans_country = $details->country;

						$row["city"] = $location_trans_city;
						$row["region"] = $location_trans_region;
						$row["country"] = $location_trans_country;

			    		$alertDetails["relatedtransations"][] = $row;
		    		}
		    	}

		    	$relatedTransactionsCountSql = " select count(*) as total from partners_aianalytics where ipaddress in (select ipaddress from partners_ipstats where ";
				$relatedTransactionsCountSql.= " ownerid = $ownerid "; 
				if($relatedOwnerIds != "")
				{
			     	$relatedTransactionsCountSql.= " or ownerid in ($relatedOwnerIds)   ";
				}

				$relatedTransactionsCountSql.= " )  ";

			    //echo $relatedTransactionsSql;

			    $relatedTransactionsCountSqlResultObj = mysqli_query($con, $relatedTransactionsCountSql);
			    if(mysqli_num_rows($relatedTransactionsCountSqlResultObj) > 0)
		    	{
		    		$row = mysqli_fetch_assoc($relatedTransactionsCountSqlResultObj);

		    		$totalUserTransactions = $row["total"];
		    		
		    	}


				$alertDetails["userdetails"]["totaldevices"] = $totalUserDevices;
				$alertDetails["userdetails"]["totaltransactions"] = $totalUserTransactions;

			echo json_encode($alertDetails);
		}
		

	}
	else
	{
		die("Merchant not found");
	}
}

if(isset($_POST['alert_change_status']))
{
	global $con;
	$mid = leaduserinfo('id');
	
	if($mid > 0)
	{
		$alertid 	  = $_POST["alertid"];
		$alertstatus  = $_POST["alertstatus"];
		
		$sql = " update partners_alerts set status = '".$alertstatus."' where alertid = '".$alertid."'  ";		
		$result = mysqli_query($con,$sql);

		$response["status"] = true;
		$response["reportfraud"] = false;


		if($alertstatus == 3)
		{
			$response["reportfraud"] = true;
		}

		echo json_encode($response);

	}
	else
	{
		die("Merchant not found");
	}
}

?>