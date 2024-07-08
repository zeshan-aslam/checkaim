<?php

	$mid = leaduserinfo('id');
	$sql = " Select * FROM `partners_alertsettings` where mid = '".$mid."'  ";
	$result = mysqli_query($con,$sql);

	$alertSettings = null;

	$interactCount = "0-5";
	$searchPrevTrans = "1";

	if(mysqli_num_rows($result) > 0)
	{
		$alertSettings = mysqli_fetch_assoc($result);
		$interactCount = $alertSettings["interactcount"];
		$searchPrevTrans = $alertSettings["searchprevtransterm"];
	}

?>
<div class="row"> 
	<div class="col-md-12">
		<div class="card stacked-form">
			<?php
							if(isset($_SESSION['successalertsettings'])){
								?>
								<p class="alert alert-success"><?php echo $_SESSION['successalertsettings']; ?></p>
								<?php
								unset($_SESSION['successalertsettings']);	
							}
							if(isset($_SESSION['faluirealertsettings'])){
								?>
								<p class="alert alert-danger"><?php echo $_SESSION['faluirealertsettings']; ?></p>
								<?php
								unset($_SESSION['faluirealertsettings']);	
							}
						?>
			<div class="row">
				<div class="col-md-6">
					<div class="card-header">
						<h4 class="card-title">Alert Settings</h4>
						
					</div>
					<div class="card-body">
					<form method="post" action="<?php echo SITEURL.'controller/alertsettings.php'; ?>">

					
						<div class="form-row">
						    <div class="form-group ">
						      <label >How often will a customer interact from you in a month?</label>
						      
						      <div class="row">
						      	<div class="col-md-6">
						      	<div class="form-check">
								  <input class="" type="radio" name="interactCount" id="rbtnInteractCount05"  value="5" <?php if($interactCount == "5"){ ?> checked <?php } ?> >
								  <label class="form-check-label" for="rbtnInteractCount05">
								    0-5 Times
								  </label>
								</div>
								<div class="form-check">
								  <input class="" type="radio" name="interactCount" id="rbtnInteractCount610"   value="10" <?php if($interactCount == "10"){ ?> checked <?php } ?> >
								  <label class="form-check-label" for="rbtnInteractCount610">
								    6-10 Times
								  </label>
								</div>
								<div class="form-check ">
								  <input class="" type="radio" name="interactCount" id="rbtnInteractCount1130"   value="30" <?php if($interactCount == "30"){ ?> checked <?php } ?>  >
								  <label class="form-check-label" for="rbtnInteractCount1130">
								   11-30 Times
								  </label>
								</div>
								<div class="form-check ">
								  <input class="" type="radio" name="interactCount" id="rbtnInteractCount31"   value="50" <?php if($interactCount == "50"){ ?> checked <?php } ?>  >
								  <label class="form-check-label" for="rbtnInteractCount31">
								   31+ Times
								  </label>
								</div>
								<div class="form-check ">
								  <input class="" type="radio" name="interactCount" id="rbtnInteractCount99999999"   value="9999999" <?php if($interactCount == "9999999"){ ?> checked <?php } ?>  >
								  <label class="form-check-label" for="rbtnInteractCount31">
								   Off
								  </label>
								</div>
								</div>
						      </div>

						    </div>

						     <div class="form-group ">
						      <label >When a fraud is reported by ANY client would you like us to search previous transactions?</label>
						      
						      <div class="row">
						      	<div class="col-md-6">
						      	<div class="form-check">
								  <input class="" type="radio" name="searchPrevTransactions" id="rbtnSearchPrevTransNo" value="no" <?php if($searchPrevTrans == "no"){ ?> checked <?php } ?>>
								  <label class="form-check-label" for="rbtnSearchPrevTransNo">
								   NO
								  </label>
								</div>
								<div class="form-check">
								  <input class="" type="radio" name="searchPrevTransactions"  id="rbtnSearchPrevTrans1Month" value="1" <?php if($searchPrevTrans == "1"){ ?> checked <?php } ?>>
								  <label class="form-check-label" for="rbtnSearchPrevTrans1Month">
								    Yes - Up to 1 month ago
								  </label>
								</div>
								<div class="form-check ">
								  <input class="" type="radio" name="searchPrevTransactions" id="rbtnSearchPrevTrans3Month"  value="3" <?php if($searchPrevTrans == "3"){ ?> checked <?php } ?>>
								  <label class="form-check-label" for="rbtnSearchPrevTrans3Month">
								   Yes - Up to 3 months ago
								  </label>
								</div>
								<div class="form-check ">
								  <input class="" type="radio" name="searchPrevTransactions" id="rbtnSearchPrevTrans6Month" value="6" <?php if($searchPrevTrans == "6"){ ?> checked <?php } ?>>
								  <label class="form-check-label" for="rbtnSearchPrevTrans6Month">
								   Yes - Up to 6 months ago
								  </label>
								</div>
								<div class="form-check ">
								  <input class="" type="radio" name="searchPrevTransactions" id="rbtnSearchPrevTransAll" value="all" <?php if($searchPrevTrans == "all"){ ?> checked <?php } ?>>
								  <label class="form-check-label" for="rbtnSearchPrevTransAll">
								   Yes – All Recorded Transactions
								  </label>
								</div>
								</div>
						      </div>

						    </div>
						    
						    
						  </div>
						  <input type="hidden" name="edit_alert_settings" value="1" />
						 <button type="submit" class="btn btn-primary">Save</button>
						</form>
					</div> 
				</div>
				<div class="col-md-6">
					
				</div>
			</div>
			
		</div>
	</div>
</div>