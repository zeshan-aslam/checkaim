<?php	
  #-------------------------------------------------------------------------------
  # Tracking code for click

  # Pgmmr        : Ankit Kedia
  # Date Created :   3rd August 2019
  # Date Modfd   :   3rd August 2019
  # Last Modified: By Ankit Kedia on 3rd August 2019
  #				   
  #-------------------------------------------------------------------------------

$requestName = createRandomPassword();

//writeToLog($requestName, "Start", getCurrentTime());

ob_end_clean();
  header("Connection: close");
  ignore_user_abort(); // optional
  ob_start();
  $file_out = "img/pixel.gif";
    $image_info = getimagesize($file_out);
    header("Content-Type: image/gif");
    header('Content-Length: ' . filesize($file_out));
    readfile($file_out);
    $size = ob_get_length();
    header("Content-Length: $size");
    ob_end_flush(); // Strange behaviour, will not work
    flush();            // Unless both are called !
    session_write_close();

  
//writeToLog($requestName, "Image Returned", getCurrentTime());
	include_once 'config.php';

  $t = microtime(true);
  $micro = sprintf("%06d",($t - floor($t)) * 1000000);
  $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
  $response["starttime"] = $d->format("Y-m-d H:i:s.u");

    # getting ip address	
    $ipaddress			    = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	if(empty($ipaddress)) $ipaddress = $_SERVER['REMOTE_ADDR'];
    
  $sale = trim($_GET['sale']);
	$productids = $_GET['productids'];
	$postage = $_GET["postage"];
	$taxcosts =  $_GET["taxcosts"];
	$cartid = $_GET["cartid"];
	$auid = isset($_GET['auid']) && trim($_GET['auid']) != "" ? trim($_GET['auid']) : "";
	$trafficsource = isset($_GET['trafficsource']) && trim($_GET['trafficsource']) != "" ? trim($_GET['trafficsource']) : "";
	$keyword = $_GET["keyword"];

	$mid					= intval(trim($_GET['mid']));
	$orderId = $_GET['orderId'];
	
	$redirectURL = isset($_GET['redirectURL']) && trim($_GET['redirectURL']) != "" ? trim($_GET['redirectURL']) : "";
    
	
	// Added by Ankit on 23rd June 2019
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$user_os        = getOS($user_agent);
	$user_browser   = getBrowser($user_agent);
	$referer 				= 	getenv(HTTP_REFERER);

  $presentDate        =   date("Y-m-d");
	$presenttime  			=   date("Y-m-d  H:i:s");

	$checkCurrency = array("$"=>'USD', "AU$"=>'aus', "CA$"=>'cas', "£"=>'GBP', "€"=>'ee', "¥"=>'yy');
	$currencyReplaceValues = array("0","1","2","3","4","5","6","7","8","9","."," ");
	$symbol = str_replace($currencyReplaceValues,'',$sale);

	

	$currency = $checkCurrency[$symbol] ? $checkCurrency[$symbol] : 'N/A';

  $sale = preg_replace( '/[^0-9\.]/', '', $sale );
  $productids = $_GET['productids'];
  $postage = preg_replace( '/[^0-9\.]/', '', $postage );
  $taxcosts =  preg_replace( '/[^0-9\.]/', '', $taxcosts );

	$currentPageUrl = $_SERVER['REQUEST_URI'];

   $location_trans_region = "";
   $location_trans_city = "";
   $location_trans_country = "";
   $location_trans_cords = "";

    try 
    {
      $iplocdetails = json_decode(file_get_contents("http://ipinfo.io/{$ipaddress}/json"));
          
      $location_trans_region = $iplocdetails->region;
      $location_trans_city = $iplocdetails->city;
      $location_trans_country = $iplocdetails->country;
      $location_trans_cords = $iplocdetails->loc;

    } 
    catch (Exception $e) {
    	$errorMessage = 'Location exception: '.getCurrentTime()." => ".$e->getMessage();
        writeToError($errorMessage);
    }

  
  //Ankit Kedia --> 25th May 2019 - Code For AUID 

  try
  {
	  $sql = " Insert into partners_aianalytics (ipaddress, browser, os, productids, postage, tax, cartid, trafficsource, auid, orderid, amount,  referer, keyword, currency, querystring, mid, location, city, region, country ) ";
		$sql.= " values ('$ipaddress', '$user_browser', '$user_os', '$productids', '$postage', '$taxcosts', '$cartid', '$trafficsource', '$auid', '$orderId', '$sale',  '$referer', '$keyword','$currency','$currentPageUrl','$mid','$location_trans_cords','$location_trans_city','$location_trans_region','$location_trans_country') ";

		//echo $sql; 

		$ret = mysqli_query($con,$sql);
	  $analyticsid = mysqli_insert_id($con);
  } 
  catch (Exception $e) 
  {
  	$errorMessage = 'Analytics exception: '.getCurrentTime()." => ".$auid." - ".$orderId." => ".$e->getMessage();
    writeToError($errorMessage);
  }
  
   $dailyAlerts = 0;
   
   if($auid != "" && $mid > 0)
   {
   	  $useremail = "";
   	  $interactCount = 5;
      $auidid = 0;
      $ownerid = 0;
      $ipid = 0;

      $sql = " Select * from av_users where id = '$mid' ";
      $userresult  = @mysqli_query($con,$sql);

	  if(mysqli_num_rows($userresult) > 0)
      {
      	$userdetails = mysqli_fetch_assoc($userresult) ;
      	$useremail = $userdetails["email"];
      }      

      $sql = " Select * from partners_alertsettings where mid = '$mid' ";
      $result  = @mysqli_query($con,$sql);

      if(mysqli_num_rows($result) > 0)
      {
      	$settingsRow = mysqli_fetch_assoc($result) ;
      	$interactCount = $settingsRow["interactcount"];
      }

      $sql = "select * from partners_auid where merchantid = '$mid' and auid = '$auid' ";
      $result  = @mysqli_query($con,$sql);
      
      if(!(mysqli_num_rows($result) > 0))
      {
        $sql = " Insert into partners_auid (merchantid, auid) values ('$mid', '$auid') ";
        @mysqli_query($con,$sql);

        $auidid = mysqli_insert_id($con);
      }
      else
      {

        $row = @mysqli_fetch_assoc($result) ;
        //var_dump($row);
        $auidid = $row["id"];

        $sql = " Select * from partners_owner_auid where auidid = '$auidid' ";
        $result  = @mysqli_query($con,$sql);

        if(mysqli_num_rows($result) > 0)
      	{
          	$row = @mysqli_fetch_assoc($result) ;
          	$ownerid = $row["ownerid"];
		}

      }

      $sql = " Select * from partners_ipstats where ipaddress = '$ipaddress' ";
      $result  = @mysqli_query($con,$sql);
      //echo $sql;
      
      if(!(mysqli_num_rows($result) > 0))
      {
      	if($ownerid == 0)
      	{
	      	$sql = " Insert into partners_aiowner (count) values (0) ";
	        mysqli_query($con,$sql);

	        $ownerid = mysqli_insert_id($con);
    	}

      	$sql = " Insert into partners_ipstats (ipaddress, ownerid) values ('$ipaddress', '$ownerid') ";
        mysqli_query($con,$sql);
        $ipid = mysqli_insert_id($con);
      }
      else
      {
      	$row = @mysqli_fetch_assoc($result) ;
      	$ipid = $row["id"];
      	$ownerid = $row["ownerid"];
      }
      
      $sql = " select * from partners_owner_auid where ownerid = '$ownerid' and auidid = '$auidid' ";
 	  $result  = @mysqli_query($con,$sql);

      if(!(mysqli_num_rows($result) > 0))
      {
	      $sql = " Insert into partners_owner_auid (ownerid,auidid) values ('$ownerid','$auidid') ";
	      @mysqli_query($con,$sql);
	  }

     
      $sql = " Select * from partners_aiowner where id = '$ownerid' ";
     
      $result  = @mysqli_query($con,$sql);
    
      if(mysqli_num_rows($result) > 0)
      {
        $aiowner = @mysqli_fetch_assoc($result) ;

        $sql = " Select count(ipaddress) as totalips from partners_ipstats where ownerid = '$ownerid' ";

        $result  = @mysqli_query($con,$sql);

        $ipstatsCount = @mysqli_fetch_assoc($result) ;

        $newcount =  $ipstatsCount["totalips"]  ;
        $sql = " Update partners_aiowner set count = '$newcount' where id = '$ownerid' ";
      
        @mysqli_query($con,$sql);


        $sql = " Insert into partners_owner_auid_ip (ownerid, auidid, ipid ) values ($ownerid, $auidid,  $ipid) ";
		@mysqli_query($con,$sql);

		$oaiid = mysqli_insert_id($con);


    
      
    $relatedOwnerIds = "";
		$fromDate = date("Y-m-d", strtotime("-30 days"));
		$toDate =  date("Y-m-d", strtotime("+1 day"));

    $relatedOwnerIdSql = " Select GROUP_CONCAT(distinct tb.ownerid) relatedownerids from partners_owner_auid_ip ta, partners_owner_auid_ip tb where ta.auidid = tb.auidid and ta.ownerid= ".$ownerid." and tb.ownerid <> ".$ownerid;

    $relatedOwnerIdResultObj = mysqli_query($con, $relatedOwnerIdSql);

    if(mysqli_num_rows($relatedOwnerIdResultObj) > 0)
    {
        $relatedOwnerIdResult = mysqli_fetch_assoc($relatedOwnerIdResultObj);
        if($relatedOwnerIdResult["relatedownerids"] != NULL)
        {
          $relatedOwnerIds = $relatedOwnerIdResult["relatedownerids"];

          if($relatedOwnerIds != "")
          {
            $relatedOwnerIds = getRelatedOwnerIds($ownerid, $relatedOwnerIds, $con);
          }
        }
    }

  
    

		$sql = " Select count(id) as total from partners_owner_auid_ip where ownerid = $ownerid and createdate between '$fromDate' and '$toDate' ";
    
    if($relatedOwnerIds != "")
    {
      $sql = " Select count(id) as total from partners_owner_auid_ip where ownerid in ($ownerid,$relatedOwnerIds)  and createdate between '$fromDate' and '$toDate' ";
    }

    //echo $sql;

		$result  = @mysqli_query($con,$sql);

		if(mysqli_num_rows($result) > 0)
    {
      		$ownerIPResult = mysqli_fetch_assoc($result);

      		//echo  " interactCount: ".$interactCount;
      		//echo  " ownerIPResult: ".$ownerIPResult["total"];

      		if($ownerIPResult["total"] > $interactCount)
      		{
      			$sql = " Insert into partners_alerts (mid, alerttype, ownerid, ipid, auidid, orderid, oaiid, status, analyticsid) ";
      			$sql.= " values ( '$mid', '2', '$ownerid', '$ipid', '$auidid', '$orderId', '$oaiid', 1, '$analyticsid'  ) ";
      			//echo $sql;
      			@mysqli_query($con,$sql);

      			$dailyAlerts = 1;

      			if($useremail != "")
      			{

              $av_company =  get_user_info($mid,'av_company',true); 

      				$alertdata["alerttype"] = "Excesive Usage";
      				$alertdata["orderid"] = $orderId;
      				$alertdata["auidid"] = $auidid;
              $alertdata["company"] = $av_company;


      				
      				alert_email($useremail, $alertdata, 21);
      			}
      		}
      	}
      }
   }


   // Update daily statistics 

  $sql = " Select * from partners_aidailystats where mid = '".$mid ."' and date = '".$presentDate."' ";
  $result = mysqli_query($con,$sql);

  if(mysqli_num_rows($result) > 0)
  {
    $row = mysqli_fetch_assoc($result) ;
     
    $dailyTransactions = $row["transactions"] + 1;
    $dailySales = $row["sales"] + $sale;
    $dailyPostage = $row["postage"] + $postage;
    $dailyTaxCosts = $row["tax"] + $taxcosts;
    $dailyAlerts = $row["alerts"] + $dailyAlerts;


    $sql = " Update partners_aidailystats set transactions = '$dailyTransactions', sales = '$dailySales', postage = '$dailyPostage', tax = '$dailyTaxCosts ', alerts = '$dailyAlerts' where mid = '".$mid ."' and date = '".$presentDate."' ";
    //echo $sql;

    mysqli_query($con,$sql);    

  }
  else
  {
     $sql = " insert into partners_aidailystats (mid, date, transactions, sales, postage, tax, alerts )  ";
     $sql.= " values ($mid, '".$presentDate."', 1, '$sale', '$postage', '$taxcosts', $dailyAlerts  ) ";

     //echo $sql; 

     mysqli_query($con,$sql);
  }



   $response["auidid"] = $auidid;
   $response["auid"] = $auid;
   $response["trafficSource"] = $trafficSource;
   $response["redirectURL"] = $redirectURL;

   $t = microtime(true);
  $micro = sprintf("%06d",($t - floor($t)) * 1000000);
  $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );


   $response["endtime"] = $d->format("Y-m-d H:i:s.u");

  echo json_encode($response);

//writeToLog($requestName, "End", getCurrentTime());

 

  function InsertAiInfo($transactionId)
  {
    $con = $GLOBALS["con"];

    $querystring = mysqli_real_escape_string($con,$_SERVER["QUERY_STRING"]);
    $remoteaddr = mysqli_real_escape_string($con,$_SERVER["REMOTE_ADDR"]);
    $serveraddr = mysqli_real_escape_string($con,$_SERVER["SERVER_ADDR"]);
    $cookie = mysqli_real_escape_string($con,$_SERVER["HTTP_COOKIE"]);
    $language = mysqli_real_escape_string($con,$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
    $referrer = mysqli_real_escape_string($con,$_SERVER["HTTP_REFERER"]);
    $useragent = mysqli_real_escape_string($con,$_SERVER["HTTP_USER_AGENT"]);


    $sql = " Insert into partners_aitrackinginfo (transactionid, querystring, remoteaddr, serveraddr, cookie, language, referrer, useragent) ";
    $sql.= " values ($transactionId, '$querystring', '$remoteaddr', '$serveraddr', '$cookie', '$language', '$referrer', '$useragent' ) "; 

    mysqli_query($con,$sql) ;

  }


	  function getOS($user_agent) { 

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser($user_agent) {

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}

function writeToLog($requestName, $type, $time){

  $log  = $requestName." >> ".$type." >> ".$time."\r\n\r\n";
  //Save string to log, use FILE_APPEND to append.
  file_put_contents('./log/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

}

function writeToError($errorMessage){

  file_put_contents('./log/error_'.date("j.n.Y").'.log', $errorMessage, FILE_APPEND);

}

function createRandomPassword() { 

    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 10) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 

} 

function getCurrentTime(){
  $t = microtime(true);
  $micro = sprintf("%06d",($t - floor($t)) * 1000000);
  $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
  return $d->format("Y-m-d H:i:s.u");
}

?>