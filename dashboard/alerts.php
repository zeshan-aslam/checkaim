 <?php

#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------

 $mid =  leaduserinfo('id'); ;


 $auidid = 0;
 $ownerid = 0;

 if(isset($_GET["auidid"]))
 {
 	$auidid = $_GET["auidid"];
 }

 if(isset($_GET["ownerid"]))
 {
 	$ownerid = $_GET["ownerid"];
 }

 $isdetails = false;


 $sql = " Select a.*, ips.ipaddress, pauid.auid from partners_alerts a left join partners_ipstats ips on a.ipid = ips.id  ";
 $sql.= " left join partners_auid pauid on pauid.id = a.auidid ";
 $sql.= "  where mid = '".$mid."' order by alertid desc LIMIT 10";



 

 ?>  
 

 <div class="row">
 	<div class="col-md-12">
 		<div class="card stacked-form trackcode_form">
 			<div class="card-body">
Below you see a list of ALERTS please check each transaction carefully. Once you have selected an action (FRAUD/DISMISS) it can not be undone.<br>
* = Location is an estimate.

 			</div>
 			<div class="text-center">

 				<h2>Alerts</h2>
 				<p class="lead">The below table shows alerts from various Owner Ids</p>
 			</div>

 			<div class="row">
 				<div class="col-md-12 order-md-2 mb-4" >
 					<div id="divAlerts">
 					</div>
 					<div id="divPagination">
                  	</div>
 				</div>

 			</div>

 		</div>
 	</div>
 </div>
 <?php

 	$secretkey = leaduserinfo('secretkey');

 	$alertfrom = date ("Y-m-d", strtotime('-30 days') );
	$alertto = date ("Y-m-d", strtotime('today') );

	$alertlink = "https://checkaim.com/alertapi.php?key=$secretkey&from=$alertfrom&to=$alertto";

 ?>
 <div class="row">
	<div class="col-md-12">
		<div class="card stacked-form">
			<div class="card-header">
				<h4 class="card-title">Alerts API Link</h4>
			</div>
			<div class="card-body">
				<div class="form-group text-center">
					Copy the following URL to get your transaction history for last 30 days				</div>
			</div>
			<div class="card-body">
				<div class="form-group text-center">
					<a href="<?php echo $alertlink; ?>"><?php echo $alertlink; ?></a>
				</div>
			</div>
		</div>
	</div>
</div>


 <section id="modalAlertDetails" class="modal" tabindex="-1" role="dialog" data-backdrop="false" style="text-align: left;">
 	<div class="modal-dialog modal-lg" role="document">
 		<div class="modal-content">
 			<div class="modal-header">
 				<h5 class="modal-title">Alert Details</h5>
 				<button type="button" class="btnclosemodal" data-dismiss="modal" aria-label="Close">
 					<span aria-hidden="true">&times;</span>
 				</button>
 			</div>
 			<div class="modal-body" id="divAlertDetails">

 			</div>
 		</div>
 	</div>
 </section>

  <script type="text/javascript" src="/js/handlebars.js"></script>
  <script type="text/javascript" src="js/alerts.js"></script>
 <script type="text/javascript">

 	function changeAlertStatus(alertId, alertstatus, analyticsid)
 	{
 		$.post( "/controller/alerts.php",
 				{ 
 					'alert_change_status':"yes",
 					'alertid': alertId,
 					'alertstatus': alertstatus
 				},
 					function(response){

 							console.log(response);

 							if(response != null)
 							{
 								$(".btnalertaction").remove();

 								if(response.reportfraud)
 								{
 									window.location.href = "index.php?Act=reportfraud&alertid="+alertId;
 								}
 								else
 								{
 									Alerts.Action.GetAlerts();
 								}

 								
 							}


 					},
 					  "json"
 				

		);
 	}

 	$(document).ready(function(){

 		
 		Alerts.Common.Init()
 		

 	});

 </script>

 <script id="alerts-template" type="text/x-handlebars-template">

 						<div class="table-responsive">
 							<table class="table table-striped table-sm">
 								<thead>
 									<tr>
 										<th>Date</th>
 										<th>Device ID </th>
 										<th>Order Id</th>
 										<th>Alert Type</th>

 										<th>LOCATION*</th>
 										<th>USER ID </th>

 										<th>Status</th>
 										<th></th>

 									</tr>
 								</thead>
 								<tbody>
 									{{#each this}}
						                    <tr>
						                    	<td>{{createdate}}</td>
						                        <td>{{auid}}</td>
						                        
						                        <td>{{orderid}}</td>
						                        <td>{{alerttypename}}</td>
						                        <td>{{city}} {{region}}</td>
						                        <td>{{auid}}</td>
						                        <td>{{alertstatusname}}</td>
						                       
						                        <td><a data-alertid="{{alertid}}" href="javascript:void(0)" data-toggle="modal" data-target="#modalAlertDetails" >Details</a></td>
				                    </tr>
				                    {{/each}}
 								</tbody>
 							</table>    				
 						</div>  


 </script>

 <script id="alertdetails-template" type="text/x-handlebars-template">


 				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6">
							Alert Id: {{this.alertid}}
						</div>
						<div class="col-md-6">
 							{{#if showactions}}
 							<button onclick="changeAlertStatus({{this.alertid}}, 3, {{this.analyticsid}})" type="button" class="btn btn-danger btnalertaction">Fraud</button> 
 							<button onclick="changeAlertStatus({{this.alertid}}, 2, {{this.analyticsid}})"  type="button" class="btn btn-success btnalertaction">Dismiss</button>
 							{{/if}}
 						</div>
					</div>
 					<div class="row">
 						<div class="col-md-6">Type: {{alerttype}}</div>
 						<div class="col-md-6">{{createdate}}</div>
 					</div>
 					<div class="row">
 						<div class="col-md-6">Order Id: {{orderid}}</div>
 						<div class="col-md-6">User Id: {{userid}}</div>
 						
 						
 					</div>
 					
 					
 					<div class="row">
 						<div class="col-md-6"><strong>Values</strong></div>
 						<div class="col-md-6"><strong>Device Details</strong></div>
 					</div>
 					<div class="row">
 						<div class="col-md-6">
 							Product Ids: {{productids}}<br/>
 							Amount: {{amount}}<br/>
 							Postage: {{postage}}<br/>
 							Tax: {{tax}}<br/>
 							Currency: {{currency}}<br/>
 							Keyword: {{keyword}}<br/>
 							Traffic Source: {{trafficsource}}<br/>
 						</div>
 						<div class="col-md-6">
 							Browser: {{browser}}<br/>
 							OS: {{os}}<br/>
 							Device ID: 400<br/>
 							Location: {{city}} {{region}} {{country}}*<br/>
 							Referer: {{referer}}<br/>
 						</div>
 					</div>
 					<div class="row">
 						<div class="col-md-12">
 							<strong>Related Transactions</strong>
 						</div>
 						<div class="col-md-12">

 							<div class="table-responsive">
	 							<table class="table table-striped table-sm">
	 								<thead>
	 									<tr>
	 										
	 										<th>Order Id</th>
	 										<th>Date</th>
	 										<th>Amount</th>
	 										<th>Device Id</th>
	 										<th>Browser </th>
	 										<th>OS</th>
	 										
	 										<th>Location</th>

	 									</tr>
	 								</thead>
	 								<tbody>

	 										{{#each relatedtransations}}
						                    <tr>
						                        <td>{{orderid}}</td>
						                        <td>{{createdate}}</td>
						                        <td>{{amount}}</td>
						                        <td>{{deviceid}}</td>
						                        <td>{{browser}}</td>
						                        <td>{{os}}</td>
						                        <td>{{city}} {{region}} {{country}}</td>
						                        
						                        
						                    </tr>
						                    {{/each}}

	 									
	 								</tbody>
	 							</table>    				
 							</div>  
 							
 						</div>
 					</div>

 					<div class="row">
 						<div class="col-md-12">
 							<strong>User Details:</strong>
 						</div>
 						<div class="col-md-12">
 							User Devices: {{userdetails.totaldevices}}<br/>
 							Transactions: {{userdetails.totaltransactions}}<br/>
 							Excessive Use Alerts: {{#each userdetails.excessiveusealerts}} {{statusname}} ({{total}}) {{/each}}
 							
 						</div>
 					</div>
 				</div>
</script>

<script id="pager-template" type="text/x-handlebars-template">

      <nav aria-label="Page navigation">
            <ul class="pagination">
              <li>
                <a href="javascript:void(0)" class="previous" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              {{#each pager.pages}}
              <li {{#if iscurrent}} class="active" {{/if}} ><a href="javascript:void(0);" data-pageno="{{pageno}}" class="pageno" >{{pageno}}</a></li>
              {{/each}}
              <li>
                <a href="javascript:void(0)" aria-label="Next" class="next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>

    </script>