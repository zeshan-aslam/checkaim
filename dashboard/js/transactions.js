var Transactions = window.Transactions || {};
Transactions.PageNo = 1;

Transactions.OSChart = null;
Transactions.BrowserChart = null;

Transactions.Common = function () {
    return {
        Init: function () {

        	$("#btnSearchTransaction").bind("click", function(){

        		Transactions.Action.Search();

        	});
	
			Transactions.Action.Search();
		
			$("#divPagination").on("click", ".pageno", function(){

				Transactions.PageNo = $(this).data("pageno");
				Transactions.Action.Search();

			});

			$("#divPagination").on("click", ".next", function(){

				Transactions.PageNo = Transactions.PageNo + 1;
				Transactions.Action.Search();

			});

			$("#divPagination").on("click", ".previous", function(){

				Transactions.PageNo = Transactions.PageNo - 1;
				Transactions.Action.Search();

			});
        },
        InitOSChart: function (data) {

            
            if (Transactions.OSChart == null) {

                var chart = am4core.create("divOSChartContainer", am4charts.PieChart);

                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart.data = data

                chart.innerRadius = am4core.percent(40);
                //chart.depth = 120;

                
                var series = chart.series.push(new am4charts.PieSeries3D());
                series.dataFields.value = "value";
                //series.dataFields.depthValue = "value";
                series.dataFields.category = "key";
                series.slices.template.cornerRadius = 5;
                series.colors.step = 3;
                series.fontSize = 9;
                //series.ticks.template.disabled = true;
                series.labels.template.radius = -15;
                series.labels.template.wrap = true;
                series.labels.template.maxWidth = 100;

              
                Transactions.OSChart = chart;  
            }
            else {
                Transactions.OSChart.data = data;
            }



        },
        InitBrowserChart: function (data) {

            if (Transactions.BrowserChart == null) {

                var chart = am4core.create("divBrowserChartContainer", am4charts.PieChart);
                chart.hiddenState.properties.opacity = 0; 

                chart.data = data;

                var series = chart.series.push(new am4charts.PieSeries());
                series.dataFields.value = "value";
                series.dataFields.radiusValue = "value";
                series.dataFields.category = "key";
                series.slices.template.cornerRadius = 6;
                series.colors.step = 3;
                //series.ticks.template.disabled = true;
                series.hiddenState.properties.endAngle = -90;
                series.fontSize = 9;

                series.labels.template.radius = -15;

                series.labels.template.wrap = true;
                series.labels.template.maxWidth = 100;

                Transactions.BrowserChart = chart;
            }
            else {
                Transactions.BrowserChart.data = data;
            }
            
        }
    }
}();

Transactions.Action = function () {
    return {

        Search: function(success)
        {
		
				if(typeof(success) == "undefined")
				{
				 success = function (response, status) {
		                        
								console.log(response);
								
								if(response != null)
								{
									
										var html = "";
										var source = $("#transactions-template").html();
										var template = Handlebars.compile(source);
										html = template(response.data);	
										
										$("#divTransactions").html(html);

										source = $("#pager-template").html();
										template = Handlebars.compile(source);
										html = template(response);	
										$("#divPagination").html(html);

										var pager = response.pager;

										if(Transactions.PageNo == 1)
										{
											$("#divPagination .previous").hide();
										}
										else
										{
											$("#divPagination .previous").show();
										}

										if(pager.totalpages == Transactions.PageNo)
										{
											$("#divPagination .next").hide();
										}
										else
										{
											$("#divPagination .next").show();
										}
									
										Transactions.Common.InitOSChart(response.osdata);
										Transactions.Common.InitBrowserChart(response.browserdata);
										
								}	
								
		                   };
				}

			var orderId = $("#txtOrderId").val();

			var postData = {'transactions_list':"yes", orderid: orderId, pageno: Transactions.PageNo};
			var headerData =  {};
			var url = "/controller/transactions.php";

			Transactions.Ajax.Request('POST', postData, url, success);
		
		}
    }
}();



Transactions.Ajax = function () {
    return {
        Request: function (requestType, postData, actionUrl, successCallback, errorCallback, completeCallback) {
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
    };
}();