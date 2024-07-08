<?php
include('../config.php');
if(!leadgenuser()){
	redirect(SITEURL);
} 
$Act	= isset($_GET['Act']) ? $_GET['Act'] : '';
 $welcomeflag = 0; 	
if(isset($_SESSION['successlogin'])){
	$welcomeflag = 1; 
	unset($_SESSION['successlogin']);
}
$leadgenid = leaduserinfo('id');


if(get_user_info($leadgenid,'av_Currency',true) == 'GBD') {
	$currSymbol  = "&pound;";
}else if(get_user_info($leadgenid,'av_Currency',true) == 'USD') {
	$currSymbol  = "&dollar;";
}else if(get_user_info($leadgenid,'av_Currency',true) == 'EURO') {
	$currSymbol  = "&euro;";
}
 //if($Act != 'add_money'){ if($welcomeflag == '1'){ balance_warning(); } check_balance_and_action(); } 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CheckAIM Brand Protection With Power!</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" /> 
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
<!-- CSS Files -->
<link href="<?php echo LEADURL; ?>public/assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo LEADURL; ?>public/assets/css/light-bootstrap-dashboard.css.css" rel="stylesheet" />
<link href="<?php echo LEADURL; ?>public/assets/css/demo.css" rel="stylesheet" />
 <link href="<?php echo LEADURL; ?>public/assets/lib/summernote/summernote.css" rel="stylesheet">
<!--<link rel="stylesheet" type="text/css" href="style.css"/>-->

<!--   Core JS Files   -->
<script src="<?php echo LEADURL; ?>public/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script>var is_show_welcome = '<?php echo $welcomeflag; ?>'; </script>
</head>
<body class="<?=$Act?>">
	<div class="wrapper">
		<!-- Sidebar -->
		<?php	include 'includes/sidebar.php';?>
		 <div class="main-panel">
			<!-- Start Navbar -->
			<?php	include 'includes/header.php';?>
			 <!-- End Navbar -->
			<div class="content">
				<?php include "process.php";?> 
			</div>
			<?php include "includes/footer.php";?>
		 </div>
	</div>
	<script>
	  jQuery( function($) {
		   // Summernote editor
        $('#summernote').summernote({
          height: 300,
        });
		$('#summernote1').summernote({
          height: 300,
        });
		$('#summernote2').summernote({
          height: 300,
        });
		$('#summernote3').summernote({
          height: 300,
        });	
		  $('a.tr_clone_text').on('click',function (e) {
			e.preventDefault();
			
			var htmls = $('.tr_row').html();
			$('#servicedynamictables tbody').append('<tr class="row tr_clone_row dynamicrow">'+htmls+'<tr>');
				arrangeSno();
				
			});
			  $('body').delegate('a.tr_clone_select','click',function (e) {
			e.preventDefault();
			
			var htmls = $('.myclonerow').html();
			$('#selectdynamictables').append('<div class="row mg-t-20 dynamicr">'+htmls+'</div>');
				arrangeSnoo1();

			
			});
	
			  $('body').delegate('a.tr_clone_option','click',function (e) {
			e.preventDefault();
				var att = $(this).attr('id');
				var htmls = $('.tr_my_row').html();
				$('.showw-'+att+' .optiontable tbody').append('<tr class="row tr_clone_rows dynamicrow">'+htmls+'</tr>');
					 
				arrangeSnooop(att);
			});
			$('body').delegate('a.ser_tr_clone_remove','click',function (e) {
		e.preventDefault();
		
		$(this).closest('tr').remove();
		 arrangeSno();
	});	
	$('body').delegate('a.option_tr_clone_remove','click',function (e) {
		e.preventDefault();
		var att = $(this).attr('id');
		$('.'+att).remove();
		arrangeSnoo1();
	});
	
	function arrangeSno()
	{
		var i=1;
		var x = 0; 
		var xs = x + 1;
		$('#servicedynamictables tbody tr.dynamicrow').each(function() {
		$(this).find(".order").html(i);
		$(this).find(".order").attr('id',i);
		$(this).find("#name").attr('name',"question["+x+"][question_name]");
		
		
		i++;
		x++;
		xs++;
		});
	}
	
	function arrangeSnoo1()
	{
		var i=1;
		var x = 0; 
		var xs = x + 1;
	$('#selectdynamictables div.dynamicr').attr('class', function(i, c){
    return c.replace(/(^|\s)showw-\S+/g, '');
});
		$('#selectdynamictables div.dynamicr').each(function() {

			$(this).addClass( 'showw-'+x );
			$(this).find(".tr_clone_option").attr('id',x); 
			$(this).find(".option_tr_clone_remove").attr('id','showw-'+x); 
			$(this).find("#dropname").attr('name',"dropquestion["+x+"][question_name]");
			arrangeSnooop(x);
		i++;
		x++;
		xs++;
		});
		
		
	}
	

	
	function arrangeSnooop(id)
	{
		var i=1;
		var x = 0; 
		var xs = x + 1;
		$('.showw-'+id+' #optiontable tbody tr.dynamicrow').each(function() {
		$(this).find(".option").attr('name','dropopt['+id+']['+x+'][question_option]'); 
		$(this).find(".value").attr('name','dropopt['+id+']['+x+'][question_value]'); 
		
		i++;
		x++;
		xs++;
		});	
	}
			$('#companyname').on('keyup', function(){
				var name = $(this).val();
				$.ajax({
				url: 'controller/save_config.php',
				type: 'post', 
				data: {comname:name,action:'checkcompany'},
				success: function(html){
					obj = JSON.parse(html);
					if(obj.exist){
						$('.show_message').html('Company Name already exist');
						$('.show_message').css('color','red');
						$('#subpos').prop('disabled',true);
					}else{
						$('.show_message').html('Company Name is available');
						$('.show_message').css('color','green');
						$('#subpos').prop('disabled',false);
					}
				}
				});
			});
			$('#removeimg').on('click', function(e){
				e.preventDefault();
				$('#showimgs').remove();
				$('#removeimg').remove();
				$('#imageva').val('');
			});
		});
function showcustomSwal(url){
	swal({
	title: '',
	html: '<iframe src="<?php echo SITEURL.'viewtemp.php';?>?aslug='+url+'"></iframe>'
});
}		
	  </script>
</body>
</html>