<?php 
$page		=   (empty($page))? getpage(): trim($_GET['page']);
$postid = isset($_GET['sid']) ? $_GET['sid'] : -1;
$limitt   =	"LIMIT ".($page-1)*$lines.",".$lines;

$sql = select("joinavaz","companyid = '$postid' order by date DESC $limitt"); 
$tablename = $prefix."joinavaz";
$sqls = "select * from $tablename where companyid = '$postid'";
$pgsql	= 	$sqls;
?>
<div class="card strpied-tabled-with-hover">
	<div class="card-body"> 
		<div class="row">
			<div class="col-md-12">
				<p align="right">
					<a href="../csv_allsubmissions.php?joinid=<?=$postid?>"><b>Export as CSV</b></a>&nbsp;&nbsp;&nbsp;
				</p>
				<div class="table-full-width table-responsive">
					<table class="table table-hover table-striped coupon_table">
						 <thead>
							<tr>
							  <th class="wd-15p">First Name11</th>
							  <th>Last Name</th>
							  <th>Post Code</th>
							  <th>Email</th>
							  <th></th>
							  <th>Phone Number</th>
							  <th>Confirmed</th>
							 <!-- <th>Sold</th>
							  <th>Closed</th>-->
							  <th class="sorting">Date Recieved</th>
							</tr>
					</thead>
					 <tbody> 
				<?php while($row = fetch($sql)){ 
				?>
				<tr>
					<td><?php echo get_avaz_info($row['id'],'first_name',true); ?></td>
					<td><?php echo get_avaz_info($row['id'],'sur_name',true); ?></td>
					<td><?php echo get_avaz_info($row['id'],'av_post_code',true); ?></td>
					<td><?php echo get_avaz_info($row['id'],'av_email',true); ?></td>
					<td><a href="<?php echo LEADURL.'index.php?Act=submission_view&cid='.$row['id']; ?>">View</a></td>
					<td><?php echo get_avaz_info($row['id'],'av_phone',true); ?></td>
					<td> <?php if(get_avaz_info($row['id'],'is_confirmed',true) == 1 ){ ?> <input disabled type="checkbox" name="is_confirmed" value="1"  checked > <?php } else if(get_avaz_info($row['id'],'is_confirmed',true) == 2 ){ echo 'Cancelled'; }else{ ?><input type="checkbox" name="is_confirmed" value="1" disabled ><?php } ?></td>
					<!--<td> <input disabled type="checkbox" name="is_solid" value="1" <?php //if(get_avaz_info($row['id'],'is_sold',true) == 1 ){ echo 'checked'; }?>></td>
					<td> <input disabled type="checkbox" name="is_closed" value="1" <?php //if(get_avaz_info($row['id'],'is_closed',true) == 1 ){ echo 'checked'; }?>></td>-->
					<td><?php echo date('Y-m-d',strtotime($row['date'])); ?></td>
				</tr>
				<?php } ?>
              </tbody>
					</table>
				</div>
			</div>
			<div class="custom_pagination">
				<?
					$url    ="index.php?Act=submission_list&amp;sid=$postid";   
					include '../includes/show_pagenos.php';
				?>
			</div> 
		</div>
	</div>
</div>