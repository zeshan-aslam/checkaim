 <?php
include('../../config.php');
if(isset($_POST['submit_pay']))
{
		$postid = isset($_GET['postid']) ? $_GET['postid'] : -1;
		$redirect_url = $_POST['redirect_url'];
		$leadgen_ids = $_POST['username'];
		$approvests = $_POST['status'];
		
		
		$sqldb = select("users","id =$leadgen_ids");
								
			while($rowdb = fetch($sqldb)){
				
				$customeremail = $rowdb['email'];
				
			
			}
		
	
		if($postid == -1){
		$data = array(
			'leadgen_id' => mysqli_real_escape_string($con,$_POST['username']),
			'date' => mysqli_real_escape_string($con,date('Y-m-d',strtotime($_POST['date']))),
			'amount' => mysqli_real_escape_string($con,$_POST['amount']),
			'pay_mode' => mysqli_real_escape_string($con,$_POST['pay_mode']),
			'status' => mysqli_real_escape_string($con,$_POST['status']),
			'currency_mode' => mysqli_real_escape_string($con,$_POST['currency_mode']),
			'vat_tax_number' => mysqli_real_escape_string($con,$_POST['vat_tax_number']),
			
		);
	}else{
		$data = array(
			'leadgen_id' => mysqli_real_escape_string($con,$_POST['username']),
			'date' => mysqli_real_escape_string($con,date('Y-m-d',strtotime($_POST['date']))),
			'amount' => mysqli_real_escape_string($con,$_POST['amount']),
			'pay_mode' => mysqli_real_escape_string($con,$_POST['pay_mode']),
			'status' => mysqli_real_escape_string($con,$_POST['status']),
			'currency_mode' => mysqli_real_escape_string($con,$_POST['currency_mode']),
			'vat_tax_number' => mysqli_real_escape_string($con,$_POST['vat_tax_number']),
			
		);
	}
	    
		
		
		
	$vat_tax_amount_val = $_POST['vat_tax_number'];	
	$amountval = $_POST['amount'];
	$amountval = $amountval - $vat_tax_amount_val;	
		
		
	$result = insert_post($con,'addmoney',$data,'',$postid); 
	if($result){
		$leadgen_id = $_POST['username'];
		$amount = $_POST['amount'];
		$sqls = select('users',"id='$leadgen_id'");
		$rowsd = fetch($sqls);
		
		$balance = $rowsd['balance'] +  $amountval;
		
		
		
		
		
		
		
		mysqli_query($con, "update av_users set balance = '$balance' where id='$leadgen_id'");
		
		
		
		$_SESSION['successpost'] = "Page saved successfully";
		if($postid == -1){

		if($approvests == 'approved')
		{
			
			
			////// ////EMAIL FUNCTION/////
		    $sent_email = avaz_email($leadgen_id,'16',$tokenid);
					
			 
			$_SESSION['failurer'] = "Reset password sent link on your email";
			redirect(SITEURL.'forget.php'.$slug);
			redirect(ADMINURL.$redirect_url.'.php');
			
		}
		else
		{
			$_SESSION['failurer'] = "Reset password sent link on your email";
			redirect(SITEURL.'forget.php'.$slug);
			redirect(ADMINURL.$redirect_url.'.php');
		}	
			
		
		}else{
			redirect(ADMINURL.$redirect_url.'.php?action=edit&id='.$postid);
		}
	}else{
		$_SESSION['faliurepost'] = "Please try again";
		if($postid == -1){
			redirect(ADMINURL.$redirect_url.'.php');
		}else{
			redirect(ADMINURL.$redirect_url.'.php?action=edit&id='.$postid);
		}
		
	}
}
?>