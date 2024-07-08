<?php
$comaign = unserialize(get_user_info($leadgenid,'av_campaign',true));
//$Val = count($comaign)
 
  
?>

<li class="nav-item">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=home" >
		<i class="nc-icon nc-chart-pie-35"></i>
		<p>Dashboard</p>
	</a>
</li>
<li class="nav-item">
	<a class="nav-link"  href="<?php echo LEADURL; ?>index.php?Act=accounts">
		<i class="nc-icon nc-notes"></i>
		<p>Profile</p>
	</a>
</li>

<li class="nav-item">
	<a class="nav-link"  href="<?php echo LEADURL; ?>index.php?Act=alertsettings">
		<i class="nc-icon nc-badge"></i>
		<p>Alert Settings</p>
	</a>
</li>

<li class="nav-item">
	<a class="nav-link"  href="<?php echo LEADURL; ?>index.php?Act=transactions">
		<i class="nc-icon nc-badge"></i>
		<p>Transactions</p>
	</a>
</li>
<!--
<li class="nav-item ">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=reports">
		<i class="nc-icon nc-chart-bar-32"></i>
		<p>Reports</p>
	</a>
</li>
-->
<li class="nav-item ">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=trackingcode">
		<i class="nc-icon nc-key-25"></i>
		<p>Tracking Code</p>
	</a>
</li>
<!--
<li class="nav-item ">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=reportissue">
		<i class="nc-icon nc-cctv"></i>
		<p>Report Issue</p>
	</a>
</li>
<li class="nav-item ">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=saleuser">
		<i class="nc-icon nc-zoom-split"></i>
		<p>Search Sale/User</p>
	</a>
</li>
-->
<li class="nav-item ">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=alerts">
		<i class="nc-icon nc-time-alarm"></i>
		<p>Alerts</p>
	</a>
</li>
<li class="nav-item ">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=statistics">
		<i class="nc-icon nc-chart-pie-36"></i>
		<p>Statistics</p>
	</a>
</li>
