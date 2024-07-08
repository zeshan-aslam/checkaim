<?php
include('../../config.php');
if(isset($_POST['submit_cat']))
{
		$postid = isset($_GET['postid']) ? $_GET['postid'] : -1;
	if($postid == -1){
		$data = array(
			'name' => mysqli_real_escape_string($con,$_POST['category_name']),
			'slug' => create_slug(mysqli_real_escape_string($con,strtolower($_POST['category_name']))),
			'description' => mysqli_real_escape_string($con,$_POST['category_desc']),
			'parent' => mysqli_real_escape_string($con,$_POST['parent']),
			'date' => date('Y-m-d h:i:s'),
		);
	}else{
		$data = array(
			'name' => mysqli_real_escape_string($con,$_POST['category_name']),
			'slug' => create_slug(mysqli_real_escape_string($con,strtolower($_POST['category_name']))),
			'parent' => mysqli_real_escape_string($con,$_POST['parent']),
			'description' => mysqli_real_escape_string($con,$_POST['category_desc']),
		);
	}
	
		$result = insert_category($con,$data,$postid); 
		if($result){
			$_SESSION['successcategory'] = "Category Saved successfully";
			if($postid == -1){
				redirect(ADMINURL.'categories.php');
			}else{
				redirect(ADMINURL.'categories.php?action=edit&id='.$postid);
			}
		}else{
			$_SESSION['faliurecategory'] = "Please try again";
			if($postid == -1){
				redirect(ADMINURL.'categories.php');
			}else{
				redirect(ADMINURL.'categories.php?action=edit&id='.$postid);
			}
			
		}
}
?>