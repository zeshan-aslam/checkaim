<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>CheckAIM Load Tester</title>
  </head>
  <body>
  	<div class="container">
	  <div class="row">
	    <div class="col-sm">
	      <h1>CheckAIM Load Tester</h1>
		    <form>

				  <div class="form-group">
				    <label for="">No of Request</label>
				    <select class="form-control" id="drpNoOfTest" >
				      <option>10</option>
				      <option>20</option>
				      <option>30</option>
				      <option>40</option>
				      <option>50</option>
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
    <script type="text/javascript" src="js/moment.min.js"></script>

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


					var url = "https://checkaim.com/secure.php?mid=36&orderId="+orderid+"&sale="+ordersale+"&productids="+productid+"&postage="+postage;
					url+= "&taxcosts="+taxcost+"&cartid="+cartid+"&auid="+auid+"&trafficsource="+traffic+"&keyword="+keyword;

					var now = moment().format("dddd, MMMM Do YYYY, h:mm:ss SSSSSSS");
					var html ="<p><strong>"+ testName +"</strong> - <img src='"+url+"' onload='showLoaded(this,\""+now+"\")' /> - "+now+" </p>";

							$("#divResponse").append("<p>"+html+"</p>");


					var successCallback = function(response, status){

						console.log(testName);
						console.log(response);
						if(response != null)
						{
							var html ="<strong>"+ testName +"</strong> - AUID: <strong>"+ response.auid+"</strong> - Start Time:<strong>"+response.starttime+"</strong> - End Time:<strong>"+response.endtime+"</strong>";

							$("#divResponse").append("<p>"+html+"</p>");
						}

						

					};

					//DoRequest(url, testName);

    	}

    	function showLoaded(img, now){

    		var nowObj = moment(now);
    		var endNow = moment();
    	
    		$(img).parent().append("Loaded - || "+endNow.format(" h:mm:ss SSSSSSS"));

    	}

    	function DoRequest(url, testName){

    		var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
			    if (this.readyState == 4 && this.status == 200){
			        //this.response is what you're looking for
			        
			        console.log(this.response, typeof this.response);
			        var img = document.createElement("IMG");
			        var url = window.URL || window.webkitURL;
			        img.src = url.createObjectURL(this.response);
			        $("#divResponse").append("<p>"+testName+"</p>");
			        $("#divResponse").append(img);
			    }
			}
			xhr.open('GET', url);
			xhr.responseType = 'blob';
			xhr.send();

    	}

    	/*
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
                contentType: "image/png",
                dataType: "image/png",
                success: eval(successCallback),
                error: eval(errorCallback),
                complete: eval(completeCallback)
            });
        }
        */




    </script>

  </body>
</html>