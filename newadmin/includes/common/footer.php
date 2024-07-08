<div class="am-footer">
        <span>Copyright &copy; <?php echo date("Y"); ?>. All Rights Reserved. Searlco.COM</span>

      </div><!-- am-footer -->
    </div><!-- am-mainpanel -->
	<script src="assets/lib/jquery/jquery.min.js"></script>
	<script src="assets/lib/popper.js/popper.js"></script>
	<script src="assets/lib/bootstrap/bootstrap.js"></script>
	
	<script src="js/demo.js"></script>
	<script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="assets/lib/jquery-toggles/toggles.min.js"></script>
	<script src="assets/lib/d3/d3.js"></script>
	<script src="assets/lib/summernote/summernote.min.js"></script>
	<script src="assets/lib/datatables/jquery.dataTables.js"></script>
    <script src="assets/lib/datatables-responsive/dataTables.responsive.js"></script>
    <script src="assets/lib/jquery-ui/jquery-ui.js"></script>
	<script src="assets/js/amanda.js"></script>
	<script src="assets/js/ResizeSensor.js"></script>
	<script src="assets/js/dashboard.js"></script>
	<script src="assets/js/jscolor.js"></script>
	<script src="assets/js/bootstrap-notify.js"></script>

	<?php

		if(isset($footerscripts))
		{
			if($footerscripts == "dashboard")
			{
	?>
					<!-- Resources -->
				<script src="//www.amcharts.com/lib/4/core.js"></script>
				<script src="//www.amcharts.com/lib/4/charts.js"></script>
				<script src="//www.amcharts.com/lib/4/maps.js"></script>
				<script src="//www.amcharts.com/lib/4/geodata/worldLow.js"></script>
				<script src="//www.amcharts.com/lib/4/themes/animated.js"></script>

				<script src="js/dashboard.js"></script>
				<script>

					$(document).ready(function(){

						Dashboard.Common.Init()

					});

				</script>
	<?php
			}
		}

	?>


	
  </body>
</html>