 <?php
include('../../config.php');
if(isset($_POST['submit_post']))
{
		$postid = isset($_GET['postid']) ? $_GET['postid'] : -1;
		$redirect_url = $_POST['redirect_url'];
	
		if($postid == -1){
		$data = array(
			'post_title' => mysqli_real_escape_string($con,$_POST['post_title']),
			'post_slug' => create_slug(mysqli_real_escape_string($con,$_POST['post_title'])),
			'post_description' => mysqli_real_escape_string($con,$_POST['post_description']),
			'post_type' => 'pages',
			'status' => 'publish',
			
		);
	}else{
		$data = array(
			'post_title' => mysqli_real_escape_string($con,$_POST['post_title']),

			'post_description' => mysqli_real_escape_string($con,$_POST['post_description']),
			'post_type' => 'pages',
			'status' => 'publish',
			
		);
	}
	
	$result = insert_post($con,'posts',$data,$news_file,$postid); 
	if($result){
		
		$_SESSION['successpost'] = "Page saved successfully";
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
?>