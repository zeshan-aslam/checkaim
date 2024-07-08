<?php
//daily stats grabber.

$lastOrderDay = null;
$lastorderdetails = null;

$lastOrderSql = " SELECT createdate FROM `partners_aianalytics`  where mid = '$leadgenid'  ORDER BY `createdate`  DESC limit 1 ";
$lastOrderSqlResult =	mysqli_query($con, $lastOrderSql);	

if(mysqli_num_rows($lastOrderSqlResult) > 0)
{
	$lastorderdetails = mysqli_fetch_assoc($lastOrderSqlResult);
	$diff = strtotime(date("Y-m-d")) - strtotime($lastorderdetails["createdate"]); 
      
    $lastOrderDay = abs(round($diff / 86400)); 
}


$saleLocations = array();

$saleLocSql = "SELECT location, city, region, country, count(orderid) as ordercount FROM `partners_aianalytics` where mid='$leadgenid' group by location, city, region, country ORDER BY `createdate` DESC limit 10";

$saleLocSqlResult 	=	mysqli_query($con,$saleLocSql);	

while($saleLocation = mysqli_fetch_assoc($saleLocSqlResult))
{
	$saleLocations[] = $saleLocation;
}



$todaySaleSql = "select sales, alerts, transactions, reports from partners_aidailystats where mid='$leadgenid' and date = '".date("Y-m-d")."' "; 
$todaySaleSqlResult 	=	mysqli_query($con,$todaySaleSql);	
$todaysSale = mysqli_fetch_assoc($todaySaleSqlResult);
$comaign = unserialize(get_user_info($leadgenid,'av_campaign',true));

//$month_start = date('Y-m-d',strtotime('first day of this month', time()));
//$month_end = date('Y-m-d',strtotime('last day of this month', time()));

$month_start = date('Y-m-d',strtotime('-30 days', time()));
$month_end = date('Y-m-d');

/*Monthly Count*/
$monthSaleSql = "select date, sales, alerts, transactions, reports from partners_aidailystats where mid='$leadgenid' and date between '".$month_start."' and '".$month_end."' order by date asc "; 

//echo $monthSaleSql;

$monthSaleSqlResult =	mysqli_query($con,$monthSaleSql);	

$monthDates = array();
$monthSales = array();
$monthAlerts = array();
$monthTransactions = array();
$monthReports = array();

$monthSalesTotal = 0;
$monthAlertsTotal = 0;
$monthTransactionsTotal = 0;
$monthReportsTotal = 0;

$monthlyChartData = array();

if(mysqli_num_rows($monthSaleSqlResult) > 0)
{
	while($monthDataItem = mysqli_fetch_assoc($monthSaleSqlResult))
	{
		$monthlyChartData[] = $monthDataItem;

		$monthDates[] = $monthDataItem["date"];

		$monthSales[] = $monthDataItem["sales"];
		$monthAlerts[] = $monthDataItem["alerts"];
		$monthTransactions[] = $monthDataItem["transactions"];
		$monthReports[] = $monthDataItem["reports"];


		$monthSalesTotal+= $monthDataItem["sales"];
		$monthAlertsTotal+= $monthDataItem["alerts"];
		$monthTransactionsTotal+= $monthDataItem["transactions"];
		$monthReportsTotal+= $monthDataItem["reports"];
	}
}



//year stats grabber
$yearSaleSql = "select year(date) as year, MONTHNAME(date) as month, sum(transactions) as transactions, sum(alerts) as alerts, sum(sales) as sales from partners_aidailystats where mid='$leadgenid' and  year(date) = '".date("Y")."' group by year(date), MONTHNAME(date) order by date asc"; 


$yearSaleSqlResult 	=	mysqli_query($con,$yearSaleSql);

$yearMonths = array();
$yearAlerts = array();
$yearTransactions = array();

$yearAlertsTotal = 0;
$yearTransactionsTotal = 0;
$yearSalesTotal = 0;

$yearlyChartData = array();

if(mysqli_num_rows($yearSaleSqlResult) > 0)
{
	while($yearDataItem = mysqli_fetch_assoc($yearSaleSqlResult))
	{
		$yearDataItem["monthyear"] = $yearDataItem["month"]." ".$yearDataItem["year"];

		$yearlyChartData[] = $yearDataItem;

		$yearMonths[] = $yearDataItem["month"];

		$yearAlerts[] = $yearDataItem["alerts"];
		$yearTransactions[] = $yearDataItem["transactions"];
		
		$yearAlertsTotal+= $yearDataItem["alerts"];
		$yearTransactionsTotal+= $yearDataItem["transactions"];
		$yearSalesTotal+=$yearDataItem["sales"];
		
	}
}

// ASSIGN THE VALUES

/* Daily Records*/
$todaysChartData[] = array("key" => "Transactions", "value" => $todaysSale["transactions"] == null ? 0 : $todaysSale["transactions"]);
$todaysChartData[] = array("key" => "Alerts", "value" => $todaysSale["alerts"] == null ? 0 : $todaysSale["alerts"]);
$todaysChartData[] = array("key" => "Reports", "value" => $todaysSale["reports"] == null ? 0 : $todaysSale["reports"]);

$nimpress = $todaysSale["transactions"];
$nsubmission = $todaysSale["alerts"];
$nconfirlead = $todaysSale["reports"];

$totaltoday = $nimpress + $nsubmission + $nconfirlead;
$pimpress = $nimpress / $totaltoday * 100;
$psubmission = $nsubmission / $totaltoday * 100;
$pconfirlead = $nconfirlead / $totaltoday * 100;

// Monthly Records
$cmimpress = $monthsSale["value_trans"];
$cmsubmission = $monthsSale["value_alerts"];
$cmconfirlead = $monthsSale["value_reports"];

$mimpress = $cmimpress;
$msubmission = $cmsubmission;
$mconfirlead = $cmconfirlead;

/*Yearly Records*/
$cysubmission = $yearSale["val_year_trans"];
$cyconfirlead = $yearSale["val_year_alerts"];
$countconfirmleadsyearly_db = $yearSale["val_year_trans"];
$countsubmissionsyearly = $yearSale["val_year_alerts"];

$submissionyearly = $yearSale["val_year_trans"];
$leadsyearly =  $yearSale["val_year_alerts"];

?>
<div class="container-fluid">

	<?php
			if($lastOrderDay > 0)
			{
				$lastOrderCssClass = "";
				if($lastOrderDay > 0 && $lastOrderDay < 4)
				{
					$lastOrderCssClass = "alert-info";
				}
				else if ($lastOrderDay > 4 && $lastOrderDay < 7)
				{
					$lastOrderCssClass = "alert-warning";
				}
				else if( $lastOrderDay >= 7 )
				{
					$lastOrderCssClass = "alert-danger";
				}


		?>
		<div class="row" style="padding-bottom: 1rem;">
		<div class="col-lg-6 col-sm-12" style="padding-right: 0px;">
			<div >
			<div style="margin-bottom: 0px;" class="alert <?php echo $lastOrderCssClass; ?>">
                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <span>
                    Hey! just to let you know, your last order was <b><?php echo $lastOrderDay; ?> days ago</b>
                </span>
            </div>
        </div>
		</div>
		</div>
		<?php
			}
		?>

	<div class="row">
		
		<div class="col-lg-4 col-sm-6">
			<div class="card card-stats">
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
								<h4 class="card-title"><?=$currSymbol?><?=number_format($yearSalesTotal,2)?> (<?php echo  $yearTransactionsTotal ;?>)</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa "></i>This Year = <?php echo date('Y'); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-sm-6">
			<div class="card card-stats">
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
						
								<h4 class="card-title"><?=$currSymbol?><?=number_format($todaysSale["sales"],2)?> (<?=$todaysSale["transactions"]?>)</h4>
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
			<div class="card card-stats">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center icon-warning">
								<i class="nc-icon nc-time-alarm text-success"></i>
							</div>
						</div>
						<div class="col-7">
							<div class="numbers">
								<p class="card-category">Today's Alerts</p>
								
						
								<h4 class="card-title"><a href="index.php?Act=alerts"><?=$todaysSale["alerts"] == null ? 0 : $todaysSale["alerts"] ?></a></h4>
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

		
	</div>
	<div class="row"> 
		<div class="col-md-4">
			<div class="card ">
				<div class="card-header ">
					<h4 class="card-title">Daily</h4>
					<!--<p class="card-category">Transactions | Alerts | Reports</p>-->
				</div>
				<div class="card-body ">
					<div id="divDailyChart" class="ct-chart ct-perfect-fourth">
						
					</div>
				</div>
				<?php 

					if($nimpress > 0 || $nsubmission > 0 || $nconfirlead > 0)
					{
				?>
				<div class="card-footer ">
				<div class="legend">
					<i class="fa fa-circle text-info chatclicks"></i> Transactions (<?= $nimpress ?>)
					<i class="fa fa-circle text-danger chatleads"></i> Alerts (<?= $nsubmission ?>)
					<i class="fa fa-circle text-warning chatsale"></i> Reports (<?= $nconfirlead ?>)
				</div>
				<hr>
				<div class="stats">
					<i class="fa fa-clock-o"></i> <?php echo date('d/m/Y'); ?>
				</div>
				</div>
				<?php
					}
				?>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card ">
				<div class="card-header ">
					<h4 class="card-title">Last 30 days</h4>
					<!--<p class="card-category">Transactions | Alerts | Reports</p>-->
				</div>
				<div class="card-body ">
					<div id="divMonthlyChart" class="ct-chart" style="height: 300px;"></div>
				</div>
				<?php 

					if($monthTransactionsTotal > 0 || $monthAlertsTotal > 0 || $monthReportsTotal > 0)
					{
				?>
				<div class="card-footer ">
					<div class="legend">

						<i class="fa fa-circle text-info chatclicks" style="color:#2278BF;"></i> Transactions (<?= $monthTransactionsTotal ?>)
						<i class="fa fa-circle text-warning chatleads" style="color:#EAC435;"></i> Alerts (<?= $monthAlertsTotal ?>)
						<i class="fa fa-circle text-danger chatsale" style="color:#C1292E;"></i> Reports (<?= $monthReportsTotal ?>)
						
					</div>
					<hr>
					<div class="stats">
						<i class="fa fa-history"></i> <?php echo date('F'); ?>
					</div>
				</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="card ">
				<div class="card-header ">
					<h4 class="card-title">Yearly</h4>
					<p class="card-category">Transactions | Alerts</p>
				</div>
				<div class="card-body ">
					<div id="divYearlyChart" class="ct-chart" style="height: 300px;"></div>
				</div>
				<div class="card-footer ">
					<div class="legend">
						 
						<i class="fa fa-circle text-info chatclicks"></i> Transactions (<?= $yearTransactionsTotal ?>)
						<i class="fa fa-circle text-danger chatleads"></i> Alerts (<?=$yearAlertsTotal ?>)
					</div>
					<hr>
					<div class="stats">
						<i class="fa fa-check"></i> Year: <?php echo date('Y'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card  card-tasks">
				<div class="card-header ">
					
					<h4 class="card-title">Locations</h4>
					<p class="card-category">Last 10 order locations</p>
				</div>
				<div class="card-body ">
					<div class="table-full-width">
					
						<table class="table">
							<tbody>
							<?php foreach($saleLocations as $saleLocation )
							{ 
							
							?>
								<tr>
									<td>
										<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" value="">
												<span class="form-check-sign"></span>
											</label>
										</div>
									</td>
									<td>
										<?php echo $saleLocation["city"]. ", ".$saleLocation["region"].", ".$saleLocation["country"]; ?>
									</td>
									<td class="td-actions text-right">
										<?php echo $saleLocation["ordercount"]; ?>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-6">
			<div class="card  card-tasks">
				<div class="card-header ">
					<?php 
					$lastloginsql = select("user_log","user_id = '$leadgenid'order by date DESC limit 1"); 
					$lastlogrow = mysqli_fetch_array($lastloginsql)
					?>
					<h4 class="card-title">Login History</h4>
					<p class="card-category">Last Login ip: <?php echo $lastlogrow['ip']; ?></p>
				</div>
				<div class="card-body ">
					<div class="table-full-width">
					<?php $loginsql = select("user_log","user_id = '$leadgenid'order by date DESC limit 7"); ?>
						<table class="table">
							<tbody>
							<?php while($logrow = mysqli_fetch_array($loginsql)){ 
							
							$logrow['date'];
							
							?>
								<tr>
									<td>
										<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" value="">
												<span class="form-check-sign"></span>
											</label>
										</div>
									</td>
									<td><?php echo $logrow['ip']; ?> - <?php echo date('d/m/Y',strtotime($logrow['date'])); ?> @ <?php echo date('G:i',strtotime($logrow['date'])); ?></td>
									<td class="td-actions text-right">
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="now-ui-icons loader_refresh spin"></i> Last Succesful Login: <?php echo date('d/m/Y',strtotime($lastlogrow['date'])); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
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

	
	var dailyChartData = <?php echo json_encode($todaysChartData) ?>;
	var monthlyChartData = <?php echo json_encode($monthlyChartData) ?>;
	var yearlyChartData = <?php echo json_encode($yearlyChartData) ?>;

	var pclick = <?php echo round($pimpress); ?>;
	var plead = <?php echo round($psubmission); ?>;
	var psale = <?php echo round($pconfirlead); ?>;


	
	var yearMonths = <?php echo "['".implode("', '",$yearMonths)."']"; ?>;
	var yearTransactions = <?php echo "[".implode(", ",$yearTransactions)."]"; ?>;
	var yearAlerts = <?php echo "[".implode(",",$yearAlerts)."]"; ?>;
	
	var saledate = <?php echo "['".implode("', '",$monthDates)."']"; ?>;
	

	var monthTransactions = <?php echo "[".implode(",",$monthTransactions)."]"; ?>;
	var monthAlerts = <?php echo "[".implode(",",$monthAlerts)."]"; ?>;
	var monthReports = <?php echo "[".implode(",",$monthReports)."]"; ?>;


	//alert(<?php echo $leadsyearly;?>);
	//alert(pclick + ", " + plead + ", " + psale + ", " + yearclick + ", " + yearsale + ", "+ saledate + "," + yearMsale + ", " + yearMclicks + ", " + yearMleads);
</script> 

<style>
#chartHours svg.ct-chart-bar, svg.ct-chart-line{
	overflow: visible;
}
#chartHours .ct-label.ct-label.ct-horizontal.ct-end {
  position: relative;
  justify-content: flex-end;
  text-align: right;
  transform-origin: 100% 0;
  transform: translate(-100%) rotate(-45deg);
  white-space:nowrap;
}
	</style>