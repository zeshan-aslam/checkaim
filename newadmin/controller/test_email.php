<?php
include('../../config.php');
if(isset($_POST['test_email']))
{
	global $prefix,$con;
	$postid = isset($_GET['pid']) ? $_GET['pid'] : -1;
	$to =  $_POST['adminmail'];
	$sqlmail = select("adminmail","adminmail_id='$postid'");
	$row           = mysqli_fetch_object($sqlmail);
			  $sub           = stripslashes($row->adminmail_subject);
			  $message       = stripslashes($row->adminmail_message);
			  $head          = stripslashes($row->adminmail_header);
			  $footer        = stripslashes($row->adminmail_footer);
			  $from          = stripslashes($row->adminmail_from);
			  $subject       = $sub;

			$headers    =  "Content-Type: text/html; charset=iso-8859-1\n";
			$headers   .=  "From: $from\n";

			$body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
			$body.="<tr>";
			$body.="<td width='100%' align='center' valign='top'><br/>";
			$body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";

			$body.="<tr>";
			$body.="<td  width='100%' align='center'> </td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td  width='100%' align='left'> $head</td>";
			$body.="</tr>";

			$body.="<tr>";
			$body.="<td  width='100%' align='left'>&nbsp;</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td width='100%' align='left'>$message";
			$body.="</td></tr>";
			$body.="<tr>";
			$body.="<td width='100%' align='left'>";
			$body.="</td></tr>";
			$body.="<tr>";
			$body.="<td  width='100%' align='left'>&nbsp;</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td  width='100%' align='left'>$footer</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td  width='100%' align='center'></td>";
			$body.="</tr>";

			$body.="</table>";
			$body.="</td>";
			$body.="</tr>";
			$body.="</table>";
		
			 $success = mail($to,$subject,$body,$headers);
			 if (!$success) {
				$_SESSION['faliuretestemail'] = error_get_last()['message'];
				redirect(ADMINURL.'edit_email'.'.php?id='.$postid);
				}else{
					$_SESSION['successtestemail'] = "Mail send successfully";
					redirect(ADMINURL.'edit_email'.'.php?id='.$postid);
				}	
			
			
	
}
?>