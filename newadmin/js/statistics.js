var Statistics = window.Statistics || {}

Statistics.TransactionChart = null;
Statistics.TransactionChartData = null;
Statistics.RequestCountr = 0;


Statistics.Common = function () {
    return {

        Init: function () {

        	

        	am4core.ready(function() {

				// Themes begin
				am4core.useTheme(am4themes_myTheme);
				// Themes end

				Statistics.Action.GetTransactions();
				


			}); // end am4core.ready()

        	
        		

        },
        InitTransactionChart: function(data){
        	
        	if(data != null && data.length > 0)
        	{
	        	
        		var chart = am4core.create("divTransactionsChart", am4charts.XYChart);

				chart.colors.step = 2;
				chart.maskBullets = false;

				// Add data
				chart.data = data;

				// Create axes
				var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
				dateAxis.renderer.grid.template.location = 0;
				dateAxis.renderer.minGridDistance = 50;
				dateAxis.renderer.grid.template.disabled = true;
				dateAxis.renderer.fullWidthTooltip = true;

				var reportAxis = chart.yAxes.push(new am4charts.ValueAxis());
				//reportAxis.title.text = "Reports";
				reportAxis.renderer.opposite = true
				reportAxis.renderer.grid.template.disabled = true;
				reportAxis.renderer.labels.template.disabled = true;

				var alertsAxis = chart.yAxes.push(new am4charts.ValueAxis());
				//alertsAxis.title.text = "Alerts";
				alertsAxis.renderer.opposite = true
				alertsAxis.renderer.grid.template.disabled = true;
				alertsAxis.renderer.labels.template.disabled = true;
				alertsAxis.syncWithAxis = reportAxis;

				
				var transactionsAxis = chart.yAxes.push(new am4charts.ValueAxis());
				//transactionsAxis.title.text = "Transactions";
				transactionsAxis.renderer.opposite = true
				transactionsAxis.renderer.grid.template.disabled = true;
				transactionsAxis.renderer.labels.template.disabled = true;
				transactionsAxis.syncWithAxis = reportAxis;


				

				


				var salesAxis = chart.yAxes.push(new am4charts.ValueAxis());
				salesAxis.title.text = "Sales";

				// Create series
				var saleSeries = chart.series.push(new am4charts.ColumnSeries());
				saleSeries.dataFields.valueY = "sales";
				saleSeries.dataFields.dateX = "date";
				saleSeries.yAxis = salesAxis;
				saleSeries.tooltipText = "Sales: ${valueY}";
				saleSeries.name = "Sales";
				saleSeries.columns.template.fillOpacity = 0.7;
				saleSeries.columns.template.propertyFields.strokeDasharray = "dashLength";
				saleSeries.columns.template.propertyFields.fillOpacity = "alpha";
				saleSeries.showOnInit = true;

				var salesState = saleSeries.columns.template.states.create("hover");
				saleSeries.properties.fillOpacity = 0.9;

				var transactionSeries = chart.series.push(new am4charts.LineSeries());
				transactionSeries.dataFields.valueY = "transactions";
				transactionSeries.dataFields.dateX = "date";
				transactionSeries.yAxis = transactionsAxis;
				transactionSeries.name = "Transactions";
				transactionSeries.strokeWidth = 2;
				transactionSeries.propertyFields.strokeDasharray = "dashLength";
				transactionSeries.tooltipText = "Transactions: {valueY}";
				transactionSeries.showOnInit = true;

				var transactionBullet = transactionSeries.bullets.push(new am4charts.Bullet());
				var transactionRectangle = transactionBullet.createChild(am4core.Rectangle);
				transactionBullet.horizontalCenter = "middle";
				transactionBullet.verticalCenter = "middle";
				transactionBullet.width = 7;
				transactionBullet.height = 7;
				transactionRectangle.width = 7;
				transactionRectangle.height = 7;

				var transactionState = transactionBullet.states.create("hover");
				transactionState.properties.scale = 1.2;

				var alertsSeries = chart.series.push(new am4charts.LineSeries());
				alertsSeries.dataFields.valueY = "alerts";
				alertsSeries.dataFields.dateX = "date";
				alertsSeries.yAxis = alertsAxis;
				alertsSeries.name = "Alerts";
				alertsSeries.strokeWidth = 2;
				alertsSeries.propertyFields.strokeDasharray = "dashLength";
				alertsSeries.tooltipText = "Alerts: {valueY}";
				alertsSeries.showOnInit = true;

				var alertsBullet = alertsSeries.bullets.push(new am4charts.CircleBullet());
				alertsBullet.circle.fill = am4core.color("#fff");
				alertsBullet.circle.strokeWidth = 2;
				alertsBullet.circle.propertyFields.radius = "alerts";

				var alertsState = alertsBullet.states.create("hover");
				alertsState.properties.scale = 1.2;


				var reportsSeries = chart.series.push(new am4charts.LineSeries());
				reportsSeries.dataFields.valueY = "reports";
				reportsSeries.dataFields.dateX = "date";
				reportsSeries.yAxis = alertsAxis;
				reportsSeries.name = "Reports";
				reportsSeries.strokeWidth = 2;
				reportsSeries.propertyFields.strokeDasharray = "dashLength";
				reportsSeries.tooltipText = "Reports: {valueY}";
				reportsSeries.showOnInit = true;

				var reportsBullet = reportsSeries.bullets.push(new am4charts.CircleBullet());
				reportsBullet.circle.fill = am4core.color("#fff");
				reportsBullet.circle.strokeWidth = 2;
				reportsBullet.circle.propertyFields.radius = "reports";

				var reportsState = reportsBullet.states.create("hover");
				reportsState.properties.scale = 1.2;


				// Add legend
				chart.legend = new am4charts.Legend();

				// Add cursor
				chart.cursor = new am4charts.XYCursor();
				chart.cursor.fullWidthLineX = true;
				chart.cursor.xAxis = dateAxis;
				chart.cursor.lineX.strokeOpacity = 0;
				chart.cursor.lineX.fill = am4core.color("#000");
				chart.cursor.lineX.fillOpacity = 0.1;
				
			}
			else
			{
				$("#divDailyChart").css("text-align","center");
				$("#divDailyChart").html("<img src='images/nodataavailable.png' />")
			}

        }
       
    }
}();


Statistics.Action = function () {
    return {
        GetTransactions: function(success){
		
			if(typeof(success) == "undefined")
			{
			 	success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
								//Statistics.Common.InitTransactionChart(response.data);
									
							}	
							
	                   };
			}

			var postData = {'transactionstats':"yes"};
			var headerData =  {
				
			};
			var url = "controller/statistics.php";

			Statistics.Ajax.Request('POST', postData, url, success);
		
		}

    }
}();



Statistics.Ajax = function () {
    return {
        Request: function (requestType, postData, actionUrl, successCallback, errorCallback, completeCallback) {

        	if (Statistics.RequestCountr == 0) {
                $('#divPageLoader').show();
            }

            Statistics.RequestCountr++;

            if (errorCallback == undefined) {
                errorCallback = function (jqXHR, textStatus, errorThrown) {
                    console.log('ERROR: ' + jqXHR.status);
                };
            }
            if (completeCallback == undefined) {
                completeCallback = function (jqXHR, textStatus) {

                    Statistics.RequestCountr--;

                    if (Statistics.RequestCountr <= 0) {
                        $('#divPageLoader').hide();
                    }
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