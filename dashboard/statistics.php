 <?php

#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------

 $mid =  leaduserinfo('id'); ;


 $auidid = 0;
 $ownerid = 0;

 if(isset($_GET["auidid"]))
 {
 	$auidid = $_GET["auidid"];
 }

 if(isset($_GET["ownerid"]))
 {
 	$ownerid = $_GET["ownerid"];
 }


 

 ?>  
 

 <div class="row">
 	<div class="col-md-12">
 		<div class="card stacked-form trackcode_form">
 			<div class="text-right" > 
 				<a href="javascript:window.print()" style="font-size: 30px; margin: 20px 20px 0px 0px;"><i class="fa fa-print"></i></a>
 			</div>
 			<div class="text-center">
 				<h2>Statistics</h2>
 				<p class="lead">Below are various statistics</p>
 				<p style="font-style: italic;">(Be default the statistics are show for last 60 days, select dates if you want to see reports for time specific period)</p>
 			</div>
 		</div>
 	</div>
 </div>
 <div class="row">
 	<div class="col-md-12">
 		<div class="card stacked-form">
 			<div class="card-body">
 			<form id="frmFilters">
					<div class="row form">
						<div class="col-md-2">
							<div class="form-group">
								<label>Filter by Date</label>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" placeholder="To" id="txtFilterFrom" class="form-control datepicker" name="from"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" placeholder="From" id="txtFilterTo" class="form-control datepicker" name="to"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<input class="btn btn-fill btn-info" type="submit" name="sub" value="View">
							<input type="hidden" name="locationstats" value="yes" />
						</div>
					</div>
				</form>
			</div>
 		</div>
 	</div>
 </div>
 <div class="row">
	<div class="col-md-12">
		<div class="card stacked-form">
			<div class="card-header">
				<h4 class="card-title">Order Locations</h4>
			</div>
			<div class="card-body">
				<form id="frmLocations">
					<div class="row form">
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" placeholder="To" id="txtLocationFrom" class="form-control datepicker" name="from"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" placeholder="From" id="txtLocationTo" class="form-control datepicker" name="to"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<input class="btn btn-fill btn-info" type="submit" name="sub" value="View">
							<input type="hidden" name="locationstats" value="yes" />
						</div>
					</div>
				</form>
				<div id="divLocationChart" style="height: 500px;">



				</div>
			</div>
		</div>
	</div>
</div>

 <div class="row">
	<div class="col-md-12">
		<div class="card stacked-form">
			<div class="card-header">
				<h4 class="card-title">Sales / Transactions / Alerts / Reports</h4>
			</div>
			<div class="card-body">
				<form id="frmTransactions">
					<div class="row form">
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" placeholder="To" id="txtTransactionsFrom" class="form-control datepicker" name="from"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" placeholder="From" id="txtTransactionsTo" class="form-control datepicker" name="to"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<input class="btn btn-fill btn-info" type="submit" name="sub" value="View">
							<input type="hidden" name="transactionstats" value="yes" />
						</div>
					</div>
				</form>
				<div id="divTransactionsChart" style="height: 500px;">



				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form">
			<div class="card-header">
				<h4 class="card-title">Operating System Analysis</h4>
			</div>
			<div class="card-body">
				<form id="frmOSAnalysis">
					<div class="row form">
						<div class="col-md-2">
							<div class="form-group">
								
								<input type="text" placeholder="To" id="txtOSAnalysisFrom" class="form-control datepicker" name="from"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" placeholder="From" id="txtOSAnalysisTo" class="form-control datepicker" name="to"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<input class="btn btn-fill btn-info" type="submit" name="sub" value="View">
							
							<input type="hidden" name="osstats" value="yes" />
						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-md-8">
						<div id="divOsAnalysisChart" style="height: 500px;">



						</div>
					</div>
					<div class="col-md-4">
						<div id="divDeviceTypeAnalysisChart" style="height: 500px;">



						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form">
			<div class="card-header">
				<h4 class="card-title">Browser Analysis</h4>
			</div>
			<div class="card-body">
				<form id="frmBrowserAnalysis">
					<div class="row form">
						<div class="col-md-2">
							<div class="form-group">
								
								<input type="text" placeholder="To" id="txtBrowserAnalysisFrom" class="form-control datepicker" name="from"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<input type="text" placeholder="From" id="txtBrowserAnalysisTo" class="form-control datepicker" name="to"  value="" />
							</div>
						</div>
						<div class="col-md-2">
							<input class="btn btn-fill btn-info" type="submit" name="sub" value="View">
							
							<input type="hidden" name="browserstats" value="yes" />
						</div>
					</div>
				</form>
				<div id="divBrowserAnalysisChart" style="height: 500px;">



				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="js/statistics.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){

 		
 		Statistics.Common.Init()
 		

 	});

 </script>

</script>