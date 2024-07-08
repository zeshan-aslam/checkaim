<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); ?>
<div class="am-pagetitle">
	<h5 class="am-title">Payment Info</h5>
</div>
<div class="am-pagebody">
	<div class="row row-sm mg-t-20">
		<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="controller/save_settings.php" method="post">
			<div class="col-md-12">
				<?php
				if(isset($_SESSION['successsetting'])){
					echo '<p class="alert alert-success">'.$_SESSION['successsetting'].'</p>';
					unset($_SESSION['successsetting']);
				}else if(isset($_SESSION['faliuresetting'])){
					echo '<p class="alert alert-danger">'.$_SESSION['faliuresetting'].'</p>';
					unset($_SESSION['faliuresetting']);
				}
				?>
				<div class="card pd-20 pd-sm-40 form-layout form-layout-4">
					<div class="row">
						<label class="col-sm-4 form-control-label">Account Name: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="account_name" class="form-control" value="<?php echo get_option_meta('account_name'); ?>">
						</div>
					</div><!-- row -->
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Account Number: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="account_number" class="form-control" value="<?php echo get_option_meta('account_number'); ?>">
						</div>
					</div><!-- row -->
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Sort Code: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="sort_code" class="form-control" value="<?php echo get_option_meta('sort_code'); ?>">
						</div>
					</div>
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Swift Code: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="swift_code" class="form-control" value="<?php echo get_option_meta('swift_code'); ?>">
						</div>
					</div>
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Paypal id: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="paypal_id" class="form-control" value="<?php echo get_option_meta('paypal_id'); ?>">
						</div>
					</div>
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Monthly License Fee: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<input type="text" name="monthly_license_fee" class="form-control" value="<?php echo get_option_meta('monthly_license_fee'); ?>">
						</div>
					</div>
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Compnay Name: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="Compnay_name" class="form-control" value="<?php echo get_option_meta('Compnay_name'); ?>">
						</div>
					</div>
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Address: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
										  
						  <textarea type="text" name="Address_name"  class="form-control"><?php echo get_option_meta('Address_name'); ?></textarea>
						</div>
					</div>
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Post Code / ZIP: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="Post_code" class="form-control" value="<?php echo get_option_meta('Post_code'); ?>">
						</div>
					</div>
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">Company Number: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="company_name" class="form-control" value="<?php echo get_option_meta('company_name'); ?>">
						</div>
					</div>
					<div class="row mg-t-30">
						<label class="col-sm-4 form-control-label">VAT / TAX Number: <span class="tx-danger">*</span></label>
						<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						  <input type="text" name="vat_tax_number" class="form-control" value="<?php echo get_option_meta('vat_tax_number'); ?>">
						</div>
					</div>
					 <div class="form-layout-footer mg-t-30">
						<button type="submit" name="submit_setting" class="btn btn-info mg-r-5">Submit</button>
					</div><!-- form-layout-footer -->
				</div>
			</div>
		</form>
	</div>
</div>
<?php include('includes/common/footer.php'); ?>