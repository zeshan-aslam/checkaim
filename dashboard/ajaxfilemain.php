<?php

$userid = $_POST['userid'];
$response = "<table border='0' width='100%'>";

 $response .= "<tr>";
 $response .= "<td><input type='text' value='$userid'></td>";
 $response .= "<br>";
 $response .= "Please Press CTRL A to Highlight All The CTRL C to Copy the URL.
You Can Now Paste to Anywhere You Want to Dispaly Campaigns.</tr>";
$response .= "<br>";
$response .= "</table>";

$response .= "<br>";
$response .= "<br>";
$response .= "<br>";


echo $response;
exit;

?>