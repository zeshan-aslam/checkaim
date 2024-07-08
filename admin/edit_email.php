 <?php include('includes/common/header.php'); ?>
<?php include('includes/common/sidebar.php'); 
$postid = isset($_GET['id']) ? $_GET['id'] : -1;
$sql = select("adminmail","adminmail_id='$postid'");
	$fetchpost = fetch($sql);
	$comid = $fetchpost['id'];
?>
<div class="am-pagetitle">
    <h5 class="am-title">Email Template</h5>
</div><!-- am-pagetitle --> 
<div class="am-pagebody">
	<div class="row row-sm mg-t-20">
		<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="controller/save_email.php?pid=<?php echo $postid; ?>" method="post">
			<div class="col-md-12">
				<?php
			if(isset($_SESSION['successemail'])){
				echo '<p class="alert alert-success">'.$_SESSION['successemail'].'</p>';
				unset($_SESSION['successemail']);
			}else if(isset($_SESSION['faliureemail'])){
				echo '<p class="alert alert-danger">'.$_SESSION['faliureemail'].'</p>';
				unset($_SESSION['faliureemail']);
			}
			
		?>
			<?php
			if(isset($_SESSION['successtestemail'])){
				echo '<p class="alert alert-success">'.$_SESSION['successtestemail'].'</p>';
				unset($_SESSION['successtestemail']);
			}else if(isset($_SESSION['faliuretestemail'])){
				echo '<p class="alert alert-danger">'.$_SESSION['faliuretestemail'].'</p>';
				unset($_SESSION['faliuretestemail']);
			}
		?>
		 <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
			<div class="row">
				<label class="col-sm-4 form-control-label">Email Event Name: </label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input disabled type="text" name="company_name" id="companyname"  class="form-control" value="<?php echo $fetchpost['adminmail_eventname']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Subject: </label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="text" name="adminmail_subject" id="adminmail_subject"  class="form-control" value="<?php echo $fetchpost['adminmail_subject']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">From: </label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="text" name="adminmail_from" id="adminmail_from"  class="form-control" value="<?php echo $fetchpost['adminmail_from']; ?>">
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Adminmail Header: </label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<textarea class="input-block-level" rows="30" cols="90" id="summernote" name="adminmail_header"><?php echo htmlspecialchars($fetchpost['adminmail_header']); ?></textarea>
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Adminmail Message:</label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<textarea class="input-block-level" rows="30" cols="90" id="summernote1" name="adminmail_message"><?php echo htmlspecialchars($fetchpost['adminmail_message']); ?></textarea>
				</div>
			</div><!-- row -->
			<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Adminmail Footer:</label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<textarea class="input-block-level" rows="30" cols="90" id="summernote2" name="adminmail_footer"><?php echo htmlspecialchars($fetchpost['adminmail_footer']); ?></textarea>
				</div>
			</div><!-- row -->
			<div class="form-layout-footer mg-t-30">
                <button type="submit" id="subpos" name="submit_email" class="btn btn-info mg-r-5">Submit</button>
           
             </div><!-- form-layout-footer -->
		 </div>
			</div>
		</form>
		<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="controller/test_email.php?pid=<?php echo $postid; ?>" method="post">
			<div class="col-md-12">
			
			 <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
				<div class="row mg-t-20">
				<label class="col-sm-4 form-control-label">Email:</label>
				<div class="col-sm-8 mg-t-10 mg-sm-t-0">
					<input type="text" required name="adminmail" id=""  class="form-control" value="">
				</div>
				</div><!-- row -->
			<div class="form-layout-footer mg-t-30">
                <button type="submit" id="subpos" name="test_email" class="btn btn-info mg-r-5">Test mail</button>
            
             </div><!-- form-layout-footer -->
			</div>
		</div>
	</div>
</div>
<?php include('includes/common/footer.php'); ?>