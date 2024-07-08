<div class="am-footer">
        <span>Copyright &copy; <?php echo date("Y"); ?>. All Rights Reserved. Searlco.COM</span>

      </div><!-- am-footer -->
    </div><!-- am-mainpanel -->
	<script src="assets/lib/jquery/jquery.js"></script>
	<script src="assets/lib/popper.js/popper.js"></script>
	<script src="assets/lib/bootstrap/bootstrap.js"></script>
	<script src="publicadmin/assets/js/plugins/chartist.min.js"></script>
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


	<script>
      $(function(){
		  $( "#datepicker" ).datepicker();
        'use strict';
demo.initDashboardPageCharts();
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
		
		 $('#datatable1').DataTable({
          responsive: false,
		  "ordering": false,
		language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });
		
		 $('#datatable2').DataTable({
			 order: [ [ 0, "asc" ] ],
         	responsive: {
		        details: {
		            type: 'column',
		            target: 'tr'
		        }
		    },
		    columnDefs: [ {
		        className: 'control',
		        orderable: false,
		        targets: -1
		    } ],
	

          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });
		
		$('.delcat').on('click', function(){
			var did = $(this).attr('dataid');
			deletetablerow(did,'Are you sure you like to delete Category','category','categories.php');
		});
		$('.delfrm').on('click', function(){
			var did = $(this).attr('datafrmid');
			deletetablerow(did,'Are you sure you like to delete Firmware','firmware','firmware.php');
		});
		function deletetablerows(cust_id,cust_name,tablename,returnurl){ 
			var action ='delete';
			if (confirm(cust_name) == true) {
			$.ajax({
				url: 'controller/save_question.php',
				type: 'post', 
				data: {tableid:cust_id,action:action,table_name:tablename,return_url:returnurl},
				success: function(html){
				//alert(html); 
					window.location='<?php echo ADMINURL?>'+returnurl;
				}
			});
			}else{

			}
		}
      });
	
		function deletetablerow(cust_id,cust_name){
			
			var action ='delete';
			if (confirm(cust_name) == true) {
			$.ajax({
				url: 'controller/save_config.php',
				type: 'post', 
				data: {tableid:cust_id,action:action},
				success: function(html){
				//alert(html); 
					window.location='<?php echo ADMINURL?>';
				}
			});
			}else{

			}
		}
		function deleteuseralldata(cust_id,cust_name){
			
					
			var action ='userdelete';
			if (confirm(cust_name) == true) {
			$.ajax({
				url: 'controller/save_config.php',
				type: 'post', 
				data: {userid:cust_id,action:action},
				success: function(html){
				//alert(html); 
					window.location='<?php echo ADMINURLUSER ?>';
				}
			});
			}else{

			}
		}

    </script>
  </body>
</html>