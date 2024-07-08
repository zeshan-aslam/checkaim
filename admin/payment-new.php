 <?php include('includes/common/header.php'); ?>
 <?php
	if(isset($_GET['action']) && $_GET['action'] == 'edit'){
		$postname = 'Edit Payment';
		
	}else{
		$postname = 'Add Payment';
	}
	$postid = isset($_GET['id']) ? $_GET['id'] : -1;
	$sql = select("addmoney","id='$postid'");
	$fetchpost = fetch($sql);
?>
<?php include('includes/common/sidebar.php'); ?>
	<div class="am-pagetitle">
        <h5 class="am-title">Payments</h5>
       
      </div><!-- am-pagetitle -->
	
      <div class="am-pagebody">
		<div class="row row-sm mg-t-20">
			
			<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="controller/save_payment.php?postid=<?php echo $postid; ?>" method="post">
				<input type="hidden" name="redirect_url" value="payment-new">
          <div class="col-md-12">
		  <?php
			if(isset($_SESSION['successpost'])){
				echo '<p class="alert alert-success">'.$_SESSION['successpost'].'</p>';
				unset($_SESSION['successpost']);
			}else if(isset($_SESSION['faliurepost'])){
				echo '<p class="alert alert-danger">'.$_SESSION['faliurepost'].'</p>';
				unset($_SESSION['faliurepost']);
			}
		?>
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
              <h6 class="card-body-title"><?php echo $postname; ?></h6>
              <div class="row">
                <label class="col-sm-4 form-control-label">User: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<?php $sl = select('users', "type = '3' order by id desc"); ?>
                 <select name="username" required class="form-control">
					<option value="">----</option>
					<?php while($row = fetch($sl)){
                        $comname = get_user_info($row['id'],'av_company',true);
						?>
						<option value="<?=$row['id']?>" <?php echo ($fetchpost['leadgen_id'] == $row['id'] ? 'selected' : ''); ?>><?php echo 'LG'.$row['id']; ?> - <?php echo $comname; ?></option>
					<?php } ?>
				 </select>
                </div>
              </div><!-- row -->
          
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Date: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
             <input type="text" id="datepicker" name="date" required class="form-control" value="<?= isset($fetchpost['date']) ? date('m/d/Y', strtotime($fetchpost['date'])) : ''?>">
                </div>
              </div><!-- row -->
			  
			  <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Amount: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" name="amount" required class="form-control" value="<?= $fetchpost['amount']?>">
                </div>
              </div><!-- row -->
			  
			   	 <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">TAX/VAT Amount: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" name="vat_tax_number" required class="form-control" value="<?= $fetchpost['vat_tax_number']?>">
                </div>
              </div><!-- row -->

			  
             <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Payment Mode: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select name="pay_mode" required class="form-control">
					<option value="">----</option>
					<option value="Bank" <?php echo ($fetchpost['pay_mode'] == 'Bank' ? 'selected' : ''); ?>>Bank</option>
					<option value="Paypal" <?php echo ($fetchpost['pay_mode'] == 'Paypal' ? 'selected' : ''); ?>>Paypal</option>
				 </select>
                </div>
              </div><!-- row -->
			  
			 
			  
			   <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Currency: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select name="currency_mode" required class="form-control">
					<option value="">----</option>
					<option value="GBP" <?php echo ($fetchpost['currency_mode'] == 'GBP' ? 'selected' : ''); ?>>£ GBP</option>
					<option value="USD" <?php echo ($fetchpost['currency_mode'] == 'USD' ? 'selected' : ''); ?>>$ USD</option>
					<option value="EURO" <?php echo ($fetchpost['currency_mode'] == 'EURO' ? 'selected' : ''); ?>>€ EURO</option>
				 </select>
                </div>
              </div><!-- row -->
			  			  
			  <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Status: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <select name="status" required class="form-control">
					<option value="">----</option>
					<option value="waiting" <?php echo ($fetchpost['status'] == 'waiting' ? 'selected' : ''); ?>>Waiting</option>
					<option value="approved" <?php echo ($fetchpost['status'] == 'approved' ? 'selected' : ''); ?>>Approved</option>
				 </select>
                </div>
              </div><!-- row -->
			 
              <div class="form-layout-footer mg-t-30">
                <button type="submit" name="submit_pay" class="btn btn-info mg-r-5">Submit</button>
                <button class="btn btn-secondary">Cancel</button>
              </div><!-- form-layout-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->
         </form>
        </div><!-- row -->


    </div>
    
<?php include('includes/common/footer.php'); ?>
