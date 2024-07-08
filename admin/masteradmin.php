<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php');
$levelcheckfromdb = $_SESSION["checklevel"];
 ?>

	<div class="am-pagetitle">
       
		<?php
			if(($levelcheckfromdb == "1")){
				?>
				<h5 class="am-title">Junior Admin Dashboard </h5>
				<?php
					
				}else if(($levelcheckfromdb == "2")) {
					?>
					 <h5 class="am-title">Senior Admin Dashboard </h5>
					<?php					
				}
				else
				{
				?>
					 <h5 class="am-title">Master Admin Dashboard </h5>
					<?php	
				}					
		
		?>
		<?php
		if(($levelcheckfromdb == "1")){
					
				}else {
					?>
					<a href="add-newadmin.php" class="btn btn-info mg-r-5">Add Admin</a>
					<?php
					
				}
		?>
         
      </div><!-- am-pagetitle -->
	  
      <div class="am-pagebody">

		<div class="card pd-20 pd-sm-40 bg_clr1">
		
          <div class="table-wrapper">
		  	<?php $sql = select("users where level=2 or level=1 or level=3 order by date DESC");	
			?>
            <table id="datatable2" class="table display responsive nowrap">
              <thead>
                <tr>
                <th>Email - ID</th>				              				  
                <th>Admin Status</th>
                <th>Admin level</th>
				<th>Date of Joing</th>
				<?php
				if(($levelcheckfromdb == "1")){	
				}
				else
				{
					?>
					<th>Action</th>	
					<?php
				}
				?>
												
				<th></th>					
                </tr>
              </thead>
              <tbody> 
			<?php			
			while($row = fetch($sql)){  
			$userid =  $row['id'];			
			$email =  $row['email'];
			$date =  $row['date'];
			$status =  $row['status'];
			$level =  $row['level'];					
			if($status == "1")
			{				
				 $statusdb = "Active";
			}
			else if ($status == "2")
			{
				$statusdb = "Suspend";
				
			}
			
			if($status == "1")
			{				
				 $change = "Suspend";
			}
			else if ($status == "2")
			{
				$change = "Active";
				
			}
			if($status == "1")
			{				
				 $val = "2";
			}
			else if ($status == "2")
			{
				$val = "1";
				
			}
			
			if($status == "1")
			{				
				 $valmaster = "2";
			}
			else if ($status == "2")
			{
				$valmaster = "1";
				
			}
			
			

			
			if($level == "1")
			{				
				 $leveldb = "Junior";
			}
			else if ($level == "2")
			{
				$leveldb = "Senior";
				
			}
			else if ($level == "3")
			{
				$leveldb = "Master";
				
			}
			
			?>
			<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="controller/deleteadmin.php" method="post">
				<tr>
					<td><?php echo  $email; ?></td>
					<td><?php echo  $statusdb; ?></td>
					<td><?php echo  $leveldb; ?></td>
					<td><?php echo  $date; ?></td>
									
				
				<?php					
				if(($levelcheckfromdb == "1")){	
				?>
			<!--	<td><a href="" >Disable</td>	-->
				<?php					
				}
				else
				{
					if(($levelcheckfromdb == "2")) {
						if(($leveldb == "Junior")) {
						?>
						<td><a href="<?php echo ADMINURL;?>controller/changeSat.php?&sts=<?php echo $val; ?>&delid=<?php echo $userid ?>"><?php echo $change; ?></a></td>	
						<?php
						}
						else						
						{							
							?>
							<td>Active</td>	
							<?php
						}
					}
					else
					{
						?>
						<td><a href="<?php echo ADMINURL;?>controller/changeSat.php?&sts=<?php echo $valmaster; ?>&delid=<?php echo $userid ?>"><?php echo $change; ?></a></td>
						<?php						
					}	
				}								
				?>
				</tr>
				</form>

<?php			} ?>				
              </tbody>
            </table>
          </div><!-- table-wrapper -->
		  <div class="form-layout-footer mg-t-30">
                <!--<button onClick="history.go(-1)" type="button" class="btn btn-info mg-r-5">Back</button>-->
        </div><!-- card -->

      </div><!-- am-pagebody -->      
<?php include('includes/common/footer.php'); ?>