<?php 
include('../config.php'); 
$user = user();
if($user == ''){
	redirect('login.php');
}
$login_success = 0;
if(isset($_SESSION['login'])){
	$login_success = 1;
	unset($_SESSION['login']);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>CheckAIM – Brand Protection With Power!</title>

    <!-- vendor css -->
    <link href="assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/lib/jquery-toggles/toggles-full.css" rel="stylesheet">
  <link href="assets/lib/summernote/summernote.css" rel="stylesheet">
  <link href="assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
  <link href="assets/lib/jquery-ui/jquery-ui.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <link href="publicadmin/assets/css/light-bootstrap-dashboard.css.css" rel="stylesheet" />
<link href="publicadmin/assets/lib/summernote/summernote.css" rel="stylesheet">


	<!-- Amanda CSS -->
    <link rel="stylesheet" href="assets/css/amanda.css">
  </head>
<body>
	<div class="am-header">
      <div class="am-header-left">
        <a id="naviconLeft" href="" class="am-navicon d-none d-lg-flex"><i class="icon ion-navicon-round"></i></a>
        <a id="naviconLeftMobile" href="" class="am-navicon d-lg-none"><i class="icon ion-navicon-round"></i></a>
        <a href="index.php" class="am-logo">CheckAIM – Brand Protection With Power!</a>
      </div><!-- am-header-left -->

      <div class="am-header-right">
       
        <div class="dropdown dropdown-profile">
          <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            <span class="logged-name"><span class="hidden-xs-down">Admin</span> <i class="fa fa-angle-down mg-l-3"></i></span>
          </a>
          <div class="dropdown-menu wd-200">
            <ul class="list-unstyled user-profile-nav">
             <!--<li><a href=""><i class="icon ion-ios-person-outline"></i> Edit Profile</a></li>-->
              <li><a href="settings.php"><i class="icon ion-ios-gear-outline"></i> Settings</a></li>
			    <li><a href="masteradmin.php"><i class="icon ion-person-stalker"></i> Admin Setup</a></li>
              <li><a href="logout.php"><i class="icon ion-power"></i> Sign Out</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </div><!-- am-header-right -->
    </div><!-- am-header -->
	