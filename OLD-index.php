<?php include('includes/header.php'); 

$submissionid = $_GET['subid'];
$comids = $_GET['cmid'];



$companydata['affiliate_merchant'];
if($fetchpost['compaign_type'] == 'standard'  || $slug == ''){
	$lastidsubidurl = unserialize(base64_decode($submissionid));
 $comid = unserialize(base64_decode($comids));


$companydatas = unserialize(base64_decode(get_config_meta('company_data', $comid, true)));
$companydata  = unserialize($companydatas['config']);


	
	
?>
<style>.msgred{color:red;}</style>
<?php if(isset($_GET['slug'])){ ?>
<div class="container">
<div class="inner_content cus_zindex"> 
	<div class="col-md-6 col-sm-12 col-xs-12">
		<?php 
		if($companydata['description'] != ''){ 
			echo htmlspecialchars_decode(stripslashes($companydata['description']));
		}else{ ?>
			<div class="inner_easy_left">
			<div class="text-center">
				<h4>It's As Easy As 1 - 2 - 3</h4>
			</div>	
				<div class="row common_easyway">
					<div class="col-md-5 col-sm-5 col-xs-5 wd100_xs">
						<div class="easy_left_img">
							<img src="img/simply_img.jpg" alt="">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-7 wd100_xs">
						<div class="easy_rgt_txt">
							<span>1</span>
							<h3>Simply</h3>
							<p>Browse as usual nd see our deals appear </p>
						</div>
					</div>  
				</div>
				<div class="row common_easyway">
					<div class="col-md-5 col-sm-5 col-xs-5 wd100_xs">
						<div class="easy_left_img">
							<img src="img/more_img.jpg" alt="">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-7 wd100_xs">
						<div class="easy_rgt_txt">
							<span>2</span>
							<h3>More</h3>
							<p>Your favourite brands with great savings</p>
						</div>
					</div>
				</div>
				<div class="row common_easyway"> 
					<div class="col-md-5 col-sm-5 col-xs-5 wd100_xs">
							<div class="easy_left_img">
							<img src="img/rewarding_img.jpg" alt="">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-7 wd100_xs">
						<div class="easy_rgt_txt">
							<span>3</span>
							<h3>Rewarding</h3>
							<p>Get Cashback</p>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	
	<?php
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
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
            $browser_name = $value;
	?>
	<?php $getscrsize = '<div id="getid"></div>';

	   $lencodesize = base64_encode(serialize($getscrsize));
		
		
	?>
	<div class="col-md-6 col-sm-12 col-xs-12 border_line">
		<div class="inner_form_rgt">
			<div class="text-center">
			
			<?
			
			?>
				<h4><?php if($companydata['form_title'] != ''){ echo $companydata['form_title']; } else{ ?>JOIN AVAZ TODAY <?php } ?></h4>
				<p><?php if($companydata['form_description'] != ''){ echo $companydata['form_description']; } else{ ?>JOIN AVAZ TODAY <?php } ?></p>
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
			?>	<?php
			
			$datacom = $companydata['affiliate_merchant'];
		//<img src="https://avaz.co.uk/trackingcode_lead.php?mid=3&sec_id=M_32iZ5hJ4bS0f&orderid="{ORDERID}"" height="1" width="1" alt="">
			//$patterns = array();
			//$patterns[0] = '{ORDERID}';

			//$replacements = array();

			//$replacements[0] = $lastidsubidurl;
			//echo $patternsoutput =  preg_replace($patterns, $replacements, $datacom);
			
			
			//$patterns = (explode(" ",$datacom));
			//$dsfsdf =$patterns[1]; 

			//Input:  $subjectVal  = "It was nice meeting you. May you shine brightly."
				$output =  str_replace('{ORDERID}', $lastidsubidurl, $datacom)
				

				 
				// $string = 'April 15, 200sdsds3';
				
				
			//	$pattern = '"{ORDERID}"'
				//$replacement = "123";
				//echo preg_replace($pattern, $replacement, $datacom);
			
			
						 
			
		?>
			
			
			    <div class="hidden"><?php echo $output; ?></div>
				<div class="form-group">
					<label>First Name</label>
					<input type="text" name="first_name" class="form-control" placeholder="Please Enter Your First Name" />
					<input type="hidden" name="os_platform" value="<?php echo $os_platform ?>" class="form-control"/>
					<input type="hidden" name="browser_name" value="<?php echo $browser_name ?>" class="form-control"/>
					<input type="hidden" name="getsizepost" value="<?php echo $widthscreen ?>" class="form-control getsizexpost"/>
					
					
					
				</div>
				<div class="form-group">
					<label>Last Name</label>
					<input type="text" name="sur_name" class="form-control" placeholder="Please Enter Your Surname" />
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
					<label><?php echo $companyquestiondata[$is]['question_name']; ?></label>
					<select required class="form-control" name="av_question1[<?php echo $companyquestiondata[$is]['question_name']; ?>]">
						<option value="">Please Select</option>
						<?php for($i =0; $i< count($companyquestionoptiondata[$is]); $i++){ ?>
						<option value="<?php echo $companyquestionoptiondata[$is][$i]['question_option']; ?>"><?php echo $companyquestionoptiondata[$is][$i]['question_value']; ?></option>
						<?php } ?>
					</select>
				</div>
				<?php } } ?>
				<?php for($i =0; $i< count($companydata['question_info']); $i++){?>
					<div class="form-group">
					<label><?php echo $companydata['question_info'][$i]['question_name']; ?></label>
					<input required type="text" name="av_question2[<?php echo $companydata['question_info'][$i]['question_name']; ?>]" class="form-control" placeholder="Please Enter Your Answer" />
				</div>
				<?php } ?>
				
				<div class="form-group text-center">
					<input type="submit" name="join_avaz" class="submit_btn" Value="Submit" />
				</div>
			</form> 
		</div>	
	</div>
	<div class="clearfix"></div>
	</div> 
	</div>	
<?php }else{
	?> 
	<div class="container-fluid pad0">
			<div class="inner_content cus_zindex full-slider"> 
			<?php include('includes/section_carousel.php'); ?>
		</div>
	</div><br><br><br><br>
	<?php
} ?>

<div class="container"> 	
<?php include('includes/footer.php'); }else if($fetchpost['compaign_type'] == 'custom'){
	if($companydata['description'] != ''){ 
			echo str_replace('{AVAZ-FORM}',avaj_form($slug),htmlspecialchars_decode(stripslashes($companydata['description'])));
	}
	?>
	<script src="js/jquery.min.js"></script>
	<script>jQuery(document).ready(function($){
						var width = $(window).width();
						var height = $(window).height();
						var widthscreen = width + ' X ' + height;
						$('.getsizexpost').val(widthscreen);
						
						<?php

						if($slug != '' && leaduserinfo('type') == 3 && $leadgenid != ''){
						
						?>
						var width = $(window).width();
						var height = $(window).height();
						$.ajax({

						url: '<?php echo SITEURL; ?>ajaxfile.php',
						data: {width:width,height:height,campid:<?php echo $comid; ?>},
						type: 'POST',
						
						success: function(response){
						
						}
				});
			<?php } ?>
						
						  });
						  
	</script>
	<?php
}else if($fetchpost['compaign_type'] == 'slide_up'){
?>
<html>
	<head>
	<title>AvazAI – Lead Generation With Power! </title>
	<link href="css/slide_up.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet">
	<style>
		#ulp-layer-555 { background-image: url(<?=SITEURL.'img/backimg/'.$companydata['background_image']?>);}
	</style>
	<style>
 form input[type="submit"]{background: #<?php  if($companydata['form_button_color'] != ''){ echo $companydata['form_button_color']; }else{ echo 'D3D3D3'; } ?>;border: 1px solid #<?php  if($companydata['form_button_color'] != ''){ echo $companydata['form_button_color']; }else{ echo 'f7931e'; } ?>;}
 form input[type="submit"]:hover{border: 1px solid #<?php  if($companydata['form_button_hover_color'] != ''){ echo $companydata['form_button_hover_color']; }else{ echo 'f7931e'; } ?>;background: #<?php  if($companydata['form_button_hover_color'] != ''){ echo $companydata['form_button_hover_color']; }else{ echo 'f7931e'; } ?>;}

.border_line:before {background: #<?php if($companydata['border_color'] != ''){ echo $companydata['border_color']; }else{ echo 'f7931e'; } ?> url(img/border_trans_line.png) no-repeat;}
<?php
if($companydata['background_image'] != ''){
	$imagesback = 'img/backimg/'.$companydata['background_image'];
}else{
	$imagesback = "img/joinnow-back.jpg";
}
?>

	.wrapper{background:url(<?php echo SITEURL.$imagesback; ?>) no-repeat;position:relative;background-size: cover;background-position: center;}

</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
	<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
	</head>
	<body>
		<div class="ulp-overlay ulp-animated ulp-fadeIn" id="ulp-dST25dQgDqXbdYlY-overlay" style="display: block;"></div>
		<div class="ulp-window-container" onclick="jQuery('#ulp-dST25dQgDqXbdYlY-overlay').click();">
				<div class="ulp-window ulp-window-middle-center" id="ulp-dST25dQgDqXbdYlY" data-title="Popup # 24728" data-width="720" data-height="500" data-position="middle-center" data-close="on" data-enter="on" onclick="event.stopPropagation();" style="transform: translate(-50%, -50%) scale(0.824); display: block;">
					<div class="ulp-content" style="">
						<div class="ulp-layer" id="ulp-layer-555" data-left="0" data-top="40" data-appearance="fade-in" data-appearance-speed="1000" data-appearance-delay="0" data-scrollbar="off" data-confirmation="off" style="left: 0px; top: 40px; display: block;"></div>
						<div class="ulp-layer poprigth" style="animation-duration: 1000ms; opacity: 0; left: 365px;     bottom: -138%;display: block;">
						
						<div id="ulp-layer-557" ><?php echo $companydata['form_title']; ?></div>
						<div  id="ulp-layer-559" ><i class="fa fa-bar-chart"></i></div>
						<div  id="ulp-layer-560"><?php echo $companydata['form_description']; ?></div>
						<div class="ulp-layer" id="ulp-layer-560" ><?php echo avaj_form($slug) ?></div>
						
						</div>
					</div>
				</div>
			</div>
			<script>
														jQuery(document).ready(function() {
														$('.poprigth').animate({ opacity: 1, top: "-10px" }, 1500);
														});

														</script>
	</body>
</html>

<?php
}	?> 



