<?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); ?>
	<div class="am-pagetitle">
        <h5 class="am-title">Question</h5>
         
      </div><!-- am-pagetitle -->
      <div class="am-pagebody">
		<div class="card pd-20 pd-sm-40">
		<?php
			if(isset($_SESSION['success'])){
				echo '<p class="alert alert-success">'.$_SESSION['success'].'</p>';
				unset($_SESSION['success']);
			}
		?>
          <div class="table-wrapper">
		  	<?php $sql = select("question order by id DESC"); ?>
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Title</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody> 
				<?php while($row = fetch($sql)){ 
				?>
				<tr>
					<td><?php echo $row['question_name']; ?></td>
					<td><a href="question-new.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a> | <a  href="javascript:;" onClick="deletetablerow(<?php echo $row['id']; ?>,'Are you sure you like to delete Product <?php echo $row['question_name']; ?>','question','question.php')">Delete</a></td>
				</tr>
				<?php } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->

      </div><!-- am-pagebody -->      
<?php include('includes/common/footer.php'); ?>