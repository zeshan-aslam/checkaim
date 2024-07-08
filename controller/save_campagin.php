<?php
include('../config.php');
if(isset($_POST['submit_post']))
{
	global $prefix,$con;
	$postid = isset($_GET['pid']) ? $_GET['pid'] : -1;
	$slug = '';
	if($postid != -1){ $slug = '&action=edit&campid='.$postid; }
	
	$sql = select("company","id='$postid'");
	$fetchpost = fetch($sql);
	if(leaduserinfo('id') != $fetchpost['user_id'] && $postid != -1){
		$_SESSION['faliureerror'] = "Campagin not found";
		redirect(LEADURL.'index.php?Act=campaign');
		exit;
	}
	
		$target = ROOT.'/img/';
		$target = $target . basename( $_POST['company_name'].$_FILES['logo_name']['name']) ;
		$filename = $_POST['company_name'].$_FILES['logo_name']['name'];
		$types = array('image/jpeg', 'image/gif', 'image/png');
		if(!empty($_FILES['logo_name']['name'])){
			if (in_array($_FILES['logo_name']['type'], $types)) {
				move_uploaded_file($_FILES['logo_name']['tmp_name'], $target);
				$_POST['config']['logo_name'] = $filename;
			} else {
				$_SESSION['faliurecamp'] = "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes.";
				
				redirect(LEADURL.'index.php/?Act=add_compaign'.$slug);
				exit;
			} 
		}else{
			$_POST['config']['logo_name'] = isset($_POST['logname']) ? $_POST['logname'] : '';
		}
		
		if(!empty($_FILES['background_image']['name'])){
			if (in_array($_FILES['background_image']['type'], $types)) {
				$target1 = ROOT.'/img/backimg/'; 
				$target1 = $target1 . basename( time().$_FILES['background_image']['name']) ;
				$filename1 = time().$_FILES['background_image']['name'];
				move_uploaded_file($_FILES['background_image']['tmp_name'], $target1);
				$_POST['config']['background_image'] = $filename1;
			}else {
				$_SESSION['faliurecamp'] = "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes.";
				redirect(LEADURL.'index.php/?Act=add_compaign'.$slug);
				exit;
			} 
		}else{
			$_POST['config']['background_image'] = isset($_POST['backgroundimage']) ? $_POST['backgroundimage'] : '';
		}
		
		$_POST['config']['question_info'] = isset($_POST['question']) ? $_POST['question'] : '';
		$inputs['config'] = serialize($_POST['config']);
		$inputs['questions'] = serialize($_POST['dropquestion']);
		$inputs['questionoption'] = serialize($_POST['dropopt']);
		$inputs['description'] = base64_encode(htmlspecialchars($_POST['description']));
		

		$page = $_POST['page'];
		
		if($postid == -1){
			$datacom = array(
			'company_name' => mysqli_real_escape_string($con,$_POST['company_name']),
			'status' => 0,
			'user_id' => leaduserinfo('id'),
			'compaign_type' => mysqli_real_escape_string($con,$_POST['compaign_type']),
			'company_slug' => create_slug(mysqli_real_escape_string($con,$_POST['company_name']))
			);
			$lastid = insert('company', $datacom);
				if($lastid){
					$dataconfig = array(
					'config_name' => 'company_data',
					'config_value' => base64_encode(serialize($inputs)),
					'user_id' => $lastid,
					);
					$success = insert('config', $dataconfig);
				}
				
				if($success){
					foreach($page as $key => $val){
						$vals = mysqli_real_escape_string($con,$val);
						 $success = mysqli_query($con,"INSERT INTO ".$prefix."posts (post_description,post_slug,user_id) VALUES ('$vals','$key','$lastid')");
					}
				}
				
		}else{
			$status = mysqli_real_escape_string($con,$_POST['status']);
			 mysqli_query($con,"update ".$prefix."company set status = '$status' where id = '$postid' ");
			
			$success = mysqli_query($con,"update ".$prefix."config set config_value = '".base64_encode(serialize($inputs))."' where user_id = '$postid' ");
			if($success){
					foreach($page as $key => $val){
						$vals = mysqli_real_escape_string($con,$val);
						 $successs = mysqli_query($con,"update ".$prefix."posts set post_description = '$vals' where user_id = '$postid' and post_slug = '$key'");
					}
			}
		}
		

		if($success){
			$_SESSION['successcamp'] = "Record Saved successfully";
			redirect(LEADURL.'index.php/?Act='.$_POST['compaign_type'].$slug);
		}else{
			$_SESSION['faliurecamp'] = "Please try again";
			redirect(LEADURL.'company-new.php'.$slug);
		}
}
?>