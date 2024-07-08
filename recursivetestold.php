<?php	
error_reporting(E_ALL);

	include_once 'config.php';


  $ownerid = isset($_GET['ownerid']) ? $_GET['ownerid'] : 1 ;
  
  $counter = 0;
  $relatedOwnerIds = "";
  
  //getRelatedOwnerIds($auidid, $ownerid);

  $relatedOwnerIdSql = " Select GROUP_CONCAT(distinct tb.ownerid) relatedownerids from partners_owner_auid_ip ta, partners_owner_auid_ip tb where ta.auidid = tb.auidid and ta.ownerid= ".$ownerid." and tb.ownerid <> ".$ownerid;

  //echo $relatedOwnerIdSql."<br/>";

  $relatedOwnerIdResultObj = mysqli_query($con, $relatedOwnerIdSql);

  if(mysqli_num_rows($relatedOwnerIdResultObj) > 0)
  {
  		$relatedOwnerIdResult = mysqli_fetch_assoc($relatedOwnerIdResultObj);
  		$relatedOwnerIds = $relatedOwnerIdResult["relatedownerids"];
  }

  //echo $relatedOwnerIds."<br/>";

  if($relatedOwnerIds != "")
  {

  	$relatedOwnerIds = getRelatedOwnerIds($ownerid, $relatedOwnerIds, $con);

  	echo "Related Owner Ids: ".$relatedOwnerIds;


  }
?>