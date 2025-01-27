var Statistics = window.Statistics || {}

Statistics.TransactionChart = null;
Statistics.TransactionChartData = null;
Statistics.RequestCountr = 0;


Statistics.Common = function () {
    return {

        Init: function () {

        	$('.datepicker').datetimepicker({
				 format: 'YYYY-MM-DD',
				 icons: {
			                date: "fa fa-calendar",
			                up: "fa fa-chevron-up",
			                down: "fa fa-chevron-down",
			                previous: 'fa fa-chevron-left',
			                next: 'fa fa-chevron-right',
			                today: 'fa fa-screenshot',
			                clear: 'fa fa-trash',
			                close: 'fa fa-remove'
			            }
			 }); 
			 

        	function am4themes_myTheme(target) {
			  if (target instanceof am4core.ColorSet) {
			    target.list = [
			      am4core.color("#2278BF"),
			      am4core.color("#EAC435"),
			      am4core.color("#C1292E"),
			      
			    ];
			  }
			}

        	am4core.ready(function() {

				// Themes begin
				am4core.useTheme(am4themes_myTheme);
				// Themes end

				Statistics.Action.GetTransactions();
				Statistics.Action.GetOSAnalysisData();
				Statistics.Action.GetBrowserAnalysisData();
				Statistics.Action.GetLocationData();


			}); // end am4core.ready()

        	
			$("#frmFilters").validate({
			  submitHandler: function(form) {

			  	//$('#divPageLoader').show();
			    
			    var from = $("#txtFilterFrom").val();
			    var to = $("#txtFilterTo").val();
			  	
			    
			  	Statistics.Action.GetTransactions(from, to);
				Statistics.Action.GetOSAnalysisData(from, to);
				Statistics.Action.GetBrowserAnalysisData(from, to);
				Statistics.Action.GetLocationData(from, to);
				
			  }
			 });

        	$("#frmBrowserAnalysis").validate({
			  submitHandler: function(form) {

			  	$('#divPageLoader').show();
			    
			  	var options = {
                            url: "/controller/statistics.php",
                            type: 'POST',
                            dataType: 'json',
                            success: function (response, status) {

                            	$('#divPageLoader').hide();

                                if (response != null) {

                                		Statistics.Common.InitBrowserAnalysisChart(response.data);

                                }
                            }
                        };

                $("#frmBrowserAnalysis").ajaxSubmit(options);

			  }
			 });

        	$("#frmOSAnalysis").validate({
			  submitHandler: function(form) {

			  	$('#divPageLoader').show();
			    
			  	var options = {
                            url: "/controller/statistics.php",
                            type: 'POST',
                            dataType: 'json',
                            success: function (response, status) {

                            	$('#divPageLoader').hide();

                                if (response != null) {

                                		Statistics.Common.InitOSAnalysisChart(response.data, response.data2);

                                }
                            }
                        };

                $("#frmOSAnalysis").ajaxSubmit(options);

			  }
			 });

        	$("#frmTransactions").validate({
			  submitHandler: function(form) {

			  	$('#divPageLoader').show();
			    
			  	var options = {
                            url: "/controller/statistics.php",
                            type: 'POST',
                            dataType: 'json',
                            success: function (response, status) {

                            	$('#divPageLoader').hide();

                                if (response != null) {

                                		Statistics.Common.InitTransactionChart(response.data);

                                }
                            }
                        };

                $("#frmTransactions").ajaxSubmit(options);

			  }
			 });

        	$("#frmLocations").validate({
			  submitHandler: function(form) {

			  	$('#divPageLoader').show();
			    
			  	var options = {
                            url: "/controller/statistics.php",
                            type: 'POST',
                            dataType: 'json',
                            success: function (response, status) {

                            	$('#divPageLoader').hide();

                                if (response != null) {

                                		Statistics.Common.InitLocationChart(response.data);

                                }
                            }
                        };

                $("#frmLocations").ajaxSubmit(options);

			  }
			 });
        		

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


				Statistics.Common.InitChartExportSettings(chart);
				
			}
			else
			{
				$("#divDailyChart").css("text-align","center");
				$("#divDailyChart").html("<img src='images/nodataavailable.png' />")
			}

        },
        InitOSAnalysisChart: function(data, data2){
        	
        	if(data != null && data.length > 0)
        	{
	        	
        		var chart = am4core.create("divOsAnalysisChart", am4charts.PieChart);
				chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

				chart.data = data;
				chart.radius = am4core.percent(70);
				chart.innerRadius = am4core.percent(40);
				chart.startAngle = 180;
				chart.endAngle = 360;  

				var series = chart.series.push(new am4charts.PieSeries());
				series.dataFields.value = "value";
				series.dataFields.category = "key";

				series.slices.template.cornerRadius = 10;
				series.slices.template.innerCornerRadius = 7;
				series.slices.template.draggable = true;
				series.slices.template.inert = true;
				series.alignLabels = false;

				series.hiddenState.properties.startAngle = 90;
				series.hiddenState.properties.endAngle = 90;

				var chart2 = am4core.create("divDeviceTypeAnalysisChart", am4charts.PieChart);
				chart2.data = data2;
				var pieSeries = chart2.series.push(new am4charts.PieSeries());
				pieSeries.dataFields.value = "value";
				pieSeries.dataFields.category = "key";

				// Let's cut a hole in our Pie chart the size of 30% the radius
				chart2.innerRadius = am4core.percent(30);

				// Put a thick white border around each Slice
				pieSeries.slices.template.stroke = am4core.color("#fff");
				pieSeries.slices.template.strokeWidth = 2;
				pieSeries.slices.template.strokeOpacity = 1;
				pieSeries.slices.template
				  // change the cursor on hover to make it apparent the object can be interacted with
				  .cursorOverStyle = [
				    {
				      "property": "cursor",
				      "value": "pointer"
				    }
				  ];

				pieSeries.alignLabels = false;
				pieSeries.labels.template.bent = true;
				pieSeries.labels.template.radius = 3;
				pieSeries.labels.template.padding(0,0,0,0);

				pieSeries.ticks.template.disabled = true;

				// Create a base filter effect (as if it's not there) for the hover to return to
				var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
				shadow.opacity = 0;

				// Create hover state
				var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

				// Slightly shift the shadow and make it more prominent on hover
				var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
				hoverShadow.opacity = 0.7;
				hoverShadow.blur = 5;

				//chart.legend = new am4charts.Legend();
				Statistics.Common.InitChartExportSettings(chart);
				Statistics.Common.InitChartExportSettings(chart2);
			}
			else
			{
				$("#divOsAnalysisChart").css("text-align","center");
				$("#divOsAnalysisChart").html("<img src='images/nodataavailable.png' />")
			}

        },
        InitBrowserAnalysisChart: function(data){
        	
        	if(data != null && data.length > 0)
        	{
	        	
				var chart = am4core.create("divBrowserAnalysisChart", am4charts.XYChart);
				chart.padding(40, 40, 40, 40);

				var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.dataFields.category = "key";
				categoryAxis.renderer.minGridDistance = 1;
				categoryAxis.renderer.inversed = true;
				categoryAxis.renderer.grid.template.disabled = true;

				var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
				valueAxis.min = 0;

				var series = chart.series.push(new am4charts.ColumnSeries());
				series.dataFields.categoryY = "key";
				series.dataFields.valueX = "value";
				series.tooltipText = "{valueX.value}"
				series.columns.template.strokeOpacity = 0;
				series.columns.template.column.cornerRadiusBottomRight = 5;
				series.columns.template.column.cornerRadiusTopRight = 5;

				var labelBullet = series.bullets.push(new am4charts.LabelBullet())
				labelBullet.label.horizontalCenter = "left";
				labelBullet.label.dx = 10;
				labelBullet.label.text = "{values.valueX}";
				labelBullet.locationX = 1;

				// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
				series.columns.template.adapter.add("fill", function(fill, target){
				  return chart.colors.getIndex(target.dataItem.index);
				});

				categoryAxis.sortBySeries = series;
				chart.data = data;
				Statistics.Common.InitChartExportSettings(chart);
			}
			else
			{
				$("#divOsAnalysisChart").css("text-align","center");
				$("#divOsAnalysisChart").html("<img src='images/nodataavailable.png' />")
			}

        },
        InitLocationChart: function(data){
        	
        	if(data != null && data.length > 0)
        	{
	        	
				// Create map instance
				var chart = am4core.create("divLocationChart", am4maps.MapChart);

				// Set map definition
				chart.geodata = am4geodata_worldLow;

				// Set projection
				chart.projection = new am4maps.projections.Miller();

				// Create map polygon series
				var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

				// Exclude Antartica
				polygonSeries.exclude = ["AQ"];

				// Make map load polygon (like country names) data from GeoJSON
				polygonSeries.useGeodata = true;

				// Configure series
				var polygonTemplate = polygonSeries.mapPolygons.template;
				polygonTemplate.tooltipText = "{name}";
				polygonTemplate.polygon.fillOpacity = 0.6;


				// Create hover state and set alternative fill color
				var hs = polygonTemplate.states.create("hover");
				hs.properties.fill = chart.colors.getIndex(0);

				// Add image series
				var imageSeries = chart.series.push(new am4maps.MapImageSeries());
				imageSeries.mapImages.template.propertyFields.longitude = "longitude";
				imageSeries.mapImages.template.propertyFields.latitude = "latitude";
				imageSeries.mapImages.template.tooltipText = "{city}, {region}, {country}";
				imageSeries.mapImages.template.propertyFields.url = "url";

				var circle = imageSeries.mapImages.template.createChild(am4core.Circle);
				circle.radius = 2;
				circle.propertyFields.fill = "color";

				var circle2 = imageSeries.mapImages.template.createChild(am4core.Circle);
				circle2.radius = 2;
				circle2.propertyFields.fill = "color";


				circle2.events.on("inited", function(event){
				  animateBullet(event.target);
				})


				function animateBullet(circle) {
				    var animation = circle.animate([{ property: "scale", from: 1, to: 3 }, { property: "opacity", from: 1, to: 0 }], 1000, am4core.ease.circleOut);
				    animation.events.on("animationended", function(event){
				      animateBullet(event.target.object);
				    })
				}

				var colorSet = new am4core.ColorSet();

				imageSeries.data = data;

				Statistics.Common.InitChartExportSettings(chart);
				
			}
			else
			{
				$("#divLocationChart").css("text-align","center");
				$("#divLocationChart").html("<img src='images/nodataavailable.png' />")
			}

        },
        InitChartExportSettings: function (chart) {

            if (chart != null) {
                chart.exporting.menu = new am4core.ExportMenu();
                chart.exporting.useWebFonts = false;
                chart.exporting.menu.items = [{
                    "label": "...",
                    "menu": [
                        //{ "type": "png", "label": "PNG" },
                        { "type": "jpg", "label": "Export", "options": { "indent": 2, "useTimestamps": true } },
                        //{ "label": "Print", "type": "print" }
                    ]
                }];
            }

        },

       
    }
}();


Statistics.Action = function () {
    return {
        GetTransactions: function(from,to, success){
		
			if(typeof(success) == "undefined")
			{
			 	success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
								Statistics.Common.InitTransactionChart(response.data);
									
							}	
							
	                   };
			}

			var postData = {'transactionstats':"yes"};

			if(typeof(from) != "undefined" && typeof(to) != "undefined")
			{
				postData["from"] = from;
				postData["to"] = to;
			}

			var headerData =  {
				
			};
			var url = "/controller/statistics.php";

			Statistics.Ajax.Request('POST', postData, url, success);
		
		},
		GetOSAnalysisData: function(from, to, success){
		
			if(typeof(success) == "undefined")
			{
			 	success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
								Statistics.Common.InitOSAnalysisChart(response.data, response.data2);
									
							}	
							
	                   };
			}

			var postData = {'osstats':"yes"};
			if(typeof(from) != "undefined" && typeof(to) != "undefined")
			{
				postData["from"] = from;
				postData["to"] = to;
			}

			var headerData =  {
				
			};
			var url = "/controller/statistics.php";

			Statistics.Ajax.Request('POST', postData, url, success);
		
		},
		GetBrowserAnalysisData: function(from, to, success){
		
			if(typeof(success) == "undefined")
			{
			 	success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
								Statistics.Common.InitBrowserAnalysisChart(response.data);
									
							}	
							
	                   };
			}


			var postData = {'browserstats':"yes"};

			if(typeof(from) != "undefined" && typeof(to) != "undefined")
			{
				postData["from"] = from;
				postData["to"] = to;
			}

			var headerData =  {
				
			};
			var url = "/controller/statistics.php";

			Statistics.Ajax.Request('POST', postData, url, success);
		
		},
		GetLocationData: function(from,to, success){
		
			if(typeof(success) == "undefined")
			{
			 	success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
								Statistics.Common.InitLocationChart(response.data);
									
							}	
							
	                   };
			}

			var postData = {'locationstats':"yes"};
			if(typeof(from) != "undefined" && typeof(to) != "undefined")
			{
				postData["from"] = from;
				postData["to"] = to;
			}


			var headerData =  {
				
			};
			var url = "/controller/statistics.php";

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