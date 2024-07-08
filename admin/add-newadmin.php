<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); ?>
<div class="am-pagetitle">
	<h5 class="am-title"> MASTER Admin </h5>
</div>
<div class="am-pagebody">
	<div class="row row-sm mg-t-20">
		<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="controller/save_admin.php" method="post">
			<div class="col-md-12">
				<?php
				if(isset($_SESSION['successadmin'])){
					echo '<p class="alert alert-success">'.$_SESSION['successadmin'].'</p>';
					unset($_SESSION['successadmin']);
				}else if(isset($_SESSION['faluireadmin'])){
					echo '<p class="alert alert-danger">'.$_SESSION['faluireadmin'].'</p>';
					unset($_SESSION['faliuresetting']);
				}
				?>
				<div class="card pd-20 pd-sm-40 form-layout form-layout-4">
					<!--<div class="row">
						<label class="col-sm-4 form-control-label">User Name: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="u_name" class="form-control" value="<?php echo get_option_meta('u_name'); ?>">
						</div>
					</div>-->
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">E- Mail : <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="email" name="email" class="form-control" value="">
						</div>
					</div><!-- row -->
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Password : <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="password" class="form-control" value="">
						</div>
					</div><!-- row -->
				<div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Admin Status  : <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select name="status" required class="form-control">
					<option value="">----</option>
					<option value="1" <?php echo ($fetchpost['pay_mode'] == 'Active' ? 'selected' : ''); ?>>Active</option>
					<option value="2" <?php echo ($fetchpost['pay_mode'] == 'Suspended' ? 'selected' : ''); ?>>Suspended</option>					
				 </select>
                </div>
              </div><!-- row -->
					<div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Admin level : <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select name="level" required class="form-control">
					<option value="">----</option>
					<option value="1" <?php echo ($fetchpost['pay_mode'] == 'Junior' ? 'selected' : ''); ?>>Junior</option>
					<option value="2" <?php echo ($fetchpost['pay_mode'] == 'Senior' ? 'selected' : ''); ?>>Senior</option>
					<option value="3" <?php echo ($fetchpost['pay_mode'] == 'Master' ? 'selected' : ''); ?>>Master</option>
				 </select>
                </div>
              </div><!-- row -->
					
					 <div class="form-layout-footer mg-t-30">
						<button type="submit" name="submit_admin" class="btn btn-info mg-r-5">Submit</button>
					</div><!-- form-layout-footer -->
				</div>
			</div>
		</form>
	</div>
</div>


<?php include('includes/common/footer.php'); ?>