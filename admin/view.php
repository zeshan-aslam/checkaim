 <?php include('includes/common/header.php'); ?>
 <?php
	$postid = isset($_GET['id']) ? $_GET['id'] : -1;
	$campid = isset($_GET['campid']) ? $_GET['campid'] : -1;

	$sql = select("joinavaz","id = '$postid' order by date DESC");
	$row = fetch($sql);
	
	$av_question1res = get_avaz_info($row['id'],'av_question1res',true);
	$av_question2res = get_avaz_info($row['id'],'av_question2res',true);
	$res1 = unserialize($av_question1res);
	$res2= unserialize($av_question2res);
?>
<?php include('includes/common/sidebar.php'); ?>
	<div class="am-pagetitle">
        <h5 class="am-title">View Detail</h5>
       
      </div><!-- am-pagetitle -->
	
      <div class="am-pagebody">
		<div class="row row-sm mg-t-20">
			
		 <div class="col-md-6">
		
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <h6 class="card-body-title"></h6>
              <div class="row">
                <label class="col-sm-4 form-control-label">First Name: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_avaz_info($row['id'],'first_name',true); ?></span>
                </div>
              </div><!-- row -->
			    <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Last Name: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_avaz_info($row['id'],'sur_name',true); ?></span>
                </div>
              </div><!-- row -->
			    <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Email: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_avaz_info($row['id'],'av_email',true); ?></span>
                </div>
              </div><!-- row -->
			     <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Phone Number: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_avaz_info($row['id'],'av_phone',true); ?></span>
                </div>
              </div><!-- row -->
			   <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Post Code: </label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo get_avaz_info($row['id'],'av_post_code',true); ?></span>
                </div>
              </div><!-- row -->
			  <?php foreach($res1 as $key => $val){ ?>
				<div class="row mg-t-20">
                <label class="col-sm-4 form-control-label"><?php echo $key; ?></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo $val; ?></span>
                </div>
              </div><!-- row -->
			  <?php  }?>
			  
			    <?php foreach($res2 as $key1 => $val1){ ?>
				<div class="row mg-t-20">
                <label class="col-sm-4 form-control-label"><?php echo $key1; ?></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <span><?php echo $val1; ?></span>
                </div>
              </div><!-- row -->
			  <?php  }?>
     
            </div><!-- card -->
				<div class="form-layout-footer mg-t-30">
                <button onClick="history.go(-1)" type="button" class="btn btn-info mg-r-5">Back</button>
          
             </div><!-- form-layout-footer -->
          </div><!-- col-6 -->
		  <div class="col-md-6">
		  <form action="controller/save_config.php" method="post">
		  <input type="hidden" value="<?php echo $postid; ?>" name="userid">
		  <input type="hidden" value="<?php echo $campid; ?>" name="campid">
		   <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <h6 class="card-body-title"></h6>
				<div class="row"> 
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<?php if(get_avaz_info($postid,'is_confirmed',true) == 2 ){ 	echo 'Cancelled'; ?><input type="hidden" name="is_confirmed" value="2"><?php }else{
						?>
						<input type="checkbox" name="is_confirmed" value="1" <?php if(get_avaz_info($postid,'is_confirmed',true) == 1 ){ echo 'checked'; }?>>
						<?php
					} ?>	 
					</div>
					<label class="col-sm-4 form-control-label">Confirmed</label>
				</div>
				<div class="row mg-t-20">
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					  <input type="checkbox" name="is_sold" value="1" <?php if(get_avaz_info($postid,'is_sold',true) == 1 ){ echo 'checked'; }?>>
					</div>
					<label class="col-sm-4 form-control-label">Sold</label>
				</div>
				<div class="row mg-t-20">
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					  <input type="checkbox" name="is_closed" value="1" <?php if(get_avaz_info($postid,'is_closed',true) == 1 ){ echo 'checked'; }?>>
					</div>
					<label class="col-sm-4 form-control-label">Closed</label>
				</div>
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Sold To</label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					  <textarea class="form-control" name="sold_to"></textarea>
					</div>
				</div>
				<div class="form-layout-footer mg-t-30">
                <button type="submit" name="is_submit" class="btn btn-info mg-r-5">Submit</button>
				
             </div>
			  <div class="row mg-t-20">
			 <ol>
			 <?php $allsold =  get_avaz_info($postid,'sold_to'); 
			
				foreach($allsold as $val){
					if($val['user_meta'] != ''){
					?>
						<li><?php echo $val['user_meta']; ?></li>
					<?php
					}
				}
			 ?>
			 </ol>
			 </div>
             </div>
			
			</form>
		  </div>
         
        </div><!-- row -->


    </div>
    
<?php include('includes/common/footer.php'); ?>