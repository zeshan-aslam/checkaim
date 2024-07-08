 <?php
include('../../config.php');
if(isset($_POST['submit_post']))
{
		$postid = isset($_GET['postid']) ? $_GET['postid'] : -1;
		$redirect_url = $_POST['redirect_url'];
	
		if($postid == -1){
		$data = array(
			'question_name' => mysqli_real_escape_string($con,$_POST['title']),
			
		);
	}else{
		$data = array(
			'question_name' => mysqli_real_escape_string($con,$_POST['title']),
		);
	}
	
	$result = insert_post($con,'question',$data,$news_file,$postid); 
	if($result){
		
		$_SESSION['successpost'] = "Question saved successfully";
		if($postid == -1){
			redirect(ADMINURL.$redirect_url.'.php');
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

if(isset($_POST['action']) && $_POST['action'] == 'delete'){
	$tableid= $_POST['tableid'];
    $tablename= $_POST['table_name'];
   $return_url= $_POST['return_url'];
   global $prefix,$con;
	$table = $prefix.$tablename;

	$result = mysqli_query($con,"delete from $table where id='$tableid'");
  if($result){
	$_SESSION['success'] = "Record Successfully Deleted"; 
	echo $return_url;
	}else{
   echo mysqli_error($con);
  }
 }
?>