 <?php
 include('../../config.php');
 $Userid = $_GET['delid'];
 $sts = $_GET['sts'];
 
 global $prefix,$con;
	$table = $prefix.'users';

	//$result = mysqli_query($con,"delete from $table where id='$Userid'");
	$result = mysqli_query($con,"update av_users set status ='$sts' where id='$Userid'");
	
	
  if($result){

		$_SESSION['successdel'] = "Record Successfully Deleted";
		redirect(ADMINURL.'masteradmin.php');		
	
	}else{
		
      $_SESSION['faluireadmindel'] = "Please try again";
		redirect(ADMINURL.'masteradmin.php');
  }
?>