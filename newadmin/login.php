<?php
include('../config.php');
$user = user(); 
if($user == ''){
}
else {
	redirect('index.php');
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

    <!-- Amanda CSS -->
    <link rel="stylesheet" href="assets/css/amanda.css">
  </head>

  <body>

    <div class="am-signin-wrapper">
      <div class="am-signin-box">
        <div class="row no-gutters">
          <div class="col-lg-5">
            <div>
              <h2>CheckAIM<br>
Brand Protection With Power!</h2>
              <!--<p>The Responsive Bootstrap 4 Admin Template</p>
              <p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate.</p>-->
			
            </div>
          </div>
          <div class="col-lg-7">
            <h5 class="tx-gray-800 mg-b-25">Sign In to Admin</h5>
			<?php if(isset($_SESSION['failure'])){
									echo '<p class="alert alert-danger">'.$_SESSION['failure'].'</p>';
									unset($_SESSION['failure']);
			} ?>
			 <form class="m-t-md" action="<?php echo 'controller/login.php'; ?>" method="post">
            <div class="form-group">
              <label class="form-control-label">Email:</label>
              <input type="text" name="username" class="form-control" placeholder="Enter your email address">
            </div><!-- form-group -->

            <div class="form-group">
              <label class="form-control-label">Password:</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password">
            </div><!-- form-group -->
			
			<button type="submit" class="btn btn-block">Sign In</button>
			</form>
          </div><!-- col-7 -->
        </div><!-- row -->
        <p class="tx-center tx-white-5 tx-12 mg-t-15">Copyright &copy; <?php echo date("Y"); ?>. All Rights Reserved. Searlco.COM</p>
      </div><!-- signin-box -->
    </div><!-- am-signin-wrapper -->

    <script src="assets/lib/jquery/jquery.js"></script>
    <script src="assets/lib/popper.js/popper.js"></script>
    <script src="assets/lib/bootstrap/bootstrap.js"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>

    <script src="assets/js/amanda.js"></script>
  </body>
</html>
