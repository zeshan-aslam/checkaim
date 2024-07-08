<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); 
$postid = isset($_GET['cid']) ? $_GET['cid'] : -1;
$levelcheckfromdb = $_SESSION["checklevel"];
?>

	<div class="am-pagetitle">
        <h5 class="am-title">User Listing</h5>
         
      </div><!-- am-pagetitle -->
      <div class="am-pagebody">
		<div class="pd-20 ">
          <div class="table-wrapper">
		  	<?php 

		  			$clients = null;

		  			$clientSql = "select * from  av_users where type = '3' and deleted <> 1 order by date DESC";

		  			$clientSqlResult = mysqli_query($con, $clientSql);	

					while($resultItem = mysqli_fetch_assoc($clientSqlResult))
					{
						$clients[] = $resultItem;
					}
		  	?>
			
            <table id="datatable1" class="table display responsive">
              <thead>
                <tr>
                  <th style="width:15%;">Company Name</th>
                  <th style="width:10%;" >Name</th>
                  <th style="width:10%;" >Email</th>
                  <th style="width:10%;">Phone Number</th>
                  <th style="width:5%;" >Monthly Fee</th>
                  <th style="width:5%;">Daily Charge</th>
                  <th style="width:7%;">Balance</th>
				 <th style="width:8%;">Join Date</th>
				 <th style="width:7%;">Status</th> 
                 <th>Action</th>
                </tr>
              </thead> 
              <tbody> 
			<?php 

				foreach($clients as $client)
				{  
					$userid =  $client['id'];

					$clientDetailSql = " SELECT * FROM `av_usermeta` where user_id = '".$userid."' ";
					$clientDetailSqlResult = mysqli_query($con, $clientDetailSql);	

					while($clientResultItem = mysqli_fetch_assoc($clientDetailSqlResult))
					{
						$client[$clientResultItem["user_key"]] = $clientResultItem["user_meta"];
					}

					
					//$tblname = $prefix."affilates_charges";
				   // $sqldata = "select * from $tblname where user_id = '$userid'";
					
					$getinfo =  $client['av_Currency'];
					if($getinfo == "USD")
					{
						
						 $currsymboldb = "$";
					}
					else if ($getinfo == "GBP")
					{
						$currsymboldb = "£";
						
					}
					else
					{
						 $currsymboldb = "€";
					}
					
									?>
						<tr>
							<td><?php echo $client['av_company']; ?></td>
							<td><?php echo $client['first_name']." ".$client['last_name']; ?></td>
							<td><?php echo $client['av_email']; ?></td>
							<td><?php echo $client['av_phone']; ?></td>
							
							<?php
							
							$getusermontly = $client['monthly_license_fee'];
							
							if($getusermontly == "")
							{
								
								?>
									<td><?php echo $currsymboldb ?>0.00</td>
								<?php
								
							}
							else
							{
								
								?>
									<td><?php echo $currsymboldb.number_format($client['monthly_license_fee'],2); ?></td>
								<?php
								
							}
							
							
							?>
							
						
							<td>
								<?php 
									$no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('y'));
									$charges = $client['monthly_license_fee'] / $no_of_days_in_month;
									 echo $currsymboldb.number_format($charges,2);
									?>
							</td>
							<td><?=$currsymboldb?><?=number_format($client['balance'],2); ?></td>
							
							
							<td><?php echo date('Y-m-d',strtotime($client['date'])); ?></td>
							<td><?php echo ucfirst($client['av_campaign_status']);?></td>
							<td>
									<a href="client-view.php?action=view&uid=<?php echo $client['id']; ?>">View</a> |
									<?php
							if(($levelcheckfromdb == "3")){
								?>
								 <a  href="javascript:;" onClick="deleteuseralldata(<?php echo $client['id']; ?>,'Are you sure you like to delete all user record from database')">Delete</a> |
								<?php
							}
							?>
							<a target="_blank" href="controller/clients.php?clientlogin=yes&uid=<?php echo $client['id']; ?>">Login</a> 

							</td>
						</tr>
						<?php } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
		  

      </div><!-- am-pagebody -->      
    </div>
<?php include('includes/common/footer.php'); ?>