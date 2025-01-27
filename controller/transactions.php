<?php
include('../config.php');
require_once("../model/pager.php");


if(isset($_POST['transactions_list']))
{
	global $con;
	$mid = leaduserinfo('id');

	if($mid > 0)
	{
		$response = array(); 
		$orderid = isset($_POST["orderid"]) ? trim($_POST["orderid"]) : "";
		$pageno = isset($_POST["pageno"]) ? $_POST["pageno"] : 1;
		$pagesize = isset($_POST["pagesize"]) ? $_POST["pagesize"] : 10;

		 $sqlCount = " Select count(*) as totalrecords from `partners_aianalytics`  where mid = '".$mid."' ";

		  if($orderid != "")
		 {
		 	$sqlCount.=" and orderid = '$orderid' ";
		 }

		 $response["sqlCount"] = $sqlCount;

		 $sqlresult = mysqli_query($con, $sqlCount);

		 if(mysqli_num_rows($sqlresult) > 0)
		 {
			$totalRecords = mysqli_fetch_assoc($sqlresult);

			$response["totalrecords"] = $totalRecords["totalrecords"];
		 }

		 $start = ($pageno * $pagesize) - $pagesize;

		 $sql = " Select a.*, al.alertid from partners_aianalytics a left join partners_alerts al on a.id = al.analyticsid  ";
		 $sql.= "  where a.mid = '".$mid."' ";

		 if($orderid != "")
		 {
		 	$sql.=" and a.orderid = '$orderid' ";
		 }

		 $sql.= "  order by id desc limit ".$start.",".$pagesize;
		 

		 $response["sql"] = $sql;

		 $result  = mysqli_query($con,$sql);

		 $osDataRaw = array();
		 $browserDataRaw = array();

		 $osData = array();
		 $browserData = array();

		 if(mysqli_num_rows($result) > 0)
		 {
		 	$data = array();

		 	while($row = mysqli_fetch_assoc($result))
			{
				if(!array_key_exists($row["os"],$osDataRaw))
				{
					$osDataRaw[$row["os"]] = 1;
				}
				else
				{
					$osDataRaw[$row["os"]]+= 1;
				}

				if(!array_key_exists($row["browser"],$browserDataRaw))
				{
					$browserDataRaw[$row["browser"]] = 1;
				}
				else
				{
					$browserDataRaw[$row["browser"]]+= 1;
				}

				$data[] = $row;
			}

			foreach ($osDataRaw as $key => $value)
			{
				$osData[] = array("key"=>$key,"value"=>$value);
			}

			foreach ($browserDataRaw as $key => $value)
			{
				$browserData[] = array("key"=>$key,"value"=>$value);
			}

			$pager = new Pager($response["totalrecords"], $pageno, $pagesize);
			$pager->setPager();

			$response["pager"] = $pager->getPager();

			$response["data"] = $data;

			$response["osdata"] = $osData;
			$response["browserdata"] = $browserData;
			

			

		 }

	}
	else
	{
		$response["status"] = false;
		$response["message"] = "Merchant not found";
	}

}


echo json_encode($response);
?>