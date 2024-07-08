<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); 
$postid = isset($_GET['cid']) ? $_GET['cid'] : -1;
?>

	<div class="am-pagetitle">
        <h5 class="am-title">Payments</h5>
		<a href="payment-new.php" class="btn btn-info mg-r-5">Add Payment</a>
         
      </div><!-- am-pagetitle -->
	  
      <div class="am-pagebody">

		<div class="card pd-20 pd-sm-40 bg_clr1">
		
          <div class="table-wrapper">
		  	<?php $sql = select("addmoney order by id DESC"); 

			?>
            <table id="datatable2" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="">Date</th>
				  <th>Invoice</th>
                  <th>LeadGen</th>
				  <th>Amount</th>
				  <th>Pay Method</th>
                 <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody> 
				<?php while($row = fetch($sql)){ 
				
				$currency_modedb =  $row['currency_mode'];
				$leadgen_id =  $row['leadgen_id'];
				
				$amountdb =  $row['amount']; 
				$vat_tax_number =  $row['vat_tax_number']; 
				
				$amountdbval = ($amountdb) - ($vat_tax_number);
				
				
				$leadgen_iddb = base64_encode(serialize($leadgen_id));
				$id =  $row['id'];
				$iddb = base64_encode(serialize($id));
				
				if($currency_modedb == "USD")
				{				
				 $currsymboldb = "$"; 
					
				}
				else if ($currency_modedb == "GBP")
				{
				 $currsymboldb = "£"; 					
				}
				else
				{
			    $currsymboldb = "€";
				}			
				?>
				<tr>
					<td><?php echo date('d-F-Y', strtotime($row['date'])); ?></td>
					<td><a  href="<?php echo LEADURL.'avazinvoice.php?&id='.$iddb; ?>&leadgenid=<?php echo $leadgen_iddb; ?>" target="_blank" >PDF</a></td>
					<td><?php echo get_user_info($row['leadgen_id'],'first_name',true).' '.get_user_info($row['leadgen_id'],'last_name',true); ?></td>
					<td><?=$currsymboldb?><?php echo $amountdbval; ?> </td>
					<td><?php echo $row['pay_mode']; ?></td>
					<td><?php echo ucfirst($row['status']); ?></td>
					<td><a href="<?php echo ADMINURL.'payment-new.php?action=edit&id='.$row['id']; ?>">Edit</a></td>
				</tr>
				<?php } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
		  <div class="form-layout-footer mg-t-30">
                <button onClick="history.go(-1)" type="button" class="btn btn-info mg-r-5">Back</button>
        </div><!-- card -->

      </div><!-- am-pagebody -->      
<?php include('includes/common/footer.php'); ?>