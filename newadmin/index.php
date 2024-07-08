<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); ?>
	<div class="am-pagetitle">
        <h5 class="am-title">Campaign Listing</h5>
        
      </div><!-- am-pagetitle -->

      <div class="am-pagebody">
		<div class="card pd-20 bg_clr">
			 <div class="table-wrapper">
				<?php $sql = select("company order by id DESC"); 
				
				$sqls = select("usermeta","user_key = 'av_campaign'");
			while($rowc = fetch($sqls)){
				 $campagin = unserialize($rowc['user_meta']);
				foreach($campagin as $l){
					$user_meta['campagin'][] = array(
					'cam' => $l,
					'user_id' => $rowc['user_id'],
				);
				}
			}
						
				?>
				
					<table id="datatable1" class="table display responsive">
					  <thead>
						<tr>
						  <th class="">Campaign</th>
						  <th class="">Campaign Type</th>
						  <th class="">Status</th>
						  <th class="">Company Name</th>
						  <th class="">Todays Charges</th>
						  <th class="">Monthly Charges</th>
						  <th class="">Current Monthly</th>
						  <th class="">IMP</th>
						  <th class="">Sub</th>
						  <th class="">QL</th>
						  <th class=""></th>
						  <th class="">CSV Download</th>
						  <th>Submission List</th>
						  <th>Action</th>
						</tr>
					  </thead>
					  <tbody> 
						<?php while($row = fetch($sql)){ 
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
							
							
							$totaltodaycharge = ($impressionval * $countimpre1) + ($subval * $countsub1) + ($qlval * $countsale1);
							/*Today Charges End*/
							
							/*Monthly Charges */
							$simpressionm = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'impression' and campagin_id = '$cmid'");
							
							$ssimpressionm = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'submissions' and campagin_id = '$cmid'");
							$climpressionm = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'confirm_leads' and campagin_id = '$cmid'");
							
							$countimpre2 = mysqli_num_rows($simpressionm);
							$countsub2 = mysqli_num_rows($ssimpressionm);
							$countsale2 = mysqli_num_rows($climpressionm);
							
							
							$totalmonthcharge = ($impressionval * $countimpre2) + ($subval * $countsub2) + ($qlval * $countsale2);
							/*Monthly Charges End*/
							
							
							
							$sqlimpression = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'impression' and campagin_id = '$cmid'");
							
							$sqlsubmissions = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'submissions' and campagin_id = '$cmid'");
							$sqlsales = mysqli_query($con,"select * from av_affilates_charges where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = 'confirm_leads' and campagin_id = '$cmid'");
							$countimpre = mysqli_num_rows($sqlimpression);
							$countsub = mysqli_num_rows($sqlsubmissions);
							$countsale = mysqli_num_rows($sqlsales);
							$userid = '';
							foreach($user_meta as $l1){
								foreach($l1 as $l2){
									if($l2['cam'] == $row['id']){
										$userid = $l2['user_id'];
									}
								}
							}
						?>
						<tr>
							<td><?php echo $row['company_name']; ?></td>
							<td><?php echo $row['compaign_type']; ?></td>
							<td>
							<?php 
							if($row['status'] == 1){ echo 'Active';  }else if($row['status'] == 2){ echo 'suspended'; }else{ echo 'Waiting Approval';	} ?> 
							</td>
							<td><?php echo get_user_info($userid,'av_company',true); ?></td>
							<td><?=$currSymbol?><?=number_format($totaltodaycharge,2)?></td>
							<td><?=$currSymbol?><?=number_format($totalmonthcharge,2)?></td>
							<td></td>
							<td><?php echo $countimpre;  ?></td>
							<td><?php echo $countsub;  ?></td>
							<td><?php echo $countsale;  ?></td>
							<td>View Report</td>
							<td><a href="controller/save_config.php?action=download&did=<?php echo $row['id']; ?>"><i class="fa fa-download"></i> Download</a></td>
							<td><a href="view-list.php?cid=<?php echo $row['id']; ?>">View</a></td>
							<td><a href="<?php echo $row['compaign_type']; ?>.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a> | <a  href="javascript:;" onClick="deletetablerow(<?php echo $row['id']; ?>,'Are you sure you like to delete  <?php echo $row['company_name']; ?>')">Delete</a> | 
							<?php if($row['status'] == 1){ ?>
								<a  target="_blank" href="<?php echo SITEURL.$row['company_slug']; ?>" >View</a>
							<?php }else if($row['status'] == 2){ ?>
								<a onclick="showcustomNotification('top','center')" href="javascript:;">View</a>
							<?php }else{ ?>
								<a onclick="showcustomNotification('top','center')" href="javascript:;">View</a>
							<?php } ?>
							</td>
						</tr>
						<?php } ?>
					  </tbody>
				</table>
			 </div>
			 
		</div>
	</div><!-- am-pagebody -->
      
<?php include('includes/common/footer.php'); ?>
<script>
type = ['primary', 'info', 'success', 'warning', 'danger'];
function showcustomNotification(from, align){
	$.notify({
            icon: "nc-icon nc-app",
            message: "This campaign is waiting approval."

        }, {
            type: type[3],
            timer: 8000,
            placement: {
                from: from,
                align: align
            }
        });
}
</script>