 <?php

#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------

    $mid =  leaduserinfo('id'); ;

	 
 ?>  

<div class="row">  
	<div class="col-md-12">
		<div class="card stacked-form trackcode_form">
			<div class="card-body">
		In order for us to perform the relevant tracking, this code must be placed be placed on either the confirmation page / completed sale page, or in the case of a publisher/affiliate in the click journey of the active user.<br>
		All transactions will then be recorded and available within the reports.<br>
		PLEASE DO NOT POST PERSONAL INFORMATION OF ANY CUSTOMER<br>
<br>
<b>The Essential Variables</b><br>
orderid = This is the order ID of the transaction that you can use to identify it.<br>
auid = This is the customer account identification (Account Number) relevant to you eg: ABC123<br>
sale = This is the total value of the order less tax eg 12.25<br><br>
<b>The Optional Variables</b><br>
productids = List all product ids of items within the transaction using a seperator eg 112233-223344<br>
postage = Put all details of any postage costs eg 3.99<br>
taxcosts = Place any tax costs such as VAT eg = 12.20<br>
cartid = If you have multiple cart/countries you can place them here eg = UK or 14556.<br>
trafficsource = You can use this to populate eg: Google/Yahoo<br>
keyword = You can populate this eg: "cheap glasses"<br>
<br>
<b>Please copy and paste the below code:</b><br>



		</div>
			<div class="card-body">

				<nav>
				  <div class="nav nav-tabs" id="nav-tab" role="tablist">
				    <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true">All</a>
				    <a class="nav-item nav-link" id="nav-shopify-tab" data-toggle="tab" href="#nav-shopify" role="tab" aria-controls="nav-shopify" aria-selected="false">Shopify</a>
				    <a class="nav-item nav-link" id="nav-woocommerce-tab" data-toggle="tab" href="#nav-woocommerce" role="tab" aria-controls="nav-woocommerce" aria-selected="false">WooCommerce</a>
				    <a class="nav-item nav-link" id="nav-digitalriver-tab" data-toggle="tab" href="#nav-digitalriver" role="tab" aria-controls="nav-digitalriver" aria-selected="false">Digital River</a>
				  </div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
				  <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
				  	
				  	<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><?//=$lang_shoppingCartIntegration?></a>-->
					<h4 class="card-title"><?=$lgetcode_TrackingCodeforLead?></h4>			
					<div class="form-group">
						<textarea rows="10" name="headertxt" class="form-control"><!--START CheckAIM CODE--><img src="https://checkaim.com/secure.php?mid=<?php echo $mid; ?>&orderId={OrderID}&sale={OrderVALUE}&productids={productids}&postage={postage}&taxcosts={taxcost}&cartid={cartid}&auid={auid}&trafficsource={trafficsource}&keyword={keyword}" height="1" width="1" alt=""><!-- END CheckAIM CODE --></textarea>
					</div>

				  </div>
				  <div class="tab-pane fade" id="nav-shopify" role="tabpanel" aria-labelledby="nav-shopify-tab">
				  	
				  	<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><?//=$lang_shoppingCartIntegration?></a>-->
					<h4 class="card-title"><?=$lgetcode_TrackingCodeforLead?></h4>			
					<div class="form-group">
						<textarea rows="10" name="headertxt" class="form-control"><!--START CheckAIM CODE--><img src="https://checkaim.com/secure.php?mid=<?php echo $mid; ?>&orderId={{ order_number }}&sale={{ subtotal_price | money_without_currency }}&productids={productids}&postage={postage}&taxcosts={taxcost}&cartid={cartid}&auid={{ customer.id }}&trafficsource={trafficsource}&keyword={{ discount.title }}" height="1" width="1" alt=""><!-- END CheckAIM CODE --></textarea>
					</div>

				  </div>
				  <div class="tab-pane fade" id="nav-woocommerce" role="tabpanel" aria-labelledby="nav-woocommerce-tab">
				  	
				  	<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><?//=$lang_shoppingCartIntegration?></a>-->
					<h4 class="card-title"><?=$lgetcode_TrackingCodeforLead?></h4>			
					<div class="form-group">
						<textarea rows="10" name="headertxt" class="form-control"><!--START CheckAIM CODE-->add_action('woocommerce_thankyou', 'checkaim_conversion_tracking');
function checkaim_conversion_tracking($order_id)
{
    $order = wc_get_order($order_id);
    $sub_total = $order->get_subtotal(); // Total before shipping cost and discount
    $discount_total = $order->get_discount_total(); 
    $total = $sub_total - $discount_total;
    $order_num = str_replace('#', '', $order->get_order_number());
    // Get coupons code if any
    $coupons_code = "";
    $count = 0;
    foreach ($order->get_used_coupons() as $coupon) {  // since WC 3.7
        $count++;
        if ($count > 1) {
            $coupons_code .= ';';
        }
        $coupons_code .= $coupon;
    }
    echo "<iframe src="https://checkaim.com/secure.php?mid=<?php echo $mid; ?>&orderId=$order_num&sale=$total&productids={productids}&postage={postage}&taxcosts={taxcost}&cartid={cartid}&auid={auid}&trafficsource={trafficsource}&keyword=$coupons_code" frameborder="0" width="1" height="1"></iframe>";
}<!-- END CheckAIM CODE --></textarea>
					</div>

				  </div>
				  <div class="tab-pane fade" id="nav-digitalriver" role="tabpanel" aria-labelledby="nav-digitalriver-tab">
				  	
				  	<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><?//=$lang_shoppingCartIntegration?></a>-->
					<h4 class="card-title"><?=$lgetcode_TrackingCodeforLead?></h4>			
					<div class="form-group">
						<textarea rows="10" name="headertxt" class="form-control"><!--START CheckAIM CODE--><img src="https://checkaim.com/secure.php?mid=<?php echo $mid; ?>&orderId=<%PURCHASE_ID%>&sale=<%TOTAL_PRICE_GROSS%>&auid=<%PURCHASE_ID%>" height="1" width="1" alt=""><!-- END CheckAIM CODE --></textarea>
					</div>

				  </div>
				</div>


				
				
			</div>
		</div>
	</div>
</div>
 	