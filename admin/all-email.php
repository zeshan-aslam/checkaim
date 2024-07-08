<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); 
$postid = isset($_GET['cid']) ? $_GET['cid'] : -1;
?>

	<div class="am-pagetitle">
        <h5 class="am-title">Adminmail</h5>
	         
      </div><!-- am-pagetitle -->
	  
      <div class="am-pagebody">

		<div class="card pd-20 pd-sm-40 bg_clr1">
		
          <div class="table-wrapper">
		  				
			
			
            <table id="datatable" class="table display  nowrap">
              <thead>
                <tr>
                  <th class="">Adminmail eventname</th>
                  <th>Adminmail from</th>
				  <th>Adminmail subject </th>
				 <th>Action</th>
            
                </tr>
              </thead>
              <tbody> 
				<?php


               $sqldata = select("adminmail");  
			   
				while($row = fetch($sqldata)){ 			
				
				
				?>
				<tr>
					<td><?php echo $row['adminmail_eventname']; ?></td>
					<td><?php echo $row['adminmail_from']; ?></td>
					<td><?php echo $row['adminmail_subject']; ?></td>
					<td><a href="<?php echo ADMINURL.'edit_email.php?id='.$row['adminmail_id']; ?>">Edit</a></td>
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