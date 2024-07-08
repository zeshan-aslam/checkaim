<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); 
$postid = isset($_GET['cid']) ? $_GET['cid'] : -1;
$levelcheckfromdb = $_SESSION["checklevel"];
?>

	<div class="am-pagetitle">
        <h5 class="am-title">User Listing</h5>
         
      </div><!-- am-pagetitle -->
      <div class="am-pagebody">
		<div class="card pd-20 bg_clr">
          <div class="table-wrapper">
		  	<?php $sql = select("users","type = '3' order by date DESC"); ?>
			
            <table id="datatable1" class="table display responsive">
              <thead>
                <tr>
                  <th class="wd-15p">First Name</th>
                  <th class="wd120">Last Name</th>
                  <th class="wd120">Monthly Fee</th>
                  <th class="wd120">Daily Charge</th>
                  <th class="">Balance</th>
				  <th>Company Name</th>
				  <th>Email</th>
                  <th>Phone Number</th>
				 <th>Join Date</th>
				 <th>Status</th> 
				 <?php 
				if(($levelcheckfromdb == "3")){
					?>
					 <th>Action user</th>
					<?php
					
				}							 
				 ?>	
                 <th>Action</th>
                </tr>
              </thead> 
              <tbody> 
				<?php while($row = fetch($sql)){  

			$userid =  $row['id'];
			//$tblname = $prefix."affilates_charges";
		   // $sqldata = "select * from $tblname where user_id = '$userid'";
			
			$getinfo =  get_user_info($userid,'av_Currency',true);
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
					<td><?php echo get_user_info($row['id'],'first_name',true); ?></td>
					<td><?php echo get_user_info($row['id'],'last_name',true); ?></td>
					
					<?php
					
					$getusermontly = get_user_info($row['id'],'monthly_license_fee',true);
					
					if($getusermontly == "")
					{
						
						?>
							<td><?php echo $currsymboldb ?>0.00</td>
						<?php
						
					}
					else
					{
						
						?>
							<td><?php echo $currsymboldb.number_format(get_user_info($row['id'],'monthly_license_fee',true),2); ?></td>
						<?php
						
					}
					
					
					?>
					
				
					<td>
						<?php 
							$no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('y'));
							$charges = get_user_info($row['id'],'monthly_license_fee',true) / $no_of_days_in_month;
							 echo $currsymboldb.number_format($charges,2);
							?>
					</td>
					<td><?=$currsymboldb?><?=number_format($row['balance'],2); ?></td>
					<td><?php echo get_user_info($row['id'],'av_company',true); ?></td>
					<td><?php echo get_user_info($row['id'],'av_email',true); ?></td>
					<td><?php echo get_user_info($row['id'],'av_phone',true); ?></td>
					<td><?php echo date('Y-m-d',strtotime($row['date'])); ?></td>
					<td><?php echo ucfirst(get_user_info($row['id'],'av_campaign_status', true));?></td>
					<?php
					if(($levelcheckfromdb == "3")){
						?>
						 <td><a  href="javascript:;" onClick="deleteuseralldata(<?php echo $row['id']; ?>,'Are you sure you like to delete all user record from database')">Delete</a></td>
						<?php
					}
					?>
					
					<td><a href="user-view.php?action=view&uid=<?php echo $row['id']; ?>">View</a></td>
				</tr>
				<?php } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
		  <div class="form-layout-footer mg-t-30">
                <button onClick="history.go(-1)" type="button" class="btn btn-info mg-r-5">Back</button>
        </div><!-- card -->

      </div><!-- am-pagebody -->      
    </div>
<?php include('includes/common/footer.php'); ?>