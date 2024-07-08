 <?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); ?>
	<div class="am-pagetitle">
        <h5 class="am-title">Configration</h5>
       
      </div><!-- am-pagetitle -->
	
      <div class="am-pagebody">
		<div class="row row-sm mg-t-20">
			
			<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="controller/save_config.php" method="post">
				<input type="hidden" name="redirect_url" value="configration">
          <div class="col-md-12">
		  <?php
			if(isset($_SESSION['successconfig'])){
				echo '<p class="alert alert-success">'.$_SESSION['successconfig'].'</p>';
				unset($_SESSION['successconfig']);
			}else if(isset($_SESSION['faliureconfig'])){
				echo '<p class="alert alert-danger">'.$_SESSION['faliureconfig'].'</p>';
				unset($_SESSION['faliureconfig']);
			}
		?>
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
			<div class="row">
				<label class="col-sm-4 form-control-label">Logo: <span class="tx-danger">*</span></label>
				<?php $logoname =  get_config_meta('logo_name', true); ?>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="file" name="logo_name">
				  <img width="100px" src="<?php echo SITEURL.'img/'.$logoname; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Main Site Link: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[main_site_link]" class="form-control" value="<?php echo get_config_meta('main_site_link', true); ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Form Title: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[form_title]" class="form-control" value="<?php echo get_config_meta('form_title', true); ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Form Description: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[form_description]" class="form-control" value="<?php echo get_config_meta('form_description', true); ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Description: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <textarea class="input-block-level" id="summernote" name="config[description]"><?php echo get_config_meta('description', true); ?></textarea>
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Form Button Color: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[form_button_color]" class="form-control jscolor" value="<?php echo get_config_meta('form_button_color', true); ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Form Button Hover Color: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[form_button_hover_color]" class="form-control jscolor" value="<?php echo get_config_meta('form_button_hover_color', true); ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Link Color: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[link_color]" class="form-control jscolor" value="<?php echo get_config_meta('link_color', true); ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Border Color: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[border_color]" class="form-control jscolor" value="<?php echo get_config_meta('border_color', true); ?>">
				</div>
			</div><!-- row -->
			<div class="form-layout-footer mg-t-30">
                <button type="submit" name="submit_post" class="btn btn-info mg-r-5">Submit</button>
                <button class="btn btn-secondary">Cancel</button>
             </div><!-- form-layout-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->
         </form>
        </div><!-- row -->
	</div>
<?php include('includes/common/footer.php'); ?>