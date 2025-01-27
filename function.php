<?php
function connect($host, $user, $pass, $database){
	$connect = mysqli_connect($host, $user, $pass,$database);
	if (mysqli_connect_errno())
	  {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die;
	  }else{
		  return $connect;
	  } 
}


function getRelatedOwnerIds($ownerid, $relatedOwnerIds, $con)
  {
  
  		$sql = " SELECT GROUP_CONCAT(distinct auidid SEPARATOR ',') auidids FROM `partners_owner_auid_ip` where ownerid in ($relatedOwnerIds) ";
		//echo $sql."<br/>";
		     
		$result = mysqli_query($con,$sql);

		if(mysqli_num_rows($result) > 0)
		{
	  		$row = mysqli_fetch_assoc($result);

	  		//var_dump($row);
	  		
  			$auidids = $row["auidids"];

  			//echo $auidids."<br/>";;

  			if($auidids != NULL)
  			{
  				$sql = " Select GROUP_CONCAT(distinct ownerid) relatedownerids FROM `partners_owner_auid_ip` where ownerid <> $ownerid ";
  				$sql.= " and  auidid in (".$auidids.")  ";
  				$sql.= " and ownerid not in ($relatedOwnerIds) ";

  				//echo $sql."<br/>"; 

  				$relatedOwnerIdsResultObj = mysqli_query($con,$sql);

  				if(mysqli_num_rows($relatedOwnerIdsResultObj) > 0)
  				{
  					$relatedOwnerIdsResult = mysqli_fetch_assoc($relatedOwnerIdsResultObj);

  					//var_dump($relatedOwnerIdsResult);

  					if($relatedOwnerIdsResult["relatedownerids"] != NULL)
  					{
  						$relatedOwnerIds.=",".$relatedOwnerIdsResult["relatedownerids"];

  						//echo $relatedOwnerIds."<br/>";;

  						getRelatedOwnerIds($ownerid, $relatedOwnerIds, $con);
  					}

  				}

  			}

  		
		}

		return $relatedOwnerIds;
  }


function login($con,$user, $password, $type) {
	global $prefix;
	$success = false;
	$tbl = $prefix."users";
	$pass = md5($password);
	if($type=='admin')
	{
		$typ = '1';
		 $query = "select * from $tbl where email='$user' and password='$pass' and type='$typ' and status='1'";
	}
	else
	{
		$typ = '3';
		$query = "select * from $tbl where email='$user' and password='$pass' and type='$typ' and status='1'";
	}
	$userlogin = mysqli_query($con,$query);
	if(mysqli_num_rows($userlogin) > 0)
	{
		$tbllog = $prefix."user_log";
		$fetchuser = fetch($userlogin);
		$userid = $fetchuser['id'];
		$ip = $_SERVER['REMOTE_ADDR'];
		mysqli_query($con,"insert into $tbllog (user_id,date,ip) values ('$userid', Now(), '$ip')");
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string = '';
		$length = 10;
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		if($type == 'admin')
		{
			$random = $string; 
			$_SESSION['my_token'] = $random;
			$_SESSION[$random] = $user;
			$_SESSION['login'] = 'Login Successfully';
			redirect(ADMINURL.'index.php');
		}
		else
		{
			$random = $string;
			$_SESSION['my_front_token'] = $random;
			$_SESSION[$random] = $user;
			$_SESSION['successlogin'] = 'front Login Successfully';
			$_SESSION['successloginid'] = $userid;
			
		}
		$success = true;
	}
	
	return $success;
}

function register($con, $password, $email, $type,$key,$r = '', $inv = ''){
	global $prefix;
	$tbl = $prefix."users";
	$pass = md5($password);
	if($type == 'admin')
	{
		$typ = '1';
		$status = '1';
	}
	else
	{
		$typ = '2';
		$status = '1';
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	$ins = mysqli_query($con,"insert into $tbl(email, password, status, user_type, date,rkey) values ('$email', '$pass', '$status', '$typ', NOW(),'$key')");
	$lastid = mysqli_insert_id($con);
	
	if($ins){
		$invite_code = sha1(mt_rand(1,999).time().$iemail);
		$subject = "Thanks for registration";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$message .= "Thanks for registration. please check access detail below <br> Password:".$password."<br>";  
		$message .= "Your Invitation Link: ".SITEURL."?r=".$key."&invite_code=".$invite_code;  
		mail($email, $subject, $message, $headers);
		$err=1;
	}
	else
	{
		$err = mysqli_error($con);
	}
	return $err;
}

function redirect($page){
	header('location:'.$page);
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function user(){
	if(isset($_SESSION['my_token']))
	{
		$token = $_SESSION['my_token'];
		if(isset($_SESSION[$token]))
		{
			$user = $_SESSION[$token];
		}
		else
		{
			$user = '';
		}
	}
	else
	{
		$user = '';
	}
	return $user;
}

function leadgenuser(){
	if(isset($_SESSION['my_front_token']))
	{
		$token = $_SESSION['my_front_token'];
		if(isset($_SESSION[$token]))
		{
			$user = $_SESSION[$token];
		}
		else
		{
			$user = '';
		}
	}
	else
	{
		$user = '';
	}
	return $user;
}

function logout()
{
	session_destroy();
	redirect('login.php');
}

function leadgenlogout()
{
	session_destroy();
	redirect(SITEURL);
}

function userinfo($id) {
	global $prefix;
	$fetch = '';
	if(isset($_SESSION['my_token']))
	{
		$token = $_SESSION['my_token'];
		if(isset($_SESSION[$token]))
		{
			$user = $_SESSION[$token];
			$tbl = 'users';
			$where = "email='$user'";
			$sel = select($tbl, $where);
			$row = fetch($sel);
			$fetch = $row[$id];
		}
	}
	return $fetch;
}

function leaduserinfo($id) {
	global $prefix;
	$fetch = '';
	if(isset($_SESSION['my_front_token']))
	{
		$token = $_SESSION['my_front_token'];
		if(isset($_SESSION[$token]))
		{
			$user = $_SESSION[$token];
			$tbl = 'users';
			$where = "email='$user'";
			$sel = select($tbl, $where);
			$row = fetch($sel);
			$fetch = $row[$id];
		}
	}
	
	return $fetch;
}

function select($tblname , $where='') {
	global $prefix,$con;
	$tbl = $prefix.$tblname;
	if($where != '')
	{
		
		$se = "select * from $tbl where $where";
		//echo $se; 
		$sel = mysqli_query($con,$se);
	}
	else
	{
		$se= "select * from $tbl";
		$sel = mysqli_query($con,$se);
	}	
	return $sel;
}

function fetch($fetch){
	return mysqli_fetch_array($fetch);
}

function query($con,$query, $singleResult = 0) {

		$_result = mysqli_query($con,$query );

		if (preg_match("/select/i",$query)) {
		$result = array();
		$table = array();
		$field = array();
		$tempResults = array();
		 $numOfFields = mysqli_num_fields($_result);
			for ($i = 0; $i < $numOfFields; ++$i) {
				$table_info  = mysqli_fetch_field_direct($_result, $i);
				
				array_push($table,$table_info->table);
				array_push($field,$table_info->name);
			}

			while ($row = mysqli_fetch_row($_result)) {
				for ($i = 0;$i < $numOfFields; ++$i) {
				 $tempResults[$field[$i]] = $row[$i];
				 }
				 if ($singleResult == 1) {
		 			mysqli_free_result($_result);
					
					return $tempResults;
				}
				 array_push($result,$tempResults);
			}
			mysqli_free_result($_result);
			
			return($result);
		}
		

	}

function get_user_info($userid, $key,$echo = false){
	global $prefix,$con;
		$query = "select * from ".$prefix."usermeta where user_id = '$userid' and user_key = '$key'";
		if($echo){
			$q = query($con,$query,1);
			$result = $q['user_meta'];
		}else{
			$result = query($con,$query);
		}
		return $result;
}

function get_avaz_info($userid, $key,$echo = false){
	global $prefix,$con;
		$query = "select * from ".$prefix."joinavazmeta where user_id = '$userid' and user_key = '$key'";
		if($echo){
			$q = query($con,$query,1);
			$result = $q['user_meta'];
		}else{
			$result = query($con,$query);
		}
		return $result;
}

function get_post_meta($post_id, $key,$echo = false){
	global $prefix,$con;
		$query = "select * from ".$prefix."posts where user_id = '$post_id' and post_slug = '$key'";
		if($echo){
			$q = query($con,$query,1);
			$result = $q['post_description'];
		}else{
			$result = query($con,$query);
		}
		return $result;
}

function get_config_meta($key, $comid, $echo = false){
	global $prefix,$con;
		$query = "select * from ".$prefix."config where user_id = '$comid' and config_name = '$key'";
		if($echo){
			$q = query($con,$query,1);
			$result = $q['config_value'];
		}else{
			$result = query($con,$query);
		}
		return $result;
}

function update_post_meta($postid,$post_key,$value){
	global $prefix,$con;
		$query = "select * from ".$prefix."postmeta where post_id = '$postid' and post_key = '$post_key'";
		$result = query($con,$query,1);
		if($result){
			$success = mysqli_query($con,"update ".$prefix."postmeta set post_value = '$value' where post_id = '$postid' and post_key = '$post_key' ");
		}else{
			 $success = mysqli_query($con,"INSERT INTO ".$prefix."postmeta (post_id,post_key,post_value) VALUES ('$postid','$post_key','$value')");
		}
}

function update_option_meta($option_name,$option_value){
	global $prefix,$con;
		$query = "select * from ".$prefix."option where option_name = '$option_name'";
		$result = query($con,$query,1);
		if($result){
			$success = mysqli_query($con,"update ".$prefix."option set option_value = '$option_value' where option_name = '$option_name' ");
		}else{
			 $success = mysqli_query($con,"INSERT INTO ".$prefix."option (option_name,option_value) VALUES ('$option_name','$option_value')");
		}
		
		return $result;
}

function get_option_meta($key){
	global $prefix,$con;
		$query = "select * from ".$prefix."option where option_name = '$key'";
	
			$q = query($con,$query,1);
			$result = $q['option_value'];
		
		return $result;
}

function update_user_meta($userid,$user_key,$value){
	global $prefix, $con;
		$query = "select * from ".$prefix."usermeta where user_id = '$userid' and user_key = '$user_key'";
		$result = query($con,$query,1);
		if($result){
			$success = mysqli_query($con,"update ".$prefix."usermeta set user_meta = '$value' where user_id = '$userid' and user_key = '$user_key' ");
		}else{
			 $success = mysqli_query($con,"INSERT INTO ".$prefix."usermeta (user_id,user_key,user_meta) VALUES ('$userid','$user_key','$value')");
		}
		return $success;
}

function update_joinavaz_meta($userid,$user_key,$value){
	global $prefix, $con;
		$query = "select * from ".$prefix."joinavazmeta where user_id = '$userid' and user_key = '$user_key'";
		$result = query($con,$query,1);
		if($result){
			$success = mysqli_query($con,"update ".$prefix."joinavazmeta set user_meta = '$value' where user_id = '$userid' and user_key = '$user_key' ");
		}else{
			 $success = mysqli_query($con,"INSERT INTO ".$prefix."joinavazmeta (user_id,user_key,user_meta) VALUES ('$userid','$user_key','$value')");
		}
		return $success;
}

function insert($table,$data){
	global $prefix,$con;
	$field = '';
	$value = '';
	foreach($data as $key => $val){
		$field .= $key.','; 
		$value .= "'$val',";
	}
	
	$fields = rtrim($field,',');
	$values = rtrim($value,',');

	mysqli_query($con,"INSERT INTO ".$prefix.$table." ($fields) VALUES ($values)");
	
	return mysqli_insert_id($con);
	//return mysqli_error($this->_dbHandle);
}

function create_slug($string){
   
   global $prefix,$con;
   $slugs = array();
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	$query = "SELECT * FROM ".$prefix."posts WHERE  post_slug  LIKE '".$slug."%'";
	$result = mysqli_query($con,$query);
	
	while($row = fetch($result)){
		$slugs[] = $row['post_slug'];
	}
	if(mysqli_num_rows($result) !== 0 && in_array($slug, $slugs)){
    $max = 0;

    //keep incrementing $max until a space is found
    while(in_array( ($slug . '-' . ++$max ), $slugs) );

    //update $slug with the appendage
    $slug .= '-' . $max;
	}
	
	return $slug; 

}

function exist($post_id,$table){
	global $prefix,$con;
	$exist = 0;
	$query = 'select * from '.$prefix.$table.' where `id` = \''.mysqli_real_escape_string($con,$post_id).'\'';
	$result = query($con,$query,1);
	if($result){ $exist = 1; }
	return $exist;
}

function email_exist($emailid){
	global $prefix,$con;
	$exist = 0;
	$tablename = $prefix."users";
	$query = "select * from $tablename where email = '$emailid'";
	$result = query($con,$query,1);
	if($result){ $exist = 1; }
	return $exist;
}

function word_limit($content,$position){
	$post = substr($content, 0, $position); 
	return $post;
}


function get_pagi($page,$total_pages,$limit){
	$adjacents = 0;
			if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			 $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1; 
		 $targetpage =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
			$targetpage = preg_replace("/(page\=[0-9]+[\&]*)/", "", $targetpage); // Delete page query string.

				if($targetpage[strlen($targetpage) - 1 ] != "?"){ 
					$targetpage .= "?"; // add &
				}else{
					$targetpage .= "";
				} 
				 
			 $pagination = "";
		if($lastpage > 1)
			{   
			$pagination .= "<div class=\"pagination\"><div class=\"page_links\">";
        //previous button
        if ($page > 1) 
            $pagination.= "<a class=\"next page-numbers\" href=\"{$targetpage}page=$prev\"><</a>";
        else
            $pagination.= "<a href=\"javascript:;\" class=\"page-numbers disabled\"><</a>"; 

        //pages 
        if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
        {   
            for ($counter = 1; $counter <= $lastpage; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class=\"page-numbers current\">$counter</span>";
                else
                    $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=$counter\">$counter</a>";                 
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
        {
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 2))     
            {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"page-numbers current\">$counter</span>";
                    else
                        $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=$counter\">$counter</a>";                 
                }
                $pagination.= "...";
                $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=$lpm1\">$lpm1</a>";
                $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=$lastpage\">$lastpage</a>";       
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
            {
                $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=1\">1</a>";
                $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=2\">2</a>";
                $pagination.= "...";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"page-numbers current\">$counter</span>";
                    else
                        $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=$counter\">$counter</a>";                 
                }
                $pagination.= "...";
                $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=$lpm1\">$lpm1</a>";
                $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=$lastpage\">$lastpage</a>";       
            }
            //close to end; only hide early pages
            else
            {
                $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=1\">1</a>";
                $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=2\">2</a>";
                $pagination.= "...";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class=\"page-numbers current\">$counter</span>";
                    else
                        $pagination.= "<a class=\"page-numbers\" href=\"{$targetpage}page=$counter\">$counter</a>";                 
                }
            }
        }

        //next button
        if ($page < $lastpage) 
            $pagination.= "<a class=\"next page-numbers\" href=\"{$targetpage}page=$next\">></a>";
        else
            $pagination.= "<a href=\"javascript:;\" class=\"page-numbers disabled\"> > </a>";
        $pagination.= "</div></div>\n";     
    }
		return $pagination;
	}
	


function insert_post($con,$table,$data,$imagefile,$post_id = false){
	global $prefix,$con;
	$success = false;
	if(!exist($post_id,$table)){
		$lastinsertid = insert($table,$data);
		if($lastinsertid){
			$success = true;
		}
	}else{
		$fields = '';
		foreach($data as $key => $val){
			$fields .= $key."="."'".$val."'".",";
		}
		$upfields = rtrim($fields,",");
	
		$success = mysqli_query($con,"update ".$prefix.$table." set $upfields where id = '$post_id'");
	}
	return $success;
}

 function getpage(){
	  if(!isset($_GET['page'])) $page=1; //Which page to display?
	  else $page=$_GET['page'];
return $page;
}

 function date2mysql($date){
	$tmp        =explode('/',$date);
	if(count($tmp)!=3) {
	$tmp        =explode('-',$date);
	if(count($tmp)!=3) return "0000-00-00";
	}
	$date        ="$tmp[2]-$tmp[1]-$tmp[0]";
	return $date;
 }

function countaffilatesdaily($leadgenid, $leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	$sqlcountaffil = "select * from $tablename where user_id = '$leadgenid' and DATE(date) = DATE(NOW()) and lead_type = '$leadtype'";
	$resultaffil   = mysqli_query($con,$sqlcountaffil);
	$naff = mysqli_num_rows($resultaffil);
	return $naff;
}
function countarrayaffilatesdaily($leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	$sqlcountaffil = "select * from $tablename where DATE(date) = DATE(NOW()) and lead_type = '$leadtype'";
	$resultaffil   = mysqli_query($con,$sqlcountaffil);
	$naff = mysqli_num_rows($resultaffil);
	return $naff;
}
function countaffilatesmonthly($leadgenid, $leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	$sqlimpression = mysqli_query($con,"select * from $tablename where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = '$leadtype' and user_id = '$leadgenid'");
	$naff = mysqli_num_rows($sqlimpression);
	return $naff; 
}
function countarrayaffilatesmonthly($leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	$sqlimpression = mysqli_query($con,"select * from $tablename where MONTH(date) = MONTH(CURRENT_DATE()) and lead_type = '$leadtype'");
	$naff .= mysqli_num_rows($sqlimpression);
	return $naff; 
}
function countaffilatesyearly($leadgenid, $leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	
	$sqlimpression = mysqli_query($con,"select * from $tablename where YEAR(date) = YEAR(CURRENT_DATE()) and lead_type = '$leadtype' and user_id = '$leadgenid'");
	$naff = mysqli_num_rows($sqlimpression);
	return $naff; 
}

function countconfirmleadsyearly($leadgenid, $leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	
	//echo "select * from $tablename where YEAR(date) and lead_type = '$leadtype' and user_id = '$leadgenid'";
	$sqlimpression = mysqli_query($con,"select * from $tablename where YEAR(date) and lead_type = '$leadtype' and user_id = '$leadgenid'");
	$naff = mysqli_num_rows($sqlimpression);
	return $naff; 
}
function countaffilatesarrayyearly($leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	$sqlimpression = mysqli_query($con,"select * from $tablename where YEAR(date) and lead_type = '$leadtype'");
	$naff .= mysqli_num_rows($sqlimpression);
	return $naff; 
}
function yearlyaffilates($leadgenid, $leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	/*Start Yearly Record*/ 
$year = date('Y');

 $sqlcountmsale = "SELECT 
    SUM(if(MONTH(date) = 1, 1,0)) as Jan,
    SUM(if(MONTH(date) = 2, 1,0)) as Feb,
    SUM(if(MONTH(date) = 3, 1,0)) as Mar,
    SUM(if(MONTH(date) = 4, 1,0)) as Apr,
    SUM(if(MONTH(date) = 5, 1,0)) as May,
    SUM(if(MONTH(date) = 6, 1,0)) as Jun,
    SUM(if(MONTH(date) = 7, 1,0)) as Jul,
    SUM(if(MONTH(date) = 8, 1,0)) as Aug,
    SUM(if(MONTH(date) = 9, 1,0)) as Sep,
    SUM(if(MONTH(date) = 10, 1,0)) as Oct,
    SUM(if(MONTH(date) = 11, 1,0)) as Nov,
    SUM(if(MONTH(date) = 12, 1,0)) as `Dec`
FROM $tablename 
WHERE user_id = $leadgenid and YEAR(date) = '$year' 
  AND lead_type = '$leadtype'";
  $resultmlead   = mysqli_query($con,$sqlcountmsale);
  while($rowlead = mysqli_fetch_array($resultmlead)){
	  $yearsale = $rowlead;
	  //$yearsale .= mysqli_num_rows($rowlead);
  }
	return $yearsale;
	
}

function countusa($leadgenid, $leadtype,$month,$monnumer){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	/*Start Yearly Record*/ 
$year = date('Y');
$x = 1; 

//while($x = 12) {
    //echo "The number is: $x <br>";
	$sqlcountmsale = "SELECT COUNT(affilate_charges) As Apr FROM $tablename  WHERE MONTH(date) = '$month' AND user_id = '$leadgenid'  and  lead_type = '$leadtype'";

    //$x++;
//} 
 
  $resultmlead   = mysqli_query($con,$sqlcountmsale);
  while($rowlead = mysqli_fetch_array($resultmlead)){
	  $yearsale = $rowlead;
	  //$yearsale .= mysqli_num_rows($rowlead);
  }
	return $yearsale;
	
}


function yearlyarrayaffilates($leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
	/*Start Yearly Record*/ 
$year = date('Y');
$yearsale = "";

$sqlcountmsale = "SELECT 
    SUM(if(MONTH(date) = 1, 1,0)) as Jan,
    SUM(if(MONTH(date) = 2, 1,0)) as Feb,
    SUM(if(MONTH(date) = 3, 1,0)) as Mar,
    SUM(if(MONTH(date) = 4, 1,0)) as Apr,
    SUM(if(MONTH(date) = 5, 1,0)) as May,
    SUM(if(MONTH(date) = 6, 1,0)) as Jun,
    SUM(if(MONTH(date) = 7, 1,0)) as Jul,
    SUM(if(MONTH(date) = 8, 1,0)) as Aug,
    SUM(if(MONTH(date) = 9, 1,0)) as Sep,
    SUM(if(MONTH(date) = 10, 1,0)) as Oct,
    SUM(if(MONTH(date) = 11, 1,0)) as Nov,
    SUM(if(MONTH(date) = 12, 1,0)) as `Dec`
FROM $tablename 
WHERE YEAR(date) = '$year' 
  AND lead_type = '$leadtype'";
  $resultmlead   = mysqli_query($con,$sqlcountmsale);
  while($rowlead = mysqli_fetch_array($resultmlead)){
	  
	 
	  $yearsale = $rowlead;
  }
	return $yearsale;
	
	
}

function getWeekDates($date, $start_date, $end_date, $i) {
    $week =  date('W', strtotime($date));
    $year =  date('Y', strtotime($date));
    $from = date("Y-m-d", strtotime("{$year}-W{$week}+1")); 
    if($from < $start_date) $from = $start_date;
    $to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   
    if($to > $end_date) $to = $end_date;
	$data = array(
		'from' => $from,
		'to' => $to,
	);
    return $data;
} 
function monthlyaffilates($leadgenid, $leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
/*Start Monthly Record*/ 
$year = date('Y');
$month = date('m');
  for($is = 0; $is < count($ids); $is++){
	$isd = $ids[$is]; 
	$psids .= "'$isd',";
  }
  $psids = rtrim($psids,',');
  
$lastmonthday = date('t');
$m = date('m');
$y = date('Y');

$sqlmsale = '';
$saledate = '';
$date = new DateTime('first Monday of this month');
$thisMonth = $date->format('m');
$weekvalue = '';
while ($date->format('m') === $thisMonth) {
    $dayweek = $date->format('Y-m-d');
	 $mno = date('d M', strtotime($dayweek));
	$sqlmsale .="SUM(if( WEEK(date)= WEEK('".$dayweek."'), affilate_charges,0)) as '".$mno."',";
    $date->modify('next Monday');
}
$month_ini = new DateTime("first day of this month");
$month_end = new DateTime("last day of this month");
$start_date = $month_ini->format('Y-m-d');
$end_date = $month_end->format('Y-m-d');
$i=1;



$sqlmsale = rtrim($sqlmsale,',');
$wsale = '';
$wlead = '';
$wclick = '';

for($date = $start_date; $date <= $end_date; $date = date('Y-m-d', strtotime($date. ' + 7 days'))) {
    $month = getWeekDates($date, $start_date, $end_date, $i);

	$weekvalue .= "'".$month['to']."',"; 
	
	$From = $month['from'];
	$To = $month['to'];
        $sqlcountmsale = "SELECT  count(*) AS reports_in_week,user_id
     FROM $tablename 
WHERE user_id = $leadgenid and date between '$From' and '$To' AND lead_type = '$leadtype'";  
$resultmsale   = mysqli_query($con,$sqlcountmsale);
while($rowws=mysqli_fetch_object($resultmsale))
{
	if($rowws->reports_in_week == ''){
		$sales = 0;
	}else{
		$sales = $rowws->reports_in_week;
	}
	$wsale .= "".$sales.","; 
} 

    $i++;
}
$data = array(
	'wsale' => $wsale,
	'weekvalue' => $weekvalue
);
return $data;
}
function monthlyarrayaffilates($leadtype){
	global $prefix,$con;
	$tablename = $prefix."affilates_charges";
/*Start Monthly Record*/ 
$year = date('Y');
$month = date('m');
  for($is = 0; $is < count($ids); $is++){
	$isd = $ids[$is]; 
	$psids .= "'$isd',";
  }
  $psids = rtrim($psids,',');
  
$lastmonthday = date('t');
$m = date('m');
$y = date('Y');

$sqlmsale = '';
$saledate = '';
$date = new DateTime('first Monday of this month');
$thisMonth = $date->format('m');
$weekvalue = '';
while ($date->format('m') === $thisMonth) {
    $dayweek = $date->format('Y-m-d');
	 $mno = date('d M', strtotime($dayweek));
	$sqlmsale .="SUM(if( WEEK(date)= WEEK('".$dayweek."'), affilate_charges,0)) as '".$mno."',";
    $date->modify('next Monday');
}
$month_ini = new DateTime("first day of this month");
$month_end = new DateTime("last day of this month");
$start_date = $month_ini->format('Y-m-d');
$end_date = $month_end->format('Y-m-d');
$i=1;



$sqlmsale = rtrim($sqlmsale,',');
$wsale = '';
$wlead = '';
$wclick = '';

for($date = $start_date; $date <= $end_date; $date = date('Y-m-d', strtotime($date. ' + 7 days'))) {
    $month = getWeekDates($date, $start_date, $end_date, $i);

	$weekvalue .= "'".$month['to']."',"; 
	
	$From = $month['from'];
	$To = $month['to'];
	$sales = "";
	
        $sqlcountmsale = "SELECT  count(*) AS reports_in_week,user_id
     FROM $tablename 
WHERE date between '$From' and '$To' AND lead_type = '$leadtype'";  
$resultmsale   = mysqli_query($con,$sqlcountmsale);
while($rowws=mysqli_fetch_object($resultmsale))
{
	if($rowws->reports_in_week == ''){
		$sales .= 0;
	}else{
		$sales .= $rowws->reports_in_week;
	}
	$wsale .= "".$sales.","; 
} 

    $i++;
}

$data = array(
	'wsale' => $wsale,
	'weekvalue' => $weekvalue
);
return $data;
}

function is_date($date){
	$tmp        =explode('/',$date);
	if(count($tmp)!=3) {
		$tmp        =explode('-',$date);
		if(count($tmp)!=3) return 0;
	}
	if(!is_numeric($tmp[1]) || !is_numeric($tmp[0]) || !is_numeric($tmp[2]))
		return 0;
	if(checkdate($tmp[1],$tmp[0],$tmp[2])) return 1;
	else return 0;
}

function balance_warning(){
	$balance = leaduserinfo('balance');
	if($balance < 50.00 && $balance > 1.00){
		?>
		<div class="sweet-container sweetcon">
			<div class="sweet-overlay" tabindex="-1" style="display: block; opacity: 1.06;"></div>
			<div class="sweet-alert show-sweet-alert visible" style="display: block; width: 500px; padding: 20px; margin-left: -250px; background: rgb(255, 255, 255); margin-top: -173px;" tabindex="-1">
				<div class="icon error" style="display: none;">
					<span class="x-mark"><span class="line left"></span><span class="line right"></span></span>
				</div>
				<div class="icon warning pulse-warning" style="display: block;"> <span class="body pulse-warning-ins"></span> <span class="dot pulse-warning-ins"></span> </div> 
				<div class="icon info" style="display: none;"></div> 
				<div class="icon success" style="display: none;"> <span class="line tip"></span> <span class="line long"></span> <div class="placeholder"></div> <div class="fix"></div> </div> 
				<img class="sweet-image" style="display: none;">
				<div class="sweet-content">
					<p>You Account is running low on funds. To prevent your campaigns from suspension make a payment urgently <a href="<?php echo LEADURL.'index.php?Act=add_money'; ?>">Click Here</a></p>
				</div>
				<hr class="sweet-spacer" style="display: block;">
				<button class="sweet-confirm btn btn-info btn-fill closepopup">Ok</button>
			</div>
		</div>
		<?php
	}
}

function check_balance_and_action(){
	$balance = leaduserinfo('balance');
	if($balance < 0.00){
		redirect(LEADURL.'index.php?Act=add_money');
		exit;
	}
}

function check_transaction($value){//MUST BE DONE ON EVERY IMPRESSION, SUBMISSION, QUALIFIED LEAD, DAILY CHARGE, AUTO APPROVAL CRON.
	$balance = leaduserinfo('balance');
	$email = leaduserinfo('email');
	$userid = leaduserinfo('id');
	
	$transaction_value = $value;
	//$total_remaining_balance = $balance - $transaction_value;
	$total_remaining_balance = $value;
	if($total_remaining_balance < 0.00){
		if(get_user_info(leaduserinfo('id'),'av_campaign_status',true) == 'approve')
		{
			//update_user_meta(leaduserinfo('id'),'av_campaign_status','suspend');
							////EMAIL FUNCTION/////			
			$sent_email = avaz_email($userid,'15',$tokenid,$test);			
		
	}
	
	$sqldb = select("users","email =$email");
								
			while($rowdb = fetch($sqldb)){
				
				$userid = $rowdb['id'];
				
			
			}
	
	
	}
}

function avaj_form($slug){
	
	ob_start();
	$slug = isset($slug) ? $slug : '';
$sql = select("company","company_slug='$slug'");
if($slug != ''){
	 if(mysqli_num_rows($sql) == 0){
		redirect(SITEURL);
		exit;
	}   
}
 
$fetchpost = fetch($sql);

$comid = $fetchpost['id'];
$submissionid = $_GET['subid'];
$lastidsubidurl = unserialize(base64_decode($submissionid));
 $comidarry = unserialize(base64_decode($comid));


 
 
$av_campaign_status = get_user_info($leadgenid, 'av_campaign_status', true);
if($slug != '' && $av_campaign_status != 'approve'  && $leadgenid != '' && leaduserinfo('type') == 3){
	$av_campaign = unserialize(get_user_info($leadgenid, 'av_campaign', true));
		redirect(SITEURL);
		exit;

}

$companydatas = unserialize(base64_decode(get_config_meta('company_data', $comid, true)));
$companydata  = unserialize($companydatas['config']);

$companyquestiondata  = unserialize($companydatas['questions']);
$companyquestionoptiondata  = unserialize($companydatas['questionoption']);

	?>
	<link href="https://fonts.googleapis.com/css?family=Oswald:400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<div class="inner_form_rgt">
     <div class="text-center">

        </div>
	<form class="" id="join_avaj" action="<?php echo SITEURL.'controller/signup.php'; ?>" method="post">
			<input type="hidden" value="<?php echo $slug; ?>" name="companyid">
			<?php
				if(isset($_SESSION['successf'])){
					echo '<p class="alert alert-success">'.$_SESSION['successf'].'</p>';
					unset($_SESSION['successf']);
				}else if(isset($_SESSION['failuref'])){
					echo '<p class="alert alert-danger">'.$_SESSION['failuref'].'</p>';
					unset($_SESSION['failuref']);
				}
			?>
			<?php 
			$datacom = $companydata['affiliate_merchant'];
			
			$output =  str_replace('{ORDERID}', $lastidsubidurl, $datacom) ?>
			<div class="hidden"><?php echo $output; ?></div>
				<div class="form-group">
				
					<label>First Name</label>
					
					<input type="text" name="first_name" class="form-control" placeholder="Please Enter Your First Name" />
					<input type="hidden" name="os_platform" value="<?php echo $os_platform ?>" class="form-control"/>
					<input type="hidden" name="browser_name" value="<?php echo $browser_name ?>" class="form-control"/>
					<input type="hidden" name="getsizepost" value="<?php echo $widthscreen ?>" class="form-control getsizexpost"/>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input required type="email" name="av_email" class="form-control" placeholder="Please Enter Your Email" id="av_email" />
					<span class="showmsg"></span>
				</div>
				<div class="form-group">
					<label>Phone Number</label>
					<input required type="text" id="av_phone" name="av_phone" class="form-control" size="20" placeholder="Please Enter Your Phone Number" />
				</div>
				<div class="form-group">
					<label>Post Code</label>
					<input required type="text" name="av_post_code" class="form-control" placeholder="Please Enter Your Post Code" />
				</div>
				<?php if(!empty($companyquestiondata)){ for($is =0; $is< count($companyquestiondata); $is++){?>
				<div class="form-group">
            <?php echo $companyquestiondata[$is]['question_name']; ?> </label>
					<select required class="form-control" name="av_question1[<?php echo $companyquestiondata[$is]['question_name']; ?>]">
						<option value="">Please Select</option>
						<?php for($i =0; $i< count($companyquestionoptiondata[$is]); $i++){ ?>
						<option value="<?php echo $companyquestionoptiondata[$is][$i]['question_option']; ?>"><?php echo $companyquestionoptiondata[$is][$i]['question_value']; ?></option>
						<?php } ?>
					</select>
				</div>
				<?php } } ?>
				<?php for($i =0; $i< count($companydata['question_info']); $i++){?>
					<div class="form-group" ><?php echo $companydata['question_info'][$i]['question_name']; ?></label>
					<input required type="text" name="av_question2[<?php echo $companydata['question_info'][$i]['question_name']; ?>]" class="form-control" placeholder="Please Enter Your Answer" />
				</div>
				<?php } ?>				
				<div class="form-group text-center">
					<input type="submit" name="join_avaz" id="button" class="submit_btn" value="Submit">
					
				</div>
			</form> 

</div>
    </div>			
	<?php
	return ob_get_clean();
}



          ////EMAIL FUNCTION/////
function avaz_email($userid,$adminmailid,$tokenid,$pass)
{

			global $con;
		
		    $sqlmail = select("adminmail","adminmail_id='$adminmailid'");		
			
			$row           = mysqli_fetch_object($sqlmail);
		 	$sub           = stripslashes($row->adminmail_subject);
			$message       = stripslashes($row->adminmail_message);
			$head          = stripslashes($row->adminmail_header);
			$footer        = stripslashes($row->adminmail_footer);
			$fromdb        = stripslashes($row->adminmail_from);
			$subject       = $sub;			  
			
			//UserDetails =  Displays all users details
			//run sql to get user info

			$useremail =  get_user_info($userid,'av_email',true); 
			$first_name =  get_user_info($userid,'first_name',true);
			$last_name =  get_user_info($userid,'last_name',true); 
			$av_company =  get_user_info($userid,'av_company',true); 
			$monthly_license_fee =  get_user_info($userid,'monthly_license_fee',true);
			$currency = get_user_info($userid,'av_Currency',true);	
	


			$getblc= "select * from av_users where email ='$useremail'";
		    $selval = mysqli_query($con,$getblc);
			$getrow           = mysqli_fetch_object($selval);	
		    $balanceADR       = stripslashes($getrow->balance);				
		
			$message = str_replace("[first_name]", $first_name, $message); //av_usermeta > first_name
			$message = str_replace("[last_name]", $last_name, $message); //av_usermeta > last_name
			$message = str_replace("[company]", $av_company, $message); //av_usermeta > av_company
			$message = str_replace("[monthly_fee]", $monthly_license_fee, $message); //av_usermeta > monthly_license_fee<br>
			$message = str_replace("[currency]", $currency, $message); //av_usermeta > monthly_license_fee
			$message = str_replace("[balance]", $balanceADR, $message); //av_users > balance 

			//Create Date Tags
			$today = date('d/m/Y');
			$month = date('F');
			$timedate = date('d/m/Y - H:i:s');
			$message = str_replace("[today]", $today, $message);
			$message = str_replace("[month]", $month, $message);
			$message = str_replace("[time_now]", $timedate, $message);							
			$message = str_replace("[mer_password]", $pass, $message);
			
			 //$body=str_replace("[mer_password]",$pass,$body);
			  
			$reset  =     "Click this <a href='https://avazai.com/confirmlink.php?token=$tokenid'>Link</a> to reset your password.";
            $message = str_replace("[password_reset_link]", $reset, $message);
			$headers    =  "Content-Type: text/html; charset=iso-8859-1\n";
		    $headers   .=  "From: $fromdb\n";
			$body.=$head;			
			$body.=$message;
			$body.=$footer;	
			
			$success = mail($useremail,$subject,$body,$headers);	
		
		
}


function contact_email($contactdata, $adminmailid)
{
			global $con;
		
		    $sqlmail = select("adminmail","adminmail_id='$adminmailid'");		
			
			$row           = mysqli_fetch_object($sqlmail);
		 	$sub           = stripslashes($row->adminmail_subject);
			$message       = stripslashes($row->adminmail_message);
			$head          = stripslashes($row->adminmail_header);
			$footer        = stripslashes($row->adminmail_footer);
			$fromdb        = stripslashes($row->adminmail_from);
			$subject       = $sub;			  
			
		

			//Create Date Tags
			$today = date('d/m/Y');
			$month = date('F');
			$timedate = date('d/m/Y - H:i:s');
			$message = str_replace("[today]", $today, $message);
			$message = str_replace("[month]", $month, $message);
			$message = str_replace("[time_now]", $timedate, $message);							
			$message = str_replace("[mer_password]", $pass, $message);
			

			$message = str_replace("[fullname]", $contactdata["fullname"], $message);
			$message = str_replace("[company]", $contactdata["company"], $message);
			$message = str_replace("[email]", $contactdata["email"], $message);
			$message = str_replace("[phone]", $contactdata["phone"], $message);
			$message = str_replace("[message]", $contactdata["message"], $message);
			  
			$reset  =     "Click this <a href='https://avazai.com/confirmlink.php?token=$tokenid'>Link</a> to reset your password.";
            $message = str_replace("[password_reset_link]", $reset, $message);
			$headers    =  "Content-Type: text/html; charset=iso-8859-1\n";
		    $headers   .=  "From: $fromdb\n";
		    $headers   .=  "BCC: humaurtumonline@gmail.com\n";
			$body.=$head;			
			$body.=$message;
			$body.=$footer;	
			
			$to = "searlco.com@gmail.com";

			$success = mail($to,$subject,$body,$headers);	

			return $success;
}


function alert_email($to, $alertdata, $adminmailid)
{
			global $con;
		
		    $sqlmail = select("adminmail","adminmail_id='$adminmailid'");		
			
			$row           = mysqli_fetch_object($sqlmail);
		 	$sub           = stripslashes($row->adminmail_subject);
			$message       = stripslashes($row->adminmail_message);
			$head          = stripslashes($row->adminmail_header);
			$footer        = stripslashes($row->adminmail_footer);
			$fromdb        = stripslashes($row->adminmail_from);
			$subject       = $sub;			  
			

		

			//Create Date Tags
			$today = date('d/m/Y');
			$month = date('F');
			$timedate = date('d/m/Y - H:i:s');
			
			$message = str_replace("[alerttype]", $alertdata["alerttype"], $message);
			$message = str_replace("[orderid]", $alertdata["orderid"], $message);
			$message = str_replace("[auidid]", $alertdata["auidid"], $message);
			$message = str_replace("[company]", $alertdata["company"], $message);
			  
			
			$headers    =  "Content-Type: text/html; charset=iso-8859-1\n";
		    $headers   .=  "From: $fromdb\n";
		    $headers   .=  "BCC: humaurtumonline@gmail.com, theandyreeve@gmail.com \n";
			$body.=$head;			
			$body.=$message;
			$body.=$footer;	
			
			$to = $to;

			$success = mail($to,$subject,$body,$headers);	

			return $success;
}




?> 