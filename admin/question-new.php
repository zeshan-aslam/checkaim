 <?php include('includes/common/header.php'); ?>
 <?php
	if(isset($_GET['action']) && $_GET['action'] == 'edit'){
		$postname = 'Edit Question';
		
	}else{
		$postname = 'Add Question';
	}

	$postid = isset($_GET['id']) ? $_GET['id'] : -1;
	$sql = select("question","id='$postid'");
	$fetchpost = fetch($sql);
?>
<?php include('includes/common/sidebar.php'); ?>
	<div class="am-pagetitle">
        <h5 class="am-title">Question</h5>
       
      </div><!-- am-pagetitle -->
	
      <div class="am-pagebody">
		<div class="row row-sm mg-t-20">
			
			<form style="width: 100%;" enctype="multipart/form-data" class="form-horizontal" action="controller/save_question.php?postid=<?php echo $postid; ?>" method="post">
				<input type="hidden" name="redirect_url" value="question-new">
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
                <label class="col-sm-4 form-control-label">Title: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <textarea type="text" class="form-control" name="title"  ><?php echo $fetchpost['question_name']; ?></textarea>
                </div>
              </div><!-- row -->
      
              
             
			 
              <div class="form-layout-footer mg-t-30">
                <button type="submit" name="submit_post" class="btn btn-info mg-r-5">Submit</button>
                <button class="btn btn-secondary">Cancel</button>
              </div><!-- form-layout-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->
         </form>
        </div><!-- row -->


    </div>
    
<?php include('includes/common/footer.php'); ?>