<?php
$orderid = rand(1, 100000);
$ordersale = rand(1, 150);
$ordersale = number_format($ordersale,2);
$productid = rand(1, 100000);
$postage = $ordersale / 10;
$postage = number_format($postage,2);
$taxcost = $ordersale / 100 *20;
$taxcost = number_format($taxcost,2);

$cartid = rand(1, 100000);
$auid = rand(1, 100000);
$traffic = rand(1, 100000);
$keyword = rand(1, 100000);


$url = "https://mybrandsecure.com/thankyou.php?mid=30&orderId=".$orderid."&sale=".$ordersale."&productids=".$productid."&postage=".$postage;
$url.= "&taxcosts=".$taxcost."&cartid=".$cartid."&auid=".$auid."&trafficsource=".$traffic."&keyword=".$keyword;

?>
<html>
<head>
<meta charset="utf-8">
<title>MyBrandSecure - Test Page for transactions</title>
</head>

<body>
	<!--START My Brand Secure CODE -->
<img src="<?php echo $url; ?>"  alt=""> 

</body>
</html>