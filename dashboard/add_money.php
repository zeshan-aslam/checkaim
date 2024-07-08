<?php

$showcurrency = get_user_info($leadgenid,'av_Currency',true);
//echo  $showcurrency ;
if($showcurrency=="GBP"){$showmoney = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FVXHETH36E6TQ';}
if($showcurrency=="USD"){$showmoney = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9ZL3UTH29V2DA';}
if($showcurrency=="EURO"){$showmoney = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9T74MN8MNPLWJ';}
?>


<div class="col-md-12 text-center"><h4 style="color:red;">Balance: <?=$currSymbol?><?php echo leaduserinfo('balance'); ?></h4></div>	<div class="col-md-6 mr-auto ml-auto">
		
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
							<label>Account Name: </label>
							<b><?php echo get_option_meta('account_name'); ?></b>
						</div>
						<div class="form-group">
							<label>Account Number: </label>
							<b><?php echo get_option_meta('account_number'); ?></b>
						</div>
						<div class="form-group">
							<label>Sort Code: </label>
							<b><?php echo get_option_meta('sort_code'); ?></b>
						</div>
						<div class="form-group">
							<label>Swift Code: </label>
							<b><?php echo get_option_meta('swift_code'); ?></b>
						</div>
						<div class="form-group">
							<label>Or pay via paypal: </label>
							<b><?php echo get_option_meta('paypal_id'); ?></b>
						</div>
						<div class="form-group">
						  <label>Or pay by PayPal</label><br>

                          <a href="<?php echo $showmoney; ?>" target="_blank"><img src="../img/ppbutt.jpg" width="300" height="147" alt=""/></a>
<p><br>
<br>

						  <b>All fees &amp; Taxes will be deducted before balances are credited.</b></p>
						</div>						<div class="form-group">
							<label>Please use payment reference: </label>
							<b><?= 'LG'.$leadgenid ?></b>
						</div>

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
	
		$balance = leaduserinfo('balance');
		if($balance > 0){
			
		}
		else
		{    ////EMAIL FUNCTION/////
			//$sent_email = avaz_email($leadgenid,'15',$tokenid);
		}
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
							<th>Invoice</th>
						</thead>
						<tbody>
					<?php
					if(mysqli_num_rows($sql)>0){
						$i = 0;
					while($newRow = mysqli_fetch_object($sql)){
						
						$mid = base64_encode(serialize($newRow->id));
						$leadgeniddb = base64_encode(serialize($leadgenid));
						
						
					
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
						<td><a  href="<?php echo LEADURL.'avazinvoice.php?&id='.$mid; ?>&leadgenid=<?php echo $leadgeniddb; ?>" target="_blank" >Invoice</a></td>
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