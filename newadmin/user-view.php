<?php include('includes/common/header.php'); ?>
 <?php
	$postid = isset($_GET['uid']) ? $_GET['uid'] : -1;

	$sql = select("users","id = '$postid'");
	$row = fetch($sql);
?>
<?php include('includes/common/sidebar.php'); ?>
	<div class="am-pagetitle">
        <h5 class="am-title">View Detail</h5>
       
      </div><!-- am-pagetitle -->
	
      <div class="am-pagebody">
	   <form action="controller/save_user.php" method="post">
		<div class="row row-sm mg-t-20">
			 <div class="col-md-6">
		 
			
		  <input type="hidden" value="<?php echo $postid; ?>" name="userid">
		   <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <h6 class="card-body-title"></h6>
				<?php if(isset($_SESSION['successuser'])){
				echo '<p class="alert alert-success">'.$_SESSION['successuser'].'</p>';
				unset($_SESSION['successuser']);
			}
			if(isset($_SESSION['failuireuser'])){
				echo '<p class="alert alert-danger">'.$_SESSION['failuireuser'].'</p>';
				unset($_SESSION['failuireuser']);
			}
			
			$av_campaign = unserialize(get_user_info($row['id'],'av_campaign',true));
			$sqls = select("usermeta","user_key = 'av_campaign'");
			while($rowc = fetch($sqls)){
				 $campagin = unserialize($rowc['user_meta']);
				foreach($campagin as $l){
					$user_meta['campagin'][] = $l;
				}
			}
			 

			?>
				
				
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Campaign</label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					 <select name="av_campaign" class="form-control">
						<option value="">--Select Campaign--</option>
						<?php 
							$sqlc = select("company order by id DESC");
							while($rowc = fetch($sqlc)){
								$optiondis = '';
								if(!in_array($rowc['id'], $user_meta['campagin'])){
									?>
									<option value="<?php echo $rowc['id']; ?>" ><?php echo $rowc['company_name']; ?></option>
									<?php
								}
							?>
								
							<?php } ?>
					 </select>
					</div>
				</div>
				<div class="row mg-t-20">
				<label class="col-sm-12 form-control-label">Campaigns Assigned To User</label>
				</div>
					<?php 
					foreach($av_campaign as $compagian){ 
					 $sqlcs = select("company", "id = '$compagian' order by id DESC");
					$rowcs = fetch($sqlcs)
					?>
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label"><?=$rowcs['company_name']?></label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<a href="#">View</a> / <a href="#">Reports</a>
					</div>
				</div>
				<?php } ?>
			  </div>

			<div class="card pd-20 pd-sm-40 form-layout form-layout-4 mg-t-20">
					<div class="row">
						<label class="col-sm-4 form-control-label">Monthly Fee</label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
							<?php echo $currSymbol.(get_user_info($row['id'],'monthly_license_fee',true) != '' ? number_format(get_user_info($row['id'],'monthly_license_fee',true),2) : '0.00');?>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-4 form-control-label">Daily Fee</label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
							<?php 
							$no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('y'));
							$charges = get_user_info($row['id'],'monthly_license_fee',true) / $no_of_days_in_month;
							 echo $currSymbol.number_format($charges,2);
							?>
						</div>
					</div>
				<div class="row">
					<div class="form-layout-footer mg-t-30">
						<div class="row">
						<label class="col-sm-4 form-control-label">Monthly Fee</label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
							<input class="form-control" type="text" name="monthly_license_fee" value="<?php echo get_user_info($row['id'],'monthly_license_fee',true); ?>">
						</div>
					</div>
					</div>
				</div>
			</div>
		  </div>
		  
		 <div class="col-md-6">
		
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <h6 class="card-body-title"></h6>
              <div class="row">
                <label class="col-sm-4 form-control-label">First Name: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'first_name',true); ?></span>
                </div>
              </div><!-- row -->
			    <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Last Name: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'last_name',true); ?></span>
                </div>
              </div><!-- row -->
			   <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Company: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_company',true); ?></span>
                </div>
              </div><!-- row -->
			  <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">URL: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_url',true); ?></span>
                </div>
              </div><!-- row -->
			    <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Email: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
				<input type="hidden" name="email" value="<?php echo get_user_info($row['id'],'av_email',true); ?>">
                  <span><?php echo get_user_info($row['id'],'av_email',true); ?></span>
                </div>
              </div><!-- row -->
			     <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Phone Number: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_phone',true); ?></span>
                </div>
              </div><!-- row -->
			   <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Fax: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_fax',true); ?></span>
                </div>
              </div><!-- row -->
			   <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Address: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_address',true); ?></span>
                </div>
              </div><!-- row -->
			    <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">City: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_city',true); ?></span>
                </div>
              </div><!-- row -->
			    <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Stae: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_state',true); ?></span>
                </div>
              </div><!-- row -->
			    <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Country: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_country',true); ?></span>
                </div>
              </div><!-- row -->
			 <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Post Code: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_post_code',true); ?></span>
                </div>
              </div><!-- row -->
			  
			  <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Tax/Vat Id: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_tax_vat_id',true); ?></span>
                </div>
              </div><!-- row -->
			  
			    <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Account Type: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_user_info($row['id'],'av_account_type',true); ?></span>
                </div>
              </div><!-- row -->
     
			<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Status</label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					 <select name="av_campaign_status" class="form-control">
						<option value="waiting" <?php if(get_user_info($row['id'],'av_campaign_status',true) == 'waiting'){ echo 'selected'; }?>>Waiting</option>
						<option value="approve" <?php if(get_user_info($row['id'],'av_campaign_status',true) == 'approve'){ echo 'selected'; }?>>Approve</option>
						<option value="suspend" <?php if(get_user_info($row['id'],'av_campaign_status',true) == 'suspend'){ echo 'selected'; }?>>Suspend</option>
					 </select>
					</div>
					
				</div>
			<div class="row mg-t-20">
			<label class="col-sm-4 form-control-label">Currency</label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<select required size="1" class="form-control" name="av_Currency" >
								  <option value="">----select a Currency----</option>
								<option value="GBP" <?php if(get_user_info($row['id'],'av_Currency',true) == 'GBP') { echo 'selected'; } ?>>£ GBP</option>
								<option value="USD" <?php if(get_user_info($row['id'],'av_Currency',true) == 'USD') { echo 'selected'; } ?>>$ USD</option>
								<option value="EURO" <?php if(get_user_info($row['id'],'av_Currency',true) == 'EURO') { echo 'selected'; } ?>>€ EURO</option>
								
								  </select>
				</div>
				</div>
			</div>
			<div class="form-layout-footer mg-t-30">
                <button type="submit" name="is_campaign" class="btn btn-info mg-r-5">Submit</button>
				  <button onClick="history.go(-1)" type="button" class="btn btn-info mg-r-5">Back</button>
             </div>
				
            </div><!-- card -->
			
          </div><!-- col-6 -->
		 
         
        </div><!-- row -->

	</form>
    </div>
    
<?php include('includes/common/footer.php'); ?>