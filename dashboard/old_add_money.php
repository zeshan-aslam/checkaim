	<div class="col-md-6 mr-auto ml-auto">
		<div class="card strpied-tabled-with-hover">
			<div class="card-body"> 
				<div class="row">
					<div class="col-md-12">
					<form action="<?php echo SITEURL.'controller/addmoney.php'; ?>" method="post">
						<?php
							if(isset($_SESSION['successmoney'])){
								echo '<p class="alert alert-success">'.$_SESSION['successmoney'].'</p>';
								unset($_SESSION['successmoney']);
							}
							if(isset($_SESSION['faluiremoney'])){
								echo '<p class="alert alert-danger">'.$_SESSION['faluiremoney'].'</p>';
								unset($_SESSION['faluiremoney']);
							}
						?>
						<p>To Add Funds to your account please send money via Bank Transfer to:</p>
						<div class="form-group">
							<label>Account Name:</label>
							<input class="form-control" type='text' name='account_name' size='' value='' />
						</div>
						<div class="form-group">
							<label>Account Number:</label>
							<input class="form-control" type='text' name='account_no' size='' value='' />
						</div>
						<div class="form-group">
							<label>Sort Code:</label>
							<input class="form-control" type='text' name='sort_code' size='' value='' />
						</div>
						<div class="form-group">
							<label>Swift Code:</label>
							<input class="form-control" type='text' name='swift_code' size='' value='' />
						</div>
						<div class="form-group">
							<label>Or pay via paypal below</label>
							<input class="checkbox" type='checkbox' name='pay_via_paypal' size='' value='' />
						</div>
						<div class="form-group">
							<label>Please use payment reference</label>
							<input class="form-control" type='text' name='payment_ref' size='' value='' />
						</div>
						<div class="form-group">
							<label>Amount: <?=$currSymbol?></label>
							<input class="form-control" type='text' name='amount' size='5' value='' />
						</div>
						<div class="form-group">
							<input class="btn btn-fill btn-info"  type="submit" value="Add Money" name="add_money" />
						</div>
					</form>
				</div> 
			</div> 
		</div> 
	</div> 
</div>

<?php
if(empty($page))   
		$page  = getpage();
	
global $prefix;
$tablename = $prefix."addmoney";
	$pgsql  	= "select * from $tablename where leadgen_id = '$leadgenid'";
	$leadgenid = leaduserinfo('id');	
	$sql = select("addmoney","leadgen_id = '$leadgenid' LIMIT ".($page-1)*$lines.",".$lines);

?>

<div class="row">
		<div class="col-md-12">
			<div class="card strpied-tabled-with-hover">
				<div class="card-header">
					<h4 class="card-title">Payment History</h4>
					
				</div>
				<div class="card-body table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<thead>
							<th>Date</th>
							<th>Amount</th>
							<th>Mode</th>
							<th>Status</th>
						</thead>
						<tbody>
					<?php
					if(mysqli_num_rows($sql)>0){
						$i = 0;
					while($newRow = mysqli_fetch_object($sql)){
					
					if($newRow->status=="waiting") 
						$img = "<font color='#006400' size='2'>Processing.......</font>";
					elseif($newRow->status=="suspend") 
						$img = "<font color='#98344E' size='2'>Payment Rejected</font>";
					else 
						$img = "<font color='#98344E' size='2'>Payment Success</font>";
					
					$class =($i%2==0)?'grid1':'grid2';
					?>
					<tr class="<?=$class?>">
						<td><?=date('d-F-Y', strtotime($newRow->date))?></td>
						<td><?=$currSymbol?> <?=$newRow->amount?></td>
						<td><?=$newRow->pay_mode?></td>
						<td><?=$img?></td>
					</tr>
					<? $i++;
					$class =($i%2==0)?'grid1':'grid2';
					}
					}else{
						?>
						<tr >
							<td colspan="4">Record Not Found</td>
						</tr>
						<?php
					}
					?>
					
					</tbody>
				</table> 
				<div class="custom_pagination">
				
				<? if(mysqli_num_rows($sql)>0){ 
				$url ="index.php?Act=add_money";  //adding page nos
				include '../includes/show_pagenos.php';
				}
				?>
				</div>
			</div>	
					
			</div>
		</div>
	</div>