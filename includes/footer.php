
			<footer class="site-footer">
				<div class="container">
					<ul>
						<li><a href="#"><i class="fa fa-facebook-square"></i></a> </li>
						<li><a href="#"><i class="fa fa-twitter-square"></i></a> </li>
					</ul>
				
					<p class="copy">2020-21 © |  All right reserved.</p>
				</div> <!-- .container -->
			</footer> <!-- .site-footer -->
		</div> <!-- #site-content -->
		
		
		<script src="/js/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>

		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>
		<script src="js/jquery.validate.min.js"></script>

	<script>
		jQuery(document).ready(function($){
			
			$('#btnContactUs').on('click', function(){
				if($('#txtContactFullname').val() == ''){
					$('#contact_message').html('<p class="alert alert-danger">Fullname is required</p>');
					return;
				}
				
				if($('#txtContactCompany').val() == ''){
					$('#contact_message').html('<p class="alert alert-danger">Company is required</p>');
					return;
				}

				if($('#txtContactEmail').val() == ''){
					$('#contact_message').html('<p class="alert alert-danger">Email is required</p>');
					return;
				}

				if($('#txtContactPhone').val() == ''){
					$('#contact_message').html('<p class="alert alert-danger">Phone is required</p>');
					return;
				}

				$("#loader").show();
				var x = document.getElementById("frmContactUs");
				var formdata = new FormData(x);
				formdata.append('contactus', 'contactus');
					$.ajax({
						dataType: 'json',
						url: '<?php echo SITEURL; ?>controller/contactus.php',
						data: formdata,
						type: 'POST',
						contentType: false,
						processData: false,
						
						success: function(response){
							var obj = JSON.parse(JSON.stringify(response));
							$("#loader").hide();
							if(obj.success){
								
								$('#contact_message').html('<p class="alert alert-success">'+obj.message+'</p>')	
								window.location.href = obj.url
							}else{
								$('#contact_message').html('<p class="alert alert-danger">'+obj.message+'</p>')				
							}
						}
				});
			});


			$('#sign_in_btn').on('click', function(){
				if($('#username').val() == ''){
					$('#show_error_message').html('<p class="alert alert-danger">Username is required</p>');
					return;
				}
				if($('#loginpassword').val() == ''){
					$('#show_error_message').html('<p class="alert alert-danger">Password is required</p>');
					return;
				}
				$("#loader").show();
				var x = document.getElementById("signin");
				var formdata = new FormData(x);
				formdata.append('action', 'sign_in');
					$.ajax({
						dataType: 'json',
						url: '<?php echo SITEURL; ?>controller/login.php',
						data: formdata,
						type: 'POST',
						contentType: false,
						processData: false,
						
						success: function(response){
							var obj = JSON.parse(JSON.stringify(response));
							$("#loader").hide();
							if(obj.success){
								$('#reply_msg').val('');
								$('#show_error_message').html('<p class="alert alert-success">'+obj.message+'</p>')	
								window.location.href = obj.url
							}else{
								$('#show_error_message').html('<p class="alert alert-danger">'+obj.message+'</p>')				
							}
						}
				});
			});
			
			jQuery("#join_avaj").validate({
				rules: {
					first_name: {
						required: true,
						lettersonly: true
					},
					sur_name: {
						required: true,
						lettersonly: true
					},
					av_phone: {
						required: true,
						digits: true,
						maxlength: 20,
					},
					av_post_code: 'required',
					av_email: { 
						required: true,
						email: true,
						maxlength: 255,
						<?php if($companydata['multisubmission'] == 'no'){ ?>
						remote: 
							{ 
								url: ' <?php echo SITEURL?>/controller/signup.php', 
								type: "post",
							}
						<?php } ?>
					},
				},
				messages: {
					first_name: {
						required : 'This field is required',
						lettersonly : 'Letters only please',
					},
					sur_name: {
						required : 'This field is required',
						lettersonly : 'Letters only please',
					},
					av_email: {
						required : 'This field is required',
						email : 'Enter a valid email',
						<?php if($companydata['multisubmission'] == 'no'){ ?>
						remote: "Email already Exists",	
						<?php } ?>
					},
					av_phone:{
						required : 'This field is required',
						
					},
					av_post_code: 'This field is required',

				},
				submitHandler: function(form) {
					form.submit();
				}
			});

			jQuery.validator.addMethod("lettersonly", function(value, element) 
			{
  				return this.optional(element) || /^[a-z]+$/i.test(value);
			}, 
			"Letters only please"); 



				
		});
			
						  
	</script>

		




<!-- Contact us Modal -->

<!-- The Modal -->
<div class="modal" id="contact-model">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Get in touch</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-md-6 col-sm-12 col-lg-6">
		
		<h3> <i class="fa fa-map-marker"></i> ADDRESS:</h3>
		<hr>
		<p>Gradene, Station Road, Ulceby, Linconshire, DN39 6UQ, United Kingdom.</p>
		
		<h3><i class="fa fa-phone"></i> Phone no:</h3>
		<hr>
		<p style="">+44 (0)20 3287 2232 </p>
		
		<h3><i class="fa fa-envelope"></i> Email:</h3>
		<hr>
		<p style="margin-bottom:3px;">searlco.com@gmail.com </p>
	
		</div>
		<div class="col-md-6 col-sm-12 col-lg-6">
			<div class="request-form">
				<div id="contact_message"></div>
				<form id="frmContactUs" >
					<input type="text" id="txtContactFullname" name="fullname" class="form-name" placeholder="Full Name...">
					<input type="text" id="txtContactCompany" name="company" class="form-company" placeholder="Company Name...">
					<input type="text" id="txtContactEmail" name="email" class="form-email" placeholder="Email Address...">
					<input type="text" id="txtContactPhone" name="phone"  class="form-phone" placeholder="Phone Number...">
					<textarea id="txtContactMesasge" name="message" class="form-email" >Message...</textarea>
					<div class="action">
						<button type="button" id="btnContactUs" name="contactus" value="contactus">Send a request</button> 
					</div>
				</form>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>
<!-- end Contact us model -->



<!-- Terms & Conditions Modal -->

<!-- The Modal -->
<div class="modal" id="tc-model">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Terms &amp; Conditions</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <p><b>Please be sure to read the terms and conditions below. You indicate your agreement by using ANY of the SEARLCO websites, APPs or SEARLCO Services.</b>
		By using the SEARLCO Application ("App") or accessing any of the SEARLCO web sites - www.searlco.com, www.searlco.co.uk, www.searlco.net, www.searlco.xyz, CheckAIM.com, winpig.com/.co.uk or Paidcash.co.uk or any other known subsidary sites you agree to abide by the Terms and Conditions of use for the App or web site. Failure to adhere to these terms may result in suspension of your account, forfeiture of funds accumulated on the site, possible legal action and other remedies available under law.
		SEARLCO Limited are companies of SEARLCO Limited a UK limited company whose registered address is XXX with company number XXX. SEARLCO is the trademarked brand of SEARLCO Limited. All of the above are hereinafter combined under the term "SEARLCO".
		</p>
		<p><strong>SITE MEMBERSHIP AND TERMINATION OF ACCOUNTS</strong>
			SEARLCO allows only one account per person. We reserve the right to refuse membership to anyone at any time and to terminate an account with SEARLCO without notice at any time, for any reason.
			By accepting these Terms and Conditions, conducting a transaction (any purchase through the App or web site) you become a member of the SEARLCO community.</p>
				
				<p><strong>CHANGE OF TERMS &amp; CONDITIONS</strong>
			SEARLCO may modify/change any of the terms and conditions contained in this Agreement at any time and in our sole discretion. SEARLCO will notify members by email when/if this happens.</p>.
			<p><strong>MISCELLANEOUS</strong>
			This Agreement is governed by the laws of England, without reference to rules governing choice of laws. Failure to enforce strict performance under any provision of this Agreement does not constitute a waiver of SEARLCO's right to subsequently enforce such provision or any other provision of this Agreement.</p>
			<p><strong>FRAUDULENT TRANSACTIONS</strong>
			Providing false information to any of our Merchants, or attempting to fraudulently obtain monies from any merchants is a violation of law and of this agreement and will immediately trigger suspension of the account in violation and the event may be reported to the relevant authorities.</p>

      </div>

     
     
    </div>
  </div>
</div>
<!-- end Terms & Conditions model -->

<!-- GDPR Modal -->


<!-- login us Modal -->

<!-- The Modal -->
<div class="modal" id="login-model">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Login Now</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
		<div class="request-form">
			<form  id="signin">
				<div id="show_error_message">
				</div>
				<input type="text" name="username" id="username" class="form-email" placeholder="Email...">
				<input type="password" name="password" id="loginpassword" class="form-password" placeholder="******">
				<a href="forgotpassword.php" style="color:#1e4192; text-decoration:underline;">Forgot password</a>
				<div class="action">
					<input id="sign_in_btn" type="button" value="LOGIN">
				</div>
			</form>
		</div>
      </div>
    </div>
  </div>
</div>
<!-- end Contact us model -->

		
	</body>

</html>