<?php

$page		=   (empty($page))? getpage(): trim($_GET['page']);
$from  = isset($_GET['from']) ? $_GET['from'] : '';
$to  = isset($_GET['to']) ? $_GET['to'] : '';

$campagin  = isset($_GET['campagin']) ? $_GET['campagin'] : '';
$impr_type  = isset($_GET['impr_type']) ? $_GET['impr_type'] : '';
$submission  = isset($_GET['submission']) ? $_GET['submission'] : '';
$quali_lead  = isset($_GET['quali_lead']) ? $_GET['quali_lead'] : '';
$daily_charges  = isset($_GET['daily_charges']) ? $_GET['daily_charges'] : '';
$tblname = $prefix."affilates_charges";
$sql = "select * from $tblname where user_id = '$leadgenid'";
$sql .= ($campagin != "All" and !empty($campagin))?" AND campagin_id = '$campagin'":"";

if(is_date($from) && is_date($to)){
	$To   = date2mysql($to);
	$From = date2mysql($from);
	$sql.= " AND Date(date) BETWEEN '$From' AND '$To' ";
}
if($impr_type==1 or $submission==1 or $quali_lead==1 or $daily_charges==1){
	$tsql  .= ($impr_type==1)  ? "  OR  lead_type = 'impression' " : "";
	$tsql  .= ($submission==1)  ? "  OR  lead_type = 'submissions' " : "";
	$tsql  .= ($quali_lead==1) ? "  OR  lead_type = 'confirm_leads' " : "";
	$tsql  .= ($daily_charges==1) ? "  OR  lead_type = 'daily_charges' " : "";
	$tsql = trim($tsql);
	$tsql = trim($tsql,"OR");
	$tsql = " AND (".$tsql.")";
	$sql .= $tsql;
}
	
$pgsql	= 	$sql;
 $sql    .=	" order by date desc LIMIT ".($page-1)*$lines.",".$lines;
$ret 	=	mysqli_query($con,$sql);
?>
<form name="trans" method="get" action="">
<input type="hidden" name="Act" value="reports">
	<div class="card stacked-form">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-6">
					<p>Statistics For Custom Period</p>
					<span class="textred"></span>
					<h4 class="card-title">For Period</h4>
					<div class="form-group">
						<label>FROM</label>
						<input type="text" id="datetimepickerfrom" class="form-control" name="from" size="18" value="<?=$from?>" />
					</div>
					<div class="form-group">
						<label>To</label>
						<input type="text" id="datetimepickerto" class="form-control" name="to" size="18" value="<?=$to?>" />
					</div>
					
					
					<div class="form-group">
						<input class="btn btn-fill btn-info" type="submit" name="sub" value="View"  />
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<? if(mysqli_num_rows($ret)>0){ ?>
<div class="card strpied-tabled-with-hover">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12"> 
				<p align="right">
					<a href="#" onClick="window.open('../print_submissions.php?leadgenid=<?=$leadgenid?>&campagin=<?=$campagin?>&from=<?=$From?>&to=<?=$To?>&impr_type=<?=$impr_type?>&submission=<?=$submission?>&quali_lead=<?=$quali_lead?>&daily_charges=<?=$daily_charges?>&currsymbol=<?=get_user_info($leadgenid,'av_Currency',true)?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>
					&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_submissions.php?leadgenid=<?=$leadgenid?>&campagin=<?=$campagin?>&from=<?=$From?>&to=<?=$To?>&impr_type=<?=$impr_type?>&submission=<?=$submission?>&quali_lead=<?=$quali_lead?>&daily_charges=<?=$daily_charges?>&currsymbol=<?=get_user_info($leadgenid,'av_Currency',true)?>"><b>Export as CSV</b></a>&nbsp;&nbsp;&nbsp;
				</p>
				<div class="table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th>TYPE</th>
								<th>Campagin Name</th>
								<th>Charges</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<? while($rows=mysqli_fetch_object($ret)){ ?>
								<tr class="">
								<?php $charges = $rows->lead_type; 
									$charges = str_replace('daily_charges','Daily Charges',$charges);
									$charges = str_replace('confirm_leads','QUALIFIED LEAD',$charges);
									 $campid = $rows->campagin_id;
									$sqlss = select("company", "id = '$campid'");
									$comss = fetch($sqlss); 
								?>
								    <td><?=$charges?></td>
									<td><?=$comss['company_name']?></td>
									<td><?=$currSymbol?> <?=number_format($rows->affilate_charges, 2)?></td>
									<td><?=date('d, m Y',strtotime($rows->date))?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>	
			<div class="custom_pagination">
				<?
					$url    ="index.php?Act=reports&amp;merid=$leadgenid&amp;from=$from&amp;to=$to&amp;campagin=$campagin&amp;impr_type=$impr_type&amp;submission=$submission&amp;quali_lead=$quali_lead&amp;daily_charges=$daily_charges";   
					include '../includes/show_pagenos.php';
				?>
			</div> 
		</div>	
	</div>	
</div>	
		<?
		} // outer if closing
		else{
		?>
			<div class="card strpied-tabled-with-hover">
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="card-body table-full-width table-responsive">
							<table class="table table-hover table-striped">
								<tbody> 
									<tr><td>Record Not Found</td></tr>
								</tbody>
							</table>
						</div>	
					</div>	 
				</div>
			</div>	
		<? } ?>
		