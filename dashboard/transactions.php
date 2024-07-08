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
Below you see a list of TRANSACTIONS please check each transaction carefully. Once you have reported a transaction as FRAUD it cannot be undone.<br>
* = Location is an estimate.

 			</div>
 			<div class="text-center">

 				<h2>Transactions</h2>
 				<p class="lead">The below table shows transactions from various Owner Ids</p>
 			</div>

      <div class="row" style="margin-bottom: 20px; padding: 10px;">
          <div class="col-md-4" >
              
                 <input placeholder="Order Id"   type="text" name="orderid" id="txtOrderId" class="form-control"  value=""/>
          </div>
          <div class="col-md-4" >
              <button id="btnSearchTransaction" type="button" class="btn btn-default">Search</button> 
          </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <h3 class="visualizeyoursearch">Visualize your search</h3>
        </div>
        <div class="col-md-6">
          <h4 class="head-block grey-bg">OS Analysis</h4>
          <div id="divOSChartContainer" style="height: 300px;">
          </div>
        </div>
        <div class="col-md-6">
          <h4 class="head-block grey-bg">Browser Analysis</h4>
          <div id="divBrowserChartContainer" style="height: 300px;">
          </div>
        </div>
      </div>

 			<div class="row">
 				<div class="col-md-12 order-md-2 mb-4" >
 					<div id="divTransactions">
 					</div>
 					<div id="divPagination">
                  	</div>
 				</div>

 			</div>

 		</div>
 	</div>
 </div>


 

  <script type="text/javascript" src="/js/handlebars.js"></script>
  <script type="text/javascript" src="js/transactions.js"></script>
 
<style>
  h3.visualizeyoursearch{
    margin-bottom: 20px;
    border-bottom: 1px solid #1e1b1c;
    color: #231f20;
    position: relative;
  }

  .head-block.grey-bg {
      background-color: #e7e7e8;
      padding: 10px;
      position: relative;
  }
</style> 
<script type="text/javascript">
 	$(document).ready(function(){

 		
 		Transactions.Common.Init()
 		

 	});

 </script>

 <script id="transactions-template" type="text/x-handlebars-template">

 						<div class="table-responsive">
 							<table class="table table-striped table-sm">
 								<thead>
 									<tr>
 										<th>Date</th>
 										<th>ID </th>
 										<th>User Id</th>
 										<th>OS</th>
 										<th>Browser</th>
                    <th>Cart ID</th>
                    <th>Order ID</th>
 										<th>Products</th>
                    <th>Amount</th>
                    <th>Tax</th>
                    <th>Postage</th>

 										<th></th>

 									</tr>
 								</thead>
 								<tbody>
 									{{#each this}}
						                    <tr>
						                    	<td>{{createdate}}</td>
						                        <td>{{id}}</td>
						                        <td>{{auid}}</td>
						                        <td>{{os}}</td>
						                        <td>{{browser}}</td>
						                        <td>{{cartid}}</td>
                                    <td>{{orderid}}</td>
						                        <td>{{productids}}</td>
                                     <td>{{amount}}</td>
                                      <td>{{tax}}</td>
                                       <td>{{postage}}</td>
						                       
						                        <td>
                                      {{#if alertid}}
                                        <a href="index.php?Act=reportfraud&alertid={{alertid}}" >Report Fraud</a>
                                      {{else}}
                                        <a href="index.php?Act=reportfraud&transactionid={{id}}" >Report Fraud</a>
                                      {{/if}}
                                    </td>
				                    </tr>
				                    {{/each}}
 								</tbody>
 							</table>    				
 						</div>  
 </script>

<script id="pager-template" type="text/x-handlebars-template">

  {{#if pager.pages}}
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
          {{/if}}

    </script>