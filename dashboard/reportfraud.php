<?php

	$alertid = $_GET["alertid"];
	$transactionid = $_GET["transactionid"];

	$mid =  leaduserinfo('id');

	if($alertid > 0)
	{
		$sql = " Select a.*,  an.ipaddress, an.browser, an.os, an.productids, an.postage, an.tax, an.cartid, an.trafficsource, an.auid, an.amount, an.keyword, an.currency, an.createdate as transactiondate   from partners_alerts a left join partners_aianalytics an on a.analyticsid = an.id where a.alertid = '$alertid' ";
		$result = mysqli_query($con,$sql);	
		$alert = mysqli_fetch_assoc($result);
	}
	else if($transactionid > 0)
	{
		$alertid = 0;
		$sql = " Select a.createdate as transactiondate, au.id as auidid, a.*  ";
		$sql.= " from partners_aianalytics a left join partners_auid au on a.auid = au.auid and a.mid = au.merchantid where a.id = '$transactionid' ";
		$result = mysqli_query($con,$sql);	
		$alert = mysqli_fetch_assoc($result);
	}

	$orderid = $alert['orderid'];

	$crsql = "select * from partners_cannedresponse";
	$crresult = mysqli_query($con,$crsql);	


	$report = null;
	$sql = " Select * FROM `partners_reports` where mid = '".$mid."' and orderid = '".$orderid."'  ";
		//die($sql);
	$result = mysqli_query($con,$sql);

	if(mysqli_num_rows($result) > 0)
	{
		$report = mysqli_fetch_assoc($result);
	}


?>
<div class="row"> 
	<div class="col-md-12">
		<div class="card stacked-form">
			<?php
							if(isset($_SESSION['successreportfraud'])){
								?>
								<p class="alert alert-success"><?php echo $_SESSION['successreportfraud']; ?></p>
								<?php
								unset($_SESSION['successreportfraud']);	
							}
							if(isset($_SESSION['faluirereportfraud'])){
								?>
								<p class="alert alert-danger"><?php echo $_SESSION['faluirereportfraud']; ?></p>
								<?php
								unset($_SESSION['faluirereportfraud']);	
							}
						?>
			<div class="row">

				<?php 
					if($alert != null)
					{

					

				?>
				<div class="col-md-8">
					<div class="card-header">
						<h4 class="card-title">Report Fraud</h4>
						
					</div>
					<div class="card-body">

						<?php if($report != null)
						{
							?>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-danger" role="alert">
								  This transaction has already been reported as fraud
								</div>
							</div>
						</div>
						<?php
						}
						?>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Date</label>
									<?php echo $alert["transactiondate"]; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>IP Address</label>
									<?php echo $alert["ipaddress"]; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Order Id</label>
									<?php echo $alert["orderid"]; ?>
								</div>

							</div>
							<div class="col-md-4">	
							<div class="form-group">							
									<label>Operating System</label>
									<?php echo $alert["os"]; ?>
								</div>
							</div>
							<div class="col-md-4">								
								<div class="form-group">
									<label>Browser</label>
									<?php echo $alert["browser"]; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>User Id</label>
									<?php echo $alert["auid"]; ?>
								</div>								
							</div>
							<div class="col-md-4">	
													<div class="form-group">
									<label>Currency</label>
									<?php echo $alert["currency"]; ?>
								</div>	
							</div>
							<div class="col-md-4">
							<div class="form-group">
									<label>Amount</label>
									<?php echo $alert["amount"]; ?>
								</div>								
							</div>
							<div class="col-md-4">	
							<div class="form-group">
									<label>Postage</label>
									<?php echo $alert["postage"]; ?>
								</div>							
							</div>
							<div class="col-md-4">	
							<div class="form-group">
									<label>Tax</label>
									<?php echo $alert["tax"]; ?>
								</div>					
							</div>
							<div class="col-md-4">	
							<div class="form-group">
									<label>Keyword</label>
									<?php echo $alert["keyword"]; ?>
								</div>					
							</div>
								
							</div>

					<form method="post" action="<?php echo SITEURL.'controller/reports.php'; ?>">
						<input type="hidden" name="alertid" value="<?php echo $alertid; ?>" />
						<input type="hidden" name="orderid" value="<?php echo $alert['orderid']; ?>" />
						<input type="hidden" name="auidid" value="<?php echo $alert['auidid']; ?>" />
					
						
						<div class="form-group">  
							<label>Response</label>
							<select class="form-control" id="drpResponse" name="responseid">
								<?php 
									if(mysqli_num_rows($crresult) > 0)
									while($crrow = mysqli_fetch_assoc($crresult))
									{

										$selected = $report != null && $report["cannedresponseid"] == $crrow['id'] ? " selected " : "";

								?>
								<?php ?>
									<option <?php echo $selected; ?> value="<?php echo $crrow['id']; ?>"><?php echo $crrow['name']; ?></option>
								<?php
									}
								?>
							</select>
						</div> 
						<div class="form-group">  
							<label>Notes</label>
							<textarea id="txtNotes" name="notes" class="form-control" style="height: 80px" ><?php if($report != null) { echo $report["notes"]; } ?></textarea>  
						</div>
						<div class="form_editlink">
							<button  type="submit" class="btn btn-fill btn-info" name="report_fraud">Save</button>
						</div>
						</form>
					</div> 
				</div>

				<?php
					}
				?>
				
			</div>
		
		</div>
	</div>
</div>