 <?php

#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------

    $mid =  leaduserinfo('id'); ;

    $auidid = 0;
    $ownerid = 0;

    if(isset($_GET["auidid"]))
    {
    	$auidid = $_GET["auidid"];
    }

    if(isset($_GET["ownerid"]))
    {
    	$ownerid = $_GET["ownerid"];
    }

    $isdetails = false;

    if($auidid > 0 && $ownerid > 0)
    {
    	$sql = " SELECT b.ipaddress, b.dateadded FROM `partners_owner_auid_ip` a left join partners_ipstats b on a.ipid = b.id where a.auidid = '$auidid' and  a.ownerid = '$ownerid' ";

	    $result  = mysqli_query($con,$sql);

	    $isdetails = true;
    }
    else
    {
	    //$sql = " SELECT b.auid, a.auidid, ownerid, count(ipid) as users FROM `partners_owner_auid_ip` a left join partners_auid b on a.auidid = b.id group by auid, ownerid ";


      //$sql = " Select DISTINCT b.auid, a.ownerid, auidid, (Select GROUP_CONCAT(ipaddress) from partners_owner_auid_ip aa left join partners_ipstats c on aa.ipid = c.id where aa.ownerid = a.ownerid) as ipids, (Select GROUP_CONCAT(ownerid) from partners_owner_auid_ip bb where bb.ipid = a.ipid and bb.ownerid <> a.ownerid ) as ownerids from partners_owner_auid_ip a left join partners_auid b on a.auidid = b.id group by a.ownerid ";

      //$sql = " Select DISTINCT b.auid, a.ownerid, auidid, count(ipid) as ipids, (Select GROUP_CONCAT(ownerid) from partners_owner_auid_ip bb where bb.ipid = a.ipid and bb.ownerid <> a.ownerid ) as ownerids from partners_owner_auid_ip a left join partners_auid b on a.auidid = b.id group by a.ownerid ";

      $sql = " Select DISTINCT b.auid, a.auidid, a.ownerid from partners_owner_auid_ip a  join partners_auid b on a.auidid = b.id and b.merchantid = '".$mid."' ";
      //echo $sql; 
	    $result  = mysqli_query($con,$sql);
	}

	 
 ?>  
 
			
<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form trackcode_form">
		<div class="card-body">
		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

		</div>
		  <div class="text-center">
   
    <h2>AI Relations</h2>
    <p class="lead">The below table shows relation between various Owner Ids</p>
  </div>

  <div class="row">
    <div class="col-md-12 order-md-2 mb-4">
    <?php

    	if(mysqli_num_rows($result) > 0)
      	{

      		

    ?>
    	<div class="table-responsive">
    		<?php
    			if($isdetails)
    			{
    				?>
 <table class="table table-striped table-sm">
          <thead>
            <tr>
             
              <th>IP Address</th>
              <th>Date</th>
              
            </tr>
          </thead>
          	 <tbody>
          	 	<?php
          		while($row = mysqli_fetch_assoc($result))
      		{
          ?>
            <tr>
              <td><?php echo $row["ipaddress"]; ?></td>
              <td><?php echo $row["dateadded"]; ?></td>
              
             
            </tr>
            <?php

            	}

            ?>
			</tbody>
        </table>
    				<?php
    			}
    			else
    			{
    		?>


        <table class="table table-striped table-sm">
          <thead>
            <tr>
             
              <th>AUID</th>
              <th>Owner Id</th>
              <th>IPs</th>
              <th>Linked Owner Ids</th>
              
            </tr>
          </thead>
          <tbody>
          	<?php
          		while($row = mysqli_fetch_assoc($result))
      		{
            $ownerIds = array();
            $ipIds = "";
            $ips = "";
             $sql = " Select ipid, ipaddress from partners_owner_auid_ip oai left join partners_ipstats ips on oai.ipid = ips.id  where auidid = '".$row["auidid"]."' and oai.ownerid = '".$row["ownerid"]."'  ";
             //echo $sql;
             $ipresult  = @mysqli_query($con,$sql);

             if(mysqli_num_rows($ipresult) > 0)
             {
                while($ipResultObj = mysqli_fetch_assoc($ipresult))
                {
                  $ipIds[]=$ipResultObj["ipid"];
                  $ips[]=$ipResultObj["ipaddress"];
                }
             }

             if(count($ips) > 0)
            {
               $ipsCsv = implode(",",$ipIds);
               $sql = "Select distinct ownerid from partners_owner_auid_ip where ownerid <> '".$row["ownerid"]."' and ipid in (".$ipsCsv.")";
               //echo $sql;
               $oresult  = @mysqli_query($con,$sql);

               if(mysqli_num_rows($oresult) > 0)
               {
                  while($oResultObj = mysqli_fetch_assoc($oresult))
                  {
                    $ownerIds[]=$oResultObj["ownerid"];
                    
                  }
               }

            }

          ?>
            <tr>
              <td><?php echo $row["auid"]; ?></td>
              <td><?php echo $row["ownerid"]; ?></td>
              <td><?php echo implode("<br/> ", $ips); ?></td>
              <td><?php echo implode(", ", $ownerIds); ?></td>
            
            </tr>
            <?php

            	}

            ?>
           
          </tbody>
        </table>
        <?php
        	}
        ?>
      </div>  

      <?php
      		
      	}
      	else
      	{
      		?>
      			<div class="text-center"><p>Sorry! no data to show</p></div>
      		<?php
      	}
      ?>
      
    </div>
    
  </div>

	</div>
</div>
</div>

 	