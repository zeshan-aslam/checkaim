<?php
$postid = isset($_GET['campid']) ? $_GET['campid'] : -1; 
$action = isset($_GET['action']) ? $_GET['action'] : '';

$edit = $_REQUEST['action'];
	
	
 

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
			<h4>Add Custom Template</h4>
			<div class="card-body">
				<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="<?php echo SITEURL; ?>controller/save_campagin.php?pid=<?php echo $postid; ?>" method="post">
				<input type="hidden" name="redirect_url" value="company-new">
				<input type="hidden" name="compaign_type" value="custom">
        <div class="row text-center">
		<div class="col-sm-2">
		</div>
		<?php		
		if($edit == '')
		{
			
		}
		else
		{	
		?>
		<div class="col-sm-8">
								<p style="color: red;">Charges: Impression = (<?php echo $currSymbol; ?><?php if($companydata['impression_amt'] != ''){ echo number_format($companydata['impression_amt'],2); }else{ echo '0.00'; } ?>) Submission = (<?php echo $currSymbol; ?><?php if($companydata['submission_amt'] != ''){ echo number_format($companydata['submission_amt'],2); }else{ echo '0.00'; } ?>) Qualified Lead = (<?php echo $currSymbol; ?><?php if($companydata['qualified_lead_amt'] != ''){ echo number_format($companydata['qualified_lead_amt'],2); }else{ echo '0.00'; } ?>)</p>
					</div>	
		<?php
		}
		?>
		
			<div class="col-sm-2">
			</div>
		</div>
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Campaign Name: <span class="tx-danger">*</span></label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					
				  <input type="text" name="company_name" id="companyname" <?php if($action == 'edit'){ echo 'disabled'; }else{} ?> class="form-control" value="<?php echo $fetchpost['company_name']; ?>">
				  <span class="show_message"></span>
				</div>
			</div><!-- row -->

			<div class="row mg-t-20">
				<div class="col-sm-4">
				<label class="form-control-label">Enter your Template Html Code Please inclde the {avaz-form} where you want to display the Data Collection Form: <span class="tx-danger">*</span></label>
				<p>
					<?php
					
					$sqls = mysqli_query($con,"select * from av_style");
					$rowss = fetch($sqls);
					
					?>
					<span>Styling here ****EXAMPLE***<span>
					<textarea readonly style="height: 378px;" class="form-control"><?php echo htmlspecialchars($rowss['style_example']); ?></textarea>
				</p>
				</div>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
				  <textarea class="input-block-level form-control" style="height:800px" id="" name="config[description]"><?php echo htmlspecialchars($companydata['description']); ?></textarea>
				</div> 
			</div><!-- row -->
			
				<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Affiliate Merchant Tracking: <span class="tx-danger"><br></br><br>In order to use Affiliate Tagging Please use the following Tags:
				{ORDERID} = This will Create a unque order id</br></span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<textarea style="height: 194px;" rows="10" class="form-control" name="config[affiliate_merchant]"><?php echo $companydata['affiliate_merchant']; ?></textarea>
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
			  
			
			<div class="row mg-t-20">				
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="hidden" name="config[impression_amt]" class="form-control" value="<?php echo $companydata['impression_amt']; ?>" placeholder="0.00">
                </div>
              </div>
			   <div class="row mg-t-20">				
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="hidden" name="config[submission_amt]" class="form-control" value="<?php echo $companydata['submission_amt']; ?>" placeholder="0.00">
                </div>
              </div>
			   <div class="row mg-t-20">				
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="hidden" name="config[qualified_lead_amt]" class="form-control" value="<?php echo $companydata['qualified_lead_amt']; ?>" placeholder="0.00">
                </div>
              </div>
			  
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