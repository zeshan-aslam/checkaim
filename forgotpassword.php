 <?php include('includes/header.php'); 

$filename                = "includes/mer_terms.htm";
$fp                      = fopen($filename,'r');
$contents                = fread ($fp, filesize ($filename));
fclose($fp);

?> 
<div class="container" style="padding:165px 0 78px"> 
<div class=" custom_regiser inner_content cus_zindex">
	<div class="col-md-8 col-sm-8 col-xs-12">
	<h3>Forget Password</h3>
			<?php
			if(isset($_SESSION['successr'])){
				echo '<p class="alert alert-success">'.$_SESSION['successr'].'</p>';
				unset($_SESSION['successr']);
			}else if(isset($_SESSION['failurer'])){
				echo '<p class="alert alert-danger">'.$_SESSION['failurer'].'</p>';
				unset($_SESSION['failurer']);
			}
			?>
			
			
		<form action="controller/forget.php" class="" method="post">
			<div class="form-group">
				<label class="col-md-5">Please Enter your E-mail Address</label>
				<div class="col-md-7">
					<input type="email" name="av_email" required placeholder="Email Address" class="form-control" />
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-7  col-md-offset-5">
					<button type="submit" name="sign_in" class="register_btn btn-center">Submit</button>
				</div>
				
			</div>			
		</form> 
	</div>
	
	<div class="clearfix"></div>
</div>	
</div>	

<?php include('includes/footer.php'); ?>