var Dashboard = window.Dashboard || {}

Dashboard.TransactionChart = null;
Dashboard.TransactionChartData = null;
Dashboard.RequestCountr = 0;


Dashboard.Common = function () {
    return {

        Init: function () {

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

				Dashboard.Action.GetTransactions();
				Dashboard.Action.GetLocationData();
				Dashboard.Action.GetEarningsData();


			}); // end am4core.ready()

        	
        		

        },
        InitTransactionChart: function(data){
        	
        	if(data != null && data.length > 0)
        	{
	        	
        		var chart = am4core.create("divClientSalesChart", am4charts.PieChart);

				// Add data
				chart.data = data;

				chart.radius = am4core.percent(70);
				chart.innerRadius = am4core.percent(40);	

				// Add and configure Series
				var pieSeries = chart.series.push(new am4charts.PieSeries());
				pieSeries.dataFields.value = "amount";
				pieSeries.dataFields.category = "client";
				pieSeries.slices.template.stroke = am4core.color("#fff");
				pieSeries.slices.template.strokeOpacity = 1;

				// This creates initial animation
				pieSeries.hiddenState.properties.opacity = 1;
				pieSeries.hiddenState.properties.endAngle = -90;
				pieSeries.hiddenState.properties.startAngle = -90;

				pieSeries.labels.template.fontSize = 10;
				pieSeries.labels.template.wrap = true;
				pieSeries.labels.template.maxWidth = 100;

				pieSeries.colors.step = 2;
				pieSeries.labels.template.radius = 3;
				pieSeries.labels.template.padding(0,0,0,0);



				var barchart = am4core.create("divClientTransactionsChart", am4charts.XYChart);
				barchart.padding(40, 40, 40, 40);
				
				var categoryAxis = barchart.yAxes.push(new am4charts.CategoryAxis());
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.dataFields.category = "client";
				categoryAxis.renderer.minGridDistance = 1;
				categoryAxis.renderer.inversed = true;
				categoryAxis.renderer.grid.template.disabled = true;

				var label = categoryAxis.renderer.labels.template;
                label.wrap = true;
				label.fontSize = 10;
                label.maxWidth = 100;
                

				var valueAxis = barchart.xAxes.push(new am4charts.ValueAxis());
				valueAxis.min = 0;

				var series = barchart.series.push(new am4charts.ColumnSeries());
				series.dataFields.categoryY = "client";
				series.dataFields.valueX = "transactions";
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
				  return barchart.colors.getIndex(target.dataItem.index);
				});

				categoryAxis.sortBySeries = series;
				barchart.data = data
				
			}
			else
			{
				$("#divDailyChart").css("text-align","center");
				$("#divDailyChart").html("<img src='images/nodataavailable.png' />")
			}

        },
        InitLocationChart: function(data){
        	
        	if(data != null && data.length > 0)
        	{
	        	
				// Create map instance
				var chart = am4core.create("divSaleLocationChart", am4maps.MapChart);

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
			}
			else
			{
				$("#divLocationChart").css("text-align","center");
				$("#divLocationChart").html("<img src='images/nodataavailable.png' />")
			}

        },
        InitEarningsChart: function(data){

        	var chart = am4core.create("divEstimatedEarnings", am4charts.XYChart);

			// Add data
			chart.data = data;//generateChartData();

			// Create axes
			var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
			dateAxis.renderer.minGridDistance = 50;

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

			// Create series
			var series = chart.series.push(new am4charts.LineSeries());
			series.dataFields.valueY = "earningestimate";
			series.dataFields.dateX = "formatteddate";
			series.strokeWidth = 2;
			series.minBulletDistance = 10;
			series.tooltipText = "{valueY}";
			series.tooltip.pointerOrientation = "vertical";
			series.tooltip.background.cornerRadius = 20;
			series.tooltip.background.fillOpacity = 0.5;
			series.tooltip.label.padding(12,12,12,12)


			

        }
       
    }
}();


Dashboard.Action = function () {
    return {
        GetTransactions: function(success){
		
			if(typeof(success) == "undefined")
			{
			 	success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
								Dashboard.Common.InitTransactionChart(response.data);
									
							}	
							
	                   };
			}

			var postData = {'clientstats':"yes"};
			var headerData =  {
				
			};
			var url = "controller/statistics.php";

			Dashboard.Ajax.Request('POST', postData, url, success);
		
		},
		GetLocationData: function(success){
		
			if(typeof(success) == "undefined")
			{
			 	success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
								Dashboard.Common.InitLocationChart(response.data);
									
							}	
							
	                   };
			}

			var postData = {'locationstats':"yes"};
			var headerData =  {
				
			};
			var url = "controller/statistics.php";

			Dashboard.Ajax.Request('POST', postData, url, success);
		
		},
		GetEarningsData: function(success){
		
			if(typeof(success) == "undefined")
			{
			 	success = function (response, status) {
	                        
							console.log(response);
							
							if(response != null)
							{
								
								Dashboard.Common.InitEarningsChart(response.data);
									
							}	
							
	                   };
			}

			var postData = {'earningstats':"yes"};
			var headerData =  {
				
			};
			var url = "controller/statistics.php";

			Dashboard.Ajax.Request('POST', postData, url, success);
		
		}

    }
}();



Dashboard.Ajax = function () {
    return {
        Request: function (requestType, postData, actionUrl, successCallback, errorCallback, completeCallback) {

        	if (Dashboard.RequestCountr == 0) {
                $('#divPageLoader').show();
            }

            Dashboard.RequestCountr++;

            if (errorCallback == undefined) {
                errorCallback = function (jqXHR, textStatus, errorThrown) {
                    console.log('ERROR: ' + jqXHR.status);
                };
            }
            if (completeCallback == undefined) {
                completeCallback = function (jqXHR, textStatus) {

                    Dashboard.RequestCountr--;

                    if (Dashboard.RequestCountr <= 0) {
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