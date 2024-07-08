<?php	
error_reporting(E_ALL);

	include_once 'config.php';


  $ownerid = isset($_GET['ownerid']) ? $_GET['ownerid'] : 1 ;
  $counter = 0;
  $relatedOwnerIds = $ownerid;
  

  $sql = " SELECT GROUP_CONCAT(distinct ownerid) relatedownerids  FROM `partners_owner_auid_ip` where ownerid <> $ownerid  and auidid in (Select auidid from partners_owner_auid_ip where ownerid = $ownerid ) ";
  $result = mysqli_query($con,$sql);
  if(mysqli_num_rows($result) > 0)
  {

      $data = mysqli_fetch_assoc($result);
       echo "Related Owner Ids: ".$data["relatedownerids"];

  }

/*
  if(mysqli_num_rows($auidIdResult) > 0)
  {
    while ($row = mysqli_fetch_assoc($auidIdResult))
    {
       $auidid = $row["auidid"];
       getRelatedOwnerIds($auidid, $ownerid);
    }
  }

  echo "Related Owner Ids: ".$relatedOwnerIds;

  function getRelatedOwnerIds($auidid, $ownerid)
  {
      global $relatedOwnerIds;
      global $counter;

      $counter++;
      //echo $counter."<br/>";

      $con = $GLOBALS["con"];

      $sql = " SELECT distinct ownerid, auidid FROM `partners_owner_auid_ip` where auidid = '$auidid' and ownerid <> '$ownerid' ";
      //echo $sql."<br/>"; 
      
      $result = mysqli_query($con,$sql);

      if(mysqli_num_rows($result) > 0)
      {
        //echo "yes";
          while ($row = mysqli_fetch_assoc($result))
          {
            

              $ownerid = $row["ownerid"];
              $auidid = $row["auidid"];

              //echo "<br/>".$relatedOwnerIds."<br/>";

              if(!in_array($ownerid, explode(",", $relatedOwnerIds)))
              {
                if($relatedOwnerIds != "")
                {
                  $relatedOwnerIds.=",";
                }              

                $relatedOwnerIds.= $ownerid;

                getRelatedOwnerIds($auidid, $ownerid);
              }


          }
      }

      return $relatedOwnerIds;

  }
  */

?>