<?php include('includes/common/header.php'); ?>

<?php include('includes/common/sidebar.php'); ?>
<?php

		$query = " SELECT sum(amount) amount, count(*) transactions FROM `partners_aianalytics` ";
		$totalTransactions = mysqli_query($con,$query);

		if(mysqli_num_rows($totalTransactions) > 0)
		{
			$totalTransactionsData = mysqli_fetch_assoc($totalTransactions);
		}

		$todaySaleSql = "select sum(sales) sales, sum(alerts) alerts, sum(transactions) transactions, sum(reports) reports from partners_aidailystats where  date = '".date("Y-m-d")."' "; 
		$todaySaleSqlResult 	=	mysqli_query($con,$todaySaleSql);	
		$todaysSale = mysqli_fetch_assoc($todaySaleSqlResult);

?>

	<div class="am-pagetitle">
        <h5 class="am-title">Dashboard</h5>
        
      </div><!-- am-pagetitle -->
	  	<?php
if(is_nan($pimpress) == 1){
	$pimpress = 0; 
}
if(is_nan($psubmission) == 1){
	$psubmission = 0; 
}
if(is_nan($pconfirlead) == 1){
	$pconfirlead = 0; 
}
?>




      <div class="am-pagebody">
		<div class="card pd-20 ">
			<div class="table-wrapper">
		
				<div class="row">
					<div class="col-lg-4 col-sm-6">
						<div class="card card-stats card-border1" style="min-height: 138px;">
							<div class="card-body ">
								<div class="row">
									<div class="col-5">
										<div class="icon-big text-center icon-warning">
											<i class="nc-icon nc-money-coins text-warning"></i>
										</div>
									</div>
									<div class="col-7">
										<div class="numbers">
											<p class="card-category">Total Sales Monitored</p>
											<h4 class="card-title"><?php echo number_format($totalTransactionsData["amount"],2) ?> (<?php echo $totalTransactionsData["transactions"] ?>)</h4>
										</div>
									</div>
								</div>
							</div>				
						</div>
					</div>
					
					<div class="col-lg-4 col-sm-6">
						<div class="card card-stats card-border1" style="min-height: 138px;">
							<div class="card-body ">
								<div class="row">
									<div class="col-5">
										<div class="icon-big text-center icon-warning">
											<i class="nc-icon nc-bank text-success"></i>
										</div>
									</div>
									<div class="col-7">
										<div class="numbers">
											<p class="card-category">Today's Sales</p>
											
									
											<h4 class="card-title"><?=number_format($todaysSale["sales"],2)?></h4>
										</div>
									</div> 
								</div>
							</div>
							<div class="card-footer ">
								<hr>
								<div class="stats">
									<i class="fa "></i> <?php echo date('d/m/Y'); ?>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-lg-4 col-sm-6">
						<div class="card card-stats card-border1" style="min-height: 138px;">
							<div class="card-body ">
								<div class="row">
									<div class="col-5">
										<div class="icon-big text-center icon-warning">
											<i class="nc-icon nc-time-alarm text-primary"></i>
										</div>
									</div>
									<div class="col-7">
										<div class="numbers">
											<p class="card-category">Today's Alerts</p>
											<h4 class="card-title"><?=$todaysSale["alerts"]?></h4>
										</div>
									</div>
									<div class="card-footer ">
								<hr>
								<div class="stats">
									<i class="fa "></i> <?php echo date('d/m/Y'); ?>
								</div>
							</div>
								</div>
							</div>				
						</div>
					</div>
				</div>
				<div class="row"> 
					<div class="col-md-6">
						<div class="card card-border1 ">
							<div class="card-header ">
								<h4 class="card-title">Client Sales</h4>
							</div>
							<div class="card-body ">
								<div id="divClientSalesChart"  style="height: 400px;">
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card card-border1">
							<div class="card-header ">
								<h4 class="card-title">Client Transaction</h4>
							</div>
							<div class="card-body ">
								<div id="divClientTransactionsChart" style="height: 400px;"></div>
							</div>				
						</div>
					</div>
					
				</div>
				<div class="row"> 
					<div class="col-md-12">
						<div class="card card-border1 ">
							<div class="card-header ">
								<h4 class="card-title">Estimated Earnings</h4>
							</div>
							<div class="card-body ">
								<div id="divEstimatedEarnings"  style="height: 400px;">
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="card card-border1 ">
							<div class="card-header ">
								<h4 class="card-title">Sale's Location</h4>
							</div>
							<div class="card-body ">
								<div id="divSaleLocationChart" class="ct-chart" style="height: 600px;">
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div><!-- am-pagebody -->
<?php
if(is_nan($pimpress) == 1){
	$pimpress = 0; 
}
if(is_nan($psubmission) == 1){
	$psubmission = 0; 
}
if(is_nan($pconfirlead) == 1){
	$pconfirlead = 0; 
}
?>
<script language="javascript" type="text/javascript">
	var pclick = <?php echo round($pimpress); ?>;
	var plead = <?php echo round($psubmission); ?>;
	var psale = <?php echo round($pconfirlead); ?>;
	var yearclick = '<?php echo json_encode($submissionyearly); ?>';
	var yearsale = '<?php echo json_encode($leadsyearly); ?>';
	var saledate = <?php echo '['.rtrim($mimpress['weekvalue'],',').']'; ?>;
	var yearMsale = <?php echo '['.rtrim($mconfirlead['wsale'],',').']'; ?>;
	var yearMclicks = <?php echo '['.rtrim($mimpress['wsale'],',').']'; ?>;
	var yearMleads = <?php echo '['.rtrim($msubmission['wsale'],',').']'; ?>;
	
	//alert(yearclick);
	//yearlyarrayaffilates alert(pclick + ", " + plead + ", " + psale + ", " + yearclick + ", " + yearsale + ", "+ saledate + "," + yearMsale + ", " + yearMclicks + ", " + yearMleads);
</script> 

<?php

	$footerscripts = "dashboard";

?>

<?php include('includes/common/footer.php'); ?>