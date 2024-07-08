<?php 
$postid = isset($_GET['cid']) ? $_GET['cid'] : -1;
$sql = select("joinavaz","id = '$postid' order by date DESC");
$row = fetch($sql);

$av_question1res = get_avaz_info($row['id'],'av_question1res',true);
$av_question2res = get_avaz_info($row['id'],'av_question2res',true);
$res1 = unserialize($av_question1res);
$res2= unserialize($av_question2res);
 ?> 
 <?php //if(isset($_SESSION['successlead']) || isset($_SESSION['faluirelead'])){ ?>
<div class="row">
	<div class="col-md-12">
		<div class="card strpied-tabled-with-hover">
			<div class="card-body">
				<?php if(isset($_SESSION['successlead'])){ ?>
					<p class="alert alert-success"><?php echo $_SESSION['successlead'];?></p>
				<?php unset($_SESSION['successlead']); } ?>
					
				<?php  if(isset($_SESSION['faluirelead']) ){ ?>
					<p class="alert alert-success"><?php echo $_SESSION['faluirelead'];?></p>
				<?php unset($_SESSION['faluirelead']); } ?>
			</div>
		</div>
	</div>
</div>
<?php //} ?>
<div class="row">
	<div class="col-md-6">
		<div class="card strpied-tabled-with-hover">
			<div class="card-body">
				<div class="row">
					<label class="col-sm-4 form-control-label">First Name: </label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo get_avaz_info($row['id'],'first_name',true); ?></span>
					</div>
				</div><!-- row -->
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Last Name: </label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo get_avaz_info($row['id'],'sur_name',true); ?></span>
					</div>
				</div><!-- row -->
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Email: </label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo get_avaz_info($row['id'],'av_email',true); ?></span>
					</div>
				</div><!-- row -->
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Phone Number: </label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo get_avaz_info($row['id'],'av_phone',true); ?></span>
					</div>
				</div><!-- row -->
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Post Code: </label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo get_avaz_info($row['id'],'av_post_code',true); ?></span>
					</div>
				</div><!-- row -->
				<?php foreach($res1 as $key => $val){ ?>
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label"><?php echo $key; ?></label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo $val; ?></span>
					</div>
				</div><!-- row -->
				<?php  }?>

				<?php foreach($res2 as $key1 => $val1){ 
					if($key1 !=0 || $key1 !=''){
				?>
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label"><?php echo $key1; ?></label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo $val1; ?></span>
					</div>
				</div><!-- row -->
					<?php } }?>
					
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Date of Submission</label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo date('d/m/Y', strtotime($row['date'])); ?></span>
					</div>
				</div><!-- row -->	
				<div class="row mg-t-20">
					<label class="col-sm-4 form-control-label">Date of Auto Confirmation</label>
					<div class="col-sm-8 mg-t-10 mg-sm-t-0">
						<span><?php echo date('d/m/Y', strtotime($row['date']. ' +14 days')); ?></span>
					</div>
				</div><!-- row -->	
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card strpied-tabled-with-hover">
			<div class="card-body">
			<form action="../controller/confirmlead.php?cid=<?=$postid?>" method="post">
				<input type="hidden" name="hiddenid" value="<?=$row['id']?>">
				<input type="hidden" name="campid" value="<?=$row['companyid']?>">
				<div class="row">
					<div class="col-md-8">
						<label><input <?php if(get_avaz_info($row['id'],'is_confirmed',true) == 1 || get_avaz_info($row['id'],'is_confirmed',true) == 2){ echo 'disabled'; }?> type="radio" name="is_confirmed" value="1" <?php if(get_avaz_info($row['id'],'is_confirmed',true) == 1 ){ echo 'checked'; }?>> Confirm </label>
						<label><input <?php if(get_avaz_info($row['id'],'is_confirmed',true) == 1 || get_avaz_info($row['id'],'is_confirmed',true) == 2){ echo 'disabled'; }?> type="radio" name="is_confirmed" value="2" <?php if(get_avaz_info($row['id'],'is_confirmed',true) == 2 ){ echo 'checked'; }?>> Cancel </label>
					</div>
					<label class="col-md-4 form-control-label">is this a Confirmed lead?</label>
				</div>
				<?php 
				if(get_avaz_info($row['id'],'is_confirmed',true) != 1 && get_avaz_info($row['id'],'is_confirmed',true) != 2){ ?>
					<div class="row">
						<div class="col-md-4">
							<div class="form_editlink">
								<button type="submit" class="btn btn-fill btn-info" name="save_lead">Submit</button>
							</div>
						</div>
					</div>
				<?php } ?>
			</form>
			</div>
		</div>
	</div>
</div>
