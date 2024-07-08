<?php
$lines_per_page=$lines;

  if($Act=="merchants")
  {
  	  if($status!="pending")
	  {
		  //generate the query to get the total number of records
		  $pgsql = strtolower($pgsql);
		  $pagingsql  = explode("from",$pgsql);
		  $pgsql = "SELECT COUNT(*) AS c FROM ";
		  if(strstr($pagingsql[1],"where"))
		  {
				$pagingsql  = explode("where",$pagingsql[1]);
                $pgsql .= $pagingsql[0]." WHERE ".$pagingsql[1];
		  }
		  else $pgsql .= $pagingsql[1];

		  $retpaging	=mysqli_query($con, $pgsql);
		  if($rowpaging = mysqli_fetch_object($retpaging)) $nos = $rowpaging->c;
   	 }
	 else
	 {
		
  		$ret	=mysqli_query($con, $pgsql);
	  	$nos	=mysqli_num_rows($ret);

	 }//end of checking for status
 }
 else
 {
  		$ret	=mysqli_query($con, $pgsql);
	  	$nos	=mysqli_num_rows($ret);
 }//end of checking for merchants
  $nop	=ceil($nos/$lines_per_page);
  $tmp	=$url;

  if(!strstr($tmp,"?")) $sp="?";
  else $sp	="&amp;";

?>
<table >
	<tr>
<?php

  /*if(!isset($_GET['page'])) $page=1;
  else $page=$_GET['page'];*/
  $cb	=floor(($page-1)/5)+1;

  $j	=($cb-1)*5+1;
  if($cb>1){
?>
<td class="tdwbdr"><a href="<?=$url.$sp?>page=<?=$j-1?>"><::</a></td>
<?php
}
  for ($i=$j; ($i<$j+5 and $i<=$nop); $i++) {
?>
<td class="tdwbdr">
<?php
if($i==$page) echo "<b>$i</b>";
else echo "<a href='$url$sp"."page=$i'>".$i."</a>";
?>
</td>
<?php
}
if(ceil($nop/5)!=$cb){
?>
<td class="tdwbdr"><a href="<?=$url.$sp?>page=<?=$i?>">::></a></td>
<?}?>
 </tr>
</table>