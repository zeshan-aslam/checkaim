<div class="card strpied-tabled-with-hover">
			<div class="card-body"> 
				<div class="row">
					<div class="col-md-12">
	
						<div class="table-full-width table-responsive">
							<table class="table table-hover table-striped coupon_table">
								<thead> 
									<tr>
										<th>Compaign Name</th>
										<th>Charges: </th>
										<th>Impression</th>
										<th>Submission</th>
										<th>Qualified Lead</th>
										<th>Today Spend</th>
										<th>Monthly Spend</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								if(get_user_info($leadgenid,'av_campaign_status',true) == 'approve'){
								$comaign = unserialize(get_user_info($leadgenid,'av_campaign',true));
								foreach($comaign as $value){
									
									$sql = select("company", "id = '$value'");
									$com = fetch($sql);
									$cmid = $com['id'];
									$companydatas = unserialize(base64_decode(get_config_meta('company_data', $cmid, true)));
									$companydata  = unserialize($companydatas['config']);
									
									$impressionval = $companydata['impression_amt'];
									$subval = $companydata['submission_amt'];
									$qlval = $companydata['qualified_lead_amt'];
									
									/*Today Charges */
										$simpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'impression' and campagin_id = '$cmid' and user_id='$leadgenid'");
										
										$ssimpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'submissions' and campagin_id = '$cmid' and user_id='$leadgenid'");
										$climpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'confirm_leads' and campagin_id = '$cmid' and user_id='$leadgenid'");
										
										 $countimpre1 = mysqli_num_rows($simpression);
										$countsub1 = mysqli_num_rows($ssimpression);
										$countsale1 = mysqli_num_rows($climpression);
										
										
										$totaltodaycharge = ($impressionval * $countimpre1) + ($subval * $countsub1) + ($qlval * $countsale1);
										/*Today Charges End*/
										
										/*Monthly Charges */
											$simpressionm = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'impression' and campagin_id = '$cmid'  and user_id='$leadgenid'");
											
											$ssimpressionm = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'submissions' and campagin_id = '$cmid'  and user_id='$leadgenid'");
											$climpressionm = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'confirm_leads' and campagin_id = '$cmid'  and user_id='$leadgenid'");
											
											$countimpre2 = mysqli_num_rows($simpressionm);
											$countsub2 = mysqli_num_rows($ssimpressionm);
											$countsale2 = mysqli_num_rows($climpressionm);
					
					
										$totalmonthcharge = ($impressionval * $countimpre2) + ($subval * $countsub2) + ($qlval * $countsale2);
					/*Monthly Charges End*/
								?>
								<tr>
									<td><?php echo $com['company_name']; ?></td>
									<td></td>
									<td><?=$currSymbol?><?=number_format($impressionval,2)?></td>
									<td><?=$currSymbol?><?=number_format($subval,2)?></td>
									<td><?=$currSymbol?><?=number_format($qlval,2)?></td>
									<td><?=$currSymbol?><?=number_format($totaltodaycharge,2)?></td>
									<td><?=$currSymbol?><?=number_format($totalmonthcharge,2)?></td>
									<td><a href="<?php echo LEADURL.'index.php?Act=submission_list&sid='.$com['id']; ?>">View</a></td>
									
								</tr>
								<?php } }else{ 
									?>
									<tr>
										<td colspan="2">No Record Found</td>
									</tr>
									<?php
								} ?>
								</tbody>
							</table>
						</div>
					</div> 
				</div> 
			</div> 
		</div>