<?php
include_once '../includes/db-connect.php';

$id 	= $_POST['merchantid'];
$dir="uploadedimage/";
if(isset($_FILES['ajax_file'])){
$imge=$_FILES['ajax_file'];
$filename = $imge['name'];
$types = array('image/jpeg', 'image/gif', 'image/png');
if (in_array($imge['type'], $types)) {
if($imge['size']<=10000000){ $destination=$dir.$imge['name']; $isuploaded=move_uploaded_file($imge['tmp_name'],$destination); if($isuploaded){ 
  $sql1="UPDATE `partners_merchant` SET `merchant_profileimage` = '$filename'
           WHERE `merchant_id` = '$id'";
$result = mysqli_query($con,$sql1);

if($result){
	echo json_encode(array("status"=>"success","message"=>"Image has been uploaded successfully"));
}else{
	echo json_encode(array("status"=>"fail","message"=>"Some error to upload this Image"));
}
}else{
echo json_encode(array("status"=>"fail","message"=>"Some error to upload this Image"));
}
}else{
echo json_encode(array("status"=>"fail","message"=>"Sorry your Image was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and PNG filetypes."));	
}
}else{
echo json_encode(array("status"=>"fail","message"=>"Image size can't more than 1 MB"));
}
}else{
echo json_encode(array("status"=>"fail","message"=>"Image size can't more than 1 MB"));
}
?>