<?php
$sql = select("users", "id='$leadgenid'");
$rowu = fetch($sql);

?>
<div class="row"> 
	<div class="col-md-12">
		<div class="card stacked-form">
			<?php
							if(isset($_SESSION['successprofile'])){
								?>
								<p class="alert alert-success"><?php echo $_SESSION['successprofile']; ?></p>
								<?php
								unset($_SESSION['successprofile']);	
							}
							if(isset($_SESSION['faluireprofile'])){
								?>
								<p class="alert alert-danger"><?php echo $_SESSION['faluireprofile']; ?></p>
								<?php
								unset($_SESSION['faluireprofile']);	
							}
						?>
			<div class="row">
				<div class="col-md-6">
					<div class="card-header">
						<h4 class="card-title">CheckAIM Login Info</h4>
						
					</div>
					<div class="card-body">
					<form method="post" action="<?php echo SITEURL.'controller/accounts.php'; ?>">
						<div class="form-group">
							<label>Email Id</label>
							<input  type="email" name="login_email" class="form-control" size="25" value="<?php echo $rowu['email']; ?>"/>
						</div>
						<div class="form-group">  
							<label>New Password</label>
							<input  autocomplete="new-password" type="password" name="new_password" class="form-control" size="25" value=""/>
						</div> 
						<div class="form-group">  
							<label>Confirm Password</label>
							<input  autocomplete="new-password" type="password" name="con_password" class="form-control" size="25" value=""/>
						</div>
						<div class="form_editlink">
							<button  type="submit" class="btn btn-fill btn-info" name="save_login">Edit</button>
						</div>
						</form>
					</div> 
				</div>
				<div class="col-md-6">
					<div class="card-header">
						<p></p>
						<span class="textred">&nbsp;</span>
						<h4 class="card-title">Client Logo</h4>
						<span class="textred"></span>
					</div>
					<div class="card-body"> 
						<form id="Ajaxform">
						<?php if(get_user_info($leadgenid,'av_profile_image',true) != ''){ ?>
								<div class="addimg_preview">
									<img  src="<?php echo SITEURL.'upload/leadgen/'.get_user_info($leadgenid,'av_profile_image',true); ?>" id="" height="150" width="150">
								</div>
						<?php } ?>
							<div class="img_preview" style="display:none;">
								<div class="im_progress">
								Loading.....
								</div>
							<img  src="" id="img_preview" height="150" width="150">
							</div>
							<div class="All_images"></div>
							<input type="file" name="ajax_file" id="Fileinput" onchange="readURL(this);">
						</form> 
						<div class="img_upload_err">
							<span class="textred">Please Note: Logo's Must be 150*150 Pixels. Only JPEG, GIF, PNG</span></div>
					</div>
				</div>
			</div>
			<form method="post" name="reg" action="<?php echo SITEURL.'controller/accounts.php'; ?>">
				<div class="card-header">
					<h4 class="card-title">Client Contact Info</h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6">
							<div class="form-group">
								<label>First Name</label>
								<input type="text" required name="first_name" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'first_name',true); ?>" />
							</div>
							<div class="form-group">
								<label>Last Name</label>
								<input required type="text" name="last_name" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'last_name',true); ?>"/>
							</div>
							<div class="form-group">
								<label>Company</label>
								<input required type="text" name="av_company" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'av_company',true); ?>"/>
							</div>
							<div class="form-group">
								<label>URL</label>
								<input required type="text" name="av_url" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'av_url',true); ?>" />
							</div>
							<div class="form-group">
								<label>Address</label>
								 <textarea required rows="2" name="av_address" class="form-control textarea_contrl"><?php echo get_user_info($leadgenid,'av_address',true); ?></textarea>
							</div>    
							<div class="form-group">
								<label>State</label>
								<input required type="text" name="av_state" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'av_state',true); ?>" />
							</div>
							<!--<div class="form-group">
								<label>Type</label>
								<select size="1" class="form-control" name="av_account_types" disabled="disabled">
								 <option value="">Select a type</option>
								  <option value="advance" <?php  //if(get_user_info($leadgenid,'av_account_type',true) == 'advance'){ echo 'selected'; }?>>Advance</option>
								  <option value="normal" <?php  //if(get_user_info($leadgenid,'av_account_type',true) == 'normal'){ echo 'selected'; }?>>Normal</option>								  
							  </select>
							</div>-->
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Category</label>
								<select required size="1" class="form-control" name="av_category" >
								  <option value="">----select a Category----</option>
								<option value="B2B Services / Retail" <?php  if(get_user_info($leadgenid,'av_category',true) == 'B2B Services / Retail'){ echo 'selected'; }?>>B2B Services / Retail</option>
								<option value="Charities" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Charities'){ echo 'selected'; }?>>Charities</option>
								<option value="Education" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Education'){ echo 'selected'; }?>>Education</option>
								<option value="Entertainment" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Entertainment'){ echo 'selected'; }?>>Entertainment</option>
								<option value="Finance &amp; Legal" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Finance &amp; Legal'){ echo 'selected'; }?>>Finance &amp; Legal</option>
								<option value="Freebies / Comps / Surveys" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Freebies / Comps / Surveys'){ echo 'selected'; }?>>Freebies / Comps / Surveys</option>
								<option value="Gambling" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Gambling'){ echo 'selected'; }?>>Gambling</option>
								<option value="Motoring" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Motoring'){ echo 'selected'; }?>>Motoring</option>
								<option value="Online Dating" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Online Dating'){ echo 'selected'; }?>>Online Dating</option>
								<option value="Other" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Other'){ echo 'selected'; }?>>Other</option>
								<option value="Retail" <?php  if(get_user_info($leadgenid,'av_category',true) == 'advance'){ echo 'selected'; }?>>Retail</option>
								<option value="Shopping" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Shopping'){ echo 'selected'; }?>>Shopping</option>
								<option value="Travel" <?php  if(get_user_info($leadgenid,'av_category',true) == 'Travel'){ echo 'selected'; }?>>Travel</option>
								  </select>
							</div>
							<div class="form-group">
								<label>Phone</label>
								<input required type="text" name="av_phone" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'av_phone',true); ?>"/>
							</div>
							<div class="form-group">
								<label>SKYPE ID</label>
								<input required type="text" name="av_fax" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'av_fax',true); ?>"/>
							</div>
							<div class="form-group">
								<label>ZIP/POST CODE</label>
								<input required type="text" name="av_post_code" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'av_post_code',true); ?>" />
							</div>	
							<div class="form-group">
								<label>CITY/TOWN</label>
								<input required type="text" name="av_city" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'av_city',true); ?>"/>
							</div>
							<div class="form-group">
								<label>COUNTRY</label>
								<select required class="form-control" size="1" name="countrylst">
								  <option value="nill" >----Select a Country----</option>
								  <?php
									$result    = select("country");
									
								?>
								<?php
									while($row=mysqli_fetch_object($result))
									{
										$selected = "";
										
									if(get_user_info($leadgenid,'countrylst',true) == $row->country_name)
									{
										$selected = 'selected';
									}
								?>
									<option value="<?=$row->country_name?>" <?php echo $selected; ?> ><?=$row->country_name?></option>
								<?php
								
									}
								?>
								</select>
							</div>
							<div class="form-group">
								<label>TAX/VAT ID</label>
								<input required type="text" name="av_tax_vat_id" class="form-control" size="20" value="<?php echo get_user_info($leadgenid,'av_tax_vat_id',true); ?>" />
							</div>
								<div class="form-group">
								<label>Currency</label>
								<select required size="1" class="form-control" name="av_Currency" >
								  <option value="">----select a Currency----</option>
								<option value="GBP" <?php if(get_user_info($leadgenid,'av_Currency',true) == 'GBP') { echo 'selected'; } ?>>£ GBP</option>
								<option value="USD" <?php if(get_user_info($leadgenid,'av_Currency',true) == 'USD') { echo 'selected'; } ?>>$ USD</option>
								<option value="EURO" <?php if(get_user_info($leadgenid,'av_Currency',true) == 'EURO') { echo 'selected'; } ?>>€ EURO</option>
								
								  </select>
							</div>							
						</div>
						<div class="col-md-12">
							<div class="form-group text-center">
								<input type="submit" class="btn btn-fill btn-info" value="Edit Contact Info" name="edit_contact_info" alt="Edit" />&nbsp;

							</div>
						</div> 
					</div> 
				</div>
			</form>
		</div>
	</div>
</div>