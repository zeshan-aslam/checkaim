<?php include('includes/common/header.php'); ?>

<?php include('includes/common/sidebar.php'); ?>
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

<title>MyBrandSecure – Brand Protection With Power!</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
<!-- CSS Files -->





<link href="publicadmin/assets/js/plugins/chartist.min.js" rel="stylesheet" />
<!--<link href="publicadmin/assets/css/bootstrap.min.css" rel="stylesheet" />-->
  <link href="publicadmin/assets/css/light-bootstrap-dashboard.css.css" rel="stylesheet" />
<link href="publicadmin/assets/lib/summernote/summernote.css" rel="stylesheet">



<?php
				/////////////GET Total balance//////////
			$tblname = $prefix."users";
			$sql = "select SUM(balance) from $tblname";
			$valsql 	=	mysqli_query($con,$sql);	

			while($row = fetch($valsql)){  


				$amount_getall =  $row['SUM(balance)'];	
				
			}
			
				/////////////GET Total Campaigns//////////
			$companyget = $prefix."company";
			$sqlCampaigns = "select * from $companyget";
			$valcomp 	=	mysqli_query($con,$sqlCampaigns);	
			$comaigncount = mysqli_num_rows($valcomp);

			while($rowcom = fetch($valcomp)){  


				$compaign_sts =  $rowcom['status'];	
				
			}
			
				/////////////GET Today's Spend//////////
			$todaycharges = $prefix."affilates_charges";
			$sqltoday = "select SUM(affilate_charges) from $todaycharges where DATE(date) = CURDATE()";
			$valtoday 	=	mysqli_query($con,$sqltoday);	
			
			while($todayrow = fetch($valtoday)){  


				$todayspend =  $todayrow['SUM(affilate_charges)'];	
				
			}
		

	//$tblname = $prefix."av_usersHide";
	//$gettotalamount = "select * from $tblname";
	//while($gettotalamount_row = fetch($gettotalamount)){
		
		//$amount_getall +=  $gettotalamount_row['balance'];
		
	//}
		
	
	$sqls = select("usermeta","user_key = 'av_campaign_status'");
			while($rowc = fetch($sqls)){
				 $campagin = unserialize($rowc['user_meta']);
				 
				 //echo $leadgenid = $rowc['user_id'];
			
			}

						$getcomaign = select("company order by id DESC"); 
						while($row = fetch($getcomaign)){ 
						$cmid = $row['id'];
						$companydatas = unserialize(base64_decode(get_config_meta('company_data', $cmid, true)));
						$companydata  = unserialize($companydatas['config']);
							
							
							$impressionval = $companydata['impression_amt'];
							$subval = $companydata['submission_amt'];
							$qlval = $companydata['qualified_lead_amt'];
							
							/*Today Charges */
							
							
							$simpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'impression' and campagin_id = '$cmid'");
							
							$ssimpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'submissions' and campagin_id = '$cmid'");
							$climpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'confirm_leads' and campagin_id = '$cmid'");
							
							 $countimpre1 = mysqli_num_rows($simpression);
							$countsub1 = mysqli_num_rows($ssimpression);
							$countsale1 = mysqli_num_rows($climpression);
							
							
							$totaltodaychargedb += ($impressionval * $countimpre1) + ($subval * $countsub1) + ($qlval * $countsale1);
							
							
							
						}


$leadgenid = '13'; // , 14 , 15, 16';
//$arraylegendid = array("13", "14", "15", "16");
//$comaign = unserialize(get_user_info($leadgenid,'av_campaign',true));


/* Daily Records*/
$nimpress = countarrayaffilatesdaily('impression');
$nsubmission = countarrayaffilatesdaily('submissions');
$nconfirlead = countarrayaffilatesdaily('confirm_leads');

/*Monthly Count*/

$cmimpress = countarrayaffilatesmonthly('impression');
$cmsubmission = countarrayaffilatesmonthly('submissions');
$cmconfirlead = countarrayaffilatesmonthly('confirm_leads');
/*-----------------*/

/*Yearly Count*/

$cysubmission = countaffilatesarrayyearly('submissions');
$cyconfirlead = countaffilatesarrayyearly('confirm_leads');
$countconfirmleadsyearly_db = countconfirmleadsyearly($leadgenid, 'confirm_leads');
$countsubmissionsyearly = countconfirmleadsyearly($leadgenid, 'submissions');
/*-----------------*/

$totaltoday = $nimpress + $nsubmission + $nconfirlead;
$pimpress = $nimpress / $totaltoday * 100;
$psubmission = $nsubmission / $totaltoday * 100;
$pconfirlead = $nconfirlead / $totaltoday * 100;

/*Yearly*/
$submissionyearly = yearlyarrayaffilates('submissions');
$leadsyearly =  yearlyarrayaffilates('confirm_leads');



/* Monthly */

$mimpress = monthlyarrayaffilates('impression');
$msubmission = monthlyarrayaffilates('submissions');
$mconfirlead = monthlyarrayaffilates('confirm_leads');


/*Today Spend*/
$totaltodaycharge = 0;
foreach($comaign as $l){
	$companydatas = unserialize(base64_decode(get_config_meta('company_data', $l, true)));
	$companydata  = unserialize($companydatas['config']);

	$impressionval = $companydata['impression_amt'];
	$subval = $companydata['submission_amt'];
	$qlval = $companydata['qualified_lead_amt'];
	$simpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'impression' and campagin_id = '$l'");
					
	$ssimpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'submissions' and campagin_id = '$l'");
	$climpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'confirm_leads' and campagin_id = '$l'");

	$countimpre1 = mysqli_num_rows($simpression);
	$countsub1 = mysqli_num_rows($ssimpression);
	$countsale1 = mysqli_num_rows($climpression);


	$totaltodaycharge += ($impressionval * $countimpre1) + ($subval * $countsub1) + ($qlval * $countsale1);



}


?>
      <div class="am-pagebody">
		<div class="card pd-20 ">
		<div class="table-wrapper">
		
	<div class="row">
		<div class="col-lg-4 col-sm-6">
			<div class="card card-stats card-border1">
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
								<h4 class="card-title"><?php echo $amount_getall ?> (1,213)</h4>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
		
		<div class="col-lg-4 col-sm-6">
			<div class="card card-stats card-border1">
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
								
						
								<h4 class="card-title"><?=number_format($todayspend,2)?></h4>
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
			<div class="card card-stats card-border1">
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
								<h4 class="card-title">X</h4>
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
		<div class="col-md-4">
			<div class="card card-border1 ">
				<div class="card-header ">
					<h4 class="card-title">Daily</h4>
					<p class="card-category">Transactions | Alerts | Reports</p>
				</div>
				<div class="card-body ">
					<div id=chartEmail class="ct-chart ct-perfect-fourth"></div>
				</div>
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
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-border1">
				<div class="card-header ">
					<h4 class="card-title">Monthly</h4>
					<p class="card-category">Transactions | Alerts | Reports</p>
				</div>
				<div class="card-body ">
					<div id=chartHours class="ct-chart"></div>
				</div>
				<div class="card-footer ">
					<div class="legend">
						<i class="fa fa-circle text-info chatclicks"></i> Transactions (<?= $cmimpress ?>)
						<i class="fa fa-circle text-warning chatleads"></i> Alerts (<?= $cmsubmission ?>)
						<i class="fa fa-circle text-danger chatsale"></i> Reports (<?= $cmconfirlead ?>)
						
					</div>
					<hr>
					<div class="stats">
						<i class="fa fa-history"></i> <?php echo date('F'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card card-border1 ">
				<div class="card-header ">
					<h4 class="card-title">Yearly</h4>
					<p class="card-category">Transactions | Alerts</p>
				</div>
				<div class="card-body ">
					<div id="chartActivity" class="ct-chart"></div>
				</div>
				<div class="card-footer ">
					<div class="legend">
						<i class="fa fa-circle text-info chatleads"></i> Transactions (<?= $cysubmission ?>)
						<i class="fa fa-circle text-danger chatsale"></i> Alerts (<?= $cyconfirlead ?>)
					</div>
					<hr>
					<div class="stats">
						<i class="fa fa-check"></i> Data Last Updated: <?php echo date('Y'); ?>
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
<?php include('includes/common/footer.php'); ?>