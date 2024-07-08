<?php	
  #-------------------------------------------------------------------------------
  # Tracking code for click

  # Pgmmr        : RR
  # Date Created :   21-1-2004
  # Date Modfd   :   16-1-2005
  # Last Modified: By DPT on June/01/05 (if click is in IP block period, record the click and forward click to URL, but merchant need not pay)
  #				   By DPT on July/30/05 (to incorporate sub-id tracking)	
  #				   By DPT on August/01/05 (to incorporate flatrate/percentage for commission)
  #				   By DPT on September/07/05 (to change the ipaddress getting line)
  #-------------------------------------------------------------------------------

	include_once 'config.php';
  
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

	    $result  = @mysqli_query($con,$sql);

	    $isdetails = true;
    }
    else
    {
	    //$sql = " SELECT b.auid, a.auidid, ownerid, count(ipid) as users FROM `partners_owner_auid_ip` a left join partners_auid b on a.auidid = b.id group by auid, ownerid ";


      //$sql = " Select DISTINCT b.auid, a.ownerid, auidid, (Select GROUP_CONCAT(ipaddress) from partners_owner_auid_ip aa left join partners_ipstats c on aa.ipid = c.id where aa.ownerid = a.ownerid) as ipids, (Select GROUP_CONCAT(ownerid) from partners_owner_auid_ip bb where bb.ipid = a.ipid and bb.ownerid <> a.ownerid ) as ownerids from partners_owner_auid_ip a left join partners_auid b on a.auidid = b.id group by a.ownerid ";

      //$sql = " Select DISTINCT b.auid, a.ownerid, auidid, count(ipid) as ipids, (Select GROUP_CONCAT(ownerid) from partners_owner_auid_ip bb where bb.ipid = a.ipid and bb.ownerid <> a.ownerid ) as ownerids from partners_owner_auid_ip a left join partners_auid b on a.auidid = b.id group by a.ownerid ";

      $sql = " Select DISTINCT b.auid, a.auidid, a.ownerid from partners_owner_auid_ip a left join partners_auid b on a.auidid = b.id  ";

	    $result  = @mysqli_query($con,$sql);
	}
    


?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ankit Kedia">
    <meta name="generator" content="">
    <title>AI Relation</title>

 
    <!-- Bootstrap core CSS -->
<link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
   
  </head>
  <body class="bg-light">
    <div class="container">
  <div class="py-5 text-center">
    <img class="d-block mx-auto mb-4" src="assets/imgs/logo.png" alt="" height="72" >
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
      ?>
      
    </div>
    
  </div>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017-2019 Company Name</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="/docs/4.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
        
</html>
