<?php
$postid = isset($_GET['campid']) ? $_GET['campid'] : -1; 
$action = isset($_GET['action']) ? $_GET['action'] : '';

	$sql = select("company","id='$postid'");
	$fetchpost = fetch($sql);
	$comid = $fetchpost['id'];
	if($leadgenid != $fetchpost['user_id'] && $postid != -1){
		$_SESSION['faliureerror'] = "Campagin not found";
		redirect(LEADURL.'index.php?Act=campaign');
	}
	$companydatas = unserialize(base64_decode(get_config_meta('company_data', $comid, true)));
	
	$companydata  = unserialize($companydatas['config']);

	$companyquestiondata  = unserialize($companydatas['questions']);
	$companyquestionoptiondata  = unserialize($companydatas['questionoption']);
?>
<div class="row"> 
	<div class="col-md-12">
		<div class="card stacked-form">
			<?php
			if(isset($_SESSION['successcamp'])){
			?>
				<p class="alert alert-success"><?php echo $_SESSION['successcamp']; ?></p>
			<?php
			unset($_SESSION['successcamp']);	
			}
			if(isset($_SESSION['faliurecamp'])){
			?>
				<p class="alert alert-danger"><?php echo $_SESSION['faliurecamp']; ?></p>
			<?php
			unset($_SESSION['faliurecamp']);	
			}
			?>
			<div class="card-body">
				<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="<?php echo SITEURL; ?>controller/save_campagin.php?pid=<?php echo $postid; ?>" method="post">
				<input type="hidden" name="redirect_url" value="company-new">
         
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Campaign Name: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					
				  <input type="text" name="company_name" id="companyname" <?php if($action == 'edit'){ echo 'disabled'; }else{} ?> class="form-control" value="<?php echo $fetchpost['company_name']; ?>">
				  <span class="show_message"></span>
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Logo: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				<?php $logoname = $companydata['logo_name']; ?>
				  <input type="file" name="logo_name">
				  <img width="100px" src="<?php echo SITEURL.'img/'.$logoname; ?>">
				  <input type="hidden" name="logname" value="<?php echo $logoname; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Main Site Link: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[main_site_link]" class="form-control" value="<?php echo $companydata['main_site_link']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Form Title: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[form_title]" class="form-control" value="<?php echo $companydata['form_title']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Form Description: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[form_description]" class="form-control" value="<?php echo $companydata['form_description']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Description: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <textarea class="input-block-level" id="summernote" name="config[description]"><?php echo $companydata['description']; ?></textarea>
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Form Button Color: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[form_button_color]" class="form-control jscolor" value="<?php echo $companydata['form_button_color']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Form Button Hover Color: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[form_button_hover_color]" class="form-control jscolor" value="<?php echo $companydata['form_button_hover_color']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Link Color: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[link_color]" class="form-control jscolor" value="<?php echo $companydata['link_color']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Border Color: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="text" name="config[border_color]" class="form-control jscolor" value="<?php echo $companydata['border_color']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Background Image: <span class="tx-danger">*</span></label>
				<?php $background_image = $companydata['background_image']; ?>
				 
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <input type="file" name="background_image" class="" >
				  <?php if($companydata['background_image'] != ''){ ?>
				  <img width="100px" id="showimgs" src="<?php echo SITEURL.'img/backimg/'.$background_image; ?>">
				  <a href="#" id="removeimg">Remove</a>
				  <?php } ?>
				   <input type="hidden" id="imageva" name="backgroundimage" value="<?php echo $background_image; ?>">
				</div>
			</div><!-- row -->
			
			<h2 class="mg-t-20">Privacy Policy</h2>
			  <div class="row mg-t-20">
			
                <label class="col-sm-4 form-control-label">Description: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <textarea  id="summernote1"  class="form-control" name="page[privacy_policy]"  ><?php if(get_post_meta($comid,'privacy_policy',true) != ''){ echo get_post_meta($comid,'privacy_policy',true); }else{ echo get_post_meta(0,'privacy_policy',true); } ?></textarea>
                </div>
              </div><!-- row -->
			  
			  <h2 class="mg-t-20">About Us</h2>
			
			  <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Description: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <textarea  id="summernote2"  class="form-control" name="page[about_us]"  ><?php if(get_post_meta($comid,'about_us',true) != ''){ echo get_post_meta($comid,'about_us',true); }else{ echo get_post_meta(0,'about_us',true); } ?></textarea>
                </div>
              </div><!-- row -->
			  
			  <h2 class="mg-t-20">Term & Condition</h2>
			  <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Description: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <textarea  id="summernote3"  class="form-control" name="page[term_condition]"  ><?php if(get_post_meta($comid,'term_condition',true) != ''){ echo get_post_meta($comid,'term_condition',true); }else{ echo get_post_meta(0,'term_condition',true); } ?></textarea>
                </div>
              </div><!-- row -->
			
			
			<h2 class="mg-t-20">Text Questions</h2>
			<div class="row mg-t-20">	
				<div class="col-sm-8 form-control-label cloneitem table-responsive">
					<table style="background-color: transparent;" id="servicedynamictables" class="table">
						<tbody>
						<?php for($i =0; $i< count($companydata['question_info']); $i++){?>
							<tr class="row tr_clone_row dynamicrow" >
								<td class="cus_td">
									<div class="own_fields own_input_field_text">
										<label>Name</label>
										<div class="own_label">
											<input type="text" id="name" class="form-control " name="question[<?php echo $$i; ?>][question_name]" value="<?php echo $companydata['question_info'][$i]['question_name']; ?>" >
										</div>		
									</div>
								</td>
								<td class="remove"><a id="" class="ser_tr_clone_remove button button-primary button-large btn btn-info mg-r-5" href="javascript:;">Remove</a></td>
							</tr>
							<?php } ?>
							<tr class="row tr_clone_row tr_row" style="display:none; ">
								<td style="width: 53%;" class="cus_td">
									<label>Name</label>
									<input type="text" id="name" class="form-control " name="" value="" >
								</td>
								<td class="remove"><a id="" class="ser_tr_clone_remove " href="javascript:;">Remove</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row mg-t-20">
				
				<div class="col-sm-8 form-control-label">
						<a href="#" oid="" tid="tabs-" class="tr_clone_text own-button button button-primary button-large btn btn-info mg-r-5">New Text</a>
				</div>
              </div>
			  <h2 class="mg-t-20">Dropdown Questions</h2>
			<div class="tr_clone_rowo" id="selectdynamictables" >
			<?php if(!empty($companyquestiondata)){ for($is =0; $is< count($companyquestiondata); $is++){?>
			<div class="row mg-t-20 dynamicr showw-<?php echo $is; ?>" >
				<div class="col-sm-12 form-control-label cloneitem table-responsive" >
					<table style="background-color: transparent;"  class="table dropt">
						<tbody>
							<tr class="row tr_row" >
								<td style="width: 53%;" class="cus_td">
									<label>Name</label>
									<input type="text" id="dropname" class="" name="dropquestion[<?php echo $is; ?>][question_name]" value="<?php echo $companyquestiondata[$is]['question_name']; ?>" >
										
								</td>
								<td class="remove"><a id="showw-<?php echo $is; ?>" class="option_tr_clone_remove " href="javascript:;">Remove</a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-sm-12 form-control-label cloneitem table-responsive">
					<table style="background-color: transparent;" class="table optiontable" id="optiontable">
						<tbody>
						<?php for($i =0; $i< count($companyquestionoptiondata[$is]); $i++){?>
							<tr class="row tr_clone_rows dynamicrow">
								<td class="cus_td">
									<label>Option</label>
									<input type="text" id="" class="option" name="dropopt[<?php echo $is; ?>][<?php echo $i; ?>][question_option]" value="<?php echo $companyquestionoptiondata[$is][$i]['question_option']; ?>" >	
								</td>
								<td class="cus_td">
									<label>value</label>
									<input type="text" id="" class="value" name="dropopt[<?php echo $is; ?>][<?php echo $i; ?>][question_value]" value="<?php echo $companyquestionoptiondata[$is][$i]['question_value']; ?>" >
								</td>
								<td class="remove"><a id="" class="ser_tr_clone_remove " href="javascript:;">Remove</a></td>
							</tr>
						<?php } ?>
						
						</tbody>
						<tfoot>
							<tr id="" class="row tr_row_selecto" >
								<td cols="3"><a id="<?php echo $is; ?>" class="tr_clone_option" href="javascript:;">Add Option</a></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<?php } } ?>
			<div class="row mg-t-20 myclonerow" style="display:none; ">	
				<div class="col-sm-12 form-control-label cloneitem table-responsive" >
					<table style="background-color: transparent;"  class="table dropt">
						<tbody>
							<tr class="row tr_row" >
								<td style="width: 53%;" class="cus_td">
									<label>Name</label>
									<input type="text" id="dropname" class="" name="" value="" >
										
								</td>
								<td class="remove"><a id="" class="option_tr_clone_remove " href="javascript:;">Remove</a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-sm-12 form-control-label cloneitem table-responsive">
					<table style="background-color: transparent;" class="table optiontable" id="optiontable">
						<tbody>
							<tr class="row tr_my_row tr_row_opt"  style="display:none; ">
								<td class="cus_td">
									<label>Option</label>
									<input type="text" id="" class="option" name="" value="" >	
								</td>
								<td class="cus_td">
									<label>value</label>
									<input type="text" id="" class="value" name="" value="" >
								</td>
								<td class="remove"><a id="" class="ser_tr_clone_remove " href="javascript:;">Remove</a></td>
							</tr>
							
						</tbody>
						<tfoot>
							<tr id="" class="row tr_row_selecto" >
								<td cols="3"><a id="<?php echo $is; ?>" class="tr_clone_option" href="javascript:;">Add Option</a></td>
							</tr>
						</tfoot>
					</table>
					<div>
				</div>
			</div>
			   </div><!-- card -->
			    </div><!-- card -->
			 <div class="row mg-t-20">
				<div class="col-sm-4 form-control-label">
						<a href="#" oid="" tid="tabs-" class="tr_clone_select own-button button button-primary button-large btn btn-info mg-r-5">New Select</a>
				</div>
				
              </div>
			  
			
			 <!-- <div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Impression: <span class="tx-danger"></span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="text" name="config[impression_amt]" class="form-control" value="<?php //echo $companydata['impression_amt']; ?>" placeholder="0.00">
                </div>
              </div>
			   <div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Submission: <span class="tx-danger"></span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="text" name="config[submission_amt]" class="form-control" value="<?php //echo $companydata['submission_amt']; ?>" placeholder="0.00">
                </div>
              </div>
			   <div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Qualified Lead: <span class="tx-danger"></span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="text" name="config[qualified_lead_amt]" class="form-control" value="<?php //echo $companydata['qualified_lead_amt']; ?>" placeholder="0.00">
                </div>
              </div>-->
			   <div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Google Analytics: <span class="tx-danger"></span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<textarea style="height: 194px;" rows="10" class="form-control" name="config[google_analytics]"><?php echo $companydata['google_analytics']; ?></textarea>
                </div>
              </div><!-- row -->
			   <div class="row mg-t-20">
				<label class="col-sm-4 form-control-label"></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<label>Are Multiple Submission from the Same user allowed?</label>
					<?php $cheval = ''; if(empty($companydata) || $companydata['multisubmission'] == ''){
						$cheval = 'checked';
					} ?>
					<label><input  required type="radio" name="config[multisubmission]" value="yes" <?php if($companydata['multisubmission'] == 'yes'){ echo 'checked'; }?>>Yes</label>
					<label><input <?php echo $cheval; ?> required type="radio" name="config[multisubmission]" value="no"<?php if($companydata['multisubmission'] == 'no'){ echo 'checked'; }?>>No</label>
                </div>
              </div><!-- row -->
			<div class="form-layout-footer mg-t-30">
                <button type="submit" id="subpos" name="submit_post" class="btn btn-info mg-r-5">Submit</button>
             </div><!-- form-layout-footer -->
  
         </form>
	</div>	
	</div>
</div>