<nav class="navbar navbar-expand-lg ">
	<div class="container-fluid">
		<div class="navbar-wrapper" style="width:100%">
			<div class="navbar-minimize">
				<button id="minimizeSidebar" class="btn btn-warning btn-fill btn-round btn-icon d-none d-lg-block">
					<i class="fa fa-ellipsis-v visible-on-sidebar-regular"></i>
					<i class="fa fa-navicon visible-on-sidebar-mini"></i>
				</button>
			</div>
			<a class="navbar-brand" href="#"> CheckAIM Anti-Fraud </a>
			<?php 
			$monthly_license_fee = get_user_info(leaduserinfo('id'),'monthly_license_fee',true);
			
			if($monthly_license_fee == '')
			{
				
				$monthly_license_fees = "0.00";
			}
			else{
				
				$monthly_license_fees = get_user_info(leaduserinfo('id'),'monthly_license_fee',true);
			}
			
			
	 $no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('y'));
	 $charges = $monthly_license_fees / $no_of_days_in_month; ?>
			<p class="navbar-brand fs_1" style="margin-left: 100px;">Monthly License Fee: <?=$currSymbol?><?=number_format($monthly_license_fees,2)?> - Daily Charge: <?=$currSymbol?><?=number_format($charges,2)?> <span class="no-display" style="font-size:12px;color:#ff0000;">( Month: <?php echo date('F'); ?> - <?php echo $no_of_days_in_month;?> Days )</span></p>
		</div>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-bar burger-lines"></span>
			<span class="navbar-toggler-bar burger-lines"></span>
			<span class="navbar-toggler-bar burger-lines"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end">
			<ul class="nav navbar-nav mr-auto">
			</ul>
			<ul class="navbar-nav">
			
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="nc-icon nc-bullet-list-67"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="index.php?Act=accounts">
							<i class="nc-icon nc-settings-90"></i> Settings
						</a>
							<a target="_blank" class="dropdown-item" href="https://youtu.be/3Al1N8FJjo8">
							<i class="nc-icon nc-paper-2"></i> Video Manual
						</a>
						<div class="divider"></div>
						<a href="<?php echo LEADURL.'logout.php'; ?>" class="dropdown-item text-danger">
							<i class="nc-icon nc-button-power"></i> Log out
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
<?php $balance = leaduserinfo('balance'); ?>
<?php if($balance < 00.00 && $balance > 1.00){ ?>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-warning">
		<button type="button" aria-hidden="true" class="close" data-dismiss="alert">
			<i class="nc-icon nc-simple-remove"></i>
		</button>
		<span>
			<b> Warning - </b> Account Funds Are Low Please Top Up.</span>
		</div>
	</div>
</div>
<?php }else if($balance < 0.00){
	if(get_user_info(leaduserinfo('id'),'av_campaign_status',true) == 'approve'){
		update_user_meta(leaduserinfo('id'),'av_campaign_status','suspend');
	}
?>
<div class="row">
	<div class="col-md-12">
	</div>
</div>
<?php }else if($balance >= 0.00){
	if(get_user_info(leaduserinfo('id'),'av_campaign_status',true) == 'suspend'){
		update_user_meta(leaduserinfo('id'),'av_campaign_status','approve');
	}
} ?>