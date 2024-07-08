<?php include('includes/header.php'); 
$id = $_REQUEST['token'];
 

?> 
<div class="container" style="padding:165px 0 78px"> 
<div class=" custom_regiser inner_content cus_zindex pw-form">
	<div class="col-md-10 col-sm-8 col-xs-12">
		<h3>Reset Password</h3>
	<?php
			if(isset($_SESSION['successr'])){
				echo '<p class="alert alert-success">'.$_SESSION['successr'].'</p>';
				unset($_SESSION['successr']);
				 header("Refresh: 2; https://checkaim.com/");
			}else if(isset($_SESSION['failurer'])){
				echo '<p class="alert alert-danger">'.$_SESSION['failurer'].'</p>';
				unset($_SESSION['failurer']);
			}
			?>
		
			<form action="controller/confirmlink.php" class="" method="post">
		
			<div class="form-group">
				<label class="col-md-5">Please Enter your new Password</label>
				<div class="col-md-7">
				<input id="password" type="password" class="form-control" name="new_password" placeholder="Password" required>
				<input type="hidden"  name="uid"   value="<?php echo $id; ?>">
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="form-group">
				<label class="col-md-5">Please confirm your new Password</label>
				<div class="col-md-7">
					<input id="conpassword" type="password" required class="form-control" name="con_password" placeholder="Confirm Password">
				</div>
			</div>
			
			<div class="clearfix"></div>
			
			<div class="form-group">
				<div class="col-md-7  col-md-offset-5">
					<button type="submit" name="passwordreset" class="register_btn btn-center">Submit</button>
				</div>
				
			</div>	
			
		</form> 
	</div>

</div>	
</div>

<?php include('includes/footer.php'); ?>

