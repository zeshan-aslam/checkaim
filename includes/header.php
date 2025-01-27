<?php
include('config.php');

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>CheckAIM - Protecting Against Fraud With AI Power</title>
		<!-- Loading third party fonts -->
		
		<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- Loading main css file -->
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		  
  		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,600i,700,700i,900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="style.css?v=26thApril2020">
		
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" rel="stylesheet" />
		
		
		<!--[if lt IE 9]>
		<script src="js/ie-support/html5.js"></script>
		<script src="js/ie-support/respond.js"></script>
		<![endif]-->

	</head>


	<body>
		
		<div id="site-content">

			<header class="site-header">
				<div style="width: 100%; height: 50px; text-align: center; color: #fff; background-color: #000; line-height: 50px;">
			<p style="font-size: 30px; font-weight: bold;">TRY IT FREE UNTIL 2022</p>
		</div>
				<div class="container">
					<nav class="navbar navbar-expand-md">
					  <!-- Brand -->
					  <div class="col-md-4 col-sm-12 col-lg-4">
					 		<a href="/" id="branding"><img src="/images/logo-checkaim.png" alt="checkaim" class="logo"></a> <!-- #branding -->
					  </div>
					  <div class="col-md-8 col-sm-12 col-lg-8">
					  <!-- Toggler/collapsibe Button -->
						  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
						    <img src="images/ui.png">
						  </button>
						  <?php

						    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
						  	$navPageUrl =  $curPageName == "index.php" ? "" : "/index.php";

						  ?>

						  <!-- Navbar links -->
						  <div class="collapse navbar-collapse menu-link pull-right" id="collapsibleNavbar">
						    <ul class="navbar-nav">
							  <li class="nav-item">
						     	<a href="<?php echo $navPageUrl; ?>#about" class="" >About Us</a>
						      </li>
						      <li class="nav-item">
						        <a href="<?php echo $navPageUrl; ?>#price" class="" >Price</a>
						      </li>
						      <li class="nav-item">
						      	<a href="#" class="" data-toggle="modal" data-target="#tc-model">Terms & conditions</a>
						      </li>
							  <li class="nav-item">
						      	<a href="#" class="" data-toggle="modal" data-target="#contact-model">Contact us</a>
						      </li>
							   <li class="nav-item">
						      	<a href="#" class="login-btn" data-toggle="modal" data-target="#login-model">Login</a>
						      </li>
							  <li class="nav-item">
						      	<a href="signup.php" class="signup-btn" >Signup</a>
						      </li>
						    </ul>
						  </div>
					  </div>
					</nav>
				</div> <!-- .container -->
			</header> <!-- .site-header -->