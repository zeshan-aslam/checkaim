<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>My Brand Secure Load Tester</title>
  </head>
  <body>
  	<div class="container">
	  <div class="row">
	    <div class="col-sm">
	      <h1>My Brand Secure Load Tester</h1>
		    <form>

				  <div class="form-group">
				    <label for="">No of Request</label>
				    <select class="form-control" id="drpNoOfTest" >
				    	 <option>1</option>
				      <option>10</option>
				      <option>20</option>
				      <option>30</option>
				      <option>40</option>
				      <option>50</option>
					  <option>70</option>
					  <option>80</option>
						<option>90</option>
				    </select>
				  </div>
		 
		   	<button id="btnStartTest" type="button" class="btn btn-primary mb-2">Start Test</button>
		</form>
	    </div>
	    
	  </div>

	  <div class="row">
	    <div class="col-sm" id="divResponse">
		</div>
	</div>  
	</div>
    


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script type="text/javascript">
    	

    	$(document).ready(function(){

    		

			$("#btnStartTest").bind("click", function(){

				$("#divResponse").html("");
				var noOdTest = parseInt($("#drpNoOfTest").val());

				for(var i=1; i<=noOdTest;i++)
				{

					var testName = "Test "+i;
					 DoTest(testName);

				}

			})

			


    	});

    	function DoTest(testName)
    	{

    		var orderid = Math.floor((Math.random() * 100000) + 1);
					var ordersale = Math.floor((Math.random() *  150) + 1);
					var productid = Math.floor((Math.random() *   100000) + 1);
					var postage = ordersale / 10;
					postage = postage.toFixed(2);
					var taxcost = ordersale / 100 *20;
					taxcost = taxcost.toFixed(2);

					var cartid = Math.floor((Math.random() * 100000) + 1);
					var auid = Math.floor((Math.random() * 100000) + 1);
					var traffic = Math.floor((Math.random() * 100000) + 1);
					var keyword = Math.floor((Math.random() * 100000) + 1);


					var url = "https://mybrandsecure.com/secure.php?mid=30&orderId="+orderid+"&sale="+ordersale+"&productids="+productid+"&postage="+postage;
					url+= "&taxcosts="+taxcost+"&cartid="+cartid+"&auid="+auid+"&trafficsource="+traffic+"&keyword="+keyword;

					var successCallback = function(response, status){

						console.log(testName);
						console.log(response);
						if(response != null)
						{
							var html ="<strong>"+ testName +"</strong> - AUID: <strong>"+ response.auid+"</strong> - Start Time:<strong>"+response.starttime+"</strong> - End Time:<strong>"+response.endtime+"</strong>";

							$("#divResponse").append("<p>"+html+"</p>");
						}

						

					};

					DoRequest("GET", {}, url, successCallback);

    	}


    	 function DoRequest(requestType, postData, actionUrl, successCallback, errorCallback, completeCallback) {
            if (errorCallback == undefined) {
                errorCallback = function (jqXHR, textStatus, errorThrown) {
                    console.log('ERROR: ' + jqXHR.status);
                };
            }
            if (completeCallback == undefined) {
                completeCallback = function (jqXHR, textStatus) {
                }
            }
            $.ajax({
                type: requestType,
                data: postData,
                url: actionUrl,
                contentType: "application/x-www-form-urlencoded",
                dataType: "json",
                success: eval(successCallback),
                error: eval(errorCallback),
                complete: eval(completeCallback)
            });
        }




    </script>

  </body>
</html>