<?php
include('../../config.php');
if(isset($_POST['submit_post']))
{
	global $prefix,$con;
	
  $approvests = $_POST['status'];

	
     $userid = $_POST['user_id'];
	
	
	
	$sqldb = select("users","id =$userid");
								
			while($rowdb = fetch($sqldb)){
				
				$customeremail = $rowdb['email'];
				
			
			}

	$postid = isset($_GET['pid']) ? $_GET['pid'] : -1;
	$slug = '';
	if($postid != -1){ $slug = '?action=edit&id='.$postid; }
		$target = ROOT.'/img/';
		$target = $target . basename( $_POST['company_name'].$_FILES['logo_name']['name']) ;
		$filename = $_POST['company_name'].$_FILES['logo_name']['name'];
		$types = array('image/jpeg', 'image/gif', 'image/png');
		if(!empty($_FILES['logo_name']['name'])){
			if (in_array($_FILES['logo_name']['type'], $types)) {
				move_uploaded_file($_FILES['logo_name']['tmp_name'], $target);
				$_POST['config']['logo_name'] = $filename;
			} else {
				$_SESSION['faliureconfig'] = "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes.";
				
				redirect(ADMINURL.$_POST['compaign_type'].'.php'.$slug);
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
				$_SESSION['faliureconfig'] = "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes.";
				redirect(ADMINURL.$_POST['compaign_type'].'.php'.$slug);
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
			'status' => mysqli_real_escape_string($con,$_POST['status']),
			'user_id' => userinfo('id'),
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
			if($status == 1){
				$sql = select("company","id='$postid'");
				$sqlfetch = fetch($sql);
				$user_id = $sqlfetch['user_id'];
				
				$sqluser = select("users","id='$user_id'");
				$fetchuser = fetch($sqluser);
				if($fetchuser['type'] == 3){  
				$av_campaignarray = unserialize(get_user_info($user_id,'av_campaign',true));
					if(!in_array($postid, $av_campaignarray)){
						$av_campaignarray[] = $postid;
					}
					$avcamp = serialize($av_campaignarray);
					update_user_meta($user_id,'av_campaign',$avcamp);
				}
			}
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
			
			if($approvests == "1")
					{
					
						////// ////EMAIL FUNCTION/////
		            $sent_email = avaz_email($userid,'19',$tokenid);	
					$_SESSION['successconfig'] = "Record Saved successfully";
			        redirect(ADMINURL.$_POST['compaign_type'].'.php'.$slug);
			
						
					}
				else if ($approvests == '2')
				{
					
					    $sent_email = avaz_email($userid,'18',$tokenid);
					    $_SESSION['successconfig'] = "Record Saved successfully";
			            redirect(ADMINURL.$_POST['compaign_type'].'.php'.$slug);
							
			
					
				}	
				else{
					
							$_SESSION['successconfig'] = "Record Saved successfully";
			                redirect(ADMINURL.$_POST['compaign_type'].'.php'.$slug);
			
					
				}	
			
			
		}else{
			$_SESSION['faliureconfig'] = "Please try again";
			redirect(ADMINURL.$_POST['compaign_type'].'.php'.$slug);
		}
}

if(isset($_POST['is_submit']))
{
	$userid = $_POST['userid'];
	$campid = $_POST['campid'];
	$data = array(
		'is_confirmed' => $_POST['is_confirmed'],
		'is_sold' => $_POST['is_sold'],
		'is_closed' => $_POST['is_closed'],
	);
	if(isset($_POST['sold_to']) && $_POST['sold_to'] != ''){
	$da = array(
		'user_id' => $userid,
		'user_key' => 'sold_to',
		'user_meta' => $_POST['sold_to'],
	);
	insert('joinavazmeta',$da);
}
	
	$sqls = select("joinavaz","id='$userid'");
	
	$fuser = fetch($sqls);
	$myuserid = $fuser['user_id'];
		if(isset($_POST['is_confirmed'])){
			$tableaff = $prefix."affilates_charges";
			$is_confirmed = get_avaz_info($userid, 'is_confirmed' , true);
			
			if($is_confirmed == 1){}else{
			$companydatas = unserialize(base64_decode(get_config_meta('company_data', $campid, true)));
			$companydata  = unserialize($companydatas['config']);
			$qlval = $companydata['qualified_lead_amt'];
			
			$sqls = select('users',"id='$myuserid'");
			$rowsd = fetch($sqls);
			$balance = $rowsd['balance'];
				if($balance > 0){
					
					mysqli_query($con, "insert into $tableaff (user_id, lead_type, date, campagin_id,affilate_charges) values ('$myuserid', 'confirm_leads', Now(), '$campid','$qlval')");
					$balace = $balance - $qlval;
					check_transaction($balace);
					mysqli_query($con, "update av_users set balance = '$balace' where id='$myuserid'");
				}
			}
		}
		foreach($data as $key => $val){
		 $success = update_joinavaz_meta($userid,$key,$val);
		}
	if($success){
			$_SESSION['successconfig'] = "Record Saved successfully";
			redirect(ADMINURL.'view.php?action=view&id='.$userid.'&campid='.$campid);
		}else{
			$_SESSION['faliureconfig'] = "Please try again";
			redirect(ADMINURL.'view.php?action=view&id='.$userid.'&campid='.$campid);
		}
}

if(isset($_POST['action']) && $_POST['action'] == 'delete'){
	global $prefix,$con;
	 $tableid= $_POST['tableid'];
	$tablecom = $prefix.'company';
	$tablecon = $prefix.'config';
	$tablepos = $prefix.'posts';
	$resultss = mysqli_query($con,"select * from $tablecom where id='$tableid'");
	$feth = fetch($resultss);
	$userid = $feth['user_id'];
	$av_campaign =  unserialize(get_user_info($userid,'av_campaign',true));
	$result = mysqli_query($con,"delete from $tablecom where id='$tableid'");
	if($result){
		if (($key = array_search($tableid, $av_campaign)) !== false) {
			unset($av_campaign[$key]);
		}
		update_user_meta($userid, 'av_campaign',serialize($av_campaign));
		$companydata = unserialize(base64_decode(get_config_meta('company_data', $tableid, true)));
		$logoname = $companydata['logo_name'];
		$target = ROOT.'/img/';
		unlink($target.$logoname);
		$result = mysqli_query($con,"delete from $tablepos where user_id='$tableid'");
		$result = mysqli_query($con,"delete from $tablecon where user_id='$tableid'");
		
	}
	if($result){
	$_SESSION['success'] = "Record Successfully Deleted"; 
	}else{
		echo mysqli_error($con);
	}
}


if(isset($_GET['action']) && $_GET['action'] == 'download'){
	 $postid = $_GET['did'];
	 
	 
	$sqls = select("company","id='$postid'");
	$fetchposts = fetch($sqls);
	$company_name = $fetchposts['company_name'];
	$csv_trans = $company_name."\r\n";
	 $csv_trans .= "First Name".","."Last Name".","."Post Code".","."Email".","."Phone No".","."Confirmed".","."Sold".","."Closed".","."Date Recieved"."\r\n";
	$sql = select("joinavaz","companyid = '$postid' order by date DESC");
	$sep= '';
	while($row = fetch($sql)){ 
		$first_name = get_avaz_info($row['id'],'first_name',true).$sep;
		$sur_name = get_avaz_info($row['id'],'sur_name',true).$sep;
		$av_post_code = get_avaz_info($row['id'],'av_post_code',true).$sep;
		$av_email = get_avaz_info($row['id'],'av_email',true).$sep;
		$av_phone = get_avaz_info($row['id'],'av_phone',true).$sep;
		if(get_avaz_info($row['id'],'is_confirmed',true) == 1 ){ $is_confirmed = 'yes'.$sep; }else{ $is_confirmed = 'No'.$sep; }
		if(get_avaz_info($row['id'],'is_solid',true) == 1 ){ $is_solid = 'yes'.$sep; }else{ $is_solid = 'No'.$sep; }
		if(get_avaz_info($row['id'],'is_closed',true) == 1 ){ $is_closed = 'yes'.$sep; }else{ $is_closed = 'No'.$sep; }
		$date = date('Y-m-d',strtotime($row['date'])).$sep;
		$csv_trans .= $first_name.",".$sur_name.",".$av_post_code.",".$av_email.",".$av_phone.",".$is_confirmed.",".$is_solid.",".$is_closed.",".$date."\r\n";
	}
	
	$fileName = $company_name."_campagin.csv";
	 ROOT."/reports/".$fileName;
	$fp = fopen( ROOT."/reports/".$fileName,"w");
	fwrite($fp,$csv_trans);
	fclose($fp);
	
	//Download file
	$newFile	= 	$fileName;
	$path		=	ROOT."/reports/".$newFile;
	 header("Pragma: public");
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-Type: application/force-download");
	header('Content-Disposition: attachment; filename="'.$fileName.'"');
	header("Content-Type: application/xls"); 
	header("Content-Transfer-Encoding: binary");
	header('Content-Length: '.@filesize($path));
	set_time_limit(0);
	@readfile($path) OR die("file not found");
	
	unlink($path);
	
	exit; 
	/* echo "Campaign ".$company_name. "\t";
	echo "\n";

	echo "First Name". "\t";
	echo "Last Name". "\t";
	echo "Post Code". "\t";
	echo "Email". "\t";
	echo "Phone No". "\t";
	echo "Confirmed". "\t";
	echo "Sold". "\t";
	echo "Closed". "\t";
	echo "Date Recieved". "\t";
	$sep = "\t"; 
	echo "\n"; */
	
	
	
	//redirect(ADMINURL);
}

if(isset($_POST['action']) && $_POST['action'] == 'checkcompany'){
	global $prefix,$con;
	 $comname= $_POST['comname'];
	$tablecom = $prefix.'company';
	$result = mysqli_query($con,"select * from $tablecom where company_name = '$comname'");
	$is_exist = mysqli_num_rows($result);
	if($is_exist > 0){
		echo json_encode(array('exist' => true));
	}else{
		echo json_encode(array('exist' => false));
	}
	die;
}
if(isset($_POST['action']) && $_POST['action'] == 'userdelete'){
	global $prefix,$con;
	$userid = $_POST['userid'];
	
	$resultuser = mysqli_query($con,"delete from av_users where id = '$userid'");
	$resultuser = mysqli_query($con,"delete from av_company where user_id = '$userid'");
	$resultuser = mysqli_query($con,"delete from av_affilates_charges where user_id = '$userid'");
	$resultuser = mysqli_query($con,"delete from av_usermeta where user_id = '$userid'");
	$resultuser = mysqli_query($con,"delete from av_user_log where user_id = '$userid'");
	$resultuser = mysqli_query($con,"delete from av_addmoney where leadgen_id  = '$userid'");
	
	

	
	if($resultuser){
		
	$_SESSION['successdeleteuser'] = "Record Successfully Deleted"; 
		
	}else{
		echo mysqli_error($con);
	}
}


?>