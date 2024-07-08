<?php
/*$from  = isset($_POST['from']) ? $_POST['from'] : '';
$From = date('Y-m-d', strtotime($from));
$to  = isset($_POST['to']) ? $_POST['to'] : '';
$To = date('Y-m-d', strtotime($to));
$campagin  = isset($_POST['campagin']) ? $_POST['campagin'] : '';
$impr_type  = isset($_POST['impr_type']) ? $_POST['impr_type'] : '';
$submission  = isset($_POST['impr_type']) ? $_POST['submission'] : '';
$quali_lead  = isset($_POST['quali_lead']) ? $_POST['quali_lead'] : '';
$tblname = $prefix."affilates_charges";
$sql = "select * from $tblname where user_id = '$leadgenid'";
$sql .= ($campagin != "All" and !empty($campagin))?" AND campagin_id = '$campagin'":"";
$sql.= " AND Date(date) BETWEEN '$From' AND '$To' ";
if($impr_type==1 or $submission==1 or $quali_lead==1){
     $tsql  .= ($impr_type==1)  ? "  OR  lead_type = 'impression' " : "";
     $tsql  .= ($submission==1)  ? "  OR  lead_type = 'submissions' " : "";
     $tsql  .= ($quali_lead==1) ? "  OR  lead_type = 'confirm_leads' " : "";

     $tsql = trim($tsql);
     $tsql = trim($tsql,"OR");
     $tsql = " AND (".$tsql.")";
     $sql .= $tsql;
    }
	
	$pgsql	= 	$sql;
   $sql    .=	" LIMIT ".($page-1)*$lines.",".$lines;
   $ret 	=	mysqli_query($con,$sql);
?>
<form name="trans" method="post" action="#">
	<div class="card stacked-form">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-6">
					<p>Statistics For Custom Period</p>
					<span class="textred"></span>
					<h4 class="card-title">For Period</h4>
					<div class="form-group">
						<label>FROM</label>
						<input type="text" id="datetimepickerfrom" class="form-control" name="from" size="18" value="" />
					</div>
					<div class="form-group">
						<label>To</label>
						<input type="text" id="datetimepickerto" class="form-control" name="to" size="18" value="" />
					</div>
					
					<h4 class="card-title">Search Campaigns</h4>
					
					<div class="form-group">
						<label></label>
						<select name="campagin" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue" >
							<option value="All" >All Program</option>
							 <?php 
								$comaign = unserialize(get_user_info($leadgenid,'av_campaign',true)); 
								foreach($comaign as $value){
									$sql = select("company", "id = '$value'");
									$com = fetch($sql);
									?>
									<option value="<?php echo $com['id']; ?>" ><?php echo $com['company_name']; ?></option>
									<?php
								}
							 ?>
						</select>
					</div>
					<div class="form-group">						
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="impr_type" value="1" <?=($impr_type)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								Impression
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="submission" value="1" <?=$submission?> <?=($submission)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								Submission
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input"  type="checkbox" name="quali_lead" value="1" <?=($quali_lead)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								QUALIFIED LEAD
							</label>
						</div>					
					</div>
					
					<div class="form-group">
						<input class="btn btn-fill btn-info" type="submit" name="sub" value="View"  />
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
 <?

  # checking for each records
  if(mysqli_num_rows($ret)>0){
  ?>
 
	<div class="card strpied-tabled-with-hover">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th>TYPE</th>
									<th>Charges</th>
									<th>Date</th>
								</tr>
							</thead>
							   <tbody>
							<?
							  while($rows=mysqli_fetch_object($ret))
							  {
								
							   ?>
								<tr class="">
										<td><?=$rows->lead_type?><td>
										<td><?=$currSymbol?> <?=number_format($rows->affilate_charges, 2)?><td>
										<td><?=date('d, m Y',strtotime($rows->date))?></td>
									</tr>
								</tbody>
						</table>
					</div>
				</div>	
				
			<div class="custom_pagination">
				<?
				//$url    ="index.php?Act=reports&amp;merid=$leadgenid";    //adding page nos
				//include '../includes/show_pagenos.php';
				?>
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
							<tr>
								<td>Record Not Found</td>
							</tr>
						</tbody>
					</table>
				</div>	
			</div>	 
		</div>
	</div>	
   	<?
    }*/
    ?>