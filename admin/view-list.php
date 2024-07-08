<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); 
$postid = isset($_GET['cid']) ? $_GET['cid'] : -1;
?>

	<div class="am-pagetitle">
        <h5 class="am-title">View</h5>
         
      </div><!-- am-pagetitle -->
      <div class="am-pagebody">
		<div class="card pd-20 pd-sm-40 bg_clr">
		<?php
			if(isset($_SESSION['success'])){
				echo '<p class="alert alert-success">'.$_SESSION['success'].'</p>';
				unset($_SESSION['success']);
			}
		?>
          <div class="table-wrapper">
		  	<?php $sql = select("joinavaz","companyid = '$postid' order by date DESC"); 
			
			$sqls = select("company","id='$postid'");
			$fetchposts = fetch($sqls);
			$company_name = $fetchposts['company_name'];
			?>
			
			<h4>Campaign = <?php echo $company_name; ?></h4>
            <table id="datatable2" class="table table-hover table-striped">
              <thead>
                <tr>
                  <th class="wd-15p">First Name</th>
                  <th>Last Name</th>
				  <th>Post Code</th>
				  <th>Email</th>
                  <th>Phone Number</th>
				  <th>Confirmed</th>
				  <th>Sold</th>
				  <th>Closed</th>
				  <th class="sorting">Date Recieved</th>
                  <th>Action</th>
				  <th></th>
                </tr>
              </thead>
              <tbody> 
				<?php while($row = fetch($sql)){ 
				?>
				<tr>
					<td><?php echo get_avaz_info($row['id'],'first_name',true); ?></td>
					<td><?php echo get_avaz_info($row['id'],'sur_name',true); ?></td>
					<td><?php echo get_avaz_info($row['id'],'av_post_code',true); ?></td>
					<td><?php echo get_avaz_info($row['id'],'av_email',true); ?></td>
					<td><?php echo get_avaz_info($row['id'],'av_phone',true); ?></td>
					<td><?php if(get_avaz_info($row['id'],'is_confirmed',true) == 1 ){ ?> <input disabled type="checkbox" name="is_confirmed" value="1"  checked > <?php } else if(get_avaz_info($row['id'],'is_confirmed',true) == 2 ){ echo 'Cancelled'; }else{ ?><input type="checkbox" name="is_confirmed" value="1" disabled ><?php } ?></td>
					<td> <input disabled type="checkbox" name="is_solid" value="1" <?php if(get_avaz_info($row['id'],'is_sold',true) == 1 ){ echo 'checked'; }?>></td>
					<td> <input disabled type="checkbox" name="is_closed" value="1" <?php if(get_avaz_info($row['id'],'is_closed',true) == 1 ){ echo 'checked'; }?>></td>
					<td><?php echo date('Y-m-d',strtotime($row['date'])); ?></td>
					
					<td><a href="view.php?action=view&id=<?php echo $row['id']; ?>&campid=<?php echo $postid; ?>">View</a></td>
					 <td></td>
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